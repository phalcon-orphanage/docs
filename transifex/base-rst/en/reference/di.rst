%{di_4a5b7bc627ed34135d58c67ccb674fb5}%

%{di_c8beb1db535d2d5d051ba217fe6c8051}%

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

%{di_574a7ed3bb5d3bb628504780fbead704}%

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

    //{%di_adb110eceff15d54c62d08f27fe45e68%}
    $connection = new Connection(array(
        "host" => "localhost",
        "username" => "root",
        "password" => "secret",
        "dbname" => "invo"
    ));

    //{%di_651e15141b7a09e7ffeeaac2cc3f90f6%}
    $some->setConnection($connection);

    $some->someDbTask();

%{di_5b7e48880fbea53af767c7bc5056d8aa}%

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

    //{%di_3fdb8ae9cd4d1bd1e31040931421dde3%}
    $some->setConnection(Registry::getConnection());

    $some->someDbTask();

%{di_7358d10fc368cb382d807da84444f939}%

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

    //{%di_a065ed5816bf5bdb232f63839413db93%}
    $some->setConnection(Registry::getSharedConnection());

    $some->someDbTask();

    //{%di_650a1e77458ec792145b424935f2d9db%}
    $some->someOtherDbTask(Registry::getConnection());

%{di_97337be64fa7cbbf9af489790e9badb6}%

%{di_2e678291f806f4e66ec87ead48e6018a}%

.. code-block:: php

    <?php

    //{%di_a368acdb5b6af2fc77288deb033de42f%}
    $connection = new Connection();
    $session = new Session();
    $fileSystem = new FileSystem();
    $filter = new Filter();
    $selector = new Selector();

    //{%di_0feab19cf0dfd1c5cddfb6e12a925d39%}
    $some = new SomeComponent($connection, $session, $fileSystem, $filter, $selector);

    // {%di_b9b85c3b69718427f55faca36d345eb8%}

    $some->setConnection($connection);
    $some->setSession($session);
    $some->setFileSystem($fileSystem);
    $some->setFilter($filter);
    $some->setSelector($selector);

%{di_35a19665bc2a2bcddfcac04d57024568}%

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

%{di_ba4b67485bd4fca58dad7b0f724aca85}%

%{di_c131f094dbcc3b2eca85a57b141612c5}%

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

            // {%di_2bb71ae71c72d6cd711b343a8ce6ef36%}
            // {%di_d960a3b92ab6d6e23ad9079e0d891ee0%}
            $connection = $this->_di->get('db');

        }

        public function someOtherDbTask()
        {

            // {%di_bdc30dd362e375de668fccf0b04cd514%}
            // {%di_7c1684b26c75a74b272808e93d26cfd7%}
            $connection = $this->_di->getShared('db');

            //{%di_4a2e6799be4cc43397224048e1cea642%}
            $filter = $this->_di->get('filter');

        }

    }

    $di = new Phalcon\DI();

    //{%di_1f6be9f851d024f9c2255b0b45ec646c%}
    $di->set('db', function() {
        return new Connection(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname" => "invo"
        ));
    });

    //{%di_ae40a4e0eb8d4449e21cf5eed59167d6%}
    $di->set('filter', function() {
        return new Filter();
    });

    //{%di_6279275289461e2e4743b305b293e167%}
    $di->set('session', function() {
        return new Session();
    });

    //{%di_f3de1ee1ded598164bbef9aac39254f9%}
    $some = new SomeComponent($di);

    $some->someTask();

%{di_e6f996a5b1eac12ea2042f1938fc5c22}%

%{di_4df3a2adc8b97815253827b168ac9186}%
============
%{di_ef4688cd63009deb66575a3205c9d639}%

%{di_3fa3eaafa26e9ffe84116c67d0fefbf1}%

%{di_fbb2fa5e81cfb83763e38d50f7fb41c3}%

%{di_99b587c85d45df1407dcd0788d9587a5}%

%{di_986a30636ebdb00490151abb04c98bbe}%
=====================================
%{di_394e670d251c1672db1443ed55c38287}%

