使用依赖注入
==========================
下面要讲的这个例子有点长，但可以很好的解释为什么使用Service Container以及DI。首先，我们假设，我们要开发一个组件命名为SomeComponent。这个组件中现在将要注入一个数据库连接。

在这个例子中，数据库连接在component中被创建，这种方法是不切实际的，这样做的话，我们将不能改变数据库连接参数及数据库类型等一些参数。

.. code-block:: php

    <?php

    class SomeComponent
    {

        /**
         * The instantiation of the connection is hardcoded inside
         * the component so is difficult to replace it externally
         * or change its behavior
         */
        public function someDbTask()
        {
            $connection = new Connection(array(
                "host" => "localhost",
                "username" => "root",
                "password" => "secret",
                "dbname" => "invo"
            ));

            // ...
        }

    }

    $some = new SomeComponent();
    $some->someDbTask();

为了解决上面所说的问题，我们需要在使用前创建一个外部连接，并注入到容器中。就目前而言，这看起来是一个很好的解决方案：

.. code-block:: php

    <?php

    class SomeComponent
    {

        protected $_connection;

        /**
         * Sets the connection externally
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

    //Create the connection
    $connection = new Connection(array(
        "host" => "localhost",
        "username" => "root",
        "password" => "secret",
        "dbname" => "invo"
    ));

    //Inject the connection in the component
    $some->setConnection($connection);

    $some->someDbTask();

现在我们来考虑一个问题，我们在应用程序中的不同地方使用此组件，将多次创建数据库连接。使用一种类似全局注册表的方式，从这获得一个数据库连接实例，而不是使用一次就创建一次。

.. code-block:: php

    <?php

    class Registry
    {

        /**
         * Returns the connection
         */
        public static function getConnection()
        {
           return new Connection(array(
                "host" => "localhost",
                "username" => "root",
                "password" => "secret",
                "dbname" => "invo"
            ));
        }

    }

    class SomeComponent
    {

        protected $_connection;

        /**
         * Sets the connection externally
         */
        public function setConnection($connection){
            $this->_connection = $connection;
        }

        public function someDbTask()
        {
            $connection = $this->_connection;

            // ...
        }

    }

    $some = new SomeComponent();

    //Pass the connection defined in the registry
    $some->setConnection(Registry::getConnection());

    $some->someDbTask();

现在，让我们来想像一下，我们必须在组件中实现两个方法，首先需要创建一个新的数据库连接，第二个总是获得一个共享连接：

.. code-block:: php

    <?php

    class Registry
    {

        protected static $_connection;

        /**
         * Creates a connection
         */
        protected static function _createConnection()
        {
            return new Connection(array(
                "host" => "localhost",
                "username" => "root",
                "password" => "secret",
                "dbname" => "invo"
            ));
        }

        /**
         * Creates a connection only once and returns it
         */
        public static function getSharedConnection()
        {
            if (self::$_connection===null){
                $connection = self::_createConnection();
                self::$_connection = $connection;
            }
            return self::$_connection;
        }

        /**
         * Always returns a new connection
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
         * Sets the connection externally
         */
        public function setConnection($connection){
            $this->_connection = $connection;
        }

        /**
         * This method always needs the shared connection
         */
        public function someDbTask()
        {
            $connection = $this->_connection;

            // ...
        }

        /**
         * This method always needs a new connection
         */
        public function someOtherDbTask($connection)
        {

        }

    }

    $some = new SomeComponent();

    //This injects the shared connection
    $some->setConnection(Registry::getSharedConnection());

    $some->someDbTask();

    //Here, we always pass a new connection as parameter
    $some->someOtherDbTask(Registry::getConnection());

到此为止，我们已经看到了如何使用依赖注入解决我们的问题。不是在代码内部创建依赖关系，而是让其作为一个参数传递，这使得我们的程序更容易维护，降低程序代码的耦合度，实现一种松耦合。但是从长远来看，这种形式的依赖注入也有一些缺点。

例如，如果组件中有较多的依赖关系，我们需要创建多个setter方法传递，或创建构造函数进行传递。另外，每次使用组件时，都需要创建依赖组件，使代码维护不太易，我们编写的代码可能像这样：

.. code-block:: php

    <?php

    //Create the dependencies or retrieve them from the registry
    $connection = new Connection();
    $session = new Session();
    $fileSystem = new FileSystem();
    $filter = new Filter();
    $selector = new Selector();

    //Pass them as constructor parameters
    $some = new SomeComponent($connection, $session, $fileSystem, $filter, $selector);

    // ... or using setters

    $some->setConnection($connection);
    $some->setSession($session);
    $some->setFileSystem($fileSystem);
    $some->setFilter($filter);
    $some->setSelector($selector);

