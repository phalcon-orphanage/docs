命令行应用（Command Line Applications）
======================================

CLI应用即是运行在命令行窗体上的应用。 主要用来实现后台任务， 命令行工具等。

结构（Structure）
----------------
最小结构的CLI程序如下：

* app/config/config.php
* app/tasks/MainTask.php
* app/cli.php <-- 主要启动文件

创建引导（Creating a Bootstrap）
-------------------------------
普通的MVC程序中，启动文件用来启动整个应用。和web应用不同, 此处应用中我们使用cli.php来作为启动文件。

下面是一个简单的启动文件示例：

.. code-block:: php

    <?php

    use Phalcon\DI\FactoryDefault\CLI as CliDI,
        Phalcon\CLI\Console as ConsoleApp;

    define('VERSION', '1.0.0');

    // 使用CLI工厂类作为默认的服务容器
    $di = new CliDI();

    // 定义应用目录路径
    defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__)));

    /**
     * 注册类自动加载器
     */
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(
        array(
            APPLICATION_PATH . '/tasks'
        )
    );
    $loader->register();

    // 加载配置文件（如果存在）
    if (is_readable(APPLICATION_PATH . '/config/config.php')) {
        $config = include APPLICATION_PATH . '/config/config.php';
        $di->set('config', $config);
    }

    // 创建console应用
    $console = new ConsoleApp();
    $console->setDI($di);

    /**
     * 处理console应用参数
     */
    $arguments = array();
    foreach ($argv as $k => $arg) {
        if ($k == 1) {
            $arguments['task'] = $arg;
        } elseif ($k == 2) {
            $arguments['action'] = $arg;
        } elseif ($k >= 3) {
            $arguments['params'][] = $arg;
        }
    }

    // 定义全局的参数， 设定当前任务及动作
    define('CURRENT_TASK',   (isset($argv[1]) ? $argv[1] : null));
    define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));

    try {
        // 处理参数
        $console->handle($arguments);
    } catch (\Phalcon\Exception $e) {
        echo $e->getMessage();
        exit(255);
    }

上面的代码可以使用如下方式执行：

.. code-block:: bash

    $ php app/cli.php

    这样程序会直接执行默认的任务及默认动作.

任务（Tasks）
-------------------
这里的任务同于web应用中的控制器。 任一 CLI 应用程序都至少包含一个mainTask 及一个 mainAction， 每个任务至少有一个mainAction, 这样在使用者未明确的 指定action时 此mainAction就会执行。

下面即是一个mainTask的例子（ app/tasks/MainTask.php ）：

.. code-block:: php

    <?php

    class MainTask extends \Phalcon\CLI\Task
    {
        public function mainAction()
        {
            echo "\nThis is the default task and the default action \n";
        }
    }

处理动作参数（Processing action parameters）
-------------------------------------------
CLI应用中， 开发者也可以在action中处理传递过来的参数， 下面的例子中已经对传递过来的参数进行了处理。

如果你使用下面的参数和动作运行应用程序:

.. code-block:: php

    <?php

    class MainTask extends \Phalcon\CLI\Task
    {
        public function mainAction()
        {
            echo "\nThis is the default task and the default action \n";
        }

        /**
         * @param array $params
         */
        public function testAction(array $params)
        {
            echo sprintf('hello %s', $params[0]) . PHP_EOL;
            echo sprintf('best regards, %s', $params[1]) . PHP_EOL;
        }
    }

我们可以使用下面的命令行及参数执行程序：

.. code-block:: bash

   $ php app/cli.php main test world universe

   hello world
   best regards, universe

链中运行任务（Running tasks in a chain）
---------------------------------------
CLI应用中可以在一个action中执行另一action. 要实现这个需要在 DI 中设置console.

.. code-block:: php

    <?php

    $di->setShared('console', $console);

    try {
        // Handle incoming arguments
        $console->handle($arguments);
    } catch (\Phalcon\Exception $e) {
        echo $e->getMessage();
        exit(255);
    }

然后开发者即可在一个action中使用用其它的action了. 下面即是例子：

.. code-block:: php

    <?php

    class MainTask extends \Phalcon\CLI\Task
    {
        public function mainAction()
        {
            echo "\nThis is the default task and the default action \n";

            $this->console->handle(
                array(
                    'task'   => 'main',
                    'action' => 'test'
                )
            );
        }

        public function testAction()
        {
            echo "\nI will get printed too!\n";
        }
    }

当然， 通过扩展 :doc:`Phalcon\\Cli\\Task <../api/Phalcon_CLI_Task>` 来实现如上操作会是一个更好主意。