%{di_c61eadc667d87fdc8772798841b75116}%

%{di_e2b160d2fd91df6f28047de0a7438245}%

%{di_b9902c5ec0e172db9ea3ef4a360a4772}%

.. code-block:: php

    <?php

    //{%di_4a09b9a8df6b4b068531d7654fac0327%}
    $di = new Phalcon\DI();

    //{%di_0c4194c9a6a75b3f309bd1d4394a6105%}
    $di->set("request", 'Phalcon\Http\Request');

    //{%di_49ef8ef6f69770739db9af5274251b7c%}
    $di->set("request", function() {
        return new Phalcon\Http\Request();
    });

    //{%di_7edeccad7eb5d61bfbcf11c7f4223867%}
    $di->set("request", new Phalcon\Http\Request());

    //{%di_703595dc0b8e648e923ca00db8bcf513%}
    $di->set("request", array(
        "className" => 'Phalcon\Http\Request'
    ));

%{di_d98882f481863f6da56c67fcda067893}%

.. code-block:: php

    <?php

    //{%di_4a09b9a8df6b4b068531d7654fac0327%}
    $di = new Phalcon\DI();

    //{%di_0c4194c9a6a75b3f309bd1d4394a6105%}
    $di["request"] = 'Phalcon\Http\Request';

    //{%di_49ef8ef6f69770739db9af5274251b7c%}
    $di["request"] = function() {
        return new Phalcon\Http\Request();
    };

    //{%di_7edeccad7eb5d61bfbcf11c7f4223867%}
    $di["request"] = new Phalcon\Http\Request();

    //{%di_703595dc0b8e648e923ca00db8bcf513%}
    $di["request"] = array(
        "className" => 'Phalcon\Http\Request'
    );

%{di_c0112234d77d9c9d66747da018ab1b16}%

%{di_70f7fd5cab148f4b7101ea9f131e885c}%

%{di_133dd51288fdbf98603194b63e11cf62}%

%{di_37f9c0bc3f3b1fd17546fe3c12fcbe71}%

%{di_694876cfdd2a46a8dcac91aa534196ad}%
-------------------
%{di_1392edb02b710a6e27f1249390e2f537}%

%{di_20cdd879f4dcfb6fb4d7de18d7e464ff}%
^^^^^^
%{di_9ef693cf4ecb42b512fbea01a3a35c84}%

.. code-block:: php

    <?php

    // return new Phalcon\Http\Request();
    $di->set('request', 'Phalcon\Http\Request');

%{di_75df90dfe0a1dbc61cc89f9a6e6f77e9}%
^^^^^^
%{di_d9691bd1823160ec71e0f0bb30469cff}%

.. code-block:: php

    <?php

    // return new Phalcon\Http\Request();
    $di->set('request', new Phalcon\Http\Request());

%{di_0288243a357389f316e2aa112edc3664}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{di_4a4d8f31d75cf986c2d00a26a48dae32}%

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

%{di_c96aadc03ffb0462aa95fb4a85923011}%

.. code-block:: php

    <?php

    //{%di_9e4c85155cdc156e3e717cf30594427b%}
    $di->set("db", function() use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
             "host" => $config->host,
             "username" => $config->username,
             "password" => $config->password,
             "dbname" => $config->name
        ));
    });

%{di_2660cdeaa3179e567ddc97ea665f0317}%
--------------------
%{di_79ed10d961ef000241c8f7d7ce1be212}%

.. code-block:: php

    <?php

    //{%di_89c6f7adda4ccce404a4dceac92a82d7%}
    $di->set('logger', array(
        'className' => 'Phalcon\Logger\Adapter\File',
        'arguments' => array(
            array(
                'type' => 'parameter',
                'value' => '../apps/logs/error.log'
            )
        )
    ));

    //{%di_2f1fffb20b38514cec7ec9556bcc1901%}
    $di->set('logger', function() {
        return new \Phalcon\Logger\Adapter\File('../apps/logs/error.log');
    });

