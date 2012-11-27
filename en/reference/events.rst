Events Manager
==============

The purpose of this component is to intercept the execution of most of the components of the framework by creating “hooks point”. These hook
points allow the developer to obtain status information, manipulate data or change the flow of execution during the process of a component.

Usage Example
-------------
In the following example, we use the EventsManager to listen for events produced in a MySQL connection managed by :doc:`Phalcon\\Db <../api/Phalcon_Db>`.
First of all, we need a listener object to do this. We created a class whose methods are the events we want to listen:

.. code-block:: php

    <?php

    class MyDbListener
    {

        public function afterConnect()
        {

        }

        public function beforeQuery()
        {

        }

        public function afterQuery()
        {

        }

    }

This new class can be as verbose as we need it to. The EventsManager will interface between the component and our listener class,
offering hook points based on the methods we defined in our listener class:

.. code-block:: php

    <?php

    $eventsManager = new \Phalcon\Events\Manager();

    //Create a database listener
    $dbListener = new MyDbListener()

    //Listen all the database events
    $eventsManager->attach('db', $dbListener);

    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => "localhost",
        "username" => "root",
        "password" => "secret",
        "dbname" => "invo"
    ));

    //Assign the eventsManager to the db adapter instance
    $connection->setEventsManager($eventsManager);

    //Send a SQL command to the database server
    $connection->query("SELECT * FROM products p WHERE p.status = 1");

In order to log all the SQL statements executed by our application, we need to use the event “afterQuery”. The first parameter passed to
the event listener contains contextual information about the event that is running, the second is the connection itself.

.. code-block:: php

    <?php

    class MyDbListener
    {

        protected $_logger;

        public function __construct()
        {
            $this->_logger = new \Phalcon\Logger\Adapter\File("../apps/logs/db.log");
        }

        public function afterQuery($event, $connection)
        {
            $this->_logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
        }

    }

As part of this example, we will also implement the Phalcon\\Db\\Profiler to detect the SQL statements that are taking longer to execute than expected:

.. code-block:: php

    <?php

    class MyDbListener
    {

        protected $_profiler;

        protected $_logger;

        public function __construct()
        {
            $this->_profiler = new \Phalcon\Db\Profiler();
            $this->_logger = new \Phalcon\Logger\Adapter\File("../apps/logs/db.log");
        }

        public function beforeQuery($event, $connection)
        {
            $this->_profiler->startProfile($connection->getSQLStatement());
        }

        public function afterQuery($event, $connection)
        {
            $this->_logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
            $this->_profiler->stopProfile();
        }

        public function getProfiler()
        {
            return $this->_profiler;
        }

    }

The resulting profile data can be obtained from the listener:

.. code-block:: php

    <?php

    //Send a SQL command to the database server
    $connection->query("SELECT * FROM products p WHERE p.status = 1");

    foreach($dbListener->getProfiler()->getProfiles() as $profile){
        echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
        echo "Start Time: ", $profile->getInitialTime(), "\n"
        echo "Final Time: ", $profile->getFinalTime(), "\n";
        echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
    }

In a similar manner we can register an lambda function to perform the task instead of a separate listener class (as seen above):

.. code-block:: php

    <?php

    //Listen all the database events
    $eventManager->attach('db', function($event, $connection) {
        if ($event->getType() == 'afterQuery') {
            echo $connection->getSQLStatement();
        }
    });

Creating components that trigger Events
---------------------------------------
You can create components in your application that trigger events to a EventsManager. As a consequence, there may exist listeners
that react to these events when generated. In the following example we're creating a component called "MyComponent".
This component is EventsManager aware; when its method "someTask" is executed it triggers two events to any listener in the EventsManager:

.. code-block:: php

    <?php

    class MyComponent implements \Phalcon\Events\EventsAwareInterface
    {

        protected $_eventsManager;

        public function setEventsManager($eventsManager)
        {
            $this->_eventsManager = $eventsManager;
        }

        public function getEventsManager()
        {
            return $this->_eventsManager
        }

        public function someTask()
        {
            $this->_eventsManager->fire("my-component:beforeSomeTask", $this);

            // do some task

            $this->_eventsManager->fire("my-component:afterSomeTask", $this);
        }

    }

Note that events produced by this component are prefixed with "my-component". This is a unique word that helps us to
identify events that are generated from certain component. You can even generate events outside of the component with
the same name. Now let's create a listener to this component:

.. code-block:: php

    <?php

    class SomeListener
    {

        public function beforeSomeTask($event, $myComponent)
        {
            echo "Here, beforeSomeTask\n";
        }

        public function afterSomeTask($event, $myComponent)
        {
            echo "Here, afterSomeTask\n";
        }

    }

A listener is simply a class that implements any of all the events triggered by the component. Now let's make everything work together:

.. code-block:: php

    <?php

    //Create an Events Manager
    $eventsManager = new Phalcon\Events\Manager();

    //Create the MyComponent instance
    $myComponent = new MyComponent();

    //Bind the eventsManager to the instance
    $myComponent->setEventsManager($myComponent);

    //Attach the listener to the EventsManager
    $eventsManager->attach('my-component', new SomeListener());

    //Execute methods in the component
    $myComponent->someTask();

As "someTask" is executed, the two methods in the listener will be executed, producing the following output:

.. code-block:: php

    Here, beforeSomeTask
    Here, afterSomeTask

Additional data may also passed when triggering an event using the third parameter of "fire":

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData);

In a listener the third parameter also receives this data:

.. code-block:: php

    <?php

    //Receiving the data in the third parameter
    $eventManager->attach('my-component', function($event, $component, $data) {
        print_r($data);
    });

    //Receiving the data from the event context
    $eventManager->attach('my-component', function($event, $component) {
        print_r($event->getData());
    });

If a listener it is only interested in listening a specific type of event you can attach a listener directly:

.. code-block:: php

    <?php

    //The handler will only be executed if the event triggered is "beforeSomeTask"
    $eventManager->attach('my-component:beforeSomeTask', function($event, $component) {
        //...
    });

Event Propagation/Cancelation
-----------------------------
Many listeners may be added to the same event manager, this means that for the same type of event many listeners can be notified.
The listeners are notified in the order they were registered in the EventsManager. Some events are cancellable, indicating that
these may be stopped preventing other listeners are notified about the event:

.. code-block:: php

    <?php

    $eventsManager->attach('db', function($event, $connection){

        //We stop the event if it is cancelable
        if ($event->isCancelable()) {
            //Stop the event, so other listeners will not be notified about this
            $event->stop();
        }

        //...

    });

By default events are cancelable, even most of events produced by the framework are cancelables. You can fire a not-cancelable event
by passing "false" in the four parameter of fire:

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData, false);

Implementing your own EventsManager
-----------------------------------
The :doc:`Phalcon\\Events\\ManagerInterface <../api/Phalcon_Events_ManagerInterface>` interface must be implemented to create your own
EventsManager replacing the one provided by Phalcon.