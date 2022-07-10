---
layout: default
language: 'uk-ua'
version: '5.0'
title: 'Phalcon\Cache'
---

* [Phalcon\Cache\AbstractCache](#cache-abstractcache)
* [Phalcon\Cache\Adapter\AdapterInterface](#cache-adapter-adapterinterface)
* [Phalcon\Cache\Adapter\Apcu](#cache-adapter-apcu)
* [Phalcon\Cache\Adapter\Libmemcached](#cache-adapter-libmemcached)
* [Phalcon\Cache\Adapter\Memory](#cache-adapter-memory)
* [Phalcon\Cache\Adapter\Redis](#cache-adapter-redis)
* [Phalcon\Cache\Adapter\Stream](#cache-adapter-stream)
* [Phalcon\Cache\AdapterFactory](#cache-adapterfactory)
* [Phalcon\Cache\Cache](#cache-cache)
* [Phalcon\Cache\CacheFactory](#cache-cachefactory)
* [Phalcon\Cache\CacheInterface](#cache-cacheinterface)
* [Phalcon\Cache\Exception\Exception](#cache-exception-exception)
* [Phalcon\Cache\Exception\InvalidArgumentException](#cache-exception-invalidargumentexception)

<h1 id="cache-abstractcache">Abstract Class Phalcon\Cache\AbstractCache</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/AbstractCache.zep)

| Namespace  | Phalcon\Cache | | Uses       | DateInterval, Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Cache\Exception\InvalidArgumentException, Traversable | | Implements | CacheInterface |

This component offers caching capabilities for your application. Phalcon\Cache implements PSR-16.

@property AdapterInterface $adapter


## Властивості
```php
/**
 * The adapter
 *
 * @var AdapterInterface
 */
protected adapter;

```

## Методи

```php
public function __construct( AdapterInterface $adapter );
```
Constructor.


```php
public function getAdapter(): AdapterInterface;
```
Returns the current adapter


```php
protected function checkKey( string $key ): void;
```
Checks the key. If it contains invalid characters an exception is thrown


```php
protected function checkKeys( mixed $keys ): void;
```
Checks the key. If it contains invalid characters an exception is thrown


```php
protected function doClear(): bool;
```
Wipes clean the entire cache's keys.


```php
protected function doDelete( string $key ): bool;
```
Delete an item from the cache by its unique key.


```php
protected function doDeleteMultiple( mixed $keys ): bool;
```
Deletes multiple cache items in a single operation.


```php
protected function doGet( string $key, mixed $defaultValue = null );
```
Fetches a value from the cache.


```php
protected function doGetMultiple( mixed $keys, mixed $defaultValue = null );
```
Obtains multiple cache items by their unique keys.


```php
protected function doHas( string $key ): bool;
```
Determines whether an item is present in the cache.


```php
protected function doSet( string $key, mixed $value, mixed $ttl = null ): bool;
```
Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.


```php
protected function doSetMultiple( mixed $values, mixed $ttl = null ): bool;
```
Persists a set of key => value pairs in the cache, with an optional TTL.


```php
abstract protected function getExceptionClass(): string;
```
Returns the exception class that will be used for exceptions thrown




<h1 id="cache-adapter-adapterinterface">Interface Phalcon\Cache\Adapter\AdapterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Adapter/AdapterInterface.zep)

| Namespace  | Phalcon\Cache\Adapter | | Uses       | Phalcon\Storage\Adapter\AdapterInterface | | Extends    | StorageAdapterInterface |

Interface for Phalcon\Cache adapters



<h1 id="cache-adapter-apcu">Class Phalcon\Cache\Adapter\Apcu</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Adapter/Apcu.zep)

| Namespace  | Phalcon\Cache\Adapter | | Uses       | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Apcu | | Extends    | StorageApcu | | Implements | CacheAdapterInterface |

Apcu adapter



<h1 id="cache-adapter-libmemcached">Class Phalcon\Cache\Adapter\Libmemcached</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Adapter/Libmemcached.zep)

| Namespace  | Phalcon\Cache\Adapter | | Uses       | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Libmemcached | | Extends    | StorageLibmemcached | | Implements | CacheAdapterInterface |

Libmemcached adapter



<h1 id="cache-adapter-memory">Class Phalcon\Cache\Adapter\Memory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Adapter/Memory.zep)

| Namespace  | Phalcon\Cache\Adapter | | Uses       | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Memory | | Extends    | StorageMemory | | Implements | CacheAdapterInterface |

Memory adapter



<h1 id="cache-adapter-redis">Class Phalcon\Cache\Adapter\Redis</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Adapter/Redis.zep)

| Namespace  | Phalcon\Cache\Adapter | | Uses       | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Redis | | Extends    | StorageRedis | | Implements | CacheAdapterInterface |

Redis adapter



<h1 id="cache-adapter-stream">Class Phalcon\Cache\Adapter\Stream</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Adapter/Stream.zep)

| Namespace  | Phalcon\Cache\Adapter | | Uses       | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Stream | | Extends    | StorageStream | | Implements | CacheAdapterInterface |

Stream adapter



<h1 id="cache-adapterfactory">Class Phalcon\Cache\AdapterFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/AdapterFactory.zep)

| Namespace  | Phalcon\Cache | | Uses       | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Cache\Exception\Exception, Phalcon\Factory\AbstractFactory, Phalcon\Storage\SerializerFactory | | Extends    | AbstractFactory |

Factory to create Cache adapters

@property SerializerFactory $serializerFactory


## Властивості
```php
/**
 * @var SerializerFactory
 */
private serializerFactory;

```

## Методи

```php
public function __construct( SerializerFactory $factory, array $services = [] );
```
AdapterFactory constructor.


```php
public function newInstance( string $name, array $options = [] ): AdapterInterface;
```
Create a new instance of the adapter


```php
protected function getExceptionClass(): string;
```

```php
protected function getServices(): array;
```
Returns the available adapters




<h1 id="cache-cache">Class Phalcon\Cache\Cache</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Cache.zep)

| Namespace  | Phalcon\Cache | | Uses       | DateInterval, Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Cache\Exception\InvalidArgumentException | | Extends    | AbstractCache |

This component offers caching capabilities for your application. Phalcon\Cache implements PSR-16.

@property AdapterInterface $adapter


## Методи

```php
public function clear(): bool;
```
Wipes clean the entire cache's keys.


```php
public function delete( string $key ): bool;
```
Delete an item from the cache by its unique key.


```php
public function deleteMultiple( mixed $keys ): bool;
```
Deletes multiple cache items in a single operation.


```php
public function get( string $key, mixed $defaultValue = null );
```
Fetches a value from the cache.


```php
public function getMultiple( mixed $keys, mixed $defaultValue = null );
```
Obtains multiple cache items by their unique keys.


```php
public function has( string $key ): bool;
```
Determines whether an item is present in the cache.


```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```
Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.


```php
public function setMultiple( mixed $values, mixed $ttl = null ): bool;
```
Persists a set of key => value pairs in the cache, with an optional TTL.


```php
protected function getExceptionClass(): string;
```
Returns the exception class that will be used for exceptions thrown




<h1 id="cache-cachefactory">Class Phalcon\Cache\CacheFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/CacheFactory.zep)

| Namespace  | Phalcon\Cache | | Uses       | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Cache\Cache, Phalcon\Cache\Exception\Exception, Phalcon\Config\ConfigInterface, Phalcon\Factory\AbstractConfigFactory | | Extends    | AbstractConfigFactory |

Creates a new Cache class

@property AdapterFactory $adapterFactory;


## Властивості
```php
/**
 * @var AdapterFactory
 */
protected adapterFactory;

```

## Методи

```php
public function __construct( AdapterFactory $factory );
```
Constructor


```php
public function load( mixed $config ): CacheInterface;
```
Factory to create an instance from a Config object


```php
public function newInstance( string $name, array $options = [] ): CacheInterface;
```
Constructs a new Cache instance.


```php
protected function getExceptionClass(): string;
```





<h1 id="cache-cacheinterface">Interface Phalcon\Cache\CacheInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/CacheInterface.zep)

| Namespace  | Phalcon\Cache | | Uses       | DateInterval, Phalcon\Cache\Exception\InvalidArgumentException |

Interface for Phalcon\Cache\Cache


## Методи

```php
public function clear(): bool;
```
Wipes clean the entire cache's keys.


```php
public function delete( string $key ): bool;
```
Delete an item from the cache by its unique key.


```php
public function deleteMultiple( mixed $keys ): bool;
```
Deletes multiple cache items in a single operation.


```php
public function get( string $key, mixed $defaultValue = null );
```
Fetches a value from the cache.


```php
public function getMultiple( mixed $keys, mixed $defaultValue = null );
```
Obtains multiple cache items by their unique keys.


```php
public function has( string $key ): bool;
```
Determines whether an item is present in the cache.


```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```
Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.


```php
public function setMultiple( mixed $values, mixed $ttl = null ): bool;
```
Persists a set of key => value pairs in the cache, with an optional TTL.




<h1 id="cache-exception-exception">Class Phalcon\Cache\Exception\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Exception/Exception.zep)

| Namespace  | Phalcon\Cache\Exception | | Extends    | \Exception |

Exceptions thrown in Phalcon\Cache will use this class



<h1 id="cache-exception-invalidargumentexception">Class Phalcon\Cache\Exception\InvalidArgumentException</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Exception/InvalidArgumentException.zep)

| Namespace  | Phalcon\Cache\Exception | | Extends    | \Exception |

Exceptions thrown in Phalcon\Cache will use this class

