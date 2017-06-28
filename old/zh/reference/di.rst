依赖注入与服务定位器（Dependency Injection/Service Location）
*************************************************************

.. highlights::

    Before reading this section, it is wise to read :doc:`the section which explains why Phalcon uses service location and dependency injection <di-explained>`.

:doc:`Phalcon\\Di <../api/Phalcon_Di>` 是一个实现依赖注入和定位服务的组件，而且它本身就是一个装载它们的容器。

因为Phalcon是高度解构的，整合框架的不同组件，使用 :doc:`Phalcon\\Di <../api/Phalcon_Di>` 是必不可少的。开发者也可以使用这个组件去注入依赖和管理的应用程序中来自不同类的全局实例。

基本上，这个组件实现了 [控制反转](http://zh.wikipedia.org/wiki/%E6%8E%A7%E5%88%B6%E5%8F%8D%E8%BD%AC) 的模式。使用这种模式，组件的对象不用再使用setter或者构造函数去接受依赖实例，而是使用请求服务的依赖注入。这减少了总的复杂性，因为在组件内，只有一个方法去获取所需的依赖实例。

另外，该模式增加了代码的可测试性，从而使其不易出错。

使用容器注册服务（Registering services in the Container）
=========================================================
框架本身或者开发者都可以注册服务。当一个组件A需要组件B(或者它的类的实例) 去操作，它可以通过容器去请求组件B，而不是创建一个新的组件B实例。

这个工作方法给我们提供了许多优势：

* 我们可以很容易的使用一个我们自己建立的或者是第三方的组件去替换原有的组件。
* 我们完全控制对象的初始化，这让我们在传递它们的实例到组件之前，根据需要设置这些对象。
* 我们可以在一个结构化的和统一组件内获取全局实例。

服务可以使用不同方式去定义：

简单的注册（Simple Registration）
---------------------------------
就像你之前看到的那样，这里有几种方法去注册服务。下面是简单调用的例子：

字符串(String)
^^^^^^^^^^^^^^
使用字符串注册服务需要一个有效的类名称，它将返回指定的类对象，如果类还没有加载的话，将使用自动加载器实例化对象。这种类型不允许向构造函数指定参数：

.. code-block:: php

    <?php

    // 返回 new Phalcon\Http\Request(); 对象
    $di->set(
        "request",
        "Phalcon\\Http\\Request"
    );

类实例（CLASS INSTANCES）
^^^^^^^^^^^^^^^^^^^^^^^^^
这种类型注册服务需要一个对象。实际上，这个服务不再需要初始化，因为它已经是一个对象，可以说，这不是一个真正的依赖注入，但是如果你想强制总是返回相同的对象/值，使用这种方式还是有用的:

.. code-block:: php

    <?php

    use Phalcon\Http\Request;

    // 返回 Phalcon\Http\Request(); 对象
    $di->set(
        "request",
        new Request()
    );

闭包与匿名函数（Closures/Anonymous functions）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
这个方法提供了更加自由的方式去注册依赖，但是如果你想从外部改变实例化的参数而不用改变注册服务的代码，这是很困难的：

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

这些限制是可以克服的，通过传递额外的变量到闭包函数里面：

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

    // 把当前域的$config变量传递给匿名函数使用
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

复杂的注册（Complex Registration）
----------------------------------
如果要求不用实例化/解析服务，就可以改变定义服务的话，我们需要使用数组的方式去定义服务。使用数组去定义服务可以更加详细：

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as LoggerFile;

    // 通过类名和参数，注册logger服务
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

    // 使用匿名函数的方式
    $di->set(
        "logger",
        function () {
            return new LoggerFile("../apps/logs/error.log");
        }
    );

上面两种注册服务的方式的结果是一样的。然而，使用数组定义的话，在需要的时候可以变更注册服务的参数：

.. code-block:: php

    <?php

    // 改变logger服务的类名
    $di->getService("logger")->setClassName("MyCustomLogger");

    // 不用实例化就可以改变第一个参数值
    $di->getService("logger")->setParameter(
        0,
        [
            "type"  => "parameter",
            "value" => "../apps/logs/error.log",
        ]
    );

除了使用数组的语法注册服务，你还可以使用以下三种类型的依赖注入：

构造函数注入（Constructor Injection）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
这个注入方式是通过传递依赖/参数到类的构造函数。让我们假设我们有下面的组件：

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

这个服务可以这样被注入：

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

reponse服务(:doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>`)作为第一个参数传递给构造函数，与此同时，一个布尔类型的值(true)作为第二个参数传递。

设值注入（Setter Injection）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
类中可能有setter去注入可选的依赖，前面那个class可以修改成通过setter来注入依赖的方式：

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

用setter方式来注入的服务可以通过下面的方式来注册：

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

属性注入（Properties Injection）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
这是一个不太常用的方式，这种方式的注入是通过类的public属性来注入：

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

通过属性注入的服务，可以像下面这样注册：

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

支持包括下面的参数类型：

+-------------+--------------------------------+-----------------------------------------------------------------------------------+
| Type        | 描述                           | 例子                                                                              |
+=============+================================+===================================================================================+
| parameter   | 表示一个文本值作为参数传递过去 | :code:`["type" => "parameter", "value" => 1234]`                                  |
+-------------+--------------------------------+-----------------------------------------------------------------------------------+
| service     | 表示作为服务                   | :code:`["type" => "service", "name" => "request"]`                                |
+-------------+--------------------------------+-----------------------------------------------------------------------------------+
| instance    | 表示必须动态生成的对象         | :code:`["type" => "instance", "className" => "DateTime", "arguments" => ["now"]]` |
+-------------+--------------------------------+-----------------------------------------------------------------------------------+

解析一个定义复杂的服务也许性能上稍微慢于先前看到的简单定义。但是，这提供了一个更强大的方式来定义和注入服务。

混合不同类型的定义是可以的，每个人可以应用需要决定什么样的注册服务的方式是最适当的。

Array Syntax
------------
使用数组的方式去注册服务也是可以的：

.. code-block:: php

    <?php

    use Phalcon\Di;
    use Phalcon\Http\Request;

    // 创建一个依赖注入容器
    $di = new Di();

    // 通过类名称设置服务
    $di["request"] = "Phalcon\\Http\\Request";

    // 使用匿名函数去设置服务，这个实例将被延迟加载
    $di["request"] = function () {
        return new Request();
    };

    // 直接注册一个实例
    $di["request"] = new Request();

    // 使用数组方式定义服务
    $di["request"] = [
        "className" => "Phalcon\\Http\\Request",
    ];

在上面的例子中，当框架需要访问request服务的内容，它会在容器里面查找名为‘request’的服务。
在容器中将返回所需要的服务的实例。当有需要时，开发者可能最终需要替换这个组件。

每个方法（在上面的例子证明）用于设置/注册服务方面具都具有优势和劣势。这是由开发者和特别的要求决定具体使用哪个。

通过字符串设置一个服务是很简单，但是缺乏灵活性。通过数组设置服务提供了更加灵活的方式，但是使代码更复杂。匿名函数是上述两者之间的一个很好的平衡，但是会导致比预期的更多维护。

:doc:`Phalcon\\Di <../api/Phalcon_Di>` 对每个储存的服务提供了延迟加载。除非开发者选择直接实例化一个对象并将其存储在容器中，任何储存在里面的对象(通过数组，字符串等等设置的)都将延迟加载，即只要当使用到时才实例化。

服务解疑（Resolving Services）
==============================
从容器中获取一个服务是一件简单的事情，只要通过“get”方法就可以。这将返回一个服务的新实例：

.. code-block:: php

    <?php $request = $di->get("request");

或者通过魔术方法的方式获取：

.. code-block:: php

    <?php

    $request = $di->getRequest();

或者通过访问数组的方式获取：

.. code-block:: php

    <?php

    $request = $di["request"];

参数可以传递到构造函数中，通过添加一个数组的参数到get方法中：

.. code-block:: php

    <?php

    // 将返回：new MyComponent("some-parameter", "other")
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

共享服务（Shared services）
===========================
服务可以注册成“shared”类型的服务，这意味着这个服务将使用 [单例模式](http://zh.wikipedia.org/wiki/%E5%8D%95%E4%BE%8B%E6%A8%A1%E5%BC%8F) 运行，
一旦服务被首次解析后，这个实例将被保存在容器中，之后的每次请求都在容器中查找并返回这个实例

.. code-block:: php

    <?php

    use Phalcon\Session\Adapter\Files as SessionFiles;

    // 把session服务注册成“shared”类型
    $di->setShared(
        "session",
        function () {
            $session = new SessionFiles();

            $session->start();

            return $session;
        }
    );

    // 第一次获取session服务时，session服务将实例化
    $session = $di->get("session");

    // 第二次获取时，不再实例化，直接返回第一次实例化的对象
    $session = $di->getSession();

另一种方式去注册一个“shared”类型的服务是，传递“set”服务的时候，把true作为第三个参数传递过去：

.. code-block:: php

    <?php

    // 把session服务注册成“shared”类型
    $di->set(
        "session",
        function () {
            // ...
        },
        true
    );

如果一个服务不是注册成“shared”类型，而你又想从DI中获取服务的“shared”实例，你可以使用getShared方法：

.. code-block:: php

    <?php

    $request = $di->getShared("request");

单独操作服务（Manipulating services individually）
==================================================
一旦服务被注册到服务容器中，你可以单独操作它：

.. code-block:: php

    <?php

    use Phalcon\Http\Request;

    // 注册request服务
    $di->set("request", "Phalcon\\Http\\Request");

    // 获取服务
    $requestService = $di->getService("request");

    // 改变它的定义
    $requestService->setDefinition(
        function () {
            return new Request();
        }
    );

    // 修改成shared类型
    $requestService->setShared(true);

    // 解析服务（返回Phalcon\Http\Request实例）
    $request = $requestService->resolve();

通过服务容器实例化类（Instantiating classes via the Service Container）
=======================================================================
当你从服务容器中请求一个服务，如果找不到具有相同名称的服务，它将尝试去加载以这个服务为名称的类。利用这个的行为，
我们可以代替任意一个类，通过简单的利用服务的名称来注册：

.. code-block:: php

    <?php

    // 把一个控制器注册为服务
    $di->set(
        "IndexController",
        function () {
            $component = new Component();

            return $component;
        },
        true
    );

    // 把一个控制器注册为服务
    $di->set(
        "MyOtherComponent",
        function () {
            // 实际上返回另外一个组件
            $component = new AnotherComponent();

            return $component;
        }
    );

    // 获取通过服务容器创建的对象
    $myComponent = $di->get("MyOtherComponent");

你可以利用这种方式，通过服务容器来总是实例化你的类(即是他们没有注册为服务)，
DI会回退到一个有效的自动加载类中，去加载这个类。通过这样做，以后你可以轻松替换任意的类通过为它实现一个定义。

自动注入 DI（Automatic Injecting of the DI itself）
===================================================
如果一个类或者组件需要用到DI服务，你需要在你的类中实现 :doc:`Phalcon\\Di\\InjectionAwareInterface <../api/Phalcon_Di_InjectionAwareInterface>` 接口，
这样就可以在实例化这个类的对象时自动注入DI的服务:

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

按照上面这样，一旦服务被解析，:code:`$di` 对象将自动传递到 :code:`setDi()` 方法：

.. code-block:: php

    <?php

    // 注册服务
    $di->set("myClass", "MyClass");

    // 解析服务（注意：将自动调用$myClass->setDi($di)方法）
    $myClass = $di->get("myClass");

使用文件组织服务（Organizing services in files）
================================================
你可以更好的组织你的应用，通过移动注册的服务到独立的文件里面，而不是全部写在应用的引导文件中：

.. code-block:: php

    <?php

    $di->set(
        "router",
        function () {
            return include "../app/config/routes.php";
        }
    );

这样，在文件("../app/config/routes.php")中，返回已解析的对象：

.. code-block:: php

    <?php

    $router = new MyRouter();

    $router->post("/login");

    return $router;

使用静态的方式访问注入器（Accessing the DI in a static way）
============================================================
如果需要的话，你可以访问最新创建的DI对象，通过下面这种静态方法的方式：

.. code-block:: php

    <?php

    use Phalcon\Di;

    class SomeComponent
    {
        public static function someMethod()
        {
            // 获取session服务
            $session = Di::getDefault()->getSession();
        }
    }

注入器默认工厂（Factory Default DI）
====================================
尽管Phalcon的解耦性质为我们提供了很大的自由度和灵活性，也许我们只是单纯的想使用它作为一个全栈框架。
为了达到这点，框架提供了变种的 :doc:`Phalcon\\Di <../api/Phalcon_Di>` 叫 :doc:`Phalcon\\Di\\FactoryDefault <../api/Phalcon_Di_FactoryDefault>` 。这个类会自动注册相应的服务，并捆绑在一起作为一个全栈框架。

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault;

    $di = new FactoryDefault();

服务名称约定（Service Name Conventions）
========================================
尽管你可以用你喜欢的名字来注册服务，但是Phalcon有一些命名约定，这些约定让你在需要的时候，可以获得正确的（内置）服务。

+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| 服务名称            | 介绍                                        | 默认                                                                                               | 是否是shared服务 |
+=====================+=============================================+====================================================================================================+==================+
| dispatcher          | 控制器调度服务                              | :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>`                                    | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| router              | 路由服务                                    | :doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>`                                            | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| url                 | URL生成服务                                 | :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>`                                                  | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| request             | HTTP 请求环境服务                           | :doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>`                                        | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| response            | HTTP响应环境服务                            | :doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>`                                      | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| cookies             | HTTP Cookie管理服务                         | :doc:`Phalcon\\Http\\Response\\Cookies <../api/Phalcon_Http_Response_Cookies>`                     | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| filter              | 输入过滤服务                                | :doc:`Phalcon\\Filter <../api/Phalcon_Filter>`                                                     | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| flash               | 闪现信息服务                                | :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>`                                        | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| flashSession        | 闪现session信息服务                         | :doc:`Phalcon\\Flash\\Session <../api/Phalcon_Flash_Session>`                                      | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| session             | session服务                                 | :doc:`Phalcon\\Session\\Adapter\\Files <../api/Phalcon_Session_Adapter_Files>`                     | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| eventsManager       | 事件管理服务                                | :doc:`Phalcon\\Events\\Manager <../api/Phalcon_Events_Manager>`                                    | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| db                  | 底层数据库连接服务                          | :doc:`Phalcon\\Db <../api/Phalcon_Db>`                                                             | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| security            | 安全助手                                    | :doc:`Phalcon\\Security <../api/Phalcon_Security>`                                                 | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| crypt               | 加密/解密数据                               | :doc:`Phalcon\\Crypt <../api/Phalcon_Crypt>`                                                       | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| tag                 | HTML生成助手                                | :doc:`Phalcon\\Tag <../api/Phalcon_Tag>`                                                           | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| escaper             | 内容(HTML)转义                              | :doc:`Phalcon\\Escaper <../api/Phalcon_Escaper>`                                                   | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| annotations         | 注释分析器                                  | :doc:`Phalcon\\Annotations\\Adapter\\Memory <../api/Phalcon_Annotations_Adapter_Memory>`           | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| modelsManager       | model管理服务                               | :doc:`Phalcon\\Mvc\\Model\\Manager <../api/Phalcon_Mvc_Model_Manager>`                             | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| modelsMetadata      | model元数据服务                             | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Memory <../api/Phalcon_Mvc_Model_MetaData_Memory>`            | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| transactionManager  | model事务管理服务                           | :doc:`Phalcon\\Mvc\\Model\\Transaction\\Manager <../api/Phalcon_Mvc_Model_Transaction_Manager>`    | 是               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| modelsCache         | model的缓存服务                             | None                                                                                               | No               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+
| viewsCache          | view的缓存服务                              | None                                                                                               | No               |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+------------------+

自定义注入器（Implementing your own DI）
========================================
如果你要创建一个自定义注入器或者继承一个已有的，接口 :doc:`Phalcon\\DiInterface <../api/Phalcon_DiInterface>` 必须被实现。

.. _`Inversion of Control`: http://zh.wikipedia.org/wiki/%E6%8E%A7%E5%88%B6%E5%8F%8D%E8%BD%AC
.. _singletons: http://zh.wikipedia.org/wiki/%E5%8D%95%E4%BE%8B%E6%A8%A1%E5%BC%8F
