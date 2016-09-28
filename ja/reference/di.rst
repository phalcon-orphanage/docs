依存性の注入とサービス・ロケーション
************************************

.. highlights::

    Before reading this section, it is wise to read :doc:`the section which explains why Phalcon uses service location and dependency injection <di-explained>`.

:doc:`Phalcon\\Di <../api/Phalcon_Di>` は 依存性の注入や サービスの場所を実装するコンポーネントで、自分自身もコンテナです。

Phalconが高度に分離されているため、:doc:`Phalcon\\Di <../api/Phalcon_Di>` はフレームワークのさまざまなコンポーネントを統合することが不可欠です。開発者は、依存性を注入し、アプリケーションで使用されるさまざまなクラスのグローバルインスタンスを管理するには、このコンポーネントを使用することができます。

基本的には、このコンポーネントは、`コントロールの反転`パターンを実装しています。

基本的には、このコンポーネントは `Inversion of Control`_ パターンを実装しています。これを適用すると、オブジェクトは、その依存関係をセッターあるいはコンストラクタによって受け取るのではなく、サービスの依存性の注入を要求します。コンポーネント内の依存関係を得るための方法は一つだけですので、これによって全体的な複雑さが軽減されます。

加えて、このパターンによってコードがテストしやすくなり、エラーへの耐性が向上します。

サービスのコンテナへの登録
==========================
フレームワーク自身だけでなく、開発者も、サービスを登録することができます。コンポーネントAが動作するのにコンポーネントB(あるいはそのクラスのインスタンス)を必要とする場合、コンポーネントBの新しいインスタンスを作るのではなく、コンテナからコンポーネントBを取り出します。

このやり方には、大きな利点があります:

* コンポーネントの差し替えが容易になる。独自に実装したものからサードパーティ製への変更等。
* オブジェクトの初期化を完全にコントロールできる。コンポーネントが提供されるより前に、必要となるものをセットしておくことができる。
* コンポーネントのグローバルなインスタンスが、よく整理され、統一されたやり方で取得できる。

サービスの登録には複数の書き方があります:

簡単な登録
----------
As seen before, there are several ways to register services. These we call simple:

文字列
^^^^^^
This type expects the name of a valid class, returning an object of the specified class, if the class is not loaded it will be instantiated using an auto-loader.
This type of definition does not allow to specify arguments for the class constructor or parameters:

.. code-block:: php

    <?php

    // Return new Phalcon\Http\Request();
    $di->set(
        "request",
        "Phalcon\\Http\\Request"
    );

オブジェクト
^^^^^^^^^^^^
This type expects an object. Due to the fact that object does not need to be resolved as it is
already an object, one could say that it is not really a dependency injection,
however it is useful if you want to force the returned dependency to always be
the same object/value:

.. code-block:: php

    <?php

    use Phalcon\Http\Request;

    // Return new Phalcon\Http\Request();
    $di->set(
        "request",
        new Request()
    );

クロージャ／無名関数
^^^^^^^^^^^^^^^^^^^^
This method offers greater freedom to build the dependency as desired, however, it is difficult to
change some of the parameters externally without having to completely change the definition of dependency:

.. code-block:: php

    <?php

    use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

    $di->set(
        "db",
        function () {
            return new PdoMysql(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "blog",
                ]
            );
        }
    );

Some of the limitations can be overcome by passing additional variables to the closure's environment:

.. code-block:: php

    <?php

    use Phalcon\Config;
    use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

    $config = new Config(
        [
            "host"     => "127.0.0.1",
            "username" => "user",
            "password" => "pass",
            "dbname"   => "my_database",
        ]
    );

    // Using the $config variable in the current scope
    $di->set(
        "db",
        function () use ($config) {
            return new PdoMysql(
                [
                    "host"     => $config->host,
                    "username" => $config->username,
                    "password" => $config->password,
                    "dbname"   => $config->name,
                ]
            );
        }
    );

You can also access other DI services using the :code:`get()` method:

.. code-block:: php

    <?php

    use Phalcon\Config;
    use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

    $di->set(
        "config",
        function () {
            return new Config(
                [
                    "host"     => "127.0.0.1",
                    "username" => "user",
                    "password" => "pass",
                    "dbname"   => "my_database",
                ]
            );
        }
    );

    // Using the 'config' service from the DI
    $di->set(
        "db",
        function () {
            $config = $this->get("config");

            return new PdoMysql(
                [
                    "host"     => $config->host,
                    "username" => $config->username,
                    "password" => $config->password,
                    "dbname"   => $config->name,
                ]
            );
        }
    );

