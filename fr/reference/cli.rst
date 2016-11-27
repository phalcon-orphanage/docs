Applications en Ligne de Commande
=================================

Les applications CLI sont exécutées depuis la ligne de commande. Elles sont utiles pour créer de jobs planifiés, des scripts, des utilitaires et bien plus encore.

Structure
---------
La structure minimale d'une application CLI doit ressembler à ceci:

* app/config/config.php
* app/tasks/MainTask.php
* app/cli.php <-- fichier d'amorce principal

Création de l'Amorce
--------------------
Comme dans les applications MVC classiques, le fichier d'amorce est utilisé pour amorcer l'application. Au lieu du traditionnel index.php des application web, nous utilisons un fichier cli.php comme point d'entrée de l'application.

Ci-dessous un exemple qui sera utilisé pour notre exemple.

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault\Cli as CliDI;
    use Phalcon\Cli\Console as ConsoleApp;
    use Phalcon\Loader;



    // Utilise le conteneur de services CLI par défaut
    $di = new CliDI();



    /**
     * Inscription d'un chargeur automatique et lui indique le chemin des tâches
     */
    $loader = new Loader();

    $loader->registerDirs(
        [
            __DIR__ . "/tasks",
        ]
    );

    $loader->register();



    // Chargement de la configuration (si elle existe)

    $configFile = __DIR__ . "/config/config.php";

    if (is_readable($configFile)) {
        $config = include $configFile;

        $di->set("config", $config);
    }



    // Création de l'application console
    $console = new ConsoleApp();

    $console->setDI($di);



    /**
     * Traitement des arguments
     */
    $arguments = [];

    foreach ($argv as $k => $arg) {
        if ($k === 1) {
            $arguments["task"] = $arg;
        } elseif ($k === 2) {
            $arguments["action"] = $arg;
        } elseif ($k >= 3) {
            $arguments["params"][] = $arg;
        }
    }



    try {
        // Gestion des arguments transmis
        $console->handle($arguments);
    } catch (\Phalcon\Exception $e) {
        echo $e->getMessage();

        exit(255);
    }

Cet extrait de code peut être exécuté ainsi:

.. code-block:: bash

    $ php app/cli.php

    Ceci est la tache 'default' et l'action 'default'

Tâches
------
Le fonctionnement des tâches est similaire à celui des contrôleurs. Chaque application nécessite au moins "MainTask" et "mainAction" et chaque tâche une "mainAction" qui sera exécutée si aucune action n'est indiquée explicitement.

Ci-dessous se trouve un exemple du fichier app/tasks/MainTask.php:

.. code-block:: php

    <?php

    use Phalcon\Cli\Task;

    class MainTask extends Task
    {
        public function mainAction()
        {
            echo "Ceci est la tache 'default' et l'action 'default'" . PHP_EOL;
        }
    }

Traitement des paramètre de l'action
------------------------------------
Il est possible de transmettre des paramètres aux actions. Le code pour réaliser ceci existe déjà dans l'exemple d'amorce.

Si vous lancer l'application avec l'action et les paramètres suivants:

.. code-block:: php

    <?php

    use Phalcon\Cli\Task;

    class MainTask extends Task
    {
        public function mainAction()
        {
            echo "Ceci est la tache 'default' et l'action 'default'" . PHP_EOL;
        }

        /**
         * @param array $params
         */
        public function testAction(array $params)
        {
            echo sprintf(
                "bonjour %s",
                $params[0]
            );

            echo PHP_EOL;

            echo sprintf(
                "cordialement, %s",
                $params[1]
            );

            echo PHP_EOL;
        }
    }

On peut désormais lancer la commande suivante:

.. code-block:: bash

   $ php app/cli.php main test monde univers

   salut monde
   cordialement, univers

Enchaînement de tâches
----------------------
Il est également possible d'enchaîner les tâches si nécessaire. Pour réaliser ceci, vous devez ajouter la console elle-même au DI:

.. code-block:: php

    <?php

    $di->setShared("console", $console);

    try {
        // Gestion des arguments fournis
        $console->handle($arguments);
    } catch (\Phalcon\Exception $e) {
        echo $e->getMessage();

        exit(255);
    }

Ainsi vous pouvez utiliser la console à l'intérieur de n'importe quelle tâche. L'exemple ci-dessous est une version modifiée de MainTask.php:

.. code-block:: php

    <?php

    use Phalcon\Cli\Task;

    class MainTask extends Task
    {
        public function mainAction()
        {
            echo "Ceci est la tache 'default' et l'action 'default'" . PHP_EOL;

            $this->console->handle(
                [
                    "task"   => "main",
                    "action" => "test",
                ]
            );
        }

        public function testAction()
        {
            echo "Je serais imprime aussi !" . PHP_EOL;
        }
    }

Cependant, ce serait une meilleure idée que d'étendre :doc:`Phalcon\\Cli\\Task <../api/Phalcon_Cli_Task>` et développer ce type de logique ici.