我想，我们不得不在应用程序的许多地方创建这个对象。如果你不需要依赖的组件后，我们又要去代码注入部分移除构造函数中的参数或者是setter方法。为了解决这个问题，我们再次返回去使用一个全局注册表来创建组件。但是，在创建对象之前，它增加了一个新的抽象层：

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
            $session = new Session();
            $fileSystem = new FileSystem();
            $filter = new Filter();
            $selector = new Selector();

            return new self($connection, $session, $fileSystem, $filter, $selector);
        }

    }

这一刻，我们好像回到了问题的开始，我们正在创建组件内部的依赖，我们每次都在修改以及找寻一种解决问题的办法，但这都不是很好的做法。

一种实用和优雅的来解决这些问题，是使用容器的依赖注入，像我们在前面看到的，容器作为全局注册表，使用容器的依赖注入做为一种桥梁来解决依赖可以使我们的代码耦合度更低，很好的降低了组件的复杂性：

.. code-block:: php

    <?php

    class SomeComponent
    {

        protected $_di;

        public function __construct($di)
        {
            $this->_di = $di;
        }

        public function someDbTask()
        {

            // Get the connection service
            // Always returns a new connection
            $connection = $this->_di->get('db');

        }

        public function someOtherDbTask()
        {

            // Get a shared connection service,
            // this will return the same connection everytime
            $connection = $this->_di->getShared('db');

            //This method also requires a input filtering service
            $filter = $this->_db->get('filter');

        }

    }

    $di = new Phalcon\DI();

    //Register a "db" service in the container
    $di->set('db', function(){
        return new Connection(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname" => "invo"
        ));
    });

    //Register a "filter" service in the container
    $di->set('filter', function(){
        return new Filter();
    });

    //Register a "session" service in the container
    $di->set('session', function(){
        return new Session();
    });

    //Pass the service container as unique parameter
    $some = new SomeComponent($di);

    $some->someTask();

现在，该组件只有访问某种service的时候才需要它，如果它不需要，它甚至不初始化，以节约资源。该组件是高度解耦。他们的行为，或者说他们的任何其他方面都不会影响到组件本身。

我们的实现办法
------------

Phalcon\\DI 是一个实现了服务的依赖注入功能的组件，它本身也是一个容器。

由于Phalcon高度解耦，Phalcon\\DI 是框架用来集成其他组件的必不可少的部分，开发人员也可以使用这个组件依赖注入和管理应用程序中不同类文件的实例。

基本上，这个组件实现了 `Inversion of Control`_  模式。基于此，对象不再以构造函数接收参数或者使用setter的方式来实现注入，而是直接请求服务的依赖注入。这就大大降低了整体程序的复杂性，因为只有一个方法用以获得所需要的一个组件的依赖关系。

此外，这种模式增强了代码的可测试性，从而使它不容易出错。

在容器中注册服务
-------------------------------------
框架本身或开发人员都可以注册服务。当一个组件A要求调用组件B（或它的类的一个实例），可以从容器中请求调用组件B，而不是创建组件B的一个实例。

这种工作方式为我们提供了许多优点：

* 我们可以更换一个组件，从他们本身或者第三方轻松创建。
* 在组件发布之前，我们可以充分的控制对象的初始化，并对对象进行各种设置。
* 我们可以使用统一的方式从组件得到一个结构化的全局实例

服务可以通过以下几种方式注入到容器：

.. code-block:: php

    <?php

    //Create the Dependency Injector Container
    $di = new Phalcon\DI();

    //By its class name
    $di->set("request", 'Phalcon\Http\Request');

    //Using an anonymous function, the instance will lazy loaded
    $di->set("request", function(){
        return new Phalcon\Http\Request();
    });

    //Registering directly an instance
    $di->set("request", new Phalcon\Http\Request());

    //Using an array definition
    $di->set("request", array(
        "className" => 'Phalcon\Http\Request'
    ));

在上面的例子中，当向框架请求访问一个请求数据时，它将首先确定容器中是否存在这个"reqeust"名称的服务。

容器会反回一个请求数据的实例，开发人员最终得到他们想要的组件。

在上面示例中的每一种方法都有优缺点，具体使用哪一种，由开发过程中的特定场景来决定的。

用一个字符串来设定一个服务非常简单，但缺少灵活性。设置服务时，使用数组则提供了更多的灵活性，而且可以使用较复杂的代码。lambda函数是两者之间一个很好的平衡，但也可能导致更多的维护管理成本。

Phalcon\\DI 提供服务的延迟加载。除非开发人员在注入服务的时候直接实例化一个对象，然后存存储到容器中。在容器中，通过数组，字符串等方式存储的服务都将被延迟加载，即只有在请求对象的时候才被初始化。