複雑な登録
----------
If it is required to change the definition of a service without instantiating/resolving the service,
then, we need to define the services using the array syntax. Define a service using an array definition
can be a little more verbose:

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as LoggerFile;

    // Register a service 'logger' with a class name and its parameters
    $di->set(
        "logger",
        [
            "className" => "Phalcon\\Logger\\Adapter\\File",
            "arguments" => [
                [
                    "type"  => "parameter",
                    "value" => "../apps/logs/error.log",
                ]
            ]
        ]
    );

    // Using an anonymous function
    $di->set(
        "logger",
        function () {
            return new LoggerFile("../apps/logs/error.log");
        }
    );

Both service registrations above produce the same result. The array definition however, allows for alteration of the service parameters if needed:

.. code-block:: php

    <?php

    // Change the service class name
    $di->getService("logger")->setClassName("MyCustomLogger");

    // Change the first parameter without instantiating the logger
    $di->getService("logger")->setParameter(
        0,
        [
            "type"  => "parameter",
            "value" => "../apps/logs/error.log",
        ]
    );

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
        /**
         * @var Response
         */
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

    $di->set(
        "response",
        [
            "className" => "Phalcon\\Http\\Response"
        ]
    );

    $di->set(
        "someComponent",
        [
            "className" => "SomeApp\\SomeComponent",
            "arguments" => [
                [
                    "type" => "service",
                    "name" => "response",
                ],
                [
                    "type"  => "parameter",
                    "value" => true,
                ],
            ]
        ]
    );

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
        /**
         * @var Response
         */
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

    $di->set(
        "response",
        [
            "className" => "Phalcon\\Http\\Response",
        ]
    );

    $di->set(
        "someComponent",
        [
            "className" => "SomeApp\\SomeComponent",
            "calls"     => [
                [
                    "method"    => "setResponse",
                    "arguments" => [
                        [
                            "type" => "service",
                            "name" => "response",
                        ]
                    ]
                ],
                [
                    "method"    => "setFlag",
                    "arguments" => [
                        [
                            "type"  => "parameter",
                            "value" => true,
                        ]
                    ]
                ]
            ]
        ]
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
        /**
         * @var Response
         */
        public $response;

        public $someFlag;
    }

A service with properties injection can be registered as follows:

.. code-block:: php

    <?php

    $di->set(
        "response",
        [
            "className" => "Phalcon\\Http\\Response",
        ]
    );

    $di->set(
        "someComponent",
        [
            "className"  => "SomeApp\\SomeComponent",
            "properties" => [
                [
                    "name"  => "response",
                    "value" => [
                        "type" => "service",
                        "name" => "response",
                    ],
                ],
                [
                    "name"  => "someFlag",
                    "value" => [
                        "type"  => "parameter",
                        "value" => true,
                    ],
                ]
            ]
        ]
    );

Supported parameter types include the following:

+-------------+----------------------------------------------------------+-----------------------------------------------------------------------------------+
| Type        | Description                                              | Example                                                                           |
+=============+==========================================================+===================================================================================+
| parameter   | Represents a literal value to be passed as parameter     | :code:`["type" => "parameter", "value" => 1234]`                                  |
+-------------+----------------------------------------------------------+-----------------------------------------------------------------------------------+
| service     | Represents another service in the service container      | :code:`["type" => "service", "name" => "request"]`                                |
+-------------+----------------------------------------------------------+-----------------------------------------------------------------------------------+
| instance    | Represents an object that must be built dynamically      | :code:`["type" => "instance", "className" => "DateTime", "arguments" => ["now"]]` |
+-------------+----------------------------------------------------------+-----------------------------------------------------------------------------------+

Resolving a service whose definition is complex may be slightly slower than simple definitions seen previously. However,
these provide a more robust approach to define and inject services.

Mixing different types of definitions is allowed, everyone can decide what is the most appropriate way to register the services
according to the application needs.

Array Syntax
------------
配列の記法でサービスを登録することもできます:

.. code-block:: php

    <?php

    use Phalcon\Di;
    use Phalcon\Http\Request;

    // 依存性を注入するコンテナ（DIコンテナ）を作成する
    $di = new Di();

    // クラス名で登録
    $di["request"] = "Phalcon\\Http\\Request";

    // 無名関数を使うと、インスタンスは遅延読み込みされる
    $di["request"] = function () {
        return new Request();
    };

    // インスタンスを直接登録する
    $di["request"] = new Request();

    // 配列で登録
    $di["request"] = [
        "className" => "Phalcon\\Http\\Request",
    ];

上記例では、フレームワークがリクエストのデータへのアクセスが必要になった時、コンテナの'request'という名前のサービスを求めます。コンテナは要求されたサービスのインスタンスを返します。開発者は、結果として、必要とするコンポーネントを置き換えることができます。

(上記例で使用された) サービス登録方法には、それぞれに利点と欠点があります。どの方法を使うかは、必要に応じて、開発者が決定します。