%{di_9aa1de8a6cafc7bd07f737adddbb8438}%

.. code-block:: php

    <?php

    //{%di_cdb0598c01cf979f97867e5bf48dabd1%}
    $di->getService('logger')->setClassName('MyCustomLogger');

    //{%di_171cc68c3687af305338dd7c0d9422b3%}
    $di->getService('logger')->setParameter(0, array(
        'type' => 'parameter',
        'value' => '../apps/logs/error.log'
    ));

%{di_f2915c8918f43a062e3f5599e794989d}%

%{di_9c0bdf48d0a98198d5490fcd17421123}%
^^^^^^^^^^^^^^^^^^^^^
%{di_04c13fc7ced43a12edc258ed23299840}%

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

%{di_d1ba10c207d7013726f7c99936b7c216}%

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

%{di_09927c30ccaac2540c35fef8dd775559}%

%{di_33371c87c59dd13879c03d2933b2883a}%
^^^^^^^^^^^^^^^^
%{di_037521458982b3a04f8a8f73e18cf0e2}%

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

%{di_b3ae449184d1b666544396372eedeccc}%

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

%{di_561e082121d27439298b1449dfa14f3d}%
^^^^^^^^^^^^^^^^^^^^
%{di_cc0e08475fea09b8e1e0faedaa904394}%

.. code-block:: php

    <?php

    namespace SomeApp;

    use Phalcon\Http\Response;

    class SomeComponent
    {

        public $response;

        public $someFlag;

    }

%{di_b415258cb72581635e1a11c818099fec}%

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

%{di_9556a96ea3e328a290fa0d1f5241b93b}%

+-------------+----------------------------------------------------------+-------------------------------------------------------------------------------------+
| Type        | Description                                              | Example                                                                             |
+=============+==========================================================+=====================================================================================+
| parameter   | Represents a literal value to be passed as parameter     | array('type' => 'parameter', 'value' => 1234)                                       |
+-------------+----------------------------------------------------------+-------------------------------------------------------------------------------------+
| service     | Represents another service in the service container      | array('type' => 'service', 'name' => 'request')                                     |
+-------------+----------------------------------------------------------+-------------------------------------------------------------------------------------+
| instance    | Represents an object that must be built dynamically      | array('type' => 'instance', 'className' => 'DateTime', 'arguments' => array('now')) |
+-------------+----------------------------------------------------------+-------------------------------------------------------------------------------------+

%{di_c39b14a551be0865ba3861920297ee03}%

%{di_2cadca58ad0af8c325f305d5e775c048}%

%{di_ebe7f70c26148e804268cefe62123657}%
==================
%{di_55272287ce2940d0156cc9f08f4cc6a8}%

.. code-block:: php

    <?php $request = $di->get("request");

%{di_7c1737f36a6e408ba72bb5a799178da2}%

.. code-block:: php

    <?php

    $request = $di->getRequest();

%{di_b30f368f718f146093bbf9e426bcaf6d}%

.. code-block:: php

    <?php

    $request = $di['request'];

%{di_df760419f3610c317d0a8389de253bb1}%

.. code-block:: php

    <?php

    // {%di_945920107394b32e034f1568d6a9d758%}
    $component = $di->get("MyComponent", array("some-parameter", "other"));

%{di_5e95da1b79954815439137b5633640d9}%
===============
%{di_523da39e9a502f591f39f45be934c195}%

