Aplicações de Linha de Comando
==============================

Aplicações CLI são executadas pela linha de comando. Elas são usadas para criar tarefas agendadas (Cron Jobs), scripts, comandos úteis e muito mais.

Estrutura
---------
Uma estrutura mínima de um aplicativo CLI será semelhante a esta:

* app/config/config.php
* app/tasks/MainTask.php
* app/cli.php <-- main bootstrap file

Criando um Bootstrap
--------------------
Como nas aplicações MVC, o bootstrap também é disponível. Em vez do index.php bootstrapper em aplicações web, usamos um arquivo cli.php para inicializar o aplicativo.

Abaixo está um exemplo de bootstrap que está sendo usado para este exemplo.

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

Este pedaço de código pode ser executado usando:

.. code-block:: bash

    $ php app/cli.php

    This is the default task and the default action

Tarefas (Tasks)
---------------
Tarefas são similares aos controladores. Qualquer aplicativo CLI precisa de pelo menos um MainTask e um mainAction e cada tarefa precisa ter um mainAction que será executado se nenhuma ação é dada explicitamente.

Abaixo está um exemplo do arquivo app/tasks/MainTask.php:

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

Processando parâmetros de ação
------------------------------
É possível passar parâmetros para ações, o código para isso já está presente no bootstrap de amostra.

Se você executar o aplicativo com os seguintes parâmetros e ação:

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

Podemos então executar o seguinte comando:

.. code-block:: bash

   $ php app/cli.php main test world universe

   hello world
   best regards, universe

Executando tarefas em cadeia
----------------------------
Também é possível executar tarefas em uma cadeia, se for necessário. Para fazer isso, você deve adicionar o próprio console ao DI:

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

Então você pode usar o console dentro de qualquer tarefa. Abaixo está um exemplo de um MainTask.php modificado:

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
    
No entanto, é melhor ter uma extensão :doc:`Phalcon\\Cli\\Task <../api/Phalcon_Cli_Task>` e implementar esse tipo de lógica lá.