文字列でのサービス登録は、シンプルですが、柔軟性に欠けます。配列でのサービス登録は、より柔軟ですが、コードが複雑になります。無名関数にはこの2つの中間的なバランスの良さがありますが、意外とメンテナンスが大変です。

:doc:`Phalcon\\Di <../api/Phalcon_Di>` は全てのサービスを遅延読み込みします。開発者がオブジェクトを直接初期化してコンテナに入れようとしない限り、コンテナに格納されるあらゆるオブジェクトは、(その登録方法がどのような方法であっても)遅延読み込みされ、要求されるまではインスタンス化されません。

サービスの解決
==============
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

    $request = $di["request"];

Arguments can be passed to the constructor by adding an array parameter to the method "get":

.. code-block:: php

    <?php

    // new MyComponent("some-parameter", "other")
    $component = $di->get(
        "MyComponent",
        [
            "some-parameter",
            "other",
        ]
    );

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

共有サービス
============
Services can be registered as "shared" services this means that they always will act as singletons_. Once the service is resolved for the first time
the same instance of it is returned every time a consumer retrieve the service from the container:

.. code-block:: php

    <?php

    use Phalcon\Session\Adapter\Files as SessionFiles;

    // Register the session service as "always shared"
    $di->setShared(
        "session",
        function () {
            $session = new SessionFiles();

            $session->start();

            return $session;
        }
    );

    // Locates the service for the first time
    $session = $di->get("session");

    // Returns the first instantiated object
    $session = $di->getSession();

An alternative way to register shared services is to pass "true" as third parameter of "set":

.. code-block:: php

    <?php

    // Register the session service as "always shared"
    $di->set(
        "session",
        function () {
            // ...
        },
        true
    );

If a service isn't registered as shared and you want to be sure that a shared instance will be accessed every time
the service is obtained from the DI, you can use the 'getShared' method:

.. code-block:: php

    <?php

    $request = $di->getShared("request");

個別のサービスの操作
====================
Once a service is registered in the service container, you can retrieve it to manipulate it individually:

.. code-block:: php

    <?php

    use Phalcon\Http\Request;

    // Register the "request" service
    $di->set("request", "Phalcon\\Http\\Request");

    // Get the service
    $requestService = $di->getService("request");

    // Change its definition
    $requestService->setDefinition(
        function () {
            return new Request();
        }
    );

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
    $di->set(
        "IndexController",
        function () {
            $component = new Component();

            return $component;
        },
        true
    );

    // Register a controller as a service
    $di->set(
        "MyOtherComponent",
        function () {
            // Actually returns another component
            $component = new AnotherComponent();

            return $component;
        }
    );

    // Create an instance via the service container
    $myComponent = $di->get("MyOtherComponent");

You can take advantage of this, always instantiating your classes via the service container (even if they aren't registered as services). The DI will
fallback to a valid autoloader to finally load the class. By doing this, you can easily replace any class in the future by implementing a definition
for it.

Automatic Injecting of the DI itself
====================================
If a class or component requires the DI itself to locate services, the DI can automatically inject itself to the instances it creates,
to do this, you need to implement the :doc:`Phalcon\\Di\\InjectionAwareInterface <../api/Phalcon_Di_InjectionAwareInterface>` in your classes:

.. code-block:: php

    <?php

    use Phalcon\DiInterface;
    use Phalcon\Di\InjectionAwareInterface;

    class MyClass implements InjectionAwareInterface
    {
        /**
         * @var DiInterface
         */
        protected $_di;



        public function setDi(DiInterface $di)
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
    $di->set("myClass", "MyClass");

    // Resolve the service (NOTE: $myClass->setDi($di) is automatically called)
    $myClass = $di->get("myClass");

Organizing services in files
============================
You can better organize your application by moving the service registration to individual files instead of
doing everything in the application's bootstrap:

.. code-block:: php

    <?php

    $di->set(
        "router",
        function () {
            return include "../app/config/routes.php";
        }
    );

Then in the file ("../app/config/routes.php") return the object resolved:

.. code-block:: php

    <?php

    $router = new MyRouter();

    $router->post("/login");

    return $router;

静的な方法でのDIへのアクセス
============================
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

サービス名の規約
================
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

独自のDIの実装
==============
The :doc:`Phalcon\\DiInterface <../api/Phalcon_DiInterface>` interface must be implemented to create your own DI replacing the one provided by Phalcon or extend the current one.

.. _`Inversion of Control`: http://ja.wikipedia.org/wiki/%E5%88%B6%E5%BE%A1%E3%81%AE%E5%8F%8D%E8%BB%A2
.. _singletons: http://ja.wikipedia.org/wiki/Singleton_%E3%83%91%E3%82%BF%E3%83%BC%E3%83%B3
