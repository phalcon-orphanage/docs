Travailler avec des modèles (Avancé)
====================================

Modes d'hydratation de données
------------------------------
Comme mentionné plus haut, les jeux de résultat sont des collections complètes d'objets, ce qui signifie que chaque résultat renvoyé est un objet
qui représente une ligne dans la base de données. Ces objets peuvent être modifiés et re-sauvegardés pour la persistence:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robots = Robots::find();

    // Manipulation d'un jeu complet de résultats d'objets
    foreach ($robots as $robot) {
        $robot->year = 2000;

        $robot->save();
    }

Parfois les enregistrement récupérés ne doivent être présentées à l'utilisateur qu'en lecture seule. Dans ces cas il peut être utile
de changer la manière dont les enregistrement sont présentés afin de faciliter leur manipulation. La statégie utilisée pour présenter
les objets retournés dans un jeu de résultat est appelée "mode d'hydratation":

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Resultset;
    use Store\Toys\Robots;

    $robots = Robots::find();

    // Retourne tous les robots dans un tableau
    $robots->setHydrateMode(
        Resultset::HYDRATE_ARRAYS
    );

    foreach ($robots as $robot) {
        echo $robot["year"], PHP_EOL;
    }

    // Retourne tous les robots dans une stdClass
    $robots->setHydrateMode(
        Resultset::HYDRATE_OBJECTS
    );

    foreach ($robots as $robot) {
        echo $robot->year, PHP_EOL;
    }

    // Retourne tous les robots dans une instance de Robots
    $robots->setHydrateMode(
        Resultset::HYDRATE_RECORDS
    );

    foreach ($robots as $robot) {
        echo $robot->year, PHP_EOL;
    }

Le mode d'hydratation peut également être transmis en paramètre de "find":

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Resultset;
    use Store\Toys\Robots;

    $robots = Robots::find(
        [
            "hydration" => Resultset::HYDRATE_ARRAYS,
        ]
    );

    foreach ($robots as $robot) {
        echo $robot["year"], PHP_EOL;
    }

Les colonnes identité auto-générées
-----------------------------------
Certains modèles peuvent avoir une colonne identité. Ces colonnes servent habituellement de clé primaire dans la table rattachée. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`
peut reconnaître la colonne identité et l'omet dans l'instruction SQL INSERT générée, laissant le SGBD générer ainsi automatiquement la valeur pour lui.
Systématiquement après chaque création d'enregistrement, le champ identité est rempli avec la valeur générée par le SGBD:

.. code-block:: php

    <?php

    $robot->save();

    echo "The generated id is: ", $robot->id;

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` est capable de reconnaître la colonne identité. Selon le SGBD, ces colonnes peut être des
colonnes "serial" comme dans PostgreSQL ou "auto_increment" dans le cas de MySQL.

PostgreSQL utilise les séquences pour générer des valeurs numérique. Par défaut, Phalcon tente d'obtenir les valeurs depuis la séquence "<table>_<field>_seq",
comme par exemple "robots_id_seq". Si cette séquence a un nom différent, alors la méthode "getSequenceName" doit être réalisée:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function getSequenceName()
        {
            return "robots_sequence_name";
        }
    }

