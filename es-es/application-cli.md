---
layout: default
language: 'es-es'
version: '5.0'
title: 'Aplicación CLI'
keywords: 'cli, línea de comandos, aplicación, tareas'
---

# Aplicación CLI
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

# Resumen
CLI significa Interfaz de Línea de Comandos (*Command Line Interface* en inglés). Las aplicaciones CLI se ejecutan desde la línea de comandos o un indicador de *shell*. Uno de los beneficios de las aplicaciones CLI es que no tienen una capa de vista (sólo potencialmente muestran la salida por pantalla) y se pueden ejecutar más de una vez al mismo tiempo. Some common usages are cron job tasks, manipulation scripts, import data scripts, command utilities and more.

## Estructura
You can create a CLI application in Phalcon, using the [Phalcon\Cli\Console][cli-console] class. Esta clase extiende desde la clase abstracta de aplicación, y usa un directorio en el que se localizan los scripts de Tareas. Task scripts are classes that extend [Phalcon\Cli\Task][cli-task] and contain the code that we need executed.

La estructura del directorio de una aplicación CLI puede parecerse a:

```bash
src/tasks/MainTask.php
php cli.php
```

En el ejemplo anterior, `cli.php` es el punto de entrada a nuestra aplicación, mientras que el directorio `src/tasks` contiene todas las clases de tareas que manejan cada comando.

> **NOTE**: Each task file and class **must** be suffixed with `Task`. The default task (if no parameters have been passed) is `MainTask` and the default method to be executed inside a task is `main` 
> 
> {: .alert .alert-info }

## Manos a la obra
Como se ha visto anteriormente, el punto de entrada de nuestra aplicación CLI es `cli.php`. En ese script, necesitamos arrancar nuestra aplicación con servicios relevantes, directivas, etc. Esto es similar al familiar `index.php` que usamos para las aplicaciones MVC.

```php
<?php

declare(strict_types=1);

use Exception;
use Phalcon\Cli\Console;
use Phalcon\Cli\Dispatcher;
use Phalcon\Cli\Exception as PhalconException;
use Phalcon\Di\FactoryDefault\Cli as CliDI;
use Phalcon\Loader\Loader;
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

$container->setShared('config', function () {
    return include 'app/config/config.php';
});


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

Crea el autocargador de Phalcon y registra el espacio de nombres para apuntar al directorio `src/`.

> **NOTE**: If you decided to use the Composer autoloader in your `composer.json`, you do not need to register the loader in this application 
> 
> {: .alert .alert-info }

**DI**
```php
$container  = new CliDI();
```
Necesitamos un contenedor de Inyección de Dependencias. You can use the [Phalcon\Di\FactoryDefault\Cli][di-factorydefault-cli] container, which already has services registered for you. Alternatively, you can always use the [Phalcon\Di][di] and register the services you need, one after another.

**Dispatcher**
```php
$dispatcher = new Dispatcher();

$dispatcher->setDefaultNamespace('MyApp\Tasks');
$container->setShared('dispatcher', $dispatcher);
```

Las aplicaciones CLI necesitan un despachador específico. [Phalcon\Cli\Dispatcher][cli-dispatcher] offers the same functionality as the main dispatcher for MVC applications, but it is tailored to CLI applications. Como era de esperar, instanciamos el objeto despachador, establecemos nuestro espacio de nombres por defecto y luego lo registramos en el contenedor DI.

**Configuración**
```php
$container->setShared('config', function () {
    return include 'app/config/config.php';
});
```
El fragmento anterior es opcional, pero le permitirá acceder a cualquier configuración que haya configurado.

Asegúrese de actualizar la ruta de inclusión para estar relativa a donde está su archivo `cli.php`.

**Application**
```php
$console = new Console($container);
```
As mentioned above, a CLI application is handled by the [Phalcon\Cli\Console][cli-console] class. Aquí la instanciamos y pasamos al contenedor DI.

**Arguments** Our application needs arguments. Estos vienen de la siguiente forma:

```bash
php ./cli.php argument1 argument2 argument3 ...
```

El primer argumento es relativo a la tarea a ejecutar. El segundo es la acción y después le siguen los parámetros que necesitamos pasar.

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

Como se puede ver arriba, usamos `$argv` para recibir lo que nos han pasado por línea de comandos, y dividimos esos argumentos apropiadamente para entender qué tarea y acción se necesita invocar y con qué parámetros.


Así para el siguiente ejemplo:

```bash
php ./cli.php users recalculate 10
```

Nuestra aplicación invocará `UsersTask`, llamará la acción `recalculate` y pasará el parámetro `10`.

**Ejecución**

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

En el código anterior, usamos el objeto consola y llamamos `handle` con los parámetros calculados. La aplicación CLI hará el enrutado necesario y lanzará la tarea y acción solicitada. Si se lanza una excepción, será capturada por las sentencias `catch` y en consecuencia los errores se mostrarán por pantalla.

## Excepciones
Any exception thrown in the [Phalcon\Cli\Console][cli-console] component will be of type [Phalcon\Cli\Console\Exception][cli-console-exception], which allows you to trap the exception specifically.

## Tareas
Las tareas son el equivalente a los controladores en una aplicación MVC. Cualquier aplicación CLI necesita al menos una tarea llamada `MainTask` y un `mainAction`. Cualquier tarea definida necesita tener un `mainAction` que se llamará si no se define ninguna acción. No hay restricción en el número de acciones que cada tarea puede contener.

Un ejemplo de una clase de tarea (`src/Tasks/MainTask.php`) es:

```php
<?php

