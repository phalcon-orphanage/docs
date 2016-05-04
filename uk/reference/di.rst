Dependency Injection/Service Location
*************************************

The following example is a bit lengthy, but it attempts to explain why Phalcon uses service location and dependency injection.
First, let's pretend we are developing a component called SomeComponent. This performs a task that is not important now.
Our component has some dependency that is a connection to a database.

In this first example, the connection is created inside the component. This approach is impractical; due to the fact
we cannot change the connection parameters or the type of database system because the component only works as created.

.. code-block:: php

    <?php

    class SomeComponent
    {
        /**
         * The instantiation of the connection is hardcoded inside
         * the component, therefore it's difficult replace it externally
         * or change its behavior
         */
        public function someDbTask()
        {
            $connection = new Connection(
                array(
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo"
                )
            );

            // ...
        }
    }

    $some = new SomeComponent();
    $some->someDbTask();

To solve this, we have created a setter that injects the dependency externally before using it. For now, this seems to be
a good solution:

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

    // Create the connection
    $connection = new Connection(
        array(
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo"
        )
    );

    // Inject the connection in the component
    $some->setConnection($connection);

    $some->someDbTask();

Now consider that we use this component in different parts of the application and
then we will need to create the connection several times before passing it to the component.
Using some kind of global registry where we obtain the connection instance and not have
to create it again and again could solve this:

.. code-block:: php

    <?php

    class Registry
    {
        /**
         * Returns the connection
         */
        public static function getConnection()
        {
            return new Connection(
                array(
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo"
                )
            );
        }
    }

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

    // Pass the connection defined in the registry
    $some->setConnection(Registry::getConnection());

    $some->someDbTask();

