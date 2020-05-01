---
layout: default
language: 'zh-cn'
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

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Session/Adapter/AbstractAdapter.zep)

| Namespace | Phalcon\Session\Adapter | | Uses | Phalcon\Storage\Adapter\AdapterInterface, SessionHandlerInterface | | Implements | SessionHandlerInterface |

This file is part of the Phalcon.

(c) Phalcon Team <team@phalcon.com>

For the full copyright and license information, please view the LICENSE file that was distributed with this source code.

## Properties

```php
/**
 * @var AdapterInterface
 */
protected adapter;

```

## Methods

Close

```php
public function close(): bool;
```

Destroy

```php
public function destroy( mixed $id ): bool;
```

Garbage Collector

```php
public function gc( mixed $maxlifetime ): bool;
```

Open

```php
public function open( mixed $savePath, mixed $sessionName ): bool;
```

Read

```php
public function read( mixed $id ): string;
```

Write

```php
public function write( mixed $id, mixed $data ): bool;
```

<h1 id="session-adapter-libmemcached">Class Phalcon\Session\Adapter\Libmemcached</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Session/Adapter/Libmemcached.zep)

| Namespace | Phalcon\Session\Adapter | | Uses | Phalcon\Storage\AdapterFactory | | Extends | AbstractAdapter |

Phalcon\Session\Adapter\Libmemcached

## Methods

Constructor

```php
public function __construct( AdapterFactory $factory, array $options = [] );
```

<h1 id="session-adapter-noop">Class Phalcon\Session\Adapter\Noop</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Session/Adapter/Noop.zep)

| Namespace | Phalcon\Session\Adapter | | Uses | SessionHandlerInterface | | Implements | SessionHandlerInterface |

Phalcon\Session\Adapter\Noop

This is an "empty" or null adapter. It can be used for testing or any other purpose that no session needs to be invoked

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Noop;

$session = new Manager();
$session->setAdapter(new Noop());
```

## Properties

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

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Close

```php
public function close(): bool;
```

Destroy

```php
public function destroy( mixed $id ): bool;
```

Garbage Collector

```php
public function gc( mixed $maxlifetime ): bool;
```

Open

```php
public function open( mixed $savePath, mixed $sessionName ): bool;
```

Read

```php
public function read( mixed $id ): string;
```

Write

```php
public function write( mixed $id, mixed $data ): bool;
```

Helper method to get the name prefixed

```php
protected function getPrefixedName( mixed $name ): string;
```

<h1 id="session-adapter-redis">Class Phalcon\Session\Adapter\Redis</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Session/Adapter/Redis.zep)

| Namespace | Phalcon\Session\Adapter | | Uses | Phalcon\Storage\AdapterFactory | | Extends | AbstractAdapter |

Phalcon\Session\Adapter\Redis

## Methods

Constructor

```php
public function __construct( AdapterFactory $factory, array $options = [] );
```

<h1 id="session-adapter-stream">Class Phalcon\Session\Adapter\Stream</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Session/Adapter/Stream.zep)

| Namespace | Phalcon\Session\Adapter | | Uses | Phalcon\Helper\Str, Phalcon\Session\Exception | | Extends | Noop |

Phalcon\Session\Adapter\Stream

This is the file based adapter. It stores sessions in a file based system

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

## Properties

```php
/**
 * @var string
 */
private path = ;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

```php
public function destroy( mixed $id ): bool;
```

```php
public function gc( mixed $maxlifetime ): bool;
```

Ignore the savePath and use local defined path

```php
public function open( mixed $savePath, mixed $sessionName ): bool;
```

```php
public function read( mixed $id ): string;
```

```php
public function write( mixed $id, mixed $data ): bool;
```

<h1 id="session-bag">Class Phalcon\Session\Bag</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Session/Bag.zep)

| Namespace | Phalcon\Session | | Uses | Phalcon\Collection, Phalcon\Di, Phalcon\Di\DiInterface, Phalcon\Di\InjectionAwareInterface | | Extends | Collection | | Implements | InjectionAwareInterface |

Phalcon\Session\Bag

This component helps to separate session data into "namespaces". Working by this way you can easily create groups of session variables into the application

```php
$user = new \Phalcon\Session\Bag("user");

$user->name = "Kimbra Johnson";
$user->age  = 22;
```

## Properties

```php
//
private container;

//
private name;

//
private session;

```

## Methods

Phalcon\Session\Bag constructor

```php
public function __construct( string $name );
```

Destroys the session bag

```php
public function clear(): void;
```

Returns the DependencyInjector container

```php
public function getDI(): DiInterface;
```

Removes a property from the internal bag

```php
public function init( array $data = [] ): void;
```

Removes a property from the internal bag

```php
public function remove( string $element ): void;
```

Sets a value in the session bag

```php
public function set( string $element, mixed $value ): void;
```

Sets the DependencyInjector container

