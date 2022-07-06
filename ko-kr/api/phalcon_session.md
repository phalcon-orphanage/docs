---
layout: default
language: 'ko-kr'
version: '5.0'
title: 'Phalcon\Session'
---

* [Phalcon\Session\Adapter\AbstractAdapter](#session-adapter-abstractadapter)
* [Phalcon\Session\Adapter\Libmemcached](#session-adapter-libmemcached)
* [Phalcon\Session\Adapter\Noop](#session-adapter-noop)
* [Phalcon\Session\Adapter\Redis](#session-adapter-redis)
* [Phalcon\Session\Adapter\Stream](#session-adapter-stream)
* [Phalcon\Session\Bag](#session-bag)
* [Phalcon\Session\BagInterface](#session-baginterface)
* [Phalcon\Session\Exception](#session-exception)
* [Phalcon\Session\Manager](#session-manager)
* [Phalcon\Session\ManagerInterface](#session-managerinterface)

<h1 id="session-adapter-abstractadapter">Abstract Class Phalcon\Session\Adapter\AbstractAdapter</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Session/Adapter/AbstractAdapter.zep)

| Namespace  | Phalcon\Session\Adapter | | Uses       | Phalcon\Storage\Adapter\AdapterInterface, SessionHandlerInterface | | Implements | SessionHandlerInterface |



## Properties
```php
/**
 * @var AdapterInterface
 */
protected adapter;

```

## Methods

```php
public function close(): bool;
```
Close


```php
public function destroy( mixed $sessionId ): bool;
```
Destroy


```php
public function gc( int $maxlifetime ): int | bool;
```
Garbage Collector


```php
public function open( mixed $savePath, mixed $sessionName ): bool;
```
Open


```php
public function read( mixed $sessionId ): string;
```
Read


```php
public function write( mixed $sessionId, mixed $data ): bool;
```
Write


```php
protected function getArrVal( array $collection, mixed $index, mixed $defaultValue = null ): mixed;
```
@todo Remove this when we get traits




<h1 id="session-adapter-libmemcached">Class Phalcon\Session\Adapter\Libmemcached</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Session/Adapter/Libmemcached.zep)

| Namespace  | Phalcon\Session\Adapter | | Uses       | Phalcon\Storage\AdapterFactory | | Extends    | AbstractAdapter |

Phalcon\Session\Adapter\Libmemcached


## Methods

```php
public function __construct( AdapterFactory $factory, array $options = [] );
```
Libmemcached constructor.




<h1 id="session-adapter-noop">Class Phalcon\Session\Adapter\Noop</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Session/Adapter/Noop.zep)

| Namespace  | Phalcon\Session\Adapter | | Uses       | SessionHandlerInterface | | Implements | SessionHandlerInterface |

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
 *
 * @var null
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

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function close(): bool;
```
Close


```php
public function destroy( mixed $sessionId ): bool;
```
Destroy


```php
public function gc( int $maxlifetime ): int | bool;
```
Garbage Collector


```php
public function open( mixed $savePath, mixed $sessionName ): bool;
```
Open


```php
public function read( mixed $sessionId ): string;
```
Read


```php
public function write( mixed $sessionId, mixed $data ): bool;
```
Write


```php
protected function getPrefixedName( mixed $name ): string;
```
Helper method to get the name prefixed




<h1 id="session-adapter-redis">Class Phalcon\Session\Adapter\Redis</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Session/Adapter/Redis.zep)

| Namespace  | Phalcon\Session\Adapter | | Uses       | Phalcon\Storage\AdapterFactory | | Extends    | AbstractAdapter |

Phalcon\Session\Adapter\Redis


## Methods

```php
public function __construct( AdapterFactory $factory, array $options = [] );
```
Constructor




<h1 id="session-adapter-stream">Class Phalcon\Session\Adapter\Stream</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Session/Adapter/Stream.zep)

| Namespace  | Phalcon\Session\Adapter | | Uses       | Phalcon\Session\Exception | | Extends    | Noop |

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

```php
public function __construct( array $options = [] );
```
Constructor


```php
public function destroy( mixed $sessionId ): bool;
```

```php
public function gc( int $maxlifetime ): int | bool;
```
Garbage Collector


```php
public function open( mixed $savePath, mixed $sessionName ): bool;
```
   Ignore the savePath and use local defined path


```php
public function read( mixed $sessionId ): string;
```
Reads data from the adapter


```php
public function write( mixed $sessionId, mixed $data ): bool;
```

```php
protected function getArrVal( array $collection, mixed $index, mixed $defaultValue = null, string $cast = null ): mixed;
```
@todo Remove this when we get traits


```php
protected function phpFileExists( string $filename );
```

```php
protected function phpFileGetContents( string $filename );
```

```php
protected function phpFilePutContents( string $filename, mixed $data, int $flags = int, mixed $context = null );
```

```php
protected function phpFopen( string $filename, string $mode );
```

```php
protected function phpIniGet( string $varname ): string;
```
Gets the value of a configuration option


```php
protected function phpIsWritable( string $filename ): bool;
```
Tells whether the filename is writable




<h1 id="session-bag">Class Phalcon\Session\Bag</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Session/Bag.zep)

| Namespace  | Phalcon\Session | | Uses       | Phalcon\Di\Di, Phalcon\Di\DiInterface, Phalcon\Di\InjectionAwareInterface, Phalcon\Session\ManagerInterface, Phalcon\Support\Collection | | Extends    | Collection | | Implements | BagInterface, InjectionAwareInterface |

Phalcon\Session\Bag

This component helps to separate session data into "namespaces". Working by this way you can easily create groups of session variables into the application

```php
$user = new \Phalcon\Session\Bag("user");

$user->name = "Kimbra Johnson";
$user->age  = 22;
```


## Properties
```php
/**
 * @var DiInterface|null
 */
private container;

/**
 * Session Bag name
 *
 * @var string
 */
private name;

/**
 * @var ManagerInterface
 */
private session;

```

## Methods

```php
public function __construct( ManagerInterface $session, string $name );
```

```php
public function clear(): void;
```
Destroys the session bag


```php
public function getDI(): DiInterface;
```
Returns the DependencyInjector container


```php
public function init( array $data = [] ): void;
```
Initialize internal array


```php
public function remove( string $element ): void;
```
Removes a property from the internal bag


```php
public function set( string $element, mixed $value ): void;
```
Sets a value in the session bag


```php
public function setDI( DiInterface $container ): void;
```
Sets the DependencyInjector container




<h1 id="session-baginterface">Interface Phalcon\Session\BagInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Session/BagInterface.zep)

| Namespace  | Phalcon\Session |

Phalcon\Session\BagInterface

Interface for Phalcon\Session\Bag


## Methods

```php
public function __get( string $element ): mixed;
```

```php
public function __isset( string $element ): bool;
```

```php
public function __set( string $element, mixed $value ): void;
```

```php
public function __unset( string $element ): void;
```

```php
public function clear(): void;
```

```php
public function get( string $element, mixed $defaultValue = null, string $cast = null ): mixed;
```

```php
public function has( string $element ): bool;
```

```php
public function init( array $data = [] ): void;
```

```php
public function remove( string $element ): void;
```

```php
public function set( string $element, mixed $value ): void;
```





<h1 id="session-exception">Class Phalcon\Session\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Session/Exception.zep)

| Namespace  | Phalcon\Session | | Extends    | \Exception |

Phalcon\Session\Exception

Exceptions thrown in Phalcon\Session will use this class



<h1 id="session-manager">Class Phalcon\Session\Manager</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Session/Manager.zep)

| Namespace  | Phalcon\Session | | Uses       | InvalidArgumentException, RuntimeException, SessionHandlerInterface, Phalcon\Di\AbstractInjectionAware, Phalcon\Di\DiInterface, Phalcon\Support\Helper\Arr\Get | | Extends    | AbstractInjectionAware | | Implements | ManagerInterface |

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

```php
public function __construct( array $options = [] );
```
Manager constructor.


```php
public function __get( string $key ): mixed;
```
Alias: Gets a session variable from an application context


```php
public function __isset( string $key ): bool;
```
Alias: Check whether a session variable is set in an application context


```php
public function __set( string $key, mixed $value ): void;
```
Alias: Sets a session variable in an application context


```php
public function __unset( string $key ): void;
```
Alias: Removes a session variable from an application context


```php
public function destroy(): void;
```
Destroy/end a session


```php
public function exists(): bool;
```
Check whether the session has been started


```php
public function get( string $key, mixed $defaultValue = null, bool $remove = bool ): mixed;
```
Gets a session variable from an application context


```php
public function getAdapter(): SessionHandlerInterface;
```
Returns the stored session adapter


```php
public function getId(): string;
```
Returns the session id


```php
public function getName(): string;
```
Returns the name of the session


```php
public function getOptions(): array;
```
Get internal options


```php
public function has( string $key ): bool;
```
Check whether a session variable is set in an application context


```php
public function regenerateId( bool $deleteOldSession = bool ): ManagerInterface;
```
Regenerates the session id using the adapter.


```php
public function remove( string $key ): void;
```
Removes a session variable from an application context


```php
public function set( string $key, mixed $value ): void;
```
Sets a session variable in an application context


```php
public function setAdapter( SessionHandlerInterface $adapter ): ManagerInterface;
```
Set the adapter for the session


```php
public function setId( string $sessionId ): ManagerInterface;
```
Set session Id


```php
public function setName( string $name ): ManagerInterface;
```
Set the session name. Throw exception if the session has started and do not allow poop names


```php
public function setOptions( array $options ): void;
```
Sets session's options


```php
public function start(): bool;
```
Starts the session (if headers are already sent the session will not be started)


```php
public function status(): int;
```
Returns the status of the current session.


```php
protected function phpHeadersSent(): bool;
```
Checks if or where headers have been sent




<h1 id="session-managerinterface">Interface Phalcon\Session\ManagerInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Session/ManagerInterface.zep)

| Namespace  | Phalcon\Session | | Uses       | InvalidArgumentException, RuntimeException, SessionHandlerInterface |

Phalcon\Session

Interface for the Phalcon\Session\Manager


## Constants
```php
const SESSION_ACTIVE = 2;
const SESSION_DISABLED = 0;
const SESSION_NONE = 1;
```

## Methods

```php
public function __get( string $key ): mixed;
```
Alias: Gets a session variable from an application context


```php
public function __isset( string $key ): bool;
```
Alias: Check whether a session variable is set in an application context


```php
public function __set( string $key, mixed $value ): void;
```
Alias: Sets a session variable in an application context


```php
public function __unset( string $key ): void;
```
Alias: Removes a session variable from an application context


```php
public function destroy(): void;
```
Destroy/end a session


```php
public function exists(): bool;
```
Check whether the session has been started


```php
public function get( string $key, mixed $defaultValue = null, bool $remove = bool ): mixed;
```
Gets a session variable from an application context


```php
public function getAdapter(): SessionHandlerInterface;
```
Returns the stored session adapter


```php
public function getId(): string;
```
Returns the session id


```php
public function getName(): string;
```
Returns the name of the session


```php
public function getOptions(): array;
```
Get internal options


```php
public function has( string $key ): bool;
```
Check whether a session variable is set in an application context


```php
public function regenerateId( bool $deleteOldSession = bool ): ManagerInterface;
```
Regenerates the session id using the adapter.


```php
public function remove( string $key ): void;
```
Removes a session variable from an application context


```php
public function set( string $key, mixed $value ): void;
```
Sets a session variable in an application context


```php
public function setAdapter( SessionHandlerInterface $adapter ): ManagerInterface;
```
Set the adapter for the session


```php
public function setId( string $sessionId ): ManagerInterface;
```
Set session Id


```php
public function setName( string $name ): ManagerInterface;
```
Set the session name. Throw exception if the session has started and do not allow poop names

@throws InvalidArgumentException


```php
public function setOptions( array $options ): void;
```
Sets session's options


```php
public function start(): bool;
```
Starts the session (if headers are already sent the session will not be started)


```php
public function status(): int;
```
Returns the status of the current session.


