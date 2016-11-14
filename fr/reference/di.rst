Injection de dépendance/Localisation de Service
***********************************************

.. highlights::

    Before reading this section, it is wise to read :doc:`the section which explains why Phalcon uses service location and dependency injection <di-explained>`.

:doc:`Phalcon\\Di <../api/Phalcon_Di>` est un composant qui met en œuvre l'Injection de Dépendance et la Localisation de Service et il est lui-même un conteneur pour cela.

Comme Phalcon est fortement découplé, :doc:`Phalcon\\Di <../api/Phalcon_Di>` est essentiel pour intégrer les différents composants dans le framework. Le développeur
peut également exploiter ce composant pour injecter des dépendances et gérer les instances globales des différentes classes utilisées dans l'application.

A la base, ce composant implémente le patron `Inversion de Contrôle`_. En appliquant cela, les objets ne recoivent pas leur dépendances en utilisant
des accesseurs ou des constructeurs, mais en interrogeant un service injecteur de dépendance. Ceci réduit la complexité tant qu'il n'y aura qu'une seule
façon d'obtenir les dépendances nécessaires au composant.

De plus, ce patron augmente la testabilité du code, le rendant ainsi moins vulnérable aux erreurs.

Inscription de services dans le conteneur
=========================================
Le framework comme le développeur peuvent inscrire des service. Lorqu'un composant A nécessite un composant B (ou une instance de cette classe)
pour fonctionner, il peut demander le composant B au conteneur plutôt que créer une nouvelle instance du composant B.

Cette façon de faire procure plusieurs avantages:

* Nous pouvons facilement remplacer un composant par un autre réalisé par nos soins ou un tiers.
* Nous avons un contrôle complet sur l'initialisation de l'objet, nous permettant de préparer les objets comme nous le souhaitons avant de les livrer aux composants.
* Nous pouvons récupérer des instances globales de composant, d'une manière structurée et unifiée.

Plusieurs styles de définitions permettent d'inscrire les services:

Inscription simple
------------------
Comme vu précédemment, il existe plusieurs façons d'inscrire un service. Voici ceux que nous appelons "simple":

Chaîne de caractères (string)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Ce mode s'attend à un nom de classe valide, retournant un objet de la classe spécifiée, qui si elle n'est pas chargée, le sera en utilisant un chargeur automatique de classes.
Ce mode de définition ne permet pas de spécifier des arguments pour constructeur de la classe ni des paramètres:

.. code-block:: php

    <?php

    // Return new Phalcon\Http\Request();
    $di->set(
        "request",
        "Phalcon\\Http\\Request"
    );

Instance de classe
^^^^^^^^^^^^^^^^^^
Ce mode s'attend à un objet. Comme l'objet n'a pas besoin d'être résolu puisqu'il est déjà un objet,
certains diront que ce n'est pas vraiment une injection de dépendance. Toutefois, cela peut être utile
si vous souhaitez forcer la dépendance retournée à être toujours le même objet 
ou la même valeur:

.. code-block:: php

    <?php

    use Phalcon\Http\Request;

    // Return new Phalcon\Http\Request();
    $di->set(
        "request",
        new Request()
    );

Fermetures (Closures)/Fonctions anonymes:
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Cette méthode offre une grande liberté pour construire les dépendances comme désirées, cependant il est difficile
de changer extérieurement sans avoir à changer complètement la définition de la dépendance:

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

Certaines limites peuvent être contournées en passant des variables supplémentaires à l'environnement de la fermeture:

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

    // Utilisation de la variable $config dans la portée courante.
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

Vous pouvez également accéder à d'autres services DI en utilisant la méthode :code:`get()`:

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
                    "username" => "utilisateur",
                    "password" => "mot_de_passe",
                    "dbname"   => "ma_base_de_donnees",
                ]
            );
        }
    );

    // Avec le service 'config' du DI
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

