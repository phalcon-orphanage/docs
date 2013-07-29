Command Line Applications
=========================
CLI applications are executed from the command line. They are useful to create cron jobs, scripts, command utilities and more.

Structure
---------
A minimal structure of a CLI application will look like this:

    * app/config/config.php
    * app/tasks/MainTask.php
    * app/cli.php <-- main bootstrap file


Tasks
-----
Tasks work similar to controllers. Any CLI application needs at least a mainTask and a mainAction and every task needs
to have a mainAction which will run if no action is given explicitly.

Below is an example of the app/tasks/MainTask.php file

.. code-block:: php

    <?php

    class mainTask extends \Phalcon\CLI\Task
    {

        public function mainAction()
        {
             echo "\nThis is the default task and the default action \n";
        }

    }


Creating a Bootstrap
--------------------
As in regular MVC applications, a bootstrap file is used to bootstrap the application. Instead of the index.php bootstrapper
in web applications, we use a cli.php file for bootstrapping the application.

Below is a sample boostrap that is being used for this example.

.. code-block:: php

   <?php
    
    use Phalcon\DI\FactoryDefault\CLI as CliDI,
        Phalcon\CLI\Console as ConsoleApp;
    
    define('VERSION', '1.0.0');
    
    //Using the CLI factory default services container
    $di = new CliDI();
    
    // Define path to application directory
    defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__)));
    
    /**
     * Register the autoloader and tell it to register the tasks directory
     */
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(
        array(
            APPLICATION_PATH . '/tasks'
        )
    );
    $loader->register();
    
    // Load the configuration file (if any) 
    if(is_readable(APPLICATION_PATH . '/config/config.php')) {
        $config = include APPLICATION_PATH . '/config/config.php';
        $di->set('config', $config);
    }    
    
    //Create a console application
    $console = new ConsoleApp();
    $console->setDI($di);
    
    /**
     * Get the console arguments
     */
    $arguments = array();
    
    if(isset($argv[1])) {
        $arguments['task'] = $argv[1];
    }
    if(isset($argv[2])) {
        $arguments['action'] = $argv[2];
    }
    
    // define global constants for the current task and action
    define('CURRENT_TASK', (isset($argv[1]) ? $argv[1] : null));
    define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));
    
    try {
        // handle incoming arguments
        $console->handle($arguments);
    }
    catch (\Phalcon\Exception $e) {
        echo $e->getMessage();
        exit(255);
    }

This piece of code can be run using:

.. code-block:: bash

    $ php app/cli.php
    

While will output:

.. code-block:: bash

    This is the default task and the default action
    

Running tasks in a chain
---------
It's also possible to run tasks in a chain if it's required. To accomplish this you must add the console itself
to the DI:

.. code-block:: php
    
     $di->setShared('console', $console);
     
     try {
        // handle incoming arguments
        $console->handle($arguments);
    }
    
Then you can use the console inside of any task. Below is an example of a modified MainTask.php:

.. code-block:: php

    
    class MainTask extends \Phalcon\CLI\Task{
    
        public function mainAction() {
            echo "\nThis is the default task and the default action \n";
    
            $this->console->handle(array(
               'task' => 'main',
               'action' => 'test'
            ));
        }
    
        public function testAction() {
            echo '\nI will get printed too!\n';
        }

    }
    
However, it's a better idea to extend \Phalcon\CLI\Task and implement it there.

