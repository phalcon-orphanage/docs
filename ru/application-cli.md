<div class='article-menu'>
  <ul>
    <li>
      <a href="#creating-cli-application">Создание консольного приложения</a> <ul>
        <li>
          <a href="#structure">Структура</a>
        </li>
        <li>
          <a href="#creating-bootstrap">Создание загрузочного файла</a>
        </li>
        <li>
          <a href="#tasks">Задачи</a>
        </li>
        <li>
          <a href="#processing-action-parameters">Обработка параметров</a>
        </li>
        <li>
          <a href="#running-tasks-chain">Запуск цепочки команд</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='creating-cli-application'></a>

# Создание консольного приложения

Консольные приложения выполняются из командной строки.Они часто используются для работы cron, скриптов с долгим временем выполнения, командных утилит и т.п.

<a name='structure'></a>

## Структура

Минимальная структура консольного приложения будет выглядеть следующим образом:

* `app/config/config.php`
* `app/tasks/MainTask.php`
* `app/cli.php` <-- main bootstrap file

<a name='creating-bootstrap'></a>

## Создание загрузочного файла

Как и в обычных MVC приложениях, для начальной загрузки приложения используется загрузочный файл. Однако для начальной загрузки приложения мы будем использовать файл cli.php, вместо загрузочного файла index.php, который используется в классических веб-приложениях.

Ниже приведен образец загрузочного файла, который используется для этого примера.

```php
<?php

use Phalcon\Di\FactoryDefault\Cli as CliDI;
use Phalcon\Cli\Console as ConsoleApp;
use Phalcon\Loader;

// Использование стандартного CLI контейнера для сервисов
$di = new CliDI();

/**
 * Регистрируем автозагрузчик и сообщаем ему директорию
 * для регистрации каталога задач
 */
$loader = new Loader();

$loader->registerDirs(
    [
        __DIR__ . '/tasks',
    ]
);

$loader->register();

// Загрузка файла конфигурации (если есть)
$configFile = __DIR__ . '/config/config.php';

if (is_readable($configFile)) {
    $config = include $configFile;

    $di->set('config', $config);
}

// Создание консольного приложения
$console = new ConsoleApp();

$console->setDI($di);

/**
 * Обработка аргументов консоли
 */
$arguments = [];

foreach ($argv as $k => $arg) {
    if ($k === 1) {
        $arguments['task'] = $arg;
    } elseif ($k === 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

try {
    // Обработка входящих аргументов
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    // Связанные с Phalcon вещи указываем здесь
    // ..
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
} catch (\Throwable $throwable) {
    fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
    exit(1);
} catch (\Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}
```

Эта часть кода может быть запущена с помощью команды:

```bash
php app/cli.php
```

<a name='tasks'></a>

## Задачи

Принцип работы задач похож на работу контролеров. Любое консольное приложение нуждается по крайней мере в одной задаче, именуемой MainTask. Каждая задача должна иметь по крайней мере одной действие, именуемое mainAction, которое будет запущено, если не указано другое, явно. Эти соглашения являются умолчанием.

Ниже приведен пример файла `app/tasks/MainTask.php`:

```php
<?php

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo 'Это задача по умолчанию и действие по умолчанию' . PHP_EOL;
    }
}
```

<a name='processing-action-parameters'></a>

## Обработка параметров действия

Вы можете передавать параметры в действие, код для этого уже присутствует в примере загрузочного файла.

Если вы запустите приложение, с задачей, составленной следующим образом:

```php
<?php

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo 'Это задача по умолчанию и действие по умолчанию' . PHP_EOL;
    }

    /**
     * @param array $params
     */
    public function testAction(array $params)
    {
        echo sprintf('hello %s', $params[0]);

        echo PHP_EOL;

        echo sprintf('best regards, %s', $params[1]);

        echo PHP_EOL;
    }
}
```

Вы сможете запустить её используя следующую команду:

```bash
php app/cli.php main test world universe

hello world
best regards, universe
```

<a name='running-tasks-chain'></a>

## Запуск цепочки команд

Также, возможно запускать задачи "цепочкой", если это необходимо. Для этого необходимо добавить само консольное приложение в DI:

```php
<?php

$di->setShared("console", $console);

try {
    // Handle incoming arguments
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    // Связанные с Phalcon вещи указываем здесь
    // ..
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
} catch (\Throwable $throwable) {
    fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
    exit(1);
} catch (\Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}
```

После этого, вы сможете использовать консольное приложение внутри любой задачи. Ниже приведен пример измененной задачи MainTask.php:

```php
<?php

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo "Это задача по умолчанию с действием по умолчанию" . PHP_EOL;

        $this->console->handle(
            [
                "task"   => "main",
                "action" => "test",
            ]
        );
    }

    public function testAction()
    {
        echo "Я буду напечатано тоже!" . PHP_EOL;
    }
}
```

Тем не менее, лучшей идеей будет реализовать свой класс, расширяющий `Phalcon\Cli\Task` и реализовать такую логику там.