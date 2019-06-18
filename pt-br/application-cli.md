---
layout: default
language: 'pt-br'
version: '4.0'
upgrade: '#cli'
---

# CLI Application

* * *

# Creating a Command Line (CLI) Application

CLI applications are executed from the command line. They are useful to create cron jobs, scripts, command utilities and more.

## Structure

A minimal structure of a CLI application will look like this:

* `src/Tasks/MainTask.php`
* `cli.php` <-- main bootstrap file

## Creating a Bootstrap

As in regular MVC applications, a bootstrap file is used to bootstrap the application. Instead of the `index.php` bootstrapper in web applications, we use a `cli.php` file for bootstrapping the application.

Below is a sample bootstrap that is being used for this example.

```php
<?php

use Phalcon\Di\FactoryDefault\Cli as CliDI;
use Phalcon\Cli\Console;
use Phalcon\Cli\Dispatcher;
use Phalcon\Loader;



/**
 * Register the autoloader and tell it to register the tasks directory
 */
$loader = new Loader();

// Register some namespaces
$loader->registerNamespaces(
    [
       'MyApp' => 'src/',
    ]
);

// Register autoloader
$loader->register();



// Using the CLI factory default services container
$di = new CliDI();



$dispatcher = new Dispatcher();

$dispatcher->setDefaultNamespace("MyApp\\Tasks");

$di->setShared("dispatcher", $dispatcher);



// Create a console application
$console = new Console();

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

This piece of code can be run using:

```bash
php cli.php
```

## Tasks

Tasks work similar to controllers. Any CLI application needs at least a `MainTask` and a `mainAction` and every task needs to have a mainAction which will run if no action is given explicitly.

Below is an example of the `src/Tasks/MainTask.php` file:

```php
<?php

namespace MyApp\Tasks;

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;
    }
}
```

## Processing action parameters

It's possible to pass parameters to actions, the code for this is already present in the sample bootstrap. If you run the application with the following parameters and action:

```php
<?php

namespace MyApp\Tasks;

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;
    }

    public function testAction(string $yourName, string $myName)
    {
        echo sprintf(
            'Hello %s!' . PHP_EOL,
            $yourName
        );

        echo sprintf(
            'Best regards, %s' . PHP_EOL,
            $myName
        );
    }
}
```

We can then run the following command:

```bash
php cli.php main test world universe

Hello world!
Best regards, universe
```

## Running tasks in a chain

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
} catch (\Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}
```

Then you can use the console inside of any task. Below is an example of a modified `MainTask.php`:

```php
<?php

namespace MyApp\Tasks;

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