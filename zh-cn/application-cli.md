* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='creating-cli-application'></a>

# 创建命令行 (CLI) 应用程序

CLI 应用程序从命令行执行。它们还可用于创建 cron 作业、 脚本、 命令实用程序和更多。

<a name='structure'></a>

## 结构

最小结构的 CLI 应用程序将如下所示︰

* `app/config/config.php`
* `app/tasks/MainTask.php`
* `app/cli.php` < — — 主引导文件

<a name='creating-bootstrap'></a>

## 创建一个引导

在常规的 MVC 应用程序，引导文件用于启动应用程序。 我们使用 cli.php 文件引导应用程序，而不是 web 应用程序中的 index.php 引导程序。

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
} catch (\Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}
```

可以使用运行这段代码︰

```bash
php app/cli.php
```

<a name='tasks'></a>

## 任务

任务的工作类似于控制器。任何 CLI 应用程序至少需要一个MainTask 和一个 mainAction ，每个任务都需要有一个 mainAction将运行，如果没有明确给出一个action时。

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

在任务链中运行多个任务也是可以得，如果它是必需的。要做到这一点必须向DI，添加控制台本身︰

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
} catch (\Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}
```

然后你可以在任何任务中使用控制台。下面是修改后的 MainTask.php 示例︰

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

However, it's a better idea to extend [Phalcon\Cli\Task](api/Phalcon_Cli_Task) and implement this kind of logic there.