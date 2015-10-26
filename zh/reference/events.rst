事件管理器（Events Manager）
============================

此组件的目的是为了通过创建“钩子”拦截框架中大部分的组件操作。
这些钩子允许开发者获得状态信息，操纵数据或者改变某个组件进程中的执行流向。

使用示例（Usage Example）
-------------------------
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

    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

    $eventsManager = new EventsManager();

    // 创建一个数据库侦听
    $dbListener    = new MyDbListener();

    // 侦听全部数据库事件
    $eventsManager->attach('db', $dbListener);

    $connection    = new DbAdapter(
        array(
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo"
        )
    );

    // 将$eventsManager赋值给数据库甜适配器
    $connection->setEventsManager($eventsManager);

    // 发送一个SQL命令到数据库服务器
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

作为些示例的一部分，我们同样实现了 :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>` 来检测SQL语句是否超出了期望的执行时间：

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
         *创建分析器并开始纪录
         */
        public function __construct()
        {
            $this->_profiler = new Profiler();
            $this->_logger   = new Logger("../apps/logs/db.log");
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

    // 发送一个SQL命令到数据库服务器
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

    // 侦听全部数据加事件
    $eventsManager->attach('db', function ($event, $connection) {
        if ($event->getType() == 'afterQuery') {
            echo $connection->getSQLStatement();
        }
    });

创建组件触发事件（Creating components that trigger Events）
-----------------------------------------------------------
你可以在你的应用中为事件管理器的触发事件创建组件。这样的结果是，可以有很多存在的侦听者为这些产生的事件作出响应。
在以下的示例中，我们将会创建一个叫做“MyComponent”组件。这是个意识事件管理器组件；
当它的方法:code:someTask()`被执行时它将触发事件管理器中全部侦听者的两个事件：

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
            echo "这里, someTask\n";

            $this->_eventsManager->fire("my-component:afterSomeTask", $this);
        }
    }

注意到这个组件产生的事件都以“my-component”为前缀。这是一个唯一的关键词，可以帮助我们区分各个组件产生的事件。
你甚至可以在组件的外面生成相同名字的事件。现在让我们来为这个组件创建一个侦听者：

.. code-block:: php

    <?php

    class SomeListener
    {
        public function beforeSomeTask($event, $myComponent)
        {
            echo "这里, beforeSomeTask\n";
        }

        public function afterSomeTask($event, $myComponent)
        {
            echo "这里, afterSomeTask\n";
        }
    }

侦听者可以是简单的一个实现了全部组件触发事件的类。现在让我们把全部的东西整合起来：

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;

    // 创建一个事件管理器
    $eventsManager = new EventsManager();

    // 创建MyComponent实例
    $myComponent   = new MyComponent();

    // 将事件管理器绑定到创建MyComponent实例实例
    $myComponent->setEventsManager($eventsManager);

    // 为事件管理器附上侦听者
    $eventsManager->attach('my-component', new SomeListener());

    // 执行组件的方法
    $myComponent->someTask();

当:code:someTask()`被执行时，在侦听者里面的两个方法将会被执行，并产生以下输出：

.. code-block:: php

    这里, beforeSomeTask
    这里, someTask
    这里, afterSomeTask

当触发一个事件时也可以使用:code:fire()`中的第三个参数来传递额外的数据：

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData);

在一个侦听者里，第三个参数可用于接收此参数：

.. code-block:: php

    <?php

    // 从第三个参数接收数据
    $eventsManager->attach('my-component', function ($event, $component, $data) {
        print_r($data);
    });

    // 从事件上下文中接收数据
    $eventsManager->attach('my-component', function ($event, $component) {
        print_r($event->getData());
    });

如果一个侦听者仅是对某个特定类型的事件感兴趣，你要吧直接附上一个侦听者：

.. code-block:: php

    <?php

    // 这个处理器只会在“beforeSomeTask”事件触发时才被执行
    $eventManager->attach('my-component:beforeSomeTask', function ($event, $component) {
        // ...
    });

事件传播与取消（Event Propagation/Cancellation）
------------------------------------------------
可能会有多个侦听者添加到同一个事件管理器，这意味着对于相同的事件会通知多个侦听者。
这些侦听者会以它们在事件管理器注册的顺序来通知。有些事件是可以被取消的，暗示着这些事件可以被终止以防其他侦听都再收到事件的通知：

.. code-block:: php

    <?php

    $eventsManager->attach('db', function ($event, $connection) {

        // 如果可以取消，我们就终止此事件
        if ($event->isCancelable()) {
            // 终止事件，这样的话其他侦听都就不会再收到此通知
            $event->stop();
        }

        // ...

    });

默认情况下全部的事件都是可以取消的，甚至框架提供的事件也是可以取消的。
你可以通过在 :code:`fire()` 中的第四个参数中传递 :code:`false` 来指明这是一个不可取消的事件：

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData, false);

侦听器优先级（Listener Priorities）
-----------------------------------
当附上侦听者时，你可以设置一个优先级。使用此特性，你可以指定这些侦听者被调用的固定顺序：

.. code-block:: php

    <?php

    $evManager->enablePriorities(true);

    $eventsManager->attach('db', new DbListener(), 150); // 高优先级
    $eventsManager->attach('db', new DbListener(), 100); // 正常优先级
    $eventsManager->attach('db', new DbListener(), 50);  // 低优先级

收集响应（Collecting Responses）
--------------------------------
事件管理器可以收集每一个被通知的侦听者返回的响应，以下这个示例解释了它是如何工作的：

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;

    $eventsManager = new EventsManager();

    // 建立事件管理器以为收集结果响应
    $eventsManager->collectResponses(true);

    // 附上一个侦听者
    $eventsManager->attach('custom:custom', function () {
        return 'first response';
    });

    // 附上一个侦听者
    $eventsManager->attach('custom:custom', function () {
        return 'second response';
    });

    // 执行fire事件
    $eventsManager->fire('custom:custom', null);

    // 获取全部收集到的响应
    print_r($eventsManager->getResponses());

上面示例将输出：

.. code-block:: html

    Array ( [0] => first response [1] => second response )

自定义事件管理器（Implementing your own EventsManager）
-------------------------------------------------------
如果想要替换Phalcon提供的事件管理器，必须实现 :doc:`Phalcon\\Events\\ManagerInterface <../api/Phalcon_Events_ManagerInterface>` 中的接口。
