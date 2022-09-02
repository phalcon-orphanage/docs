---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cli'
---

* [Phalcon\Cli\Console](#cli-console)
* [Phalcon\Cli\Console\Exception](#cli-console-exception)
* [Phalcon\Cli\Dispatcher](#cli-dispatcher)
* [Phalcon\Cli\Dispatcher\Exception](#cli-dispatcher-exception)
* [Phalcon\Cli\DispatcherInterface](#cli-dispatcherinterface)
* [Phalcon\Cli\Router](#cli-router)
* [Phalcon\Cli\Router\Exception](#cli-router-exception)
* [Phalcon\Cli\Router\Route](#cli-router-route)
* [Phalcon\Cli\Router\RouteInterface](#cli-router-routeinterface)
* [Phalcon\Cli\RouterInterface](#cli-routerinterface)
* [Phalcon\Cli\Task](#cli-task)
* [Phalcon\Cli\TaskInterface](#cli-taskinterface)

<h1 id="cli-console">Class Phalcon\Cli\Console</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cli/Console.zep)

| Namespace | Phalcon\Cli | | Uses | Phalcon\Application\AbstractApplication, Phalcon\Cli\Router\Route, Phalcon\Cli\Console\Exception, Phalcon\Di\DiInterface, Phalcon\Events\ManagerInterface | | Extends | AbstractApplication |

Este componente permite crear aplicaciones CLI usando Phalcon

## Propiedades

```php
/**
 * @var array
 */
protected arguments;

/**
 * @var array
 */
protected options;

```

## Métodos

```php
public function handle( array $arguments = null );
```

Gestiona todas las tareas de línea de comandos

```php
public function setArgument( array $arguments = null, bool $str = bool, bool $shift = bool ): Console;
```

Establece un argumento específico

<h1 id="cli-console-exception">Class Phalcon\Cli\Console\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cli/Console/Exception.zep)

| Namespace | Phalcon\Cli\Console | | Extends | \Phalcon\Application\Exception |

Las excepciones lanzadas en Phalcon\Cli\Console usarán esta clase

<h1 id="cli-dispatcher">Class Phalcon\Cli\Dispatcher</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cli/Dispatcher.zep)

| Namespace | Phalcon\Cli | | Uses | Phalcon\Cli\Dispatcher\Exception, Phalcon\Dispatcher\AbstractDispatcher, Phalcon\Events\ManagerInterface, Phalcon\Filter\FilterInterface | | Extends | CliDispatcher | | Implements | DispatcherInterface |

El despachado es el proceso de tomar los argumentos de la línea de comando, extraer el nombre del módulo, nombre de la tarea, nombre de la acción, y opcionalmente los parámetros contenidos en ellos, y entonces instanciar una tarea y llamar una acción sobre ella.

```php
use Phalcon\Di;
use Phalcon\Cli\Dispatcher;

$di = new Di();

$dispatcher = new Dispatcher();

$dispatcher->setDi($di);

$dispatcher->setTaskName("posts");
$dispatcher->setActionName("index");
$dispatcher->setParams([]);

$handle = $dispatcher->dispatch();
```

## Propiedades

```php
/**
 * @var string
 */
protected defaultHandler = main;

/**
 * @var string
 */
protected defaultAction = main;

/**
 * @var string
 */
protected handlerSuffix = Task;

/**
 * @var array
 */
protected options;

```

## Métodos

```php
public function callActionMethod( mixed $handler, string $actionMethod, array $params = [] ): mixed;
```

Llama al método acción.

```php
public function getActiveTask(): TaskInterface;
```

Devuelve la tarea activa en el despachador

```php
public function getLastTask(): TaskInterface;
```

Devuelve el último controlador despachado

```php
public function getOption( mixed $option, mixed $filters = null, mixed $defaultValue = null ): mixed;
```

Obtiene una opción por su nombre o índice numérico

```php
public function getOptions(): array;
```

Obtiene las opciones despachadas

```php
public function getTaskName(): string;
```

Obtiene el nombre de la última tarea despachada

```php
public function getTaskSuffix(): string;
```

Obtiene el sufijo de la tarea predeterminada

```php
public function hasOption( mixed $option ): bool;
```

Comprueba si existe una opción

```php
public function setDefaultTask( string $taskName ): void;
```

Establece el nombre de la tarea predeterminada

```php
public function setOptions( array $options ): void;
```

Establece las opciones a despachar

```php
public function setTaskName( string $taskName ): void;
```

Establece el nombre de la tarea a despachar

```php
public function setTaskSuffix( string $taskSuffix ): void;
```

Establece el sufijo de la tarea por defecto

```php
protected function handleException( \Exception $exception );
```

Gestiona una excepción de usuario

```php
protected function throwDispatchException( string $message, int $exceptionCode = int );
```

Lanza una excepción interna

<h1 id="cli-dispatcher-exception">Class Phalcon\Cli\Dispatcher\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cli/Dispatcher/Exception.zep)

| Namespace | Phalcon\Cli\Dispatcher | | Extends | \Phalcon\Dispatcher\Exception |

Las excepciones lanzadas en Phalcon\Cli\Dispatcher usarán esta clase

<h1 id="cli-dispatcherinterface">Interface Phalcon\Cli\DispatcherInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cli/DispatcherInterface.zep)

| Namespace | Phalcon\Cli | | Uses | Phalcon\Dispatcher\DispatcherInterface | | Extends | DispatcherInterfaceBase |

Interfaz para Phalcon\Cli\Dispatcher

## Métodos

```php
public function getActiveTask(): TaskInterface;
```

Devuelve la tarea activa en el despachador

```php
public function getLastTask(): TaskInterface;
```

Devuelve el último controlador despachado

```php
public function getOptions(): array;
```

Obtiene las opciones despachadas

```php
public function getTaskName(): string;
```

Obtiene el nombre de la última tarea despachada

```php
public function getTaskSuffix(): string;
```

Obtiene el sufijo de la tarea por defecto

```php
public function setDefaultTask( string $taskName ): void;
```

Establece el nombre de la tarea predeterminada

```php
public function setOptions( array $options ): void;
```

Establece las opciones a despachar

```php
public function setTaskName( string $taskName ): void;
```

Establece el nombre de la tarea a despachar

```php
public function setTaskSuffix( string $taskSuffix ): void;
```

Establece el sufijo de la tarea por defecto

<h1 id="cli-router">Class Phalcon\Cli\Router</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cli/Router.zep)

| Namespace | Phalcon\Cli | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Cli\Router\Route, Phalcon\Cli\Router\Exception, Phalcon\Cli\Router\RouteInterface | | Extends | AbstractInjectionAware |

Phalcon\Cli\Router es el enrutador de framework estándar. Enrutamiento es el proceso de tomar los argumentos de la línea de comandos y descomponerlos en parámetros para determinar qué módulo, tarea, y acción de esa tarea debería recibir la petición.

```php
$router = new \Phalcon\Cli\Router();

$router->handle(
    [
        "module" => "main",
        "task"   => "videos",
        "action" => "process",
    ]
);

echo $router->getTaskName();
```

## Propiedades

```php
//
protected action;

//
protected defaultAction;

//
protected defaultModule;

/**
 * @var array
 */
protected defaultParams;

//
protected defaultTask;

//
protected matchedRoute;

//
protected matches;

//
protected module;

/**
 * @var array
 */
protected params;

//
protected routes;

//
protected task;

//
protected wasMatched = false;

```

## Métodos

```php
public function __construct( bool $defaultRoutes = bool );
```

Constructor Phalcon\Cli\Router

```php
public function add( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador

```php
$router->add("/about", "About::main");
```

```php
public function getActionName(): string;
```

Devuelve el nombre de la acción procesada

```php
public function getMatchedRoute(): RouteInterface;
```

Devuelve la ruta que coincide con el URI gestionado

```php
public function getMatches(): array;
```

Devuelve las sub expresiones en la expresión regular combinada

```php
public function getModuleName(): string;
```

Devuelve el nombre del módulo procesado

```php
public function getParams(): array;
```

Devuelve los parámetros extra procesados

```php
public function getRouteById( mixed $id ): RouteInterface | bool;
```

Devuelve un objeto de ruta por su identidad

```php
public function getRouteByName( string $name ): RouteInterface | bool;
```

Devuelve un objeto de ruta por su nombre

```php
public function getRoutes(): Route[];
```

Devuelve todas las rutas definidas en el enrutador

```php
public function getTaskName(): string;
```

Devuelve el nombre de la tarea procesada

```php
public function handle( mixed $arguments = null );
```

Gestiona la información de enrutamiento recibida desde los argumentos de la línea de comandos

```php
public function setDefaultAction( string $actionName );
```

Establece el nombre de acción predeterminado

```php
public function setDefaultModule( string $moduleName );
```

Establece el nombre del módulo predeterminado

```php
public function setDefaultTask( string $taskName ): void;
```

Establece el nombre predeterminado del controlador

```php
public function setDefaults( array $defaults ): Router;
```

Establece un vector de rutas por defecto. Si a una ruta le falta el camino el enrutador usará el definido aquí. No se debe usar este método para establecer una ruta 404

```php
$router->setDefaults(
    [
        "module" => "common",
        "action" => "index",
    ]
);
```

```php
public function wasMatched(): bool;
```

Comprueba si el enrutador coincide con alguna de las rutas definidas

<h1 id="cli-router-exception">Class Phalcon\Cli\Router\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cli/Router/Exception.zep)

| Namespace | Phalcon\Cli\Router | | Extends | \Phalcon\Exception |

Las excepciones lanzadas en Phalcon\Cli\Router usarán esta clase

<h1 id="cli-router-route">Class Phalcon\Cli\Router\Route</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cli/Router/Route.zep)

| Namespace | Phalcon\Cli\Router | | Implements | RouteInterface |

Esta clase representa cada ruta agregada al enrutador

## Constantes

```php
const DEFAULT_DELIMITER =  ;
```

## Propiedades

```php
//
protected beforeMatch;

//
protected compiledPattern;

//
protected converters;

//
protected delimiter;

//
protected static delimiterPath;

//
protected description;

//
protected id;

//
protected name;

//
protected paths;

//
protected pattern;

//
protected static uniqueId = 0;

```

## Métodos

```php
public function __construct( string $pattern, mixed $paths = null );
```

```php
public function beforeMatch( mixed $callback ): RouteInterface;
```

Establece una llamada de retorno que se llama si la ruta coincide. El desarrollador puede implementar cualquier condición arbitraria aquí. Si la función de retorno devuelve `false` la ruta será tratada como no coincidente

```php
public function compilePattern( string $pattern ): string;
```

Sustituye los marcadores de posición del patrón devolviendo una expresión regular PCRE válida

```php
public function convert( string $name, mixed $converter ): RouteInterface;
```

Añade un convertidor para ejecutar una transformación adicional para un parámetro determinado

```php
public static function delimiter( string $delimiter = null ): void;
```

Establece el delimitador de enrutamiento

```php
public function extractNamedParams( string $pattern ): array | bool;
```

Extrae parámetros de una cadena

```php
public function getBeforeMatch(): mixed;
```

Devuelve la función de retorno *'before match'* si la hay

```php
public function getCompiledPattern(): string;
```

Devuelve el patrón compilado de la ruta

```php
public function getConverters(): array;
```

Devuelve el convertidor del router

```php
public static function getDelimiter(): string;
```

Obtiene el delimitador de enrutamiento

```php
public function getDescription(): string;
```

Devuelve la descripción de la ruta

```php
public function getName(): string;
```

Devuelve el nombre de la ruta

```php
public function getPaths(): array;
```

Devuelve las rutas

```php
public function getPattern(): string;
```

Devuelve el patrón de la ruta

```php
public function getReversedPaths(): array;
```

Devuelve las rutas usando posiciones como claves y nombres como valores

```php
public function getRouteId(): string;
```

Devuelve la identidad de la ruta

```php
public function reConfigure( string $pattern, mixed $paths = null ): void;
```

Reconfigura la ruta agregando un nuevo patrón y un conjunto de rutas

```php
public static function reset(): void;
```

Restablece el generador de identificador de ruta interno

```php
public function setDescription( string $description ): RouteInterface;
```

Establece la descripción de la ruta

```php
public function setName( string $name ): RouteInterface;
```

Establece el nombre de la ruta

```php
$router->add(
    "/about",
    [
        "controller" => "about",
    ]
)->setName("about");
```

<h1 id="cli-router-routeinterface">Interface Phalcon\Cli\Router\RouteInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cli/Router/RouteInterface.zep)

| Namespace | Phalcon\Cli\Router |

Interfaz para Phalcon\Cli\Router\Route

## Métodos

```php
public function compilePattern( string $pattern ): string;
```

Sustituye los marcadores de posición del patrón devolviendo una expresión regular PCRE válida

```php
public static function delimiter( string $delimiter = null );
```

Establece el delimitador de enrutamiento

```php
public function getCompiledPattern(): string;
```

Devuelve el patrón de la ruta

```php
public static function getDelimiter(): string;
```

Obtiene el delimitador de enrutamiento

```php
public function getDescription(): string;
```

Devuelve la descripción de la ruta

```php
public function getName(): string;
```

Devuelve el nombre de la ruta

```php
public function getPaths(): array;
```

Devuelve las rutas

```php
public function getPattern(): string;
```

Devuelve el patrón de la ruta

```php
public function getReversedPaths(): array;
```

Devuelve las rutas usando posiciones como claves y nombres como valores

```php
public function getRouteId(): string;
```

Devuelve la identidad de la ruta

```php
public function reConfigure( string $pattern, mixed $paths = null ): void;
```

Reconfigura la ruta agregando un nuevo patrón y un conjunto de rutas

```php
public static function reset(): void;
```

Restablece el generador de identificador de ruta interno

```php
public function setDescription( string $description ): RouteInterface;
```

Establece la descripción de la ruta

```php
public function setName( string $name ): RouteInterface;
```

Establece el nombre de la ruta

<h1 id="cli-routerinterface">Interface Phalcon\Cli\RouterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cli/RouterInterface.zep)

| Namespace | Phalcon\Cli | | Uses | Phalcon\Cli\Router\RouteInterface |

Interfaz para Phalcon\Cli\Router

## Métodos

```php
public function add( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador en cualquier método HTTP

```php
public function getActionName(): string;
```

Devuelve el nombre de la acción procesada

```php
public function getMatchedRoute(): RouteInterface;
```

Devuelve la ruta que coincide con el URI gestionado

```php
public function getMatches(): array;
```

Devuelve las subexpresiones coincidentes en la expresión regular

```php
public function getModuleName(): string;
```

Devuelve el nombre del módulo procesado

```php
public function getParams(): array;
```

Devuelve los parámetros extra procesados

```php
public function getRouteById( mixed $id ): RouteInterface;
```

Devuelve un objeto de ruta por su identidad

```php
public function getRouteByName( string $name ): RouteInterface;
```

Devuelve un objeto de ruta por su nombre

```php
public function getRoutes(): RouteInterface[];
```

Devuelve todas las rutas definidas en el enrutador

```php
public function getTaskName(): string;
```

Devuelve el nombre de la tarea procesada

```php
public function handle( mixed $arguments = null );
```

Gestiona la información de enrutamiento recibida del motor de reescritura

```php
public function setDefaultAction( string $actionName ): void;
```

Establece el nombre de acción predeterminado

```php
public function setDefaultModule( string $moduleName ): void;
```

Establece el nombre del módulo predeterminado

```php
public function setDefaultTask( string $taskName ): void;
```

Establece el nombre de la tarea predeterminada

```php
public function setDefaults( array $defaults ): void;
```

Establece un vector de rutas por defecto

```php
public function wasMatched(): bool;
```

Comprueba si el enrutador coincide con alguna de las rutas definidas

<h1 id="cli-task">Class Phalcon\Cli\Task</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cli/Task.zep)

| Namespace | Phalcon\Cli | | Uses | Phalcon\Di\Injectable, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface | | Extends | Injectable | | Implements | TaskInterface, EventsAwareInterface |

Cada tarea de la línea de comandos debería extender esta clase que encapsula toda la funcionalidad de la tarea

Una tarea se puede usar para ejecutar "tareas" como migraciones, tareas programadas, tests unitarios, o cualquier otra cosa que se quiera. La clase Tarea debería tener al menos un método "mainAction".

```php
class HelloTask extends \Phalcon\Cli\Task
{
    // This action will be executed by default
    public function mainAction()
    {

    }

    public function findAction()
    {

    }
}
```

## Propiedades

```php
//
protected eventsManager;

```

## Métodos

```php
final public function __construct();
```

Constructor Phalcon\Cli\Task

```php
public function getEventsManager(): ManagerInterface | null;
```

Devuelve el gestor de eventos interno

```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

Establece el administrador de eventos

<h1 id="cli-taskinterface">Interface Phalcon\Cli\TaskInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cli/TaskInterface.zep)

| Namespace | Phalcon\Cli |

Interfaz para los manejadores de tareas
