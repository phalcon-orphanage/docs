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

.. code-block:: php

    <?php

    //Using the CLI factory default services container
    $di = new Phalcon\DI\FactoryDefault\CLI();

    //Create a console application
    $console = new \Phalcon\CLI\Console();
    $console->setDI($di);

    //
    $console->handle(array('shell_script_name', 'echo'));