```php
public function setDI( DiInterface $container ): void;
```

<h1 id="session-exception">Class Phalcon\Session\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Session/Exception.zep)

| Namespace | Phalcon\Session | | Extends | \Phalcon\Exception |

Phalcon\Session\Exception

Exceptions thrown in Phalcon\Session will use this class

<h1 id="session-manager">Class Phalcon\Session\Manager</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Session/Manager.zep)

| Namespace | Phalcon\Session | | Uses | InvalidArgumentException, RuntimeException, SessionHandlerInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Di\DiInterface, Phalcon\Helper\Arr | | Extends | AbstractInjectionAware | | Implements | ManagerInterface |

Phalcon\Session\Manager

Session manager class

## Properties

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

## Methods

Manager constructor.

```php
public function __construct( array $options = [] );
```

Alias: Gets a session variable from an application context

```php
public function __get( string $key ): mixed;
```

Alias: Check whether a session variable is set in an application context

```php
public function __isset( string $key ): bool;
```

Alias: Sets a session variable in an application context

```php
public function __set( string $key, mixed $value ): void;
```

Alias: Removes a session variable from an application context

```php
public function __unset( string $key ): void;
```

Destroy/end a session

```php
public function destroy(): void;
```

Check whether the session has been started

```php
public function exists(): bool;
```

Gets a session variable from an application context

```php
public function get( string $key, mixed $defaultValue = null, bool $remove = bool ): mixed;
```

Returns the stored session adapter

```php
public function getAdapter(): SessionHandlerInterface;
```

Returns the session id

```php
public function getId(): string;
```

Returns the name of the session

```php
public function getName(): string;
```

Get internal options

```php
public function getOptions(): array;
```

Check whether a session variable is set in an application context

```php
public function has( string $key ): bool;
```

Regenerates the session id using the adapter.

```php
public function regenerateId( mixed $deleteOldSession = bool ): ManagerInterface;
```

Removes a session variable from an application context

```php
public function remove( string $key ): void;
```

Sets a session variable in an application context

```php
public function set( string $key, mixed $value ): void;
```

Set the adapter for the session

```php
public function setAdapter( SessionHandlerInterface $adapter ): ManagerInterface;
```

Set session Id

```php
public function setId( string $id ): ManagerInterface;
```

Set the session name. Throw exception if the session has started and do not allow poop names

```php
public function setName( string $name ): ManagerInterface;
```

Sets session's options

```php
public function setOptions( array $options ): void;
```

Starts the session (if headers are already sent the session will not be started)

```php
public function start(): bool;
```

Returns the status of the current session.

```php
public function status(): int;
```

<h1 id="session-managerinterface">Interface Phalcon\Session\ManagerInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Session/ManagerInterface.zep)

| Namespace | Phalcon\Session | | Uses | InvalidArgumentException, RuntimeException, SessionHandlerInterface |

Phalcon\Session

Interface for the Phalcon\Session\Manager

## 常量

```php
const SESSION_ACTIVE = 2;
const SESSION_DISABLED = 0;
const SESSION_NONE = 1;
```

## Methods

Alias: Gets a session variable from an application context

```php
public function __get( string $key ): mixed;
```

Alias: Check whether a session variable is set in an application context

```php
public function __isset( string $key ): bool;
```

Alias: Sets a session variable in an application context

```php
public function __set( string $key, mixed $value ): void;
```

Alias: Removes a session variable from an application context

```php
public function __unset( string $key ): void;
```

Destroy/end a session

```php
public function destroy(): void;
```

Check whether the session has been started

```php
public function exists(): bool;
```

Gets a session variable from an application context

```php
public function get( string $key, mixed $defaultValue = null, bool $remove = bool ): mixed;
```

Returns the stored session adapter

```php
public function getAdapter(): SessionHandlerInterface;
```

Returns the session id

```php
public function getId(): string;
```

Returns the name of the session

```php
public function getName(): string;
```

Get internal options

```php
public function getOptions(): array;
```

Check whether a session variable is set in an application context

```php
public function has( string $key ): bool;
```

Regenerates the session id using the adapter.

```php
public function regenerateId( mixed $deleteOldSession = bool ): ManagerInterface;
```

Removes a session variable from an application context

```php
public function remove( string $key ): void;
```

Sets a session variable in an application context

```php
public function set( string $key, mixed $value ): void;
```

Set the adapter for the session

```php
public function setAdapter( SessionHandlerInterface $adapter ): ManagerInterface;
```

Set session Id

```php
public function setId( string $id ): ManagerInterface;
```

Set the session name. Throw exception if the session has started and do not allow poop names

@throws InvalidArgumentException

```php
public function setName( string $name ): ManagerInterface;
```

Sets session's options

```php
public function setOptions( array $options ): void;
```

Starts the session (if headers are already sent the session will not be started)

```php
public function start(): bool;
```

Returns the status of the current session.

```php
public function status(): int;
```