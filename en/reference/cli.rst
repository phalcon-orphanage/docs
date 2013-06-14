Command Line Applications
=========================
CLI applications are executed from the command line. They are useful to create cron jobs, scripts, command utilities and more.

Tasks
-----
Tasks are similar to controllers, on them can be implemented

.. code-block:: php

    <?php

    class MonitoringTask extends \Phalcon\CLI\Task
    {

        public function mainAction()
        {

        }

    }

Creating a Bootstrap
--------------------
As MVC applications, a bootstrap is available to

.. code-block:: php

    <?php

    use Phalcon\DI\FactoryDefault\CLI as CliDI,
        Phalcon\CLI\Console as ConsoleApp;

    //Using the CLI factory default services container
    $di = new CliDI();

    //Create a console application
    $console = new ConsoleApp();
    $console->setDI($di);

    //
    $console->handle(array('task' => 'shell_script_name', 'action' => 'echo'));

