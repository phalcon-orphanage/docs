イベントマネージャ
==================

The purpose of this component is to intercept the execution of most of the other components of the framework by creating "hook points". These hook
points allow the developer to obtain status information, manipulate data or change the flow of execution during the process of a component.

Naming Convention
-----------------
Phalcon events use namespaces to avoid naming collisions. Each component in Phalcon occupies a different event namespace and you are free to create
your own as you see fit. Event names are formatted as "component:event". For example, as :doc:`Phalcon\\Db <../api/Phalcon_Db>` occupies the "db"
namespace, its "afterQuery" event's full name is "db:afterQuery".

When attaching event listeners to the events manager, you can use "component" to catch all events from that component (eg. "db" to catch all of the
:doc:`Phalcon\\Db <../api/Phalcon_Db>` events) or "component:event" to target a specific event (eg. "db:afterQuery").

使用例
-------------
In the following example, we will use the EventsManager to listen for the "afterQuery" event produced in a MySQL connection managed by
:doc:`Phalcon\\Db <../api/Phalcon_Db>`:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

    $eventsManager = new EventsManager();

    $eventsManager->attach(
        "db:afterQuery",
        function (Event $event, $connection) {
            echo $connection->getSQLStatement();
        }
    );

    $connection = new DbAdapter(
        [
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo",
        ]
    );

    // Assign the eventsManager to the db adapter instance
    $connection->setEventsManager($eventsManager);

    // Send a SQL command to the database server
    $connection->query(
        "SELECT * FROM products p WHERE p.status = 1"
    );

Now every time a query is executed, the SQL statement will be echoed out. The first parameter passed to the lambda function contains contextual
information about the event that is running, the second is the source of the event (in this case: the connection itself). A third parameter may
also be specified which will contain arbitrary data specific to the event.

.. highlights::

    You must explicitly set the Events Manager to a component using the :code:`setEventsManager()` method in order for that component to trigger events. You can create a new Events Manager instance for each component or you can set the same Events Manager to multiple components as the naming convention will avoid conflicts.

