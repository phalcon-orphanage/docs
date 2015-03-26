事件管理器（Events Manager）
==============
此组件的目的是为了通过创建“钩子”拦截框架中大部分的组件操作。
这些钩子允许开发者获得状态信息，操纵数据或者改变某个组件进程中的执行流向。

使用示例（Usage Example）
-------------
以下面示例中，我们使用EventsManager来侦听在 :doc:`Phalcon\\Db <../api/Phalcon_Db>` 管理下的MySQL连接中产生的事件。
首先，我们需要一个侦听者对象来完成这部分的工作。我们创建了一个类，这个类有我们需要侦听事件所对应的方法：

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

这个新的类可能有点啰嗦，但我们需要这样做。
事件管理器在组件和我们的侦听类之间充当着接口角色，并提供了基于在我们侦听类中所定义方法的钩子：

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager,
        Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

    $eventsManager = new EventsManager();

    //创建一个数据库侦听
    $dbListener = new MyDbListener();

    //侦听全部数据库事件
    $eventsManager->attach('db', $dbListener);

    $connection = new DbAdapter(array(
        "host" => "localhost",
        "username" => "root",
        "password" => "secret",
        "dbname" => "invo"
    ));

    //将$eventsManager赋值给数据库甜适配器
    $connection->setEventsManager($eventsManager);

    //发送一个SQL命令到数据库服务器
    $connection->query("SELECT * FROM products p WHERE p.status = 1");

为了纪录我们应用中全部执行的SQL语句，我们需要使用“afterQuery”事件。
第一个传递给事件侦听者的参数包含了关于正在运行事件的上下文信息，第二个则是连接本身。

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

作为些示例的一部分，我们同样实现了 Phalcon\\Db\\Profiler 来检测SQL语句是否超出了期望的执行时间：

.. code-block:: php

    <?php

    use Phalcon\Db\Profiler,
        Phalcon\Logger,
        Phalcon\Logger\Adapter\File;

    class MyDbListener
    {

        protected $_profiler;

        protected $_logger;

        /**
         *创建分析器并开始纪录
         */
        public function __construct()
        {
            $this->_profiler = new Profiler();
            $this->_logger = new Logger("../apps/logs/db.log");
        }

        /**
         * 如果事件触发器是'beforeQuery'，此函数将会被执行
         */
        public function beforeQuery($event, $connection)
        {
            $this->_profiler->startProfile($connection->getSQLStatement());
        }

        /**
         * 如果事件触发器是'afterQuery'，此函数将会被执行
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

可以从侦听者中获取结果分析数据：

.. code-block:: php

    <?php

    //Send a SQL command to the database server
    $connection->execute("SELECT * FROM products p WHERE p.status = 1");

    foreach ($dbListener->getProfiler()->getProfiles() as $profile) {
        echo "SQL语句: ", $profile->getSQLStatement(), "\n";
        echo "开始时间: ", $profile->getInitialTime(), "\n";
        echo "结束时间: ", $profile->getFinalTime(), "\n";
        echo "总共执行的时间: ", $profile->getTotalElapsedSeconds(), "\n";
    }

类似地，我们可以注册一个匿名函数来执行这些任务，而不是再分离出一个侦听类（如上面看到的）：

.. code-block:: php

    <?php

    //侦听全部数据加事件
    $eventManager->attach('db', function($event, $connection) {
        if ($event->getType() == 'afterQuery') {
            echo $connection->getSQLStatement();
        }
    });

创建组件触发事件（Creating components that trigger Events）
---------------------------------------
你可以在你的应用中为事件管理器的触发事件创建组件。这样的结果是，可以有很多存在的侦听者为这些产生的事件作出响应。
在以下的示例中，我们将会创建一个叫做“MyComponent”组件。这是个意识事件管理器组件；
当它的方法“someTask”被执行时它将触发事件管理器中全部侦听者的两个事件：

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

            // 做一些你想做的事情

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

    //Create an Events Manager
    $eventsManager = new Phalcon\Events\Manager();

    //Create the MyComponent instance
    $myComponent = new MyComponent();

    //Bind the eventsManager to the instance
    $myComponent->setEventsManager($eventsManager);

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

事件传播与取消（Event Propagation/Cancellation）
-----------------------------------
Many listeners may be added to the same event manager, this means that for the same type of event many listeners can be notified.
The listeners are notified in the order they were registered in the EventsManager. Some events are cancelable, indicating that
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
by passing "false" in the fourth parameter of fire:

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData, false);

侦听器优先级（Listener Priorities）
-------------------
When attaching listeners you can set a specific priority. With this feature you can attach listeners indicating the order
in which they must be called:

.. code-block:: php

    <?php

    $evManager->enablePriorities(true);

    $evManager->attach('db', new DbListener(), 150); //More priority
    $evManager->attach('db', new DbListener(), 100); //Normal priority
    $evManager->attach('db', new DbListener(), 50); //Less priority

收集响应（Collecting Responses）
--------------------
The events manager can collect every response returned by every notified listener, this example explains how it works:

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;

    $evManager = new EventsManager();

    //Set up the events manager to collect responses
    $evManager->collectResponses(true);

    //Attach a listener
    $evManager->attach('custom:custom', function() {
        return 'first response';
    });

    //Attach a listener
    $evManager->attach('custom:custom', function() {
        return 'second response';
    });

    //Fire the event
    $evManager->fire('custom:custom', null);

    //Get all the collected responses
    print_r($evManager->getResponses());

The above example produces:

.. code-block:: html

    Array ( [0] => first response [1] => second response )

自定义事件管理器（Implementing your own EventsManager）
-----------------------------------
The :doc:`Phalcon\\Events\\ManagerInterface <../api/Phalcon_Events_ManagerInterface>` interface must be implemented to create your own
EventsManager replacing the one provided by Phalcon.
