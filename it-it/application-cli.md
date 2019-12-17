---
layout: default
language: 'it-it'
version: '4.0'
upgrade: '#cli'
title: 'CLI Application'
keywords: 'cli, command line, application, tasks'
---

# CLI Application

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

# Overview

CLI stands for Command Line Interface. CLI applications are executed from the command line or a shell prompt. One of the benefits of CLI applications is that they do not have a view layer (only potentially echoing output on screen) and can be run more than one at a time. Some of the common usages are cron job tasks, manipulation scripts, import data scripts, command utilities and more.

## Structure

You can create a CLI application in Phalcon, using the [Phalcon\Cli\Console](api/phalcon_cli#cli-console) class. This class extends from the main abstract application class, and uses a directory in which the Task scripts are located. Task scripts are classes that extend [Phalcon\Cli\Task](api/phalcon_cli#cli-task) and contain the code that we need executed.

The directory structure of a CLI application can look like this:

```bash
src/tasks/MainTask.php
php cli.php
```

In the above example, the `cli.php` is the entry point of our application, while the `src/tasks` directory contains all the task classes that handle each command.

> **NOTE**: Each task file and class **must** be suffixed with `Task`. The default task (if no parameters have been passed) is `MainTask` and the default method to be executed inside a task is `main` 
{: .alert .alert-info }

## Bootstrap

As seen above, the entry point of our CLI application is the `cli.php`. In that script, we need to bootstrap our application with relevant services, directives etc. This is similar to the all familiar `index.php` that we use for MVC applications.

```php
<?php

declare(strict_types=1);

use Exception;
use Phalcon\Cli\Console;
use Phalcon\Cli\Dispatcher;
use Phalcon\Di\FactoryDefault\Cli as CliDI;
use Phalcon\Exception as PhalconException;
use Phalcon\Loader;
use Throwable;

$loader = new Loader();
$loader->registerNamespaces(
    [
       'MyApp' => 'src/',
    ]
);
$loader->register();

$container  = new CliDI();
$dispatcher = new Dispatcher();

$dispatcher->setDefaultNamespace('MyApp\Tasks');
$container->setShared('dispatcher', $dispatcher);

$console = new Console($container);

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
    $console->handle($arguments);
} catch (PhalconException $e) {
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
} catch (Throwable $throwable) {
    fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
    exit(1);
} catch (Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}
```

Let's look at the code above in more detail.

First we need to create all the necessary services for our CLI application. We are going to create a loader to autoload our tasks, the CLI application, a dispatcher and a CLI Console application. These are the minimum amount of services that we need to instantiate to create a CLI application.

**Loader**

```php
$loader = new Loader();
$loader->registerNamespaces(
    [
       'MyApp' => 'src/',
    ]
);
$loader->register();
```

Create the Phalcon autoloader and register the namespace to point to the `src/` directory.

> **NOTE**: If you decided to use the Composer autoloader in your `composer.json`, you do not need to register the loader in this application
{: .alert .alert-info }

**DI**

```php
$container  = new CliDI();
```

We need a Dependency Injection container. You can use the [Phalcon\Di\FactoryDefault\Cli](api/phalcon_di#di-factorydefault-cli) container, which already has services registered for you. Alternatively, you can always use the [Phalcon\Di](api/phalcon_di#di) and register the services you need, one after another.

**Dispatcher**

```php
$dispatcher = new Dispatcher();

$dispatcher->setDefaultNamespace('MyApp\Tasks');
$container->setShared('dispatcher', $dispatcher);
```

CLI applications need a specific dispatcher. [Phalcon\Cli\Dispatcher](api/phalcon_cli#cli-dispatcher) offers the same functionality as the main dispatcher for MVC applications, but it is tailored to CLI applications. As expected, we instantiate the dispatcher object, we set our default namespace and then register it in the DI container.

**Application**

```php
$console = new Console($container);
```

As mentioned above, a CLI application is handled by the [Phalcon\Cli\Console](api/phalcon_cli#cli-console) class. Here we instantiate it and pass in it the DI container.

**Arguments** Our application needs arguments. These come in the form of :

```bash
php ./cli.php argument1 argument2 argument3 ...
```

The first argument relates to the task to be executed. The second is the action and after that follow the parameters we need to pass.

```php
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
```

As you can see in the above, we use the `$argv` to receive what has been passed through the command line, and we split those arguments accordingly to understand what task and action need to be invoked and with what parameters.

So for the following example:

```bash
php ./cli.php users recalculate 10
```

Our application will invoke the `UsersTask`, call the `recalculate` action and pass the parameter `10`.

**Execution**

```php
try {
    $console->handle($arguments);
} catch (PhalconException $e) {
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
} catch (Throwable $throwable) {
    fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
    exit(1);
} catch (Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}
```

In the code above, we use our console object and call `handle` with the calculated parameters. The CLI application will do the necessary routing and dispatch the task and action requested. If an exception is thrown, it will be caught by the `catch` statements and errors will be displayed on screen accordingly.

## Exceptions

Any exception thrown in the [Phalcon\Cli\Console](api/phalcon_cli#cli-console) component will be of type [Phalcon\Cli\Console\Exception](api/phalcon_cli#cli-console-exception), which allows you to trap the exception specifically.

## Tasks

Tasks are the equivalent of controllers in a MVC application. Any CLI application needs at least one task called `MainTask` and a `mainAction`. Any task defined needs to have a `mainAction` which will be called if no action is defined. You are not restricted to the number of actions that each task can contain.

An example of a task class (`src/Tasks/MainTask.php`) is:

```php
<?php

declare(strict_types=1);

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

You can implement your own tasks by either extending the supplied [Phalcon\Cli\Task](api/phalcon_cli#cli-task) or writing your own class implementing the [Phalcon\Cli\TaskInterface](api/phalcon_cli#cli-taskinterface).

## Actions

As seen above, we have specified the second parameter to be the action. The task can contain more than one actions.

```php
<?php

declare(strict_types=1);

namespace MyApp\Tasks;

use Phalcon\Cli\Task;

class UsersTask extends Task
{
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;
    }

    public function regenerateAction(int $count = 0)
    {
        echo 'This is the retenerate action' . PHP_EOL;
    }
}
```

We can then call the `main` action (default action):

```php
./cli.php users 
```

or the `regenerate` action:

```php
./cli.php users regenerate
```

## Parameters

You can also pass parameters to action. An example of how to process the parameters can be found above, in the sample bootstrap file.

```php
<?php

declare(strict_types=1);

namespace MyApp\Tasks;

use Phalcon\Cli\Task;

class UsersTask extends Task
{
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;
    }

    public function addAction(int $first, int $second)
    {
        echo $first + $second . PHP_EOL;
    }
}
```

We can then run the following command:

```bash
php cli.php users add 4 5

9
```

## Chain

You can also chain tasks. To run them one after another, we need to make a small change in our bootstap: we need to register our application in the DI container:

```php
// ...
$console = new Console($container);
$container->setShared('console', $console);

$arguments = [];
// ...
```

Now that the console application is inside the DI container, we can access it from any task.

Assume we want to call the `printAction()` from the `Users` task, all we have to do is call it using the container.

```php
<?php

namespace MyApp\Tasks;

use Phalcon\Cli\Console;
use Phalcon\Cli\Task;

/**
 * @property Console $console
 */
class UsersTask extends Task
{
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;

        $this->console->handle(
            [
                'task'   => 'main',
                'action' => 'print',
            ]
        );
    }

    public function printAction()
    {
        echo 'I will get printed too!' . PHP_EOL;
    }
}
```

This technique allows you to run any task and any action from any other task. However, it is not recommended because it could lead to maintenance nightmares. It is better to extend [Phalcon\Cli\Task](api/phalcon_cli#cli-task) and implement your logic there.

## Modules

CLI applications can also handle different modules, the same as MVC applications. You can register different modules in your CLI application, to handle different paths of your CLI application. This allows for better organization of your code and grouping of tasks.

The CLI application offers the following methods:

- `getDefaultModule` - `string` - Returns the default module name
- `getModule(string $name)` - `array`/`object` - Gets the module definition registered in the application via module name
- `getModules` - `array` - Return the modules registered in the application
- `registerModules(array $modules, bool $merge = false)` - `AbstractApplication` - Register an array of modules present in the application
- `setDefaultModule(string $defaultModule)` - `AbstractApplication` - Sets the module name to be used if the router doesn't return a valid module

You can register a `frontend` and `backend` module for your console application as follows:

```php
<?php

declare(strict_types=1);

use Exception;
use MyApp\Modules\Backend\Module as BackendModule;
use MyApp\Modules\Frontend\Module as FrontendModule;
use Phalcon\Cli\Console;
use Phalcon\Cli\Dispatcher;
use Phalcon\Di\FactoryDefault\Cli as CliDI;
use Phalcon\Exception as PhalconException;
use Phalcon\Loader;
use Throwable;

$loader = new Loader();
$loader->registerNamespaces(
    [
       'MyApp' => 'src/',
    ]
);
$loader->register();

$container  = new CliDI();
$dispatcher = new Dispatcher();

$dispatcher->setDefaultNamespace('MyApp\Tasks');
$container->setShared('dispatcher', $dispatcher);

$console = new Console($container);

$console->registerModules(
    [
        'frontend' => [
            'className' => BackendModule::class,
            'path'      => './src/frontend/Module.php',
        ],
        'backend' => [
            'className' => FrontendModule::class,
            'path'      => './src/backend/Module.php',
        ],
    ]
);

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
    $console->handle($arguments);
} catch (PhalconException $e) {
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
} catch (Throwable $throwable) {
    fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
    exit(1);
} catch (Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}
```

The above code assumes that you have structured your directories to contain modules in the `frontend` and `backend` directories.

```bash
src/
src/backend/Module.php
src/frontend/Module.php
php cli.php
```

## Routes

The CLI application has its own router. By default the Phalcon CLI application uses the [Phalcon\Cli\Router](api/phalcon_cli#cli-router) object, but you can implement your own by using the [Phalcon\Cli\RouterInterface](api/phalcon_cli#cli-routerinterface).

Similar to a MVC application, the [Phalcon\Cli\Router](api/phalcon_cli#cli-router) uses [Phalcon\Cli\Router\Route](api/phalcon_cli#cli-router-route) objects to store the route information. You can always implement your own objects by implementing the [Phalcon\Cli\Router\RouteInterface](api/phalcon_cli#cli-router-routeinterface).

The routes accept the expected regex parameters such as `a-zA-Z0-9` etc. There are also additional placeholders that you can take advantage of:

| Placeholder  | Description                                |
| ------------ | ------------------------------------------ |
| `:module`    | The module (need to set modules first)     |
| `:task`      | The task name                              |
| `:namespace` | The namespace name                         |
| `:action`    | The action                                 |
| `:params`    | Any parameters                             |
| `:int`       | Whether this is an integer route parameter |

The [Phalcon\Cli\Router](api/phalcon_cli#cli-router) comes with two predefined routes, so that it works right out of the box. These are:

- `/:task/:action`
- `/:task/:action/:params`

If you do not wish to use the default routes, all you have to do is pass `false` in the [Phalcon\Cli\Router](api/phalcon_cli#cli-router) object upon construction.

```php
<?php

declare(strict_types=1);

use Phalcon\Cli\Router;

$router = new Router(false);
```

For more information regarding routes and the route classes, you can check the [Routing](routing) page.

## Events

CLI applications are also <events> aware. You can use the `setEventsManager` and `getEventsManager` methods to access the events manager.

The following events are available:

| Event               | Stop | Description                                             |
| ------------------- |:----:| ------------------------------------------------------- |
| `afterHandleTask`   | Yes  | Called after the task is handled                        |
| `afterStartModule`  | Yes  | Called after processing a module (if modules are used)  |
| `beforeHandleTask`  |  No  | Called before the task is handled                       |
| `beforeStartModule` | Yes  | Called before processing a module (if modules are used) |
| `boot`              | Yes  | Called when the application boots                       |

If you use the [Phalcon\Cli\Dispatcher](api/phalcon_cli#cli-dispatcher) you can also take advantage of the `beforeException` event, which can stop operations and is fired from the dispatcher object.