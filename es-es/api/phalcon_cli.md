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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Cli/Console.zep)

| Namespace | Phalcon\Cli | | Uses | Phalcon\Application\AbstractApplication, Phalcon\Cli\Router\Route, Phalcon\Cli\Console\Exception, Phalcon\Di\DiInterface, Phalcon\Events\ManagerInterface | | Extends | AbstractApplication |

This component allows to create CLI applications using Phalcon

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

Handle the whole command-line tasks

```php
public function handle( array $arguments = null );
```

Set an specific argument

```php
public function setArgument( array $arguments = null, bool $str = bool, bool $shift = bool ): Console;
```

<h1 id="cli-console-exception">Class Phalcon\Cli\Console\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Cli/Console/Exception.zep)

| Namespace | Phalcon\Cli\Console | | Extends | \Phalcon\Application\Exception |

Exceptions thrown in Phalcon\Cli\Console will use this class

<h1 id="cli-dispatcher">Class Phalcon\Cli\Dispatcher</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Cli/Dispatcher.zep)

| Namespace | Phalcon\Cli | | Uses | Phalcon\Cli\Dispatcher\Exception, Phalcon\Dispatcher\AbstractDispatcher, Phalcon\Events\ManagerInterface, Phalcon\Filter\FilterInterface | | Extends | CliDispatcher | | Implements | DispatcherInterface |

Dispatching is the process of taking the command-line arguments, extracting the module name, task name, action name, and optional parameters contained in it, and then instantiating a task and calling an action on it.

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

Calls the action method.

```php
public function callActionMethod( mixed $handler, string $actionMethod, array $params = [] ): mixed;
```

Returns the active task in the dispatcher

```php
public function getActiveTask(): TaskInterface;
```

Returns the latest dispatched controller

```php
public function getLastTask(): TaskInterface;
```

Gets an option by its name or numeric index

```php
public function getOption( mixed $option, mixed $filters = null, mixed $defaultValue = null ): mixed;
```

Get dispatched options

```php
public function getOptions(): array;
```

Gets last dispatched task name

```php
public function getTaskName(): string;
```

Gets the default task suffix

```php
public function getTaskSuffix(): string;
```

Check if an option exists

```php
public function hasOption( mixed $option ): bool;
```

Sets the default task name

```php
public function setDefaultTask( string $taskName ): void;
```

Set the options to be dispatched

```php
public function setOptions( array $options ): void;
```

Sets the task name to be dispatched

```php
public function setTaskName( string $taskName ): void;
```

Sets the default task suffix

```php
public function setTaskSuffix( string $taskSuffix ): void;
```

Handles a user exception

```php
protected function handleException( \Exception $exception );
```

Throws an internal exception

```php
protected function throwDispatchException( string $message, int $exceptionCode = int );
```

<h1 id="cli-dispatcher-exception">Class Phalcon\Cli\Dispatcher\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Cli/Dispatcher/Exception.zep)

| Namespace | Phalcon\Cli\Dispatcher | | Extends | \Phalcon\Dispatcher\Exception |

Exceptions thrown in Phalcon\Cli\Dispatcher will use this class

<h1 id="cli-dispatcherinterface">Interface Phalcon\Cli\DispatcherInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Cli/DispatcherInterface.zep)

| Namespace | Phalcon\Cli | | Uses | Phalcon\Dispatcher\DispatcherInterface | | Extends | DispatcherInterfaceBase |

Interface for Phalcon\Cli\Dispatcher

## Métodos

Returns the active task in the dispatcher

```php
public function getActiveTask(): TaskInterface;
```

Returns the latest dispatched controller

```php
public function getLastTask(): TaskInterface;
```

Get dispatched options

```php
public function getOptions(): array;
```

Gets last dispatched task name

```php
public function getTaskName(): string;
```

Gets default task suffix

```php
public function getTaskSuffix(): string;
```

Sets the default task name

```php
public function setDefaultTask( string $taskName ): void;
```

Set the options to be dispatched

```php
public function setOptions( array $options ): void;
```

Sets the task name to be dispatched

```php
public function setTaskName( string $taskName ): void;
```

Sets the default task suffix