Inscription Complexe
--------------------
S'il est nécessaire de changer la définition d'un service sans devoir instancier/résoudre le service, nous devrons alors
définir les services en utilisant la syntaxe tableau. La définition d'un service sous forme de tableau
peut être un peu plus verbeuse:

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as LoggerFile;

    // Inscription d'un service "logger" avec un nom de classe et ses paramètres
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

    // En utilisant une fonction anonyme
    $di->set(
        "logger",
        function () {
            return new LoggerFile("../apps/logs/error.log");
        }
    );

Les deux inscriptions précédentes produisent le même résultat. Cependant, la définition sous forme de tableau
permet une altération des paramètres du service si nécessaire:

.. code-block:: php

    <?php

    // Changement du nom de service
    $di->getService("logger")->setClassName("MyCustomLogger");

    // Changement du premier paramètre sans instancier le logger
    $di->getService("logger")->setParameter(
        0,
        [
            "type"  => "parameter",
            "value" => "../apps/logs/error.log",
        ]
    );

De plus, en utilisant la syntaxe tableau, vous pouvez exploiter trois type d'injection de dépendance:

Injection de constructeur
^^^^^^^^^^^^^^^^^^^^^^^^^
Ce type d'injection transmet les dépendances au constructeur de la classe.
Admettons que nous ayons le composant suivant:

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

Le service peut être inscrit de cette façon:

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