declare(strict_types=1);

namespace MyApp\Tasks;

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        // #01
        echo '000000' . PHP_EOL;
    }
}
```

> **Legend**
> 
> 01: This is the default task and the default action 
> 
> {: .alert .alert-info }

You can implement your own tasks by either extending the supplied [Phalcon\Cli\Task][cli-task] or writing your own class implementing the [Phalcon\Cli\TaskInterface][cli-taskinterface].

## Acciones
Como se observa arriba, especificamos el segundo parámetro para ser la acción. La tarea puede contener más de una acción.

```php
<?php

declare(strict_types=1);

namespace MyApp\Tasks;

use Phalcon\Cli\Task;

class UsersTask extends Task
{
    public function mainAction()
    {
        // #01
        echo '000000' . PHP_EOL;
    }

    public function regenerateAction(int $count = 0)
    {
        // #01
        echo '111111' . PHP_EOL;
    }
}
```

> **Legend**
> 
> 01: This is the default task and the default action
> 
> 02: This is the regenerate action 
> 
> {: .alert .alert-info }

Podemos llamar a la acción `main` (acción predeterminada):

```php
./cli.php users 
```

o la acción `regenerate`:

```php
./cli.php users regenerate
```

## Parámetros
También puede pasar parámetros a la acción. Un ejemplo de cómo procesar los parámetros se puede encontrar arriba, en el ejemplo del fichero de arranque.

```php
<?php

declare(strict_types=1);

namespace MyApp\Tasks;

use Phalcon\Cli\Task;

class UsersTask extends Task
{
    public function mainAction()
    {
        echo '000000' . PHP_EOL;
    }

    public function addAction(int $first, int $second)
    {
        echo $first + $second . PHP_EOL;
    }
}
```

> **Legend**
> 
> 01: This is the default task and the default action 
> 
> {: .alert .alert-info }


Entonces podemos ejecutar el siguiente comando:

```bash
php cli.php users add 4 5

9
```

Parameters can also be accessed through the [Phalcon\Cli\Dispatcher][cli-dispatcher] which is helpful when passing flags in, or an unknown number of parameters.

```php
<?php

declare(strict_types=1);

namespace MyApp\Tasks;

use Phalcon\Cli\Task;

class UsersTask extends Task
{
    public function mainAction()
    {
        print_r( $this->dispatcher->getParams() );
    }

}
```

Ejecutar esto entonces mostrará:

```bash
php cli.php users main additional parameters

Array
(
    [0] => additional
    [1] => parameters
)
```

## Cadena
También puede encadenar tareas. Para ejecutarlas una tras otra, necesitamos hacer un pequeño cambio en nuestro arranque: necesitamos registrar nuestra aplicación en el contenedor DI:

```php
// ...
$console = new Console($container);
$container->setShared('console', $console);

$arguments = [];
// ...
```

Ahora que la aplicación de consola está en el contenedor DI, podemos acceder a ella desde cualquier tarea.

Supongamos que queremos llamar `printAction()` desde la tarea `Users`, todo lo que tenemos que hacer es llamarla usando el contenedor.

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
        # 01
        echo '000000' . PHP_EOL;

        # 02
        $this->console->handle(
            [
                'task'   => 'main',
                'action' => 'print',
            ]
        );
    }

    public function printAction()
    {
        # 03
        echo '444444' . PHP_EOL;
    }
}
```

> **Legend**
> 
> 01: This is the default task and the default action
> 
> 02: Also handle the `print` action
> 
> 03: Print action executed also 
> 
> {: .alert .alert-info }


Esta técnica le permite ejecutar cualquier tarea y cualquier acción desde cualquier otra tarea. Sin embargo, no es recomendable porque podría provocar pesadillas de mantenimiento. It is better to extend [Phalcon\Cli\Task][cli-task] and implement your logic there.