```php
public function setTaskSuffix( string $taskSuffix ): void;
```

<h1 id="cli-router">Class Phalcon\Cli\Router</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Cli/Router.zep)

| Namespace | Phalcon\Cli | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Cli\Router\Route, Phalcon\Cli\Router\Exception, Phalcon\Cli\Router\RouteInterface | | Extends | AbstractInjectionAware |

Phalcon\Cli\Router is the standard framework router. Routing is the process of taking a command-line arguments and decomposing it into parameters to determine which module, task, and action of that task should receive the request.

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

Phalcon\Cli\Router constructor

```php
public function __construct( bool $defaultRoutes = bool );
```

Adds a route to the router

```php
$router->add("/about", "About::main");
```

```php
public function add( string $pattern, mixed $paths = null ): RouteInterface;
```

Returns processed action name

```php
public function getActionName(): string;
```

Returns the route that matches the handled URI

```php
public function getMatchedRoute(): RouteInterface;
```

Returns the sub expressions in the regular expression matched

```php
public function getMatches(): array;
```

Returns processed module name

```php
public function getModuleName(): string;
```

Returns processed extra params

```php
public function getParams(): array;
```

Returns a route object by its id

```php
public function getRouteById( mixed $id ): RouteInterface | bool;
```

Returns a route object by its name

```php
public function getRouteByName( string $name ): RouteInterface | bool;
```

Returns all the routes defined in the router

```php
public function getRoutes(): Route[];
```

Returns processed task name

```php
public function getTaskName(): string;
```

Handles routing information received from command-line arguments

```php
public function handle( mixed $arguments = null );
```

Sets the default action name

```php
public function setDefaultAction( string $actionName );
```

Sets the name of the default module

```php
public function setDefaultModule( string $moduleName );
```

Sets the default controller name

```php
public function setDefaultTask( string $taskName ): void;
```

Sets an array of default paths. If a route is missing a path the router will use the defined here. This method must not be used to set a 404 route

```php
$router->setDefaults(
    [
        "module" => "common",
        "action" => "index",
    ]
);
```

```php
public function setDefaults( array $defaults ): Router;
```

Checks if the router matches any of the defined routes

```php
public function wasMatched(): bool;
```

<h1 id="cli-router-exception">Class Phalcon\Cli\Router\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Cli/Router/Exception.zep)

| Namespace | Phalcon\Cli\Router | | Extends | \Phalcon\Exception |

Exceptions thrown in Phalcon\Cli\Router will use this class

<h1 id="cli-router-route">Class Phalcon\Cli\Router\Route</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Cli/Router/Route.zep)

| Namespace | Phalcon\Cli\Router | | Implements | RouteInterface |

This class represents every route added to the router

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

Sets a callback that is called if the route is matched. The developer can implement any arbitrary conditions here If the callback returns false the route is treated as not matched

```php
public function beforeMatch( mixed $callback ): RouteInterface;
```

Replaces placeholders from pattern returning a valid PCRE regular expression

```php
public function compilePattern( string $pattern ): string;
```

Adds a converter to perform an additional transformation for certain parameter

```php
public function convert( string $name, mixed $converter ): RouteInterface;
```

Set the routing delimiter

```php
public static function delimiter( string $delimiter = null ): void;
```

Extracts parameters from a string

```php
public function extractNamedParams( string $pattern ): array | bool;
```

Returns the 'before match' callback if any

```php
public function getBeforeMatch(): mixed;
```

Returns the route's compiled pattern

```php
public function getCompiledPattern(): string;
```

Returns the router converter

```php
public function getConverters(): array;
```

Get routing delimiter

```php
public static function getDelimiter(): string;
```

Returns the route's description

```php
public function getDescription(): string;
```

Returns the route's name

```php
public function getName(): string;
```

Returns the paths

```php
public function getPaths(): array;
```

Returns the route's pattern

```php
public function getPattern(): string;
```

Returns the paths using positions as keys and names as values

```php
public function getReversedPaths(): array;
```

Returns the route's id

```php
public function getRouteId(): string;
```

Reconfigure the route adding a new pattern and a set of paths

```php
public function reConfigure( string $pattern, mixed $paths = null ): void;
```

Resets the internal route id generator