Now, let's imagine that we must implement two methods in the component, the first always needs to create a new connection and the second always needs to use a shared connection:

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
            return new Connection(
                array(
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo"
                )
            );
        }

        /**
         * Creates a connection only once and returns it
         */
        public static function getSharedConnection()
        {
            if (self::$_connection===null) {
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
        public function setConnection($connection)
        {
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

    // This injects the shared connection
    $some->setConnection(Registry::getSharedConnection());

    $some->someDbTask();

    // Here, we always pass a new connection as parameter
    $some->someOtherDbTask(Registry::getNewConnection());

So far we have seen how dependency injection solved our problems. Passing dependencies as arguments instead
of creating them internally in the code makes our application more maintainable and decoupled. However, in the long-term,
this form of dependency injection has some disadvantages.

For instance, if the component has many dependencies, we will need to create multiple setter arguments to pass
the dependencies or create a constructor that pass them with many arguments, additionally creating dependencies
before using the component, every time, makes our code not as maintainable as we would like:

.. code-block:: php

    <?php

    // Create the dependencies or retrieve them from the registry
    $connection = new Connection();
    $session    = new Session();
    $fileSystem = new FileSystem();
    $filter     = new Filter();
    $selector   = new Selector();

    // Pass them as constructor parameters
    $some = new SomeComponent($connection, $session, $fileSystem, $filter, $selector);

    // ... Or using setters

    $some->setConnection($connection);
    $some->setSession($session);
    $some->setFileSystem($fileSystem);
    $some->setFilter($filter);
    $some->setSelector($selector);

Think if we had to create this object in many parts of our application. In the future, if we do not require any of the dependencies,
we need to go through the entire code base to remove the parameter in any constructor or setter where we injected the code. To solve this,
we return again to a global registry to create the component. However, it adds a new layer of abstraction before creating
the object:

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

Now we find ourselves back where we started, we are again building the dependencies inside of the component! We must find a solution that
keeps us from repeatedly falling into bad practices.

A practical and elegant way to solve these problems is using a container for dependencies. The containers act as the global registry that
we saw earlier. Using the container for dependencies as a bridge to obtain the dependencies allows us to reduce the complexity
of our component:

.. code-block:: php

    <?php

    use Phalcon\Di;

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

            // This method also requires an input filtering service
            $filter = $this->_di->get('filter');
        }
    }

    $di = new Di();

    // Register a "db" service in the container
    $di->set('db', function () {
        return new Connection(
            array(
                "host"     => "localhost",
                "username" => "root",
                "password" => "secret",
                "dbname"   => "invo"
            )
        );
    });

    // Register a "filter" service in the container
    $di->set('filter', function () {
        return new Filter();
    });

    // Register a "session" service in the container
    $di->set('session', function () {
        return new Session();
    });

    // Pass the service container as unique parameter
    $some = new SomeComponent($di);

    $some->someDbTask();

The component can now simply access the service it requires when it needs it, if it does not require a service it is not even initialized,
saving resources. The component is now highly decoupled. For example, we can replace the manner in which connections are created,
their behavior or any other aspect of them and that would not affect the component.

Our approach
============
:doc:`Phalcon\\Di <../api/Phalcon_Di>` is a component implementing Dependency Injection and Location of services and it's itself a container for them.

Since Phalcon is highly decoupled, :doc:`Phalcon\\Di <../api/Phalcon_Di>` is essential to integrate the different components of the framework. The developer can
also use this component to inject dependencies and manage global instances of the different classes used in the application.

Basically, this component implements the `Inversion of Control`_ pattern. Applying this, the objects do not receive their dependencies
using setters or constructors, but requesting a service dependency injector. This reduces the overall complexity since there is only
one way to get the required dependencies within a component.

Additionally, this pattern increases testability in the code, thus making it less prone to errors.

Registering services in the Container
=====================================
The framework itself or the developer can register services. When a component A requires component B (or an instance of its class) to operate, it
can request component B from the container, rather than creating a new instance component B.

This way of working gives us many advantages:

* We can easily replace a component with one created by ourselves or a third party.
* We have full control of the object initialization, allowing us to set these objects, as needed before delivering them to components.
* We can get global instances of components in a structured and unified way.

Services can be registered using several types of definitions:

.. code-block:: php

    <?php

    use Phalcon\Http\Request;

    // Create the Dependency Injector Container
    $di = new Phalcon\Di();

    // By its class name
    $di->set("request", 'Phalcon\Http\Request');

    // Using an anonymous function, the instance will be lazy loaded
    $di->set("request", function () {
        return new Request();
    });

    // Registering an instance directly
    $di->set("request", new Request());

    // Using an array definition
    $di->set(
        "request",
        array(
            "className" => 'Phalcon\Http\Request'
        )
    );

The array syntax is also allowed to register services:

.. code-block:: php

    <?php

    use Phalcon\Http\Request;

    // Create the Dependency Injector Container
    $di = new Phalcon\Di();

    // By its class name
    $di["request"] = 'Phalcon\Http\Request';

    // Using an anonymous function, the instance will be lazy loaded
    $di["request"] = function () {
        return new Request();
    };

    // Registering an instance directly
    $di["request"] = new Request();

    // Using an array definition
    $di["request"] = array(
        "className" => 'Phalcon\Http\Request'
    );

In the examples above, when the framework needs to access the request data, it will ask for the service identified as ‘request’ in the container.
The container in turn will return an instance of the required service. A developer might eventually replace a component when he/she needs.

Each of the methods (demonstrated in the examples above) used to set/register a service has advantages and disadvantages. It is up to the
developer and the particular requirements that will designate which one is used.

Setting a service by a string is simple, but lacks flexibility. Setting services using an array offers a lot more flexibility, but makes the
code more complicated. The lambda function is a good balance between the two, but could lead to more maintenance than one would expect.

:doc:`Phalcon\\Di <../api/Phalcon_Di>` offers lazy loading for every service it stores. Unless the developer chooses to instantiate an object directly and store it
in the container, any object stored in it (via array, string, etc.) will be lazy loaded i.e. instantiated only when requested.

Simple Registration
-------------------
As seen before, there are several ways to register services. These we call simple:

String
^^^^^^
This type expects the name of a valid class, returning an object of the specified class, if the class is not loaded it will be instantiated using an auto-loader.
This type of definition does not allow to specify arguments for the class constructor or parameters:

.. code-block:: php

    <?php

    // Return new Phalcon\Http\Request();
    $di->set('request', 'Phalcon\Http\Request');

Object
^^^^^^
This type expects an object. Due to the fact that object does not need to be resolved as it is
already an object, one could say that it is not really a dependency injection,
however it is useful if you want to force the returned dependency to always be
the same object/value:

.. code-block:: php

    <?php

    use Phalcon\Http\Request;

    // Return new Phalcon\Http\Request();
    $di->set('request', new Request());

Closures/Anonymous functions
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
This method offers greater freedom to build the dependency as desired, however, it is difficult to
change some of the parameters externally without having to completely change the definition of dependency:

.. code-block:: php

    <?php

    use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

    $di->set("db", function () {
        return new PdoMysql(
            array(
                "host"     => "localhost",
                "username" => "root",
                "password" => "secret",
                "dbname"   => "blog"
            )
        );
    });

Some of the limitations can be overcome by passing additional variables to the closure's environment:

.. code-block:: php

    <?php

    use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

    // Using the $config variable in the current scope
    $di->set("db", function () use ($config) {
        return new PdoMysql(
            array(
                "host"     => $config->host,
                "username" => $config->username,
                "password" => $config->password,
                "dbname"   => $config->name
            )
        );
    });

Complex Registration
--------------------
If it is required to change the definition of a service without instantiating/resolving the service,
then, we need to define the services using the array syntax. Define a service using an array definition
can be a little more verbose:

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as LoggerFile;

    // Register a service 'logger' with a class name and its parameters
    $di->set('logger', array(
        'className' => 'Phalcon\Logger\Adapter\File',
        'arguments' => array(
            array(
                'type'  => 'parameter',
                'value' => '../apps/logs/error.log'
            )
        )
    ));

    // Using an anonymous function
    $di->set('logger', function () {
        return new LoggerFile('../apps/logs/error.log');
    });

Both service registrations above produce the same result. The array definition however, allows for alteration of the service parameters if needed:

.. code-block:: php

    <?php

    // Change the service class name
    $di->getService('logger')->setClassName('MyCustomLogger');

    // Change the first parameter without instantiating the logger
    $di->getService('logger')->setParameter(0, array(
        'type'  => 'parameter',
        'value' => '../apps/logs/error.log'
    ));

In addition by using the array syntax you can use three types of dependency injection:

Constructor Injection
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

The service "response" (:doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>`) is resolved to be passed as the first argument of the constructor,
while the second is a boolean value (true) that is passed as it is.

Setter Injection
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

    $di->set(
        'someComponent',
        array(
            'className' => 'SomeApp\SomeComponent',
            'calls'     => array(
                array(
                    'method'    => 'setResponse',
                    'arguments' => array(
                        array(
                            'type' => 'service',
                            'name' => 'response'
                        )
                    )
                ),
                array(
                    'method'    => 'setFlag',
                    'arguments' => array(
                        array(
                            'type'  => 'parameter',
                            'value' => true
                        )
                    )
                )
            )
        )
    );

Properties Injection
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

    $di->set(
        'response',
        array(
            'className' => 'Phalcon\Http\Response'
        )
    );

    $di->set(
        'someComponent',
        array(
            'className'  => 'SomeApp\SomeComponent',
            'properties' => array(
                array(
                    'name'  => 'response',
                    'value' => array(
                        'type' => 'service',
                        'name' => 'response'
                    )
                ),
                array(
                    'name'  => 'someFlag',
                    'value' => array(
                        'type'  => 'parameter',
                        'value' => true
                    )
                )
            )
        )
    );

Supported parameter types include the following:

+-------------+----------------------------------------------------------+---------------------------------------------------------------------------------------------+
| Type        | Description                                              | Example                                                                                     |
+=============+==========================================================+=============================================================================================+
| parameter   | Represents a literal value to be passed as parameter     | :code:`array('type' => 'parameter', 'value' => 1234)`                                       |
+-------------+----------------------------------------------------------+---------------------------------------------------------------------------------------------+
| service     | Represents another service in the service container      | :code:`array('type' => 'service', 'name' => 'request')`                                     |
+-------------+----------------------------------------------------------+---------------------------------------------------------------------------------------------+
| instance    | Represents an object that must be built dynamically      | :code:`array('type' => 'instance', 'className' => 'DateTime', 'arguments' => array('now'))` |
+-------------+----------------------------------------------------------+---------------------------------------------------------------------------------------------+

Resolving a service whose definition is complex may be slightly slower than simple definitions seen previously. However,
these provide a more robust approach to define and inject services.

Mixing different types of definitions is allowed, everyone can decide what is the most appropriate way to register the services
according to the application needs.

Resolving Services
==================
Obtaining a service from the container is a matter of simply calling the "get" method. A new instance of the service will be returned:

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

Events
------
:doc:`Phalcon\\Di <../api/Phalcon_Di>` is able to send events to an :doc:`EventsManager <events>` if it is present.
Events are triggered using the type "di". Some events when returning boolean false could stop the active operation.
The following events are supported:

+----------------------+---------------------------------------------------------------------------------------------------------------------------------+---------------------+--------------------+
| Event Name           | Triggered                                                                                                                       | Can stop operation? | Triggered on       |
+======================+=================================================================================================================================+=====================+====================+
| beforeServiceResolve | Triggered before resolve service. Listeners receive the service name and the parameters passed to it.                           | No                  | Listeners          |
+----------------------+---------------------------------------------------------------------------------------------------------------------------------+---------------------+--------------------+
| afterServiceResolve  | Triggered after resolve service. Listeners receive the service name, instance, and the parameters passed to it.                 | No                  | Listeners          |
+----------------------+---------------------------------------------------------------------------------------------------------------------------------+---------------------+--------------------+

Shared services
===============
Services can be registered as "shared" services this means that they always will act as singletons_. Once the service is resolved for the first time
the same instance of it is returned every time a consumer retrieve the service from the container:

.. code-block:: php

    <?php

    use Phalcon\Session\Adapter\Files as SessionFiles;

    // Register the session service as "always shared"
    $di->setShared('session', function () {
        $session = new SessionFiles();
        $session->start();
        return $session;
    });

    $session = $di->get('session'); // Locates the service for the first time
    $session = $di->getSession();   // Returns the first instantiated object

An alternative way to register shared services is to pass "true" as third parameter of "set":

.. code-block:: php

    <?php

    // Register the session service as "always shared"
    $di->set('session', function () {
        // ...
    }, true);

If a service isn't registered as shared and you want to be sure that a shared instance will be accessed every time
the service is obtained from the DI, you can use the 'getShared' method:

.. code-block:: php

    <?php

    $request = $di->getShared("request");

Manipulating services individually
==================================
Once a service is registered in the service container, you can retrieve it to manipulate it individually:

.. code-block:: php

    <?php

    use Phalcon\Http\Request;

    // Register the "request" service
    $di->set('request', 'Phalcon\Http\Request');

    // Get the service
    $requestService = $di->getService('request');

    // Change its definition
    $requestService->setDefinition(function () {
        return new Request();
    });

    // Change it to shared
    $requestService->setShared(true);

    // Resolve the service (return a Phalcon\Http\Request instance)
    $request = $requestService->resolve();

Instantiating classes via the Service Container
===============================================
When you request a service to the service container, if it can't find out a service with the same name it'll try to load a class with
the same name. With this behavior we can replace any class by another simply by registering a service with its name:

.. code-block:: php

    <?php

    // Register a controller as a service
    $di->set('IndexController', function () {
        $component = new Component();
        return $component;
    }, true);

    // Register a controller as a service
    $di->set('MyOtherComponent', function () {
        // Actually returns another component
        $component = new AnotherComponent();
        return $component;
    });

    // Create an instance via the service container
    $myComponent = $di->get('MyOtherComponent');

You can take advantage of this, always instantiating your classes via the service container (even if they aren't registered as services). The DI will
fallback to a valid autoloader to finally load the class. By doing this, you can easily replace any class in the future by implementing a definition
for it.

Automatic Injecting of the DI itself
====================================
If a class or component requires the DI itself to locate services, the DI can automatically inject itself to the instances it creates,
to do this, you need to implement the :doc:`Phalcon\\Di\\InjectionAwareInterface <../api/Phalcon_Di_InjectionAwareInterface>` in your classes:

.. code-block:: php

    <?php

    use Phalcon\Di\InjectionAwareInterface;

    class MyClass implements InjectionAwareInterface
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

Then once the service is resolved, the :code:`$di` will be passed to :code:`setDi()` automatically:

.. code-block:: php

    <?php

    // Register the service
    $di->set('myClass', 'MyClass');

    // Resolve the service (NOTE: $myClass->setDi($di) is automatically called)
    $myClass = $di->get('myClass');

Avoiding service resolution
===========================
Some services are used in each of the requests made to the application, eliminate the process of resolving the service
could add some small improvement in performance.

.. code-block:: php

    <?php

    // Resolve the object externally instead of using a definition for it
    $router = new MyRouter();

    // Pass the resolved object to the service registration
    $di->set('router', $router);

Organizing services in files
============================
You can better organize your application by moving the service registration to individual files instead of
doing everything in the application's bootstrap:

.. code-block:: php

    <?php

    $di->set('router', function () {
        return include "../app/config/routes.php";
    });

Then in the file ("../app/config/routes.php") return the object resolved:

.. code-block:: php

    <?php

    $router = new MyRouter();

    $router->post('/login');

    return $router;

Accessing the DI in a static way
================================
If needed you can access the latest DI created in a static function in the following way:

.. code-block:: php

    <?php

    use Phalcon\Di;

    class SomeComponent
    {
        public static function someMethod()
        {
            // Get the session service
            $session = Di::getDefault()->getSession();
        }
    }

Factory Default DI
==================
Although the decoupled character of Phalcon offers us great freedom and flexibility, maybe we just simply want to use it as a full-stack
framework. To achieve this, the framework provides a variant of :doc:`Phalcon\\Di <../api/Phalcon_Di>` called :doc:`Phalcon\\Di\\FactoryDefault <../api/Phalcon_Di_FactoryDefault>`. This class automatically
registers the appropriate services bundled with the framework to act as full-stack.

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault;

    $di = new FactoryDefault();

Service Name Conventions
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
| modelsCache         | Cache backend for models cache              | None                                                                                               | No     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| viewsCache          | Cache backend for views fragments           | None                                                                                               | No     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+

Implementing your own DI
========================
The :doc:`Phalcon\\DiInterface <../api/Phalcon_DiInterface>` interface must be implemented to create your own DI replacing the one provided by Phalcon or extend the current one.

.. _`Inversion of Control`: http://en.wikipedia.org/wiki/Inversion_of_control
.. _singletons: http://en.wikipedia.org/wiki/Singleton_pattern
