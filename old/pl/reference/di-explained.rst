Dependency Injection Explained
==============================

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
        [
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo",
        ]
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
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo",
                ]
            );
        }

        /**
         * Creates a connection only once and returns it
         */
        public static function getSharedConnection()
        {
            if (self::$_connection === null) {
                self::$_connection = self::_createConnection();
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
    $some->setConnection(
        Registry::getSharedConnection()
    );

    $some->someDbTask();

    // Here, we always pass a new connection as parameter
    $some->someOtherDbTask(
        Registry::getNewConnection()
    );

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
            // Get the connection service
            // Always returns a new connection
            $connection = $this->_di->get("db");
        }

        public function someOtherDbTask()
        {
            // Get a shared connection service,
            // this will return the same connection every time
            $connection = $this->_di->getShared("db");

            // This method also requires an input filtering service
            $filter = $this->_di->get("filter");
        }
    }

    $di = new Di();

    // Register a "db" service in the container
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

    // Register a "filter" service in the container
    $di->set(
        "filter",
        function () {
            return new Filter();
        }
    );

    // Register a "session" service in the container
    $di->set(
        "session",
        function () {
            return new Session();
        }
    );

    // Pass the service container as unique parameter
    $some = new SomeComponent($di);

    $some->someDbTask();

The component can now simply access the service it requires when it needs it, if it does not require a service it is not even initialized,
saving resources. The component is now highly decoupled. For example, we can replace the manner in which connections are created,
their behavior or any other aspect of them and that would not affect the component.
