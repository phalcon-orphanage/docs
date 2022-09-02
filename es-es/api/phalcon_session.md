---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Session'
---

* [Phalcon\Session\Adapter\AbstractAdapter](#session-adapter-abstractadapter)
* [Phalcon\Session\Adapter\Libmemcached](#session-adapter-libmemcached)
* [Phalcon\Session\Adapter\Noop](#session-adapter-noop)
* [Phalcon\Session\Adapter\Redis](#session-adapter-redis)
* [Phalcon\Session\Adapter\Stream](#session-adapter-stream)
* [Phalcon\Session\Bag](#session-bag)
* [Phalcon\Session\Exception](#session-exception)
* [Phalcon\Session\Manager](#session-manager)
* [Phalcon\Session\ManagerInterface](#session-managerinterface)

<h1 id="session-adapter-abstractadapter">Abstract Class Phalcon\Session\Adapter\AbstractAdapter</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Session/Adapter/AbstractAdapter.zep)

| Namespace | Phalcon\Session\Adapter | | Uses | Phalcon\Storage\Adapter\AdapterInterface, SessionHandlerInterface | | Implements | SessionHandlerInterface |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.com>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE que se distribuyó con este código fuente.

## Propiedades

```php
/**
 * @var AdapterInterface
 */
protected adapter;

```

## Métodos

```php
public function close(): bool;
```

Cerrar

```php
public function destroy( mixed $id ): bool;
```

Destruir

```php
public function gc( mixed $maxlifetime ): bool;
```

Recolección de basura (GC)

```php
public function open( mixed $savePath, mixed $sessionName ): bool;
```

Abrir

```php
public function read( mixed $id ): string;
```

Leer

```php
public function write( mixed $id, mixed $data ): bool;
```

Escribir

<h1 id="session-adapter-libmemcached">Class Phalcon\Session\Adapter\Libmemcached</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Session/Adapter/Libmemcached.zep)

| Namespace | Phalcon\Session\Adapter | | Uses | Phalcon\Storage\AdapterFactory, Phalcon\Helper\Arr | | Extends | AbstractAdapter |

Phalcon\Session\Adapter\Libmemcached

## Métodos

```php
public function __construct( AdapterFactory $factory, array $options = [] );
```

Constructor

<h1 id="session-adapter-noop">Class Phalcon\Session\Adapter\Noop</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Session/Adapter/Noop.zep)

| Namespace | Phalcon\Session\Adapter | | Uses | SessionHandlerInterface | | Implements | SessionHandlerInterface |

Phalcon\Session\Adapter\Noop

Este es un adaptador "vacío" o nulo. It can be used for testing or any other purpose that no session needs to be invoked

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Noop;

$session = new Manager();
$session->setAdapter(new Noop());
```

## Propiedades

```php
/**
 * The connection of some adapters
 */
protected connection;

/**
 * Session options
 *
 * @var array
 */
protected options;

/**
 * Session prefix
 *
 * @var string
 */
protected prefix = ;

/**
 * Time To Live
 *
 * @var int
 */
protected ttl = 8600;

```

## Métodos

```php
public function __construct( array $options = [] );
```

Constructor

```php
public function close(): bool;
```

Cerrar

```php
public function destroy( mixed $id ): bool;
```

Destruir

```php
public function gc( mixed $maxlifetime ): bool;
```

Recolección de basura (GC)

```php
public function open( mixed $savePath, mixed $sessionName ): bool;
```

Abrir

```php
public function read( mixed $id ): string;
```

Leer

```php
public function write( mixed $id, mixed $data ): bool;
```

Escribir

```php
protected function getPrefixedName( mixed $name ): string;
```

Método auxiliar para obtener el prefijo del nombre

<h1 id="session-adapter-redis">Class Phalcon\Session\Adapter\Redis</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Session/Adapter/Redis.zep)

| Namespace | Phalcon\Session\Adapter | | Uses | Phalcon\Storage\AdapterFactory, Phalcon\Helper\Arr | | Extends | AbstractAdapter |

Phalcon\Session\Adapter\Redis

## Métodos

```php
public function __construct( AdapterFactory $factory, array $options = [] );
```

Constructor

<h1 id="session-adapter-stream">Class Phalcon\Session\Adapter\Stream</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Session/Adapter/Stream.zep)

| Namespace | Phalcon\Session\Adapter | | Uses | Phalcon\Helper\Str, Phalcon\Session\Exception | | Extends | Noop |

Phalcon\Session\Adapter\Stream

Este es el adaptador basado en ficheros. Almacena sesiones en un sistema basado en ficheros

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);
$session->setAdapter($files);
```

## Propiedades

```php
/**
 * @var string
 */
private path = ;

```

## Métodos

```php
public function __construct( array $options = [] );
```

Constructor

```php
public function destroy( mixed $id ): bool;
```

```php
public function gc( mixed $maxlifetime ): bool;
```

```php
public function open( mixed $savePath, mixed $sessionName ): bool;
```

Ignora savePath y usa la ruta local definida

```php
public function read( mixed $id ): string;
```

```php
public function write( mixed $id, mixed $data ): bool;
```

<h1 id="session-bag">Class Phalcon\Session\Bag</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Session/Bag.zep)

| Namespace | Phalcon\Session | | Uses | Phalcon\Collection, Phalcon\Di, Phalcon\Di\DiInterface, Phalcon\Di\InjectionAwareInterface | | Extends | Collection | | Implements | InjectionAwareInterface |

Phalcon\Session\Bag

Este componente ayuda a separar los datos de sesión en "namespaces". Trabajando de esta forma puede crear fácilmente grupos de variables de sesión en la aplicación

```php
$user = new \Phalcon\Session\Bag("user");

$user->name = "Kimbra Johnson";
$user->age  = 22;
```

## Propiedades

```php
//
private container;

//
private name;

//
private session;

```

## Métodos

```php
public function __construct( string $name );
```

Constructor Phalcon\Session\Bag

```php
public function clear(): void;
```

Destruye la bolsa de la sesión

```php
public function getDI(): DiInterface;
```

Devuelve el contenedor DependencyInjector

```php
public function init( array $data = [] ): void;
```

Inicializa el vector interno

```php
public function remove( string $element ): void;
```

Elimina una propiedad de la bolsa interna

```php
public function set( string $element, mixed $value ): void;
```

Establece un valor en la bolsa de sesión

```php
public function setDI( DiInterface $container ): void;
```

Configura el contenedor DependencyInjector

<h1 id="session-exception">Class Phalcon\Session\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Session/Exception.zep)

| Namespace | Phalcon\Session | | Extends | \Phalcon\Exception |

Phalcon\Session\Exception

Las excepciones lanzadas en Phalcon\Session usarán esta clase

<h1 id="session-manager">Class Phalcon\Session\Manager</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Session/Manager.zep)

| Namespace | Phalcon\Session | | Uses | InvalidArgumentException, RuntimeException, SessionHandlerInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Di\DiInterface, Phalcon\Helper\Arr | | Extends | AbstractInjectionAware | | Implements | ManagerInterface |

Phalcon\Session\Manager

Clase gestor de sesiones

## Propiedades

```php
/**
 * @var SessionHandlerInterface|null
 */
private adapter;

/**
 * @var string
 */
private name = ;

/**
 * @var array
 */
private options;

/**
 * @var string
 */
private uniqueId = ;

```

## Métodos

```php
public function __construct( array $options = [] );
```

Constructor del gestor.

```php
public function __get( string $key ): mixed;
```

Alias: obtiene una variable de sesión de un contexto de aplicación

```php
public function __isset( string $key ): bool;
```

Alias: comprueba si una variable de sesión se ha establecido en un contexto de aplicación

```php
public function __set( string $key, mixed $value ): void;
```

Alias: establece una variable de sesión en un contexto de aplicación

```php
public function __unset( string $key ): void;
```

Alias: elimina una variable de sesión de un contexto de aplicación

```php
public function destroy(): void;
```

Destruir/finalizar una sesión

```php
public function exists(): bool;
```

Comprueba si la sesión ha sido iniciada

```php
public function get( string $key, mixed $defaultValue = null, bool $remove = bool ): mixed;
```

Obtiene una variable de sesión de un contexto de aplicación

```php
public function getAdapter(): SessionHandlerInterface;
```

Devuelve el adaptador de sesión almacenado

```php
public function getId(): string;
```

Devuelve el id de sesión

```php
public function getName(): string;
```

Devuelve el nombre de la sesión

```php
public function getOptions(): array;
```

Obtiene opciones internas

```php
public function has( string $key ): bool;
```

Comprueba si una variable de sesión se ha establecido en un contexto de aplicación

```php
public function regenerateId( mixed $deleteOldSession = bool ): ManagerInterface;
```

Regenera el identificador de sesión usando el adaptador.

```php
public function remove( string $key ): void;
```

Elimina una variable de sesión de un contexto de aplicación

```php
public function set( string $key, mixed $value ): void;
```

Establece una variable de sesión en un contexto de aplicación

```php
public function setAdapter( SessionHandlerInterface $adapter ): ManagerInterface;
```

Establece el adaptador para la sesión

```php
public function setId( string $id ): ManagerInterface;
```

Establece el Id de la sesión

```php
public function setName( string $name ): ManagerInterface;
```

Establece el nombre de la sesión. Lanzar una excepción si la sesión ha iniciado y no permite nombres malos

```php
public function setOptions( array $options ): void;
```

Establece las opciones de la sesión

```php
public function start(): bool;
```

Inicia la sesión (si las cabeceras ya se enviaron, la sesión no iniciará)

```php
public function status(): int;
```

Devuelve el estado de la sesión actual.

<h1 id="session-managerinterface">Interface Phalcon\Session\ManagerInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Session/ManagerInterface.zep)

| Namespace | Phalcon\Session | | Uses | InvalidArgumentException, RuntimeException, SessionHandlerInterface |

Phalcon\Session

Interfaz para Phalcon\Session\Manager

## Constantes

```php
const SESSION_ACTIVE = 2;
const SESSION_DISABLED = 0;
const SESSION_NONE = 1;
```

## Métodos

```php
public function __get( string $key ): mixed;
```

Alias: obtiene una variable de sesión de un contexto de aplicación

```php
public function __isset( string $key ): bool;
```

Alias: comprueba si una variable de sesión se ha establecido en un contexto de aplicación

```php
public function __set( string $key, mixed $value ): void;
```

Alias: establece una variable de sesión en un contexto de aplicación

```php
public function __unset( string $key ): void;
```

Alias: elimina una variable de sesión de un contexto de aplicación

```php
public function destroy(): void;
```

Destruir/finalizar una sesión

```php
public function exists(): bool;
```

Comprueba si la sesión ha sido iniciada

```php
public function get( string $key, mixed $defaultValue = null, bool $remove = bool ): mixed;
```

Obtiene una variable de sesión de un contexto de aplicación

```php
public function getAdapter(): SessionHandlerInterface;
```

Devuelve el adaptador de sesión almacenado

```php
public function getId(): string;
```

Devuelve el id de sesión

```php
public function getName(): string;
```

Devuelve el nombre de la sesión

```php
public function getOptions(): array;
```

Obtiene opciones internas

```php
public function has( string $key ): bool;
```

Comprueba si una variable de sesión se ha establecido en un contexto de aplicación

```php
public function regenerateId( mixed $deleteOldSession = bool ): ManagerInterface;
```

Regenera el identificador de sesión usando el adaptador.

```php
public function remove( string $key ): void;
```

Elimina una variable de sesión de un contexto de aplicación

```php
public function set( string $key, mixed $value ): void;
```

Establece una variable de sesión en un contexto de aplicación

```php
public function setAdapter( SessionHandlerInterface $adapter ): ManagerInterface;
```

Establece el adaptador para la sesión

```php
public function setId( string $id ): ManagerInterface;
```

Establece el Id de la sesión

```php
public function setName( string $name ): ManagerInterface;
```

Establece el nombre de la sesión. Throw exception if the session has started and do not allow poop names

@throws InvalidArgumentException

```php
public function setOptions( array $options ): void;
```

Establece las opciones de la sesión

```php
public function start(): bool;
```

Starts the session (if headers are already sent the session will not be started)

```php
public function status(): int;
```

Devuelve el estado de la sesión actual.
