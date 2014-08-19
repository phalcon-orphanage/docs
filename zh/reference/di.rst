依赖注入与服务定位器（Dependency Injection/Service Location）
*************************************
接下来的例子有些长，但解释了为什么我们使用依赖注入与服务定位器.
首先，假设我们正在开发一个组件，叫SomeComponent，它执行的内容现在还不重要。
我们的组件依赖数据库的连接。

在第一个例子中，数据库的连接是在组件内部建立的。这种方法是不实用的；事实上这样做的话，我们不能改变创建数据库连接的参数或者选择不同的数据库系统，因为连接是当组件被创建时建立的。

.. code-block:: php

    <?php

    class SomeComponent
    {

        /**
         * 连接数据库的实例是被硬编码在组件的内部
         * 因此，我们很难从外部替换或者改变它的行为
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

    //建立数据库连接实例
    $connection = new Connection(array(
        "host" => "localhost",
        "username" => "root",
        "password" => "secret",
        "dbname" => "invo"
    ));

    //向组件注入数据连接实例
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

    //把注册表中的连接实例传递给组件
    $some->setConnection(Registry::getConnection());

    $some->someDbTask();

现在，让我们想象一下，我们必须实现2个方法，第一个方法是总是创建一个新的连接，第二方法是总是使用一个共享连接：

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
            return new Connection(array(
                "host" => "localhost",
                "username" => "root",
                "password" => "secret",
                "dbname" => "invo"
            ));
        }

        /**
         * 只建立一个连接实例，后面的请求只返回该连接实例
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

    //注入共享连接实例
    $some->setConnection(Registry::getSharedConnection());

    $some->someDbTask();

    //这里我们总是传递一个新的连接实例
    $some->someOtherDbTask(Registry::getConnection());

到目前为止，我们已经看到依赖注入怎么解决我们的问题了。把依赖作为参数来传递，而不是建立在内部建立它们，这使我们的应用更加容易维护和更加解耦。不管怎么样，长期来说，这种形式的依赖注入有一些缺点。

例如，如果这个组件有很多依赖，
我们需要创建多个参数的setter方法​​来传递依赖关系，或者建立一个多个参数的构造函数来传递它们，另外在使用组件前还要每次都创建依赖，这让我们的代码像这样不易维护：

.. code-block:: php

    <?php

    //创建依赖实例或从注册表中查找
    $connection = new Connection();
    $session = new Session();
    $fileSystem = new FileSystem();
    $filter = new Filter();
    $selector = new Selector();

    //把实例作为参数传递给构造函数
    $some = new SomeComponent($connection, $session, $fileSystem, $filter, $selector);

    // ... 或者使用setter

    $some->setConnection($connection);
    $some->setSession($session);
    $some->setFileSystem($fileSystem);
    $some->setFilter($filter);
    $some->setSelector($selector);

想象一下我们在应用不同地方使用的时候必须建立这些对象。当然如果你永远不需要任何依赖实例，你需要删掉构造函数的参数，或者删掉注入的setter。为了解决这样的问题，我们再次回到全局注册表创建组件。不管怎么样，在创建对象之前，它增加了一个新的抽象层：

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

瞬间，我们又回到刚刚开始的问题了，我们再次创建依赖实例在组件内部！我们可以继续前进，找出一个每次能奏效的方法去解决这个问题。但似乎一次又一次，我们又回到的不实用的例子中。

一个使用和优雅的方法去解决这些问题，是为依赖实例提供一个容器。这个容器担任全局的注册表，就像我们刚才看到的那样。使用依赖实例的容器作为一个桥梁来获取依赖实例，使我们能够降低我们的组件的复杂性：

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

            // 获得数据库连接实例
            // 总是返回一个新的连接
            $connection = $this->_di->get('db');

        }

        public function someOtherDbTask()
        {

            // 获得共享连接实例
            // 每次请求都返回相同的连接实例
            $connection = $this->_di->getShared('db');

            // 这个方法也需要一个输入过滤的依赖服务
            $filter = $this->_di->get('filter');

        }

    }

    $di = new Phalcon\DI();

    //在容器中注册一个db服务
    $di->set('db', function() {
        return new Connection(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname" => "invo"
        ));
    });

    //在容器中注册一个filter服务
    $di->set('filter', function() {
        return new Filter();
    });

    //在容器中注册一个session服务
    $di->set('session', function() {
        return new Session();
    });

    //把传递服务的容器作为唯一参数传递给组件
    $some = new SomeComponent($di);

    $some->someTask();

这个组件现在可以很简单的获取到它所需要的服务，如果它不去获取一个服务，那么那个服务不会初始化，这也节省了服务器资源。这个组件现在是高度解耦。例如，我们可以替换掉创建连接飞方式，他们的行为或它们的任何其他方面，也不会影响该组件。

实现方法（Our approach）
============
Phalcon\\DI is a component implementing Dependency Injection and Location of services and it's itself a container for them.

Since Phalcon is highly decoupled, Phalcon\\DI is essential to integrate the different components of the framework. The developer can
also use this component to inject dependencies and manage global instances of the different classes used in the application.

Basically, this component implements the `Inversion of Control`_ pattern. Applying this, the objects do not receive their dependencies
using setters or constructors, but requesting a service dependency injector. This reduces the overall complexity since there is only
one way to get the required dependencies within a component.

Additionally, this pattern increases testability in the code, thus making it less prone to errors.

使用容器注册服务（Registering services in the Container）
=====================================
The framework itself or the developer can register services. When a component A requires component B (or an instance of its class) to operate, it
can request component B from the container, rather than creating a new instance component B.

This way of working gives us many advantages:

* We can easily replace a component with one created by ourselves or a third party.
* We have full control of the object initialization, allowing us to set these objects, as needed before delivering them to components.
* We can get global instances of components in a structured and unified way

Services can be registered using several types of definitions:

.. code-block:: php

    <?php

    //Create the Dependency Injector Container
    $di = new Phalcon\DI();

    //By its class name
    $di->set("request", 'Phalcon\Http\Request');

    //Using an anonymous function, the instance will be lazy loaded
    $di->set("request", function() {
        return new Phalcon\Http\Request();
    });

    //Registering an instance directly
    $di->set("request", new Phalcon\Http\Request());

    //Using an array definition
    $di->set("request", array(
        "className" => 'Phalcon\Http\Request'
    ));

The array syntax is also allowed to register services:

.. code-block:: php

    <?php

    //Create the Dependency Injector Container
    $di = new Phalcon\DI();

    //By its class name
    $di["request"] = 'Phalcon\Http\Request';

    //Using an anonymous function, the instance will be lazy loaded
    $di["request"] = function() {
        return new Phalcon\Http\Request();
    };

    //Registering an instance directly
    $di["request"] = new Phalcon\Http\Request();

    //Using an array definition
    $di["request"] = array(
        "className" => 'Phalcon\Http\Request'
    );

In the examples above, when the framework needs to access the request data, it will ask for the service identified as ‘request’ in the container.
The container in turn will return an instance of the required service. A developer might eventually replace a component when he/she needs.

Each of the methods (demonstrated in the examples above) used to set/register a service has advantages and disadvantages. It is up to the
developer and the particular requirements that will designate which one is used.

Setting a service by a string is simple, but lacks flexibility. Setting services using an array offers a lot more flexibility, but makes the
code more complicated. The lambda function is a good balance between the two, but could lead to more maintenance than one would expect.

Phalcon\\DI offers lazy loading for every service it stores. Unless the developer chooses to instantiate an object directly and store it
in the container, any object stored in it (via array, string, etc.) will be lazy loaded i.e. instantiated only when requested.

简单的注册（Simple Registration）
-------------------
As seen before, there are several ways to register services. These we call simple:

String
^^^^^^
This type expects the name of a valid class, returning an object of the specified class, if the class is not loaded it will be instantiated using an auto-loader.
This type of definition does not allow to specify arguments for the class constructor or parameters:

.. code-block:: php

    <?php

    // return new Phalcon\Http\Request();
    $di->set('request', 'Phalcon\Http\Request');

对象（Object）
^^^^^^
This type expects an object. Due to the fact that object does not need to be resolved as it is
already an object, one could say that it is not really a dependency injection,
however it is useful if you want to force the returned dependency to always be
the same object/value:

.. code-block:: php

    <?php

    // return new Phalcon\Http\Request();
    $di->set('request', new Phalcon\Http\Request());

闭包与匿名函数（Closures/Anonymous functions）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
This method offers greater freedom to build the dependency as desired, however, it is difficult to
change some of the parameters externally without having to completely change the definition of dependency:

.. code-block:: php

    <?php

    $di->set("db", function() {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
             "host" => "localhost",
             "username" => "root",
             "password" => "secret",
             "dbname" => "blog"
        ));
    });

Some of the limitations can be overcome by passing additional variables to the closure's environment:

.. code-block:: php

    <?php

    //Using the $config variable in the current scope
    $di->set("db", function() use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
             "host" => $config->host,
             "username" => $config->username,
             "password" => $config->password,
             "dbname" => $config->name
        ));
    });

复杂的注册（Complex Registration）
--------------------
If it is required to change the definition of a service without instantiating/resolving the service,
then, we need to define the services using the array syntax. Define a service using an array definition
can be a little more verbose:

.. code-block:: php

    <?php

    //Register a service 'logger' with a class name and its parameters
    $di->set('logger', array(
        'className' => 'Phalcon\Logger\Adapter\File',
        'arguments' => array(
            array(
                'type' => 'parameter',
                'value' => '../apps/logs/error.log'
            )
        )
    ));

    //Using an anonymous function
    $di->set('logger', function() {
        return new \Phalcon\Logger\Adapter\File('../apps/logs/error.log');
    });

Both service registrations above produce the same result. The array definition however, allows for alteration of the service parameters if needed:

.. code-block:: php

    <?php

    //Change the service class name
    $di->getService('logger')->setClassName('MyCustomLogger');

    //Change the first parameter without instantiating the logger
    $di->getService('logger')->setParameter(0, array(
        'type' => 'parameter',
        'value' => '../apps/logs/error.log'
    ));

In addition by using the array syntax you can use three types of dependency injection:

构造函数注入（Constructor Injection）
^^^^^^^^^^^^^^^^^^^^^
This injection type passes the dependencies/arguments to the class constructor.
Let's pretend we have the following component:

.. code-block:: php

    <?php

    namespace SomeApp;

    use Phalcon\Http\Response;

    class SomeComponent
    {

        protected $_response;

        protected $_someFlag;

        public function __construct(Response $response, $someFlag)
        {
            $this->_response = $response;
            $this->_someFlag = $someFlag;
        }

    }

The service can be registered this way:

.. code-block:: php

    <?php

    $di->set('response', array(
        'className' => 'Phalcon\Http\Response'
    ));

    $di->set('someComponent', array(
        'className' => 'SomeApp\SomeComponent',
        'arguments' => array(
            array('type' => 'service', 'name' => 'response'),
            array('type' => 'parameter', 'value' => true)
        )
    ));

The service "response" (Phalcon\\Http\\Response) is resolved to be passed as the first argument of the constructor,
while the second is a boolean value (true) that is passed as it is.

设值注入（Setter Injection）
^^^^^^^^^^^^^^^^
Classes may have setters to inject optional dependencies, our previous class can be changed to accept the dependencies with setters:

.. code-block:: php

    <?php

    namespace SomeApp;

    use Phalcon\Http\Response;

    class SomeComponent
    {

        protected $_response;

        protected $_someFlag;

        public function setResponse(Response $response)
        {
            $this->_response = $response;
        }

        public function setFlag($someFlag)
        {
            $this->_someFlag = $someFlag;
        }

    }

A service with setter injection can be registered as follows:

.. code-block:: php

    <?php

    $di->set('response', array(
        'className' => 'Phalcon\Http\Response'
    ));

    $di->set('someComponent', array(
        'className' => 'SomeApp\SomeComponent',
        'calls' => array(
            array(
                'method' => 'setResponse',
                'arguments' => array(
                    array('type' => 'service', 'name' => 'response'),
                )
            ),
            array(
                'method' => 'setFlag',
                'arguments' => array(
                    array('type' => 'parameter', 'value' => true)
                )
            )
        )
    ));

属性注入（Properties Injection）
^^^^^^^^^^^^^^^^^^^^
A less common strategy is to inject dependencies or parameters directly into public attributes of the class:

.. code-block:: php

    <?php

    namespace SomeApp;

    use Phalcon\Http\Response;

    class SomeComponent
    {

        public $response;

        public $someFlag;

    }

A service with properties injection can be registered as follows:

.. code-block:: php

    <?php

    $di->set('response', array(
        'className' => 'Phalcon\Http\Response'
    ));

    $di->set('someComponent', array(
        'className' => 'SomeApp\SomeComponent',
        'properties' => array(
            array(
                'name' => 'response',
                'value' => array('type' => 'service', 'name' => 'response')
            ),
            array(
                'name' => 'someFlag',
                'value' => array('type' => 'parameter', 'value' => true)
            )
        )
    ));

Supported parameter types include the following:

+-------------+----------------------------------------------------------+-------------------------------------------------------------------------------------+
| Type        | Description                                              | Example                                                                             |
+=============+==========================================================+=====================================================================================+
| parameter   | Represents a literal value to be passed as parameter     | array('type' => 'parameter', 'value' => 1234)                                       |
+-------------+----------------------------------------------------------+-------------------------------------------------------------------------------------+
| service     | Represents another service in the service container      | array('type' => 'service', 'name' => 'request')                                     |
+-------------+----------------------------------------------------------+-------------------------------------------------------------------------------------+
| instance    | Represents an object that must be built dynamically      | array('type' => 'instance', 'className' => 'DateTime', 'arguments' => array('now')) |
+-------------+----------------------------------------------------------+-------------------------------------------------------------------------------------+

Resolving a service whose definition is complex may be slightly slower than simple definitions seen previously. However,
these provide a more robust approach to define and inject services.

Mixing different types of definitions is allowed, everyone can decide what is the most appropriate way to register the services
according to the application needs.

服务解疑（Resolving Services）
==================
Obtaining a service from the container is a matter of simply calling the “get” method. A new instance of the service will be returned:

.. code-block:: php

    <?php $request = $di->get("request");

Or by calling through the magic method:

.. code-block:: php

    <?php

    $request = $di->getRequest();

Or using the array-access syntax:

.. code-block:: php

    <?php

    $request = $di['request'];

Arguments can be passed to the constructor by adding an array parameter to the method "get":

.. code-block:: php

    <?php

    // new MyComponent("some-parameter", "other")
    $component = $di->get("MyComponent", array("some-parameter", "other"));

共享服务（Shared services）
===============
Services can be registered as "shared" services this means that they always will act as singletons_. Once the service is resolved for the first time
the same instance of it is returned every time a consumer retrieve the service from the container:

.. code-block:: php

    <?php

    //Register the session service as "always shared"
    $di->setShared('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

    $session = $di->get('session'); // Locates the service for the first time
    $session = $di->getSession(); // Returns the first instantiated object

An alternative way to register shared services is to pass "true" as third parameter of "set":

.. code-block:: php

    <?php

    //Register the session service as "always shared"
    $di->set('session', function() {
        //...
    }, true);

If a service isn't registered as shared and you want to be sure that a shared instance will be accessed every time
the service is obtained from the DI, you can use the 'getShared' method:

.. code-block:: php

    <?php

    $request = $di->getShared("request");

单独操作服务（Manipulating services individually）
==================================
Once a service is registered in the service container, you can retrieve it to manipulate it individually:

.. code-block:: php

    <?php

    //Register the "register" service
    $di->set('request', 'Phalcon\Http\Request');

    //Get the service
    $requestService = $di->getService('request');

    //Change its definition
    $requestService->setDefinition(function() {
        return new Phalcon\Http\Request();
    });

    //Change it to shared
    $requestService->setShared(true);

    //Resolve the service (return a Phalcon\Http\Request instance)
    $request = $requestService->resolve();

通过服务容器实例化类（Instantiating classes via the Service Container）
===============================================
When you request a service to the service container, if it can't find out a service with the same name it'll try to load a class with
the same name. With this behavior we can replace any class by another simply by registering a service with its name:

.. code-block:: php

    <?php

    //Register a controller as a service
    $di->set('IndexController', function() {
        $component = new Component();
        return $component;
    }, true);

    //Register a controller as a service
    $di->set('MyOtherComponent', function() {
        //Actually returns another component
        $component = new AnotherComponent();
        return $component;
    });

    //Create an instance via the service container
    $myComponent = $di->get('MyOtherComponent');

You can take advantage of this, always instantiating your classes via the service container (even if they aren't registered as services). The DI will
fallback to a valid autoloader to finally load the class. By doing this, you can easily replace any class in the future by implementing a definition
for it.

自动注入 DI（Automatic Injecting of the DI itself）
====================================
If a class or component requires the DI itself to locate services, the DI can automatically inject itself to the instances it creates,
to do this, you need to implement the :doc:`Phalcon\\DI\\InjectionAwareInterface <../api/Phalcon_DI_InjectionAwareInterface>` in your classes:

.. code-block:: php

    <?php

    class MyClass implements \Phalcon\DI\InjectionAwareInterface
    {

        protected $_di;

        public function setDi($di)
        {
            $this->_di = $di;
        }

        public function getDi()
        {
            return $this->_di;
        }

    }

Then once the service is resolved, the $di will be passed to setDi automatically:

.. code-block:: php

    <?php

    //Register the service
    $di->set('myClass', 'MyClass');

    //Resolve the service (NOTE: $myClass->setDi($di) is automatically called)
    $myClass = $di->get('myClass');

避免服务解析（Avoiding service resolution）
===========================
Some services are used in each of the requests made to the application, eliminate the process of resolving the service
could add some small improvement in performance.

.. code-block:: php

    <?php

    //Resolve the object externally instead of using a definition for it:
    $router = new MyRouter();

    //Pass the resolved object to the service registration
    $di->set('router', $router);

使用文件组织服务（Organizing services in files）
============================
You can better organize your application by moving the service registration to individual files instead of
doing everything in the application's bootstrap:

.. code-block:: php

    <?php

    $di->set('router', function() {
        return include "../app/config/routes.php";
    });

Then in the file ("../app/config/routes.php") return the object resolved:

.. code-block:: php

    <?php

    $router = new MyRouter();

    $router->post('/login');

    return $router;

使用静态的方式访问注入器（Accessing the DI in a static way）
================================
If needed you can access the latest DI created in a static function in the following way:

.. code-block:: php

    <?php

    class SomeComponent
    {

        public static function someMethod()
        {
            //Get the session service
            $session = Phalcon\DI::getDefault()->getSession();
        }

    }

注入器默认工厂（Factory Default DI）
==================
Although the decoupled character of Phalcon offers us great freedom and flexibility, maybe we just simply want to use it as a full-stack
framework. To achieve this, the framework provides a variant of Phalcon\\DI called Phalcon\\DI\\FactoryDefault. This class automatically
registers the appropriate services bundled with the framework to act as full-stack.

.. code-block:: php

    <?php $di = new Phalcon\DI\FactoryDefault();

服务名称约定（Service Name Conventions）
========================
Although you can register services with the names you want, Phalcon has a several naming conventions that allow it to get the
the correct (built-in) service when you need it.

+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| Service Name        | Description                                 | Default                                                                                            | Shared |
+=====================+=============================================+====================================================================================================+========+
| dispatcher          | Controllers Dispatching Service             | :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>`                                    | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| router              | Routing Service                             | :doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>`                                            | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| url                 | URL Generator Service                       | :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>`                                                  | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| request             | HTTP Request Environment Service            | :doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>`                                        | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| response            | HTTP Response Environment Service           | :doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>`                                      | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| cookies             | HTTP Cookies Management Service             | :doc:`Phalcon\\Http\\Response\\Cookies <../api/Phalcon_Http_Response_Cookies>`                     | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| filter              | Input Filtering Service                     | :doc:`Phalcon\\Filter <../api/Phalcon_Filter>`                                                     | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| flash               | Flash Messaging Service                     | :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>`                                        | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| flashSession        | Flash Session Messaging Service             | :doc:`Phalcon\\Flash\\Session <../api/Phalcon_Flash_Session>`                                      | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| session             | Session Service                             | :doc:`Phalcon\\Session\\Adapter\\Files <../api/Phalcon_Session_Adapter_Files>`                     | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| eventsManager       | Events Management Service                   | :doc:`Phalcon\\Events\\Manager <../api/Phalcon_Events_Manager>`                                    | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| db                  | Low-Level Database Connection Service       | :doc:`Phalcon\\Db <../api/Phalcon_Db>`                                                             | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| security            | Security helpers                            | :doc:`Phalcon\\Security <../api/Phalcon_Security>`                                                 | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| crypt               | Encrypt/Decrypt data                        | :doc:`Phalcon\\Crypt <../api/Phalcon_Crypt>`                                                       | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| tag                 | HTML generation helpers                     | :doc:`Phalcon\\Tag <../api/Phalcon_Tag>`                                                           | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| escaper             | Contextual Escaping                         | :doc:`Phalcon\\Escaper <../api/Phalcon_Escaper>`                                                   | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| annotations         | Annotations Parser                          | :doc:`Phalcon\\Annotations\\Adapter\\Memory <../api/Phalcon_Annotations_Adapter_Memory>`           | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| modelsManager       | Models Management Service                   | :doc:`Phalcon\\Mvc\\Model\\Manager <../api/Phalcon_Mvc_Model_Manager>`                             | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| modelsMetadata      | Models Meta-Data Service                    | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Memory <../api/Phalcon_Mvc_Model_MetaData_Memory>`            | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| transactionManager  | Models Transaction Manager Service          | :doc:`Phalcon\\Mvc\\Model\\Transaction\\Manager <../api/Phalcon_Mvc_Model_Transaction_Manager>`    | Yes    |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| modelsCache         | Cache backend for models cache              | None                                                                                               | -      |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| viewsCache          | Cache backend for views fragments           | None                                                                                               | -      |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+

自定义注入器（Implementing your own DI）
========================
The :doc:`Phalcon\\DiInterface <../api/Phalcon_DiInterface>` interface must be implemented to create your own DI replacing the one provided by Phalcon or extend the current one.

.. _`Inversion of Control`: http://en.wikipedia.org/wiki/Inversion_of_control
.. _Singletons: http://en.wikipedia.org/wiki/Singleton_pattern
