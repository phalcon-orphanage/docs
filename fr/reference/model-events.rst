Evénements et Modèles
=====================

Événements et Gestionnaire d'événements
---------------------------------------
Les modèles vous permettent d'écrire des événements qui seront générés lors de la réalisation d'une insertion/mise à jour(m.à.j.)/suppression. Il permettent de définir les règles métiers. Ce qui suit sont les événements supportés par :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` et leur ordre d'exécution:

+--------------------+--------------------------+------------------------+-------------------------------------------------------------------------------------------------------------------------------------+
| Opération          | Nom                      | Opération stoppée ?   | Explication                                                                                                                          |
+====================+==========================+=======================+======================================================================================================================================+
| insertion / m.à.j. | beforeValidation         | Oui                    | Est exécuté avant la validation des champs sur du texte nul ou vide ou bien des clés étrangères                                     |
+--------------------+--------------------------+------------------------+-------------------------------------------------------------------------------------------------------------------------------------+
| insertion          | beforeValidationOnCreate | Oui                    | Est exécuté avant la validation des champs sur du texte nul ou vide ou bien des clés étrangères lors d'une opération d'insertion    |
+--------------------+--------------------------+------------------------+-------------------------------------------------------------------------------------------------------------------------------------+
| m.à.j.             | beforeValidationOnUpdate | Oui                    | Est exécuté avant la validation des champs sur du texte nul ou vide ou bien des clés étrangères lors d'une opération de mise à jour |
+--------------------+--------------------------+------------------------+-------------------------------------------------------------------------------------------------------------------------------------+
| insertion / m.à.j. | onValidationFails        | Oui (systématiquement) | Est exécuté lors de l'échec d'une validation d'intégrité                                                                            |
+--------------------+--------------------------+------------------------+-------------------------------------------------------------------------------------------------------------------------------------+
| insertion          | afterValidationOnCreate  | Oui                    | Est exécuté après la validation des champs sur du texte nul ou vide ou bien des clés étrangères lors d'une opération d'insertion    |
+--------------------+--------------------------+------------------------+-------------------------------------------------------------------------------------------------------------------------------------+
| m.à.j.             | afterValidationOnUpdate  | Oui                    | Est exécuté après la validation des champs sur du texte nul ou vide ou bien des clés étrangères lors d'une opération de mise à jour |
+--------------------+--------------------------+------------------------+-------------------------------------------------------------------------------------------------------------------------------------+
| insertion / m.à.j. | afterValidation          | Oui                    | Est exécuté après la validation des champs sur du texte nul ou vide ou bien des clés étrangères                                     |
+--------------------+--------------------------+------------------------+-------------------------------------------------------------------------------------------------------------------------------------+
| insertion / m.à.j. | beforeSave               | Oui                    | Lancé avant l'opération requise sur le SGBD                                                                                         |
+--------------------+--------------------------+------------------------+-------------------------------------------------------------------------------------------------------------------------------------+
| m.à.j.             | beforeUpdate             | Oui                    | Lancé avant l'opération de mise à jour requise sur le SGBD                                                                          |
+--------------------+--------------------------+------------------------+-------------------------------------------------------------------------------------------------------------------------------------+
| insertion          | beforeCreate             | Oui                    | Lancé avant l'opération d'insertion requise sur le SGBD                                                                             |
+--------------------+--------------------------+------------------------+-------------------------------------------------------------------------------------------------------------------------------------+
| m.à.j.             | afterUpdate              | Non                    | Lancé après l'opération de mise à jour requise sur le SGBD                                                                          |
+--------------------+--------------------------+------------------------+-------------------------------------------------------------------------------------------------------------------------------------+
| insertion          | afterCreate              | Non                    | Lancé après l'opération d'insertion requise sur le SGBD                                                                             |
+--------------------+--------------------------+------------------------+-------------------------------------------------------------------------------------------------------------------------------------+
| insertion / m.à.j. | afterSave                | Non                    | Lancé après l'opération requise sur le SGBD                                                                                         |
+--------------------+--------------------------+------------------------+-------------------------------------------------------------------------------------------------------------------------------------+

Mise en œuvre d'événements dans la classe du Modèle
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
La façon la plus facile pour faire en sorte qu'un modèle réagisse aux événement est de réaliser dans la classe une méthode du même nom que l'événement:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function beforeValidationOnCreate()
        {
            echo "Ceci est exécuté avant la création d'un Robot !";
        }
    }

Les événements peuvent être utiles pour assigner des valeurs avant la réalisation d'une opération comme par exemple:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Products extends Model
    {
        public function beforeCreate()
        {
            // Établir la date de création
            $this->created_at = date("Y-m-d H:i:s");
        }

        public function beforeUpdate()
        {
            // Établir la date de modification
            $this->modified_in = date("Y-m-d H:i:s");
        }
    }

Utilisation d'un Gestionnaire d'Événements personnalisé
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
De plus, ce composant est intégré dans :doc:`Phalcon\\Events\\Manager <../api/Phalcon_Events_Manager>`,
ce qui signifie que nous pouvons créer des écouteurs qui s'exécutent lors du déclenchement d'un événement.

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    class Robots extends Model
    {
        public function initialize()
        {
            $eventsManager = new EventsManager();

            // Attache une fonction anonyme pour écouter les événements de "model"
            $eventsManager->attach(
                "model:beforeSave",
                function (Event $event, $robot) {
                    if ($robot->name === "Scooby Doo") {
                        echo "Scooby Doo isn't a robot!";

                        return false;
                    }

                    return true;
                }
            );

            // Attache le gestionnaire d'événement à l'événement
            $this->setEventsManager($eventsManager);
        }
    }

Dans l'exemple précédent, le Gestionnaire d'Événements agit comme un pont entre l'objet et l'écouteur (la fonction anonyme).
Les événements fuseront vers les écouteurs lors de la sauvegarde de 'robots':

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->name = "Scooby Doo";
    $robot->year = 1969;

    $robot->save();

Si vous voulez que tous les objets créés dans votre application utilisent le même EventsManager, vous devez alors l'assigner au Gestionnaire de Modèles:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    // Inscription du service "modelsManager"
    $di->setShared(
        "modelsManager",
        function () {
            $eventsManager = new EventsManager();

        // Attache une fonction anonyme en tant qu'écouteur pour les événements de "model"
            $eventsManager->attach(
                "model:beforeSave",
                function (Event $event, $model) {
					// Capture les événements produits par le modèle "Robots"
                    if (get_class($model) === "Store\\Toys\\Robots") {
                        if ($model->name === "Scooby Doo") {
                            echo "Scooby Doo isn't a robot!";

                            return false;
                        }
                    }

                    return true;
                }
            );

        // Établissement d'un EventsManager par défaut
            $modelsManager = new ModelsManager();

            $modelsManager->setEventsManager($eventsManager);

            return $modelsManager;
        }
    );

Si un écouteur retourne "faux" alors ceci interrompt l'opération en cours d'exécution.

Journalisation des instructions SQL de bas niveau
-------------------------------------------------
Losrqu'on utilise un composant de haut niveau d'abstraction tel que :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` pour accéder aux données, il devient
difficile de savoir quelles sont les instructions qui sont finalement envoyées au SGBD. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`
est supporté en interne par :doc:`Phalcon\\Db <../api/Phalcon_Db>`. :doc:`Phalcon\\Logger <../api/Phalcon_Logger>` interagit avec 
:doc:`Phalcon\\Db <../api/Phalcon_Db>`, fournissant des capacités de journalisation sur la couche d'abstraction de la base de données, ce qui nous permet
de journaliser les instructions quand elles surviennent.

.. code-block:: php

    <?php

    use Phalcon\Logger;
    use Phalcon\Events\Manager;
    use Phalcon\Logger\Adapter\File as FileLogger;
    use Phalcon\Db\Adapter\Pdo\Mysql as Connection;

    $di->set(
        "db",
        function () {
            $eventsManager = new EventsManager();

            $logger = new FileLogger("app/logs/debug.log");

            // Ecoute tous les événements de la base de données
            $eventsManager->attach(
                "db:beforeQuery",
                function ($event, $connection) use ($logger) {
                    $logger->log(
                        $connection->getSQLStatement(),
                        Logger::INFO
                    );
                }
            );

            $connection = new Connection(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo",
                ]
            );

            // Assign the eventsManager to the db adapter instance
            $connection->setEventsManager($eventsManager);

            return $connection;
        }
    );

As models access the default database connection, all SQL statements that are sent to the database system will be logged in the file:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->name       = "Robby the Robot";
    $robot->created_at = "1956-07-21";

    if ($robot->save() === false) {
        echo "Cannot save robot";
    }

As above, the file *app/logs/db.log* will contain something like this:

.. code-block:: irc

    [Mon, 30 Apr 12 13:47:18 -0500][DEBUG][Resource Id #77] INSERT INTO robots
    (name, created_at) VALUES ('Robby the Robot', '1956-07-21')

Profiling SQL Statements
------------------------
Thanks to :doc:`Phalcon\\Db <../api/Phalcon_Db>`, the underlying component of :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`,
it's possible to profile the SQL statements generated by the ORM in order to analyze the performance of database operations. With
this you can diagnose performance problems and to discover bottlenecks.

