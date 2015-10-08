Events Manager
==============

The purpose of this component is to intercept the execution of most of the other components of the framework by creating "hook points". These hook
points allow the developer to obtain status information, manipulate data or change the flow of execution during the process of a component.

Usage Example
-------------
In the following example, we use the EventsManager to listen for events produced in a MySQL connection managed by :doc:`Phalcon\\Db <../api/Phalcon_Db>`.
First, we need a listener object to do this. We created a class whose methods are the events we want to listen:

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

    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

    $eventsManager = new EventsManager();

    // Create a database listener
    $dbListener    = new MyDbListener();

    // Listen all the database events
    $eventsManager->attach('db', $dbListener);

    $connection    = new DbAdapter(
        array(
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo"
        )
    );

    // Assign the eventsManager to the db adapter instance
    $connection->setEventsManager($eventsManager);

    // Send a SQL command to the database server
    $connection->query("SELECT * FROM products p WHERE p.status = 1");

In order to log all the SQL statements executed by our application, we need to use the event “afterQuery”. The first parameter passed to
the event listener contains contextual information about the event that is running, the second is the connection itself.

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as Logger;

    class MyDbListener
    {
        protected $_logger;

        public function __construct()
        {
            $this->_logger = new Logger("../apps/logs/db.log");
        }

        public function afterQuery($event, $connection)
        {
            $this->_logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
        }
    }

As part of this example, we will also implement the :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>` to detect the SQL statements that are taking longer to execute than expected:

.. code-block:: php

    <?php

    use Phalcon\Db\Profiler;
    use Phalcon\Logger;
    use Phalcon\Logger\Adapter\File;

    class MyDbListener
    {
        protected $_profiler;

        protected $_logger;

        /**
         * Creates the profiler and starts the logging
         */
        public function __construct()
        {
            $this->_profiler = new Profiler();
            $this->_logger   = new Logger("../apps/logs/db.log");
        }

        /**
         * This is executed if the event triggered is 'beforeQuery'
         */
        public function beforeQuery($event, $connection)
        {
            $this->_profiler->startProfile($connection->getSQLStatement());
        }

        /**
         * This is executed if the event triggered is 'afterQuery'
         */
        public function afterQuery($event, $connection)
        {
            $this->_logger->log($connection->getSQLStatement(), Logger::INFO);
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

    // Send a SQL command to the database server
    $connection->execute("SELECT * FROM products p WHERE p.status = 1");

    foreach ($dbListener->getProfiler()->getProfiles() as $profile) {
        echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
        echo "Start Time: ", $profile->getInitialTime(), "\n";
        echo "Final Time: ", $profile->getFinalTime(), "\n";
        echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
    }

In a similar manner we can register a lambda function to perform the task instead of a separate listener class (as seen above):

.. code-block:: php

    <?php

    // Listen all the database events
    $eventsManager->attach('db', function ($event, $connection) {
        if ($event->getType() == 'afterQuery') {
            echo $connection->getSQLStatement();
        }
    });

Creating components that trigger Events
---------------------------------------
You can create components in your application that trigger events to an EventsManager. As a consequence, there may exist listeners
that react to these events when generated. In the following example we're creating a component called "MyComponent".
This component is EventsManager aware (it implements :doc:`Phalcon\\Events\\EventsAwareInterface <../api/Phalcon_Events_EventsAwareInterface>`); when its :code:`someTask()` method is executed it triggers two events to any listener in the EventsManager:

.. code-block:: php

    <?php

    use Phalcon\Events\EventsAwareInterface;

    class MyComponent implements EventsAwareInterface
    {
        protected $_eventsManager;

        public function setEventsManager($eventsManager)
        {
            $this->_eventsManager = $eventsManager;
        }

        public function getEventsManager()
        {
            return $this->_eventsManager;
        }

        public function someTask()
        {
            $this->_eventsManager->fire("my-component:beforeSomeTask", $this);

            // Do some task
            echo "Here, someTask\n";

            $this->_eventsManager->fire("my-component:afterSomeTask", $this);
        }
    }

Note that events produced by this component are prefixed with "my-component". This is a unique word that helps us
identify events that are generated from certain component. You can even generate events outside the component with
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

    use Phalcon\Events\Manager as EventsManager;

    // Create an Events Manager
    $eventsManager = new EventsManager();

    // Create the MyComponent instance
    $myComponent   = new MyComponent();

    // Bind the eventsManager to the instance
    $myComponent->setEventsManager($eventsManager);

    // Attach the listener to the EventsManager
    $eventsManager->attach('my-component', new SomeListener());

    // Execute methods in the component
    $myComponent->someTask();

As :code:`someTask()` is executed, the two methods in the listener will be executed, producing the following output:

.. code-block:: php

    Here, beforeSomeTask
    Here, someTask
    Here, afterSomeTask

Additional data may also passed when triggering an event using the third parameter of :code:`fire()`:

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData);

In a listener the third parameter also receives this data:

.. code-block:: php

    <?php

    // Receiving the data in the third parameter
    $eventsManager->attach('my-component', function ($event, $component, $data) {
        print_r($data);
    });

    // Receiving the data from the event context
    $eventsManager->attach('my-component', function ($event, $component) {
        print_r($event->getData());
    });

If a listener it is only interested in listening to a specific type of event you can attach a listener directly:

.. code-block:: php

    <?php

    // The handler will only be executed if the event triggered is "beforeSomeTask"
    $eventsManager->attach('my-component:beforeSomeTask', function ($event, $component) {
        // ...
    });

Event Propagation/Cancellation
------------------------------
Many listeners may be added to the same event manager. This means that for the same type of event many listeners can be notified.
The listeners are notified in the order they were registered in the EventsManager. Some events are cancelable, indicating that
these may be stopped preventing other listeners are notified about the event:

.. code-block:: php

    <?php

    $eventsManager->attach('db', function ($event, $connection) {

        // We stop the event if it is cancelable
        if ($event->isCancelable()) {
            // Stop the event, so other listeners will not be notified about this
            $event->stop();
        }

        // ...

    });

By default events are cancelable, even most of events produced by the framework are cancelables. You can fire a not-cancelable event
by passing :code:`false` in the fourth parameter of :code:`fire()`:

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData, false);

Listener Priorities
-------------------
When attaching listeners you can set a specific priority. With this feature you can attach listeners indicating the order
in which they must be called:

.. code-block:: php

    <?php

    $eventsManager->enablePriorities(true);

    $eventsManager->attach('db', new DbListener(), 150); // More priority
    $eventsManager->attach('db', new DbListener(), 100); // Normal priority
    $eventsManager->attach('db', new DbListener(), 50);  // Less priority

Collecting Responses
--------------------
The events manager can collect every response returned by every notified listener. This example explains how it works:

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;

    $eventsManager = new EventsManager();

    // Set up the events manager to collect responses
    $eventsManager->collectResponses(true);

    // Attach a listener
    $eventsManager->attach('custom:custom', function () {
        return 'first response';
    });

    // Attach a listener
    $eventsManager->attach('custom:custom', function () {
        return 'second response';
    });

    // Fire the event
    $eventsManager->fire('custom:custom', null);

    // Get all the collected responses
    print_r($eventsManager->getResponses());

The above example produces:

.. code-block:: html

    Array ( [0] => first response [1] => second response )

Implementing your own EventsManager
-----------------------------------
The :doc:`Phalcon\\Events\\ManagerInterface <../api/Phalcon_Events_ManagerInterface>` interface must be implemented to create your own
EventsManager replacing the one provided by Phalcon.
