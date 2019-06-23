---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Firewall'
---

* [Phalcon\Firewall\Adapter](#Firewall_Adapter)
* [Phalcon\Firewall\Adapter\Acl](#Firewall_Adapter_Acl)
* [Phalcon\Firewall\Adapter\Annotations](#Firewall_Adapter_Annotations)
* [Phalcon\Firewall\Adapter\Micro\Acl](#Firewall_Adapter_Micro_Acl)
* [Phalcon\Firewall\AdapterInterface](#Firewall_AdapterInterface)
* [Phalcon\Firewall\Exception](#Firewall_Exception)

<h1 id="Firewall_Adapter">Abstract Class Phalcon\Firewall\Adapter</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/firewall/adapter.zep)

| Namespace | Phalcon\Firewall | | Uses | Phalcon\Acl, Phalcon\Acl\RoleAware, Phalcon\Cache\Adapter\AdapterInterface, Phalcon\DiInterface, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface, Phalcon\Mvc\Dispatcher | | Implements | AdapterInterface, EventsAwareInterface |

Adapter for Phalcon\Firewall adapters

## Properties

```php
/**
 * Storing active identity object implementing Phalcon/Acl/RoleAware
 */
protected activeIdentity;

/**
 * Storing active user role
 */
protected activeRole;

/**
 * Should role always be resolved using role callback or just once?
 * @var bool
 */
protected alwaysResolvingRole = false;

/**
 * Cache for caching access
 * @var <CacheAdapterInterface>
 */
protected cache;

/**
 * Default access
 * @var int
 */
protected defaultAccess;

/**
 * Events manager
 * @var mixed
 */
protected eventsManager;

/**
 * Internal cache for caching access during request time
 * @var mixed
 */
protected internalCache;

/**
 * Anonymous function for getting user identity - this function must
 * return string, array or object implementing Phalcon\Acl\RoleAware
 * @var mixed
 */
protected roleCallback;

```

## メソッド

```php
public function getActiveIdentity()
```

```php
public function getActiveRole()
```

```php
public function getDefaultAccess(): int
```

```php
public function getEventsManager(): ManagerInterface;
```

内部イベントマネージャーを返します

```php
public function getRoleCallback(): \Closure;
```

Gets role callback to fetch role name

```php
public function isAlwaysResolvingRole(): bool;
```

Gets always resolving role option

```php
public function setAlwaysResolvingRole( bool $alwaysResolvingRole )
```

```php
public function setCache( mixed $cache ): AdapterInterface;
```

Sets the cache adapter

```php
public function setDefaultAccess( int $defaultAccess ): AdapterInterface;
```

Sets the default access level (Phalcon\Acl::ALLOW or Phalcon\Acl::DENY)

```php
public function setEventsManager( mixed $eventsManager ): AdapterInterface;
```

イベントマネージャーをセットします

```php
public function setRoleCallback( mixed $callback ): AdapterInterface;
```

Sets role callback to fetch role name

```php
protected function callRoleCallback( mixed $container ): void;
```

//

```php
protected function fireEventOrThrowException( mixed $role, string $actionName, string $controllerName, bool $access );
```

Fires event or throwing exception

```php
protected function getAccessFromCache( string $key, array $originalValues, string $roleCacheKey ): bool | null;
```

Gets access from cache

```php
protected function handleException( mixed $exception );
```

Handles a user exception

```php
protected function saveAccessInCache( string $key, bool $access ): void;
```

Saves access in cache and internal cache

```php
protected function throwFirewallException( string $message, int $exceptionCode ): bool;
```

Throws an internal exception

<h1 id="Firewall_Adapter_Acl">Class Phalcon\Firewall\Adapter\Acl</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/firewall/adapter/acl.zep)

| Namespace | Phalcon\Firewall\Adapter | | Uses | Phalcon\Di, Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Events\Event, Phalcon\Events\ManagerInterface, Phalcon\Firewall\Adapter, Phalcon\Firewall\Exception, Phalcon\Mvc\DispatcherInterface | | Extends | Adapter |

FirewallZ for Phalcon\Application which depends on acl and dispatcher

## Properties

```php
/**
 * Acl service name
 * @var string
 */
protected aclServiceName;

/**
 * Bound models
 * @var array
 */
protected boundModels;

/**
 * Property used for setting different key names in associated acl function than got from Binder
 */
protected boundModelsKeyMap;

/**
 * Dispatcher
 * @var mixed
 */
protected dispatcher;

/**
 * Parameter for using with multi module application
 * @var bool
 */
protected multiModuleConfiguration = false;

/**
 * Separator between module name and controller prefix
 * @var string
 */
protected moduleSeparator = :;

/**
 * Function returning string for role cache key
 * @var mixed
 */
protected roleCacheCallback;

```

## メソッド

```php
public function __construct( string $aclServiceName, array $boundModelsKeyMap );
```

Phalcon\Firewall\Adapter\Acl constructor

@param string aclServiceName @param array boundModelsKeyMap

```php
public function afterBinding( mixed $event, mixed $dispatcher, mixed $data );
```

//

```php
public function beforeExecuteRoute( mixed $event, mixed $dispatcher, mixed $data );
```

//

```php
public function getAclServiceName(): string
```

```php
public function getBoundModelsKeyMap()
```

```php
public function getDispatcher(): Dispatcher;
```

Gets dispatcher

```php
public function getModuleSeparator(): string
```

```php
public function getRoleCacheCallback(): mixed
```

```php
public function isMultiModuleConfiguration(): bool;
```

Returns multiModuleConfiguration

```php
public function setAclServiceName( string $aclServiceName )
```

```php
public function setBoundModelsKeyMap( $boundModelsKeyMap )
```

```php
public function setModuleSeparator( string $moduleSeparator )
```

```php
public function setRoleCacheCallback( mixed $roleCacheCallback )
```

```php
public function useMultiModuleConfiguration( bool $multiModuleConfiguration );
```

Sets multiModuleConfiguration

```php
protected function getAccessFromCache( string $key, array $originalValues, string $roleCacheKey ): bool | null;
```

//

```php
protected function handleDispatcher( mixed $dispatcher );
```

//

```php
protected function saveAccessInCache( string $key, bool $access ): void;
```

//

<h1 id="Firewall_Adapter_Annotations">Class Phalcon\Firewall\Adapter\Annotations</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/firewall/adapter/annotations.zep)

| Namespace | Phalcon\Firewall\Adapter | | Uses | Phalcon\Annotations\Adapter\AdapterInterface, Phalcon\Events\Event, Phalcon\Events\ManagerInterface, Phalcon\Firewall\Adapter, Phalcon\Firewall\Exception, Phalcon\Mvc\DispatcherInterface, ReflectionClass | | Extends | Adapter |

Firewall which depends on annotations and dispatcher

## Properties

```php
/**
 * Number of active active arguments in active annotation
 * @var int
 */
protected activeArgumentsNumber = 0;

/**
 * Adapter for annotations
 * @var mixed
 */
protected annotationsAdapter;

/**
 * Dispatcher
 * @var mixed
 */
protected dispatcher;

/**
 * Role for which access was granted
 */
protected resolvedRole;

```

## メソッド

```php
public function __construct( mixed $annotationsAdapter );
```

Phalcon\Firewall\Adapter\Annotations constructor

@param mixed annotationsAdapter

```php
public function beforeExecuteRoute( mixed $event, mixed $dispatcher, mixed $data );
```

//

```php
public function getAnnotationsAdapter(): mixed
```

```php
public function getDispatcher(): Dispatcher;
```

Gets dispatcher

```php
public function setAnnotationsAdapter( mixed $annotationsAdapter )
```

```php
protected function checkActionAnnotationAccess( string $controllerClass, string $controllerName, string $actionName, mixed $role );
```

//

```php
protected function checkAnnotations( mixed $annotations, mixed $role );
```

//

```php
protected function checkControllerAnnotationAccess( string $controllerClass, string $controllerName, mixed $role );
```

//

```php
protected function getAccessFromCache( string $key, array $originalValues, string $roleCacheKey ): bool | null;
```

//

```php
protected function handleAnnotation( mixed $annotation, bool $access, mixed $role );
```

//

<h1 id="Firewall_Adapter_Micro_Acl">Class Phalcon\Firewall\Adapter\Micro\Acl</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/firewall/adapter/micro/acl.zep)

| Namespace | Phalcon\Firewall\Adapter\Micro | | Uses | Phalcon\Di, Phalcon\Cache\Adapter\AdapterInterface, Phalcon\DiInterface, Phalcon\Events\Event, Phalcon\Events\ManagerInterface, Phalcon\Firewall\Adapter, Phalcon\Firewall\Exception, Phalcon\Mvc\Micro, Phalcon\Mvc\Model\BinderInterface, Phalcon\Mvc\Router | | Extends | Adapter |

Firewall for Phalcon\Mvc\Micro which depends on ACL

## Properties

```php
/**
 * Acl service name
 * @var string
 */
protected aclServiceName;

/**
 * Bound models
 * @var array
 */
protected boundModels;

/**
 * Property used for setting different key names in associated ACL function
 * than got from Binder
 */
protected boundModelsKeyMap;

/**
 * Component name used to acquire access, be default it's Micro
 * @var string
 */
protected componentName = Micro;

/**
 * Micro object
 * @var mixed
 */
protected micro;

/**
 * Function returning string for role cache key
 * @var mixed
 */
protected roleCacheCallback;

/**
 * Router object
 * @var mixed
 */
protected router;

/**
 * By default using route names which are required, you can change it to
 * false to use route patterns
 * @var bool
 */
protected routeNameConfiguration = true;

```

## メソッド

```php
public function __construct( string $aclServiceName, array $boundModelsKeyMap );
```

//

```php
public function afterBinding( mixed $event, mixed $micro, mixed $data );
```

//

```php
public function beforeExecuteRoute( mixed $event, mixed $micro, mixed $data );
```

//

```php
public function getAclServiceName(): string
```

```php
public function getBoundModelsKeyMap()
```

```php
public function getComponentName(): string
```

```php
public function getMicro(): Micro;
```

Gets micro

```php
public function getRoleCacheCallback(): mixed
```

```php
public function isRouteNameConfiguration(): bool;
```

Gets route name configuration

```php
public function setAclServiceName( string $aclServiceName )
```

```php
public function setBoundModelsKeyMap( $boundModelsKeyMap )
```

```php
public function setComponentName( string $componentName )
```

```php
public function setRoleCacheCallback( mixed $roleCacheCallback )
```

```php
public function setRouteNameConfiguration( bool $routeNameConfiguration )
```

```php
protected function fireEventOrThrowException( mixed $role, string $actionName, string $controllerName, bool $access );
```

Fires event or throwing exception

```php
protected function getAccessFromCache( string $key, array $originalValues, string $roleCacheKey ): bool | null;
```

//

```php
protected function handleRouter( mixed $micro );
```

//

```php
protected function saveAccessInCache( string $key, bool $access ): void;
```

//

<h1 id="Firewall_AdapterInterface">Interface Phalcon\Firewall\AdapterInterface</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/firewall/adapterinterface.zep)

| Namespace | Phalcon\Firewall | | Uses | Phalcon\Mvc\DispatcherInterface, Phalcon\Cache\Adapter\AdapterInterface |

Interface for Phalcon\Mvc\Dispatcher\Firewall adapters

## メソッド

```php
public function getDefaultAccess(): int;
```

Returns the default ACL access level

```php
public function getRoleCallback();
```

Gets role callback to fetch role name

```php
public function isAlwaysResolvingRole(): bool;
```

Gets always resolving role option

```php
public function setAlwaysResolvingRole( bool $alwaysResolvingRole ): void;
```

Sets always resolving role option

```php
public function setCache( mixed $cache ): AdapterInterface;
```

Sets cache backend

```php
public function setDefaultAccess( int $defaultAccess ): AdapterInterface;
```

Sets the default access level (Phalcon\Acl::ALLOW or Phalcon\Acl::DENY)

```php
public function setRoleCallback( mixed $callback ): AdapterInterface;
```

Sets role callback to fetch role name

<h1 id="Firewall_Exception">Class Phalcon\Firewall\Exception</h1>

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/firewall/exception.zep)

| Namespace | Phalcon\Firewall | | Extends | \Phalcon\Exception |

Exceptions thrown in Phalcon\Firewall will use this class