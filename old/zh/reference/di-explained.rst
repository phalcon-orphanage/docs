Dependency Injection Explained
==============================

接下来的例子有些长，但解释了为什么我们使用依赖注入与服务定位器.
首先，假设我们正在开发一个组件，叫SomeComponent，它执行的内容现在还不重要。
我们的组件需要依赖数据库的连接。

在下面第一个例子中，数据库的连接是在组件内部建立的。这种方法是不实用的；事实上这样做的话，我们不能改变创建数据库连接的参数或者选择不同的数据库系统，因为连接是当组件被创建时建立的。

.. code-block:: php

    <?php

    class SomeComponent
    {
        /**
         * 连接数据库的实例是被写死在组件的内部
         * 因此，我们很难从外部替换或者改变它的行为
         */
        public function someDbTask()
        {
            $connection = new Connection(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo",
                ]
            );

            // ...
        }
    }

    $some = new SomeComponent();

    $some->someDbTask();

为了解决这样的情况，我们建立一个setter，在使用前注入独立外部依赖。现在，看起来似乎是一个不错的解决办法：

.. code-block:: php

    <?php

    class SomeComponent
    {
        protected $_connection;

        /**
         * 设置外部传入的数据库的连接实例
         */
        public function setConnection($connection)
        {
            $this->_connection = $connection;
        }

        public function someDbTask()
        {
            $connection = $this->_connection;

            // ...
        }
    }

    $some = new SomeComponent();

    // 建立数据库连接实例
    $connection = new Connection(
        [
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo",
        ]
    );

    // 向组件注入数据连接实例
    $some->setConnection($connection);

    $some->someDbTask();

想一下，假设我们使用这个组件在应用内的好几个地方都用到，然而我们在注入连接实例时还需要建立好几次数据的连接实例。
如果我们可以获取到数据库的连接实例而不用每次都要创建新的连接实例，使用某种全局注册表可以解决这样的问题：

.. code-block:: php

    <?php

    class Registry
    {
        /**
         * 返回数据库连接实例
         */
        public static function getConnection()
        {
            return new Connection(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo",
                ]
            );
        }
    }

    class SomeComponent
    {
        protected $_connection;

        /**
         * 设置外部传入的数据库的连接实例
         */
        public function setConnection($connection)
        {
            $this->_connection = $connection;
        }

        public function someDbTask()
        {
            $connection = $this->_connection;

            // ...
        }
    }

    $some = new SomeComponent();

    // 把注册表中的连接实例传递给组件
    $some->setConnection(Registry::getConnection());

    $some->someDbTask();

现在，让我们设想一下，我们必须实现2个方法，第一个方法是总是创建一个新的连接，第二方法是总是使用一个共享连接：

.. code-block:: php

    <?php

    class Registry
    {
        protected static $_connection;

        /**
         * 建立一个新的连接实例
         */
        protected static function _createConnection()
        {
            return new Connection(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo",
                ]
            );
        }

        /**
         * 只建立一个连接实例，后面的请求只返回该连接实例
         */
        public static function getSharedConnection()
        {
            if (self::$_connection === null) {
                self::$_connection = self::_createConnection();
            }

            return self::$_connection;
        }

        /**
         * 总是返回一个新的连接实例
         */
        public static function getNewConnection()
        {
            return self::_createConnection();
        }
    }

    class SomeComponent
    {
        protected $_connection;

        /**
         * 设置外部传入的数据库的连接实例
         */
        public function setConnection($connection)
        {
            $this->_connection = $connection;
        }

        /**
         * 这个方法总是需要共享连接实例
         */
        public function someDbTask()
        {
            $connection = $this->_connection;

            // ...
        }

        /**
         * 这个方法总是需要新的连接实例
         */
        public function someOtherDbTask($connection)
        {

        }
    }

    $some = new SomeComponent();

    // 注入共享连接实例
    $some->setConnection(
        Registry::getSharedConnection()
    );

    $some->someDbTask();

    // 这里我们总是传递一个新的连接实例
    $some->someOtherDbTask(
        Registry::getNewConnection()
    );

