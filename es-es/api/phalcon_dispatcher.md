---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Dispatcher'
---

* [Phalcon\Dispatcher\AbstractDispatcher](#dispatcher-abstractdispatcher)
* [Phalcon\Dispatcher\DispatcherInterface](#dispatcher-dispatcherinterface)
* [Phalcon\Dispatcher\Exception](#dispatcher-exception)

<h1 id="dispatcher-abstractdispatcher">Abstract Class Phalcon\Dispatcher\AbstractDispatcher</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Dispatcher/AbstractDispatcher.zep)

| Namespace | Phalcon\Dispatcher | | Uses | Exception, Phalcon\Di\DiInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Dispatcher\Exception, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface, Phalcon\Filter\FilterInterface, Phalcon\Mvc\Model\Binder, Phalcon\Mvc\Model\BinderInterface | | Extends | AbstractInjectionAware | | Implements | DispatcherInterface, EventsAwareInterface |

Esta es la clase base para Phalcon\Mvc\Dispatcher y Phalcon\Cli\Dispatcher. Esta clase no puede se instanciada directamente, puedes usarla para crear tus propios despachadores.

## Propiedades

```php
//
protected activeHandler;

/**
 * @var array
 */
protected activeMethodMap;

//
protected actionName;

/**
 * @var string
 */
protected actionSuffix = Action;

/**
 * @var array
 */
protected camelCaseMap;

/**
 * @var string
 */
protected defaultAction = ;

//
protected defaultNamespace;

//
protected defaultHandler;

/**
 * @var array
 */
protected handlerHashes;

//
protected handlerName;

/**
 * @var string
 */
protected handlerSuffix = ;

//
protected eventsManager;

/**
 * @var bool
 */
protected finished = false;

/**
 * @var bool
 */
protected forwarded = false;

/**
 * @var bool
 */
protected isControllerInitialize = false;

//
protected lastHandler;

//
protected modelBinder;

/**
 * @var bool
 */
protected modelBinding = false;

//
protected moduleName;

//
protected namespaceName;

/**
 * @var array
 */
protected params;

//
protected previousActionName;

//
protected previousHandlerName;

//
protected previousNamespaceName;

//
protected returnedValue;

```

## Métodos

```php
public function callActionMethod( mixed $handler, string $actionMethod, array $params = [] );
```

```php
public function dispatch(): mixed | bool;
```

Procesa los resultados del enrutador llamando a la(s) acción(es) apropiadas del controlador incluyendo cualquier dato de enrutado o parámetros inyectados.

```php
public function forward( array $forward ): void;
```

Reenvía el flujo de ejecución a otro controlador/acción.

```php
$this->dispatcher->forward(
    [
        "controller" => "posts",
        "action"     => "index",
    ]
);
```

@throws \Phalcon\Exception

```php
public function getActionName(): string;
```

Obtiene el nombre de la última acción despachada

```php
public function getActionSuffix(): string;
```

Obtiene el sufijo de acción por defecto

```php
public function getActiveMethod(): string;
```

Devuelve el método actual a ser ejecutado en el despachador

```php
public function getBoundModels(): array;
```

Devuelve los modelos enlazados de la instancia del enlazador

```php
class UserController extends Controller
{
    public function showAction(User $user)
    {
        // return array with $user
        $boundModels = $this->dispatcher->getBoundModels();
    }
}
```

```php
public function getDefaultNamespace(): string;
```

Devuelve el espacio de nombres por defecto

```php
public function getEventsManager(): ManagerInterface;
```

Devuelve el administrador de eventos interno

```php
public function getHandlerClass(): string;
```

Posible nombre de clase que será localizada para despachar la petición

```php
public function getHandlerSuffix(): string;
```

Obtiene el sufijo del manejador por defecto

```php
public function getModelBinder(): BinderInterface | null;
```

Obtiene el enlazador del modelo

```php
public function getModuleName(): string;
```

Obtiene el módulo donde está la clase del controlador

```php
public function getNamespaceName(): string;
```

Obtiene el espacio de nombres a anteponer al nombre del manejador actual

```php
public function getParam( mixed $param, mixed $filters = null, mixed $defaultValue = null ): mixed;
```

Obtiene un parámetro por su nombre o índice numérico

```php
public function getParams(): array;
```

Obtiene los parámetros de la acción

```php
public function getReturnedValue(): mixed;
```

Devuelve el valor devuelto por la última acción despachada

```php
public function hasParam( mixed $param ): bool;
```

Comprueba si un parámetro existe

```php
public function isFinished(): bool;
```

Comprueba si el bucle de despacho se ha terminado o tiene más controladores/tareas pendientes de despachar

```php
public function setActionName( string $actionName ): void;
```

Establece el nombre de la acción a despachar

```php
public function setActionSuffix( string $actionSuffix ): void;
```

Establece el sufijo de acción por defecto

```php
public function setDefaultAction( string $actionName ): void;
```

Establece el nombre de acción predeterminado

```php
public function setDefaultNamespace( string $namespaceName ): void;
```

Establece el espacio de nombres por defecto

```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

Establece el administrador de eventos

```php
public function setHandlerSuffix( string $handlerSuffix ): void;
```

Establece el sufijo por defecto del manejador

```php
public function setModelBinder( BinderInterface $modelBinder, mixed $cache = null ): DispatcherInterface;
```

Habilita el enlazado de modelos durante el despacho

```php
$di->set(
    'dispatcher',
    function() {
        $dispatcher = new Dispatcher();

        $dispatcher->setModelBinder(
            new Binder(),
            'cache'
        );

        return $dispatcher;
    }
);
```

```php
public function setModuleName( string $moduleName ): void;
```

Establece el módulo donde está el controlador (sólo informativo)

```php
public function setNamespaceName( string $namespaceName ): void;
```

Establece el espacio de nombres donde está la clase controlador

```php
public function setParam( mixed $param, mixed $value ): void;
```

Establece un parámetro por su nombre o índice numérico

```php
public function setParams( array $params ): void;
```

Establece los parámetros de la acción a despachar

```php
public function setReturnedValue( mixed $value ): void;
```

Establece manualmente el último valor devuelto por una acción

```php
public function wasForwarded(): bool;
```

Comprueba si la acción ejecutada actual fue reenviada desde otra

```php
protected function resolveEmptyProperties(): void;
```

Establece propiedades vacías a sus valores por defecto (donde existan valores por defecto disponibles)

```php
protected function toCamelCase( string $input ): string;
```

<h1 id="dispatcher-dispatcherinterface">Interface Phalcon\Dispatcher\DispatcherInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Dispatcher/DispatcherInterface.zep)

| Namespace | Phalcon\Dispatcher |

Interface for Phalcon\Dispatcher\AbstractDispatcher

## Métodos

```php
public function dispatch(): mixed | bool;
```

Despacha una acción de manejo teniendo en cuenta los parámetros de enrutado

```php
public function forward( array $forward ): void;
```

Reenvía el flujo de ejecución a otro controlador/acción

```php
public function getActionName(): string;
```

Obtiene el nombre de la última acción despachada

```php
public function getActionSuffix(): string;
```

Obtiene el sufijo de acción por defecto

```php
public function getHandlerSuffix(): string;
```

Obtiene el sufijo del manejador por defecto

```php
public function getParam( mixed $param, mixed $filters = null ): mixed;
```

Obtiene un parámetro por su nombre o índice numérico

```php
public function getParams(): array;
```

Obtiene los parámetros de la acción

```php
public function getReturnedValue(): mixed;
```

Devuelve el valor devuelto por la última acción despachada

```php
public function hasParam( mixed $param ): bool;
```

Comprueba si un parámetro existe

```php
public function isFinished(): bool;
```

Comprueba si el bucle de despacho se ha terminado o tiene más controladores/tareas pendientes de despachar

```php
public function setActionName( string $actionName ): void;
```

Establece el nombre de la acción a despachar

```php
public function setActionSuffix( string $actionSuffix ): void;
```

Establece el sufijo de acción por defecto

```php
public function setDefaultAction( string $actionName ): void;
```

Establece el nombre de acción predeterminado

```php
public function setDefaultNamespace( string $defaultNamespace ): void;
```

Establece el espacio de nombres por defecto

```php
public function setHandlerSuffix( string $handlerSuffix ): void;
```

Establece el sufijo por defecto del manejador

```php
public function setModuleName( string $moduleName ): void;
```

Establece el nombre del módulo al que pertenece la aplicación

```php
public function setNamespaceName( string $namespaceName ): void;
```

Establece el espacio de nombres al que pertenece el controlador

```php
public function setParam( mixed $param, mixed $value ): void;
```

Establece un parámetro por su nombre o índice numérico

```php
public function setParams( array $params ): void;
```

Establece los parámetros de la acción a despachar

<h1 id="dispatcher-exception">Class Phalcon\Dispatcher\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Dispatcher/Exception.zep)

| Namespace | Phalcon\Dispatcher | | Extends | \Phalcon\Exception |

Las excepciones lanzadas en Phalcon\Dispatcher/* usarán esta clase

## Constantes

```php
const EXCEPTION_ACTION_NOT_FOUND = 5;
const EXCEPTION_CYCLIC_ROUTING = 1;
const EXCEPTION_HANDLER_NOT_FOUND = 2;
const EXCEPTION_INVALID_HANDLER = 3;
const EXCEPTION_INVALID_PARAMS = 4;
const EXCEPTION_NO_DI = 0;
```
