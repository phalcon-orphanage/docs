Inyección de Dependencias/Localización de Servicios
***************************************************
El siguiente ejemplo es un poco largo, pero explica porqué usar un contenedor de servicios, localización de servicios e
inyección de dependencias. Primero, pensemos que estamos creando algún componente llamado SomeComponent. Este realiza
alguna tarea que no es importante en este momento. Nuestro componente tiene una dependencia que es una conexión a una
base de datos.

En este primer ejemplo, la conexión es creada dentro del componente, esto es impráctico, ya que no podemos
cambiar los parámetros de conexión o el tipo de sistema de base de datos externamente ya que el componente
solo funciona como fue creado.

.. code-block:: php

    <?php

    class SomeComponent
    {

        /**
         * La instanciación del componente es realizada dentro de él
         * así que es díficil cambiar su comportamiento o parámetros
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

Para solucionar esto, hemos creado un setter que inyecta la dependencia externamente antes de usarla. Por ahora,
esto parece ser una buena solución.

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

    //Crear la conexión
    $connection = new Connection(array(
        "host" => "localhost",
        "username" => "root",
        "password" => "secret",
        "dbname" => "invo"
    ));

    //Inyectarla en el componente
    $some->setConnection($connection);

    $some->someDbTask();

Ahora pensemos que usamos este componente en distintas partes de la aplicación, por lo tanto
vamos a requerir crear siempre la conexión y pasarla siempre al componente. Usar
algún tipo de registro global donde obtengamos la conexión y no tengamos que crearla nuevamente:

.. code-block:: php

    <?php

    class Registry
    {

        /**
         * Devuelve una conexión
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
         * Establecer la conexión externamente
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

    //Pasar la conexión definida en el registro
    $some->setConnection(Registry::getConnection());

    $some->someDbTask();

Ahora, imaginemos que debemos implementar dos métodos en el componente, el primero siempre necesita una conexión nueva y
el segundo siempre debe usar una conexión existente.

.. code-block:: php

    <?php

    class Registry
    {

        protected static $_connection;

        /**
         * Crea una conexión
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
         * Crea una conexión o devuelve una existente
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
         * Siempre devuelve una nueva conexión
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
         * Establecer la conexión
         */
        public function setConnection($connection)
        {
            $this->_connection = $connection;
        }

        /**
         * Este método requiere la conexión compartida
         */
        public function someDbTask()
        {
            $connection = $this->_connection;

            // ...
        }

        /**
         * Este método siempre requiere una nueva conexión
         */
        public function someOtherDbTask($connection)
        {

        }

    }

    $some = new SomeComponent();

    //Inyectar la conexión compartida
    $some->setConnection(Registry::getSharedConnection());

    $some->someDbTask();

    //Aquí, pasamos una nueva conexión
    $some->someOtherDbTask(Registry::getConnection());

Hasta aquí hemos visto como inyectar dependencias en los componentes soluciona nuestros problemas.
Pasar dependencias como argumentos en vez de crearlos internamente hace nuestra aplicación más mantenible y
desacoplada. Sin embargo, a largo plazo este tipo de inyección de dependencias podría tener algunas desventajas.

For instance, if the component has many dependencies, we will need to create multiple setter arguments to pass
the dependencies or create a constructor that pass them with many arguments, additionally creating dependencies
before using the component, every time, makes our code not as maintainable as we would like:

.. code-block:: php

    <?php

    //Crear la dependencia o obtenerla del registro
    $connection = new Connection();
    $session = new Session();
    $fileSystem = new FileSystem();
    $filter = new Filter();
    $selector = new Selector();

    //Pasar las dependencias en el constructor del componente
    $some = new SomeComponent($connection, $session, $fileSystem, $filter, $selector);

    // ... o usar setters

    $some->setConnection($connection);
    $some->setSession($session);
    $some->setFileSystem($fileSystem);
    $some->setFilter($filter);
    $some->setSelector($selector);

