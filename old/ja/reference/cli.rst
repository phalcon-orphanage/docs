コマンドライン アプリケーション
===============================

CLI アプリケーションはコマンドラインから実行されます。これらは cron ジョブやスクリプト、コマンドユーティリティ等を作成するのに便利です。

構造
---------
CLI アプリケーションの最小構成はこんな感じになります:

* app/config/config.php
* app/tasks/MainTask.php
* app/cli.php <-- メインのブートストラップファイル

ブートストラップの作成
--------------------
通常の MVC アプリケーションのように、ブートストラップファイルはアプリケーションの起動に使用されます。Web アプリケーションではおなじみの index.php の代わりに、cli.php をこのアプリケーションのブートストラップファイルに使います。

下は、サンプルのこの例のために用意したブートストラップです。

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault\Cli as CliDI;
    use Phalcon\Cli\Console as ConsoleApp;
    use Phalcon\Loader;



    // CLI ファクトリのデフォルトサービスコンテナを使います
    $di = new CliDI();



    /**
     * オートローダを登録し、更にローダにタスク用ディレクトリを登録
     */
    $loader = new Loader();

    $loader->registerDirs(
        [
            __DIR__ . "/tasks",
        ]
    );

    $loader->register();



    // 設定ファイルを読み込み（もしあれば）

    $configFile = __DIR__ . "/config/config.php";

    if (is_readable($configFile)) {
        $config = include $configFile;

        $di->set("config", $config);
    }



    // コンソールアプリケーションを作成
    $console = new ConsoleApp();

    $console->setDI($di);



    /**
     * コンソールの引数を処理
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
        // 渡された引数の処理
        $console->handle($arguments);
    } catch (\Phalcon\Exception $e) {
        echo $e->getMessage();

        exit(255);
    }

この部分のコードは下記のように実行されます:

.. code-block:: bash

    $ php app/cli.php

    これはデフォルトのタスクで、かつデフォルトのアクションになります。

タスク
------
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

アクションパラメータの処理
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