Instead of using lambda functions, you can use event listener classes instead. Event listeners also allow you to listen to multiple events. In
this example, we will implement the :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>` to detect the SQL statements that are taking longer
to execute than expected:

.. code-block:: php

    <?php

    use Phalcon\Db\Profiler;
    use Phalcon\Events\Event;
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
        public function beforeQuery(Event $event, $connection)
        {
            $this->_profiler->startProfile(
                $connection->getSQLStatement()
            );
        }

        /**
         * This is executed if the event triggered is 'afterQuery'
         */
        public function afterQuery(Event $event, $connection)
        {
            $this->_logger->log(
                $connection->getSQLStatement(),
                Logger::INFO
            );

            $this->_profiler->stopProfile();
        }

        public function getProfiler()
        {
            return $this->_profiler;
        }
    }

Attaching an event listener to the events manager is as simple as:

.. code-block:: php

    <?php

    // Create a database listener
    $dbListener = new MyDbListener();

    // Listen all the database events
    $eventsManager->attach(
        "db",
        $dbListener
    );

The resulting profile data can be obtained from the listener:

.. code-block:: php

    <?php

    // Send a SQL command to the database server
    $connection->execute(
        "SELECT * FROM products p WHERE p.status = 1"
    );

    foreach ($dbListener->getProfiler()->getProfiles() as $profile) {
        echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
        echo "Start Time: ", $profile->getInitialTime(), "\n";
        echo "Final Time: ", $profile->getFinalTime(), "\n";
        echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
    }

イベントをトリガするコンポーネントの作成
----------------------------------------
You can create components in your application that trigger events to an EventsManager. As a consequence, there may exist listeners
that react to these events when generated. In the following example we're creating a component called "MyComponent".
This component is EventsManager aware (it implements :doc:`Phalcon\\Events\\EventsAwareInterface <../api/Phalcon_Events_EventsAwareInterface>`); when its :code:`someTask()` method is executed it triggers two events to any listener in the EventsManager:

.. code-block:: php

    <?php

    use Phalcon\Events\EventsAwareInterface;
    use Phalcon\Events\Manager as EventsManager;

    class MyComponent implements EventsAwareInterface
    {
        protected $_eventsManager;

        public function setEventsManager(EventsManager $eventsManager)
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

Notice that in this example, we're using the "my-component" event namespace. Now we need to create an event listener for this component:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;

    class SomeListener
    {
        public function beforeSomeTask(Event $event, $myComponent)
        {
            echo "Here, beforeSomeTask\n";
        }

        public function afterSomeTask(Event $event, $myComponent)
        {
            echo "Here, afterSomeTask\n";
        }
    }

Now let's make everything work together:

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;

    // Create an Events Manager
    $eventsManager = new EventsManager();

    // Create the MyComponent instance
    $myComponent = new MyComponent();

    // Bind the eventsManager to the instance
    $myComponent->setEventsManager($eventsManager);

    // Attach the listener to the EventsManager
    $eventsManager->attach(
        "my-component",
        new SomeListener()
    );

    // Execute methods in the component
    $myComponent->someTask();

As :code:`someTask()` is executed, the two methods in the listener will be executed, producing the following output:

.. code-block:: php

    Here, beforeSomeTask
    Here, someTask
    Here, afterSomeTask

Additional data may also be passed when triggering an event using the third parameter of :code:`fire()`:

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData);

In a listener the third parameter also receives this data:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;

    // Receiving the data in the third parameter
    $eventsManager->attach(
        "my-component",
        function (Event $event, $component, $data) {
            print_r($data);
        }
    );

    // Receiving the data from the event context
    $eventsManager->attach(
        "my-component",
        function (Event $event, $component) {
            print_r($event->getData());
        }
    );

Using Services From The DI
--------------------------
By extending :doc:`Phalcon\\Mvc\\User\\Plugin <../api/Phalcon_Mvc_User_Plugin>`, you can access services from the DI, just like you would in a controller:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Mvc\User\Plugin;

    class SomeListener extends Plugin
    {
        public function beforeSomeTask(Event $event, $myComponent)
        {
            echo "Here, beforeSomeTask\n";

            $this->logger->debug(
                "beforeSomeTask has been triggered";
            );
        }

        public function afterSomeTask(Event $event, $myComponent)
        {
            echo "Here, afterSomeTask\n";

            $this->logger->debug(
                "afterSomeTask has been triggered";
            );
        }
    }

Event Propagation/Cancellation
------------------------------
Many listeners may be added to the same event manager. This means that for the same type of event, many listeners can be notified.
The listeners are notified in the order they were registered in the EventsManager. Some events are cancelable, indicating that
these may be stopped preventing other listeners from being notified about the event:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;

    $eventsManager->attach(
        "db",
        function (Event $event, $connection) {
            // We stop the event if it is cancelable
            if ($event->isCancelable()) {
                // Stop the event, so other listeners will not be notified about this
                $event->stop();
            }

            // ...
        }
    );

By default, events are cancelable - even most of the events produced by the framework are cancelables. You can fire a not-cancelable event
by passing :code:`false` in the fourth parameter of :code:`fire()`:

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData, false);

リスナーの優先度
-------------------
When attaching listeners you can set a specific priority. With this feature you can attach listeners indicating the order
in which they must be called:

.. code-block:: php

    <?php

    $eventsManager->enablePriorities(true);

    $eventsManager->attach("db", new DbListener(), 150); // More priority
    $eventsManager->attach("db", new DbListener(), 100); // Normal priority
    $eventsManager->attach("db", new DbListener(), 50);  // Less priority

レスポンスの収集
--------------------
The events manager can collect every response returned by every notified listener. This example explains how it works:

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;

    $eventsManager = new EventsManager();

    // Set up the events manager to collect responses
    $eventsManager->collectResponses(true);

    // Attach a listener
    $eventsManager->attach(
        "custom:custom",
        function () {
            return "first response";
        }
    );

    // Attach a listener
    $eventsManager->attach(
        "custom:custom",
        function () {
            return "second response";
        }
    );

    // Fire the event
    $eventsManager->fire("custom:custom", null);

    // Get all the collected responses
    print_r($eventsManager->getResponses());

The above example produces:

.. code-block:: html

    Array ( [0] => first response [1] => second response )

独自イベントマネージャの実装
-----------------------------------
The :doc:`Phalcon\\Events\\ManagerInterface <../api/Phalcon_Events_ManagerInterface>` interface must be implemented to create your own
EventsManager replacing the one provided by Phalcon.
