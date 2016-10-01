Command Line Applications
=========================

CLI applications are executed from the command line. They are useful to create cron jobs, scripts, command utilities and more.

Structure
---------
A minimal structure of a CLI application will look like this:

* app/config/config.php
* app/tasks/MainTask.php
* app/cli.php <-- main bootstrap file

Creating a Bootstrap
--------------------
As in regular MVC applications, a bootstrap file is used to bootstrap the application. Instead of the index.php bootstrapper in web applications, we use a cli.php file for bootstrapping the application.

Below is a sample bootstrap that is being used for this example.

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault\Cli as CliDI;
    use Phalcon\Cli\Console as ConsoleApp;
    use Phalcon\Loader;



    // Using the CLI factory default services container
    $di = new CliDI();



    /**
     * Register the autoloader and tell it to register the tasks directory
     */
    $loader = new Loader();

    $loader->registerDirs(
        [
            __DIR__ . "/tasks",
        ]
    );

    $loader->register();



    // Load the configuration file (if any)

    $configFile = __DIR__ . "/config/config.php";

    if (is_readable($configFile)) {
        $config = include $configFile;

        $di->set("config", $config);
    }



    // Create a console application
    $console = new ConsoleApp();

    $console->setDI($di);



    /**
     * Process the console arguments
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
        // Handle incoming arguments
        $console->handle($arguments);
    } catch (\Phalcon\Exception $e) {
        echo $e->getMessage();

        exit(255);
    }

This piece of code can be run using:

.. code-block:: bash

    $ php app/cli.php

    This is the default task and the default action

Tasks
-----
Tasks work similar to controllers. Any CLI application needs at least a MainTask and a mainAction and every task needs to have a mainAction which will run if no action is given explicitly.

Below is an example of the app/tasks/MainTask.php file:

.. code-block:: php

    <?php

    use Phalcon\Cli\Task;

    class MainTask extends Task
    {
        public function mainAction()
        {
            echo "This is the default task and the default action" . PHP_EOL;
        }
    }

Processing action parameters
----------------------------
It's possible to pass parameters to actions, the code for this is already present in the sample bootstrap.

If you run the application with the following parameters and action:

.. code-block:: php

    <?php

    use Phalcon\Cli\Task;

    class MainTask extends Task
    {
        public function mainAction()
        {
            echo "This is the default task and the default action" . PHP_EOL;
        }

        /**
         * @param array $params
         */
        public function testAction(array $params)
        {
            echo sprintf(
                "hello %s",
                $params[0]
            );

            echo PHP_EOL;

            echo sprintf(
                "best regards, %s",
                $params[1]
            );

            echo PHP_EOL;
        }
    }

We can then run the following command:

.. code-block:: bash

   $ php app/cli.php main test world universe

   hello world
   best regards, universe

Running tasks in a chain
------------------------
It's also possible to run tasks in a chain if it's required. To accomplish this you must add the console itself to the DI:

.. code-block:: php

    <?php

    $di->setShared("console", $console);

    try {
        // Handle incoming arguments
        $console->handle($arguments);
    } catch (\Phalcon\Exception $e) {
        echo $e->getMessage();

        exit(255);
    }

Then you can use the console inside of any task. Below is an example of a modified MainTask.php:

.. code-block:: php

    <?php

    use Phalcon\Cli\Task;

    class MainTask extends Task
    {
        public function mainAction()
        {
            echo "This is the default task and the default action" . PHP_EOL;

            $this->console->handle(
                [
                    "task"   => "main",
                    "action" => "test",
                ]
            );
        }

        public function testAction()
        {
            echo "I will get printed too!" . PHP_EOL;
        }
    }

However, it's a better idea to extend :doc:`Phalcon\\Cli\\Task <../api/Phalcon_Cli_Task>` and implement this kind of logic there.