Le service "response" (:doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>`) est résolu pour être transmis en premier argument au constructeur,
alors que le second est une valeur booléenne (true) transmise telle quelle.

Injection d'accesseur
^^^^^^^^^^^^^^^^^^^^^
Les classes peuvent posséder des accesseurs pour injecter des dépendances optionnelles. Nos précédentes classes peuvent être modifiées pour
accepter des dépendances avec des accesseurs:

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

Un service avec une injection par accesseur peut être inscrite comme suit:

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

Injection de propriétés
^^^^^^^^^^^^^^^^^^^^^^^
Une stratégie moins courante est d'injecter directement des dépendances ou des paramètres aux attributs publics de la classe:

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

Un service avec un injection de propriétés peut être inscrite comme suit:

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

Les différents types de paramètre supportés sont les suivants:

+-------------+-----------------------------------------------------------+-----------------------------------------------------------------------------------+
| Type        | Description                                               | Exemple                                                                           |
+=============+===========================================================+===================================================================================+
| paramètre   | Représente une valeur littérale transmise en paramètre    | :code:`["type" => "parameter", "value" => 1234]`                                  |
+-------------+-----------------------------------------------------------+-----------------------------------------------------------------------------------+
| service     | Représente un autre service dans le conteneur de services | :code:`["type" => "service", "name" => "request"]`                                |
+-------------+-----------------------------------------------------------+-----------------------------------------------------------------------------------+
| instance    | Représente un objet qui doit être construit dynamiquement | :code:`["type" => "instance", "className" => "DateTime", "arguments" => ["now"]]` |
+-------------+-----------------------------------------------------------+-----------------------------------------------------------------------------------+

La résolution d'un service dont la définition est complexe peut être légèrement plus lente que pour les définitions simples vues précédemment. Cependant,
ceci fournit une approche plus robuste pour définir et injecter des services.

Le mélange de différents types de définitions est permis. Chacun décide de la méthode d'inscription des service la plus appropriée en
fonction des besoins de l'application.

Forme tableau
-------------
L'écriture sous forme de tableau est possible pour inscrire des services:

.. code-block:: php

    <?php

    use Phalcon\Di;
    use Phalcon\Http\Request;

    // Création du conteneur d'Injection de Dépendance
    $di = new Di();

    // D'après son nom
    $di["request"] = "Phalcon\\Http\\Request";

    // Chargement tardif avec une fonction anonyme
    $di["request"] = function () {
        return new Request();
    };

    // En inscrivant directement une instance
    $di["request"] = new Request();

    // Avec un tableau de définition
    $di["request"] = [
        "className" => "Phalcon\\Http\\Request",
    ];

Dans les exemples précédents, lorsque le framework doit accéder aux données demandées, il interroge le service identifié en tant que 'request' dans le conteneur.
Le conteneur retourne une instance du service demandé. Le développeur peut éventuellement remplacer les composants selon ses besoins.

Chacune des méthodes (vues dans les exemples précédents) utilisée pour définir/inscrire un service a ses avantages et ses inconvénients. C'est au
développeur de choisir laquelle utiliser en fonction des exigences.

Définir un service par une chaîne de caractères est simple mais manque de souplesse. Définir un service par un tableau offre plus de flexibilité mais
rend le code plus compliqué. La fonction lambda est un bon équilibre entre les deux mais risque de nécessiter plus de maintenance que nécessaire.

:doc:`Phalcon\\Di <../api/Phalcon_Di>` offre un chargement tardif pour chaque service qu'il stocke. A moins que le développeur choisisse d'instancier directement et de le stocker
dans le conteneur, chaque objet qui lui est confié (via tableau, chaîne de caractères, etc.) sera chargé tardivement c.à.d instancié lors de la demande.

Résolution de services
======================
L'obtention d'un service à partir d'un conteneur peut se faire simplement en utilisant la méthode "get". Une nouvelle instance du service sera retournée:

.. code-block:: php

    <?php $request = $di->get("request");

Ou en invoquant la méthode magique:

.. code-block:: php

    <?php

    $request = $di->getRequest();

Ou en utilisant l'écriture tableau:

.. code-block:: php

    <?php

    $request = $di["request"];

Les arguments sont transmis au constructeur en ajoutant un tableau en paramètre de la méthode "get":

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

Evénements
----------
:doc:`Phalcon\\Di <../api/Phalcon_Di>` est capable d'envoyer des événements à un :doc:`EventsManager <events>` s'il existe.
Les événements sont déclenchés en utilisant le type "di". Les événements qui retourne la valeur booléenne faux peuvent interrompre l'opération en cours.
Les événements suivants son supportés:

+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------+----------------------+--------------------+
| Nom d'événement      | Déclenchement                                                                                                                                   | Stoppe l'opération ? | Destinataire       |
+======================+=================================================================================================================================================+======================+====================+
| beforeServiceResolve | Déclenché avant la résolution de service. Les écouteurs reçoivent le nom du service ainsi que les paramètres qui lui sont transmis              | Non                  | Ecouteurs          |
+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------+----------------------+--------------------+
| afterServiceResolve  | Déclenché avant la résolution de service. Les écouteurs reçoivent le nom du service, l'instance, ainsi que les paramètres qui lui sont transmis | Non                  | Ecouteurs          |
+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------+----------------------+--------------------+

Services partagés
=================
Les services peuvent être inscrits en tant que service "partagé". Ceci signifie qu'ils se comporteront toujours comme des singletons_. Une fois que le service est résolu une première fois
la même instance est systématiquement retournée lorsqu'un consommateur récupère le service depuis le conteneur:

.. code-block:: php

    <?php

    use Phalcon\Session\Adapter\Files as SessionFiles;

    // Inscription du service de session comme "toujours partagé"
    $di->setShared(
        "session",
        function () {
            $session = new SessionFiles();

            $session->start();

            return $session;
        }
    );

    // Localisation du service pour la première fois
    $session = $di->get("session");

    // Retourne l'objet instancié initialement
    $session = $di->getSession();

Une autre façon d'inscrire des services partagés est de transmettre "true" au troisième paramètre de "set":

.. code-block:: php

    <?php

    // Inscription du service de session comme "toujours partagé"
    $di->set(
        "session",
        function () {
            // ...
        },
        true
    );

Si un service n'est pas inscrit comme partagé et vous voulez être sûr d'accéder à une instance partagée à chaque fois
que le service est obtenu auprès de DI, vous pouvez utiliser la méthode 'getShared':

.. code-block:: php

    <?php

    $request = $di->getShared("request");

Manipuler les services individuellement
=======================================
Une fois qu'un service est inscrit dans le conteneur de services, vous pouvez le récupérer pour le manipuler individuellement:

.. code-block:: php

    <?php

    use Phalcon\Http\Request;

    // Inscription du service "request"
    $di->set("request", "Phalcon\\Http\\Request");

    // Récupère le service
    $requestService = $di->getService("request");

    // Modifie sa définition
    $requestService->setDefinition(
        function () {
            return new Request();
        }
    );

    // Le transforme en "partagé"
    $requestService->setShared(true);

    // Résolution du service (retourne un instance de Phalcon\Http\Request)
    $request = $requestService->resolve();

Instanciation de classes via le Conteneur de Services
=====================================================
Lorsque vous demandez un service au conteneur de services, s'il n'en trouve pas un avec le même nom, il tente de charger une classe avec
le même nom. Grâce à ce comportement nous pouvons remplacer n'importe quelle autre simplement en inscrivant un service avec son nom:

.. code-block:: php

    <?php

    // Inscription d'un contrôleur en tant que service
    $di->set(
        "IndexController",
        function () {
            $component = new Component();

            return $component;
        },
        true
    );

    // Inscription d'un contrôleur en tant que service
    $di->set(
        "MyOtherComponent",
        function () {
            // Actuellement retourne un autre composant
            $component = new AnotherComponent();

            return $component;
        }
    );

    // Création d'un instance via le conteneur de service.
    $myComponent = $di->get("MyOtherComponent");

Vous pouvez profiter de ceci en instanciant toujours vos classes depuis le conteneur de services (même s'ils ne sont pas inscrits en tant que service).
Le DI prendra par défaut un chargeur automatique valide pour charger la classe. En faisant comme ceci, vous pourrez aisément replacer n'importe quelle
classe en implémentant une définition pour elle.

Injection automatique pour le DI lui-même
=========================================
Si une classe ou un composant ai besoin que le DI localise lui-même les services, le DI peut automatiquement s'injecter les instances qu'il crée.
Pour ceci, vous devez implémenter l'interface :doc:`Phalcon\\Di\\InjectionAwareInterface <../api/Phalcon_Di_InjectionAwareInterface>` dans vos classes:

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

Une fois que le service est résolu, la variable :code:`$di` sera transmise automatiquement à :code:`setDi()`:

.. code-block:: php

    <?php

    // Inscription du service
    $di->set("myClass", "MyClass");

    // Résolution du service (NOTE: $myClass->setDi($di) est automatiquement appélée)
    $myClass = $di->get("myClass");

Organisation des services en fichiers
=====================================
Vous pouvez mieux organiser votre application en déplaçant l'inscription des services dans des fichiers distincts
au lieu de tout mettre dans l'amorce de l'application:

.. code-block:: php

    <?php

    $di->set(
        "router",
        function () {
            return include "../app/config/routes.php";
        }
    );

Ainsi le fichier ("../app/config/routes.php") renvoi l'objet résolu:

.. code-block:: php

    <?php

    $router = new MyRouter();

    $router->post("/login");

    return $router;

Accès au DI de manière statique
===============================
Si nécessaire, vous pouvez accéder au dernier DI créé dans une fonction statique de la façon suivante:

.. code-block:: php

    <?php

    use Phalcon\Di;

    class SomeComponent
    {
        public static function someMethod()
        {
            // Récupère le service de session
            $session = Di::getDefault()->getSession();
        }
    }

Construction du DI par défaut
=============================
Bien que le caractère découplé de Phalcon offre une grande liberté et flexibilité, peut-être que nous voulons simplement l'utiliser comme un framework full-stack.
Pour réaliser ceci, le framework fournit une variante de :doc:`Phalcon\\Di <../api/Phalcon_Di>` appelée :doc:`Phalcon\\Di\\FactoryDefault <../api/Phalcon_Di_FactoryDefault>`.
Cette classe inscrit automatiquement les services appropriés qui sont encapsulés dans le framework afin qu'il agisse comme un full-stack.

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault;

    $di = new FactoryDefault();

Convention de nommage des services
==================================
Bien que vous puissiez inscrire les services avec le nom que vous voulez, Phalcon a plusieurs conventions de nommage qui permettent
d'obtenir le bon service (built-in) au bon moment.

+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| Nom de service      | Description                                           | Par défaut                                                                                         | Partagé |
+=====================+=======================================================+====================================================================================================+=========+
| dispatcher          | Service de ventilation des contrôleurs                | :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>`                                    | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| router              | Service de routage                                    | :doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>`                                            | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| url                 | Service de génération d'URL                           | :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>`                                                  | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| request             | HTTP Request Environment Service                      | :doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>`                                        | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| response            | HTTP Response Environment Service                     | :doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>`                                      | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| cookies             | HTTP Cookies Management Service                       | :doc:`Phalcon\\Http\\Response\\Cookies <../api/Phalcon_Http_Response_Cookies>`                     | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| filter              | Service de filtrage des entrées                       | :doc:`Phalcon\\Filter <../api/Phalcon_Filter>`                                                     | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| flash               | Service des messages flash                            | :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>`                                        | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| flashSession        | Service de session des messages flash                 | :doc:`Phalcon\\Flash\\Session <../api/Phalcon_Flash_Session>`                                      | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| session             | Service de session                                    | :doc:`Phalcon\\Session\\Adapter\\Files <../api/Phalcon_Session_Adapter_Files>`                     | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| eventsManager       | Service de gestion des événements                     | :doc:`Phalcon\\Events\\Manager <../api/Phalcon_Events_Manager>`                                    | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| db                  | Service élémentaire de connexion aux bases de données | :doc:`Phalcon\\Db <../api/Phalcon_Db>`                                                             | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| security            | Auxiliaires de sécurité                               | :doc:`Phalcon\\Security <../api/Phalcon_Security>`                                                 | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| crypt               | Cryptage/Décryptage                                   | :doc:`Phalcon\\Crypt <../api/Phalcon_Crypt>`                                                       | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| tag                 | Aide de génération HTML                               | :doc:`Phalcon\\Tag <../api/Phalcon_Tag>`                                                           | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| escaper             | Echappement contextuel                                | :doc:`Phalcon\\Escaper <../api/Phalcon_Escaper>`                                                   | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| annotations         | Analyseur d'annotations                               | :doc:`Phalcon\\Annotations\\Adapter\\Memory <../api/Phalcon_Annotations_Adapter_Memory>`           | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| modelsManager       | Service de gestion des modèles                        | :doc:`Phalcon\\Mvc\\Model\\Manager <../api/Phalcon_Mvc_Model_Manager>`                             | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| modelsMetadata      | Service de métadonnées des modèles                    | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Memory <../api/Phalcon_Mvc_Model_MetaData_Memory>`            | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| transactionManager  | Service de gestion des transactions                   | :doc:`Phalcon\\Mvc\\Model\\Transaction\\Manager <../api/Phalcon_Mvc_Model_Transaction_Manager>`    | Oui     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| modelsCache         | Cache pour les modèles coté serveur                   | Aucun                                                                                              | Non     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+
| viewsCache          | Cache des fragments de vue coté serveur               | Aucun                                                                                              | Non     |
+---------------------+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+---------+

Création de votre propre DI
===========================
Pour remplacer le DI fournit par Phalcon, vous devez soit implementer l'interface :doc:`Phalcon\\DiInterface <../api/Phalcon_DiInterface>`, soit étendre un existant.

.. _`Inversion de Contrôle`: http://fr.wikipedia.org/wiki/Inversion_de_contr%C3%B4le
.. _singletons: http://fr.wikipedia.org/wiki/Singleton_(patron_de_conception)