```php
public static function reset(): void;
```

Sets the route's description

```php
public function setDescription( string $description ): RouteInterface;
```

Sets the route's name

```php
$router->add(
    "/about",
    [
        "controller" => "about",
    ]
)->setName("about");
```

```php
public function setName( string $name ): RouteInterface;
```

<h1 id="cli-router-routeinterface">Interface Phalcon\Cli\Router\RouteInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Cli/Router/RouteInterface.zep)

| Namespace | Phalcon\Cli\Router |

Interface for Phalcon\Cli\Router\Route

## Métodos

Replaces placeholders from pattern returning a valid PCRE regular expression

```php
public function compilePattern( string $pattern ): string;
```

Set the routing delimiter

```php
public static function delimiter( string $delimiter = null );
```

Returns the route's pattern

```php
public function getCompiledPattern(): string;
```

Get routing delimiter

```php
public static function getDelimiter(): string;
```

Returns the route's description

```php
public function getDescription(): string;
```

Returns the route's name

```php
public function getName(): string;
```

Returns the paths

```php
public function getPaths(): array;
```

Returns the route's pattern

```php
public function getPattern(): string;
```

Returns the paths using positions as keys and names as values

```php
public function getReversedPaths(): array;
```

Returns the route's id

```php
public function getRouteId(): string;
```

Reconfigure the route adding a new pattern and a set of paths

```php
public function reConfigure( string $pattern, mixed $paths = null ): void;
```

Resets the internal route id generator

```php
public static function reset(): void;
```

Sets the route's description

```php
public function setDescription( string $description ): RouteInterface;
```

Sets the route's name

```php
public function setName( string $name ): RouteInterface;
```

<h1 id="cli-routerinterface">Interface Phalcon\Cli\RouterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Cli/RouterInterface.zep)

| Namespace | Phalcon\Cli | | Uses | Phalcon\Cli\Router\RouteInterface |

Interface for Phalcon\Cli\Router

## Métodos

Adds a route to the router on any HTTP method

```php
public function add( string $pattern, mixed $paths = null ): RouteInterface;
```

Returns processed action name

```php
public function getActionName(): string;
```

Returns the route that matches the handled URI

```php
public function getMatchedRoute(): RouteInterface;
```

Return the sub expressions in the regular expression matched

```php
public function getMatches(): array;
```

Returns processed module name

```php
public function getModuleName(): string;
```

Returns processed extra params

```php
public function getParams(): array;
```

Returns a route object by its id

```php
public function getRouteById( mixed $id ): RouteInterface;
```

Returns a route object by its name

```php
public function getRouteByName( string $name ): RouteInterface;
```

Return all the routes defined in the router

```php
public function getRoutes(): RouteInterface[];
```

Returns processed task name

```php
public function getTaskName(): string;
```

Handles routing information received from the rewrite engine

```php
public function handle( mixed $arguments = null );
```

Sets the default action name

```php
public function setDefaultAction( string $actionName ): void;
```

Sets the name of the default module

```php
public function setDefaultModule( string $moduleName ): void;
```

Sets the default task name

```php
public function setDefaultTask( string $taskName ): void;
```

Sets an array of default paths

```php
public function setDefaults( array $defaults ): void;
```

Check if the router matches any of the defined routes

```php
public function wasMatched(): bool;
```

<h1 id="cli-task">Class Phalcon\Cli\Task</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Cli/Task.zep)

| Namespace | Phalcon\Cli | | Uses | Phalcon\Di\Injectable, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface | | Extends | Injectable | | Implements | TaskInterface, EventsAwareInterface |

Every command-line task should extend this class that encapsulates all the task functionality

A task can be used to run "tasks" such as migrations, cronjobs, unit-tests, or anything that you want. The Task class should at least have a "mainAction" method.

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

Phalcon\Cli\Task constructor

```php
final public function __construct();
```

Devuelve el administrador de eventos interno

```php
public function getEventsManager(): ManagerInterface | null;
```

Establece el administrador de eventos

```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

<h1 id="cli-taskinterface">Interface Phalcon\Cli\TaskInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Cli/TaskInterface.zep)

| Namespace | Phalcon\Cli |

Interface for task handlers