Omission de colonnes
--------------------
Pour indiquer à :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` qu'il doit omettre systématiquement des champs lors de la création ou la mise à jour d'enregistrement
afin de déléguer au SGDB la mission d'assigner les valeurs soit par défaut soit par l'intermédiaire d'un déclencheur:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            // Omission de colonnes sur l'INSERT et l'UPDATE
            $this->skipAttributes(
                [
                    "year",
                    "price",
                ]
            );

            // Omis uniquement à la création
            $this->skipAttributesOnCreate(
                [
                    "created_at",
                ]
            );

            // Omis uniquement à la mise à jour
            $this->skipAttributesOnUpdate(
                [
                    "modified_in",
                ]
            );
        }
    }

Ceci ignorera ces champs sur chaque opération d'INSERT ou d'UPDATE pour l'ensemble de l'application.
Si vous voulez ignorer des attributs selon l'opération INSERT ou UPDATE, vous devez spécifier un dexuième paramètre (booléen) - vrai pour le
remplacement. Forcer une nouvelle valeur par défaut peut être réalisée de la façon suivante:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    use Phalcon\Db\RawValue;

    $robot = new Robots();

    $robot->name       = "Bender";
    $robot->year       = 1999;
    $robot->created_at = new RawValue("default");

    $robot->create();

Une fonction de rappel peut être utilisée pour réaliser une assignation conditionnelle des valeurs par défaut:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;
    use Phalcon\Db\RawValue;

    class Robots extends Model
    {
        public function beforeCreate()
        {
            if ($this->price > 10000) {
                $this->type = new RawValue("default");
            }
        }
    }

.. highlights::

    N'utilisez jamais :doc:`Phalcon\\Db\\RawValue <../api/Phalcon_Db_RawValue>` pour assigner des valeurs externes (comme les entrées utilisateur)
    ou des données variables. Les valeurs de ces champs sont ignorées lors de la liaison de paramètres à la requête.
    Ceci peut être sujet à des attaques par injection SQL.

Mise à jour dynamique
^^^^^^^^^^^^^^^^^^^^^
Par défaut, les instructions SQL UPDATE sont créées avec toutes les colonnes définies dans le modèle (full all-field SQL update). 
Vous pouvez modifier des modèles spécifique pour réaliser des mises à jour dynamiques. Dans ce cas, seuls les champs qui ont changé
seront utilisés dans l'instruction SQL finale.

Dans certains cas, cela peut améliorer les performances en réduisant le trafic entre l'application et le serveur de base de données.
Ceci est particulièrement utiles lorsque la table contient des champs blob ou textuels:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->useDynamicUpdate(true);
        }
    }

Correspondance indépendante de colonnes
---------------------------------------
L'ORM supporte une correspondance indépendante de colonnes, ce qui permet au développeur d'utiliser des noms de colonnes dans le modèles différents de ceux 
de la table. Phalcon reconnaîtra les nouveaux noms de colonnes et les renommera pour qu'ils correspondent aux colonnes respectives dans la base.
Ceci est une caractéristique intéressante lorsqu'on a besoin de renommer des champs sans avoir à se soucier de toutes les requêtes 
du code. Un simple changement dans la correspondance de colonnes et le modèle s'occupera du reste. Par exemple:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public $code;

        public $theName;

        public $theType;

        public $theYear;

        public function columnMap()
        {
            // Les clés sont les vrais noms dans la table et 
            // Les valeurs sont leur noms dans l'application
            return [
                "id"       => "code",
                "the_name" => "theName",
                "the_type" => "theType",
                "the_year" => "theYear",
            ];
        }
    }

Ainsi vous pouvez utilisez simplement les nouveaux noms dans votre code:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Rechercher un robot par son nom
    $robot = Robots::findFirst(
        "theName = 'Voltron'"
    );

    echo $robot->theName, "\n";

    // Récupérer les robots triés par type
    $robot = Robots::find(
        [
            "order" => "theType DESC",
        ]
    );

    foreach ($robots as $robot) {
        echo "Code: ", $robot->code, "\n";
    }

    // Création d'un robot
    $robot = new Robots();

    $robot->code    = "10101";
    $robot->theName = "Bender";
    $robot->theType = "Industrial";
    $robot->theYear = 2999;

    $robot->save();

Prenez en considération ce qui suit lors du renommage de colonnes:

* Les références aux attributs dans les relations et validateurs doivent utiliser les nouveaux noms
* Se référer au nom réel résultera en une exception de la part de l'ORM

La correspondance indépendante de colonnes vous permet:

* D'écrire des application en utilisant vos propre conventions
* D'éliminer les suffixe ou préfixe dans votre code
* De renommer les colonnes sans avoir à modifier le code de votre application

Instantanés d'enregistrements
-----------------------------
Des modèles spéciaux peuvent être définis pour maintenir un instantané d'enregistrements lors de l'interrogation. Vous pouvez utiliser cette caractéristique pour 
mettre en œuvre un audit ou bien juste pour savoir quels sont les champs qui ont changés depuis leur dernière interrogation:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->keepSnapshots(true);
        }
    }

En activant cette caractéristique, l'application consomme un peu plus de mémoire pour conserver les valeurs d'origine obtenues depuis la persistance.
Dans les modèles qui ont activés cette caractéristique vous pouvez vérifier quels sont les champs qui ont changé:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Récupère un enregistrement depuis la base
    $robot = Robots::findFirst();

    // Modifie une colonne
    $robot->name = "Other name";

    var_dump($robot->getChangedFields()); // ["name"]

    var_dump($robot->hasChanged("name")); // true

    var_dump($robot->hasChanged("type")); // false

Pointer un schéma différent
---------------------------
Si un modèle est rattaché à une table qui se trouve dans un autre schéma ou base que celui par défaut, vous pouvez utiliser la méthode :code:`setSchema()` pour définir cela:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->setSchema("toys");
        }
    }

Définition de plusieurs bases de données
----------------------------------------
Dans Phalcon, tous les modèles peuvent dépendre de la même connexion à la base de données ou en avoir un particulier. Actuellement, 
lorsque :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` a besoin de se connecter à la base, il interroge le service "db" dans le 
container de services de l'application. Vous pouvez surcharger le paramétrage de ce service dans la méthode :code:`initialize()`:

.. code-block:: php

    <?php

    use Phalcon\Db\Adapter\Pdo\Mysql as MysqlPdo;
    use Phalcon\Db\Adapter\Pdo\PostgreSQL as PostgreSQLPdo;

    // Ce service retourne une base de données MySQL
    $di->set(
        "dbMysql",
        function () {
            return new MysqlPdo(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo",
                ]
            );
        }
    );

    // Ce service retourne une base de données PostgreSQL
    $di->set(
        "dbPostgres",
        function () {
            return new PostgreSQLPdo(
                [
                    "host"     => "localhost",
                    "username" => "postgres",
                    "password" => "",
                    "dbname"   => "invo",
                ]
            );
        }
    );

Ainsi, dans la méthode :code:`initialize()`, nous définissons le service de connexion pour le modèle:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->setConnectionService("dbPostgres");
        }
    }