Piensa que debemos crear este objeto en muchas partes de nuestra aplicación, si ya no se requiere alguna dependencia
debemos ir a cada parte y quitar el parámetro del constructor o del setter donde la inyectamos. Para resolver esto
podríamos volver a usar el registro global para crear el componente. Sin embargo, esto agrega una nueva capa de
abstracción antes de crear el objeto:

.. code-block:: php

    <?php

    class SomeComponent
    {

        // ...

        /**
         * Definir un método fabrica para crear instancias de SomeComponent inyectando sus dependencias
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

Si nos damos cuenta, hemos vuelto al principio, nuevamente estamos creando dependencias dentro del componente!
Podemos dar y dar vueltas sobre este problema y veremos que caemos una y otra vez en malas prácticas. Dependiendo
de la complejidad de nuestra aplicación esto puede ser un problema a largo plazo.

Una forma práctica y elegante de solucionar estos problemas es usar un localizador de servicios.
Los contenedores de servicios trabajan de manera similar a un registro global que vimos anteriormente.
Usar el contenedor de dependencias como un puente para obtener las dependencias permitirá reducir la complejidad
del componente:

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

            // Obtener la conexión localizando el servicio
            $connection = $this->_di->get('db');

        }

        public function someOtherDbTask()
        {

            // Obtener una conexión compartida
            $connection = $this->_di->getShared('db');

            //Este método también requiere el servicio de filtrado
            $filter = $this->_db->get('filter');

        }

    }

    //Crear el localizador de servicios
    $di = new Phalcon\DI();

    //Registrar un servicio 'db'
    $di->set('db', function() {
        return new Connection(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname" => "invo"
        ));
    });

    //Registrar un servicio "filter"
    $di->set('filter', function() {
        return new Filter();
    });

    //Registrar un servicio 'session'
    $di->set('session', function() {
        return new Session();
    });

    //Pasar el localizador de servicios como único componente
    $some = new SomeComponent($di);

    $some->someTask();

El componente simplemente accede al servicio que requiere cuando lo necesita, si no lo requiere entonces ni siquiera es inicializado
ahorrando recursos. Por ejemplo, podemos cambiar la manera en la que las conexiones son creadas y su comportamiento
o cualquier otro aspecto no afectarán el componente.

Our approach
============
Phalcon\\DI es un componente que implementa inyección de dependencias y localización de servicios, de la misma manera
es un contenedor para ellos.

Ya que Phalcon es altamente desacoplado, Phalcon\\DI es esencial para integrar los diferentes componentes del framework.
El desarrollador puede usar este componente para inyectar dependencias y administrar instancias globales de las distintas
clases usadas en el framework.

Basicamente, la localización de servicios significa que los objetos no reciben sus dependencias
a partir de setters o en su constructor, sino que los solicitan al localizador.

Esto reduce la complejidad ya que solo hay una manera únificada de acceder a las dependencias requeridas dentro de un componente.

Adicionalmente, este patrón hace el código más testeable, haciendolo menos propenso a errores.

Registrar servicios en el contenedor
====================================
El framework en si mismo ó el desarrollador pueden registrar servicios. Cuando un componente A requiere del componente B (o una instancia de su clase)
para operar, puede obtener el componente B del contenedor, en vez de crear una instancia directamente del componente B.

This way of working gives us many advantages:
Esta manera de trabajar nos da muchas ventajas:

* Podemos facilmente reemplazar un componente con uno creado por nosotros mismos o un tercero
* Podemos controlar la manera en la que los objetos se inicializan, permitiendonos configurarlos como se requiera antes de entregarlos a sus componentes
* Podemos mantener instancias globales de componentes de manera estructurada y únificada

Los servicios pueden ser registrados de distintas maneras:

.. code-block:: php

    <?php

    //Crear el inyector de dependencias
    $di = new Phalcon\DI();

    //Por su nombre de clase
    $di->set("request", 'Phalcon\Http\Request');

    //Usando una función anónima, la instancia se creará solo cuando el servicio sea accedido
    $di->set("request", function() {
        return new Phalcon\Http\Request();
    });

    //Registrando una instancia directamente
    $di->set("request", new Phalcon\Http\Request());

    //Usar una definición en un array
    $di->set("request", array(
        "className" => 'Phalcon\Http\Request'
    ));

También podemos registrar servicios en el DI usando la sintaxis de array:

.. code-block:: php

    <?php

    //Crear el inyector de dependencias
    $di = new Phalcon\DI();

    //Por su nombre de clase
    $di["request"] = 'Phalcon\Http\Request';

    //Usar una función anónima, la instancia se creará solo cuando el servicio sea accedido
    $di["request"] = function() {
        return new Phalcon\Http\Request();
    };

    //Registrar la instancia directamente
    $di["request"] = new Phalcon\Http\Request();

    //Usar un array como definición
    $di["request"] = array(
        "className" => 'Phalcon\Http\Request'
    );

En el ejemplo anterior, cuando el framework o algún componente requiera acceder a los datos de la petición, lo que hará
es solicitar un servicio identificado como 'request' en el contenedor. Este lo que hará es "resolver" el servicio requerido
devolviendo una instancia de él. Un desarrollador puede eventualmente reemplazar la clase usada como componente,
su configuración, etc, siempre y cuando la instancia retornada cumpla con una interface convenida entre ambas partes.

En el ejemplo anterior, cada uno de las formas de registrar servicios tiene ventajas y desventajas.
Depende del desarrollador y de sus necesidades particulares escoger la que más le convenga.

Establecer un servicio por su nombre de clase es sencillo pero carece de flexibilidad. Establecer servicios usando
un array ofrece más flexibilidad pero puede ser un poco más complicado.
La función anónima ofrece un buen balance entre ambas pero puede ser más díficil cambiar algún parámetro de inicialización
sino es editando directamente su código.

La mayoría de estrategias para registrar servicios en Phalcon\\DI inicializan los servicios solo la primera vez
que son requeridas.

Registro simple
---------------
Como se vió anteriormente, hay muchos tipos de registrar servicios, a estos les denomiamos simples:

String
^^^^^^
Este tipo requiere un nombre de clase válido, y devuelve un objeto de la clase indicada, si la clase no está cargada
se usará un auto-loader. Este tipo de definición no permite indicar parámetros para su constructor o setters.

.. code-block:: php

    <?php

    // devuelve new Phalcon\Http\Request();
    $di->set('request', 'Phalcon\Http\Request');

Objetos
^^^^^^^
Este tipo requiere un objeto. Debido a que el objeto como tal ya está resuelto no necesita
resolverse nuevamente. Es útil cuando queremos forzar el objeto sea el mismo y no pueda ser cambiado:

.. code-block:: php

    <?php

    // devuelve new Phalcon\Http\Request();
    $di->set('request', new Phalcon\Http\Request());

Funciones anónimas
^^^^^^^^^^^^^^^^^^
Este método ofrece una gran libertad pra construir las dependencias como se requiera, sin embargo,
puede ser díficil cambiar la definición del servicio en runtime ó dinámicamente sin tener
que cambiar la definición en código de la dependencia:

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

Alguna de las limitaciones pueden compensarse pasando variables adicionales al contexto de la función
anónima:

.. code-block:: php

    <?php

    //Usar la variable $config en el contexto de la función anónima
    $di->set("db", function() use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
             "host" => $config->host,
             "username" => $config->username,
             "password" => $config->password,
             "dbname" => $config->name
        ));
    });

Registro Avanzado
-----------------
Si es requerido cambiar la definición del servicio sin instanciar o resolver el servicio,
luego, necesitamos definir el servicio usando la sintaxís de array. Definir un servicio usando
la definición de array puede requerir más código:

.. code-block:: php

    <?php

    //Registrar el servicio 'logger' con un nombre de clase y sus parámetros
    $di->set('logger', array(
        'className' => 'Phalcon\Logger\Adapter\File',
        'arguments' => array(
            array(
                'type' => 'parameter',
                'value' => '../apps/logs/error.log'
            )
        )
    ));

    //Igual pero usando una función anónima
    $di->set('logger', function() {
        return new \Phalcon\Logger\Adapter\File('../apps/logs/error.log');
    });

Ambas definiciones construyen la instancia de la misma manera, sin embargo la definición de array, permite alterar los parámetros
del servicio de manera más sencilla si se requiere:

.. code-block:: php

    <?php

    //Cambiar el nombre de la clase
    $di->getService('logger')->setClassName('MyCustomLogger');

    //Cambiar el primer parámetro
    $di->getService('logger')->setParameter(0, array(
        'type' => 'parameter',
        'value' => '../apps/logs/error.log'
    ));

Adicionalmente, al usar la construcción avanzada de dependencias puedes usar 3 tipos de inyección de dependencias:

Inyección en el Constructor
^^^^^^^^^^^^^^^^^^^^^^^^^^^
Este tipo de inyección pasa sus dependencias/argumentos al constructor de su clase.
Prentendamos que tenemos el siguiente componente:

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

El servicio puede ser registrado de la siguiente forma:

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

El servicio "response" (Phalcon\\Http\\Response) es resuelto y se pasa como primer argumetno del constructor,
mientras que el segundo es un valor booleano (true) que se pasa tal y como está.

Inyección via Setters
^^^^^^^^^^^^^^^^^^^^^
Las clases pueden tener setters que inyectan dependencias opcionales, nuestra clase previa puede ser cambiada
para aceptar las dependencias con setters:

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

Un servicio con inyección de setters se puede registrar así:

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

Inyección de Propiedades
^^^^^^^^^^^^^^^^^^^^^^^^
Una estrategia menos común es inyectar las dependencias directamente a los atributos públicos de la clase:

.. code-block:: php

    <?php

    namespace SomeApp;

    use Phalcon\Http\Response;

    class SomeComponent
    {

        public $response;

        public $someFlag;

    }

Un servicio con dependencias inyectadas en sus propiedades se puede registrar así:

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

Los tipos de parámetros soportados incluyen los siguientes:

+-------------+----------------------------------------------------------+-------------------------------------------------------------------------------------+
| Tipo        | Descripción                                              | Ejemplo                                                                             |
+=============+==========================================================+=====================================================================================+
| parameter   | Representa un valor literal a ser inyectado              | array('type' => 'parameter', 'value' => 1234)                                       |
+-------------+----------------------------------------------------------+-------------------------------------------------------------------------------------+
| service     | Representa el resultado de resolver otro servicio en DI  | array('type' => 'service', 'name' => 'request')                                     |
+-------------+----------------------------------------------------------+-------------------------------------------------------------------------------------+
| instance    | Representa un objeto que debe ser construído por el DI   | array('type' => 'instance', 'className' => 'DateTime', 'arguments' => array('now')) |
+-------------+----------------------------------------------------------+-------------------------------------------------------------------------------------+

Resolver un servicio de esta manera puede ser un poco más complicado y algo más lento con respecto a las definiciones vistas
inicialmente. Sin embargo, estas proporcionan una estrategía más robusta para inyectar servicios:

Mezclar distintos tipos de definiciones está permitido, cada quien puede decidir cuál es la forma más apropiada de acuerdo
a las necesidades de la aplicación.

Resolver Servicios
==================
Resolver y obtener un servicio del contenedor es simplemente usar el método "get". Una nueva instancia del servicio será devuelta:

.. code-block:: php

    <?php $request = $di->get("request");

También es posible usar métodos mágicos:

.. code-block:: php

    <?php

    $request = $di->getRequest();

O usar la sintaxis de array:

.. code-block:: php

    <?php

    $request = $di['request'];

Arguments can be passed to the constructor by adding an array parameter to the method "get":
Los argumentos se pueden pasar al constructor agregando un array como parámetro del método "get":

.. code-block:: php

    <?php

    // new MyComponent("some-parameter", "other")
    $component = $di->get("MyComponent", array("some-parameter", "other"));

Servicios Compartidos
=====================
Los servicios pueden ser registrados como compartidos esto significa que actuarán como singletons_. Una vez el servicio
se resuelva por primera vez la misma instancia será retornada cada vez que alguien consuma el servicio en el contenedor:

.. code-block:: php

    <?php

    //Registrar el servicio "session" como siempre compartido
    $di->setShared('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

    $session = $di->get('session'); // Localiza y resuelve el servicio por primera vez
    $session = $di->getSession(); // Devuelve el objeto instanciado inicialmente

Una manera alternativa de registrar un servicio compartido es pasar "true" como tercer parámetro de "set":

.. code-block:: php

    <?php

    //Registrar un servicio como "siempre compartido"
    $di->set('session', function() {
        //...
    }, true);

Si un servicio no está registrado como compartido y lo que quieres es estar seguro que una instancia compartida
será siempre devuelta , entonces debes usar el método 'getShared':

.. code-block:: php

    <?php

    $request = $di->getShared("request");

Manipular servicios individualmente
===================================
Una vez un servicio está registrado en el contenedor de servicios, puedes obtenerlo y manipularlo indivualmente:

.. code-block:: php

    <?php

    //Registrar el servicio de sesión
    $di->set('request', 'Phalcon\Http\Request');

    //Obtener el servicio como tal
    $requestService = $di->getService('request');

    //Cambiar su definición
    $requestService->setDefinition(function() {
        return new MyRequest();
    });

    //Volverlo compartido
    $request->setShared(true);

    //Resolver el servicio (devuelve una instancia de MyRequest)
    $request = $requestService->resolve();

Instanciar clases via el contenedor de servicios
================================================
Cuando solicitas un servicio al contenedor de servicios y este no ha sido registrado con ese nombre, el tratará de obtener
un nombre de clase con el mismo nombre. Con este comportamiento

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

Automatic Injecting of the DI itself
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

Avoiding service resolution
===========================
Some services are used in each of the requests made to the application, eliminate the process of resolving the service
could add some small improvement in performance.

.. code-block:: php

    <?php

    //Resolve the object externally instead of using a definition for it:
    $router = new MyRouter();

    //Pass the resolved object to the service registration
    $di->set('router', $router);

Organizing services in files
============================
You can better organize your application by moving the service registration to individual files instead of
doing everything in the application's bootstrap:

.. code-block:: php

    <?php

    $di->set('router', function() {
        return include ("../app/config/routes.php");
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

    class SomeComponent
    {

        public static function someMethod()
        {
            //Get the session service
            $session = Phalcon\DI::getDefault()->getSession();
        }

    }

Factory Default DI
==================
Although the decoupled character of Phalcon offers us great freedom and flexibility, maybe we just simply want to use it as a full-stack
framework. To achieve this, the framework provides a variant of Phalcon\\DI called Phalcon\\DI\\FactoryDefault. This class automatically
registers the appropriate services bundled with the framework to act as full-stack.

.. code-block:: php

    <?php $di = new Phalcon\DI\FactoryDefault();

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

Implementing your own DI
========================
The :doc:`Phalcon\\DiInterface <../api/Phalcon_DiInterface>` interface must be implemented to create your own DI replacing the one provided by Phalcon or extend the current one.

.. _`Inversion of Control`: http://en.wikipedia.org/wiki/Inversion_of_control
.. _Singletons: http://en.wikipedia.org/wiki/Singleton_pattern
