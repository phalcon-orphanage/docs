Dependency Injection Explained
==============================

El siguiente ejemplo es un poco largo, pero explica porqué usar un contenedor de servicios, localización de servicios e inyección de dependencias.
Primero, pensemos que estamos creando algún componente llamado SomeComponent. Este realiza alguna tarea que no es importante en este momento.
Nuestro componente tiene una dependencia que es una conexión a una base de datos.

En este primer ejemplo, la conexión es creada dentro del componente, esto es impráctico, ya que
no podemos cambiar los parámetros de conexión o el tipo de sistema de base de datos externamente ya que el componente solo funciona como fue creado.

.. code-block:: php

    <?php

    class SomeComponent
    {
        /**
         * La instanciación del componente es realizada
         * dentro de él así que es díficil cambiar su
         * comportamiento o parámetros
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

Para solucionar esto, hemos creado un setter que inyecta la dependencia externamente antes de usarla. Por ahora, esto parece ser
una buena solución:

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

    // Crear la conexión
    $connection = new Connection(
        [
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo",
        ]
    );

    // Inyectarla en el componente
    $some->setConnection($connection);

    $some->someDbTask();

Ahora pensemos que usamos este componente en distintas partes de la aplicación,
por lo tanto vamos a requerir crear siempre la conexión y pasarla siempre al componente.
Usar algún tipo de registro global donde obtengamos la conexión y no tengamos que
crearla nuevamente:

.. code-block:: php

    <?php

    class Registry
    {
        /**
         * Devuelve una conexión
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

    // Pasar la conexión definida en el registro
    $some->setConnection(Registry::getConnection());

    $some->someDbTask();

Ahora, imaginemos que debemos implementar dos métodos en el componente, el primero siempre necesita una conexión nueva y el segundo siempre debe usar una conexión existente:

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
         * Crea una conexión o devuelve una existente
         */
        public static function getSharedConnection()
        {
            if (self::$_connection === null) {
                self::$_connection = self::_createConnection();
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

    // Inyectar la conexión compartida
    $some->setConnection(
        Registry::getSharedConnection()
    );

    $some->someDbTask();

    // Aquí, pasamos una nueva conexión
    $some->someOtherDbTask(
        Registry::getNewConnection()
    );

Hasta aquí hemos visto como inyectar dependencias en los componentes soluciona nuestros problemas. Pasar dependencias como argumentos en vez
de crearlos internamente hace nuestra aplicación más mantenible y desacoplada. Sin embargo,
a largo plazo este tipo de inyección de dependencias podría tener algunas desventajas.

For instance, if the component has many dependencies, we will need to create multiple setter arguments to pass
the dependencies or create a constructor that pass them with many arguments, additionally creating dependencies
before using the component, every time, makes our code not as maintainable as we would like:

.. code-block:: php

    <?php

    // Crear la dependencia o obtenerla del registro
    $connection = new Connection();
    $session    = new Session();
    $fileSystem = new FileSystem();
    $filter     = new Filter();
    $selector   = new Selector();

    // Pasar las dependencias en el constructor del componente
    $some = new SomeComponent($connection, $session, $fileSystem, $filter, $selector);

    // ... O usar setters
    $some->setConnection($connection);
    $some->setSession($session);
    $some->setFileSystem($fileSystem);
    $some->setFilter($filter);
    $some->setSelector($selector);

Piensa que debemos crear este objeto en muchas partes de nuestra aplicación, si ya no se requiere alguna dependencia
debemos ir a cada parte y quitar el parámetro del constructor o del setter donde la inyectamos. Para resolver esto
podríamos volver a usar el registro global para crear el componente. Sin embargo, esto agrega una nueva capa de abstracción antes de crear
el objeto:

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
            $session    = new Session();
            $fileSystem = new FileSystem();
            $filter     = new Filter();
            $selector   = new Selector();

            return new self($connection, $session, $fileSystem, $filter, $selector);
        }
    }

Si nos damos cuenta, hemos vuelto al principio, nuevamente estamos creando dependencias dentro del componente!
Podemos dar y dar vueltas sobre este problema y veremos que caemos una y otra vez en malas prácticas. Dependiendo de la complejidad de nuestra aplicación esto puede ser un problema a largo plazo.

Una forma práctica y elegante de solucionar estos problemas es usar un localizador de servicios. Los contenedores de servicios trabajan de manera similar a un registro global que
vimos anteriormente. Usar el contenedor de dependencias como un puente para obtener las dependencias permitirá reducir la complejidad
del componente:

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
            // Obtener la conexión localizando el servicio
            // Always returns a new connection
            $connection = $this->_di->get("db");
        }

        public function someOtherDbTask()
        {
            // Obtener una conexión compartida,
            // this will return the same connection everytime
            $connection = $this->_di->getShared("db");

            // Este método también requiere el servicio de filtrado
            $filter = $this->_di->get("filter");
        }
    }

    $di = new Di();

    // Registrar un servicio "db"
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

    // Registrar un servicio "filter"
    $di->set(
        "filter",
        function () {
            return new Filter();
        }
    );

    // Registrar un servicio "session"
    $di->set(
        "session",
        function () {
            return new Session();
        }
    );

    // Pasar el localizador de servicios como único componente
    $some = new SomeComponent($di);

    $some->someDbTask();

El componente simplemente accede al servicio que requiere cuando lo necesita, si no lo requiere entonces ni siquiera es inicializado
ahorrando recursos. Por ejemplo, podemos cambiar la manera en la que las conexiones son creadas
y su comportamiento o cualquier otro aspecto no afectarán el componente.