到目前为止，我们已经看到依赖注入怎么解决我们的问题了。把依赖作为参数来传递，而不是建立在内部建立它们，这使我们的应用更加容易维护和更加解耦。不管怎么样，长期来说，这种形式的依赖注入有一些缺点。

例如，如果这个组件有很多依赖，
我们需要创建多个参数的setter方法​​来传递依赖关系，或者建立一个多个参数的构造函数来传递它们，另外在使用组件前还要每次都创建依赖，这让我们的代码像这样不易维护：

.. code-block:: php

    <?php

    // 创建依赖实例或从注册表中查找
    $connection = new Connection();
    $session    = new Session();
    $fileSystem = new FileSystem();
    $filter     = new Filter();
    $selector   = new Selector();

    // 把实例作为参数传递给构造函数
    $some = new SomeComponent($connection, $session, $fileSystem, $filter, $selector);

    // ... 或者使用setter
    $some->setConnection($connection);
    $some->setSession($session);
    $some->setFileSystem($fileSystem);
    $some->setFilter($filter);
    $some->setSelector($selector);

假设我们必须在应用的不同地方使用和创建这些对象。如果当你永远不需要任何依赖实例时，你需要去删掉构造函数的参数，或者去删掉注入的setter。为了解决这样的问题，我们再次回到全局注册表创建组件。不管怎么样，在创建对象之前，它增加了一个新的抽象层：

.. code-block:: php

    <?php

    class SomeComponent
    {
        // ...

        /**
         * Define a factory method to create SomeComponent instances injecting its dependencies
         */
        public static function factory()
        {
            $connection = new Connection();
            $session    = new Session();
            $fileSystem = new FileSystem();
            $filter     = new Filter();
            $selector   = new Selector();

            return new self($connection, $session, $fileSystem, $filter, $selector);
        }
    }

瞬间，我们又回到刚刚开始的问题了，我们再次创建依赖实例在组件内部！我们可以继续前进，找出一个每次能奏效的方法去解决这个问题。但似乎一次又一次，我们又回到了不实用的例子中。

一个实用和优雅的解决方法，是为依赖实例提供一个容器。这个容器担任全局的注册表，就像我们刚才看到的那样。使用依赖实例的容器作为一个桥梁来获取依赖实例，使我们能够降低我们的组件的复杂性：

.. code-block:: php

    <?php

    use Phalcon\Di;
    use Phalcon\DiInterface;

    class SomeComponent
    {
        protected $_di;

        public function __construct(DiInterface $di)
        {
            $this->_di = $di;
        }

        public function someDbTask()
        {
            // 获得数据库连接实例
            // 总是返回一个新的连接
            $connection = $this->_di->get("db");
        }

        public function someOtherDbTask()
        {
            // 获得共享连接实例
            // 每次请求都返回相同的连接实例
            $connection = $this->_di->getShared("db");

            // 这个方法也需要一个输入过滤的依赖服务
            $filter = $this->_di->get("filter");
        }
    }

    $di = new Di();

    // 在容器中注册一个db服务
    $di->set(
        "db",
        function () {
            return new Connection(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo",
                ]
            );
        }
    );

    // 在容器中注册一个filter服务
    $di->set(
        "filter",
        function () {
            return new Filter();
        }
    );

    // 在容器中注册一个session服务
    $di->set(
        "session",
        function () {
            return new Session();
        }
    );

    // 把传递服务的容器作为唯一参数传递给组件
    $some = new SomeComponent($di);

    $some->someDbTask();

这个组件现在可以很简单的获取到它所需要的服务，服务采用延迟加载的方式，只有在需要使用的时候才初始化，这也节省了服务器资源。这个组件现在是高度解耦。例如，我们可以替换掉创建连接的方式，它们的行为或它们的任何其他方面，也不会影响该组件。
