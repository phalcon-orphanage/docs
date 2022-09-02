---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Mvc'
---

- [Phalcon\Mvc\Application](#mvc-application)
- [Phalcon\Mvc\Application\Exception](#mvc-application-exception)
- [Phalcon\Mvc\Controller](#mvc-controller)
- [Phalcon\Mvc\Controller\BindModelInterface](#mvc-controller-bindmodelinterface)
- [Phalcon\Mvc\ControllerInterface](#mvc-controllerinterface)
- [Phalcon\Mvc\Dispatcher](#mvc-dispatcher)
- [Phalcon\Mvc\Dispatcher\Exception](#mvc-dispatcher-exception)
- [Phalcon\Mvc\DispatcherInterface](#mvc-dispatcherinterface)
- [Phalcon\Mvc\EntityInterface](#mvc-entityinterface)
- [Phalcon\Mvc\Micro](#mvc-micro)
- [Phalcon\Mvc\Micro\Collection](#mvc-micro-collection)
- [Phalcon\Mvc\Micro\CollectionInterface](#mvc-micro-collectioninterface)
- [Phalcon\Mvc\Micro\Exception](#mvc-micro-exception)
- [Phalcon\Mvc\Micro\LazyLoader](#mvc-micro-lazyloader)
- [Phalcon\Mvc\Micro\MiddlewareInterface](#mvc-micro-middlewareinterface)
- [Phalcon\Mvc\Model](#mvc-model)
- [Phalcon\Mvc\Model\Behavior](#mvc-model-behavior)
- [Phalcon\Mvc\Model\Behavior\SoftDelete](#mvc-model-behavior-softdelete)
- [Phalcon\Mvc\Model\Behavior\Timestampable](#mvc-model-behavior-timestampable)
- [Phalcon\Mvc\Model\BehaviorInterface](#mvc-model-behaviorinterface)
- [Phalcon\Mvc\Model\Binder](#mvc-model-binder)
- [Phalcon\Mvc\Model\Binder\BindableInterface](#mvc-model-binder-bindableinterface)
- [Phalcon\Mvc\Model\BinderInterface](#mvc-model-binderinterface)
- [Phalcon\Mvc\Model\Criteria](#mvc-model-criteria)
- [Phalcon\Mvc\Model\CriteriaInterface](#mvc-model-criteriainterface)
- [Phalcon\Mvc\Model\Exception](#mvc-model-exception)
- [Phalcon\Mvc\Model\Manager](#mvc-model-manager)
- [Phalcon\Mvc\Model\ManagerInterface](#mvc-model-managerinterface)
- [Phalcon\Mvc\Model\MetaData](#mvc-model-metadata)
- [Phalcon\Mvc\Model\MetaData\Apcu](#mvc-model-metadata-apcu)
- [Phalcon\Mvc\Model\MetaData\Libmemcached](#mvc-model-metadata-libmemcached)
- [Phalcon\Mvc\Model\MetaData\Memory](#mvc-model-metadata-memory)
- [Phalcon\Mvc\Model\MetaData\Redis](#mvc-model-metadata-redis)
- [Phalcon\Mvc\Model\MetaData\Strategy\Annotations](#mvc-model-metadata-strategy-annotations)
- [Phalcon\Mvc\Model\MetaData\Strategy\Introspection](#mvc-model-metadata-strategy-introspection)
- [Phalcon\Mvc\Model\MetaData\Strategy\StrategyInterface](#mvc-model-metadata-strategy-strategyinterface)
- [Phalcon\Mvc\Model\MetaData\Stream](#mvc-model-metadata-stream)
- [Phalcon\Mvc\Model\MetaDataInterface](#mvc-model-metadatainterface)
- [Phalcon\Mvc\Model\Query](#mvc-model-query)
- [Phalcon\Mvc\Model\Query\Builder](#mvc-model-query-builder)
- [Phalcon\Mvc\Model\Query\BuilderInterface](#mvc-model-query-builderinterface)
- [Phalcon\Mvc\Model\Query\Lang](#mvc-model-query-lang)
- [Phalcon\Mvc\Model\Query\Status](#mvc-model-query-status)
- [Phalcon\Mvc\Model\Query\StatusInterface](#mvc-model-query-statusinterface)
- [Phalcon\Mvc\Model\QueryInterface](#mvc-model-queryinterface)
- [Phalcon\Mvc\Model\Relation](#mvc-model-relation)
- [Phalcon\Mvc\Model\RelationInterface](#mvc-model-relationinterface)
- [Phalcon\Mvc\Model\ResultInterface](#mvc-model-resultinterface)
- [Phalcon\Mvc\Model\Resultset](#mvc-model-resultset)
- [Phalcon\Mvc\Model\Resultset\Complex](#mvc-model-resultset-complex)
- [Phalcon\Mvc\Model\Resultset\Simple](#mvc-model-resultset-simple)
- [Phalcon\Mvc\Model\ResultsetInterface](#mvc-model-resultsetinterface)
- [Phalcon\Mvc\Model\Row](#mvc-model-row)
- [Phalcon\Mvc\Model\Transaction](#mvc-model-transaction)
- [Phalcon\Mvc\Model\Transaction\Exception](#mvc-model-transaction-exception)
- [Phalcon\Mvc\Model\Transaction\Failed](#mvc-model-transaction-failed)
- [Phalcon\Mvc\Model\Transaction\Manager](#mvc-model-transaction-manager)
- [Phalcon\Mvc\Model\Transaction\ManagerInterface](#mvc-model-transaction-managerinterface)
- [Phalcon\Mvc\Model\TransactionInterface](#mvc-model-transactioninterface)
- [Phalcon\Mvc\Model\ValidationFailed](#mvc-model-validationfailed)
- [Phalcon\Mvc\ModelInterface](#mvc-modelinterface)
- [Phalcon\Mvc\ModuleDefinitionInterface](#mvc-moduledefinitioninterface)
- [Phalcon\Mvc\Router](#mvc-router)
- [Phalcon\Mvc\Router\Annotations](#mvc-router-annotations)
- [Phalcon\Mvc\Router\Exception](#mvc-router-exception)
- [Phalcon\Mvc\Router\Group](#mvc-router-group)
- [Phalcon\Mvc\Router\GroupInterface](#mvc-router-groupinterface)
- [Phalcon\Mvc\Router\Route](#mvc-router-route)
- [Phalcon\Mvc\Router\RouteInterface](#mvc-router-routeinterface)
- [Phalcon\Mvc\RouterInterface](#mvc-routerinterface)
- [Phalcon\Mvc\View](#mvc-view)
- [Phalcon\Mvc\View\Engine\AbstractEngine](#mvc-view-engine-abstractengine)
- [Phalcon\Mvc\View\Engine\EngineInterface](#mvc-view-engine-engineinterface)
- [Phalcon\Mvc\View\Engine\Php](#mvc-view-engine-php)
- [Phalcon\Mvc\View\Engine\Volt](#mvc-view-engine-volt)
- [Phalcon\Mvc\View\Engine\Volt\Compiler](#mvc-view-engine-volt-compiler)
- [Phalcon\Mvc\View\Engine\Volt\Exception](#mvc-view-engine-volt-exception)
- [Phalcon\Mvc\View\Exception](#mvc-view-exception)
- [Phalcon\Mvc\View\Simple](#mvc-view-simple)
- [Phalcon\Mvc\ViewBaseInterface](#mvc-viewbaseinterface)
- [Phalcon\Mvc\ViewInterface](#mvc-viewinterface)

<h1 id="mvc-application">Class Phalcon\Mvc\Application</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Application.zep)

| Namespace | Phalcon\Mvc | | Uses | Closure, Phalcon\Application\AbstractApplication, Phalcon\Di\DiInterface, Phalcon\Http\ResponseInterface, Phalcon\Events\ManagerInterface, Phalcon\Mvc\Application\Exception, Phalcon\Mvc\Router\RouteInterface, Phalcon\Mvc\ModuleDefinitionInterface | | Extends | AbstractApplication |

Phalcon\Mvc\Application

Este componente encapsula todas las operaciones complejas tras instanciar cada componente necesario e integrarlo con el resto para permitir al patrón MVC operar de la manera deseada.

```php
use Phalcon\Mvc\Application;

class MyApp extends Application
{
Register the services here to make them general or register
in the ModuleDefinition to make them module-specific
\/
    protected function registerServices()
    {

    }

This method registers all the modules in the application
\/
    public function main()
    {
        $this->registerModules(
            [
                "frontend" => [
                    "className" => "Multiple\\Frontend\\Module",
                    "path"      => "../apps/frontend/Module.php",
                ],
                "backend" => [
                    "className" => "Multiple\\Backend\\Module",
                    "path"      => "../apps/backend/Module.php",
                ],
            ]
        );
    }
}

$application = new MyApp();

$application->main();
```

## Propiedades

```php
//
protected implicitView = true;

//
protected sendCookies = true;

//
protected sendHeaders = true;

```

## Métodos

```php
public function handle( string $uri ): ResponseInterface | bool;
```

Maneja una petición MVC

```php
public function sendCookiesOnHandleRequest( bool $sendCookies ): Application;
```

Habilita o deshabilita el envío de cookies para cada gestión de petición

```php
public function sendHeadersOnHandleRequest( bool $sendHeaders ): Application;
```

Habilita o deshabilita el envío de cabeceras para cada gestión de petición

```php
public function useImplicitView( bool $implicitView ): Application;
```

Por defecto. La vista almacena implícitamente todas las salidas. Puede deshabilitar por completo el componente de vista utilizando este método

<h1 id="mvc-application-exception">Class Phalcon\Mvc\Application\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Application/Exception.zep)

| Namespace | Phalcon\Mvc\Application | | Extends | \Phalcon\Application\Exception |

Phalcon\Mvc\Application\Exception

Las excepciones lanzadas en la clase Phalcon\Mvc\Application usarán esta clase

<h1 id="mvc-controller">Abstract Class Phalcon\Mvc\Controller</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Controller.zep)

| Namespace | Phalcon\Mvc | | Uses | Phalcon\Di\Injectable | | Extends | Injectable | | Implements | ControllerInterface |

Phalcon\Mvc\Controller

Cada controlador de aplicación debería extender esta clase que encapsula toda la funcionalidad del controlador

El controlador proporciona el "flujo" entre modelos y vistas. Los controladores son responsables de procesar las peticiones entrantes desde el navegador web, solicitando los datos a los modelos, y pasando esos datos a las vistas para su presentación.

```php
<?php

class PeopleController extends \Phalcon\Mvc\Controller
{
    // This action will be executed by default
    public function indexAction()
    {

    }

    public function findAction()
    {

    }

    public function saveAction()
    {
        // Forwards flow to the index action
        return $this->dispatcher->forward(
            [
                "controller" => "people",
                "action"     => "index",
            ]
        );
    }
}
```

## Métodos

```php
final public function __construct();
```

Constructor Phalcon\Mvc\Controller

<h1 id="mvc-controller-bindmodelinterface">Interface Phalcon\Mvc\Controller\BindModelInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Controller/BindModelInterface.zep)

| Namespace | Phalcon\Mvc\Controller |

Phalcon\Mvc\Controller\BindModelInterface

Interfaz para Phalcon\Mvc\Controller

## Métodos

```php
public static function getModelName(): string;
```

Devuelve el nombre del modelo asociado con este controlador

<h1 id="mvc-controllerinterface">Interface Phalcon\Mvc\ControllerInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/ControllerInterface.zep)

| Namespace | Phalcon\Mvc |

Phalcon\Mvc\ControllerInterface

Interfaz para manejadores de controlador

<h1 id="mvc-dispatcher">Class Phalcon\Mvc\Dispatcher</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Dispatcher.zep)

| Namespace | Phalcon\Mvc | | Uses | Phalcon\Mvc\Dispatcher\Exception, Phalcon\Events\ManagerInterface, Phalcon\Http\ResponseInterface, Phalcon\Dispatcher\AbstractDispatcher | | Extends | BaseDispatcher | | Implements | DispatcherInterface |

Despachar es el proceso de tomar el objeto de solicitud, extraer el nombre del módulo, el nombre de controlador, el nombre de la acción, y los parámetros opcionales que contenga, y luego instanciar un controlador y llamar una acción de ese controlador.

```php
$di = new \Phalcon\Di();

$dispatcher = new \Phalcon\Mvc\Dispatcher();

$dispatcher->setDI($di);

$dispatcher->setControllerName("posts");
$dispatcher->setActionName("index");
$dispatcher->setParams([]);

$controller = $dispatcher->dispatch();
```

## Propiedades

```php
//
protected defaultAction = index;

//
protected defaultHandler = index;

//
protected handlerSuffix = Controller;

```

## Métodos

```php
public function forward( array $forward ): void;
```

Reenvía el flujo de ejecución a otro controlador/acción.

```php
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use App\Backend\Bootstrap as Backend;
use App\Frontend\Bootstrap as Frontend;

// Registering modules
$modules = [
    "frontend" => [
        "className" => Frontend::class,
        "path"      => __DIR__ . "/app/Modules/Frontend/Bootstrap.php",
        "metadata"  => [
            "controllersNamespace" => "App\Frontend\Controllers",
        ],
    ],
    "backend" => [
        "className" => Backend::class,
        "path"      => __DIR__ . "/app/Modules/Backend/Bootstrap.php",
        "metadata"  => [
            "controllersNamespace" => "App\Backend\Controllers",
        ],
    ],
];

$application->registerModules($modules);

// Setting beforeForward listener
$eventsManager  = $di->getShared("eventsManager");

$eventsManager->attach(
    "dispatch:beforeForward",
    function(Event $event, Dispatcher $dispatcher, array $forward) use ($modules) {
        $metadata = $modules[$forward["module"]]["metadata"];

        $dispatcher->setModuleName(
            $forward["module"]
        );

        $dispatcher->setNamespaceName(
            $metadata["controllersNamespace"]
        );
    }
);

// Forward
$this->dispatcher->forward(
    [
        "module"     => "backend",
        "controller" => "posts",
        "action"     => "index",
    ]
);
```

```php
public function getActiveController(): ControllerInterface;
```

Devuelve el controlador activo en el despachador

```php
public function getControllerClass(): string;
```

Posible nombre de la clase del controlador que será localizada para despachar la petición

```php
public function getControllerName(): string;
```

Obtiene el nombre del último controlador despachado

```php
public function getLastController(): ControllerInterface;
```

Devuelve el último controlador despachado

```php
public function getPreviousActionName(): string;
```

Obtiene el nombre de la acción despachada anterior

```php
public function getPreviousControllerName(): string;
```

Obtiene el nombre del controlador despachado anterior

```php
public function getPreviousNamespaceName(): string;
```

Obtiene el espacio de nombres despachado anterior

```php
public function setControllerName( string $controllerName );
```

Establece el nombre del controlador a despachar

```php
public function setControllerSuffix( string $controllerSuffix );
```

Establece el sufijo de controlador por defecto

```php
public function setDefaultController( string $controllerName );
```

Establece el nombre predeterminado del controlador

```php
protected function handleException( \Exception $exception );
```

Gestiona una excepción de usuario

```php
protected function throwDispatchException( string $message, int $exceptionCode = int );
```

Lanza una excepción interna

<h1 id="mvc-dispatcher-exception">Class Phalcon\Mvc\Dispatcher\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Dispatcher/Exception.zep)

| Namespace | Phalcon\Mvc\Dispatcher | | Extends | \Phalcon\Dispatcher\Exception |

Phalcon\Mvc\Dispatcher\Exception

Las excepciones lanzadas en Phalcon\Mvc\Dispatcher usarán esta clase

<h1 id="mvc-dispatcherinterface">Interface Phalcon\Mvc\DispatcherInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/DispatcherInterface.zep)

| Namespace | Phalcon\Mvc | | Uses | Phalcon\Dispatcher\DispatcherInterface | | Extends | DispatcherInterfaceBase |

Phalcon\Mvc\DispatcherInterface

Interfaz para Phalcon\Mvc\Dispatcher

## Métodos

```php
public function getActiveController(): ControllerInterface;
```

Devuelve el controlador activo en el despachador

```php
public function getControllerName(): string;
```

Obtiene el nombre del último controlador despachado

```php
public function getLastController(): ControllerInterface;
```

Devuelve el último controlador despachado

```php
public function setControllerName( string $controllerName );
```

Establece el nombre del controlador a despachar

```php
public function setControllerSuffix( string $controllerSuffix );
```

Establece el sufijo de controlador por defecto

```php
public function setDefaultController( string $controllerName );
```

Establece el nombre predeterminado del controlador

<h1 id="mvc-entityinterface">Interface Phalcon\Mvc\EntityInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/EntityInterface.zep)

| Namespace | Phalcon\Mvc |

Phalcon\Mvc\EntityInterface

Interfaz para Phalcon\Mvc\Collection y Phalcon\Mvc\Model

## Métodos

```php
public function readAttribute( string $attribute ): mixed | null;
```

Lee un valor de atributo por su nombre

```php
public function writeAttribute( string $attribute, mixed $value );
```

Escribe un valor de atributo por su nombre

<h1 id="mvc-micro">Class Phalcon\Mvc\Micro</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Micro.zep)

| Namespace | Phalcon\Mvc | | Uses | ArrayAccess, Closure, Phalcon\Di\DiInterface, Phalcon\Di\Injectable, Phalcon\Di\FactoryDefault, Phalcon\Mvc\Micro\Exception, Phalcon\Di\ServiceInterface, Phalcon\Mvc\Micro\Collection, Phalcon\Mvc\Micro\LazyLoader, Phalcon\Http\ResponseInterface, Phalcon\Mvc\Model\BinderInterface, Phalcon\Mvc\Router\RouteInterface, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface, Phalcon\Mvc\Micro\MiddlewareInterface, Phalcon\Mvc\Micro\CollectionInterface, Throwable | | Extends | Injectable | | Implements | ArrayAccess, EventsAwareInterface |

Phalcon\Mvc\Micro

Con Phalcon se pueden crear aplicaciones "Micro-Framework like". Al hacer esto, solo se necesita escribir una cantidad mínima de código para crear una aplicación PHP. Las aplicaciones Micro son adecuadas de una manera práctica para aplicaciones pequeñas, APIs y prototipos.

```php
$app = new \Phalcon\Mvc\Micro();

$app->get(
    "/say/welcome/{name}",
    function ($name) {
        echo "<h1>Welcome $name!</h1>";
    }
);

$app->handle("/say/welcome/Phalcon");
```

## Propiedades

```php
//
protected activeHandler;

//
protected afterBindingHandlers;

//
protected afterHandlers;

//
protected beforeHandlers;

//
protected container;

//
protected errorHandler;

//
protected eventsManager;

//
protected finishHandlers;

//
protected handlers;

//
protected modelBinder;

//
protected notFoundHandler;

//
protected responseHandler;

//
protected returnedValue;

//
protected router;

//
protected stopped;

```

## Métodos

```php
public function __construct( DiInterface $container = null );
```

Constructor Phalcon\Mvc\Micro

```php
public function after( mixed $handler ): Micro;
```

Añade un software intermedio "after" para ser llamado después de ejecutar la ruta

```php
public function afterBinding( mixed $handler ): Micro;
```

Añade un software intermedio afterBinding para ser llamado después del enlace del modelo

```php
public function before( mixed $handler ): Micro;
```

Anexa un software intermedio before para ser llamado antes de ejecutar la ruta

```php
public function delete( string $routePattern, mixed $handler ): RouteInterface;
```

Asigna una ruta a un manejador que sólo coincide si el método HTTP es DELETE

```php
public function error( mixed $handler ): Micro;
```

Configura un controlador que será llamado cuando se lance una excepción al gestionar la ruta

```php
public function finish( mixed $handler ): Micro;
```

Añade un software intermedio "finish" para ser llamado cuando finalice la solicitud

```php
public function get( string $routePattern, mixed $handler ): RouteInterface;
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es GET

```php
public function getActiveHandler();
```

Devuelve el controlador que será llamado para la ruta coincidente

```php
public function getBoundModels(): array;
```

Devuelve los modelos enlazados de la instancia del enlazador

```php
public function getEventsManager(): ManagerInterface | null;
```

Devuelve el administrador de eventos interno

```php
public function getHandlers(): array;
```

Devuelve los gestores internos adjuntos a la aplicación

```php
public function getModelBinder(): BinderInterface | null;
```

Obtiene el enlazador del modelo

```php
public function getReturnedValue();
```

Devuelve el valor devuelto por el gestor ejecutado

```php
public function getRouter(): RouterInterface;
```

Devuelve el enrutador interno utilizado por la aplicación

```php
public function getService( string $serviceName );
```

Obtiene un servicio del DI

```php
public function getSharedService( string $serviceName );
```

Obtiene un servicio compartido del DI

```php
public function handle( string $uri );
```

Maneja toda la solicitud

```php
public function hasService( string $serviceName ): bool;
```

Comprueba si un servicio está registrado en el DI

```php
public function head( string $routePattern, mixed $handler ): RouteInterface;
```

Asigna una ruta a un controlador que solo coincide si el método HTTP es HEAD

```php
public function map( string $routePattern, mixed $handler ): RouteInterface;
```

Asigna una ruta a un controlador sin ninguna restricción de método HTTP

```php
public function mount( CollectionInterface $collection ): Micro;
```

Monta una colección de gestores

```php
public function notFound( mixed $handler ): Micro;
```

Configura un controlador que será llamado cuando la ruta no coincida con ninguna de las rutas definidas

```php
public function offsetExists( mixed $alias ): bool;
```

Comprueba si un servicio está registrado en el contenedor de servicios interno utilizando la sintaxis de vector

```php
public function offsetGet( mixed $alias ): mixed;
```

Permite obtener un servicio compartido en el contenedor de servicios interno utilizando la sintaxis de vector

```php
var_dump(
    $app["request"]
);
```

```php
public function offsetSet( mixed $alias, mixed $definition ): void;
```

Permite registrar un servicio compartido en el contenedor de servicios interno utilizando la sintaxis de vector

```php
   $app["request"] = new \Phalcon\Http\Request();
```

```php
public function offsetUnset( mixed $alias ): void;
```

Elimina un servicio del contenedor de servicios interno utilizando la sintaxis de vector

```php
public function options( string $routePattern, mixed $handler ): RouteInterface;
```

Asigna una ruta a un controlador que solo coincide si el método HTTP es OPTIONS

```php
public function patch( string $routePattern, mixed $handler ): RouteInterface;
```

Asigna una ruta a un controlador que solo coincide si el método HTTP es PATCH

```php
public function post( string $routePattern, mixed $handler ): RouteInterface;
```

Asigna una ruta a un controlador que solo coincide si el método HTTP es POST

```php
public function put( string $routePattern, mixed $handler ): RouteInterface;
```

Asigna una ruta a un controlador que solo coincide si el método HTTP es PUT

```php
public function setActiveHandler( mixed $activeHandler );
```

Configura externamente el gestor que debe ser llamado por la ruta coincidente

```php
public function setDI( DiInterface $container ): void;
```

Configura el contenedor DependencyInjector

```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

Establece el administrador de eventos

```php
public function setModelBinder( BinderInterface $modelBinder, mixed $cache = null ): Micro;
```

Configura el enlazador de modelo

```php
$micro = new Micro($di);

$micro->setModelBinder(
    new Binder(),
    'cache'
);
```

```php
public function setResponseHandler( mixed $handler ): Micro;
```

Añade un gestor 'response' personalizado a ser llamado en lugar del predeterminado

```php
public function setService( string $serviceName, mixed $definition, bool $shared = bool ): ServiceInterface;
```

Configura un servicio desde el DI

```php
public function stop();
```

Detiene la ejecución del software intermedio evitando que se ejecuten otros softwares intermedios

<h1 id="mvc-micro-collection">Class Phalcon\Mvc\Micro\Collection</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Micro/Collection.zep)

| Namespace | Phalcon\Mvc\Micro | | Implements | CollectionInterface |

Phalcon\Mvc\Micro\Collection

Agrupa controladores Micro-Mvc como controladores

```php
$app = new \Phalcon\Mvc\Micro();

$collection = new Collection();

$collection->setHandler(
    new PostsController()
);

$collection->get("/posts/edit/{id}", "edit");

$app->mount($collection);
```

## Propiedades

```php
//
protected handler;

//
protected handlers;

//
protected lazy;

//
protected prefix;

```

## Métodos

```php
public function delete( string $routePattern, mixed $handler, string $name = null ): CollectionInterface;
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es DELETE.

```php
public function get( string $routePattern, mixed $handler, string $name = null ): CollectionInterface;
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es GET.

```php
public function getHandler(): mixed;
```

Devuelve el gestor principal

```php
public function getHandlers(): array;
```

Devuelve los gestores registrados

```php
public function getPrefix(): string;
```

Devuelve el prefijo de la colección (si hay alguno)

```php
public function head( string $routePattern, mixed $handler, string $name = null ): CollectionInterface;
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es HEAD.

```php
public function isLazy(): bool;
```

Devuelve si el gestor principal debe ser cargado de forma diferida

```php
public function map( string $routePattern, mixed $handler, string $name = null ): CollectionInterface;
```

Asigna una ruta a un gestor.

```php
public function mapVia( string $routePattern, mixed $handler, mixed $method, string $name = null ): CollectionInterface;
```

Asigna una ruta a un gestor a través de métodos.

```php
$collection->mapVia(
    "/test",
    "indexAction",
    ["POST", "GET"],
    "test"
);
```

```php
public function options( string $routePattern, mixed $handler, string $name = null ): CollectionInterface;
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es OPTIONS.

```php
public function patch( string $routePattern, mixed $handler, string $name = null ): CollectionInterface;
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es PATCH.

```php
public function post( string $routePattern, mixed $handler, string $name = null ): CollectionInterface;
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es POST.

```php
public function put( string $routePattern, mixed $handler, string $name = null ): CollectionInterface;
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es PUT.

```php
public function setHandler( mixed $handler, bool $lazy = bool ): CollectionInterface;
```

Configura el gestor principal.

```php
public function setLazy( bool $lazy ): CollectionInterface;
```

Establece si el gestor principal debe ser cargado de forma diferida

```php
public function setPrefix( string $prefix ): CollectionInterface;
```

Configura un prefijo para todas las rutas agregadas a la colección

```php
protected function addMap( mixed $method, string $routePattern, mixed $handler, string $name );
```

Una función interna para añadir un controlador al grupo.

<h1 id="mvc-micro-collectioninterface">Interface Phalcon\Mvc\Micro\CollectionInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Micro/CollectionInterface.zep)

| Namespace | Phalcon\Mvc\Micro |

Phalcon\Mvc\Micro\CollectionInterface

Interfaz para Phalcon\Mvc\Micro\Collection

## Métodos

```php
public function delete( string $routePattern, callable $handler, string $name = null ): CollectionInterface;
```

Asigna una ruta a un manejador que sólo coincide si el método HTTP es DELETE

```php
public function get( string $routePattern, callable $handler, string $name = null ): CollectionInterface;
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es GET

```php
public function getHandler(): mixed;
```

Devuelve el gestor principal

```php
public function getHandlers(): array;
```

Devuelve los gestores registrados

```php
public function getPrefix(): string;
```

Devuelve el prefijo de la colección (si hay alguno)

```php
public function head( string $routePattern, callable $handler, string $name = null ): CollectionInterface;
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es HEAD

```php
public function isLazy(): bool;
```

Devuelve si el gestor principal debe ser cargado de forma diferida

```php
public function map( string $routePattern, callable $handler, string $name = null ): CollectionInterface;
```

Asigna una ruta a un manejador

```php
public function options( string $routePattern, callable $handler, string $name = null ): CollectionInterface;
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es OPTIONS

```php
public function patch( string $routePattern, callable $handler, string $name = null ): CollectionInterface;
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es PATCH

```php
public function post( string $routePattern, callable $handler, string $name = null ): CollectionInterface;
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es POST

```php
public function put( string $routePattern, callable $handler, string $name = null ): CollectionInterface;
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es PUT

```php
public function setHandler( mixed $handler, bool $lazy = bool ): CollectionInterface;
```

Configura el manejador principal

```php
public function setLazy( bool $lazy ): CollectionInterface;
```

Establece si el gestor principal debe ser cargado de forma diferida

```php
public function setPrefix( string $prefix ): CollectionInterface;
```

Configura un prefijo para todas las rutas agregadas a la colección

<h1 id="mvc-micro-exception">Class Phalcon\Mvc\Micro\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Micro/Exception.zep)

| Namespace | Phalcon\Mvc\Micro | | Extends | \Phalcon\Exception |

Las excepciones lanzadas en Phalcon\Mvc\Micro usarán esta clase

<h1 id="mvc-micro-lazyloader">Class Phalcon\Mvc\Micro\LazyLoader</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Micro/LazyLoader.zep)

| Namespace | Phalcon\Mvc\Micro | | Uses | Phalcon\Mvc\Model\BinderInterface |

Phalcon\Mvc\Micro\LazyLoader

Carga perezosa de manejadores para Mvc\Micro utilizando la autocarga

## Propiedades

```php
//
protected handler;

//
protected definition;

```

## Métodos

```php
public function __construct( string $definition );
```

Constructor Phalcon\Mvc\Micro\LazyLoader

```php
public function callMethod( string $method, mixed $arguments, BinderInterface $modelBinder = null );
```

Método de llamada __call

```php
public function getDefinition()
```

```php
public function getHandler()
```

<h1 id="mvc-micro-middlewareinterface">Interface Phalcon\Mvc\Micro\MiddlewareInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Micro/MiddlewareInterface.zep)

| Namespace | Phalcon\Mvc\Micro | | Uses | Phalcon\Mvc\Micro |

Permite implementar el software intermedio Phalcon\Mvc\Micro en clases

## Métodos

```php
public function call( Micro $application );
```

Llama al software intermedio

<h1 id="mvc-model">Abstract Class Phalcon\Mvc\Model</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model.zep)

| Namespace | Phalcon\Mvc | | Uses | JsonSerializable, Phalcon\Db\Adapter\AdapterInterface, Phalcon\Db\Column, Phalcon\Db\DialectInterface, Phalcon\Db\Enum, Phalcon\Db\RawValue, Phalcon\Di\AbstractInjectionAware, Phalcon\Di, Phalcon\Di\DiInterface, Phalcon\Events\ManagerInterface, Phalcon\Helper\Arr, Phalcon\Messages\Message, Phalcon\Messages\MessageInterface, Phalcon\Mvc\Model\BehaviorInterface, Phalcon\Mvc\Model\Criteria, Phalcon\Mvc\Model\CriteriaInterface, Phalcon\Mvc\Model\Exception, Phalcon\Mvc\Model\ManagerInterface, Phalcon\Mvc\Model\MetaDataInterface, Phalcon\Mvc\Model\Query, Phalcon\Mvc\Model\Query\Builder, Phalcon\Mvc\Model\Query\BuilderInterface, Phalcon\Mvc\Model\QueryInterface, Phalcon\Mvc\Model\ResultInterface, Phalcon\Mvc\Model\Resultset, Phalcon\Mvc\Model\ResultsetInterface, Phalcon\Mvc\Model\Relation, Phalcon\Mvc\Model\RelationInterface, Phalcon\Mvc\Model\TransactionInterface, Phalcon\Mvc\Model\ValidationFailed, Phalcon\Mvc\ModelInterface, Phalcon\Validation\ValidationInterface, Serializable | | Extends | AbstractInjectionAware | | Implements | EntityInterface, ModelInterface, ResultInterface, Serializable, JsonSerializable |

Phalcon\Mvc\Model

Phalcon\\Mvc\\Model conecta objetos de negocio y tablas de base de datos para crear un modelo de dominio persistente donde la lógica y los datos se presentan en una envoltura. Es una implementación del mapeo objeto-relacional (ORM).

Un modelo representa la información (datos) de la aplicación y las reglas para manipular estos datos. Los modelos se utilizan principalmente para gestionar las reglas de interacción con una correspondiente tabla de base de datos. En la mayoría de los casos, cada tabla de la base de datos corresponderá a un modelo en su aplicación. La mayor parte de la lógica de negocio de su aplicación se concentrará en los modelos.

Phalcon\Mvc\Model es el primer ORM escrito en los lenguajes Zephir/C para PHP, lo que ofrece a los desarrolladores un alto rendimiento cuando se interactúa con bases de datos y que también es fácil de utilizar.

```php
$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

if ($robot->save() === false) {
    echo "Umh, We can store robots: ";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message;
    }
} else {
    echo "Great, a new robot was saved successfully!";
}
```

## Constantes

```php
const DIRTY_STATE_DETACHED = 2;
const DIRTY_STATE_PERSISTENT = 0;
const DIRTY_STATE_TRANSIENT = 1;
const OP_CREATE = 1;
const OP_DELETE = 3;
const OP_NONE = 0;
const OP_UPDATE = 2;
const TRANSACTION_INDEX = transaction;
```

## Propiedades

```php
//
protected dirtyState = 1;

/**
 * @var array
 */
protected dirtyRelated;

/**
 * @var array
 */
protected errorMessages;

//
protected modelsManager;

//
protected modelsMetaData;

/**
 * @var array
 */
protected related;

//
protected operationMade = 0;

/**
 * @var array
 */
protected oldSnapshot;

//
protected skipped;

//
protected snapshot;

//
protected transaction;

//
protected uniqueKey;

//
protected uniqueParams;

//
protected uniqueTypes;

```

## Métodos

```php
public function __call( string $method, array $arguments );
```

Gestiona las llamadas a métodos cuando un método no se ha implementado

```php
public static function __callStatic( string $method, array $arguments );
```

Gestiona las llamadas a métodos cuando un método estático no se ha implementado

```php
final public function __construct( mixed $data = null, DiInterface $container = null, ManagerInterface $modelsManager = null );
```

Constructor Phalcon\Mvc\Model

```php
public function __get( string $property );
```

Método mágico para obtener registros relacionados usando el alias de la relación como una propiedad

```php
public function __isset( string $property ): bool;
```

Método mágico que comprueba si una propiedad es una relación válida

```php
public function __set( string $property, mixed $value );
```

Método mágico para asignar valores a el modelo

```php
public function addBehavior( BehaviorInterface $behavior ): void;
```

Configura un comportamiento en un modelo

```php
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class Robots extends Model
{
    public function initialize()
    {
        $this->addBehavior(
            new Timestampable(
                [
                    "beforeCreate" => [
                        "field"  => "created_at",
                        "format" => "Y-m-d",
                    ],
                ]
            )
        );

        $this->addBehavior(
            new Timestampable(
                [
                    "beforeUpdate" => [
                        "field"  => "updated_at",
                        "format" => "Y-m-d",
                    ],
                ]
            )
        );
    }
}
```

```php
public function appendMessage( MessageInterface $message ): ModelInterface;
```

Añade un mensaje personalizado a un proceso de validación

```php
use Phalcon\Mvc\Model;
use Phalcon\Messages\Message as Message;

class Robots extends Model
{
    public function beforeSave()
    {
        if ($this->name === "Peter") {
            $message = new Message(
                "Sorry, but a robot cannot be named Peter"
            );

            $this->appendMessage($message);
        }
    }
}
```

```php
public function assign( array $data, mixed $whiteList = null, mixed $dataColumnMap = null ): ModelInterface;
```

Asigna valores a un modelo desde un vector

```php
$robot->assign(
    [
        "type" => "mechanical",
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);

// Assign by db row, column map needed
$robot->assign(
    $dbRow,
    [
        "db_type" => "type",
        "db_name" => "name",
        "db_year" => "year",
    ]
);

// Allow assign only name and year
$robot->assign(
    $_POST,
    [
        "name",
        "year",
    ]
);

// By default assign method will use setters if exist, you can disable it by using ini_set to directly use properties

ini_set("phalcon.orm.disable_assign_setters", true);

$robot->assign(
    $_POST,
    [
        "name",
        "year",
    ]
);
```

```php
public static function average( mixed $parameters = null ): double | ResultsetInterface;
```

Devuelve el valor medio en una columna para un conjunto de resultados de filas que coinciden con las condiciones especificadas.

El valor devuelto será un float para consultas simples o una instancia de ResultsetInterface para cuando se utilice la condición GROUP. Los resultados contendrán la media de cada grupo.

```php
// What's the average price of robots?
$average = Robots::average(
    [
        "column" => "price",
    ]
);

echo "The average price is ", $average, "\n";

// What's the average price of mechanical robots?
$average = Robots::average(
    [
        "type = 'mechanical'",
        "column" => "price",
    ]
);

echo "The average price of mechanical robots is ", $average, "\n";
```

```php
public static function cloneResult( ModelInterface $base, array $data, int $dirtyState = int ): ModelInterface;
```

Asigna valores a un modelo desde un vector devolviendo un nuevo modelo

```php
$robot = Phalcon\Mvc\Model::cloneResult(
    new Robots(),
    [
        "type" => "mechanical",
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);
```

```php
public static function cloneResultMap( mixed $base, array $data, mixed $columnMap, int $dirtyState = int, bool $keepSnapshots = null ): ModelInterface;
```

Asigna valores a un modelo desde un vector, devolviendo un nuevo modelo.

```php
$robot = \Phalcon\Mvc\Model::cloneResultMap(
    new Robots(),
    [
        "type" => "mechanical",
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);
```

```php
public static function cloneResultMapHydrate( array $data, mixed $columnMap, int $hydrationMode );
```

Devuelve un resultado hidratado basado en los datos y el mapa de columnas

```php
public static function count( mixed $parameters = null ): int | ResultsetInterface;
```

Cuenta cuantos registros coinciden con las condiciones especificadas.

Devuelve un entero para consultas simples o una instancia de ResultsetInterface para cuando se utiliza la condición GROUP. Los resultados contendrán el contador de cada grupo.

```php
// How many robots are there?
$number = Robots::count();

echo "There are ", $number, "\n";

// How many mechanical robots are there?
$number = Robots::count("type = 'mechanical'");

echo "There are ", $number, " mechanical robots\n";
```

```php
public function create(): bool;
```

Inserta una instancia de modelo. Si la instancia ya existe en la persistencia producirá una excepción. Devuelve true si tiene éxito, de lo contrario devuelve false.

```php
// Creating a new robot
$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

$robot->create();

// Passing an array to create
$robot = new Robots();

$robot->assign(
    [
        "type" => "mechanical",
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);

$robot->create();
```

```php
public function delete(): bool;
```

Borra una instancia del modelo. Devuelve `true` en caso de éxito o `false` en caso contrario.

```php
$robot = Robots::findFirst("id=100");

$robot->delete();

$robots = Robots::find("type = 'mechanical'");

foreach ($robots as $robot) {
    $robot->delete();
}
```

```php
public function dump(): array;
```

Devuelve una representación simple del objeto que se puede usar con `var_dump()`

```php
var_dump(
    $robot->dump()
);
```

```php
public static function find( mixed $parameters = null ): ResultsetInterface;
```

Consulta un conjunto de registros que coinciden con las condiciones especificadas

```php
// How many robots are there?
$robots = Robots::find();

echo "There are ", count($robots), "\n";

// How many mechanical robots are there?
$robots = Robots::find(
    "type = 'mechanical'"
);

echo "There are ", count($robots), "\n";

// Get and print virtual robots ordered by name
$robots = Robots::find(
    [
        "type = 'virtual'",
        "order" => "name",
    ]
);

foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

// Get first 100 virtual robots ordered by name
$robots = Robots::find(
    [
        "type = 'virtual'",
        "order" => "name",
        "limit" => 100,
    ]
);

foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

// encapsulate find it into an running transaction esp. useful for application unit-tests
// or complex business logic where we wanna control which transactions are used.

$myTransaction = new Transaction(\Phalcon\Di::getDefault());
$myTransaction->begin();

$newRobot = new Robot();
$newRobot->setTransaction($myTransaction);

$newRobot->assign(
    [
        'name' => 'test',
        'type' => 'mechanical',
        'year' => 1944,
    ]
);

$newRobot->save();

$resultInsideTransaction = Robot::find(
    [
        'name' => 'test',
        Model::TRANSACTION_INDEX => $myTransaction,
    ]
);

$resultOutsideTransaction = Robot::find(['name' => 'test']);

foreach ($setInsideTransaction as $robot) {
    echo $robot->name, "\n";
}

foreach ($setOutsideTransaction as $robot) {
    echo $robot->name, "\n";
}

// reverts all not commited changes
$myTransaction->rollback();

// creating two different transactions
$myTransaction1 = new Transaction(\Phalcon\Di::getDefault());
$myTransaction1->begin();
$myTransaction2 = new Transaction(\Phalcon\Di::getDefault());
$myTransaction2->begin();

 // add a new robots
$firstNewRobot = new Robot();
$firstNewRobot->setTransaction($myTransaction1);
$firstNewRobot->assign(
    [
        'name' => 'first-transaction-robot',
        'type' => 'mechanical',
        'year' => 1944,
    ]
);
$firstNewRobot->save();

$secondNewRobot = new Robot();
$secondNewRobot->setTransaction($myTransaction2);
$secondNewRobot->assign(
    [
        'name' => 'second-transaction-robot',
        'type' => 'fictional',
        'year' => 1984,
    ]
);
$secondNewRobot->save();

// this transaction will find the robot.
$resultInFirstTransaction = Robot::find(
    [
        'name'                   => 'first-transaction-robot',
        Model::TRANSACTION_INDEX => $myTransaction1,
    ]
);

// this transaction won't find the robot.
$resultInSecondTransaction = Robot::find(
    [
        'name'                   => 'first-transaction-robot',
        Model::TRANSACTION_INDEX => $myTransaction2,
    ]
);

// this transaction won't find the robot.
$resultOutsideAnyExplicitTransaction = Robot::find(
    [
        'name' => 'first-transaction-robot',
    ]
);

// this transaction won't find the robot.
$resultInFirstTransaction = Robot::find(
    [
        'name'                   => 'second-transaction-robot',
        Model::TRANSACTION_INDEX => $myTransaction2,
    ]
);

// this transaction will find the robot.
$resultInSecondTransaction = Robot::find(
    [
        'name'                   => 'second-transaction-robot',
        Model::TRANSACTION_INDEX => $myTransaction1,
    ]
);

// this transaction won't find the robot.
$resultOutsideAnyExplicitTransaction = Robot::find(
    [
        'name' => 'second-transaction-robot',
    ]
);

$transaction1->rollback();
$transaction2->rollback();
```

```php
public static function findFirst( mixed $parameters = null ): ModelInterface | null;
```

Consulta el primer registro que coincide con las condiciones especificadas

```php
// What's the first robot in robots table?
$robot = Robots::findFirst();

echo "The robot name is ", $robot->name;

// What's the first mechanical robot in robots table?
$robot = Robots::findFirst(
    "type = 'mechanical'"
);

echo "The first mechanical robot name is ", $robot->name;

// Get first virtual robot ordered by name
$robot = Robots::findFirst(
    [
        "type = 'virtual'",
        "order" => "name",
    ]
);

echo "The first virtual robot name is ", $robot->name;

// behaviour with transaction
$myTransaction = new Transaction(\Phalcon\Di::getDefault());
$myTransaction->begin();

$newRobot = new Robot();
$newRobot->setTransaction($myTransaction);
$newRobot->assign(
    [
        'name' => 'test',
        'type' => 'mechanical',
        'year' => 1944,
    ]
);
$newRobot->save();

$findsARobot = Robot::findFirst(
    [
        'name'                   => 'test',
        Model::TRANSACTION_INDEX => $myTransaction,
    ]
);

$doesNotFindARobot = Robot::findFirst(
    [
        'name' => 'test',
    ]
);

var_dump($findARobot);
var_dump($doesNotFindARobot);

$transaction->commit();

$doesFindTheRobotNow = Robot::findFirst(
    [
        'name' => 'test',
    ]
);
```

```php
public function fireEvent( string $eventName ): bool;
```

Dispara un evento, llama implícitamente a comportamientos y se notifica a los oyentes del gestor de eventos

```php
public function fireEventCancel( string $eventName ): bool;
```

Dispara un evento, implícitamente se notifica a los comportamientos y oyentes de las llamadas en el gestor de eventos. Este método se detiene si una de las funciones de retorno/oyentes devuelve el valor booleano false

```php
public function getChangedFields(): array;
```

Devuelve una lista de valores cambiados.

```php
$robots = Robots::findFirst();
print_r($robots->getChangedFields()); // []

$robots->deleted = 'Y';

$robots->getChangedFields();
print_r($robots->getChangedFields()); // ["deleted"]
```

```php
public function getDirtyState(): int;
```

Devuelve una de las constantes DIRTY_STATE_* que indica si el registro existe en la base de datos o no

```php
public function getEventsManager(): EventsManagerInterface | null;
```

Devuelve el gestor de eventos personalizado o nulo si no hay ningún gestor de eventos personalizado

```php
public function getMessages( mixed $filter = null ): MessageInterface[];
```

Devuelve un vector de mensajes de validación

```php
$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

if ($robot->save() === false) {
    echo "Umh, We can't store robots right now ";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message;
    }
} else {
    echo "Great, a new robot was saved successfully!";
}
```

```php
public function getModelsManager(): ManagerInterface;
```

Devuelve el gestor de modelos relacionado con la instancia de la entidad

```php
public function getModelsMetaData(): MetaDataInterface;
```
{@inheritdoc}


```php
public function getOldSnapshotData(): array;
```

Devuelve los datos de instantánea internos antiguos

```php
public function getOperationMade(): int;
```

Devuelve el tipo de la operación realizada por el ORM más reciente. Devuelve una de las constantes de clase OP_*

```php
final public function getReadConnection(): AdapterInterface;
```

Obtiene la conexión usada para leer datos del modelo

```php
final public function getReadConnectionService(): string;
```

Devuelve el nombre del servicio de conexión de *DependencyInjection* usado para leer datos relacionados del modelo

```php
public function getRelated( string $alias, mixed $arguments = null );
```

Devuelve registros relacionados basados en relaciones definidas

```php
final public function getSchema(): string;
```

Devuelve el nombre del esquema donde se encuentra la tabla mapeada

```php
public function getSnapshotData(): array;
```

Devuelve los datos de instantánea internos

```php
final public function getSource(): string;
```

Devuelve el nombre de tabla mapeada en el modelo

```php
public function getTransaction()
```

```php
public function getUpdatedFields(): array;
```

Devuelve una lista de valores actualizados.

```php
$robots = Robots::findFirst();
print_r($robots->getChangedFields()); // []

$robots->deleted = 'Y';

$robots->getChangedFields();
print_r($robots->getChangedFields()); // ["deleted"]
$robots->save();
print_r($robots->getChangedFields()); // []
print_r($robots->getUpdatedFields()); // ["deleted"]
```

```php
final public function getWriteConnection(): AdapterInterface;
```

Obtiene la conexión usada para escribir datos al modelo

```php
final public function getWriteConnectionService(): string;
```

Devuelve el nombre del servicio de conexión de *DependencyInjection* usado para escribir datos relacionados al modelo

```php
public function hasChanged( mixed $fieldName = null, bool $allFields = bool ): bool;
```

Comprueba si un atributo específico ha cambiado. Esto solo funciona si el modelo mantiene instantáneas de los datos

```php
$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

$robot->create();

$robot->type = "hydraulic";

$hasChanged = $robot->hasChanged("type"); // returns true
$hasChanged = $robot->hasChanged(["type", "name"]); // returns true
$hasChanged = $robot->hasChanged(["type", "name"], true); // returns false
```

```php
public function hasSnapshotData(): bool;
```

Comprueba si el objeto tiene datos de instantánea internos

```php
public function hasUpdated( mixed $fieldName = null, bool $allFields = bool ): bool;
```

Comprueba si un atributo específico fue actualizado. Esto solo funciona si el modelo mantiene instantáneas de los datos

```php
public function isRelationshipLoaded( string $relationshipAlias ): bool;
```

Comprueba si los registros relacionados guardados ya se han cargado.

Sólo devuelve true si los registros se obtuvieron previamente a través del modelo sin ningún parámetro adicional.

```php
$robot = Robots::findFirst();
var_dump($robot->isRelationshipLoaded('robotsParts')); // false

$robotsParts = $robot->getRobotsParts(['id > 0']);
var_dump($robot->isRelationshipLoaded('robotsParts')); // false

$robotsParts = $robot->getRobotsParts(); // or $robot->robotsParts
var_dump($robot->isRelationshipLoaded('robotsParts')); // true

$robot->robotsParts = [new RobotsParts()];
var_dump($robot->isRelationshipLoaded('robotsParts')); // false
```

```php
public function jsonSerialize(): array;
```

Serializa el objeto por json_encode

   ```php
   echo json_encode($robot);
   ```

```php
public static function maximum( mixed $parameters = null ): mixed;
```

Devuelve el valor máximo de una columna para un conjunto de resultados de filas que coinciden con las condiciones especificadas

```php
// What is the maximum robot id?
$id = Robots::maximum(
    [
        "column" => "id",
    ]
);

echo "The maximum robot id is: ", $id, "\n";

// What is the maximum id of mechanical robots?
$sum = Robots::maximum(
    [
        "type = 'mechanical'",
        "column" => "id",
    ]
);

echo "The maximum robot id of mechanical robots is ", $id, "\n";
```

```php
public static function minimum( mixed $parameters = null ): mixed;
```

Devuelve el valor mínimo de una columna para un conjunto de resultados de filas que coinciden con las condiciones especificadas

```php
// What is the minimum robot id?
$id = Robots::minimum(
    [
        "column" => "id",
    ]
);

echo "The minimum robot id is: ", $id;

// What is the minimum id of mechanical robots?
$sum = Robots::minimum(
    [
        "type = 'mechanical'",
        "column" => "id",
    ]
);

echo "The minimum robot id of mechanical robots is ", $id;
```

```php
public static function query( DiInterface $container = null ): CriteriaInterface;
```

Crea un criterio para un modelo específico

```php
public function readAttribute( string $attribute ): mixed | null;
```

Lee un valor de atributo por su nombre

```php
echo $robot->readAttribute("name");
```

```php
public function refresh(): ModelInterface;
```

Refresca los atributos del modelo consultando otra vez el registro desde la base de datos

```php
public function save(): bool;
```

Inserta o actualiza una instancia de modelo. Devuelve `true` en caso de éxito o `false` en caso contrario.

```php
// Creating a new robot
$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

$robot->save();

// Updating a robot name
$robot = Robots::findFirst("id = 100");

$robot->name = "Biomass";

$robot->save();
```

```php
public function serialize(): string;
```

Serializa el objeto ignorando conexiones, servicios, objetos relacionados o propiedades estáticas

```php
final public function setConnectionService( string $connectionService ): void;
```

Establece el nombre del servicio de conexión *DependencyInjection*

```php
public function setDirtyState( int $dirtyState ): ModelInterface | bool;
```

Establece el estado de suciedad del objeto usando una de las constantes DIRTY_STATE_*

```php
public function setEventsManager( EventsManagerInterface $eventsManager );
```

Establece un gestor de eventos personalizado

```php
public function setOldSnapshotData( array $data, mixed $columnMap = null );
```

Establece los datos viejos de instantánea del registro. Este método se usa internamente para establecer datos de instantánea viejos cuando el modelo haya sido configurado para mantener datos de instantánea

```php
final public function setReadConnectionService( string $connectionService ): void;
```

Establece el nombre de servicio de conexión *DependencyInjection* usado para leer datos

```php
public function setSnapshotData( array $data, mixed $columnMap = null ): void;
```

Establece los datos de instantánea del registro. Este método se usa internamente para establecer los datos de instantánea cuando el modelo haya sido configurado para mantener datos de instantánea

```php
public function setTransaction( TransactionInterface $transaction ): ModelInterface;
```

Establece una transacción relacionada con la instancia del modelo

```php
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;

try {
    $txManager = new TxManager();

    $transaction = $txManager->get();

    $robot = new Robots();

    $robot->setTransaction($transaction);

    $robot->name       = "WALL·E";
    $robot->created_at = date("Y-m-d");

    if ($robot->save() === false) {
        $transaction->rollback("Can't save robot");
    }

    $robotPart = new RobotParts();

    $robotPart->setTransaction($transaction);

    $robotPart->type = "head";

    if ($robotPart->save() === false) {
        $transaction->rollback("Robot part cannot be saved");
    }

    $transaction->commit();
} catch (TxFailed $e) {
    echo "Failed, reason: ", $e->getMessage();
}
```

```php
final public function setWriteConnectionService( string $connectionService ): void;
```

Establece el nombre de servicio de conexión *DependencyInjection* usado para escribir datos

```php
public static function setup( array $options ): void;
```

Habilita/deshabilita las opciones en el ORM

```php
public function skipOperation( bool $skip ): void;
```

Omite la operación actual forzando un estado de éxito

```php
public static function sum( mixed $parameters = null ): double | ResultsetInterface;
```

Calcula la suma de una columna para un conjunto de resultados de filas que coinciden con las condiciones especificadas

```php
// How much are all robots?
$sum = Robots::sum(
    [
        "column" => "price",
    ]
);

echo "The total price of robots is ", $sum, "\n";

// How much are mechanical robots?
$sum = Robots::sum(
    [
        "type = 'mechanical'",
        "column" => "price",
    ]
);

echo "The total price of mechanical robots is  ", $sum, "\n";
```

```php
public function toArray( mixed $columns = null ): array;
```

Devuelve la instancia como una representación de vector

```php
print_r(
    $robot->toArray()
);
```

```php
public function unserialize( mixed $data );
```

Deserializa el objeto desde una cadena serializada

```php
public function update(): bool;
```

Actualiza una instancia de modelo. Si la instancia no existe en la persistencia lanzará una excepción. Devuelve `true` en caso de éxito o `false` en caso contrario.

```php
// Updating a robot name
$robot = Robots::findFirst("id = 100");

$robot->name = "Biomass";

$robot->update();
```

```php
public function validationHasFailed(): bool;
```

Comprueba si el proceso de validación ha generado algún mensaje

```php
use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\ExclusionIn;

class Subscriptors extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->validate(
            "status",
            new ExclusionIn(
                [
                    "domain" => [
                        "A",
                        "I",
                    ],
                ]
            )
        );

        return $this->validate($validator);
    }
}
```

```php
public function writeAttribute( string $attribute, mixed $value ): void;
```

Escribe un valor de atributo por su nombre

```php
$robot->writeAttribute("name", "Rosey");
```

```php
protected function _cancelOperation();
```

Cancela la operación actual

@todo Remove in v5.0 @deprecated Use cancelOperation()

```php
final protected function _checkForeignKeysRestrict(): bool;
```

Lee relaciones "belongs to" y comprueba las claves virtuales externas cuando se insertan o actualizan registros para verificar que los valores insertados o actualizados estén presentes en la entidad relacionada

```php
final protected function _checkForeignKeysReverseCascade(): bool;
```

Lee las relaciones "hasMany" y "hasOne" y comprueba las claves virtuales externas (cascada) cuando se eliminan registros

```php
final protected function _checkForeignKeysReverseRestrict(): bool;
```

Lee las relaciones "hasMany" y "hasOne" y comprueba las claves virtuales externas (restringida) cuando se eliminan registros

```php
protected function _doLowInsert( MetaDataInterface $metaData, AdapterInterface $connection, mixed $table, mixed $identityField ): bool;
```

Envía una sentencia SQL INSERT preconstruida al sistema de base de datos relacional

@todo Remove in v5.0 @deprecated Use doLowInsert()

```php
protected function _doLowUpdate( MetaDataInterface $metaData, AdapterInterface $connection, mixed $table ): bool;
```

Envía una sentencia SQL UPDATE preconstruida al sistema de base de datos relacional

@todo Remove in v5.0 @deprecated Use doLowUpdate()

```php
protected function _exists( MetaDataInterface $metaData, AdapterInterface $connection ): bool;
```

Comprueba si el registro actual ya existe

@todo Remove in v5.0 @deprecated Use exists()

```php
protected function _getRelatedRecords( string $modelName, string $method, array $arguments );
```

Devuelve las relaciones definidas de los registros relacionados dependiendo del nombre del método. Devuelve falso si la relación no existe.

@todo Remove in v5.0 @deprecated Use getRelatedRecords()

```php
protected static function _groupResult( string $functionName, string $alias, mixed $parameters ): ResultsetInterface;
```

Genera una sentencia PHQL SELECT para un agregado

@todo Remove in v5.0 @deprecated Use groupResult()

```php
final protected function _possibleSetter( string $property, mixed $value ): bool;
```

Comprueba, e intenta usar, un posible *setter*.

```php
protected function _postSave( bool $success, bool $exists ): bool;
```

Ejecuta eventos internos después de guardar un registro

@todo Remove in v5.0 @deprecated Use postSave()

```php
protected function _postSaveRelatedRecords( AdapterInterface $connection, mixed $related ): bool;
```

Guarda los archivos relacionados asignados en las relaciones tiene-uno/tiene-muchos

@todo Remove in v5.0 @deprecated Use postSaveRelatedRecords()

```php
protected function _preSave( MetaDataInterface $metaData, bool $exists, mixed $identityField ): bool;
```

Ejecuta enlaces internos antes de guardar un registro

@todo Remove in v5.0 @deprecated Use preSave()

```php
protected function _preSaveRelatedRecords( AdapterInterface $connection, mixed $related ): bool;
```

Guarda los registros relacionados que deben almacenarse antes de guardar el registro maestro

@todo Remove in v5.0 @deprecated Use preSaveRelatedRecords()

```php
protected function allowEmptyStringValues( array $attributes ): void;
```

Establece una lista de atributos que se deben omitir de la sentencia UPDATE generada

```php
class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->allowEmptyStringValues(
            [
                "name",
            ]
        );
    }
}
```

```php
protected function belongsTo( mixed $fields, string $referenceModel, mixed $referencedFields, mixed $options = null ): Relation;
```

Configura una relación 1-1 inversa o n-1 entre dos modelos

```php
class RobotsParts extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->belongsTo(
            "robots_id",
            Robots::class,
            "id"
        );
    }
}
```

```php
protected function cancelOperation();
```

Cancela la operación actual

```php
protected function collectRelatedToSave(): array;
```

Recoge registros relacionados previamente consultados (`belongs-to`, `has-one` y `has-one-through`) junto con uno recién añadido

```php
protected function doLowInsert( MetaDataInterface $metaData, AdapterInterface $connection, mixed $table, mixed $identityField ): bool;
```

Envía una sentencia SQL INSERT preconstruida al sistema de base de datos relacional

```php
protected function doLowUpdate( MetaDataInterface $metaData, AdapterInterface $connection, mixed $table ): bool;
```

Envía una sentencia SQL UPDATE preconstruida al sistema de base de datos relacional

```php
protected function exists( MetaDataInterface $metaData, AdapterInterface $connection ): bool;
```

Comprueba si el registro actual ya existe

```php
protected function getRelatedRecords( string $modelName, string $method, array $arguments );
```

Devuelve las relaciones definidas de los registros relacionados dependiendo del nombre del método. Devuelve falso si la relación no existe.

```php
protected static function groupResult( string $functionName, string $alias, mixed $parameters ): ResultsetInterface;
```

Genera una sentencia PHQL SELECT para un agregado

```php
protected function hasMany( mixed $fields, string $referenceModel, mixed $referencedFields, mixed $options = null ): Relation;
```

Configura una relación 1-n entre dos modelos

```php
class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->hasMany(
            "id",
            RobotsParts::class,
            "robots_id"
        );
    }
}
```

```php
protected function hasManyToMany( mixed $fields, string $intermediateModel, mixed $intermediateFields, mixed $intermediateReferencedFields, string $referenceModel, mixed $referencedFields, mixed $options = null ): Relation;
```

Configura una relación n-n entre dos modelos, a través de una relación intermedia

```php
class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        // Setup a many-to-many relation to Parts through RobotsParts
        $this->hasManyToMany(
            "id",
            RobotsParts::class,
            "robots_id",
            "parts_id",
            Parts::class,
            "id",
        );
    }
}
```

```php
protected function hasOne( mixed $fields, string $referenceModel, mixed $referencedFields, mixed $options = null ): Relation;
```

Configura una relación 1-1 entre dos modelos

```php
class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->hasOne(
            "id",
            RobotsDescription::class,
            "robots_id"
        );
    }
}
```

```php
protected function hasOneThrough( mixed $fields, string $intermediateModel, mixed $intermediateFields, mixed $intermediateReferencedFields, string $referenceModel, mixed $referencedFields, mixed $options = null ): Relation;
```

Configura una relación 1-1 entre dos modelos, a través de una relación intermedia

```php
class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        // Setup a 1-1 relation to one item from Parts through RobotsParts
        $this->hasOneThrough(
            "id",
            RobotsParts::class,
            "robots_id",
            "parts_id",
            Parts::class,
            "id",
        );
    }
}
```

```php
protected function keepSnapshots( bool $keepSnapshot ): void;
```

Configura si el modelo debe mantener la instantánea del registro original en memoria

```php
use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->keepSnapshots(true);
    }
}
```

```php
protected function postSave( bool $success, bool $exists ): bool;
```

Ejecuta eventos internos después de guardar un registro

```php
protected function postSaveRelatedRecords( AdapterInterface $connection, mixed $related ): bool;
```

Guarda los archivos relacionados asignados en las relaciones tiene-uno/tiene-muchos

```php
protected function preSave( MetaDataInterface $metaData, bool $exists, mixed $identityField ): bool;
```

Ejecuta enlaces internos antes de guardar un registro

```php
protected function preSaveRelatedRecords( AdapterInterface $connection, mixed $related ): bool;
```

Guarda los registros relacionados que deben almacenarse antes de guardar el registro maestro

```php
final protected function setSchema( string $schema ): ModelInterface;
```

Establece el nombre del esquema donde se ubica la tabla mapeada

```php
final protected function setSource( string $source ): ModelInterface;
```

Establece el nombre de tabla al que se debe mapear el modelo

```php
protected function skipAttributes( array $attributes );
```

Configura una lista de atributos que se deben omitir de la sentencia INSERT/UPDATE generada

```php
class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->skipAttributes(
            [
                "price",
            ]
        );
    }
}
```

```php
protected function skipAttributesOnCreate( array $attributes ): void;
```

Configura una lista de atributos que se deben omitir de la declaración INSERT generada

```php
class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->skipAttributesOnCreate(
            [
                "created_at",
            ]
        );
    }
}
```

```php
protected function skipAttributesOnUpdate( array $attributes ): void;
```

Establece una lista de atributos que se deben omitir de la sentencia UPDATE generada

```php
class Robots extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->skipAttributesOnUpdate(
            [
                "modified_in",
            ]
        );
    }
}
```

```php
protected function useDynamicUpdate( bool $dynamicUpdate ): void;
```

Establece si el modelo debe usar actualización dinámica en vez de actualizar todos los campos

```php
use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->useDynamicUpdate(true);
    }
}
```

```php
protected function validate( ValidationInterface $validator ): bool;
```

Ejecuta los validadores en cada llamada de validación

```php
use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\ExclusionIn;

class Subscriptors extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            "status",
            new ExclusionIn(
                [
                    "domain" => [
                        "A",
                        "I",
                    ],
                ]
            )
        );

        return $this->validate($validator);
    }
}
```

<h1 id="mvc-model-behavior">Abstract Class Phalcon\Mvc\Model\Behavior</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Behavior.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Phalcon\Mvc\ModelInterface | | Implements | BehaviorInterface |

Phalcon\Mvc\Model\Behavior

Este es una clase base opcional para comportamientos ORM

## Propiedades

```php
/**
 * @var array
 */
protected options;

```

## Métodos

```php
public function __construct( array $options = [] );
```

Phalcon\Mvc\Model\Behavior

```php
public function missingMethod( ModelInterface $model, string $method, array $arguments = [] );
```

Actúa como respaldo cuando se llama un método inexistente en el modelo

```php
public function notify( string $type, ModelInterface $model );
```

Este método recibe las notificaciones del EventsManager

```php
protected function getOptions( string $eventName = null );
```

Devuelve las opciones de comportamiento relacionadas a un evento

```php
protected function mustTakeAction( string $eventName ): bool;
```

Comprueba si el comportamiento debe actuar en ciertos eventos

<h1 id="mvc-model-behavior-softdelete">Class Phalcon\Mvc\Model\Behavior\SoftDelete</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Behavior/SoftDelete.zep)

| Namespace | Phalcon\Mvc\Model\Behavior | | Uses | Phalcon\Mvc\ModelInterface, Phalcon\Mvc\Model\Behavior, Phalcon\Mvc\Model\Exception | | Extends | Behavior |

Phalcon\Mvc\Model\Behavior\SoftDelete

En lugar de borrar permanentemente un registro, marca el registro como borrado cambiando el valor de una columna bandera

## Métodos

```php
public function notify( string $type, ModelInterface $model );
```

Escucha las notificaciones del gestor de modelos

<h1 id="mvc-model-behavior-timestampable">Class Phalcon\Mvc\Model\Behavior\Timestampable</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Behavior/Timestampable.zep)

| Namespace | Phalcon\Mvc\Model\Behavior | | Uses | Closure, Phalcon\Mvc\ModelInterface, Phalcon\Mvc\Model\Behavior, Phalcon\Mvc\Model\Exception | | Extends | Behavior |

Phalcon\Mvc\Model\Behavior\Timestampable

Permite actualizar automáticamente el atributo del modelo guardando la fecha y hora cuando se creó o actualizó el registro

## Métodos

```php
public function notify( string $type, ModelInterface $model );
```

Escucha las notificaciones del gestor de modelos

<h1 id="mvc-model-behaviorinterface">Interface Phalcon\Mvc\Model\BehaviorInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/BehaviorInterface.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Phalcon\Mvc\ModelInterface |

Phalcon\Mvc\Model\BehaviorInterface

Interfaz para Phalcon\Mvc\Model\Behavior

## Métodos

```php
public function missingMethod( ModelInterface $model, string $method, array $arguments = [] );
```

Llama a un método cuando falta en el modelo

```php
public function notify( string $type, ModelInterface $model );
```

Este método recibe las notificaciones del EventsManager

<h1 id="mvc-model-binder">Class Phalcon\Mvc\Model\Binder</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Binder.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Closure, Phalcon\Mvc\Controller\BindModelInterface, Phalcon\Mvc\Model\Binder\BindableInterface, Phalcon\Cache\Adapter\AdapterInterface, ReflectionFunction, ReflectionMethod | | Implements | BinderInterface |

Phalcon\Mvc\Model\Binder

Esta es una clase para vincular modelos en parámetros para el manejador

## Propiedades

```php
/**
 * Array for storing active bound models
 *
 * @var array
 */
protected boundModels;

/**
 * Cache object used for caching parameters for model binding
 */
protected cache;

/**
 * Internal cache for caching parameters for model binding during request
 */
protected internalCache;

/**
 * Array for original values
 */
protected originalValues;

```

## Métodos

```php
public function __construct( AdapterInterface $cache = null );
```

Constructor Phalcon\Mvc\Model\Binder

```php
public function bindToHandler( object $handler, array $params, string $cacheKey, string $methodName = null ): array;
```

Vincular modelos en parámetros en el manejador apropiado

```php
public function getBoundModels(): array
```

```php
public function getCache(): AdapterInterface;
```

Establece la instancia de caché

```php
public function getOriginalValues()
```

```php
public function setCache( AdapterInterface $cache ): BinderInterface;
```

Obtiene instancia de caché

```php
protected function findBoundModel( mixed $paramValue, string $className ): mixed | bool;
```

Encuentra el modelo por valor de parámetro.

```php
protected function getParamsFromCache( string $cacheKey ): array | null;
```

Obtener parámetros de clases del caché por clave

```php
protected function getParamsFromReflection( object $handler, array $params, string $cacheKey, string $methodName ): array;
```

Obtener parámetros modificados para el manejador usando la reflexión

<h1 id="mvc-model-binder-bindableinterface">Interface Phalcon\Mvc\Model\Binder\BindableInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Binder/BindableInterface.zep)

| Namespace | Phalcon\Mvc\Model\Binder |

Phalcon\Mvc\Model\Binder\BindableInterface

Interfaz para clases vinculables

## Métodos

```php
public function getModelName(): string | array;
```

Devuelve el nombre del modelo o los nombres de los modelos y las claves de parámetros asociadas con esta clase

<h1 id="mvc-model-binderinterface">Interface Phalcon\Mvc\Model\BinderInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/BinderInterface.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Phalcon\Cache\Adapter\AdapterInterface |

Phalcon\Mvc\Model\BinderInterface

Interfaz para Phalcon\Mvc\Model\Binder

## Métodos

```php
public function bindToHandler( object $handler, array $params, string $cacheKey, string $methodName = null ): array;
```

Vincular modelos en parámetros en el manejador apropiado

```php
public function getBoundModels(): array;
```

Obtiene modelos enlazados activos

```php
public function getCache(): AdapterInterface;
```

Obtiene instancia de caché

```php
public function setCache( AdapterInterface $cache ): BinderInterface;
```

Establece la instancia de caché

<h1 id="mvc-model-criteria">Class Phalcon\Mvc\Model\Criteria</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Criteria.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Phalcon\Di, Phalcon\Db\Column, Phalcon\Di\DiInterface, Phalcon\Di\InjectionAwareInterface, Phalcon\Mvc\Model\Query\BuilderInterface | | Implements | CriteriaInterface, InjectionAwareInterface |

Phalcon\Mvc\Model\Criteria

Esta clase se usa para construir el parámetro de vector requerido por Phalcon\\Mvc\\Model::find() y Phalcon\\Mvc\\Model::findFirst() usando una interfaz orientada a objetos.

```php
$robots = Robots::query()
    ->where("type = :type:")
    ->andWhere("year < 2000")
    ->bind(["type" => "mechanical"])
    ->limit(5, 10)
    ->orderBy("name")
    ->execute();
```

## Propiedades

```php
//
protected bindParams;

//
protected bindTypes;

//
protected hiddenParamNumber = 0;

//
protected model;

//
protected params;

```

## Métodos

```php
public function andWhere( string $conditions, mixed $bindParams = null, mixed $bindTypes = null ): CriteriaInterface;
```

Añade una condición a las condiciones actuales usando un operador AND

```php
public function betweenWhere( string $expr, mixed $minimum, mixed $maximum ): CriteriaInterface;
```

Añade una condición BETWEEN a las condiciones actuales

```php
$criteria->betweenWhere("price", 100.25, 200.50);
```

```php
public function bind( array $bindParams, bool $merge = bool ): CriteriaInterface;
```

Establece los parámetros enlazados en los criterios Este método reemplaza todos los parámetros vinculados establecidos previamente

```php
public function bindTypes( array $bindTypes ): CriteriaInterface;
```

Establece los tipos de enlace en los criterios Este método reemplaza todos los parámetros vinculados establecidos previamente

```php
public function cache( array $cache ): CriteriaInterface;
```

Establece las opciones de cache en los criterios Este método reemplaza todas las opciones de cache establecidas previamente

```php
public function columns( mixed $columns ): CriteriaInterface;
```

Establece las columnas a consultar

```php
$criteria->columns(
    [
        "id",
        "name",
    ]
);
```

```php
public function conditions( string $conditions ): CriteriaInterface;
```

Añade el parámetro de condiciones a los criterios

```php
public function createBuilder(): BuilderInterface;
```

Crea un constructor de consultas a partir de criterios.

```php
$builder = Robots::query()
    ->where("type = :type:")
    ->bind(["type" => "mechanical"])
    ->createBuilder();
```

```php
public function distinct( mixed $distinct ): CriteriaInterface;
```

Establece la bandera SELECT DISTINCT / SELECT ALL

```php
public function execute(): ResultsetInterface;
```

Ejecuta una búsqueda usando los parámetros construidos con los criterios

```php
public function forUpdate( bool $forUpdate = bool ): CriteriaInterface;
```

Añade el parámetro "for_update" al criterio

```php
public static function fromInput( DiInterface $container, string $modelName, array $data, string $operator = string ): CriteriaInterface;
```

Construye un Phalcon\Mvc\Model\Criteria basado en un vector de entrada como $_POST

```php
public function getColumns(): string | array | null;
```

Devuelve las columnas a ser consultadas

```php
public function getConditions(): string | null;
```

Devuelve el parámetro de condiciones en los criterios

```php
public function getDI(): DiInterface;
```

Devuelve el contenedor DependencyInjector

```php
public function getGroupBy();
```

Devuelve la cláusula de grupo en los criterios

```php
public function getHaving();
```

Devuelve la cláusula `having` en los criterios

```php
public function getLimit(): int | array | null;
```

Devuelve el parámetro de límite en los criterios, que será

- Un entero si 'limit' se configuró sin un 'offset'
- Una vector con las claves 'number' y 'offset' si se configuró un desplazamiento con el límite
- NULL si no se ha establecido el límite

```php
public function getModelName(): string;
```

Devuelve un nombre de modelo interno al que se le aplicarán los criterios

```php
public function getOrderBy(): string | null;
```

Devuelve la cláusula de orden en los criterios

```php
public function getParams(): array;
```

Devuelve todos los parámetros definidos en los criterios

```php
public function getWhere(): string | null;
```

Devuelve el parámetro de condiciones en los criterios

```php
public function groupBy( mixed $group ): CriteriaInterface;
```

Añade la cláusula group-by a los criterios

```php
public function having( mixed $having ): CriteriaInterface;
```

Añade la cláusula `having` a los criterios

```php
public function inWhere( string $expr, array $values ): CriteriaInterface;
```

Añade una condición IN a las condiciones actuales

```php
$criteria->inWhere("id", [1, 2, 3]);
```

```php
public function innerJoin( string $model, mixed $conditions = null, mixed $alias = null ): CriteriaInterface;
```

Añade un `INNER join` a la consulta

```php
$criteria->innerJoin(
    Robots::class
);

$criteria->innerJoin(
    Robots::class,
    "r.id = RobotsParts.robots_id"
);

$criteria->innerJoin(
    Robots::class,
    "r.id = RobotsParts.robots_id",
    "r"
);
```

```php
public function join( string $model, mixed $conditions = null, mixed $alias = null, mixed $type = null ): CriteriaInterface;
```

Añade un `INNER join` a la consulta

```php
$criteria->join(
    Robots::class
);

$criteria->join(
    Robots::class,
    "r.id = RobotsParts.robots_id"
);

$criteria->join(
    Robots::class,
    "r.id = RobotsParts.robots_id",
    "r"
);

$criteria->join(
    Robots::class,
    "r.id = RobotsParts.robots_id",
    "r",
    "LEFT"
);
```

```php
public function leftJoin( string $model, mixed $conditions = null, mixed $alias = null ): CriteriaInterface;
```

Añade un `LEFT join` a la consulta

```php
$criteria->leftJoin(
    Robots::class,
    "r.id = RobotsParts.robots_id",
    "r"
);
```

```php
public function limit( int $limit, int $offset = int ): CriteriaInterface;
```

Añade el parámetro límite a los criterios.

```php
$criteria->limit(100);
$criteria->limit(100, 200);
$criteria->limit("100", "200");
```

```php
public function notBetweenWhere( string $expr, mixed $minimum, mixed $maximum ): CriteriaInterface;
```

Añade una condición NOT BETWEEN a las condiciones actuales

```php
$criteria->notBetweenWhere("price", 100.25, 200.50);
```

```php
public function notInWhere( string $expr, array $values ): CriteriaInterface;
```

Añade una condición NOT IN a las condiciones actuales

```php
$criteria->notInWhere("id", [1, 2, 3]);
```

```php
public function orWhere( string $conditions, mixed $bindParams = null, mixed $bindTypes = null ): CriteriaInterface;
```

Añade una condición a las condiciones actuales usando un operador OR

```php
public function orderBy( string $orderColumns ): CriteriaInterface;
```

Añade la cláusula order-by a los criterios

```php
public function rightJoin( string $model, mixed $conditions = null, mixed $alias = null ): CriteriaInterface;
```

Añade un `RIGHT join` a la consulta

```php
$criteria->rightJoin(
    Robots::class,
    "r.id = RobotsParts.robots_id",
    "r"
);
```

```php
public function setDI( DiInterface $container ): void;
```

Configura el contenedor DependencyInjector

```php
public function setModelName( string $modelName ): CriteriaInterface;
```

Establece un modelo en el que se ejecutará la consulta

```php
public function sharedLock( bool $sharedLock = bool ): CriteriaInterface;
```

Añade el parámetro "shared_lock" al criterio

```php
public function where( string $conditions, mixed $bindParams = null, mixed $bindTypes = null ): CriteriaInterface;
```

Establece el parámetro de condiciones en los criterios

<h1 id="mvc-model-criteriainterface">Interface Phalcon\Mvc\Model\CriteriaInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/CriteriaInterface.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Phalcon\Di\DiInterface |

Phalcon\Mvc\Model\CriteriaInterface

Interfaz para Phalcon\Mvc\Model\Criteria

## Métodos

```php
public function andWhere( string $conditions, mixed $bindParams = null, mixed $bindTypes = null ): CriteriaInterface;
```

Añade una condición a las condiciones actuales usando un operador AND

```php
public function betweenWhere( string $expr, mixed $minimum, mixed $maximum ): CriteriaInterface;
```

Añade una condición BETWEEN a las condiciones actuales

```php
$criteria->betweenWhere("price", 100.25, 200.50);
```

```php
public function bind( array $bindParams ): CriteriaInterface;
```

Establece los parámetros enlazados en los criterios Este método reemplaza todos los parámetros vinculados establecidos previamente

```php
public function bindTypes( array $bindTypes ): CriteriaInterface;
```

Establece los tipos de enlace en los criterios Este método reemplaza todos los parámetros vinculados establecidos previamente

```php
public function cache( array $cache ): CriteriaInterface;
```

Establece las opciones de cache en los criterios Este método reemplaza todas las opciones de cache establecidas previamente

```php
public function conditions( string $conditions ): CriteriaInterface;
```

Añade el parámetro de condiciones a los criterios

```php
public function distinct( mixed $distinct ): CriteriaInterface;
```

Establece la bandera SELECT DISTINCT / SELECT ALL

```php
public function execute(): ResultsetInterface;
```

Ejecuta una búsqueda usando los parámetros construidos con los criterios

```php
public function forUpdate( bool $forUpdate = bool ): CriteriaInterface;
```

Establece el parámetro "for_update" al criterio

```php
public function getColumns(): string | array | null;
```

Devuelve las columnas a ser consultadas

```php
public function getConditions(): string | null;
```

Devuelve el parámetro de condiciones en los criterios

```php
public function getGroupBy();
```

Devuelve la cláusula de grupo en los criterios

```php
public function getHaving();
```

Devuelve la cláusula `having` en los criterios

```php
public function getLimit(): int | array | null;
```

Devuelve el parámetro de límite en los criterios, que será

- Un entero si 'limit' se configuró sin un 'offset'
- Una vector con las claves 'number' y 'offset' si se configuró un desplazamiento con el límite
- NULL si no se ha establecido el límite

```php
public function getModelName(): string;
```

Devuelve un nombre de modelo interno al que se le aplicarán los criterios

```php
public function getOrderBy(): string | null;
```

Devuelve el parámetro orden en los criterios

```php
public function getParams(): array;
```

Devuelve todos los parámetros definidos en los criterios

```php
public function getWhere(): string | null;
```

Devuelve el parámetro de condiciones en los criterios

```php
public function groupBy( mixed $group ): CriteriaInterface;
```

Añade la cláusula group-by a los criterios

```php
public function having( mixed $having ): CriteriaInterface;
```

Añade la cláusula `having` a los criterios

```php
public function inWhere( string $expr, array $values ): CriteriaInterface;
```

Añade una condición IN a las condiciones actuales

```php
$criteria->inWhere("id", [1, 2, 3]);
```

```php
public function innerJoin( string $model, mixed $conditions = null, mixed $alias = null ): CriteriaInterface;
```

Añade un `INNER join` a la consulta

```php
$criteria->innerJoin(
    Robots::class
);

$criteria->innerJoin(
    Robots::class,
    "r.id = RobotsParts.robots_id"
);

$criteria->innerJoin(
    Robots::class,
    "r.id = RobotsParts.robots_id",
    "r"
);
```

```php
public function leftJoin( string $model, mixed $conditions = null, mixed $alias = null ): CriteriaInterface;
```

Añade un `LEFT join` a la consulta

```php
$criteria->leftJoin(
    Robots::class,
    "r.id = RobotsParts.robots_id",
    "r"
);
```

```php
public function limit( int $limit, int $offset = int ): CriteriaInterface;
```

Establece el parámetro límite a los criterios

```php
public function notBetweenWhere( string $expr, mixed $minimum, mixed $maximum ): CriteriaInterface;
```

Añade una condición NOT BETWEEN a las condiciones actuales

```php
$criteria->notBetweenWhere("price", 100.25, 200.50);
```

```php
public function notInWhere( string $expr, array $values ): CriteriaInterface;
```

Añade una condición NOT IN a las condiciones actuales

```php
$criteria->notInWhere("id", [1, 2, 3]);
```

```php
public function orWhere( string $conditions, mixed $bindParams = null, mixed $bindTypes = null ): CriteriaInterface;
```

Añade una condición a las condiciones actuales usando un operador OR

```php
public function orderBy( string $orderColumns ): CriteriaInterface;
```

Añade el parámetro order-by a los criterios

```php
public function rightJoin( string $model, mixed $conditions = null, mixed $alias = null ): CriteriaInterface;
```

Añade un `RIGHT join` a la consulta

```php
$criteria->rightJoin(
    Robots::class,
    "r.id = RobotsParts.robots_id",
    "r"
);
```

```php
public function setModelName( string $modelName ): CriteriaInterface;
```

Establece un modelo en el que se ejecutará la consulta

```php
public function sharedLock( bool $sharedLock = bool ): CriteriaInterface;
```

Establece el parámetro "shared_lock" al criterio

```php
public function where( string $conditions, mixed $bindParams = null, mixed $bindTypes = null ): CriteriaInterface;
```

Establece el parámetro de condiciones en los criterios

<h1 id="mvc-model-exception">Class Phalcon\Mvc\Model\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Exception.zep)

| Namespace | Phalcon\Mvc\Model | | Extends | \Phalcon\Exception |

Phalcon\Mvc\Model\Exception

Las excepciones lanzadas en clases Phalcon\Mvc\Model\* usarán esta clase

<h1 id="mvc-model-manager">Class Phalcon\Mvc\Model\Manager</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Manager.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Phalcon\Db\Adapter\AdapterInterface, Phalcon\Di\DiInterface, Phalcon\Di\InjectionAwareInterface, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface, Phalcon\Mvc\ModelInterface, Phalcon\Mvc\Model\Query\Builder, Phalcon\Mvc\Model\Query\BuilderInterface, Phalcon\Mvc\Model\Query\StatusInterface | | Implements | ManagerInterface, InjectionAwareInterface, EventsAwareInterface |

Phalcon\Mvc\Model\Manager

Este componente controla la inicialización de modelos, manteniendo el registro de relaciones entre los diferentes modelos de la aplicación.

Se inyecta un ModelsManager a un modelo a través de un Inyector de Dependencias/Contenedor de Servicios como Phalcon\Di.

```php
use Phalcon\Di;
use Phalcon\Mvc\Model\Manager as ModelsManager;

$di = new Di();

$di->set(
    "modelsManager",
    function() {
        return new ModelsManager();
    }
);

$robot = new Robots($di);
```

## Propiedades

```php
//
protected aliases;

/**
 * Models' behaviors
 */
protected behaviors;

/**
 * Belongs to relations
 */
protected belongsTo;

/**
 * All the relationships by model
 */
protected belongsToSingle;

//
protected container;

//
protected customEventsManager;

/**
 * Does the model use dynamic update, instead of updating all rows?
 */
protected dynamicUpdate;

//
protected eventsManager;

/**
 * Has many relations
 */
protected hasMany;

/**
 * Has many relations by model
 */
protected hasManySingle;

/**
 * Has many-Through relations
 */
protected hasManyToMany;

/**
 * Has many-Through relations by model
 */
protected hasManyToManySingle;

/**
 * Has one relations
 */
protected hasOne;

/**
 * Has one relations by model
 */
protected hasOneSingle;

/**
 * Has one through relations
 */
protected hasOneThrough;

/**
 * Has one through relations by model
 */
protected hasOneThroughSingle;

/**
 * Mark initialized models
 */
protected initialized;

//
protected keepSnapshots;

/**
 * Last model initialized
 */
protected lastInitialized;

/**
 * Last query created/executed
 */
protected lastQuery;

//
protected modelVisibility;

//
protected prefix = ;

//
protected readConnectionServices;

//
protected sources;

//
protected schemas;

//
protected writeConnectionServices;

/**
 * Stores a list of reusable instances
 */
protected reusable;

```

## Métodos

```php
public function __destruct();
```

Destruye la caché PHQL actual

```php
public function _getConnectionService( ModelInterface $model, mixed $connectionServices ): string;
```

Devuelve el nombre del servicio de conexión usado para leer o escribir datos relacionados con un modelo dependiendo de los servicios de conexión

@todo Remove in v5.0 @deprecated Use getConnectionService()

```php
public function addBehavior( ModelInterface $model, BehaviorInterface $behavior ): void;
```

Enlaza un comportamiento a un modelo

```php
public function addBelongsTo( ModelInterface $model, mixed $fields, string $referencedModel, mixed $referencedFields, mixed $options = null ): RelationInterface;
```

Configura una relación inversa muchos a uno entre dos modelos

```php
public function addHasMany( ModelInterface $model, mixed $fields, string $referencedModel, mixed $referencedFields, mixed $options = null ): RelationInterface;
```

Configura una relación 1-n entre dos modelos

```php
public function addHasManyToMany( ModelInterface $model, mixed $fields, string $intermediateModel, mixed $intermediateFields, mixed $intermediateReferencedFields, string $referencedModel, mixed $referencedFields, mixed $options = null ): RelationInterface;
```

Configura una relación n-m entre dos modelos

```php
public function addHasOne( ModelInterface $model, mixed $fields, string $referencedModel, mixed $referencedFields, mixed $options = null ): RelationInterface;
```

Configura una relación 1-1 entre dos modelos

```php
public function addHasOneThrough( ModelInterface $model, mixed $fields, string $intermediateModel, mixed $intermediateFields, mixed $intermediateReferencedFields, string $referencedModel, mixed $referencedFields, mixed $options = null ): RelationInterface;
```

Configura una relación 1-1 entre dos modelos utilizando un modelo intermedio

```php
public function clearReusableObjects(): void;
```

Limpia la lista reutilizable interna

```php
public function createBuilder( mixed $params = null ): BuilderInterface;
```

Crea un Phalcon\Mvc\Model\Query\Builder

```php
public function createQuery( string $phql ): QueryInterface;
```

Crea un Phalcon\Mvc\Model\Query sin ejecutarlo

```php
public function executeQuery( string $phql, mixed $placeholders = null, mixed $types = null ): mixed;
```

Crea un Phalcon\Mvc\Model\Query y lo ejecuta

```php
$model = new Robots();
$manager = $model->getModelsManager();

// \Phalcon\Mvc\Model\Resultset\Simple
$manager->executeQuery('SELECTFROM Robots');

// \Phalcon\Mvc\Model\Resultset\Complex
$manager->executeQuery('SELECT COUNT(type) FROM Robots GROUP BY type');

// \Phalcon\Mvc\Model\Query\StatusInterface
$manager->executeQuery('INSERT INTO Robots (id) VALUES (1)');

// \Phalcon\Mvc\Model\Query\StatusInterface
$manager->executeQuery('UPDATE Robots SET id = 0 WHERE id = :id:', ['id' => 1]);

// \Phalcon\Mvc\Model\Query\StatusInterface
$manager->executeQuery('DELETE FROM Robots WHERE id = :id:', ['id' => 1]);
```

```php
public function existsBelongsTo( string $modelName, string $modelRelation ): bool;
```

Comprueba si un modelo tiene una relación `belongsTo` con otro modelo

```php
public function existsHasMany( string $modelName, string $modelRelation ): bool;
```

Comprueba si un modelo tiene una relación `hasMany` con otro modelo

```php
public function existsHasManyToMany( string $modelName, string $modelRelation ): bool;
```

Comprueba si un modelo tiene una relación `hasManyToMany` con otro modelo

```php
public function existsHasOne( string $modelName, string $modelRelation ): bool;
```

Comprueba si un modelo tiene una relación `hasOne` con otro modelo

```php
public function existsHasOneThrough( string $modelName, string $modelRelation ): bool;
```

Comprueba si un modelo tiene una relación `hasOneThrough` con otro modelo

```php
public function getBelongsTo( ModelInterface $model ): RelationInterface[] | array;
```

Obtiene todas las relaciones `belongsTo` definidas en un modelo

```php
$relations = $modelsManager->getBelongsTo(
    new Robots()
);
```

```php
public function getBelongsToRecords( string $modelName, string $modelRelation, ModelInterface $record, mixed $parameters = null, string $method = null ): ResultsetInterface | bool;
```

Obtiene los registros `belongsTo` relacionados desde un modelo

```php
public function getConnectionService( ModelInterface $model, mixed $connectionServices ): string;
```

Devuelve el nombre del servicio de conexión usado para leer o escribir datos relacionados con un modelo dependiendo de los servicios de conexión

```php
public function getCustomEventsManager( ModelInterface $model ): EventsManagerInterface | null;
```

Devuelve un gestor de eventos personalizado relacionado con un modelo o nulo si no hay gestor de eventos relacionado

```php
public function getDI(): DiInterface;
```

Devuelve el contenedor DependencyInjector

```php
public function getEventsManager(): EventsManagerInterface;
```

Devuelve el administrador de eventos interno

```php
public function getHasMany( ModelInterface $model ): RelationInterface[] | array;
```

Obtiene las relaciones `hasMany` definidas en un modelo

```php
public function getHasManyRecords( string $modelName, string $modelRelation, ModelInterface $record, mixed $parameters = null, string $method = null ): ResultsetInterface | bool;
```

Obtiene los registros `hasMany` relacionados desde un modelo

```php
public function getHasManyToMany( ModelInterface $model ): RelationInterface[] | array;
```

Obtiene las relaciones `hasManyToMany` definidas en un modelo

```php
public function getHasOne( ModelInterface $model ): array;
```

Obtiene las relaciones `hasOne` definidas en un modelo

```php
public function getHasOneAndHasMany( ModelInterface $model ): RelationInterface[];
```

Obtiene las relaciones `hasOne` definidas en un modelo

```php
public function getHasOneRecords( string $modelName, string $modelRelation, ModelInterface $record, mixed $parameters = null, string $method = null ): ModelInterface | bool;
```

Obtiene los registros `belongsTo` relacionados desde un modelo

```php
public function getHasOneThrough( ModelInterface $model ): RelationInterface[] | array;
```

Obtiene las relaciones `hasOneThrough` definidas en un modelo

```php
public function getLastInitialized(): ModelInterface;
```

Obtiene el último modelo inicializado

```php
public function getLastQuery(): QueryInterface;
```

Devuelve la última consulta creada o ejecutada en el gestor de modelos

```php
public function getModelPrefix(): string;
```

Devuelve el prefijo para todas las fuentes del modelo.

```php
public function getModelSchema( ModelInterface $model ): string;
```

Devuelve el esquema mapeado para un modelo

```php
public function getModelSource( ModelInterface $model ): string;
```

Devuelve la fuente mapeada para un modelo

```php
public function getReadConnection( ModelInterface $model ): AdapterInterface;
```

Devuelve la conexión para leer datos relacionada con un modelo

```php
public function getReadConnectionService( ModelInterface $model ): string;
```

Devuelve el nombre del servicio de conexión usado para leer datos relacionado con un modelo

```php
public function getRelationByAlias( string $modelName, string $alias ): RelationInterface | bool;
```

Devuelve una relación por su alias

```php
public function getRelationRecords( RelationInterface $relation, ModelInterface $record, mixed $parameters = null, string $method = null );
```

Método auxiliar para consultar registros basado en una definición de relación

```php
public function getRelations( string $modelName ): RelationInterface[];
```

Consulta todas las relaciones definidas en un modelo

```php
public function getRelationsBetween( string $first, string $second ): RelationInterface[] | bool;
```

Consulta la primera relación definida entre dos modelos

```php
public function getReusableRecords( string $modelName, string $key );
```

Devuelve un objeto reutilizable de la lista interna

```php
public function getWriteConnection( ModelInterface $model ): AdapterInterface;
```

Devuelve la conexión para escribir datos relacionada con un modelo

```php
public function getWriteConnectionService( ModelInterface $model ): string;
```

Devuelve el nombre del servicio de conexión usado para escribir datos relacionado con un modelo

```php
public function initialize( ModelInterface $model ): bool;
```

Inicializa un modelo en el gestor de modelos

```php
public function isInitialized( string $className ): bool;
```

Comprueba si un modelo está ya inicializado

```php
public function isKeepingSnapshots( ModelInterface $model ): bool;
```

Comprueba si un modelo mantiene instantáneas para los registros consultados

```php
public function isUsingDynamicUpdate( ModelInterface $model ): bool;
```

Comprueba si un modelo está usando una actualización dinámica en lugar de una actualización de todos los campos

```php
final public function isVisibleModelProperty( ModelInterface $model, string $property ): bool;
```

Compruebe si una propiedad de modelo está declarada como pública.

```php
$isPublic = $manager->isVisibleModelProperty(
    new Robots(),
    "name"
);
```

```php
public function keepSnapshots( ModelInterface $model, bool $keepSnapshots ): void;
```

Establece si un modelo debe mantener instantáneas

```php
public function load( string $modelName ): ModelInterface;
```

Carga un modelo lanzando una excepción si no existe

```php
public function missingMethod( ModelInterface $model, string $eventName, mixed $data );
```

Envía un evento a los oyentes y a los comportamientos. Este método espera que los oyentes/comportamientos del punto de conexión devuelvan true, lo que significa que al menos uno fue implementado

```php
public function notifyEvent( string $eventName, ModelInterface $model );
```

Recibe eventos generados en los modelos y los envía a un gestor de eventos si está disponible. Notifica los comportamientos que están escuchando en el modelo

```php
public function setConnectionService( ModelInterface $model, string $connectionService ): void;
```

Establece el servicio de conexión de escritura y lectura para un modelo

```php
public function setCustomEventsManager( ModelInterface $model, EventsManagerInterface $eventsManager ): void;
```

Establece un gestor de eventos personalizado para un modelo específico

```php
public function setDI( DiInterface $container ): void;
```

Configura el contenedor DependencyInjector

```php
public function setEventsManager( EventsManagerInterface $eventsManager ): void;
```

Establece un gestor de eventos global

```php
public function setModelPrefix( string $prefix ): void;
```

Establece el prefijo para todas las fuentes de modelo.

```php
use Phalcon\Mvc\Model\Manager;

$di->set(
    "modelsManager",
    function () {
        $modelsManager = new Manager();

        $modelsManager->setModelPrefix("wp_");

        return $modelsManager;
    }
);

$robots = new Robots();

echo $robots->getSource(); // wp_robots
```

```php
public function setModelSchema( ModelInterface $model, string $schema ): void;
```

Establece el esquema mapeado para un modelo

```php
public function setModelSource( ModelInterface $model, string $source ): void;
```

Establece la fuente mapeada para un modelo

```php
public function setReadConnectionService( ModelInterface $model, string $connectionService ): void;
```

Establece el servicio de conexión de lectura para un modelo

```php
public function setReusableRecords( string $modelName, string $key, mixed $records ): void;
```

Almacena un registro reutilizable en la lista interna

```php
public function setWriteConnectionService( ModelInterface $model, string $connectionService ): void;
```

Establece el servicio de conexión de escritura para un modelo

```php
public function useDynamicUpdate( ModelInterface $model, bool $dynamicUpdate ): void;
```

Establece si el modelo debe usar actualización dinámica en vez de actualizar todos los campos

```php
protected function _getConnection( ModelInterface $model, mixed $connectionServices ): AdapterInterface;
```

Devuelve la conexión para leer o escribir datos relacionados con un modelo dependiendo de los servicios de conexión.

@todo Remove in v5.0 @deprecated Use getConnection()

```php
final protected function _mergeFindParameters( mixed $findParamsOne, mixed $findParamsTwo ): array;
```

Une dos vectores de parámetros de búsqueda

```php
protected function getConnection( ModelInterface $model, mixed $connectionServices ): AdapterInterface;
```

Devuelve la conexión para leer o escribir datos relacionados con un modelo dependiendo de los servicios de conexión.

<h1 id="mvc-model-managerinterface">Interface Phalcon\Mvc\Model\ManagerInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/ManagerInterface.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Phalcon\Db\Adapter\AdapterInterface, Phalcon\Mvc\ModelInterface, Phalcon\Mvc\Model\Query\BuilderInterface, Phalcon\Mvc\Model\Query\StatusInterface |

Phalcon\Mvc\Model\ManagerInterface

Interfaz para Phalcon\Mvc\Model\Manager

## Métodos

```php
public function addBehavior( ModelInterface $model, BehaviorInterface $behavior ): void;
```

Enlaza un comportamiento a un modelo

```php
public function addBelongsTo( ModelInterface $model, mixed $fields, string $referencedModel, mixed $referencedFields, mixed $options = null ): RelationInterface;
```

Configura una relación 1-1 entre dos modelos

```php
public function addHasMany( ModelInterface $model, mixed $fields, string $referencedModel, mixed $referencedFields, mixed $options = null ): RelationInterface;
```

Configura una relación 1-n entre dos modelos

```php
public function addHasManyToMany( ModelInterface $model, mixed $fields, string $intermediateModel, mixed $intermediateFields, mixed $intermediateReferencedFields, string $referencedModel, mixed $referencedFields, mixed $options = null ): RelationInterface;
```

Configura una relación n-m entre dos modelos

```php
public function addHasOne( ModelInterface $model, mixed $fields, string $referencedModel, mixed $referencedFields, mixed $options = null ): RelationInterface;
```

Configura una relación 1-1 entre dos modelos

```php
public function addHasOneThrough( ModelInterface $model, mixed $fields, string $intermediateModel, mixed $intermediateFields, mixed $intermediateReferencedFields, string $referencedModel, mixed $referencedFields, mixed $options = null ): RelationInterface;
```

Configura una relación 1-1 entre dos modelos utilizando una tabla intermedia

```php
public function createBuilder( mixed $params = null ): BuilderInterface;
```

Crea un Phalcon\Mvc\Model\Query\Builder

```php
public function createQuery( string $phql ): QueryInterface;
```

Crea un Phalcon\Mvc\Model\Query sin ejecutarlo

```php
public function executeQuery( string $phql, mixed $placeholders = null, mixed $types = null ): mixed;
```

Crea un Phalcon\Mvc\Model\Query y lo ejecuta

```php
public function existsBelongsTo( string $modelName, string $modelRelation ): bool;
```

Comprueba si un modelo tiene una relación `belongsTo` con otro modelo

```php
public function existsHasMany( string $modelName, string $modelRelation ): bool;
```

Comprueba si un modelo tiene una relación `hasMany` con otro modelo

```php
public function existsHasManyToMany( string $modelName, string $modelRelation ): bool;
```

Comprueba si un modelo tiene una relación `hasManyToMany` con otro modelo

```php
public function existsHasOne( string $modelName, string $modelRelation ): bool;
```

Comprueba si un modelo tiene una relación `hasOne` con otro modelo

```php
public function existsHasOneThrough( string $modelName, string $modelRelation ): bool;
```

Comprueba si un modelo tiene una relación `hasOneThrough` con otro modelo

```php
public function getBelongsTo( ModelInterface $model ): RelationInterface[] | array;
```

Obtiene las relaciones `belongsTo` definidas en un modelo

```php
public function getBelongsToRecords( string $modelName, string $modelRelation, ModelInterface $record, mixed $parameters = null, string $method = null ): ResultsetInterface | bool;
```

Obtiene los registros `belongsTo` relacionados desde un modelo

```php
public function getHasMany( ModelInterface $model ): RelationInterface[] | array;
```

Obtiene las relaciones `hasMany` definidas en un modelo

```php
public function getHasManyRecords( string $modelName, string $modelRelation, ModelInterface $record, mixed $parameters = null, string $method = null ): ResultsetInterface | bool;
```

Obtiene los registros `hasMany` relacionados desde un modelo

```php
public function getHasManyToMany( ModelInterface $model ): RelationInterface[] | array;
```

Obtiene las relaciones `hasManyToMany` definidas en un modelo

```php
public function getHasOne( ModelInterface $model ): RelationInterface[] | array;
```

Obtiene las relaciones `hasOne` definidas en un modelo

```php
public function getHasOneAndHasMany( ModelInterface $model ): RelationInterface[];
```

Obtiene las relaciones `hasOne` definidas en un modelo

```php
public function getHasOneRecords( string $modelName, string $modelRelation, ModelInterface $record, mixed $parameters = null, string $method = null ): ModelInterface | bool;
```

Obtiene los registros `hasOne` relacionados desde un modelo

```php
public function getHasOneThrough( ModelInterface $model ): RelationInterface[] | array;
```

Obtiene las relaciones `hasOneThrough` definidas en un modelo

```php
public function getLastInitialized(): ModelInterface;
```

Obtiene el último modelo inicializado

```php
public function getLastQuery(): QueryInterface;
```

Devuelve la última consulta creada o ejecutada en el gestor de modelos

```php
public function getModelSchema( ModelInterface $model ): string;
```

Devuelve el esquema mapeado para un modelo

```php
public function getModelSource( ModelInterface $model ): string;
```

Devuelve la fuente mapeada para un modelo

```php
public function getReadConnection( ModelInterface $model ): AdapterInterface;
```

Devuelve la conexión para leer datos relacionada con un modelo

```php
public function getReadConnectionService( ModelInterface $model ): string;
```

Devuelve el nombre del servicio de conexión usado para leer datos relacionado con un modelo

```php
public function getRelationByAlias( string $modelName, string $alias ): Relation | bool;
```

Devuelve una relación por su alias

```php
public function getRelationRecords( RelationInterface $relation, ModelInterface $record, mixed $parameters = null, string $method = null );
```

Método auxiliar para consultar registros basado en una definición de relación

```php
public function getRelations( string $modelName ): RelationInterface[];
```

Consulta todas las relaciones definidas en un modelo

```php
public function getRelationsBetween( string $first, string $second ): RelationInterface[] | bool;
```

Consulta las relaciones entre dos modelos

```php
public function getWriteConnection( ModelInterface $model ): AdapterInterface;
```

Devuelve la conexión para escribir datos relacionada con un modelo

```php
public function getWriteConnectionService( ModelInterface $model ): string;
```

Devuelve el nombre del servicio de conexión usado para escribir datos relacionado con un modelo

```php
public function initialize( ModelInterface $model );
```

Inicializa un modelo en el gestor de modelos

```php
public function isInitialized( string $className ): bool;
```

Comprueba si un modelo está ya inicializado

```php
public function isKeepingSnapshots( ModelInterface $model ): bool;
```

Comprueba si un modelo mantiene instantáneas para los registros consultados

```php
public function isUsingDynamicUpdate( ModelInterface $model ): bool;
```

Comprueba si un modelo está usando una actualización dinámica en lugar de una actualización de todos los campos

```php
public function isVisibleModelProperty( ModelInterface $model, string $property ): bool;
```

Compruebe si una propiedad de modelo está declarada como pública.

```php
$isPublic = $manager->isVisibleModelProperty(
    new Robots(),
    "name"
);
```

```php
public function keepSnapshots( ModelInterface $model, bool $keepSnapshots ): void;
```

Establece si un modelo debe mantener instantáneas

```php
public function load( string $modelName ): ModelInterface;
```

Carga un modelo lanzando una excepción si no existe

```php
public function missingMethod( ModelInterface $model, string $eventName, mixed $data );
```

Envía un evento a los oyentes y a los comportamientos. Este método espera que los oyentes/comportamientos del punto de conexión devuelvan true, lo que significa que al menos uno fue implementado

```php
public function notifyEvent( string $eventName, ModelInterface $model );
```

Recibe los eventos generados en los modelos y los envía al gestor de eventos si está disponible. Notifica los comportamientos que están escuchando en el modelo

```php
public function setConnectionService( ModelInterface $model, string $connectionService ): void;
```

Establece el servicio de conexión de escritura y lectura para un modelo

```php
public function setModelSchema( ModelInterface $model, string $schema ): void;
```

Establece el esquema mapeado para un modelo

```php
public function setModelSource( ModelInterface $model, string $source ): void;
```

Establece la fuente mapeada para un modelo

```php
public function setReadConnectionService( ModelInterface $model, string $connectionService ): void;
```

Establece el servicio de conexión de lectura para un modelo

```php
public function setWriteConnectionService( ModelInterface $model, string $connectionService );
```

Establece el servicio de conexión de escritura para un modelo

```php
public function useDynamicUpdate( ModelInterface $model, bool $dynamicUpdate ): void;
```

Establece si el modelo debe usar actualización dinámica en vez de actualizar todos los campos

<h1 id="mvc-model-metadata">Abstract Class Phalcon\Mvc\Model\MetaData</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/MetaData.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Di\DiInterface, Phalcon\Di\InjectionAwareInterface, Phalcon\Mvc\Model\MetaData\Strategy\Introspection, Phalcon\Mvc\Model\MetaData\Strategy\StrategyInterface, Phalcon\Mvc\ModelInterface | | Implements | InjectionAwareInterface, MetaDataInterface |

Phalcon\Mvc\Model\MetaData

Porque Phalcon\Mvc\Model requiere meta-datos como nombres de campos, tipos de datos, claves primarias, etc. Este componente los recoge y almacena para consultas posteriores de Phalcon\Mvc\Model. Phalcon\Mvc\Model\MetaData también puede utilizar adaptadores para almacenar temporal o permanentemente los meta-datos.

Se puede usar un Phalcon\Mvc\Model\MetaData estándar para consultar los atributos del modelo:

```php
$metaData = new \Phalcon\Mvc\Model\MetaData\Memory();

$attributes = $metaData->getAttributes(
    new Robots()
);

print_r($attributes);
```

## Constantes

```php
const MODELS_ATTRIBUTES = 0;
const MODELS_AUTOMATIC_DEFAULT_INSERT = 10;
const MODELS_AUTOMATIC_DEFAULT_UPDATE = 11;
const MODELS_COLUMN_MAP = 0;
const MODELS_DATA_TYPES = 4;
const MODELS_DATA_TYPES_BIND = 9;
const MODELS_DATA_TYPES_NUMERIC = 5;
const MODELS_DATE_AT = 6;
const MODELS_DATE_IN = 7;
const MODELS_DEFAULT_VALUES = 12;
const MODELS_EMPTY_STRING_VALUES = 13;
const MODELS_IDENTITY_COLUMN = 8;
const MODELS_NON_PRIMARY_KEY = 2;
const MODELS_NOT_NULL = 3;
const MODELS_PRIMARY_KEY = 1;
const MODELS_REVERSE_COLUMN_MAP = 1;
```

## Propiedades

```php
/**
 * @var CacheAdapterInterface
 */
protected adapter;

//
protected columnMap;

//
protected container;

//
protected metaData;

//
protected strategy;

```

## Métodos

```php
public function getAttributes( ModelInterface $model ): array;
```

Devuelve los nombres de los atributos de la tabla (campos)

```php
print_r(
    $metaData->getAttributes(
        new Robots()
    )
);
```

```php
public function getAutomaticCreateAttributes( ModelInterface $model ): array;
```

Devuelve los atributos que se deben ignorar en la generación del SQL INSERT

```php
print_r(
    $metaData->getAutomaticCreateAttributes(
        new Robots()
    )
);
```

```php
public function getAutomaticUpdateAttributes( ModelInterface $model ): array;
```

Devuelve los atributos que se deben ignorar de la generación del SQL UPDATE

```php
print_r(
    $metaData->getAutomaticUpdateAttributes(
        new Robots()
    )
);
```

```php
public function getBindTypes( ModelInterface $model ): array;
```

Devuelve los atributos y sus tipos de datos de enlace

```php
print_r(
    $metaData->getBindTypes(
        new Robots()
    )
);
```

```php
public function getColumnMap( ModelInterface $model ): array | null;
```

Devuelve el mapa de columnas si lo hay

```php
print_r(
    $metaData->getColumnMap(
        new Robots()
    )
);
```

```php
public function getDI(): DiInterface;
```

Devuelve el contenedor DependencyInjector

```php
public function getDataTypes( ModelInterface $model ): array;
```

Devuelve los atributos y sus tipos de datos

```php
print_r(
    $metaData->getDataTypes(
        new Robots()
    )
);
```

```php
public function getDataTypesNumeric( ModelInterface $model ): array;
```

Devuelve los atributos con tipos numéricos

```php
print_r(
    $metaData->getDataTypesNumeric(
        new Robots()
    )
);
```

```php
public function getDefaultValues( ModelInterface $model ): array;
```

Devuelve los atributos (que tienen valores por defecto) y sus valores por defecto

```php
print_r(
    $metaData->getDefaultValues(
        new Robots()
    )
);
```

```php
public function getEmptyStringAttributes( ModelInterface $model ): array;
```

Devuelve atributos que permiten cadenas vacías

```php
print_r(
    $metaData->getEmptyStringAttributes(
        new Robots()
    )
);
```

```php
public function getIdentityField( ModelInterface $model ): string | null;
```

Devuelve el nombre del campo identidad (si hay uno presente)

```php
print_r(
    $metaData->getIdentityField(
        new Robots()
    )
);
```

```php
public function getNonPrimaryKeyAttributes( ModelInterface $model ): array;
```

Devuelve un vector de campos que no forman parte de la clave primaria

```php
print_r(
    $metaData->getNonPrimaryKeyAttributes(
        new Robots()
    )
);
```

```php
public function getNotNullAttributes( ModelInterface $model ): array;
```

Devuelve un vector de atributos no nulos

```php
print_r(
    $metaData->getNotNullAttributes(
        new Robots()
    )
);
```

```php
public function getPrimaryKeyAttributes( ModelInterface $model ): array;
```

Devuelve un vector de campos que forman parte de la clave primaria

```php
print_r(
    $metaData->getPrimaryKeyAttributes(
        new Robots()
    )
);
```

```php
public function getReverseColumnMap( ModelInterface $model ): array | null;
```

Devuelve el mapa de columnas inverso si existe

```php
print_r(
    $metaData->getReverseColumnMap(
        new Robots()
    )
);
```

```php
public function getStrategy(): StrategyInterface;
```

Devuelve la estrategia para obtener los metadatos

```php
public function hasAttribute( ModelInterface $model, string $attribute ): bool;
```

Comprueba si un modelo tiene cierto atributo

```php
var_dump(
    $metaData->hasAttribute(
        new Robots(),
        "name"
    )
);
```

```php
public function isEmpty(): bool;
```

Comprueba si el contenedor de metadatos interno está vacío

```php
var_dump(
    $metaData->isEmpty()
);
```

```php
public function read( string $key ): array | null;
```

Lee los metadatos del adaptador

```php
final public function readColumnMap( ModelInterface $model ): array | null;
```

Lee el mapa de columnas ordenado/inverso para cierto modelo

```php
print_r(
    $metaData->readColumnMap(
        new Robots()
    )
);
```

```php
final public function readColumnMapIndex( ModelInterface $model, int $index );
```

Lee información del mapa de columnas para cierto modelo usando una constante MODEL_*

```php
print_r(
    $metaData->readColumnMapIndex(
        new Robots(),
        MetaData::MODELS_REVERSE_COLUMN_MAP
    )
);
```

```php
final public function readMetaData( ModelInterface $model ): array;
```

Lee los metadatos completos para cierto modelo

```php
print_r(
    $metaData->readMetaData(
        new Robots()
    )
);
```

```php
final public function readMetaDataIndex( ModelInterface $model, int $index );
```

Lee los metadatos para cierto modelo

```php
print_r(
    $metaData->readMetaDataIndex(
        new Robots(),
        0
    )
);
```

```php
public function reset(): void;
```

Resetea los metadatos internos para regenerarlos

```php
$metaData->reset();
```

```php
public function setAutomaticCreateAttributes( ModelInterface $model, array $attributes ): void;
```

Establece los atributos que se deben ignorar en la generación SQL del `INSERT`

```php
$metaData->setAutomaticCreateAttributes(
    new Robots(),
    [
        "created_at" => true,
    ]
);
```

```php
public function setAutomaticUpdateAttributes( ModelInterface $model, array $attributes ): void;
```

Establece los atributos que se deben ignorar en la generación SQL del `UPDATE`

```php
$metaData->setAutomaticUpdateAttributes(
    new Robots(),
    [
        "modified_at" => true,
    ]
);
```

```php
public function setDI( DiInterface $container ): void;
```

Configura el contenedor DependencyInjector

```php
public function setEmptyStringAttributes( ModelInterface $model, array $attributes ): void;
```

Establece los atributos que permiten valores de cadena vacía

```php
$metaData->setEmptyStringAttributes(
    new Robots(),
    [
        "name" => true,
    ]
);
```

```php
public function setStrategy( StrategyInterface $strategy ): void;
```

Establece la estrategia de extracción de metadatos

```php
public function write( string $key, array $data ): void;
```

Escribe los metadatos al adaptador

```php
final public function writeMetaDataIndex( ModelInterface $model, int $index, mixed $data ): void;
```

Escribe metadatos para cierto modelo usando una constante `MODEL_*`

```php
print_r(
    $metaData->writeColumnMapIndex(
        new Robots(),
        MetaData::MODELS_REVERSE_COLUMN_MAP,
        [
            "leName" => "name",
        ]
    )
);
```

```php
final protected function initialize( ModelInterface $model, mixed $key, mixed $table, mixed $schema );
```

Inicializa los metadatos para cierta tabla

<h1 id="mvc-model-metadata-apcu">Class Phalcon\Mvc\Model\MetaData\Apcu</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/MetaData/Apcu.zep)

| Namespace | Phalcon\Mvc\Model\MetaData | | Uses | Phalcon\Helper\Arr, Phalcon\Mvc\Model\MetaData, Phalcon\Mvc\Model\Exception, Phalcon\Cache\AdapterFactory | | Extends | MetaData |

Phalcon\Mvc\Model\MetaData\Apcu

Almacena los meta-datos del modelo en la caché APCu. Los datos serán borrados si se reinicia el servidor web

Por defecto los meta-datos se almacenan durante 48 horas (172800 segundos)

Puede consultar los meta-datos imprimiendo apcu_fetch('$PMM$') o apcu_fetch('$PMM$my-app-id')

```php
$metaData = new \Phalcon\Mvc\Model\MetaData\Apcu(
    [
        "prefix"   => "my-app-id",
        "lifetime" => 86400,
    ]
);
```

## Métodos

```php
public function __construct( AdapterFactory $factory, array $options = null );
```

Constructor Phalcon\Mvc\Model\MetaData\Apcu

<h1 id="mvc-model-metadata-libmemcached">Class Phalcon\Mvc\Model\MetaData\Libmemcached</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/MetaData/Libmemcached.zep)

| Namespace | Phalcon\Mvc\Model\MetaData | | Uses | Phalcon\Helper\Arr, Phalcon\Mvc\Model\Exception, Phalcon\Mvc\Model\MetaData, Phalcon\Cache\AdapterFactory | | Extends | MetaData |

Phalcon\Mvc\Model\MetaData\Libmemcached

Almacena los meta-datos del modelo en la Memcache.

Por defecto los meta-datos se almacenan durante 48 horas (172800 segundos)

## Métodos

```php
public function __construct( AdapterFactory $factory, array $options = [] );
```

Constructor Phalcon\Mvc\Model\MetaData\Libmemcached

```php
public function reset(): void;
```

Vacía los datos de Memcache y reinicia los meta-datos internos para regenerarlos

<h1 id="mvc-model-metadata-memory">Class Phalcon\Mvc\Model\MetaData\Memory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/MetaData/Memory.zep)

| Namespace | Phalcon\Mvc\Model\MetaData | | Uses | Phalcon\Mvc\Model\MetaData, Phalcon\Mvc\Model\Exception | | Extends | MetaData |

Phalcon\Mvc\Model\MetaData\Memory

Almacena los meta-datos del modelo en memoria. Los datos serán borrados cuando la petición finalice

## Métodos

```php
public function __construct( mixed $options = null );
```

Constructor Phalcon\Mvc\Model\MetaData\Memory

```php
public function read( string $key ): array | null;
```

Lee los meta-datos de la memoria temporal

```php
public function write( string $key, array $data ): void;
```

Escribe los meta-datos en la memoria temporal

<h1 id="mvc-model-metadata-redis">Class Phalcon\Mvc\Model\MetaData\Redis</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/MetaData/Redis.zep)

| Namespace | Phalcon\Mvc\Model\MetaData | | Uses | Phalcon\Helper\Arr, Phalcon\Mvc\Model\MetaData, Phalcon\Cache\AdapterFactory | | Extends | MetaData |

Phalcon\Mvc\Model\MetaData\Redis

Almacena los meta-datos del modelo en el Redis.

Por defecto los meta-datos se almacenan durante 48 horas (172800 segundos)

```php
use Phalcon\Mvc\Model\MetaData\Redis;

$metaData = new Redis(
    [
        "host"       => "127.0.0.1",
        "port"       => 6379,
        "persistent" => 0,
        "lifetime"   => 172800,
        "index"      => 2,
    ]
);
```

## Métodos

```php
public function __construct( AdapterFactory $factory, array $options = [] );
```

Constructor Phalcon\Mvc\Model\MetaData\Redis

```php
public function reset(): void;
```

Vacía los datos Redis y reinicia los meta-datos internos para regenerarlos

<h1 id="mvc-model-metadata-strategy-annotations">Class Phalcon\Mvc\Model\MetaData\Strategy\Annotations</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/MetaData/Strategy/Annotations.zep)

| Namespace | Phalcon\Mvc\Model\MetaData\Strategy | | Uses | Phalcon\Di\DiInterface, Phalcon\Db\Column, Phalcon\Mvc\ModelInterface, Phalcon\Mvc\Model\MetaData, Phalcon\Mvc\Model\Exception | | Implements | StrategyInterface |

Este fichero es parte del *Framework* Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Métodos

```php
final public function getColumnMaps( ModelInterface $model, DiInterface $container ): array;
```

Lee el mapa de columnas del modelo, esto no se puede inferir

```php
final public function getMetaData( ModelInterface $model, DiInterface $container ): array;
```

Los meta-datos se obtienen leyendo las descripciones de columna del esquema de información de la base de datos

<h1 id="mvc-model-metadata-strategy-introspection">Class Phalcon\Mvc\Model\MetaData\Strategy\Introspection</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/MetaData/Strategy/Introspection.zep)

| Namespace | Phalcon\Mvc\Model\MetaData\Strategy | | Uses | Phalcon\Di\DiInterface, Phalcon\Db\Adapter\AdapterInterface, Phalcon\Db\Column, Phalcon\Mvc\ModelInterface, Phalcon\Mvc\Model\Exception, Phalcon\Mvc\Model\MetaData | | Implements | StrategyInterface |

Phalcon\Mvc\Model\MetaData\Strategy\Introspection

Consulta los meta-datos de la tabla para realizar una introspección de los metadatos del modelo

## Métodos

```php
final public function getColumnMaps( ModelInterface $model, DiInterface $container ): array;
```

Lee el mapa de columnas del modelo, esto no se puede inferir

```php
final public function getMetaData( ModelInterface $model, DiInterface $container ): array;
```

Los meta-datos se obtienen leyendo las descripciones de columna del esquema de información de la base de datos

<h1 id="mvc-model-metadata-strategy-strategyinterface">Interface Phalcon\Mvc\Model\MetaData\Strategy\StrategyInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/MetaData/Strategy/StrategyInterface.zep)

| Namespace | Phalcon\Mvc\Model\MetaData\Strategy | | Uses | Phalcon\Mvc\ModelInterface, Phalcon\Di\DiInterface |

Este fichero es parte del *Framework* Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Métodos

```php
public function getColumnMaps( ModelInterface $model, DiInterface $container ): array;
```

Lee el mapa de columnas del modelo, esto no se puede inferir

@todo Not implemented

```php
public function getMetaData( ModelInterface $model, DiInterface $container ): array;
```

Los meta-datos se obtienen leyendo las descripciones de columna del esquema de información de la base de datos

<h1 id="mvc-model-metadata-stream">Class Phalcon\Mvc\Model\MetaData\Stream</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/MetaData/Stream.zep)

| Namespace | Phalcon\Mvc\Model\MetaData | | Uses | Phalcon\Mvc\Model\MetaData, Phalcon\Mvc\Model\Exception | | Extends | MetaData |

Phalcon\Mvc\Model\MetaData\Stream

Almacena los meta-datos del modelo en archivos PHP.

```php
$metaData = new \Phalcon\Mvc\Model\MetaData\Files(
    [
        "metaDataDir" => "app/cache/metadata/",
    ]
);
```

## Propiedades

```php
//
protected metaDataDir = ./;

```

## Métodos

```php
public function __construct( mixed $options = null );
```

Constructor Phalcon\Mvc\Model\MetaData\Files

```php
public function read( string $key ): array | null;
```

Lee meta-datos de archivos

```php
public function write( string $key, array $data ): void;
```

Escribe los meta-datos en archivos

<h1 id="mvc-model-metadatainterface">Interface Phalcon\Mvc\Model\MetaDataInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/MetaDataInterface.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Phalcon\Mvc\ModelInterface, Phalcon\Mvc\Model\MetaData\Strategy\StrategyInterface |

Phalcon\Mvc\Model\MetaDataInterface

Interfaz para Phalcon\Mvc\Model\MetaData

## Métodos

```php
public function getAttributes( ModelInterface $model ): array;
```

Devuelve los nombres de los atributos de la tabla (campos)

```php
public function getAutomaticCreateAttributes( ModelInterface $model ): array;
```

Devuelve los atributos que se deben ignorar en la generación del SQL INSERT

```php
public function getAutomaticUpdateAttributes( ModelInterface $model ): array;
```

Devuelve los atributos que se deben ignorar de la generación del SQL UPDATE

```php
public function getBindTypes( ModelInterface $model ): array;
```

Devuelve los atributos y sus tipos de datos de enlace

```php
public function getColumnMap( ModelInterface $model ): array | null;
```

Devuelve el mapa de columnas si lo hay

```php
public function getDataTypes( ModelInterface $model ): array;
```

Devuelve los atributos y sus tipos de datos

```php
public function getDataTypesNumeric( ModelInterface $model ): array;
```

Devuelve los atributos con tipos numéricos

```php
public function getDefaultValues( ModelInterface $model ): array;
```

Devuelve los atributos (que tienen valores por defecto) y sus valores por defecto

```php
public function getEmptyStringAttributes( ModelInterface $model ): array;
```

Devuelve atributos que permiten cadenas vacías

```php
public function getIdentityField( ModelInterface $model ): string | null;
```

Devuelve el nombre del campo identidad (si hay uno presente)

```php
public function getNonPrimaryKeyAttributes( ModelInterface $model ): array;
```

Devuelve un vector de campos que no forman parte de la clave primaria

```php
public function getNotNullAttributes( ModelInterface $model ): array;
```

Devuelve un vector de atributos no nulos

```php
public function getPrimaryKeyAttributes( ModelInterface $model ): array;
```

Devuelve un vector de campos que forman parte de la clave primaria

```php
public function getReverseColumnMap( ModelInterface $model ): array | null;
```

Devuelve el mapa de columnas inverso si existe

```php
public function getStrategy(): StrategyInterface;
```

Devuelve la estrategia para obtener los metadatos

```php
public function hasAttribute( ModelInterface $model, string $attribute ): bool;
```

Comprueba si un modelo tiene cierto atributo

```php
public function isEmpty(): bool;
```

Comprueba si el contenedor de metadatos interno está vacío

```php
public function read( string $key ): array | null;
```

Lee meta-datos del adaptador

```php
public function readColumnMap( ModelInterface $model ): array | null;
```

Lee el mapa de columnas ordenado/inverso para cierto modelo

```php
public function readColumnMapIndex( ModelInterface $model, int $index );
```

Lee información del mapa de columnas para cierto modelo usando una constante MODEL_*

```php
public function readMetaData( ModelInterface $model ): array;
```

Lee los metadatos para cierto modelo

```php
public function readMetaDataIndex( ModelInterface $model, int $index ): mixed;
```

Lee meta-datos para ciertos modelos usando una constante MODEL_*

```php
public function reset();
```

Resetea los metadatos internos para regenerarlos

```php
public function setAutomaticCreateAttributes( ModelInterface $model, array $attributes );
```

Establece los atributos que se deben ignorar en la generación SQL del `INSERT`

```php
public function setAutomaticUpdateAttributes( ModelInterface $model, array $attributes );
```

Establece los atributos que se deben ignorar en la generación SQL del `UPDATE`

```php
public function setEmptyStringAttributes( ModelInterface $model, array $attributes ): void;
```

Establece los atributos que permiten valores de cadena vacía

```php
public function setStrategy( StrategyInterface $strategy );
```

Establece la estrategia de extracción de metadatos

```php
public function write( string $key, array $data ): void;
```

Escribe meta-datos en el adaptador

```php
public function writeMetaDataIndex( ModelInterface $model, int $index, mixed $data );
```

Escribe metadatos para cierto modelo usando una constante `MODEL_*`

<h1 id="mvc-model-query">Class Phalcon\Mvc\Model\Query</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Query.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Phalcon\Db\Column, Phalcon\Db\RawValue, Phalcon\Db\ResultInterface, Phalcon\Db\Adapter\AdapterInterface, Phalcon\Di\DiInterface, Phalcon\Helper\Arr, Phalcon\Mvc\ModelInterface, Phalcon\Mvc\Model\Query\Status, Phalcon\Mvc\Model\Resultset\Complex, Phalcon\Mvc\Model\Query\StatusInterface, Phalcon\Mvc\Model\ResultsetInterface, Phalcon\Mvc\Model\Resultset\Simple, Phalcon\Di\InjectionAwareInterface, Phalcon\Db\DialectInterface, Phalcon\Mvc\Model\Query\Lang | | Implements | QueryInterface, InjectionAwareInterface |

Phalcon\Mvc\Model\Query

Esta clase coge una representación intermedia PHQL y la ejecuta.

```php
$phql = "SELECT c.price*0.16 AS taxes, c.* FROM Cars AS c JOIN Brands AS b
         WHERE b.name = :name: ORDER BY c.name";

$result = $manager->executeQuery(
    $phql,
    [
        "name" => "Lamborghini",
    ]
);

foreach ($result as $row) {
    echo "Name: ",  $row->cars->name, "\n";
    echo "Price: ", $row->cars->price, "\n";
    echo "Taxes: ", $row->taxes, "\n";
}

// with transaction
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\Model\Transaction;

// $di needs to have the service "db" registered for this to work
$di = Phalcon\Di\FactoryDefault::getDefault();

$phql = 'SELECTFROM robot';

$myTransaction = new Transaction($di);
$myTransaction->begin();

$newRobot = new Robot();
$newRobot->setTransaction($myTransaction);
$newRobot->type = "mechanical";
$newRobot->name = "Astro Boy";
$newRobot->year = 1952;
$newRobot->save();

$queryWithTransaction = new Query($phql, $di);
$queryWithTransaction->setTransaction($myTransaction);

$resultWithEntries = $queryWithTransaction->execute();

$queryWithOutTransaction = new Query($phql, $di);
$resultWithOutEntries = $queryWithTransaction->execute();
```

## Constantes

```php
const TYPE_DELETE = 303;
const TYPE_INSERT = 306;
const TYPE_SELECT = 309;
const TYPE_UPDATE = 300;
```

## Propiedades

```php
//
protected ast;

//
protected bindParams;

//
protected bindTypes;

//
protected cache;

//
protected cacheOptions;

//
protected container;

//
protected enableImplicitJoins;

//
protected intermediate;

//
protected manager;

//
protected metaData;

//
protected models;

//
protected modelsInstances;

//
protected nestingLevel = -1;

//
protected phql;

//
protected sharedLock;

//
protected sqlAliases;

//
protected sqlAliasesModels;

//
protected sqlAliasesModelsInstances;

//
protected sqlColumnAliases;

//
protected sqlModelsAliases;

//
protected type;

//
protected uniqueRow;

//
static protected _irPhqlCache;

/**
 * TransactionInterface so that the query can wrap a transaction
 * around batch updates and intermediate selects within the transaction.
 * however if a model got a transaction set inside it will use the local
 * transaction instead of this one
 */
protected _transaction;

```

## Métodos

```php
public function __construct( string $phql = null, DiInterface $container = null, array $options = [] );
```

Constructor Phalcon\Mvc\Model\Query

```php
public function cache( array $cacheOptions ): QueryInterface;
```

Establece los parámetros del caché de la consulta

```php
public static function clean(): void;
```

Destruye el caché PHQL interno

```php
public function execute( array $bindParams = [], array $bindTypes = [] );
```

Ejecuta una sentencia PHQL analizada

```php
public function getBindParams(): array;
```

Devuelve parámetros de enlace por defecto

```php
public function getBindTypes(): array;
```

Devuelve tipos de enlace por defecto

```php
public function getCache(): AdapterInterface;
```

Devuelve la instancia de backend de caché actual

```php
public function getCacheOptions(): array;
```

Devuelve las opciones actuales de caché

```php
public function getDI(): DiInterface;
```

Devuelve el contenedor de inyección de dependencias

```php
public function getIntermediate(): array;
```

Devuelve la representación intermedia de la sentencia PHQL

```php
public function getSingleResult( array $bindParams = [], array $bindTypes = [] ): ModelInterface;
```

Ejecuta la consulta devolviendo el primer resultado

```php
public function getSql(): array;
```

Devuelve el SQL a ser generado por el PHQL interno (solo funciona en sentencias SELECT)

```php
public function getType(): int;
```

Obtiene el tipo de sentencia PHQL ejecutada

```php
public function getUniqueRow(): bool;
```

Comprueba si la consulta está programada para obtener solo la primera fila en el conjunto de resultados

```php
public function get_transaction()
```

```php
public function parse(): array;
```

Analiza el código intermedio producido por Phalcon\Mvc\Model\Query\Lang generando otra representación intermedia que podría ser ejecutada por Phalcon\Mvc\Model\Query

```php
public function setBindParams( array $bindParams, bool $merge = bool ): QueryInterface;
```

Establece parámetros de enlace por defecto

```php
public function setBindTypes( array $bindTypes, bool $merge = bool ): QueryInterface;
```

Establece parámetros de enlace por defecto

```php
public function setDI( DiInterface $container ): void;
```

Establece el contenedor de inyección de dependencias

```php
public function setIntermediate( array $intermediate ): QueryInterface;
```

Permite establecer la IR a ser ejecutada

```php
public function setSharedLock( bool $sharedLock = bool ): QueryInterface;
```

Establece cláusula SHARED LOCK

```php
public function setTransaction( TransactionInterface $transaction ): QueryInterface;
```

permite envolver una transacción alrededor de todas las consultas

```php
public function setType( int $type ): QueryInterface;
```

Establece el tipo de sentencia PHQL a ser ejecutada

```php
public function setUniqueRow( bool $uniqueRow ): QueryInterface;
```

Indica a la consulta si se debe devolver sólo el primer registro del conjunto de resultados

```php
final protected function _executeDelete( array $intermediate, array $bindParams, array $bindTypes ): StatusInterface;
```

Ejecuta la representación intermedia DELETE produciendo un Phalcon\Mvc\Model\Query\Status

```php
final protected function _executeInsert( array $intermediate, array $bindParams, array $bindTypes ): StatusInterface;
```

Ejecuta la representación intermedia INSERT produciendo un Phalcon\Mvc\Model\Query\Status

```php
final protected function _executeSelect( array $intermediate, array $bindParams, array $bindTypes, bool $simulate = bool ): ResultsetInterface | array;
```

Ejecuta la representación intermedia SELECT produciendo un Phalcon\Mvc\Model\Resultset

```php
final protected function _executeUpdate( array $intermediate, array $bindParams, array $bindTypes ): StatusInterface;
```

Ejecuta la representación intermedia UPDATE produciendo un Phalcon\Mvc\Model\Query\Status

```php
final protected function _getCallArgument( array $argument ): array;
```

Resuelve una expresión en un único argumento de llamada

```php
final protected function _getCaseExpression( array $expr ): array;
```

Resuelve una expresión en un único argumento de llamada

```php
final protected function _getExpression( array $expr, bool $quoting = bool ): string;
```

Resuelve una expresión de su código intermedio a una cadena

```php
final protected function _getFunctionCall( array $expr ): array;
```

Resuelve una expresión en un único argumento de llamada

```php
final protected function _getGroupClause( array $group ): array;
```

Devuelve una cláusula de grupo procesado para una sentencia SELECT

```php
final protected function _getJoin( ManagerInterface $manager, array $join ): array;
```

Resuelve una cláusula JOIN comprobando si los modelos asociados existen

```php
final protected function _getJoinType( array $join ): string;
```

Resuelve un tipo de JOIN

```php
final protected function _getJoins( array $select ): array;
```

Procesa los JOINs en la consulta que devuelve una representación interna para el dialecto de la base de datos

```php
final protected function _getLimitClause( array $limitClause ): array;
```

Devuelve una cláusula de límite procesada para una sentencia SELECT

```php
final protected function _getMultiJoin( string $joinType, mixed $joinSource, string $modelAlias, string $joinAlias, RelationInterface $relation ): array;
```

Resuelve `joins` que involucran relaciones muchos-a-muchos

```php
final protected function _getOrderClause( mixed $order ): array;
```

Devuelve una cláusula de orden procesada para una sentencia SELECT

```php
final protected function _getQualified( array $expr ): array;
```

Reemplaza el nombre del modelo por su nombre de origen en una expresión de nombre calificado

```php
final protected function _getRelatedRecords( ModelInterface $model, array $intermediate, array $bindParams, array $bindTypes ): ResultsetInterface;
```

Consulta los registros en los que se realizará la operación UPDATE/DELETE

@todo Remove in v5.0 @deprecated Use getRelatedRecords()

```php
final protected function _getSelectColumn( array $column ): array;
```

Resuelve una columna de su representación intermedia en un vector usado para determinar si el conjunto de resultados producido es simple o complejo

```php
final protected function _getSingleJoin( string $joinType, mixed $joinSource, string $modelAlias, string $joinAlias, RelationInterface $relation ): array;
```

Resuelve `joins` que involucran relaciones tiene-uno/pertenece-a/tiene-muchos

```php
final protected function _getTable( ManagerInterface $manager, array $qualifiedName );
```

Resuelve una tabla en una sentencia SELECT comprobando si el modelo existe

```php
final protected function _prepareDelete(): array;
```

Analiza un código intermedio DELETE y produce un vector para ser ejecutado más tarde

```php
final protected function _prepareInsert(): array;
```

Analiza un código intermedio INSERT y produce un vector para ser ejecutado más tarde

```php
final protected function _prepareSelect( mixed $ast = null, bool $merge = bool ): array;
```

Analiza un código intermedio SELECT y produce un vector para ser ejecutado más tarde

```php
final protected function _prepareUpdate(): array;
```

Analiza un código intermedio UPDATE y produce un vector para ser ejecutado más tarde

```php
protected function getReadConnection( ModelInterface $model, array $intermediate = null, array $bindParams = [], array $bindTypes = [] ): AdapterInterface;
```

Obtiene la conexión de lectura del modelo si no hay ninguna transacción establecida dentro del objeto de consulta

```php
final protected function getRelatedRecords( ModelInterface $model, array $intermediate, array $bindParams, array $bindTypes ): ResultsetInterface;
```

Consulta los registros en los que se realizará la operación UPDATE/DELETE

```php
protected function getWriteConnection( ModelInterface $model, array $intermediate = null, array $bindParams = [], array $bindTypes = [] ): AdapterInterface;
```

Obtiene la conexión de escritura del modelo si no hay ninguna transacción dentro del objeto consulta

<h1 id="mvc-model-query-builder">Class Phalcon\Mvc\Model\Query\Builder</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Query/Builder.zep)

| Namespace | Phalcon\Mvc\Model\Query | | Uses | Phalcon\Di, Phalcon\Db\Column, Phalcon\Di\DiInterface, Phalcon\Helper\Arr, Phalcon\Mvc\Model\Exception, Phalcon\Di\InjectionAwareInterface, Phalcon\Mvc\Model\QueryInterface | | Implements | BuilderInterface, InjectionAwareInterface |

Phalcon\Mvc\Model\Query\Builder

Ayuda a crear consultas PHQL usando una interfaz OO

```php
$params = [
    "models"     => [
        Users::class,
    ],
    "columns"    => ["id", "name", "status"],
    "conditions" => [
        [
            "created > :min: AND created < :max:",
            [
                "min" => "2013-01-01",
                "max" => "2014-01-01",
            ],
            [
                "min" => PDO::PARAM_STR,
                "max" => PDO::PARAM_STR,
            ],
        ],
    ],
    // or "conditions" => "created > '2013-01-01' AND created < '2014-01-01'",
    "group"      => ["id", "name"],
    "having"     => "name = 'Kamil'",
    "order"      => ["name", "id"],
    "limit"      => 20,
    "offset"     => 20,
    // or "limit" => [20, 20],
];

$queryBuilder = new \Phalcon\Mvc\Model\Query\Builder($params);
```

## Propiedades

```php
//
protected bindParams;

//
protected bindTypes;

//
protected columns;

//
protected conditions;

//
protected container;

//
protected distinct;

//
protected forUpdate;

/**
 * @var array
 */
protected group;

//
protected having;

//
protected hiddenParamNumber = 0;

//
protected joins;

//
protected limit;

/**
 * @var array|string
 */
protected models;

//
protected offset;

//
protected order;

//
protected sharedLock;

```

## Métodos

```php
public function __construct( mixed $params = null, DiInterface $container = null );
```

Constructor Phalcon\Mvc\Model\Query\Builder

```php
public function addFrom( string $model, string $alias = null ): BuilderInterface;
```

Añade un modelo para que tome parte en la consulta

```php
// Load data from models Robots
$builder->addFrom(
    Robots::class
);

// Load data from model 'Robots' using 'r' as alias in PHQL
$builder->addFrom(
    Robots::class,
    "r"
);
```

```php
public function andHaving( string $conditions, array $bindParams = [], array $bindTypes = [] ): BuilderInterface;
```

Añade una condición a la cláusula de condiciones HAVING actual usando un operador AND

```php
$builder->andHaving("SUM(Robots.price) > 0");

$builder->andHaving(
    "SUM(Robots.price) > :sum:",
    [
        "sum" => 100,
    ]
);
```

```php
public function andWhere( string $conditions, array $bindParams = [], array $bindTypes = [] ): BuilderInterface;
```

Añade una condición a las condiciones WHERE actuales usando un operador AND

```php
$builder->andWhere("name = 'Peter'");

$builder->andWhere(
    "name = :name: AND id > :id:",
    [
        "name" => "Peter",
        "id"   => 100,
    ]
);
```

```php
final public function autoescape( string $identifier ): string;
```

Escapa automáticamente los identificadores, pero sólo si necesitan ser escapados.

```php
public function betweenHaving( string $expr, mixed $minimum, mixed $maximum, string $operator = static-constant-access ): BuilderInterface;
```

Añade una condición BETWEEN a la cláusula actual de condiciones HAVING

```php
$builder->betweenHaving("SUM(Robots.price)", 100.25, 200.50);
```

```php
public function betweenWhere( string $expr, mixed $minimum, mixed $maximum, string $operator = static-constant-access ): BuilderInterface;
```

Añade una condición BETWEEN a las condiciones WHERE actuales

```php
$builder->betweenWhere("price", 100.25, 200.50);
```

```php
public function columns( mixed $columns ): BuilderInterface;
```

Establece las columnas a consultar

```php
$builder->columns("id, name");

$builder->columns(
    [
        "id",
        "name",
    ]
);

$builder->columns(
    [
        "name",
        "number" => "COUNT(*)",
    ]
);
```

```php
public function distinct( mixed $distinct ): BuilderInterface;
```

Establece la bandera SELECT DISTINCT / SELECT ALL

```php
$builder->distinct("status");
$builder->distinct(null);
```

```php
public function forUpdate( bool $forUpdate ): BuilderInterface;
```

Establece una cláusula FOR UPDATE

```php
$builder->forUpdate(true);
```

```php
public function from( mixed $models ): BuilderInterface;
```

Establece los modelos que forman parte de la consulta

```php
$builder->from(
    Robots::class
);

$builder->from(
    [
        Robots::class,
        RobotsParts::class,
    ]
);

$builder->from(
    [
        "r"  => Robots::class,
        "rp" => RobotsParts::class,
    ]
);
```

```php
public function getBindParams(): array;
```

Devuelve parámetros de enlace por defecto

```php
public function getBindTypes(): array;
```

Devuelve tipos de enlace por defecto

```php
public function getColumns();
```

Devuelve las columnas a ser consultadas

```php
public function getDI(): DiInterface;
```

Devuelve el contenedor DependencyInjector

```php
public function getDistinct(): bool;
```

Devuelve la bandera SELECT DISTINCT / SELECT ALL

```php
public function getFrom();
```

Devuelve los modelos que forman parte de la consulta

```php
public function getGroupBy(): array;
```

Devuelve la cláusula GROUP BY

```php
public function getHaving(): string;
```

Devuelve la cláusula `having` actual

```php
public function getJoins(): array;
```

Devuelve las partes `join` de la consulta

```php
public function getLimit();
```

Devuelve la cláusula LIMIT actual

```php
public function getModels(): string | array | null;
```

Devuelve los modelos involucrados en la consulta

```php
public function getOffset(): int;
```

Devuelve la cláusula OFFSET actual

```php
public function getOrderBy();
```

Devuelve la cláusula ORDER BY establecida

```php
final public function getPhql(): string;
```

Devuelve una sentencia PHQL construida basada en los parámetros del constructor

```php
public function getQuery(): QueryInterface;
```

Devuelve la consulta construida

```php
public function getWhere();
```

Devolver las condiciones de la consulta

```php
public function groupBy( mixed $group ): BuilderInterface;
```

Establece una cláusula GROUP BY

```php
$builder->groupBy(
    [
        "Robots.name",
    ]
);
```

```php
public function having( mixed $conditions, array $bindParams = [], array $bindTypes = [] ): BuilderInterface;
```

Establece la cláusula de condición HAVING

```php
$builder->having("SUM(Robots.price) > 0");

$builder->having(
    "SUM(Robots.price) > :sum:",
    [
        "sum" => 100,
    ]
);
```

```php
public function inHaving( string $expr, array $values, string $operator = static-constant-access ): BuilderInterface;
```

Añade una condición IN a la cláusula actual HAVING

```php
$builder->inHaving("SUM(Robots.price)", [100, 200]);
```

```php
public function inWhere( string $expr, array $values, string $operator = static-constant-access ): BuilderInterface;
```

Añade una condición IN a las condiciones WHERE actuales

```php
$builder->inWhere(
    "id",
    [1, 2, 3]
);
```

```php
public function innerJoin( string $model, string $conditions = null, string $alias = null ): BuilderInterface;
```

Añade un `INNER join` a la consulta

```php
// Inner Join model 'Robots' with automatic conditions and alias
$builder->innerJoin(
    Robots::class
);

// Inner Join model 'Robots' specifying conditions
$builder->innerJoin(
    Robots::class,
    "Robots.id = RobotsParts.robots_id"
);

// Inner Join model 'Robots' specifying conditions and alias
$builder->innerJoin(
    Robots::class,
    "r.id = RobotsParts.robots_id",
    "r"
);
```

```php
public function join( string $model, string $conditions = null, string $alias = null, string $type = null ): BuilderInterface;
```

Añade un :type: join (por defecto - INNER) a la consulta

```php
// Inner Join model 'Robots' with automatic conditions and alias
$builder->join(
    Robots::class
);

// Inner Join model 'Robots' specifying conditions
$builder->join(
    Robots::class,
    "Robots.id = RobotsParts.robots_id"
);

// Inner Join model 'Robots' specifying conditions and alias
$builder->join(
    Robots::class,
    "r.id = RobotsParts.robots_id",
    "r"
);

// Left Join model 'Robots' specifying conditions, alias and type of join
$builder->join(
    Robots::class,
    "r.id = RobotsParts.robots_id",
    "r",
    "LEFT"
);
```

```php
public function leftJoin( string $model, string $conditions = null, string $alias = null ): BuilderInterface;
```

Añade un `LEFT join` a la consulta

```php
$builder->leftJoin(
    Robots::class,
    "r.id = RobotsParts.robots_id",
    "r"
);
```

```php
public function limit( int $limit, mixed $offset = null ): BuilderInterface;
```

Establece una cláusula LIMIT, opcionalmente una cláusula de desplazamiento

```php
$builder->limit(100);
$builder->limit(100, 20);
$builder->limit("100", "20");
```

```php
public function notBetweenHaving( string $expr, mixed $minimum, mixed $maximum, string $operator = static-constant-access ): BuilderInterface;
```

Añade una condición NOT BETWEEN a la cláusula actual de condiciones HAVING

```php
$builder->notBetweenHaving("SUM(Robots.price)", 100.25, 200.50);
```

```php
public function notBetweenWhere( string $expr, mixed $minimum, mixed $maximum, string $operator = static-constant-access ): BuilderInterface;
```

Añade una condición BETWEEN a las condiciones WHERE actuales

```php
$builder->notBetweenWhere("price", 100.25, 200.50);
```

```php
public function notInHaving( string $expr, array $values, string $operator = static-constant-access ): BuilderInterface;
```

Añade una condición NOT IN a la cláusula actual de condiciones HAVING

```php
$builder->notInHaving("SUM(Robots.price)", [100, 200]);
```

```php
public function notInWhere( string $expr, array $values, string $operator = static-constant-access ): BuilderInterface;
```

Añade una condición NOT IN a las condiciones WHERE actuales

```php
$builder->notInWhere("id", [1, 2, 3]);
```

```php
public function offset( int $offset ): BuilderInterface;
```

Establece una cláusula OFFSET

```php
$builder->offset(30);
```

```php
public function orHaving( string $conditions, array $bindParams = [], array $bindTypes = [] ): BuilderInterface;
```

Añade una condición a la cláusula actual de condiciones HAVING usando un operador OR

```php
$builder->orHaving("SUM(Robots.price) > 0");

$builder->orHaving(
    "SUM(Robots.price) > :sum:",
    [
        "sum" => 100,
    ]
);
```

```php
public function orWhere( string $conditions, array $bindParams = [], array $bindTypes = [] ): BuilderInterface;
```

Añade una condición a las condiciones actuales usando un operador OR

```php
$builder->orWhere("name = 'Peter'");

$builder->orWhere(
    "name = :name: AND id > :id:",
    [
        "name" => "Peter",
        "id"   => 100,
    ]
);
```

```php
public function orderBy( mixed $orderBy ): BuilderInterface;
```

Establece una cláusula de condición ORDER BY

```php
$builder->orderBy("Robots.name");
$builder->orderBy(["1", "Robots.name"]);
$builder->orderBy(["Robots.name DESC"]);
```

```php
public function rightJoin( string $model, string $conditions = null, string $alias = null ): BuilderInterface;
```

Añade un `RIGHT join` a la consulta

```php
$builder->rightJoin(
    Robots::class,
    "r.id = RobotsParts.robots_id",
    "r"
);
```

```php
public function setBindParams( array $bindParams, bool $merge = bool ): BuilderInterface;
```

Establece parámetros de enlace por defecto

```php
public function setBindTypes( array $bindTypes, bool $merge = bool ): BuilderInterface;
```

Establece los tipos de enlace predeterminados

```php
public function setDI( DiInterface $container ): void;
```

Configura el contenedor DependencyInjector

```php
public function where( string $conditions, array $bindParams = [], array $bindTypes = [] ): BuilderInterface;
```

Establece las condiciones WHERE de la consulta

```php
$builder->where(100);

$builder->where("name = 'Peter'");

$builder->where(
    "name = :name: AND id > :id:",
    [
        "name" => "Peter",
        "id"   => 100,
    ]
);
```

```php
protected function conditionBetween( string $clause, string $operator, string $expr, mixed $minimum, mixed $maximum ): BuilderInterface;
```

Añade una condición BETWEEN

```php
protected function conditionIn( string $clause, string $operator, string $expr, array $values ): BuilderInterface;
```

Añade una condición IN

```php
protected function conditionNotBetween( string $clause, string $operator, string $expr, mixed $minimum, mixed $maximum ): BuilderInterface;
```

Añade una condición NOT BETWEEN

```php
protected function conditionNotIn( string $clause, string $operator, string $expr, array $values ): BuilderInterface;
```

Añade una condición NOT IN

<h1 id="mvc-model-query-builderinterface">Interface Phalcon\Mvc\Model\Query\BuilderInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Query/BuilderInterface.zep)

| Namespace | Phalcon\Mvc\Model\Query | | Uses | Phalcon\Mvc\Model\QueryInterface |

Phalcon\Mvc\Model\Query\BuilderInterface

Interfaz para Phalcon\Mvc\Model\Query\Builder

## Constantes

```php
const OPERATOR_AND = and;
const OPERATOR_OR = or;
```

## Métodos

```php
public function addFrom( string $model, string $alias = null ): BuilderInterface;
```

Añade un modelo para que tome parte en la consulta

```php
public function andWhere( string $conditions, array $bindParams = [], array $bindTypes = [] ): BuilderInterface;
```

Añade una condición a las condiciones actuales usando un operador AND

```php
public function betweenWhere( string $expr, mixed $minimum, mixed $maximum, string $operator = static-constant-access ): BuilderInterface;
```

Añade una condición BETWEEN a las condiciones actuales

```php
public function columns( mixed $columns ): BuilderInterface;
```

Establece las columnas a consultar

```php
public function distinct( mixed $distinct ): BuilderInterface;
```

Establece la bandera SELECT DISTINCT / SELECT ALL

```php
$builder->distinct("status");
$builder->distinct(null);
```

```php
public function forUpdate( bool $forUpdate ): BuilderInterface;
```

Establece una cláusula FOR UPDATE

```php
$builder->forUpdate(true);
```

```php
public function from( mixed $models ): BuilderInterface;
```

Establece los modelos que forman parte de la consulta

```php
public function getBindParams(): array;
```

Devuelve parámetros de enlace por defecto

```php
public function getBindTypes(): array;
```

Devuelve tipos de enlace por defecto

```php
public function getColumns();
```

Devuelve las columnas a ser consultadas

```php
public function getDistinct(): bool;
```

Devuelve la bandera SELECT DISTINCT / SELECT ALL

```php
public function getFrom();
```

Devuelve los modelos que forman parte de la consulta

```php
public function getGroupBy(): array;
```

Devuelve la cláusula GROUP BY

```php
public function getHaving(): string;
```

Devuelve la cláusula de condición HAVING

```php
public function getJoins(): array;
```

Devuelve las partes `join` de la consulta

```php
public function getLimit();
```

Devuelve la cláusula LIMIT actual

```php
public function getModels(): string | array | null;
```

Devuelve los modelos involucrados en la consulta

```php
public function getOffset(): int;
```

Devuelve la cláusula OFFSET actual

```php
public function getOrderBy();
```

Devuelve la cláusula ORDER BY establecida

```php
public function getPhql(): string;
```

Devuelve una sentencia PHQL construida basada en los parámetros del constructor

```php
public function getQuery(): QueryInterface;
```

Devuelve la consulta construida

```php
public function getWhere();
```

Devolver las condiciones de la consulta

```php
public function groupBy( mixed $group ): BuilderInterface;
```

Establece una cláusula GROUP BY

```php
public function having( string $having ): BuilderInterface;
```

Establece la cláusula de condición HAVING

```php
public function inWhere( string $expr, array $values, string $operator = static-constant-access ): BuilderInterface;
```

Añade una condición IN a las condiciones actuales

```php
public function innerJoin( string $model, string $conditions = null, string $alias = null ): BuilderInterface;
```

Añade un `INNER join` a la consulta

```php
public function join( string $model, string $conditions = null, string $alias = null ): BuilderInterface;
```

Añade un :type: join (por defecto - INNER) a la consulta

```php
public function leftJoin( string $model, string $conditions = null, string $alias = null ): BuilderInterface;
```

Añade un `LEFT join` a la consulta

```php
public function limit( int $limit, mixed $offset = null ): BuilderInterface;
```

Establece una cláusula LIMIT

```php
public function notBetweenWhere( string $expr, mixed $minimum, mixed $maximum, string $operator = static-constant-access ): BuilderInterface;
```

Añade una condición NOT BETWEEN a las condiciones actuales

```php
public function notInWhere( string $expr, array $values, string $operator = static-constant-access ): BuilderInterface;
```

Añade una condición NOT IN a las condiciones actuales

```php
public function offset( int $offset ): BuilderInterface;
```

Establece una cláusula OFFSET

```php
public function orWhere( string $conditions, array $bindParams = [], array $bindTypes = [] ): BuilderInterface;
```

Añade una condición a las condiciones actuales usando un operador OR

```php
public function orderBy( string $orderBy ): BuilderInterface;
```

Establece una cláusula de condición ORDER BY

```php
public function rightJoin( string $model, string $conditions = null, string $alias = null ): BuilderInterface;
```

Añade un `RIGHT join` a la consulta

```php
public function setBindParams( array $bindParams, bool $merge = bool ): BuilderInterface;
```

Establece parámetros de enlace por defecto

```php
public function setBindTypes( array $bindTypes, bool $merge = bool ): BuilderInterface;
```

Establece los tipos de enlace predeterminados

```php
public function where( string $conditions, array $bindParams = [], array $bindTypes = [] ): BuilderInterface;
```

Establece las condiciones para la consulta

<h1 id="mvc-model-query-lang">Abstract Class Phalcon\Mvc\Model\Query\Lang</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Query/Lang.zep)

| Namespace | Phalcon\Mvc\Model\Query |

Phalcon\Mvc\Model\Query\Lang

PHQL está implementado como un analizador (escrito en C) que traduce la sintaxis en la del RDBMS destino. Permite a Phalcon ofrecer un lenguaje SQL unificado al desarrollador, mientras internamente está haciendo todo el trabajo de traducir las instrucciones de PHQL a las instrucciones SQL más óptimas dependiendo del tipo RDBMS asociado con un modelo.

Para lograr el mayor rendimiento posible, escribimos un analizador que utiliza la misma tecnología que SQLite. Esta tecnología proporciona un analizador pequeño en memoria con una huella en memoria muy baja que también es segura en hilos.

```php
use Phalcon\Mvc\Model\Query\Lang;

$intermediate = Lang::parsePHQL(
    "SELECT r.* FROM Robots r LIMIT 10"
);
```

## Métodos

```php
public static function parsePHQL( string $phql ): array;
```

Analiza una sentencia PHQL devolviendo una representación intermedia (IR)

<h1 id="mvc-model-query-status">Class Phalcon\Mvc\Model\Query\Status</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Query/Status.zep)

| Namespace | Phalcon\Mvc\Model\Query | | Uses | Phalcon\Messages\MessageInterface, Phalcon\Mvc\ModelInterface | | Implements | StatusInterface |

Phalcon\Mvc\Model\Query\Status

Esta clase representa el estado devuelto por una sentencia PHQL como INSERT, UPDATE o DELETE. Ofrece información del contexto y los mensajes relacionados producidos por el modelo que finalmente ejecuta las operaciones cuando falla

```php
$phql = "UPDATE Robots SET name = :name:, type = :type:, year = :year: WHERE id = :id:";

$status = $app->modelsManager->executeQuery(
    $phql,
    [
        "id"   => 100,
        "name" => "Astroy Boy",
        "type" => "mechanical",
        "year" => 1959,
    ]
);

// Check if the update was successful
if ($status->success()) {
    echo "OK";
}
```

## Propiedades

```php
//
protected model;

//
protected success;

```

## Métodos

```php
public function __construct( bool $success, ModelInterface $model = null );
```

Phalcon\Mvc\Model\Query\Status

```php
public function getMessages(): MessageInterface[];
```

Devuelve los mensajes producidos debido a una operación fallida

```php
public function getModel(): ModelInterface;
```

Devuelve el modelo que ejecutó la acción

```php
public function success(): bool;
```

Permite comprobar si la operación ejecutada fue exitosa

<h1 id="mvc-model-query-statusinterface">Interface Phalcon\Mvc\Model\Query\StatusInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Query/StatusInterface.zep)

| Namespace | Phalcon\Mvc\Model\Query | | Uses | Phalcon\Messages\MessageInterface, Phalcon\Mvc\ModelInterface |

Phalcon\Mvc\Model\Query\StatusInterface

Interfaz para Phalcon\Mvc\Model\Query\Status

## Métodos

```php
public function getMessages(): MessageInterface[];
```

Devuelve los mensajes producidos por una operación fallida

```php
public function getModel(): ModelInterface;
```

Devuelve el modelo que ejecutó la acción

```php
public function success(): bool;
```

Permite comprobar si la operación ejecutada fue exitosa

<h1 id="mvc-model-queryinterface">Interface Phalcon\Mvc\Model\QueryInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/QueryInterface.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Phalcon\Mvc\ModelInterface |

Phalcon\Mvc\Model\QueryInterface

Interfaz para Phalcon\Mvc\Model\Query

## Métodos

```php
public function cache( array $cacheOptions ): QueryInterface;
```

Establece los parámetros del caché de la consulta

```php
public function execute( array $bindParams = [], array $bindTypes = [] );
```

Ejecuta una sentencia PHQL analizada

```php
public function getBindParams(): array;
```

Devuelve parámetros de enlace por defecto

```php
public function getBindTypes(): array;
```

Devuelve tipos de enlace por defecto

```php
public function getCacheOptions(): array;
```

Devuelve las opciones actuales de caché

```php
public function getSingleResult( array $bindParams = [], array $bindTypes = [] ): ModelInterface;
```

Ejecuta la consulta devolviendo el primer resultado

```php
public function getSql(): array;
```

Devuelve el SQL a ser generado por el PHQL interno (solo funciona en sentencias SELECT)

```php
public function getUniqueRow(): bool;
```

Comprueba si la consulta está programada para obtener solo la primera fila en el conjunto de resultados

```php
public function parse(): array;
```

Analiza el código intermedio producido por Phalcon\Mvc\Model\Query\Lang generando otra representación intermedia que podría ser ejecutada por Phalcon\Mvc\Model\Query

```php
public function setBindParams( array $bindParams, bool $merge = bool ): QueryInterface;
```

Establece parámetros de enlace por defecto

```php
public function setBindTypes( array $bindTypes, bool $merge = bool ): QueryInterface;
```

Establece parámetros de enlace por defecto

```php
public function setSharedLock( bool $sharedLock = bool ): QueryInterface;
```

Establece cláusula SHARED LOCK

```php
public function setUniqueRow( bool $uniqueRow ): QueryInterface;
```

Indica a la consulta si se debe devolver sólo el primer registro del conjunto de resultados

<h1 id="mvc-model-relation">Class Phalcon\Mvc\Model\Relation</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Relation.zep)

| Namespace | Phalcon\Mvc\Model | | Implements | RelationInterface |

Phalcon\Mvc\Model\Relation

Esta clase representa una relación entre dos modelos

## Constantes

```php
const ACTION_CASCADE = 2;
const ACTION_RESTRICT = 1;
const BELONGS_TO = 0;
const HAS_MANY = 2;
const HAS_MANY_THROUGH = 4;
const HAS_ONE = 1;
const HAS_ONE_THROUGH = 3;
const NO_ACTION = 0;
```

## Propiedades

```php
//
protected fields;

//
protected intermediateFields;

//
protected intermediateModel;

//
protected intermediateReferencedFields;

//
protected options;

//
protected referencedFields;

//
protected referencedModel;

//
protected type;

```

## Métodos

```php
public function __construct( int $type, string $referencedModel, mixed $fields, mixed $referencedFields, array $options = [] );
```

Constructor Phalcon\Mvc\Model\Relation

```php
public function getFields();
```

Devuelve los campos

```php
public function getForeignKey();
```

Devuelve la configuración de clave ajena

```php
public function getIntermediateFields();
```

Obtiene los campos intermedios para las relaciones has-*-through

```php
public function getIntermediateModel(): string;
```

Obtiene el modelo intermedio para las relaciones has-*-through

```php
public function getIntermediateReferencedFields();
```

Obtiene los campos intermedios referenciados para las relaciones has-*-through

```php
public function getOption( string $name );
```

Devuelve una opción por el nombre especificado Si la opción no existe se devuelve null

```php
public function getOptions(): array;
```

Devuelve las opciones

```php
public function getParams();
```

Devuelve parámetros que deben utilizarse siempre cuando se obtengan los registros relacionados

```php
public function getReferencedFields();
```

Devuelve los campos referenciados

```php
public function getReferencedModel(): string;
```

Devuelve el modelo referenciado

```php
public function getType(): int;
```

Devuelve el tipo de relación

```php
public function isForeignKey(): bool;
```

Comprueba si la relación actúa como una clave ajena

```php
public function isReusable(): bool;
```

Comprobar si los registros devueltos al obtener belongs-to/has-many están implícitamente almacenados en caché durante la solicitud actual

```php
public function isThrough(): bool;
```

Comprueba si la relación es una relación 'muchos-a-muchos' o no

```php
public function setIntermediateRelation( mixed $intermediateFields, string $intermediateModel, mixed $intermediateReferencedFields );
```

Establece los datos intermedios del modelo para las relaciones has-*-through

<h1 id="mvc-model-relationinterface">Interface Phalcon\Mvc\Model\RelationInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/RelationInterface.zep)

| Namespace | Phalcon\Mvc\Model |

Phalcon\Mvc\Model\RelationInterface

Interfaz para Phalcon\Mvc\Model\Relation

## Métodos

```php
public function getFields();
```

Devuelve los campos

```php
public function getForeignKey();
```

Devuelve la configuración de clave ajena

```php
public function getIntermediateFields();
```

Obtiene los campos intermedios para las relaciones has-*-through

```php
public function getIntermediateModel(): string;
```

Obtiene el modelo intermedio para las relaciones has-*-through

```php
public function getIntermediateReferencedFields();
```

Obtiene los campos intermedios referenciados para las relaciones has-*-through

```php
public function getOption( string $name );
```

Devuelve una opción por el nombre especificado Si la opción no existe se devuelve null

```php
public function getOptions(): array;
```

Devuelve las opciones

```php
public function getParams();
```

Devuelve parámetros que deben utilizarse siempre cuando se obtengan los registros relacionados

```php
public function getReferencedFields();
```

Devuelve los campos referenciados

```php
public function getReferencedModel(): string;
```

Devuelve el modelo referenciado

```php
public function getType(): int;
```

Devuelve los tipos de relación

```php
public function isForeignKey(): bool;
```

Comprueba si la relación actúa como una clave ajena

```php
public function isReusable(): bool;
```

Comprobar si los registros devueltos al obtener belongs-to/has-many están implícitamente almacenados en caché durante la solicitud actual

```php
public function isThrough(): bool;
```

Comprueba si la relación es una relación 'muchos-a-muchos' o no

```php
public function setIntermediateRelation( mixed $intermediateFields, string $intermediateModel, mixed $intermediateReferencedFields );
```

Establece los datos intermedios del modelo para las relaciones has-*-through

<h1 id="mvc-model-resultinterface">Interface Phalcon\Mvc\Model\ResultInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/ResultInterface.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Phalcon\Mvc\ModelInterface |

Phalcon\Mvc\Model\ResultInterface

Todos los objetos individuales pasados como objetos base a Resultsets deben implementar esta interfaz

## Métodos

```php
public function setDirtyState( int $dirtyState ): ModelInterface | bool;
```

Establece el estado del objeto

<h1 id="mvc-model-resultset">Abstract Class Phalcon\Mvc\Model\Resultset</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Resultset.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | ArrayAccess, Closure, Countable, Iterator, JsonSerializable, Phalcon\Db\Enum, Phalcon\Messages\MessageInterface, Phalcon\Mvc\Model, Phalcon\Mvc\ModelInterface, Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Serializer\SerializerInterface, SeekableIterator, Serializable | | Implements | ResultsetInterface, Iterator, SeekableIterator, Countable, ArrayAccess, Serializable, JsonSerializable |

Phalcon\Mvc\Model\Resultset

Este componente permite que Phalcon\Mvc\Model devuelva conjuntos de resultados grandes con el consumo mínimo de memoria Los Resultsets pueden ser recorridos usando una instrucción estándar para cada uno o un tiempo. Si un conjunto de resultados se serializa volcará todos los registros en un gran vector. Entonces la deserialización recuperará las filas como estaban antes de serializar.

```php
<br />// Using a standard foreach
$robots = Robots::find(
    [
        "type = 'virtual'",
        "order" => "name",
    ]
);

foreach ($robots as robot) {
    echo robot->name, "\n";
}

// Using a while
$robots = Robots::find(
    [
        "type = 'virtual'",
        "order" => "name",
    ]
);

$robots->rewind();

while ($robots->valid()) {
    $robot = $robots->current();

    echo $robot->name, "\n";

    $robots->next();
}
```

## Constantes

```php
const HYDRATE_ARRAYS = 1;
const HYDRATE_OBJECTS = 2;
const HYDRATE_RECORDS = 0;
const TYPE_RESULT_FULL = 0;
const TYPE_RESULT_PARTIAL = 1;
```

## Propiedades

```php
//
protected activeRow;

//
protected cache;

//
protected count = 0;

//
protected errorMessages;

//
protected hydrateMode = 0;

//
protected isFresh = true;

//
protected pointer = 0;

//
protected row;

//
protected rows;

/**
 * Phalcon\Db\ResultInterface or false for empty resultset
 */
protected result;

```

## Métodos

```php
public function __construct( mixed $result, AdapterInterface $cache = null );
```

Constructor Phalcon\Mvc\Model\Resultset

```php
final public function count(): int;
```

Cuenta cuántos registros hay en el conjunto de resultados

```php
public function delete( Closure $conditionCallback = null ): bool;
```

Elimina todos los registros del conjunto de resultados

```php
public function filter( callable $filter ): ModelInterface[];
```

Filtra un conjunto de resultados devolviendo sólo aquellos que el desarrollador requiera

```php
$filtered = $robots->filter(
    function ($robot) {
        if ($robot->id < 3) {
            return $robot;
        }
    }
);
```

```php
public function getCache(): AdapterInterface;
```

Devuelve el caché asociado para el conjunto de resultados

```php
public function getFirst(): mixed | null;
```

Obtener la primera fila del conjunto de resultados

```php
$model = new Robots();
$manager = $model->getModelsManager();

// \Robots
$manager->createQuery('SELECTFROM Robots')
        ->execute()
        ->getFirst();

// \Phalcon\Mvc\Model\Row
$manager->createQuery('SELECT r.id FROM Robots AS r')
        ->execute()
        ->getFirst();

// NULL
$manager->createQuery('SELECT r.id FROM Robots AS r WHERE r.name = "NON-EXISTENT"')
        ->execute()
        ->getFirst();
```

```php
public function getHydrateMode(): int;
```

Devuelve el modo de hidratación actual

```php
public function getLast(): ModelInterface | null;
```

Obtener la última fila del conjunto de resultados

```php
public function getMessages(): MessageInterface[];
```

Devuelve los mensajes de error producidos por una operación por lotes

```php
public function getType(): int;
```

Devuelve el tipo interno de recuperación de datos que el conjunto de resultados está usando

```php
public function isFresh(): bool;
```

Indica si el conjunto de resultados es fresco o un caché antiguo

```php
public function jsonSerialize(): array;
```

Devuelve objetos de modelo serializados como vector por json_encode. Llama jsonSerialize en cada objeto si está presente

```php
$robots = Robots::find();

echo json_encode($robots);
```

```php
public function key(): int | null;
```

Obtiene el número de puntero del registro activo en el conjunto de resultados

```php
public function next(): void;
```

Mueve el cursor a la siguiente fila del conjunto de resultados

```php
public function offsetExists( mixed $index ): bool;
```

Comprueba si existe un offset en el conjunto de resultados

```php
public function offsetGet( mixed $index ): ModelInterface | bool;
```

Obtiene un registro de una posición específica del conjunto de resultados

```php
public function offsetSet( mixed $index, mixed $value ): void;
```

Los conjuntos de resultados no se pueden cambiar. Sólo se ha implementado para cumplir con la definición de la interfaz ArrayAccess

```php
public function offsetUnset( mixed $offset ): void;
```

Los conjuntos de resultados no se pueden cambiar. Sólo se ha implementado para cumplir con la definición de la interfaz ArrayAccess

```php
final public function rewind(): void;
```

Rebobina el conjunto de resultados a su inicio

```php
final public function seek( mixed $position ): void;
```

Cambia el puntero interno a una posición específica en el conjunto de resultados. Establece la nueva posición si es necesario, y luego establece this->row

```php
public function setHydrateMode( int $hydrateMode ): ResultsetInterface;
```

Establece el modo de hidratación en el conjunto de resultados

```php
public function setIsFresh( bool $isFresh ): ResultsetInterface;
```

Establece si el conjunto de resultados es fresco o un caché antiguo

```php
public function update( mixed $data, Closure $conditionCallback = null ): bool;
```

Actualiza cada registro en el conjunto de resultados

```php
public function valid(): bool;
```

Comprobar si el recurso interno tiene filas para recuperar

<h1 id="mvc-model-resultset-complex">Class Phalcon\Mvc\Model\Resultset\Complex</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Resultset/Complex.zep)

| Namespace | Phalcon\Mvc\Model\Resultset | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Di, Phalcon\Di\DiInterface, Phalcon\Db\ResultInterface, Phalcon\Mvc\Model, Phalcon\Mvc\Model\Exception, Phalcon\Mvc\Model\Resultset, Phalcon\Mvc\Model\ResultsetInterface, Phalcon\Mvc\Model\Row, Phalcon\Mvc\ModelInterface, Phalcon\Storage\Serializer\SerializerInterface, stdClass | | Extends | Resultset | | Implements | ResultsetInterface |

Phalcon\Mvc\Model\Resultset\Complex

Los conjuntos de resultados complejos pueden incluir objetos completos y valores escalares. Esta clase construye cada registro complejo ya que se requiere

## Propiedades

```php
//
protected columnTypes;

/**
 * Unserialised result-set hydrated all rows already. unserialise() sets
 * disableHydration to true
 */
protected disableHydration = false;

```

## Métodos

```php
public function __construct( mixed $columnTypes, ResultInterface $result = null, AdapterInterface $cache = null );
```

Constructor Phalcon\Mvc\Model\Resultset\Complex

```php
final public function current(): ModelInterface | bool;
```

Devuelve la fila actual en el conjunto de resultados

```php
public function serialize(): string;
```

Serializar un conjunto de resultados extraerá todas las filas relacionadas en un vector grande

```php
public function toArray(): array;
```

Devuelve un conjunto de resultados completo como un vector, si el conjunto de resultados tiene un gran número de filas podría consumir más memoria de la que consume actualmente.

```php
public function unserialize( mixed $data ): void;
```

Deserializar un conjunto de resultados sólo permitirá trabajar en las filas presentes en el estado guardado

<h1 id="mvc-model-resultset-simple">Class Phalcon\Mvc\Model\Resultset\Simple</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Resultset/Simple.zep)

| Namespace | Phalcon\Mvc\Model\Resultset | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Di, Phalcon\Di\DiInterface, Phalcon\Mvc\Model, Phalcon\Mvc\Model\Exception, Phalcon\Mvc\Model\Resultset, Phalcon\Mvc\Model\Row, Phalcon\Mvc\ModelInterface, Phalcon\Storage\Serializer\SerializerInterface | | Extends | Resultset |

Phalcon\Mvc\Model\Resultset\Simple

Los conjuntos de resultados simples solo contienen un objeto completo Esta clase construye cada objeto completo como es requerido

## Propiedades

```php
//
protected columnMap;

//
protected model;

/**
 * @var bool
 */
protected keepSnapshots = false;

```

## Métodos

```php
public function __construct( mixed $columnMap, mixed $model, mixed $result, AdapterInterface $cache = null, bool $keepSnapshots = null );
```

Constructor Phalcon\Mvc\Model\Resultset\Simple

```php
final public function current(): ModelInterface | null;
```

Devuelve la fila actual en el conjunto de resultados

```php
public function serialize(): string;
```

Serializar un conjunto de resultados extraerá todas las filas relacionadas en un vector grande

```php
public function toArray( bool $renameColumns = bool ): array;
```

Devuelve un conjunto de resultados completo como un vector, si el conjunto de resultados tiene un gran número de filas podría consumir más memoria de la que consume actualmente. Exportar el conjunto de resultados a un vector no podría ser más rápido con un gran número de registros

```php
public function unserialize( mixed $data ): void;
```

Deserializar un conjunto de resultados solo permitirá trabajar en las filas presentes en el estado guardado

<h1 id="mvc-model-resultsetinterface">Interface Phalcon\Mvc\Model\ResultsetInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/ResultsetInterface.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Closure, Phalcon\Messages\MessageInterface, Phalcon\Mvc\ModelInterface, Phalcon\Cache\Adapter\AdapterInterface |

Phalcon\Mvc\Model\ResultsetInterface

Interfaz para Phalcon\Mvc\Model\Resultset

## Métodos

```php
public function delete( Closure $conditionCallback = null ): bool;
```

Elimina todos los registros del conjunto de resultados

```php
public function filter( callable $filter ): ModelInterface[];
```

Filtra un conjunto de resultados devolviendo sólo aquellos que el desarrollador requiera

```php
$filtered = $robots->filter(
    function ($robot) {
        if ($robot->id < 3) {
            return $robot;
        }
    }
);
```

```php
public function getCache(): AdapterInterface;
```

Devuelve el caché asociado para el conjunto de resultados

```php
public function getFirst(): mixed | null;
```

Obtener la primera fila del conjunto de resultados

```php
public function getHydrateMode(): int;
```

Devuelve el modo de hidratación actual

```php
public function getLast(): ModelInterface | null;
```

Obtener la última fila del conjunto de resultados

```php
public function getMessages(): MessageInterface[];
```

Devuelve los mensajes de error producidos por una operación por lotes

```php
public function getType(): int;
```

Devuelve el tipo interno de recuperación de datos que el conjunto de resultados está usando

```php
public function isFresh(): bool;
```

Indica si el conjunto de resultados es fresco o un caché antiguo

```php
public function setHydrateMode( int $hydrateMode ): ResultsetInterface;
```

Establece el modo de hidratación en el conjunto de resultados

```php
public function setIsFresh( bool $isFresh ): ResultsetInterface;
```

Establece si el conjunto de resultados es fresco o un caché antiguo

```php
public function toArray(): array;
```

Devuelve un conjunto de resultados completo como un vector, si el conjunto de resultados tiene un gran número de filas podría consumir más memoria de la que consume actualmente.

```php
public function update( mixed $data, Closure $conditionCallback = null ): bool;
```

Actualiza cada registro en el conjunto de resultados

<h1 id="mvc-model-row">Class Phalcon\Mvc\Model\Row</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Row.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | ArrayAccess, JsonSerializable, Phalcon\Mvc\EntityInterface, Phalcon\Mvc\ModelInterface | | Implements | EntityInterface, ResultInterface, ArrayAccess, JsonSerializable |

Phalcon\Mvc\Model\Row

Este componente permite a Phalcon\Mvc\Model devolver filas sin una entidad asociada. Este objeto implementa la interfaz ArrayAccess para permitir el acceso al objeto como objeto->x o array[x].

## Métodos

```php
public function jsonSerialize(): array;
```

Serializa el objeto por json_encode

```php
public function offsetExists( mixed $index ): bool;
```

Comprueba si existe un desplazamiento en la fila

```php
public function offsetGet( mixed $index ): mixed;
```

Obtiene un registro en una posición específica de la fila

```php
public function offsetSet( mixed $index, mixed $value ): void;
```

Las filas no se pueden cambiar. Sólo se ha implementado para cumplir con la definición de la interfaz ArrayAccess

```php
public function offsetUnset( mixed $offset ): void;
```

Las filas no se pueden cambiar. Sólo se ha implementado para cumplir con la definición de la interfaz ArrayAccess

```php
public function readAttribute( string $attribute );
```

Lee un valor de atributo por su nombre

```php
echo $robot->readAttribute("name");
```

```php
public function setDirtyState( int $dirtyState ): ModelInterface | bool;
```

Establece el estado del objeto actual

```php
public function toArray(): array;
```

Devuelve la instancia como una representación de vector

```php
public function writeAttribute( string $attribute, mixed $value ): void;
```

Escribe un valor de atributo por su nombre

```php
$robot->writeAttribute("name", "Rosey");
```

<h1 id="mvc-model-transaction">Class Phalcon\Mvc\Model\Transaction</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Transaction.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Phalcon\Di\DiInterface, Phalcon\Mvc\ModelInterface, Phalcon\Mvc\Model\Transaction\Failed, Phalcon\Mvc\Model\Transaction\ManagerInterface, Phalcon\Mvc\Model\TransactionInterface | | Implements | TransactionInterface |

Phalcon\Mvc\Model\Transaction

Las transacciones son bloques protectores donde las sentencias SQL solo son permanentes si todas pueden tener éxito como una acción atómica. Phalcon\Transaction está destinado a ser usado con Phalcon_Model_Base. Phalcon Transactions se debería crear usando Phalcon\Transaction\Manager.

```php
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\Model\Transaction\Manager;

try {
    $manager = new Manager();

    $transaction = $manager->get();

    $robot = new Robots();

    $robot->setTransaction($transaction);

    $robot->name       = "WALL·E";
    $robot->created_at = date("Y-m-d");

    if ($robot->save() === false) {
        $transaction->rollback("Can't save robot");
    }

    $robotPart = new RobotParts();

    $robotPart->setTransaction($transaction);

    $robotPart->type = "head";

    if ($robotPart->save() === false) {
        $transaction->rollback("Can't save robot part");
    }

    $transaction->commit();
} catch(Failed $e) {
    echo "Failed, reason: ", $e->getMessage();
}
```

## Propiedades

```php
//
protected activeTransaction = false;

//
protected connection;

//
protected isNewTransaction = true;

//
protected manager;

//
protected messages;

//
protected rollbackRecord;

//
protected rollbackOnAbort = false;

//
protected rollbackThrowException = false;

```

## Métodos

```php
public function __construct( DiInterface $container, bool $autoBegin = bool, string $service = string );
```

Constructor Phalcon\Mvc\Model\Transaction

```php
public function begin(): bool;
```

Inicia la transacción

```php
public function commit(): bool;
```

Confirma la transacción

```php
public function getConnection(): \Phalcon\Db\Adapter\AdapterInterface;
```

Devuelve la conexión relacionada con la transacción

```php
public function getMessages(): array;
```

Devuelve mensajes de validación desde el último intento de guardado

```php
public function isManaged(): bool;
```

Comprueba si la transacción es administrada por un gestor de transacciones

```php
public function isValid(): bool;
```

Comprueba si la conexión interna está bajo una transacción activa

```php
public function rollback( string $rollbackMessage = null, ModelInterface $rollbackRecord = null ): bool;
```

Deshace la transacción

```php
public function setIsNewTransaction( bool $isNew ): void;
```

Establece si es una transacción reutilizada o nueva

```php
public function setRollbackOnAbort( bool $rollbackOnAbort ): void;
```

Establece la opción de cancelación al abortar la conexión HTTP

```php
public function setRollbackedRecord( ModelInterface $record ): void;
```

Establece el objeto que genera la acción de deshacer

```php
public function setTransactionManager( ManagerInterface $manager ): void;
```

Establece el gestor de transacciones relacionado con la transacción

```php
public function throwRollbackException( bool $status ): TransactionInterface;
```

Permite lanzar excepciones

<h1 id="mvc-model-transaction-exception">Class Phalcon\Mvc\Model\Transaction\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Transaction/Exception.zep)

| Namespace | Phalcon\Mvc\Model\Transaction | | Extends | \Phalcon\Mvc\Model\Exception |

Phalcon\Mvc\Model\Transaction\Exception

Las excepciones lanzadas en Phalcon\Mvc\Model\Transaction usarán esta clase

<h1 id="mvc-model-transaction-failed">Class Phalcon\Mvc\Model\Transaction\Failed</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Transaction/Failed.zep)

| Namespace | Phalcon\Mvc\Model\Transaction | | Uses | Phalcon\Messages\MessageInterface, Phalcon\Mvc\ModelInterface | | Extends | Exception |

Phalcon\Mvc\Model\Transaction\Failed

Esta clase será lanzada para salir de un bloque try/catch para transacciones aisladas

## Propiedades

```php
//
protected record;

```

## Métodos

```php
public function __construct( string $message, ModelInterface $record = null );
```

Constructor Phalcon\Mvc\Model\Transaction\Failed

```php
public function getRecord(): ModelInterface;
```

Devuelve mensajes de validación de registro que detienen la transacción

```php
public function getRecordMessages(): MessageInterface[];
```

Devuelve mensajes de validación de registro que detienen la transacción

<h1 id="mvc-model-transaction-manager">Class Phalcon\Mvc\Model\Transaction\Manager</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Transaction/Manager.zep)

| Namespace | Phalcon\Mvc\Model\Transaction | | Uses | Phalcon\Di, Phalcon\Di\DiInterface, Phalcon\Di\InjectionAwareInterface, Phalcon\Mvc\Model\Transaction, Phalcon\Mvc\Model\TransactionInterface | | Implements | ManagerInterface, InjectionAwareInterface |

Phalcon\Mvc\Model\Transaction\Manager

Una transacción actúa en una única conexión de base de datos. Si tienes múltiples bases de datos específicas de clase, la transacción no protegerá la interacción entre ellas.

Esta clase administra los objetos que componen una transacción. Una transacción produce una conexión única que se pasa a cada objeto parte de la transacción.

```php
use Phalcon\Mvc\Model\Transaction\Failed;
use Phalcon\Mvc\Model\Transaction\Manager;

try {
   $transactionManager = new Manager();

   $transaction = $transactionManager->get();

   $robot = new Robots();

   $robot->setTransaction($transaction);

   $robot->name       = "WALL·E";
   $robot->created_at = date("Y-m-d");

   if ($robot->save() === false) {
       $transaction->rollback("Can't save robot");
   }

   $robotPart = new RobotParts();

   $robotPart->setTransaction($transaction);

   $robotPart->type = "head";

   if ($robotPart->save() === false) {
       $transaction->rollback("Can't save robot part");
   }

   $transaction->commit();
} catch (Failed $e) {
   echo "Failed, reason: ", $e->getMessage();
}
```

## Propiedades

```php
//
protected container;

//
protected initialized = false;

//
protected number = 0;

//
protected rollbackPendent = true;

//
protected service = db;

/**
 * @var array
 */
protected transactions;

```

## Métodos

```php
public function __construct( DiInterface $container = null );
```

Constructor Phalcon\Mvc\Model\Transaction\Manager

```php
public function collectTransactions(): void;
```

Eliminar todas las transacciones del gestor

```php
public function commit();
```

Confirma las transacciones activas dentro del gestor

```php
public function get( bool $autoBegin = bool ): TransactionInterface;
```

Devuelve una nueva \Phalcon\Mvc\Model\Transaction o una ya creada Este método registra una función de apagado para deshacer las conexiones activas

```php
public function getDI(): DiInterface;
```

Devuelve el contenedor de inyección de dependencias

```php
public function getDbService(): string;
```

Devuelve el servicio de base de datos usado para aislar la transacción

```php
public function getOrCreateTransaction( bool $autoBegin = bool ): TransactionInterface;
```

Crear/Devuelve una nueva transacción o una existente

```php
public function getRollbackPendent(): bool;
```

Compruebe si el gestor de transacciones está registrando una función de apagado para limpiar transacciones pendientes

```php
public function has(): bool;
```

Comprueba si el gestor tiene una transacción activa

```php
public function notifyCommit( TransactionInterface $transaction ): void;
```

Notifica al gestor sobre una transacción confirmada

```php
public function notifyRollback( TransactionInterface $transaction ): void;
```

Notifica al gestor sobre una transacción deshecha

```php
public function rollback( bool $collect = bool ): void;
```

Deshace las transacciones activas dentro del gestor La recogida eliminará la transacción del gestor

```php
public function rollbackPendent(): void;
```

Deshace las transacciones activas dentro del gestor

```php
public function setDI( DiInterface $container ): void;
```

Establece el contenedor de inyección de dependencias

```php
public function setDbService( string $service ): ManagerInterface;
```

Establece el servicio de base de datos usado para ejecutar las transacciones aisladas

```php
public function setRollbackPendent( bool $rollbackPendent ): ManagerInterface;
```

Establece si el gestor de transacciones debe registrar una función de apagado para limpiar transacciones pendientes

```php
protected function collectTransaction( TransactionInterface $transaction ): void;
```

Elimina las transacciones del TransactionManager

<h1 id="mvc-model-transaction-managerinterface">Interface Phalcon\Mvc\Model\Transaction\ManagerInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/Transaction/ManagerInterface.zep)

| Namespace | Phalcon\Mvc\Model\Transaction | | Uses | Phalcon\Mvc\Model\TransactionInterface |

Phalcon\Mvc\Model\Transaction\ManagerInterface

Interfaz para Phalcon\Mvc\Model\Transaction\Manager

## Métodos

```php
public function collectTransactions(): void;
```

Eliminar todas las transacciones del gestor

```php
public function commit();
```

Confirma las transacciones activas dentro del gestor

```php
public function get( bool $autoBegin = bool ): TransactionInterface;
```

Devuelve un nuevo \Phalcon\Mvc\Model\Transaction o uno ya creado

```php
public function getDbService(): string;
```

Devuelve el servicio de base de datos usado para aislar la transacción

```php
public function getRollbackPendent(): bool;
```

Compruebe si el gestor de transacciones está registrando una función de apagado para limpiar transacciones pendientes

```php
public function has(): bool;
```

Comprueba si el gestor tiene una transacción activa

```php
public function notifyCommit( TransactionInterface $transaction ): void;
```

Notifica al gestor sobre una transacción confirmada

```php
public function notifyRollback( TransactionInterface $transaction ): void;
```

Notifica al gestor sobre una transacción deshecha

```php
public function rollback( bool $collect = bool ): void;
```

Deshace las transacciones activas dentro del gestor La recogida eliminará la transacción del gestor

```php
public function rollbackPendent(): void;
```

Deshace las transacciones activas dentro del gestor

```php
public function setDbService( string $service ): ManagerInterface;
```

Establece el servicio de base de datos usado para ejecutar las transacciones aisladas

```php
public function setRollbackPendent( bool $rollbackPendent ): ManagerInterface;
```

Establece si el gestor de transacciones debe registrar una función de apagado para limpiar transacciones pendientes

<h1 id="mvc-model-transactioninterface">Interface Phalcon\Mvc\Model\TransactionInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/TransactionInterface.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Phalcon\Mvc\ModelInterface, Phalcon\Mvc\Model\Transaction\ManagerInterface |

Phalcon\Mvc\Model\TransactionInterface

Interfaz para Phalcon\Mvc\Model\Transaction

## Métodos

```php
public function begin(): bool;
```

Inicia la transacción

```php
public function commit(): bool;
```

Confirma la transacción

```php
public function getConnection(): \Phalcon\Db\Adapter\AdapterInterface;
```

Devuelve la conexión relacionada con la transacción

```php
public function getMessages(): array;
```

Devuelve mensajes de validación desde el último intento de guardado

```php
public function isManaged(): bool;
```

Comprueba si la transacción es administrada por un gestor de transacciones

```php
public function isValid(): bool;
```

Comprueba si la conexión interna está bajo una transacción activa

```php
public function rollback( string $rollbackMessage = null, ModelInterface $rollbackRecord = null ): bool;
```

Deshace la transacción

```php
public function setIsNewTransaction( bool $isNew ): void;
```

Establece si es una transacción reutilizada o nueva

```php
public function setRollbackOnAbort( bool $rollbackOnAbort ): void;
```

Establece la opción de cancelación al abortar la conexión HTTP

```php
public function setRollbackedRecord( ModelInterface $record ): void;
```

Establece el objeto que genera la acción de deshacer

```php
public function setTransactionManager( ManagerInterface $manager ): void;
```

Establece el gestor de transacciones relacionado con la transacción

```php
public function throwRollbackException( bool $status ): TransactionInterface;
```

Permite lanzar excepciones

<h1 id="mvc-model-validationfailed">Class Phalcon\Mvc\Model\ValidationFailed</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Model/ValidationFailed.zep)

| Namespace | Phalcon\Mvc\Model | | Uses | Phalcon\Mvc\ModelInterface | | Extends | Exception |

Phalcon\Mvc\Model\ValidationFailed

Esta excepción se genera cuando un modelo falla al guardar un registro Se debe configurar Phalcon\Mvc\Model para tener este comportamiento

## Propiedades

```php
//
protected messages;

//
protected model;

```

## Métodos

```php
public function __construct( ModelInterface $model, array $validationMessages );
```

Constructor Phalcon\Mvc\Model\ValidationFailed

```php
public function getMessages(): Message[];
```

Devuelve el grupo completo de mensajes producidos en la validación

```php
public function getModel(): ModelInterface;
```

Devuelve el modelo que generó los mensajes

<h1 id="mvc-modelinterface">Interface Phalcon\Mvc\ModelInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/ModelInterface.zep)

| Namespace | Phalcon\Mvc | | Uses | Phalcon\Db\Adapter\AdapterInterface, Phalcon\Di\DiInterface, Phalcon\Messages\MessageInterface, Phalcon\Mvc\Model\CriteriaInterface, Phalcon\Mvc\Model\MetaDataInterface, Phalcon\Mvc\Model\ResultsetInterface, Phalcon\Mvc\Model\TransactionInterface |

Phalcon\Mvc\ModelInterface

Interfaz para Phalcon\Mvc\Model

## Métodos

```php
public function appendMessage( MessageInterface $message ): ModelInterface;
```

Añade un mensaje personalizado a un proceso de validación

```php
public function assign( array $data, mixed $whiteList = null, mixed $dataColumnMap = null ): ModelInterface;
```

Asigna valores a un modelo desde un vector

```php
public static function average( mixed $parameters = null ): double | ResultsetInterface;
```

Permite calcular el valor promedio de una columna que coincida con las condiciones especificadas

```php
public static function cloneResult( ModelInterface $base, array $data, int $dirtyState = int ): ModelInterface;
```

Asigna valores a un modelo desde un vector devolviendo un nuevo modelo

```php
public static function cloneResultMap( mixed $base, array $data, mixed $columnMap, int $dirtyState = int, bool $keepSnapshots = null ): ModelInterface;
```

Asigna valores a un modelo desde un vector devolviendo un nuevo modelo

```php
public static function cloneResultMapHydrate( array $data, mixed $columnMap, int $hydrationMode );
```

Devuelve un resultado hidratado basado en los datos y el mapa de columnas

```php
public static function count( mixed $parameters = null ): int | ResultsetInterface;
```

Permite contar cuántos registros coinciden con las condiciones especificadas

Devuelve un entero para consultas simples o una instancia de ResultsetInterface para cuando se utiliza la condición GROUP. Los resultados contendrán el contador de cada grupo.

```php
public function create(): bool;
```

Inserta una instancia de modelo. Si la instancia ya existe en la persistencia lanzará una excepción. Devuelve `true` en caso de éxito o `false` en caso contrario.

```php
public function delete(): bool;
```

Borra una instancia del modelo. Devuelve `true` en caso de éxito o `false` en caso contrario.

```php
public static function find( mixed $parameters = null ): ResultsetInterface;
```

Permite consultar un conjunto de registros que coinciden con las condiciones especificadas

```php
public static function findFirst( mixed $parameters = null ): mixed | null;
```

Permite consultar el primer registro que coincide con las condiciones especificadas

```php
public function fireEvent( string $eventName ): bool;
```

Dispara un evento, llama implícitamente a comportamientos y se notifica a los oyentes del gestor de eventos

```php
public function fireEventCancel( string $eventName ): bool;
```

Dispara un evento, llama implícitamente a comportamientos y se notifica a los oyentes del gestor de eventos. Este método se detiene si alguna de las funciones de retorno/oyentes devuelve false

```php
public function getDirtyState(): int;
```

Devuelve una de las constantes DIRTY_STATE_* que indica si el registro existe en la base de datos o no

```php
public function getMessages(): MessageInterface[];
```

Devuelve un vector de mensajes de validación

```php
public function getModelsMetaData(): MetaDataInterface;
```

Devuelve el servicio de metadatos de los modelos relacionados a la instancia de entidad.

```php
public function getOperationMade(): int;
```

Devuelve el tipo de la operación realizada por el ORM más reciente. Devuelve una de las constantes de clase OP_*

```php
public function getReadConnection(): AdapterInterface;
```

Obtiene la conexión interna de base de datos

```php
public function getReadConnectionService(): string;
```

Devuelve el servicio de conexión DependencyInjection usado para leer datos

```php
public function getRelated( string $alias, mixed $arguments = null );
```

Devuelve registros relacionados basados en relaciones definidas

```php
public function getSchema(): string;
```

Devuelve el nombre del esquema donde se encuentra la tabla mapeada

```php
public function getSource(): string;
```

Devuelve el nombre de tabla mapeado en el modelo

```php
public function getWriteConnection(): AdapterInterface;
```

Obtiene la conexión interna de base de datos

```php
public function getWriteConnectionService(): string;
```

Devuelve el servicio de conexión DependencyInjection usado para escribir datos

```php
public static function maximum( mixed $parameters = null ): mixed;
```

Permite obtener el valor máximo de una columna que coincida con las condiciones especificadas

```php
public static function minimum( mixed $parameters = null ): mixed;
```

Permite obtener el valor mínimo de una columna que coincida con las condiciones especificadas

```php
public static function query( DiInterface $container = null ): CriteriaInterface;
```

Crea un criterio para un modelo específico

```php
public function refresh(): ModelInterface;
```

Refresca los atributos del modelo consultando otra vez el registro desde la base de datos

```php
public function save(): bool;
```

Inserta o actualiza una instancia de modelo. Devuelve `true` en caso de éxito o `false` en caso contrario.

```php
public function setConnectionService( string $connectionService ): void;
```

Establecer ambos servicios de conexión de lectura/escritura

```php
public function setDirtyState( int $dirtyState ): ModelInterface | bool;
```

Establece el estado de suciedad del objeto usando una de las constantes DIRTY_STATE_*

```php
public function setReadConnectionService( string $connectionService ): void;
```

Establece el servicio de conexión DependencyInjection usado para leer datos

```php
public function setSnapshotData( array $data, mixed $columnMap = null ): void;
```

Establece los datos de instantánea del registro. Este método se usa internamente para establecer los datos de instantánea cuando el modelo fue configurado para mantener datos de instantánea

```php
public function setTransaction( TransactionInterface $transaction ): ModelInterface;
```

Establece una transacción relacionada con la instancia del modelo

```php
public function setWriteConnectionService( string $connectionService ): void;
```

Establece el servicio de conexión DependencyInjection usado para escribir datos

```php
public function skipOperation( bool $skip ): void;
```

Omite la operación actual forzando un estado de éxito

```php
public static function sum( mixed $parameters = null ): double | ResultsetInterface;
```

Permite calcular una suma sobre una columna que coincida con las condiciones especificadas

```php
public function update(): bool;
```

Actualiza una instancia de modelo. Si la instancia no existe en la persistencia lanzará una excepción. Devuelve `true` en caso de éxito o `false` en caso contrario.

```php
public function validationHasFailed(): bool;
```

Comprueba si el proceso de validación ha generado algún mensaje

<h1 id="mvc-moduledefinitioninterface">Interface Phalcon\Mvc\ModuleDefinitionInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/ModuleDefinitionInterface.zep)

| Namespace | Phalcon\Mvc | | Uses | Phalcon\Di\DiInterface |

Phalcon\Mvc\ModuleDefinitionInterface

Se debe implementar esta interfaz por definiciones de módulo de clase

## Métodos

```php
public function registerAutoloaders( DiInterface $container = null );
```

Registra un autocargador relacionado con el módulo

```php
public function registerServices( DiInterface $container );
```

Registrar servicios relacionados con el módulo

<h1 id="mvc-router">Class Phalcon\Mvc\Router</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Router.zep)

| Namespace | Phalcon\Mvc | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface, Phalcon\Http\RequestInterface, Phalcon\Mvc\Router\Exception, Phalcon\Mvc\Router\GroupInterface, Phalcon\Mvc\Router\Route, Phalcon\Mvc\Router\RouteInterface | | Extends | AbstractInjectionAware | | Implements | RouterInterface, EventsAwareInterface |

Phalcon\Mvc\Router

Phalcon\Mvc\Router es el enrutador estándar del framework. Enrutamiento es el proceso de tomar un punto final URI (la parte del URI que viene después de la URL base) y descomponerlo en parámetros para determinar qué módulo, controlador y acción de ese controlador debería recibir la solicitud

```php
use Phalcon\Mvc\Router;

$router = new Router();

$router->add(
    "/documentation/{chapter}/{name}\.{type:[a-z]+}",
    [
        "controller" => "documentation",
        "action"     => "show",
    ]
);

$router->handle(
    "/documentation/1/examples.html"
);

echo $router->getControllerName();
```

## Constantes

```php
const POSITION_FIRST = 0;
const POSITION_LAST = 1;
```

## Propiedades

```php
//
protected action;

//
protected controller;

//
protected defaultAction;

//
protected defaultController;

//
protected defaultModule;

//
protected defaultNamespace;

//
protected defaultParams;

//
protected eventsManager;

//
protected keyRouteNames;

//
protected keyRouteIds;

//
protected matchedRoute;

//
protected matches;

//
protected module;

//
protected namespaceName;

//
protected notFoundPaths;

//
protected params;

//
protected removeExtraSlashes;

//
protected routes;

//
protected wasMatched = false;

```

## Métodos

```php
public function __construct( bool $defaultRoutes = bool );
```

Constructor Phalcon\Mvc\Router

```php
public function add( string $pattern, mixed $paths = null, mixed $httpMethods = null, mixed $position = static-constant-access ): RouteInterface;
```

Añade una ruta al enrutador sin ninguna restricción HTTP

```php
use Phalcon\Mvc\Router;

$router->add("/about", "About::index");

$router->add(
    "/about",
    "About::index",
    ["GET", "POST"]
);

$router->add(
    "/about",
    "About::index",
    ["GET", "POST"],
    Router::POSITION_FIRST
);
```

```php
public function addConnect( string $pattern, mixed $paths = null, mixed $position = static-constant-access ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es CONNECT

```php
public function addDelete( string $pattern, mixed $paths = null, mixed $position = static-constant-access ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es DELETE

```php
public function addGet( string $pattern, mixed $paths = null, mixed $position = static-constant-access ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es GET

```php
public function addHead( string $pattern, mixed $paths = null, mixed $position = static-constant-access ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es HEAD

```php
public function addOptions( string $pattern, mixed $paths = null, mixed $position = static-constant-access ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es OPTIONS

```php
public function addPatch( string $pattern, mixed $paths = null, mixed $position = static-constant-access ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es PATCH

```php
public function addPost( string $pattern, mixed $paths = null, mixed $position = static-constant-access ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es POST

```php
public function addPurge( string $pattern, mixed $paths = null, mixed $position = static-constant-access ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es PURGE (soporte Squid y Varnish)

```php
public function addPut( string $pattern, mixed $paths = null, mixed $position = static-constant-access ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es PUT

```php
public function addTrace( string $pattern, mixed $paths = null, mixed $position = static-constant-access ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es TRACE

```php
public function attach( RouteInterface $route, mixed $position = static-constant-access ): RouterInterface;
```

Adjunta un objeto `Route` a la pila de rutas.

```php
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Route;

class CustomRoute extends Route {
     // ...
}

$router = new Router();

$router->attach(
    new CustomRoute("/about", "About::index", ["GET", "HEAD"]),
    Router::POSITION_FIRST
);
```

```php
public function clear(): void;
```

Elimina todas las rutas predefinidas

```php
public function getActionName(): string;
```

Devuelve el nombre de la acción procesada

```php
public function getControllerName(): string;
```

Devuelve el nombre del controlador procesado

```php
public function getDefaults(): array;
```

Devuelve un vector de parámetros predeterminados

```php
public function getEventsManager(): ManagerInterface;
```

Devuelve el administrador de eventos interno

```php
public function getKeyRouteIds()
```

```php
public function getKeyRouteNames()
```

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
public function getNamespaceName(): string;
```

Devuelve el nombre del espacio de nombres procesado

```php
public function getParams(): array;
```

Devuelve los parámetros procesados

```php
public function getRouteById( mixed $id ): RouteInterface | bool;
```

Devuelve un objeto de ruta por su identidad

```php
public function getRouteByName( string $name ): RouteInterface | bool;
```

Devuelve un objeto de ruta por su nombre

```php
public function getRoutes(): RouteInterface[];
```

Devuelve todas las rutas definidas en el enrutador

```php
public function handle( string $uri ): void;
```

Gestiona la información de enrutamiento recibida del motor de reescritura

```php
// Passing a URL
$router->handle("/posts/edit/1");
```

```php
public function isExactControllerName(): bool;
```

Devuelve si el nombre del controlador no debe ser roto

```php
public function mount( GroupInterface $group ): RouterInterface;
```

Monta un grupo de rutas en el enrutador

```php
public function notFound( mixed $paths ): RouterInterface;
```

Establece un grupo de rutas que se devolverán cuando ninguna de las rutas definidas coincidan

```php
public function removeExtraSlashes( bool $remove ): RouterInterface;
```

Establece si el enrutador debe eliminar las barras adicionales en las rutas gestionadas

```php
public function setDefaultAction( string $actionName ): RouterInterface;
```

Establece el nombre de acción predeterminado

```php
public function setDefaultController( string $controllerName ): RouterInterface;
```

Establece el nombre predeterminado del controlador

```php
public function setDefaultModule( string $moduleName ): RouterInterface;
```

Establece el nombre del módulo predeterminado

```php
public function setDefaultNamespace( string $namespaceName ): RouterInterface;
```

Establece el nombre del espacio de nombres predeterminado

```php
public function setDefaults( array $defaults ): RouterInterface;
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
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

Establece el administrador de eventos

```php
public function setKeyRouteIds( $keyRouteIds )
```

```php
public function setKeyRouteNames( $keyRouteNames )
```

```php
public function wasMatched(): bool;
```

Comprueba si el enrutador coincide con alguna de las rutas definidas

<h1 id="mvc-router-annotations">Class Phalcon\Mvc\Router\Annotations</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Router/Annotations.zep)

| Namespace | Phalcon\Mvc\Router | | Uses | Phalcon\Di\DiInterface, Phalcon\Mvc\Router, Phalcon\Annotations\Annotation | | Extends | Router |

Phalcon\Mvc\Router\Annotations

Un enrutador que lee anotaciones de rutas desde clases/recursos

```php
use Phalcon\Mvc\Router\Annotations;

$di->setShared(
    "router",
    function() {
        // Use the annotations router
        $router = new Annotations(false);

        // This will do the same as above but only if the handled uri starts with /robots
        $router->addResource("Robots", "/robots");

        return $router;
    }
);
```

## Propiedades

```php
//
protected actionSuffix = Action;

//
protected actionPreformatCallback;

//
protected controllerSuffix = Controller;

//
protected handlers;

//
protected routePrefix;

```

## Métodos

```php
public function addModuleResource( string $module, string $handler, string $prefix = null ): Annotations;
```

Añade un recurso al manejador de anotaciones. Un recurso es una clase que contiene anotaciones de enrutamiento. La clase se encuentra en un módulo

```php
public function addResource( string $handler, string $prefix = null ): Annotations;
```

Añade un recurso al manejador de anotaciones. Un recurso es una clase que contiene anotaciones de enrutamiento

```php
public function getActionPreformatCallback();
```

```php
public function getResources(): array;
```

Devuelve los recursos registrados

```php
public function handle( string $uri ): void;
```

Produce los parámetros de enrutamiento desde la información de reescritura

```php
public function processActionAnnotation( string $module, string $namespaceName, string $controller, string $action, Annotation $annotation );
```

Comprueba las anotaciones en los métodos públicos del controlador

```php
public function processControllerAnnotation( string $handler, Annotation $annotation );
```

Comprueba las anotaciones en el docblock del controlador

```php
public function setActionPreformatCallback( mixed $callback = null );
```

Establece aquí la llamada de retorno de preformato de la acción $action ya sin el sufijo 'Action'

```php
// Array as callback
$annotationRouter->setActionPreformatCallback([Text::class, 'uncamelize']);

// Function as callback
$annotationRouter->setActionPreformatCallback(function(action){
    return action;
});

// String as callback
$annotationRouter->setActionPreformatCallback('strtolower');

// If empty method constructor called [null], sets uncamelize with - delimiter
$annotationRouter->setActionPreformatCallback();
```

```php
public function setActionSuffix( string $actionSuffix );
```

Cambia el sufijo del método de acción

```php
public function setControllerSuffix( string $controllerSuffix );
```

Cambia el sufijo de la clase del controlador

<h1 id="mvc-router-exception">Class Phalcon\Mvc\Router\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Router/Exception.zep)

| Namespace | Phalcon\Mvc\Router | | Extends | \Phalcon\Exception |

Phalcon\Mvc\Router\Exception

Las excepciones lanzadas en Phalcon\Mvc\Router usarán esta clase

<h1 id="mvc-router-group">Class Phalcon\Mvc\Router\Group</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Router/Group.zep)

| Namespace | Phalcon\Mvc\Router | | Implements | GroupInterface |

Phalcon\Mvc\Router\Group

Clase auxiliar para crear un grupo de rutas con atributos comunes

```php
$router = new \Phalcon\Mvc\Router();

//Create a group with a common module and controller
$blog = new Group(
    [
        "module"     => "blog",
        "controller" => "index",
    ]
);

//All the routes start with /blog
$blog->setPrefix("/blog");

//Add a route to the group
$blog->add(
    "/save",
    [
        "action" => "save",
    ]
);

//Add another route to the group
$blog->add(
    "/edit/{id}",
    [
        "action" => "edit",
    ]
);

//This route maps to a controller different than the default
$blog->add(
    "/blog",
    [
        "controller" => "about",
        "action"     => "index",
    ]
);

//Add the group to the router
$router->mount($blog);
```

## Propiedades

```php
//
protected beforeMatch;

//
protected hostname;

//
protected paths;

//
protected prefix;

//
protected routes;

```

## Métodos

```php
public function __construct( mixed $paths = null );
```

Constructor Phalcon\Mvc\Router\Group

```php
public function add( string $pattern, mixed $paths = null, mixed $httpMethods = null ): RouteInterface;
```

Añade una ruta al enrutador en cualquier método HTTP

```php
$router->add("/about", "About::index");
```

```php
public function addConnect( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es CONNECT

```php
public function addDelete( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es DELETE

```php
public function addGet( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es GET

```php
public function addHead( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es HEAD

```php
public function addOptions( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es OPTIONS

```php
public function addPatch( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es PATCH

```php
public function addPost( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es POST

```php
public function addPurge( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es PURGE

```php
public function addPut( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es PUT

```php
public function addTrace( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es TRACE

```php
public function beforeMatch( callable $beforeMatch ): GroupInterface;
```

Establece una llamada de retorno que se llama si la ruta coincide. El desarrollador puede implementar cualquier condición arbitraria aquí. Si la función de retorno devuelve `false` la ruta será tratada como no coincidente

```php
public function clear(): void;
```

Elimina todas las rutas predefinidas

```php
public function getBeforeMatch(): callable;
```

Devuelve la función de retorno *'before match'* si la hay

```php
public function getHostname(): string;
```

Devuelve la restricción del nombre de host

```php
public function getPaths(): array | string;
```

Devuelve las rutas comunes definidas para este grupo

```php
public function getPrefix(): string;
```

Devuelve el prefijo común para todas las rutas

```php
public function getRoutes(): RouteInterface[];
```

Devuelve las rutas añadidas al grupo

```php
public function setHostname( string $hostname ): GroupInterface;
```

Establece una restricción de nombre de host para todas las rutas del grupo

```php
public function setPaths( mixed $paths ): GroupInterface;
```

Establece rutas comunes para todas las rutas del grupo

```php
public function setPrefix( string $prefix ): GroupInterface;
```

Establece un prefijo de uri común para todas las rutas de este grupo

```php
protected function addRoute( string $pattern, mixed $paths = null, mixed $httpMethods = null ): RouteInterface;
```

Añade una ruta aplicando los atributos comunes

<h1 id="mvc-router-groupinterface">Interface Phalcon\Mvc\Router\GroupInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Router/GroupInterface.zep)

| Namespace | Phalcon\Mvc\Router |

Phalcon\Mvc\Router\GroupInterface

```php
$router = new \Phalcon\Mvc\Router();

// Create a group with a common module and controller
$blog = new Group(
    [
        "module"     => "blog",
        "controller" => "index",
    ]
);

// All the routes start with /blog
$blog->setPrefix("/blog");

// Add a route to the group
$blog->add(
    "/save",
    [
        "action" => "save",
    ]
);

// Add another route to the group
$blog->add(
    "/edit/{id}",
    [
        "action" => "edit",
    ]
);

// This route maps to a controller different than the default
$blog->add(
    "/blog",
    [
        "controller" => "about",
        "action"     => "index",
    ]
);

// Add the group to the router
$router->mount($blog);
```

## Métodos

```php
public function add( string $pattern, mixed $paths = null, mixed $httpMethods = null ): RouteInterface;
```

Añade una ruta al enrutador en cualquier método HTTP

```php
router->add("/about", "About::index");
```

```php
public function addConnect( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es CONNECT

```php
public function addDelete( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es DELETE

```php
public function addGet( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es GET

```php
public function addHead( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es HEAD

```php
public function addOptions( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es OPTIONS

```php
public function addPatch( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es PATCH

```php
public function addPost( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es POST

```php
public function addPurge( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es PURGE

```php
public function addPut( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es PUT

```php
public function addTrace( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es TRACE

```php
public function beforeMatch( callable $beforeMatch ): GroupInterface;
```

Establece una llamada de retorno que se llama si la ruta coincide. El desarrollador puede implementar cualquier condición arbitraria aquí. Si la función de retorno devuelve `false` la ruta será tratada como no coincidente

```php
public function clear(): void;
```

Elimina todas las rutas predefinidas

```php
public function getBeforeMatch(): callable;
```

Devuelve la función de retorno *'before match'* si la hay

```php
public function getHostname(): string;
```

Devuelve la restricción del nombre de host

```php
public function getPaths(): array | string;
```

Devuelve las rutas comunes definidas para este grupo

```php
public function getPrefix(): string;
```

Devuelve el prefijo común para todas las rutas

```php
public function getRoutes(): RouteInterface[];
```

Devuelve las rutas añadidas al grupo

```php
public function setHostname( string $hostname ): GroupInterface;
```

Establece una restricción de nombre de host para todas las rutas del grupo

```php
public function setPaths( mixed $paths ): GroupInterface;
```

Establece rutas comunes para todas las rutas del grupo

```php
public function setPrefix( string $prefix ): GroupInterface;
```

Establece un prefijo de uri común para todas las rutas de este grupo

<h1 id="mvc-router-route">Class Phalcon\Mvc\Router\Route</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Router/Route.zep)

| Namespace | Phalcon\Mvc\Router | | Implements | RouteInterface |

Phalcon\Mvc\Router\Route

Esta clase representa cada ruta agregada al enrutador

## Propiedades

```php
//
protected beforeMatch;

//
protected compiledPattern;

//
protected converters;

//
protected group;

//
protected hostname;

//
protected id;

//
protected methods;

//
protected match;

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
public function __construct( string $pattern, mixed $paths = null, mixed $httpMethods = null );
```

Constructor Phalcon\Mvc\Router\Route

```php
public function beforeMatch( mixed $callback ): RouteInterface;
```

Establece una llamada de retorno que se llama si la ruta coincide. El desarrollador puede implementar cualquier condición arbitraria aquí. Si la función de retorno devuelve `false` la ruta será tratada como no coincidente

```php
$router->add(
    "/login",
    [
        "module"     => "admin",
        "controller" => "session",
    ]
)->beforeMatch(
    function ($uri, $route) {
        // Check if the request was made with Ajax
        if ($_SERVER["HTTP_X_REQUESTED_WITH"] === "xmlhttprequest") {
            return false;
        }

        return true;
    }
);
```

```php
public function compilePattern( string $pattern ): string;
```

Reemplaza los marcadores de posición del patrón devolviendo una expresión regular PCRE válida

```php
public function convert( string $name, mixed $converter ): RouteInterface;
```
{@inheritdoc}


```php
public function extractNamedParams( string $pattern ): array | bool;
```

Extrae parámetros de una cadena

```php
public function getBeforeMatch(): callable;
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
public function getGroup(): GroupInterface | null;
```

Devuelve el grupo asociado con la ruta

```php
public function getHostname(): string;
```

Devuelve la restricción del nombre de host si hay

```php
public function getHttpMethods(): array | string;
```

Devuelve los métodos HTTP que coinciden con la ruta

```php
public function getId()
```

```php
public function getMatch(): callable;
```

Devuelve la función de retorno *'match'* si la hay

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
public static function getRoutePaths( mixed $paths = null ): array;
```

Devuelve routePaths

```php
public function match( mixed $callback ): RouteInterface;
```

Permite establecer un función de retorno para manejar la solicitud directamente en la ruta

```php
$router->add(
    "/help",
    []
)->match(
    function () {
        return $this->getResponse()->redirect("https://support.google.com/", true);
    }
);
```

```php
public function reConfigure( string $pattern, mixed $paths = null ): void;
```

Reconfigura la ruta agregando un nuevo patrón y un conjunto de rutas

```php
public static function reset(): void;
```

Restablece el generador de identificador de ruta interno

```php
public function setGroup( GroupInterface $group ): RouteInterface;
```

Establece el grupo asociado a la ruta

```php
public function setHostname( string $hostname ): RouteInterface;
```

Establece una restricción de nombre de host a la ruta

```php
$route->setHostname("localhost");
```

```php
public function setHttpMethods( mixed $httpMethods ): RouteInterface;
```

Establece un conjunto de métodos HTTP que restringen la coincidencia de la ruta (alias de via)

```php
$route->setHttpMethods("GET");

$route->setHttpMethods(
    [
        "GET",
        "POST",
    ]
);
```

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

```php
public function via( mixed $httpMethods ): RouteInterface;
```

Establece uno o más métodos HTTP que restringen la coincidencia de la ruta

```php
$route->via("GET");

$route->via(
    [
        "GET",
        "POST",
    ]
);
```

<h1 id="mvc-router-routeinterface">Interface Phalcon\Mvc\Router\RouteInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/Router/RouteInterface.zep)

| Namespace | Phalcon\Mvc\Router |

Phalcon\Mvc\Router\RouteInterface

Interface for Phalcon\Mvc\Router\Route

## Métodos

```php
public function compilePattern( string $pattern ): string;
```

Reemplaza los marcadores de posición del patrón devolviendo una expresión regular PCRE válida

```php
public function convert( string $name, mixed $converter ): RouteInterface;
```

Agrega un convertidor para realizar una transformación adicional para cierto parámetro.

```php
public function getCompiledPattern(): string;
```

Devuelve el patrón de la ruta

```php
public function getHostname(): string;
```

Devuelve la restricción del nombre de host si hay

```php
public function getHttpMethods(): string | array;
```

Devuelve los métodos HTTP que coinciden con la ruta

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
public function setHostname( string $hostname ): RouteInterface;
```

Establece una restricción de nombre de host a la ruta

```php
public function setHttpMethods( mixed $httpMethods ): RouteInterface;
```

Establece un conjunto de métodos HTTP que restringen la coincidencia de la ruta

```php
public function setName( string $name ): RouteInterface;
```

Establece el nombre de la ruta

```php
public function via( mixed $httpMethods ): RouteInterface;
```

Establece uno o más métodos HTTP que restringen la coincidencia de la ruta

<h1 id="mvc-routerinterface">Interface Phalcon\Mvc\RouterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/RouterInterface.zep)

| Namespace | Phalcon\Mvc | | Uses | Phalcon\Mvc\Router\RouteInterface, Phalcon\Mvc\Router\GroupInterface |

Interfaz para Phalcon\Mvc\Router

## Métodos

```php
public function add( string $pattern, mixed $paths = null, mixed $httpMethods = null ): RouteInterface;
```

Añade una ruta al enrutador en cualquier método HTTP

```php
public function addConnect( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es CONNECT

```php
public function addDelete( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es DELETE

```php
public function addGet( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es GET

```php
public function addHead( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es HEAD

```php
public function addOptions( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es OPTIONS

```php
public function addPatch( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es PATCH

```php
public function addPost( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es POST

```php
public function addPurge( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es PURGE (soporte Squid y Varnish)

```php
public function addPut( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es PUT

```php
public function addTrace( string $pattern, mixed $paths = null ): RouteInterface;
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es TRACE

```php
public function attach( RouteInterface $route, mixed $position = static-constant-access ): RouterInterface;
```

Adjunta un objeto `Route` a la pila de rutas.

```php
public function clear(): void;
```

Elimina todas las rutas definidas

```php
public function getActionName(): string;
```

Devuelve el nombre de la acción procesada

```php
public function getControllerName(): string;
```

Devuelve el nombre del controlador procesado

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
public function getNamespaceName(): string;
```

Devuelve el nombre del espacio de nombres procesado

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
public function getRoutes(): RouteInterface[];
```

Devuelve todas las rutas definidas en el enrutador

```php
public function handle( string $uri ): void;
```

Gestiona la información de enrutamiento recibida del motor de reescritura

```php
public function mount( GroupInterface $group ): RouterInterface;
```

Monta un grupo de rutas en el enrutador

```php
public function setDefaultAction( string $actionName ): RouterInterface;
```

Establece el nombre de acción predeterminado

```php
public function setDefaultController( string $controllerName ): RouterInterface;
```

Establece el nombre predeterminado del controlador

```php
public function setDefaultModule( string $moduleName ): RouterInterface;
```

Establece el nombre del módulo predeterminado

```php
public function setDefaults( array $defaults ): RouterInterface;
```

Establece un vector de rutas por defecto

```php
public function wasMatched(): bool;
```

Comprueba si el enrutador coincide con alguna de las rutas definidas

<h1 id="mvc-view">Class Phalcon\Mvc\View</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/View.zep)

| Namespace | Phalcon\Mvc | | Uses | Closure, Phalcon\Di\DiInterface, Phalcon\Di\Injectable, Phalcon\Events\ManagerInterface, Phalcon\Helper\Arr, Phalcon\Helper\Str, Phalcon\Mvc\View\Exception, Phalcon\Events\EventsAwareInterface, Phalcon\Mvc\View\Engine\Php | | Extends | Injectable | | Implements | ViewInterface, EventsAwareInterface |

Phalcon\Mvc\View

Phalcon\Mvc\View es una clase para trabajar con la porción "vista" del patrón modelo-vista-controlador. Es decir, existe para ayudar a mantener el script de vistas separado de los scripts de modelos y controladores. Proporciona un sistema de ayudantes, filtros de salida y escape de variables.

```php
use Phalcon\Mvc\View;

$view = new View();

// Setting views directory
$view->setViewsDir("app/views/");

$view->start();

// Shows recent posts view (app/views/posts/recent.phtml)
$view->render("posts", "recent");
$view->finish();

// Printing views output
echo $view->getContent();
```

## Constantes

```php
const LEVEL_ACTION_VIEW = 1;
const LEVEL_AFTER_TEMPLATE = 4;
const LEVEL_BEFORE_TEMPLATE = 2;
const LEVEL_LAYOUT = 3;
const LEVEL_MAIN_LAYOUT = 5;
const LEVEL_NO_RENDER = 0;
```

## Propiedades

```php
//
protected actionName;

//
protected activeRenderPaths;

//
protected basePath = ;

//
protected content = ;

//
protected controllerName;

//
protected currentRenderLevel = 0;

//
protected disabled = false;

//
protected disabledLevels;

//
protected engines = false;

//
protected eventsManager;

//
protected layout;

//
protected layoutsDir = ;

//
protected mainView = index;

//
protected options;

//
protected params;

//
protected pickView;

//
protected partialsDir = ;

//
protected registeredEngines;

//
protected renderLevel = 5;

//
protected templatesAfter;

//
protected templatesBefore;

//
protected viewsDirs;

//
protected viewParams;

```

## Métodos

```php
public function __construct( array $options = [] );
```

Constructor Phalcon\Mvc\View

```php
public function __get( string $key ): mixed | null;
```

Método mágico para obtener las variables pasadas a la vista

```php
echo $this->view->products;
```

```php
public function __isset( string $key ): bool;
```

Método mágico para obtener si una variable está establecida en la vista

```php
echo isset($this->view->products);
```

```php
public function __set( string $key, mixed $value );
```

Método mágico para pasar variables a las vistas

```php
$this->view->products = $products;
```

```php
public function cleanTemplateAfter(): View;
```

Reestablece cualquier plantilla anterior de la disposición

```php
public function cleanTemplateBefore(): View;
```

Restablece cualquier disposición de "plantilla anterior"

```php
public function disable(): View;
```

Deshabilita el proceso de auto-renderizado

```php
public function disableLevel( mixed $level ): ViewInterface;
```

Deshabilita un nivel específico de renderizado

```php
// Render all levels except ACTION level
$this->view->disableLevel(
    View::LEVEL_ACTION_VIEW
);
```

```php
public function enable(): View;
```

Habilita el proceso de auto-renderizado

```php
public function exists( string $view ): bool;
```

Comprueba si existe la vista

```php
public function finish(): View;
```

Finaliza el proceso de renderizado deteniendo el búfer de salida

```php
public function getActionName(): string;
```

Obtiene el nombre de la acción renderizada

```php
public function getActiveRenderPath(): string | array;
```

Devuelve la ruta (o rutas) de las vistas que se están renderizando actualmente

```php
public function getBasePath(): string;
```

Obtiene la ruta base

```php
public function getContent(): string;
```

Devuelve la salida desde otra etapa de vista

```php
public function getControllerName(): string;
```

Obtiene el nombre del controlador renderizado

```php
public function getCurrentRenderLevel()
```

```php
public function getEventsManager(): ManagerInterface | null;
```

Devuelve el administrador de eventos interno

```php
public function getLayout(): string;
```

Obtiene el nombre de la vista principal

```php
public function getLayoutsDir(): string;
```

Obtiene los diseños actuales del subdirectorio

```php
public function getMainView(): string;
```

Obtiene el nombre de la vista principal

```php
public function getParamsToView(): array;
```

Obtiene los parámetros de las vistas

```php
public function getPartial( string $partialPath, mixed $params = null ): string;
```

Renderiza una vista parcial

```php
// Retrieve the contents of a partial
echo $this->getPartial("shared/footer");
```

```php
// Retrieve the contents of a partial with arguments
echo $this->getPartial(
    "shared/footer",
    [
        "content" => $html,
    ]
);
```

```php
public function getPartialsDir(): string;
```

Obtiene el subdirectorio actual de parciales

```php
public function getRegisteredEngines()
```

```php
public function getRender( string $controllerName, string $actionName, array $params = [], mixed $configCallback = null ): string;
```

Realiza el renderizado automático devolviendo la salida como una cadena

```php
$template = $this->view->getRender(
    "products",
    "show",
    [
        "products" => $products,
    ]
);
```

```php
public function getRenderLevel()
```

```php
public function getVar( string $key );
```

Devuelve un parámetro previamente establecido en la vista

```php
public function getViewsDir(): string | array;
```

Devuelve el directorio de las vistas

```php
public function isDisabled(): bool;
```

Si está habilitado el renderizado automático

```php
public function partial( string $partialPath, mixed $params = null );
```

Renderiza una vista parcial

```php
// Show a partial inside another view
$this->partial("shared/footer");
```

```php
// Show a partial inside another view with parameters
$this->partial(
    "shared/footer",
    [
        "content" => $html,
    ]
);
```

```php
public function pick( mixed $renderView ): View;
```

Elige una vista diferente a renderizar en vez del último-controlador/última-acción

```php
use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function saveAction()
    {
        // Do some save stuff...

        // Then show the list view
        $this->view->pick("products/list");
    }
}
```

```php
public function processRender( string $controllerName, string $actionName, array $params = [], bool $fireEvents = bool ): bool;
```

Procesa la vista y las plantillas; Dispara eventos si es necesario

```php
public function registerEngines( array $engines ): View;
```

Registra motores de plantillas

```php
$this->view->registerEngines(
    [
        ".phtml" => \Phalcon\Mvc\View\Engine\Php::class,
        ".volt"  => \Phalcon\Mvc\View\Engine\Volt::class,
        ".mhtml" => \MyCustomEngine::class,
    ]
);
```

```php
public function render( string $controllerName, string $actionName, array $params = [] ): View | bool;
```

Ejecuta el proceso de renderizado desde los datos de despacho

```php
// Shows recent posts view (app/views/posts/recent.phtml)
$view->start()->render("posts", "recent")->finish();
```

```php
public function reset(): View;
```

Resetea el componente vista a sus valores predeterminados de fábrica

```php
public function setBasePath( string $basePath ): View;
```

Establece la ruta base. Dependiendo de su plataforma, siempre añada una barra diagonal o barra invertida al final

```php
$view->setBasePath(__DIR__ . "/");
```

```php
public function setContent( string $content ): View;
```

Establece externamente el contenido de la vista

```php
$this->view->setContent("<h1>hello</h1>");
```

```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

Establece el administrador de eventos

```php
public function setLayout( string $layout ): View;
```

Cambia la disposición a usar en vez de usar el nombre del último nombre de controlador

```php
$this->view->setLayout("main");
```

```php
public function setLayoutsDir( string $layoutsDir ): View;
```

Establece el subdirectorio de disposiciones. Debe ser un directorio dentro del directorio de vistas. Dependiendo de su plataforma, siempre añada una barra diagonal o barra invertida al final

```php
$view->setLayoutsDir("../common/layouts/");
```

```php
public function setMainView( string $viewPath ): View;
```

Establece el nombre de la vista predeterminada. Debe ser un fichero sin extensión en el directorio de vistas

```php
// Renders as main view views-dir/base.phtml
$this->view->setMainView("base");
```

```php
public function setParamToView( string $key, mixed $value ): View;
```

Añade parámetros a las vistas (alias de setVar)

```php
$this->view->setParamToView("products", $products);
```

```php
public function setPartialsDir( string $partialsDir ): View;
```

Establece un subdirectorio de parciales. Debe ser un directorio dentro del directorio de vistas. Dependiendo de su plataforma, siempre añada una barra diagonal o barra invertida al final

```php
$view->setPartialsDir("../common/partials/");
```

```php
public function setRenderLevel( int $level ): ViewInterface;
```

Establece el nivel de renderizado de la vista

```php
// Render the view related to the controller only
$this->view->setRenderLevel(
    View::LEVEL_LAYOUT
);
```

```php
public function setTemplateAfter( mixed $templateAfter ): View;
```

Establece una disposición de controlador "plantilla posterior"

```php
public function setTemplateBefore( mixed $templateBefore ): View;
```

Establece una plantilla anterior a la disposición del controlador

```php
public function setVar( string $key, mixed $value ): View;
```

Establece un parámetro de vista único

```php
$this->view->setVar("products", $products);
```

```php
public function setVars( array $params, bool $merge = bool ): View;
```

Establece todos los parámetros de renderizado

```php
$this->view->setVars(
    [
        "products" => $products,
    ]
);
```

```php
public function setViewsDir( mixed $viewsDir ): View;
```

Establece el directorio de las vistas. Dependiendo de su plataforma, siempre añada una barra diagonal o barra invertida al final

```php
public function start(): View;
```

Inicia el proceso de renderizado habilitando el búfer de salida

```php
public function toString( string $controllerName, string $actionName, array $params = [] ): string;
```

Renderiza la vista y la devuelve como una cadena

```php
protected function engineRender( array $engines, string $viewPath, bool $silence, bool $mustClean = bool );
```

Comprueba si la vista existe en las extensiones registradas y la renderiza

```php
protected function getViewsDirs(): array;
```

Devuelve los directorios de las vistas

```php
final protected function isAbsolutePath( string $path );
```

Comprueba si una ruta es absoluta o no

```php
protected function loadTemplateEngines(): array;
```

Carga motores de plantilla registrados, si no hay ninguno registrado usará Phalcon\Mvc\View\Engine\Php

<h1 id="mvc-view-engine-abstractengine">Abstract Class Phalcon\Mvc\View\Engine\AbstractEngine</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/View/Engine/AbstractEngine.zep)

| Namespace | Phalcon\Mvc\View\Engine | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\Injectable, Phalcon\Mvc\ViewBaseInterface | | Extends | Injectable | | Implements | EngineInterface |

Todos los adaptadores del motor de plantillas deben heredar esta clase. Esto proporciona interfaz básica entre el motor y el componente Phalcon\Mvc\View.

## Propiedades

```php
//
protected view;

```

## Métodos

```php
public function __construct( ViewBaseInterface $view, DiInterface $container = null );
```

Constructor Phalcon\Mvc\View\Engine

```php
public function getContent(): string;
```

Devuelve la salida almacenada en caché en otra etapa de visualización

```php
public function getView(): ViewBaseInterface;
```

Devuelve el componente de vista relacionados con el adaptador

```php
public function partial( string $partialPath, mixed $params = null ): void;
```

Representa una vista parcial dentro de otro punto de vista

<h1 id="mvc-view-engine-engineinterface">Interface Phalcon\Mvc\View\Engine\EngineInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/View/Engine/EngineInterface.zep)

| Namespace | Phalcon\Mvc\View\Engine |

Interfaz para los adaptadores de motor Phalcon\Mvc\View

## Métodos

```php
public function getContent(): string;
```

Devuelve la salida almacenada en caché en otra etapa de visualización

```php
public function partial( string $partialPath, mixed $params = null ): void;
```

Representa una vista parcial dentro de otro punto de vista

```php
public function render( string $path, mixed $params, bool $mustClean = bool );
```

Renderiza una vista utilizando el motor de plantillas

<h1 id="mvc-view-engine-php">Class Phalcon\Mvc\View\Engine\Php</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/View/Engine/Php.zep)

| Namespace | Phalcon\Mvc\View\Engine | | Extends | AbstractEngine |

Adaptador para utilizar el mismo PHP como motor de plantillas

## Métodos

```php
public function render( string $path, mixed $params, bool $mustClean = bool );
```

Renderiza una vista utilizando el motor de plantillas

<h1 id="mvc-view-engine-volt">Class Phalcon\Mvc\View\Engine\Volt</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/View/Engine/Volt.zep)

| Namespace | Phalcon\Mvc\View\Engine | | Uses | Phalcon\Di\DiInterface, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface, Phalcon\Mvc\View\Engine\Volt\Compiler, Phalcon\Mvc\View\Exception | | Extends | AbstractEngine | | Implements | EventsAwareInterface |

Diseñador fácil y rápido motor de plantillas para PHP escrito en Zephir/C

## Propiedades

```php
//
protected compiler;

//
protected eventsManager;

//
protected macros;

//
protected options;

```

## Métodos

```php
public function callMacro( string $name, array $arguments = [] ): mixed;
```

Comprueba si una macro está definida y la llama

```php
public function convertEncoding( string $text, string $from, string $to ): string;
```

Realiza una conversión cadena

```php
public function getCompiler(): Compiler;
```

Devuelve el compilador del Volt

```php
public function getEventsManager(): ManagerInterface | null;
```

Devuelve el administrador de eventos interno

```php
public function getOptions(): array;
```

Obtener las opciones de Volt

```php
public function isIncluded( mixed $needle, mixed $haystack ): bool;
```

Comprueba si se incluye la aguja en el pajar

```php
public function length( mixed $item ): int;
```

Filtro de longitud. Si se pasa un objeto o matriz se realiza un `count()`, de lo contrario realiza un `strlen()<code>/`mb_strlen()</code>

```php
public function render( string $templatePath, mixed $params, bool $mustClean = bool );
```

Renderiza una vista utilizando el motor de plantillas

```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

Establece el administrador de eventos

```php
public function setOptions( array $options );
```

Establecer las opciones del Volt

```php
public function slice( mixed $value, int $start = int, mixed $end = null );
```

Extrae un trozo de un valor de un string/array/objecto iterable

```php
public function sort( array $value ): array;
```

Ordena una matriz

<h1 id="mvc-view-engine-volt-compiler">Class Phalcon\Mvc\View\Engine\Volt\Compiler</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/View/Engine/Volt/Compiler.zep)

| Namespace | Phalcon\Mvc\View\Engine\Volt | | Uses | Closure, Phalcon\Di\DiInterface, Phalcon\Mvc\ViewBaseInterface, Phalcon\Di\InjectionAwareInterface | | Implements | InjectionAwareInterface |

Esta clase lee y compila plantillas Volt a código PHP plano

```php
$compiler = new \Phalcon\Mvc\View\Engine\Volt\Compiler();

$compiler->compile("views/partials/header.volt");

require $compiler->getCompiledTemplatePath();
```

## Propiedades

```php
//
protected autoescape = false;

//
protected blockLevel = 0;

//
protected blocks;

//
protected container;

//
protected compiledTemplatePath;

//
protected currentBlock;

//
protected currentPath;

//
protected exprLevel = 0;

//
protected extended = false;

//
protected extensions;

//
protected extendedBlocks;

//
protected filters;

//
protected foreachLevel = 0;

//
protected forElsePointers;

//
protected functions;

//
protected level = 0;

//
protected loopPointers;

//
protected macros;

//
protected options;

//
protected prefix;

//
protected view;

```

## Métodos

```php
public function __construct( ViewBaseInterface $view = null );
```

Phalcon\Mvc\View\Engine\Volt\Compiler

```php
public function addExtension( mixed $extension ): Compiler;
```

Registra una extensión de Volt

```php
public function addFilter( string $name, mixed $definition ): Compiler;
```

Registra un nuevo filtro en el compilador

```php
public function addFunction( string $name, mixed $definition ): Compiler;
```

Registra una nueva función en el compilador

```php
public function attributeReader( array $expr ): string;
```

Resuelve la lectura de atributos

```php
public function compile( string $templatePath, bool $extendsMode = bool );
```

Compila una plantilla en un archivo aplicando las opciones del compilador Este método no devuelve la ruta compilada si la plantilla no fue compilada

```php
$compiler->compile("views/layouts/main.volt");

require $compiler->getCompiledTemplatePath();
```

```php
public function compileAutoEscape( array $statement, bool $extendsMode ): string;
```

Compila una sentencia "autoescape" devolviendo código PHP

```php
public function compileCache( array $statement, bool $extendsMode = bool ): string;
```

Compila una sentencia "cache" devolviendo código PHP

@deprecated Will be removed in 5.0 @todo Remove this in the next major version

```php
public function compileCall( array $statement, bool $extendsMode );
```

Compila llamadas a macros

```php
public function compileCase( array $statement, bool $caseClause = bool ): string;
```

Compila una cláusula "case"/"default" devolviendo código PHP

```php
public function compileDo( array $statement ): string;
```

Compila una sentencia "do" devolviendo código PHP

```php
public function compileEcho( array $statement ): string;
```

Compila una sentencia {% raw %}`{{` `}}`{% endraw %} devolviendo código PHP

```php
public function compileElseIf( array $statement ): string;
```

Compila una sentencia "elseif" devolviendo código PHP

```php
public function compileFile( string $path, string $compiledPath, bool $extendsMode = bool );
```

Compila una plantilla en un fichero forzando la ruta destino

```php
$compiler->compileFile(
    "views/layouts/main.volt",
    "views/layouts/main.volt.php"
);
```

```php
public function compileForElse(): string;
```

Genera un código PHP 'forelse'

```php
public function compileForeach( array $statement, bool $extendsMode = bool ): string;
```

Compila una representación intermedia de código "foreach" en código PHP plano

```php
public function compileIf( array $statement, bool $extendsMode = bool ): string;
```

Compila una sentencia 'if' devolviendo código PHP

```php
public function compileInclude( array $statement ): string;
```

Compila una sentencia 'include' devolviendo código PHP

```php
public function compileMacro( array $statement, bool $extendsMode ): string;
```

Compila macros

```php
public function compileReturn( array $statement ): string;
```

Compila una sentencia "return" devolviendo código PHP

```php
public function compileSet( array $statement ): string;
```

Compila una sentencia "set" devolviendo código PHP

```php
public function compileString( string $viewCode, bool $extendsMode = bool ): string;
```

Compila una plantilla en una cadena

```php
echo $compiler->compileString({% raw %}'{{ "hello world" }}'{% endraw %});
```

```php
public function compileSwitch( array $statement, bool $extendsMode = bool ): string;
```

Compila una sentencia 'switch' devolviendo código PHP

```php
final public function expression( array $expr ): string;
```

Resuelve un nodo de expresión en un árbol AST de Volt

```php
final public function fireExtensionEvent( string $name, mixed $arguments = null );
```

Dispara un evento a las extensiones registradas

```php
public function functionCall( array $expr ): string;
```

Resuelve el código intermedio de funciones en llamadas a funciones PHP

```php
public function getCompiledTemplatePath(): string;
```

Devuelve la ruta a la última plantilla compilada

```php
public function getDI(): DiInterface;
```

Devuelve el inyector de dependencias interno

```php
public function getExtensions(): array;
```

Devuelve la lista de extensiones registradas en Volt

```php
public function getFilters(): array;
```

Devuelve los filtros registrados por el usuario

```php
public function getFunctions(): array;
```

Devuelve las funciones registradas por el usuario

```php
public function getOption( string $option );
```

Devuelve la opción de un compilador

```php
public function getOptions(): array;
```

Devuelve las opciones del compilador

```php
public function getTemplatePath(): string;
```

Devuelve la ruta que está siendo compilada actualmente

```php
public function getUniquePrefix(): string;
```

Devuelve un prefijo único a usar como prefijo de las variables y contextos compilados

```php
public function parse( string $viewCode );
```

Analiza una plantilla Volt devolviendo su representación intermedia

```php
print_r(
    $compiler->parse("{% raw %}{{ 3 + 2 }}{% endraw %}")
);
```

```php
public function resolveTest( array $test, string $left ): string;
```

Resuelve el código intermedio de filtro en una expresión PHP válida

```php
public function setDI( DiInterface $container ): void;
```

Configura el inyector de dependencia

```php
public function setOption( string $option, mixed $value );
```

Establece una única opción del compilador

```php
public function setOptions( array $options );
```

Establece las opciones del compilador

```php
public function setUniquePrefix( string $prefix ): Compiler;
```

Establece un prefijo único a usar como prefijo de las variables compiladas

```php
protected function compileSource( string $viewCode, bool $extendsMode = bool ): string;
```

Compila un código fuente Volt devolviendo una versión plana en PHP

```php
protected function getFinalPath( string $path );
```

Obtiene la ruta final con VIEW

```php
final protected function resolveFilter( array $filter, string $left ): string;
```

Resuelve filtrar código intermedio en llamadas a funciones PHP

```php
final protected function statementList( array $statements, bool $extendsMode = bool ): string;
```

Recorre una lista de sentencias compilando cada uno de sus nodos

```php
final protected function statementListOrExtends( mixed $statements );
```

Compila un bloque de sentencias

<h1 id="mvc-view-engine-volt-exception">Class Phalcon\Mvc\View\Engine\Volt\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/View/Engine/Volt/Exception.zep)

| Namespace | Phalcon\Mvc\View\Engine\Volt | | Uses | Phalcon\Mvc\View\Exception | | Extends | BaseException |

Clase para excepciones lanzadas por Phalcon\Mvc\View

## Propiedades

```php
//
protected statement;

```

## Métodos

```php
public function __construct( string $message = string, array $statement = [], int $code = int, \Exception $previous = null );
```

```php
public function getStatement(): array;
```

Obtiene la instrucción analizada (si existe).

<h1 id="mvc-view-exception">Class Phalcon\Mvc\View\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/View/Exception.zep)

| Namespace | Phalcon\Mvc\View | | Extends | \Phalcon\Exception |

Phalcon\Mvc\View\Exception

Clase para excepciones lanzadas por Phalcon\Mvc\View

<h1 id="mvc-view-simple">Class Phalcon\Mvc\View\Simple</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/View/Simple.zep)

| Namespace | Phalcon\Mvc\View | | Uses | Closure, Phalcon\Di\DiInterface, Phalcon\Di\Injectable, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface, Phalcon\Helper\Arr, Phalcon\Helper\Str, Phalcon\Mvc\ViewBaseInterface, Phalcon\Mvc\View\Engine\EngineInterface, Phalcon\Mvc\View\Engine\Php | | Extends | Injectable | | Implements | ViewBaseInterface, EventsAwareInterface |

Phalcon\Mvc\View\Simple

Este componente permite renderizar vistas sin niveles jerárquicos

```php
use Phalcon\Mvc\View\Simple as View;

$view = new View();

// Render a view
echo $view->render(
    "templates/my-view",
    [
        "some" => $param,
    ]
);

// Or with filename with extension
echo $view->render(
    "templates/my-view.volt",
    [
        "parameter" => $here,
    ]
);
```

## Propiedades

```php
//
protected activeRenderPath;

//
protected content;

/**
 * @var \Phalcon\Mvc\View\EngineInterface[]|false
 */
protected engines = false;

//
protected eventsManager;

//
protected options;

//
protected partialsDir;

/**
 * @var array|null
 */
protected registeredEngines;

//
protected viewsDir;

//
protected viewParams;

```

## Métodos

```php
public function __construct( array $options = [] );
```

Constructor Phalcon\Mvc\View\Simple

```php
public function __get( string $key ): mixed | null;
```

Método mágico para obtener las variables pasadas a la vista

```php
echo $this->view->products;
```

```php
public function __set( string $key, mixed $value );
```

Método mágico para pasar variables a las vistas

```php
$this->view->products = $products;
```

```php
public function getActiveRenderPath(): string;
```

Devuelve la ruta de la vista que actualmente se está renderizando

```php
public function getContent(): string;
```

Devuelve la salida desde otra etapa de vista

```php
public function getEventsManager(): ManagerInterface | null;
```

Devuelve el administrador de eventos interno

```php
public function getParamsToView(): array;
```

Obtiene los parámetros de las vistas

```php
public function getRegisteredEngines(): array|null
```

```php
public function getVar( string $key ): mixed | null;
```

Devuelve un parámetro previamente establecido en la vista

```php
public function getViewsDir(): string;
```

Devuelve el directorio de las vistas

```php
public function partial( string $partialPath, mixed $params = null );
```

Renderiza una vista parcial

```php
// Show a partial inside another view
$this->partial("shared/footer");
```

```php
// Show a partial inside another view with parameters
$this->partial(
    "shared/footer",
    [
        "content" => $html,
    ]
);
```

```php
public function registerEngines( array $engines );
```

Registra motores de plantillas

```php
$this->view->registerEngines(
    [
        ".phtml" => \Phalcon\Mvc\View\Engine\Php::class,
        ".volt"  => \Phalcon\Mvc\View\Engine\Volt::class,
        ".mhtml" => \MyCustomEngine::class,
    ]
);
```

```php
public function render( string $path, array $params = [] ): string;
```

Renderiza una vista

```php
public function setContent( string $content ): Simple;
```

Establece externamente el contenido de la vista

```php
$this->view->setContent("<h1>hello</h1>");
```

```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

Establece el administrador de eventos

```php
public function setParamToView( string $key, mixed $value ): Simple;
```

Añade parámetros a las vistas (alias de setVar)

```php
$this->view->setParamToView("products", $products);
```

```php
public function setVar( string $key, mixed $value ): Simple;
```

Establece un parámetro de vista único

```php
$this->view->setVar("products", $products);
```

```php
public function setVars( array $params, bool $merge = bool ): Simple;
```

Establece todos los parámetros de renderizado

```php
$this->view->setVars(
    [
        "products" => $products,
    ]
);
```

```php
public function setViewsDir( string $viewsDir );
```

Establece el directorio de las vistas

```php
final protected function internalRender( string $path, mixed $params );
```

Intenta renderizar la vista con cada motor registrado en el componente

```php
protected function loadTemplateEngines(): array;
```

Carga los motores de plantilla registrados, si no hay ninguno registrado usará Phalcon\Mvc\View\Engine\Php

<h1 id="mvc-viewbaseinterface">Interface Phalcon\Mvc\ViewBaseInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/ViewBaseInterface.zep)

| Namespace | Phalcon\Mvc | | Uses | Phalcon\Cache\Adapter\AdapterInterface |

Phalcon\Mvc\ViewInterface

Interfaz para Phalcon\Mvc\View y Phalcon\Mvc\View\Simple

## Métodos

```php
public function getContent(): string;
```

Devuelve la salida almacenada en caché desde otra etapa de vista

```php
public function getParamsToView(): array;
```

Obtiene los parámetros de las vistas

```php
public function getViewsDir(): string | array;
```

Devuelve el directorio de las vistas

```php
public function partial( string $partialPath, mixed $params = null );
```

Renderiza una vista parcial

```php
public function setContent( string $content );
```

Establece externamente el contenido de la vista

```php
public function setParamToView( string $key, mixed $value );
```

Añade parámetros a las vistas (alias de setVar)

```php
public function setVar( string $key, mixed $value );
```

Añade parámetros a las vistas

```php
public function setViewsDir( string $viewsDir );
```

Establece el directorio de las vistas. Dependiendo de su plataforma, siempre añada una barra diagonal o barra invertida al final

<h1 id="mvc-viewinterface">Interface Phalcon\Mvc\ViewInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Mvc/ViewInterface.zep)

| Namespace | Phalcon\Mvc | | Extends | ViewBaseInterface |

Phalcon\Mvc\ViewInterface

Interfaz para Phalcon\Mvc\View

## Métodos

```php
public function cleanTemplateAfter();
```

Reestablece cualquier plantilla anterior de la disposición

```php
public function cleanTemplateBefore();
```

Reestablece cualquier plantilla anterior de la disposición

```php
public function disable();
```

Deshabilita el proceso de auto-renderizado

```php
public function enable();
```

Habilita el proceso de auto-renderizado

```php
public function finish();
```

Finaliza el proceso de renderizado deteniendo el búfer de salida

```php
public function getActionName(): string;
```

Obtiene el nombre de la acción renderizada

```php
public function getActiveRenderPath(): string | array;
```

Devuelve la ruta de la vista que actualmente se está renderizando

```php
public function getBasePath(): string;
```

Obtiene la ruta base

```php
public function getControllerName(): string;
```

Obtiene el nombre del controlador renderizado

```php
public function getLayout(): string;
```

Obtiene el nombre de la vista principal

```php
public function getLayoutsDir(): string;
```

Obtiene los diseños actuales del subdirectorio

```php
public function getMainView(): string;
```

Obtiene el nombre de la vista principal

```php
public function getPartialsDir(): string;
```

Obtiene el subdirectorio actual de parciales

```php
public function isDisabled(): bool;
```

Si está deshabilitado el renderizado automático

```php
public function pick( string $renderView );
```

Elige una vista diferente a renderizar en vez del último-controlador/última-acción

```php
public function registerEngines( array $engines );
```

Registra motores de plantillas

```php
public function render( string $controllerName, string $actionName, array $params = [] ): ViewInterface | bool;
```

Ejecuta el proceso de renderizado desde los datos de despacho

```php
public function reset();
```

Resetea el componente vista a sus valores predeterminados de fábrica

```php
public function setBasePath( string $basePath );
```

Establece la ruta base. Dependiendo de su plataforma, siempre añada una barra diagonal o barra invertida al final

```php
public function setLayout( string $layout );
```

Cambia la disposición a usar en vez de usar el nombre del último nombre de controlador

```php
public function setLayoutsDir( string $layoutsDir );
```

Establece el subdirectorio de disposiciones. Debe ser un directorio dentro del directorio de vistas. Dependiendo de su plataforma, siempre añada una barra diagonal o barra invertida al final

```php
public function setMainView( string $viewPath );
```

Establece el nombre de la vista predeterminada. Debe ser un fichero sin extensión en el directorio de vistas

```php
public function setPartialsDir( string $partialsDir );
```

Establece un subdirectorio de parciales. Debe ser un directorio dentro del directorio de vistas. Dependiendo de su plataforma, siempre añada una barra diagonal o barra invertida al final

```php
public function setRenderLevel( int $level ): ViewInterface;
```

Establece el nivel de renderizado de la vista

```php
public function setTemplateAfter( mixed $templateAfter );
```

Añade la plantilla después del diseño del controlador

```php
public function setTemplateBefore( mixed $templateBefore );
```

Añade la plantilla antes del diseño del controlador

```php
public function start();
```

Inicia el proceso de renderizado habilitando el búfer de salida