.. code-block:: php

    <?php

    use Phalcon\Db\Profiler as ProfilerDb;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Adapter\Pdo\Mysql as MysqlPdo;

    $di->set(
        "profiler",
        function () {
            return new ProfilerDb();
        },
        true
    );

    $di->set(
        "db",
        function () use ($di) {
            $eventsManager = new EventsManager();

            // Get a shared instance of the DbProfiler
            $profiler = $di->getProfiler();

            // Listen all the database events
            $eventsManager->attach(
                "db",
                function ($event, $connection) use ($profiler) {
                    if ($event->getType() === "beforeQuery") {
                        $profiler->startProfile(
                            $connection->getSQLStatement()
                        );
                    }

                    if ($event->getType() === "afterQuery") {
                        $profiler->stopProfile();
                    }
                }
            );

            $connection = new MysqlPdo(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo",
                ]
            );

            // Assign the eventsManager to the db adapter instance
            $connection->setEventsManager($eventsManager);

            return $connection;
        }
    );

Profiling some queries:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Send some SQL statements to the database
    Robots::find();

    Robots::find(
        [
            "order" => "name",
        ]
    );

    Robots::find(
        [
            "limit" => 30,
        ]
    );

    // Get the generated profiles from the profiler
    $profiles = $di->get("profiler")->getProfiles();

    foreach ($profiles as $profile) {
       echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
       echo "Start Time: ", $profile->getInitialTime(), "\n";
       echo "Final Time: ", $profile->getFinalTime(), "\n";
       echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
    }

Each generated profile contains the duration in milliseconds that each instruction takes to complete as well as the generated SQL statement.
