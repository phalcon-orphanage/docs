Using Dependency Injection
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

Our approach
------------

Phalcon\\DI is a component that implements Dependency Injection of services and it's itself a container for them.

Since Phalcon is highly decoupled, Phalcon\\DI is essential to integrate the different components of the framework. The developer can also use this component
to inject dependencies and manage global instances of the different classes used in the application.

Basically, this component implements the `Inversion of Control`_ pattern. Applying this, the objects do not receive their dependencies using setters or
constructors, but requesting a service dependency injector. This reduces the overall complexity, since there is only one way to get the required dependencies within a component.

Additionally, this pattern increases testability in the code, thus making it less prone to errors.

Registering services in the Container
-------------------------------------
The framework itself or the developer can register services. When a component A requires component B (or an instance of its class) to operate, it
can request component B from the container, rather than creating a new instance component B.

This way of working gives us many advantages:

* We can replace a component by one created by ourselves or a third party one easily.
* We have full control of the object initialization, allowing us to set this objects, as you need before delivery them to components.
* We can get global instances of components in a structured and unified way

Services can be registered in several ways:

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

In the above example, when the framework needs to access the request data, it will ask for the service identified as ‘request’ in the container.
The container in turn will return an instance of the required service. A developer might eventually replace a component when he/she needs.

Each of the methods (demonstrated in the above example) used to set/register a service has advantages and disadvantages. It is up to the
developer and the particular requirements that will designate which one is used.

Setting a service by a string is simple but lacks flexibility. Setting services using an array offers a lot more flexibility but makes the
code more complicated. The lambda function is a good balance between the two but could lead to more maintenance than one would expect.

Phalcon\\DI offers lazy loading for every service it stores. Unless the developer chooses to instantiate an object directly and store it
in the container, any object stored in it (via array, string etc.) will be lazy loaded i.e. instantiated only when requested.

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

Both service registrations above produce the same result. The array definition however, allows for alteration of the service parameters if needed:

.. code-block:: php

    <?php

    $di->setParameter("db", 0, array(
        "host" => "localhost",
        "username" => "root",
        "password" => "secret"
    ));

Obtaining a service from the container is a matter of simply calling the “get” method. A new instance of the service will be returned:

.. code-block:: php

    <?php $request = $di->get("request");

Or by calling through the magic method:

.. code-block:: php

    <?php

    $request = $di->getRequest();

Phalcon\\DI also allows for services to be reusable. To get a service previously instantiated the getShared() method can be used.
Specifically for the Phalcon\\Http\\Request example shown above:

.. code-block:: php

    <?php

    $request = $di->getShared("request");

Arguments can be passed to the constructor by adding an array parameter to the method "get":

.. code-block:: php

    <?php

    $component = $di->get("MyComponent", array("some-parameter", "other"))

Factory Default DI
------------------
Although the decoupled character of Phalcon offers us great freedom and flexibility, maybe we just simply want to use it as a full-stack
framework. To achieve this, the framework provides a variant of Phalcon\\DI called Phalcon\\DI\\FactoryDefault. This class automatically
registers the appropriate services bundled with the framework to act as full-stack.

.. code-block:: php

    <?php $di = new Phalcon\DI\FactoryDefault();

Service Name Conventions
------------------------
Although you can register services with the names you want. Phalcon has a seriers of service naming conventions that allow it to get the
right services when you need it requires them.

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
When you request a service to the services container, if it can't find out a service with the same name it'll try to load a class with
the same name. With this behavior we can replace any class by another simply by registering a service with its name:

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

You can take advantage of this, always instantiating your classes via the services container (even if they aren't registered as services). The DI will
fallback to a valid autoloader to finally load the class.

Accessing the DI in a static way
--------------------------------
If needed you can access the latest DI created in an static function in the following way:

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