.. code-block:: php

    <?php

    //Register a service "db" with a class name and its parameters
    $di->set("db", array(
        "className" => "Phalcon\Db\Adapter\Pdo\Mysql",
        "parameters" => array(
              "parameter" => array(
                   "host" => "localhost",
                   "username" => "root",
                   "password" => "secret",
                   "dbname" => "blog"
              )
        )
    ));

    //Using an anonymous function
    $di->set("db", function(){
        return new Phalcon\Db\Adapter\Pdo\Mysql(array(
             "host" => "localhost",
             "username" => "root",
             "password" => "secret",
             "dbname" => "blog"
        ));
    });

以上这两种服务的注册方式产生相同的结果。然后，通过数组定义的，在后面需要的时候，你可以修改服务参数：

.. code-block:: php

    <?php

    $di->setParameter("db", 0, array(
        "host" => "localhost",
        "username" => "root",
        "password" => "secret"
    ));

从容器中获得服务的最简单方式就是使用"get"方法，它将从容器中返回一个新的实例：

.. code-block:: php

    <?php $request = $di->get("request");

或者通过下面这种魔术方法的形式调用：

.. code-block:: php

    <?php

    $request = $di->getRequest();

Phalcon\\DI 同时允许服务重用，为了得到一个已经实例化过的服务，可以使用 getShared() 方法的形式来获得服务。

具体的 Phalcon\\Http\\Request 请求示例：

.. code-block:: php

    <?php

    $request = $di->getShared("request");

参数还可以在请求的时候通过将一个数组参数传递给构造函数的方式：

.. code-block:: php

    <?php

    $component = $di->get("MyComponent", array("some-parameter", "other"))

Factory Default DI
------------------
虽然Phalcon在解耦方面为我们提供了很大的自由度和灵活性，也许我们只是单纯的把它当作一个full-stack的框架来使用。为了实现这一目标，该框架提供了 Phalcon\\DI 的一个变种 Phalcon\\DI\\FactoryDefault 。这个类会自动注册相应的服务，使各种服务组件绑定到框架。

.. code-block:: php

    <?php $di = new Phalcon\DI\FactoryDefault();

服务命名约定
------------------------
虽然你可以任意注入你想要的服务(名称)到容器中，但Phalcon有一系列的命名约定，使用它们以能得到适当的服务。

+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+
| Service Name        | Description                                 | Default                                                                                            |
+=====================+=============================================+====================================================================================================+
| dispatcher          | Controllers Dispatching Service             | :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>`                                    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+
| router              | Routing Service                             | :doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>`                                            |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+
| url                 | URL Generator Service                       | :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>`                                                  |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+
| request             | HTTP Request Environment Service            | :doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>`                                        |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+
| response            | HTTP Response Environment Service           | :doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>`                                      |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+
| filter              | Input Filtering Service                     | :doc:`Phalcon\\Filter <../api/Phalcon_Filter>`                                                     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+
| flash               | Flash Messaging Service                     | :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>`                                        |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+
| session             | Session Service                             | :doc:`Phalcon\\Session\\Adapter\\Files <../api/Phalcon_Session_Adapter_Files>`                     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+
| eventsManager       | Events Management Service                   | :doc:`Phalcon\\Events\\Manager <../api/Phalcon_Events_Manager>`                                    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+
| db                  | Low-Level Database Connection Service       | :doc:`Phalcon\\Db <../api/Phalcon_Db>`                                                             |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+
| modelsManager       | Models Management Service                   | :doc:`Phalcon\\Mvc\\Model\\Manager <../api/Phalcon_Mvc_Model_Manager>`                             |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+
| modelsMetadata      | Models Meta-Data Service                    | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Memory <../api/Phalcon_Mvc_Model_MetaData_Memory>`            |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+
| transactionManager  | Models Transaction Manager Service          | :doc:`Phalcon\\Mvc\\Model\\Transaction\\Manager <../api/Phalcon_Mvc_Model_Transaction_Manager>`    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+

Instantiating classes via the Services Container
------------------------------------------------
当你向服务容器请求服务的时候，如果在容器中找不到这个服务，它会尝试加载具有相同名称的一个类，通过这种行为，我们可以使用注册为一个服务的形式来获取一个类的实例：

.. code-block:: php

    <?php

    //Register a controller as a service
    $di->set('IndexController', function() {
        $component = new Component();
        return $component;
    });

    //Register a controller as a service
    $di->set('MyOtherComponent', function() {
        //Actually returns another component
        $component = new AnotherComponent();
        return $component;
    });

    //Create a instance via the services container
    $myComponent = $di->get('MyOtherComponent');

你可以利用这个特点，总是通过向服务容器(即使它们没有被注册为服务)请求服务来获得类的实例，DI会通过 autoloader 加载的类返回一个类的实例。

Accessing the DI in a static way
--------------------------------
如果你需要，你还可以通过以下的方式使用DI来创建一个静态函数

.. code-block:: php

    <?php

    class SomeComponent
    {

        public static function someMethod()
        {
            $session = Phalcon\DI::getDefault()->getShared('session');
        }

    }

.. _`Inversion of Control`: http://en.wikipedia.org/wiki/Inversion_of_control