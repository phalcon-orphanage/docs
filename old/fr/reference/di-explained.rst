La dépendance d'injection expliquée
===================================

L'exemple qui suit est un peut long, mais il tente d'expliquer pourquoi Phalcon utilise la localisation de service et l'injection de dépendance.
Pour commencer, imaginons que nous avons développé un composant appelé SomeComponent. La tâche qu'il réalise n'a pas d'importance maintenant.
Notre composant détient des dépendances dont la connexion à la base de données.

Dans ce premier exemple, la connexion est réalisée à l'intérieur du composant. Cette approche n'est pas pratique; nous ne
pouvons pas changer les paramètres de la connexion ou le type de SGBD parce que le composant n'est créé que pour fonctionner comme ça.

.. code-block:: php

    <?php

    class SomeComponent
    {
        /**
         * L'instanciation de la connexion est codée en dur dans le
         * composant, ce qui fait qu'il est compliqué de le remplacer
         * extérieurement ou de modifier son comportement
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

Pour résoudre ceci, nous avons créé un accesseur qui injecte une dépendance externe avant de l'utiliser. Pour l'instant,
ceci semble être une bonne solution:

.. code-block:: php

    <?php

    class SomeComponent
    {
        protected $_connection;

        /**
         * Attribution d'une connexion externe
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

    // Création de la connexion
    $connection = new Connection(
        [
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo",
        ]
    );

    // Injection de la connexion dans le composant
    $some->setConnection($connection);

    $some->someDbTask();

Bon, considérons maintenant que nous utilisons ce composant dans différentes parties de l'application et
que nous ayons besoin de créer la connexion plusieurs fois avant de la transmettre au composant.

Nous pouvons résoudre ceci en créant une sorte de registre global d'où nous obtenons l'instance de la connexion pour ne pas avoir
à la recréer encore et encore:

.. code-block:: php

    <?php

    class Registry
    {
        /**
         * Retourne la connexion
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
         * Attribution d'une connexion externe
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

Maintenant, imaginons que nous devons réaliser deux méthodes dans ce composant, La première doit toujours créer une nouvelle connexion et la seconde doit utiliser une connexion partagée:

.. code-block:: php

    <?php

    class Registry
    {
        protected static $_connection;

        /**
         * Création d'une connexion
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
         * Création unique d'une connexion et la retourne
         */
        public static function getSharedConnection()
        {
            if (self::$_connection === null) {
                self::$_connection = self::_createConnection();
            }

            return self::$_connection;
        }

        /**
         * Retourne toujours une nouvelle connexion
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
         * Attribution d'une connexion externe
         */
        public function setConnection($connection)
        {
            $this->_connection = $connection;
        }

        /**
         * Cette méthode utilise toujours la connexion partagée
         */
        public function someDbTask()
        {
            $connection = $this->_connection;

            // ...
        }

        /**
         * Cette méthode utilise toujours une nouvelle connexion
         */
        public function someOtherDbTask($connection)
        {

        }
    }

    $some = new SomeComponent();

    // Injection de la connexion partagée
    $some->setConnection(
        Registry::getSharedConnection()
    );

    $some->someDbTask();

    // Ici, nous passons toujours une nouvelle connexion en paramètre
    $some->someOtherDbTask(
        Registry::getNewConnection()
    );

Jusque là, nous avons vu comment l'injection de dépendance résout notre problème. Transmettre des dépendances en argument au lieu
de les créer en interne dans le code rend notre application plus maintenable et découplée. Cependant, sur le long terme, cette forme de
dépendance possède quelques inconvénients.

Par exemple, si le composant contient plusieurs dépendances, nous devrons créer plusieurs mutateurs pour transmettre
les dépendances ou créer un constructeur avec plusieurs arguments, créant ainsi systématiquement des dépendances avant d'utiliser
le composant, rendant ainsi le code moins maintenable que nous ne le voudrions:

.. code-block:: php

    <?php

    // Création de la dépendance ou récupération du registre
    $connection = new Connection();
    $session    = new Session();
    $fileSystem = new FileSystem();
    $filter     = new Filter();
    $selector   = new Selector();

    // Passage de paramètres au constructeur
    $some = new SomeComponent($connection, $session, $fileSystem, $filter, $selector);

    // ... ou avec des mutateurs
    $some->setConnection($connection);
    $some->setSession($session);
    $some->setFileSystem($fileSystem);
    $some->setFilter($filter);
    $some->setSelector($selector);

Supposez que nous devions créer cet objet dans différentes parties de notre application. Si, dans le futur, nous n'avions plus besoin de ces
dépendances, nous devrions naviguer au sein du code pour enlever le paramètre des constructeurs ou des accesseurs. Pour résoudre ceci, nous
revenons au registre global pour créer le composant. Toutefois, on ajoute une nouvelle couche d'abstraction avant de créer l'objet:

.. code-block:: php

    <?php

    class SomeComponent
    {
        // ...

        /**
         * Définition d'une méthode de fabrication pour instancier SomeComponent
         * et lui injecter ses dépendances
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

Maintenant, nous nous retrouvons à notre point de départ en ayant une fois de plus recréé les dependances à l'intérieur du composant ! Nous
devons trouver une solution pour éviter de reproduire ces mauvaises pratiques.

Une façon pratique et élégante de résoudre ces problèmes est d'exploiter un conteneur pour dépendances. Ces conteneur agissent comme le registre
global que nous avions vus au préalable. L'utilisation d'un conteneur de dépendances comme passerelle pour obtenir les dépendances nous
permet de réduire la complexité de notre composant:

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
            // Récupération du service de connexion
            // Retourne toujours une nouvelle connexion
            $connection = $this->_di->get("db");
        }

        public function someOtherDbTask()
        {
            // Récupération d'un service de connexion partagé
            // Retourne toujours la même connexion
            $connection = $this->_di->getShared("db");

            // Cette méthode nécessite également un filtre d'entrée
            $filter = $this->_di->get("filter");
        }
    }

    $di = new Di();

    // Inscription d'un service "db" dans le conteneur
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

    // Inscription d'un service "filter" dans le conteneur
    $di->set(
        "filter",
        function () {
            return new Filter();
        }
    );

    // Inscription d'un service "session" dans le conteneur
    $di->set(
        "session",
        function () {
            return new Session();
        }
    );

    // Transmision du conteneur en un seul paramètre
    $some = new SomeComponent($di);

    $some->someDbTask();

Le composant peut maintenant accéder au service dont il n'a besoin que lorsque c'est nécessaire et s'il n'est pas requis il ne sera pas initialisé
épargnant ainsi des ressources. Le composant est désormais fortement découplé. Par exemple nous pouvons remplacer la façon dont la connexion
est créée, son comportement ou tout autre aspect n'affectera pas le composant.
