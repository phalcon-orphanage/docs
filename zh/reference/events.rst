事件管理
==============

此组件的目的是通过创建挂钩点拦截框架中大部分组件的执行。这些挂钩点允许开发者获取状态信息，操作数据或改变一个组件在执行过程中的流程。

译者注：挂钩点(hooks point)类似于SVN或GIT中的hook。在使用SVN开发过程中，我们想实现把提交的代码直接部署到演示环境下，那么就需要SVN的hook.

使用示例
-------------
在下面的例子中，我们使用EventsManager侦听使用 :doc:`Phalcon\\Db <../api/Phalcon_Db>` 进行MySQL连接管理过程中产生的事件。首先，我们需要一个侦听器对象，我们创建一个类，它的方法是我们要侦听的事件：

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

这个新的类文件可以更详细一些，因为我们需要使用它。EventsManager 将充当组件与侦听器之间的桥梁，为我们创建的侦听类的方法提供挂钩点：

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

为了记录我们的应用程序执行的所有SQL语句，我们需要使用事件“afterQuery”。第一个参数传递给
事件侦听器，包含正在运行的事件的上下文信息，第二个是连接本身。

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

作为示例的一部分，我们需要实现 Phalcon\\Db\\Profiler，以检测SQL语句比预期花费多长时间：

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

可以从监听器获得返回的数据：

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

以类似的方式，我们可以注册一个lambda形式的匿名函数来执行任务，而不是一个单独的监听器类(见上面示例)：

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
你也可以在应用程序中创建自己的组件，使用EventsManager触发事件。作为结果，事件运行时监听器会作出相应的反应。在下面的例子中，我们创建了一个叫"MyComponent"的组件。这个组件实现了EventsManager aware接口，当它的方法 "someTask" 执行时，监听器会触发相应的两个事件：

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

请注意，这个事件在触发时使用的前辍是  "my-component"，这是一个唯一标志字符，以帮助我们知道事件是由哪个组件产生的。你甚至可以在组件之个创建相同名称的事件。现在，让我们来创建一个监听器监听这个组件：

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

一个监听器就是一个简单的类文件，它实现了所有组件触发的事件。现在，让我们使他们联合在一起工作：

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

"someTask"执行后，监听器中的两个方法也会被执行，下面是输出结果：

.. code-block:: php

    Here, beforeSomeTask
    Here, afterSomeTask

其他数据也可以通过 "fire" 调用第三个参数进行触发：

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData);

在监听器中，第三个参数也接收此数据：

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

如果监听器只对一个特定类型的事件感兴趣，你可以直接绑定：

.. code-block:: php

    <?php

    //The handler will only be executed if the event triggered is "beforeSomeTask"
    $eventManager->attach('my-component:beforeSomeTask', function($event, $component) {
        //...
    });

事件的发布与取消(Event Propagation/Cancelation)
------------------------------------------------------------------
许多监听器可能会添加相同的事件，这意味着，对于同类类型的事件，许多监听器都会被触发(即会有非常多同类型的消息输出)。根据注册到 EventsManager 的顺序，监听器被一一触发。一些事件可以被撤消，表明可以停止一些其他的监听器事件被触发：

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

在默认情况下，事件是可以被取消的，甚至在框架中的大部分事件都是可以被取消的。你可以使用fire方法传递第四个参数，值为"false"，以达到不可取消的目的：

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData, false);

实现自定义EventsManager(Implementing your own EventsManager)
---------------------------------------------------------------------------
The :doc:`Phalcon\\Events\\ManagerInterface <../api/Phalcon_Events_ManagerInterface>` interface must be implemented to create your own
EventsManager replacing the one provided by Phalcon.