.. code-block:: php

    <?php

    //{%di_bd223bfb790abb46b36c0bb9c45137d0%}
    $di->setShared('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

    $session = $di->get('session'); // {%di_ab897c9c2e7e46440b6466f2d36f124e%}
    $session = $di->getSession(); // {%di_9d15eb019aa64c75adc2a2eb51d56882%}

%{di_ab7945a37fd0394ab6aa70073346689e}%

.. code-block:: php

    <?php

    //{%di_bd223bfb790abb46b36c0bb9c45137d0%}
    $di->set('session', function() {
        //...
    }, true);

%{di_a2fc89c7cf97ed772e169211e2239c2c}%

.. code-block:: php

    <?php

    $request = $di->getShared("request");

%{di_a9c22033c4679a03e177418411d01888}%
==================================
%{di_36420ae7d6f7117c9398175a25e18bfb}%

.. code-block:: php

    <?php

    //{%di_3dccbfc975bace728b4222d239d68241%}
    $di->set('request', 'Phalcon\Http\Request');

    //{%di_ed008be759e16fd3e75fee7914c96149%}
    $requestService = $di->getService('request');

    //{%di_192eed5fc58caf31cd16710dfd023934%}
    $requestService->setDefinition(function() {
        return new Phalcon\Http\Request();
    });

    //{%di_41da7327626545a050418aedcfdb4d2c%}
    $requestService->setShared(true);

    //{%di_5a6f307a548f6f9f8793612e2f16f52f%}
    $request = $requestService->resolve();

%{di_11205d8363eee750e219f2142a69f6cc}%
===============================================
%{di_9ec7bab8213c10730a15e14a83bf8eca}%

.. code-block:: php

    <?php

    //{%di_488248aa224f04bf34e44796a2a8c3f9%}
    $di->set('IndexController', function() {
        $component = new Component();
        return $component;
    }, true);

    //{%di_488248aa224f04bf34e44796a2a8c3f9%}
    $di->set('MyOtherComponent', function() {
        //{%di_9d551646f920cbebf936f0e2e5fe8e1e%}
        $component = new AnotherComponent();
        return $component;
    });

    //{%di_0a981d32b627f0c9ed8f523d9fdd914e%}
    $myComponent = $di->get('MyOtherComponent');

%{di_85beb28ee3f83ae99cc759a92dd8034f}%

%{di_f490448655b0bd4ef0ac8da57a753c8e}%
====================================
%{di_f82822663c272f5d23969e02e67203db}%

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

%{di_6fc810bd74ec71922209d7143f7ccf7d}%

.. code-block:: php

    <?php

    //{%di_7ac0b9f44dc8d0e8ccae26e1649cbe95%}
    $di->set('myClass', 'MyClass');

    //{%di_17a5c5092cbcd30c2143d48dee095d01%}
    $myClass = $di->get('myClass');

%{di_718a4aef623ce8b43b3b6e573948839b}%
===========================
%{di_e6b5036b404972f413cc53cc18341336}%

.. code-block:: php

    <?php

    //{%di_a2e7edcb5aaefca2b15a87f1a5834393%}
    $router = new MyRouter();

    //{%di_f3008f164f57066b43613e1aaffa98b6%}
    $di->set('router', $router);

%{di_4f001400cf0edf3b340d6e85965045ee}%
============================
%{di_70f16f940b677929f1bb8f1d27a08918}%

.. code-block:: php

    <?php

    $di->set('router', function() {
        return include "../app/config/routes.php";
    });

%{di_dff5e52a906d54857347dee1fe5cadf7}%

.. code-block:: php

    <?php

    $router = new MyRouter();

    $router->post('/login');

    return $router;

%{di_009d636bc5ba7d3c807ad2171952c475}%
================================
%{di_3686f852ccc9494199407f0f5c8a333f}%

.. code-block:: php

    <?php

    class SomeComponent
    {

        public static function someMethod()
        {
            //{%di_c13c8c8ed70c91d9a0bafe5c87f4351e%}
            $session = Phalcon\DI::getDefault()->getSession();
        }

    }

%{di_ab8dffcd5daaff4344d575991cd0f12a}%
==================
%{di_029caf1fc063b7ffdda35adf1e2ff47d}%

.. code-block:: php

    <?php $di = new Phalcon\DI\FactoryDefault();

%{di_0e74f12e67a950d157dc6477fd91d5ab}%
========================
%{di_873e69b82630ed0e18cfce537a6d384e}%

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

%{di_fbd70cc43e51089bc8589a32fe15143f}%
========================
%{di_7a91b02925ab6cdbaa40291e51a1f94e}%