## Módulos
Las aplicaciones CLI también puede gestionar diferentes módulos, igual que en aplicaciones MVC. Puede registrar diferentes módulos en su aplicación CLI, para manejar diferentes rutas de su aplicación CLI. Esto permite una mejor organización de su código y la agrupación de tareas.

La aplicación CLI ofrece los siguientes métodos:

- `getDefaultModule` - `string` - Devuelve el nombre del módulo predeterminado
- `getModule(string $name)` - `array`/`object` - Obtiene la definición del módulo registrado en la aplicación vía nombre de módulo
- `getModules` - `array` - Devuelve los módulos registrados en la aplicación
- `registerModules(array $modules, bool $merge = false)` - `AbstractApplication` - Registra un vector de módulos presente en la aplicación
- `setDefaultModule(string $defaultModule)` - `AbstractApplication` - Establece el nombre del módulo a ser usado si el router no devuelve un módulo valido

Puede registrar un módulo `frontend` y `backend` para su aplicación de consola como sigue:

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
use Phalcon\Loader\Loader;
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

El código anterior asume que ha estructurado sus directorios para contener los módulos en los directorios `frontend` y `backend`.

```bash
src/
src/backend/Module.php
src/frontend/Module.php
php cli.php
```
## Rutas
La aplicación CLI tiene su propio router. By default the Phalcon CLI application uses the [Phalcon\Cli\Router][cli-router] object, but you can implement your own by using the [Phalcon\Cli\RouterInterface][cli-routerinterface].

Similar to a MVC application, the [Phalcon\Cli\Router][cli-router] uses [Phalcon\Cli\Router\Route][cli-router-route] objects to store the route information. You can always implement your own objects by implementing the [Phalcon\Cli\Router\RouteInterface][cli-router-routeinterface].

Las rutas aceptan los parámetros regex esperados como `a-zA-Z0-9` etc. También hay comodines adicionales que puede aprovechar:

| Marcador     | Descripción                                         |
| ------------ | --------------------------------------------------- |
| `:module`    | El módulo (necesita configurar los módulos primero) |
| `:task`      | El nombre de la tarea                               |
| `:namespace` | El nombre del espacio de nombres                    |
| `:action`    | La acción                                           |
| `:params`    | Cualquier parámetros                                |
| `:int`       | Si es un parámetro entero de ruta                   |

The [Phalcon\Cli\Router][cli-router] comes with two predefined routes, so that it works right out of the box. Estas son:

- `/:task/:action`
- `/:task/:action/:params`

If you do not wish to use the default routes, all you have to do is pass `false` in the [Phalcon\Cli\Router][cli-router] object upon construction.

```php
<?php

declare(strict_types=1);

use Phalcon\Cli\Router;

$router = new Router(false);
```

Para más información sobre rutas y clases de rutas, puede consultar la página [Enrutamiento](routing).

## Eventos
Las aplicaciones CLI también consideran los [eventos](events). Puede usar los métodos `setEventsManager` y `getEventsManager` para acceder al gestor de eventos.

Los siguientes eventos están disponibles:

| Evento              | Detiene | Descripción                                                |
| ------------------- |:-------:| ---------------------------------------------------------- |
| `afterHandleTask`   |   Si    | Llamado después de gestionar la tarea                      |
| `afterStartModule`  |   Si    | Llamado después de procesar un módulo (si se usan módulos) |
| `beforeHandleTask`  |   No    | Llamado antes de gestionar la tarea                        |
| `beforeStartModule` |   Si    | Llamado antes de procesar un módulo (si se usan módulos)   |
| `boot`              |   Si    | Llamado cuando al aplicación arranca                       |

If you use the [Phalcon\Cli\Dispatcher][cli-dispatcher] you can also take advantage of the `beforeException` event, which can stop operations and is fired from the dispatcher object.

[cli-console]: api/phalcon_cli#cli-console
[cli-console-exception]: api/phalcon_cli#cli-console-exception
[cli-dispatcher]: api/phalcon_cli#cli-dispatcher
[cli-router]: api/phalcon_cli#cli-router
[cli-router-route]: api/phalcon_cli#cli-router-route
[cli-router-routeinterface]: api/phalcon_cli#cli-router-routeinterface
[cli-routerinterface]: api/phalcon_cli#cli-routerinterface
[cli-task]: api/phalcon_cli#cli-task
[cli-taskinterface]: api/phalcon_cli#cli-taskinterface
[di]: api/phalcon_di#di
[di-factorydefault-cli]: api/phalcon_di#di-factorydefault-cli