Mais Phalcon offre encore plus de flexibilité, nous pouvons définir une connexion pour la lecture et une pour l'écriture. Ceci est particulièrement utile
pour équilibrer la charge entre les bases de données dans une architecture maître-esclave:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->setReadConnectionService("dbSlave");

            $this->setWriteConnectionService("dbMaster");
        }
    }

L'ORM fournit aussi la capacité d'`Horizontal Sharding`_, en vous permettant de mettre en place une sélection de "shard"
en fonction des conditions actuelles de la requête:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        /**
         * Sélection dynamique d'un shard
         *
         * @param array $intermediate
         * @param array $bindParams
         * @param array $bindTypes
         */
        public function selectReadConnection($intermediate, $bindParams, $bindTypes)
        {
            // Vérifie la présence d'une clause 'where'
            if (isset($intermediate["where"])) {
                $conditions = $intermediate["where"];

                // Choix des shard potentiels en fonction des conditions
                if ($conditions["left"]["name"] === "id") {
                    $id = $conditions["right"]["value"];

                    if ($id > 0 && $id < 10000) {
                        return $this->getDI()->get("dbShard1");
                    }

                    if ($id > 10000) {
                        return $this->getDI()->get("dbShard2");
                    }
                }
            }

            // Utilisation du shard par défaut
            return $this->getDI()->get("dbShard0");
        }
    }

La méthode :code:`selectReadConnection()` est appelée pour sélectionner la bonne connexion. Cette méthode intercepte chaque
nouvelle requête exécutée:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst('id = 101');

Injection de services dans les modèles
--------------------------------------
Si vous devez accéder aux services de l'application à partir d'un modèle, l'exemple qui suit vous montre comment faire:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function notSaved()
        {
            // Obtention du service flash à partir du conteneur DI
            $flash = $this->getDI()->getFlash();

            $messages = $this->getMessages();

            // Affiche les messages de validation
            foreach ($messages as $message) {
                $flash->error($message);
            }
        }
    }

L'événement "notSaved" est déclenché à chaque échec des actions "create" ou "update". Ainsi nous envoyons les messages de validation
dans le service "flash" obtenu depuis le conteneur DI. En faisant comme cela, nous n'avons par besoin d'imprimer le message après chaque sauvegarde.

Activation/Désactivation de fonctionnalités
-------------------------------------------
Dans l'ORM nous avons mis en place un mécanisme qui vous permette d'activer ou de désactiver à la volée des fonctionnalités particulière ou des options.
Vous pouvez désactiver de que vous n'utilisez pas dans l'ORM. Ces options peuvent également être désactivées temporairement si nécessaire:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    Model::setup(
        [
            "events"         => false,
            "columnRenaming" => false,
        ]
    );

Les options sont:

+---------------------+-----------------------------------------------------------------------------------------+---------------+
| Option              | Description                                                                             | Défaut        |
+=====================+=========================================================================================+===============+
| events              | Enables/Disables les rappels, crochets et notifications d'événement de tous les modèles | :code:`true`  |
+---------------------+-----------------------------------------------------------------------------------------+---------------+
| columnRenaming      | Active/Désactive le renommage de colonnes                                               | :code:`true`  |
+---------------------+-----------------------------------------------------------------------------------------+---------------+
| notNullValidations  | L'ORM valide automatiquement les colonnes non nulles présentes dans la table rattachée  | :code:`true`  |
+---------------------+-----------------------------------------------------------------------------------------+---------------+
| virtualForeignKeys  | Active/Désactive les clés étrangères virtuelles                                         | :code:`true`  |
+---------------------+-----------------------------------------------------------------------------------------+---------------+
| phqlLiterals        | Active/Désactive les littéraux dans le parser PHQL                                      | :code:`true`  |
+---------------------+-----------------------------------------------------------------------------------------+---------------+
| lateStateBinding    | Active/Désactive l'état tardif de la méthode :code:`Mvc\Model::cloneResultMap()`        | :code:`false` |
+---------------------+-----------------------------------------------------------------------------------------+---------------+

Composant autonome
------------------
L'utilisation de :doc:`Phalcon\\Mvc\\Model <models>` en mode autonome est montrée ci-dessous:

.. code-block:: php

    <?php

    use Phalcon\Di;
    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Manager as ModelsManager;
    use Phalcon\Db\Adapter\Pdo\Sqlite as Connection;
    use Phalcon\Mvc\Model\Metadata\Memory as MetaData;

    $di = new Di();

    // Etablissement d'une connexion
    $di->set(
        "db",
        new Connection(
            [
                "dbname" => "sample.db",
            ]
        )
    );

    // Définition d'un gestionnaire de modèles
    $di->set(
        "modelsManager",
        new ModelsManager()
    );

    // Utilisation d'un adaptateur de métadonnées
    $di->set(
        "modelsMetadata",
        new MetaData()
    );

    // Création d'un modèle
    class Robots extends Model
    {

    }

    // Utilisation du modèle
    echo Robots::count();

.. _Horizontal Sharding: https://en.wikipedia.org/wiki/Shard_(database_architecture)
