%{cli_d8b0d1e34b25db1d7588c63c80ca46ed}%
=========================
%{cli_b06b86bae30c7e9318c2270148e441ab}%

%{cli_f6f429eb9ad945f547f04b04f67ce57a}%
---------
%{cli_cff96e41ec35e70efbec5ec74e343a3e}%

* {%cli_ea24575eefced9021991b9113cfea18e%}
* {%cli_1cc086c35bb6c6f40033dbb65d72921d%}
* {%cli_b5994b8f6b492194af4f240cc424033f%}

%{cli_448cbc477e8c68335b2a22300c49db96}%
--------------------
%{cli_7d3f73a4b4b6ef3b708cf4ba28258d4e}%

%{cli_04117c61cf865aa866cad78bace24460}%

.. code-block:: php

   <?php
    
    use Phalcon\DI\FactoryDefault\CLI as CliDI,
        Phalcon\CLI\Console as ConsoleApp;
    
    define('VERSION', '1.0.0');
    
    //{%cli_7de6afb1f05b7a8897d6bdd9e27b7afb%}
    $di = new CliDI();
    
    // {%cli_d414a65783adf1be083dfbc25efed474%}
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
    
    // {%cli_c7a24ef50d08a17121ecfb7a9e58ddc8%}
    if(is_readable(APPLICATION_PATH . '/config/config.php')) {
        $config = include APPLICATION_PATH . '/config/config.php';
        $di->set('config', $config);
    }    
    
    //{%cli_6535177d94825112c9adb341afe1fc02%}
    $console = new ConsoleApp();
    $console->setDI($di);
    
    /**
    * Process the console arguments
    */
    $arguments = array();
    $params = array();
    
    foreach($argv as $k => $arg) {
        if($k == 1) {
            $arguments['task'] = $arg;
        } elseif($k == 2) {
            $arguments['action'] = $arg;
        } elseif($k >= 3) {
           $params[] = $arg;
        }
    }
    if(count($params) > 0) {
        $arguments['params'] = $params;
    }

    // {%cli_1fedf20a4623e73400b7e36b68feee2a%}
    define('CURRENT_TASK', (isset($argv[1]) ? $argv[1] : null));
    define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));
    
    try {
        // {%cli_5062480511df35df4d7a5bb393556e91%}
        $console->handle($arguments);
    }
    catch (\Phalcon\Exception $e) {
        echo $e->getMessage();
        exit(255);
    }


%{cli_6e7a3acc1a481f8f72d8b5fb22365b29}%

.. code-block:: bash

    $ php app/cli.php
   
    This is the default task and the default action
    
    

%{cli_16a463e446a3db7d6923abf39284e5c8}%
-----
%{cli_90ff34bad02c33f4416b8f401b6bfef9}%

%{cli_1b1c48668af4d19257308cead1a6890a}%

.. code-block:: php

    <?php

    class mainTask extends \Phalcon\CLI\Task
    {

        public function mainAction() {
             echo "\nThis is the default task and the default action \n";
        }

    }



%{cli_6c285ece3eff07b4c3388d86af2d194d}%
----------------------------
%{cli_e5688d2f9aabfa125fa7835d55882cdc}%

%{cli_0995ae67b473a890eb4fbc76b8fae9b9}%

.. code-block:: php

    <?php

    class mainTask extends \Phalcon\CLI\Task
    {

        public function mainAction() {
             echo "\nThis is the default task and the default action \n";
        }
        
        /**
        * @param array $params
        */
       public function testAction(array $params) {
           echo sprintf('hello %s', $params[0]) . PHP_EOL;
           echo sprintf('best regards, %s', $params[1]) . PHP_EOL;
       }
    }

.. code-block:: bash

   $ php app/cli.php main test world universe
   
   hello world
   best regards, universe
    


%{cli_cc62382fa7cca3d492d10ea7f5f7c481}%
------------------------
%{cli_85c7d2c33e9788c7a249e8ff99d33ada}%

.. code-block:: php
    
     $di->setShared('console', $console);
     
     try {
        // {%cli_5062480511df35df4d7a5bb393556e91%}
        $console->handle($arguments);
    }
    

%{cli_55ab633837e29b2cfc056603ac6dc5be}%

.. code-block:: php

    
    class MainTask extends \Phalcon\CLI\Task {
    
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
    

%{cli_862081cd7f0eb6b6d8b2f674e128770a}%

