Консольные приложения
=====================

CLI приложения выполняются в командной строке. Они часто используются для работы cron, скриптов с долгим временем выполнения, командных утилит и т.п.

Структура
---------
Минимальная структура приложений CLI будет выглядеть следующим образом:

* app/config/config.php
* app/tasks/MainTask.php
* app/cli.php <-- основной загрузочный файл

Создание загрузочного файла
---------------------------
Как и в обычных приложениях MVC, загрузочный файл используется для загрузки приложения. Вместо загрузочного файла
index.php, как в веб-приложениях, мы используем cli.php.

Ниже приведен образец загрузочного файлов, который используется для этого примера.

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault\Cli as CliDI,
        Phalcon\Cli\Console as ConsoleApp;

    define('VERSION', '1.0.0');

    // Используем стандартный для CLI контейнер зависимостей
    $di = new CliDI();

    // Определяем путь к каталогу приложений
    defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__)));

    /**
     * Регистрируем автозагрузчик, и скажем ему, чтобы зарегистрировал каталог задач
     */
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(
        [
            APPLICATION_PATH . '/tasks'
        ]
    );
    $loader->register();

    // Загружаем файл конфигурации, если он есть
    if (is_readable(APPLICATION_PATH . '/config/config.php')) {
        $config = include APPLICATION_PATH . '/config/config.php';
        $di->set('config', $config);
    }

    // Создаем консольное приложение
    $console = new ConsoleApp();
    $console->setDI($di);

    /**
     * Определяем консольные аргументы
     */
    $arguments = [];
    foreach ($argv as $k => $arg) {
        if ($k == 1) {
            $arguments['task'] = $arg;
        } elseif ($k == 2) {
            $arguments['action'] = $arg;
        } elseif ($k >= 3) {
            $arguments['params'][] = $arg;
        }
    }

    // определяем глобальные константы для текущей задачи и действия
    define('CURRENT_TASK',   (isset($argv[1]) ? $argv[1] : null));
    define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));

    try {
        // обрабатываем входящие аргументы
        $console->handle($arguments);
    } catch (\Phalcon\Exception $e) {
        echo $e->getMessage();
        exit(255);
    }

Эта часть кода может быть запущена с помощью команды:

.. code-block:: bash

    $ php app/cli.php

    This is the default task and the default action


Задачи
------
Принцип работы задач похож на работу контролеров. Любое приложение CLI нуждается, по крайней
мере, в MainTask и mainAction, и каждая задача должна иметь mainAction, который будет выполняться,
если действие не задано явно.

Ниже приведен пример задачи из файла 'app/tasks/MainTask.php':

.. code-block:: php

    <?php

    class MainTask extends \Phalcon\Cli\Task
    {
        public function mainAction()
        {
            echo "\nThis is the default task and the default action \n";
        }
    }


Обработка параметров в Action
-----------------------------
Имеется возможность передавать параметры в Action, код для этого уже присутствует в образце загрузочного файла.

Если вы запустите приложение со следующими параметрами и Action:

.. code-block:: php

    <?php

    class MainTask extends \Phalcon\Cli\Task
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

We can then run the following command:

.. code-block:: bash

   $ php app/cli.php main test world universe

   hello world
   best regards, universe

Запуск цепочки команд
---------------------
Вы также можете запустить цепочку задач, для этого вы должны добавить саму консоль в контейнер зависимостей:

.. code-block:: php

    <?php

    $di->setShared('console', $console);

    try {
        // обрабатываем входящие аргументы
        $console->handle($arguments);
    } catch (\Phalcon\Exception $e) {
        echo $e->getMessage();
        exit(255);
    }

Затем, вы сможете использовать консоль внутри любой задачи. Ниже приведен пример модифицированного MainTask.php:

.. code-block:: php

    <?php

    class MainTask extends \Phalcon\Cli\Task
    {
        public function mainAction()
        {
            echo "\nThis is the default task and the default action \n";

            $this->console->handle(
                [
                    'task'   => 'main',
                    'action' => 'test'
                ]
            );
        }

        public function testAction()
        {
            echo "\nI will get printed too!\n";
        }
    }

Тем не менее, лучшей идеей будет реализовать свой класс, расширяющий :doc:`Phalcon\\Cli\\Task <../api/Phalcon_Cli_Task>`, и реализовать такую логику там.
