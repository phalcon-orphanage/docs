<div class='article-menu'>
  <ul>
    <li>
      <a href="#creating-cli-application">创建一个 CLI 应用程序</a> 
      <ul>
        <li>
          <a href="#structure">结构</a>
        </li>
        <li>
          <a href="#creating-bootstrap">创建一个引导</a>
        </li>
        <li>
          <a href="#tasks">任务</a>
        </li>
        <li>
          <a href="#processing-action-parameters">处理操作参数</a>
        </li>
        <li>
          <a href="#running-tasks-chain">在任务链中执行多个任务</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='creating-cli-application'></a>

# 创建命令行 (CLI) 应用程序

CLI applications are executed from the command line. They are useful to create cron jobs, scripts, command utilities and more.

<a name='structure'></a>

## 结构

最小结构的 CLI 应用程序将如下所示︰

* `app/config/config.php`
* `app/tasks/MainTask.php`
* `app/cli.php` main bootstrap file

<a name='creating-bootstrap'></a>

## 创建引导

在常规的 MVC 应用程序，引导文件用于启动应用程序。 Instead of the `index.php` bootstrapper in web applications, we use a `cli.php` file for bootstrapping the application.

下面是一个简单的引导程序，被使用于此示例。

```php
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
        __DIR__ . '/tasks',
    ]
);

$loader->register();

// Load the configuration file (if any)
$configFile = __DIR__ . '/config/config.php';

if (is_readable($configFile)) {
    $config = include $configFile;

    $di->set('config', $config);
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
        $arguments['task'] = $arg;
    } elseif ($k === 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

try {
    // Handle incoming arguments
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    // Do Phalcon related stuff here
    // ..
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
} catch (\Throwable $throwable) {
    fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
    exit(1);
}
```

可以使用运行这段代码︰

```bash
php app/cli.php
```

<a name='tasks'></a>

## 任务

Tasks work similar to controllers. Any CLI application needs at least a `MainTask` and a `mainAction` and every task needs to have a `mainAction` which will run if no action is given explicitly.

下面是 `app/tasks/MainTask.php` 文件的一个示例︰

```php
<?php

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;
    }
}
```

<a name='processing-action-parameters'></a>

## 处理操作参数

也可以将参数传递到操作，此代码已存在于样本引导。

如果您运行该应用程序附带以下参数与行动︰

```php
<?php

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;
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

然后，我们可以运行以下命令︰

```bash
php app/cli.php main test world universe

hello world
best regards, universe
```

<a name='running-tasks-chain'></a>

## 在任务链中执行多个任务

It's also possible to run tasks in a chain if it's required. To accomplish this you must add the console itself to the DI:

```php
<?php

$di->setShared("console", $console);

try {
    // Handle incoming arguments
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    // Do Phalcon related stuff here
    // ..
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
} catch (\Throwable $throwable) {
    fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
    exit(1);
}
```

Then you can use the console inside of any task. Below is an example of a modified MainTask.php:

```php
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
```

总之，扩展 `Phalcon\Cli\Task` 并实现这种逻辑，是一个更好的办法。