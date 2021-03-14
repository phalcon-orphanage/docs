---
layout: default
language: 'es-es'
version: '4.0'
upgrade: '#cli'
title: 'Aplicación CLI'
keywords: 'cli, línea de comandos, aplicación, tareas'
---

# Aplicación CLI

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

# Resumen

CLI significa Interfaz de Línea de Comandos (*Command Line Interface* en inglés). Las aplicaciones CLI se ejecutan desde la línea de comandos o un indicador de *shell*. Uno de los beneficios de las aplicaciones CLI es que no tienen una capa de vista (sólo potencialmente muestran la salida por pantalla) y se pueden ejecutar más de una vez al mismo tiempo. Alguno de los usos comunes son tareas de cron, scripts de manipulación, scripts de importación de datos, utilidades de comandos y más.

## Estructura

Puede crear una aplicación CLI Phalcon, usando la clase [Phalcon\Cli\Console](api/phalcon_cli#cli-console). Esta clase extiende desde la clase abstracta de aplicación, y usa un directorio en el que se localizan los scripts de Tareas. Los scripts de tareas son clases que extienden [Phalcon\Cli\Task](api/phalcon_cli#cli-task) y contienen el código que necesitamos ejecutar.

La estructura del directorio de una aplicación CLI puede parecerse a:

```bash
src/tasks/MainTask.php
php cli.php
```

En el ejemplo anterior, `cli.php` es el punto de entrada a nuestra aplicación, mientras que el directorio `src/tasks` contiene todas las clases de tareas que manejan cada comando.

> **NOTA**: Cada fichero de tareas y clase **debe** tener el sufijo `Task`. La tarea por defecto (si no se pasan parámetros) es `MainTask` y el método por defecto que se ejecuta dentro de una tareas es `main` 
{: .alert .alert-info }

## Manos a la obra

Como se ha visto anteriormente, el punto de entrada de nuestra aplicación CLI es `cli.php`. En ese script, necesitamos arrancar nuestra aplicación con servicios relevantes, directivas, etc. Esto es similar al familiar `index.php` que usamos para las aplicaciones MVC.

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

Veamos el código anterior en más detalle.

Primero necesitamos crear todos los servicios necesarios para nuestra aplicación CLI. Vamos a crear un cargador para autocargar nuestras tareas, la aplicación CLI, un despachador y una aplicación de Consola CLI. Estos son la cantidad mínima de servicios que necesitamos instanciar para crear una aplicación CLI.

**Cargador**

```php
$loader = new Loader();
$loader->registerNamespaces(
    [
       'MyApp' => 'src/',
    ]
);
$loader->register();
```

Crea el autocargador de Phalcon y registra el espacio de nombres para apuntar al directorio `src/`.

> **NOTA**: Si decide usar el autocargador de Composer en su `composer.json`, no necesita registrar el cargador en esta aplicación
{: .alert .alert-info }

**DI**

```php
$container  = new CliDI();
```

Necesitamos un contenedor de Inyección de Dependencias. Puede usar el contenedor [Phalcon\Di\FactoryDefault\Cli](api/phalcon_di#di-factorydefault-cli), que ya tiene servicios registrados para usted. Alternativamente, siempre puede usar [Phalcon\Di](api/phalcon_di#di) y registrar los servicios que necesite, uno tras otro.

**Despachador**

```php
$dispatcher = new Dispatcher();

$dispatcher->setDefaultNamespace('MyApp\Tasks');
$container->setShared('dispatcher', $dispatcher);
```

Las aplicaciones CLI necesitan un despachador específico. [Phalcon\Cli\Dispatcher](api/phalcon_cli#cli-dispatcher) ofrece la misma funcionalidad que el despachador principal de las aplicaciones MVC, pero adaptado a las aplicaciones CLI. Como era de esperar, instanciamos el objeto despachador, establecemos nuestro espacio de nombres por defecto y luego lo registramos en el contenedor DI.

**Aplicación**

```php
$console = new Console($container);
```

Como se ha mencionado anteriormente, una aplicación CLI se maneja por la clase [Phalcon\Cli\Console](api/phalcon_cli#cli-console). Aquí la instanciamos y pasamos al contenedor DI.

**Argumentos** Nuestra aplicación necesita argumentos. Estos vienen de la siguiente forma:

```bash
php ./cli.php argument1 argument2 argument3 ...
```

El primer argumento es relativo a la tarea a ejecutar. The second is the action and after that follow the parameters we need to pass.

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

## Parámetros

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

You can also chain tasks. To run them one after another, we need to make a small change in our bootstrap: we need to register our application in the DI container:

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

| Marcador     | Descripción                                |
| ------------ | ------------------------------------------ |
| `:module`    | The module (need to set modules first)     |
| `:task`      | The task name                              |
| `:namespace` | The namespace name                         |
| `:action`    | The action                                 |
| `:params`    | Any parameters                             |
| `:int`       | Whether this is an integer route parameter |

The [Phalcon\Cli\Router](api/phalcon_cli#cli-router) comes with two predefined routes, so that it works right out of the box. Estas son:

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

## Eventos

CLI applications are also <events> aware. You can use the `setEventsManager` and `getEventsManager` methods to access the events manager.

Los siguientes eventos están disponibles:

| Evento              | Stop | Descripción                                             |
| ------------------- |:----:| ------------------------------------------------------- |
| `afterHandleTask`   |  Si  | Called after the task is handled                        |
| `afterStartModule`  |  Si  | Called after processing a module (if modules are used)  |
| `beforeHandleTask`  |  No  | Called before the task is handled                       |
| `beforeStartModule` |  Si  | Called before processing a module (if modules are used) |
| `boot`              |  Si  | Called when the application boots                       |

If you use the [Phalcon\Cli\Dispatcher](api/phalcon_cli#cli-dispatcher) you can also take advantage of the `beforeException` event, which can stop operations and is fired from the dispatcher object.