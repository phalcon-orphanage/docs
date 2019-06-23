---
layout: default
language: 'fr-fr'
version: '4.0'
title: 'Phalcon\Cache'
---

* [Phalcon\Cache\Adapter\AdapterInterface](#Cache_Adapter_AdapterInterface)
* [Phalcon\Cache\Adapter\Apcu](#Cache_Adapter_Apcu)
* [Phalcon\Cache\Adapter\Libmemcached](#Cache_Adapter_Libmemcached)
* [Phalcon\Cache\Adapter\Memory](#Cache_Adapter_Memory)
* [Phalcon\Cache\Adapter\Redis](#Cache_Adapter_Redis)
* [Phalcon\Cache\Adapter\Stream](#Cache_Adapter_Stream)
* [Phalcon\Cache\AdapterFactory](#Cache_AdapterFactory)
* [Phalcon\Cache\Cache](#Cache_Cache)
* [Phalcon\Cache\CacheFactory](#Cache_CacheFactory)
* [Phalcon\Cache\Exception\Exception](#Cache_Exception_Exception)
* [Phalcon\Cache\Exception\InvalidArgumentException](#Cache_Exception_InvalidArgumentException)

<h1 id="Cache_Adapter_AdapterInterface">Interface Phalcon\Cache\Adapter\AdapterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/adapter/adapterinterface.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Storage\Adapter\AdapterInterface | | Extends | Array |

Interface for Phalcon\Cache adapters

<h1 id="Cache_Adapter_Apcu">Class Phalcon\Cache\Adapter\Apcu</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/adapter/apcu.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Apcu | | Extends | StorageApcu | | Implements | CacheAdapterInterface |

Apcu adapter

<h1 id="Cache_Adapter_Libmemcached">Class Phalcon\Cache\Adapter\Libmemcached</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/adapter/libmemcached.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Libmemcached | | Extends | StorageLibmemcached | | Implements | CacheAdapterInterface |

Libmemcached adapter

<h1 id="Cache_Adapter_Memory">Class Phalcon\Cache\Adapter\Memory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/adapter/memory.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Memory | | Extends | StorageMemory | | Implements | CacheAdapterInterface |

Memory adapter

<h1 id="Cache_Adapter_Redis">Class Phalcon\Cache\Adapter\Redis</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/adapter/redis.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Redis | | Extends | StorageRedis | | Implements | CacheAdapterInterface |

Redis adapter

<h1 id="Cache_Adapter_Stream">Class Phalcon\Cache\Adapter\Stream</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/adapter/stream.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Stream | | Extends | StorageStream | | Implements | CacheAdapterInterface |

Stream adapter

<h1 id="Cache_AdapterFactory">Class Phalcon\Cache\AdapterFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/adapterfactory.zep)

| Namespace | Phalcon\Cache | | Uses | Phalcon\Cache\Adapter\AbstractAdapter, Phalcon\Cache\Exception\Exception, Phalcon\Factory\AbstractFactory, Phalcon\Storage\SerializerFactory | | Extends | AbstractFactory |

Factory to create Cache adapters

## Properties

```php
/**
 * @var SerializerFactory
 */
private serializerFactory;

```

## Methods

```php
public function __construct( mixed $factory, array $services );
```

AdapterFactory constructor.

```php
public function newInstance( string $name, array $options ): AbstractAdapter;
```

Create a new instance of the adapter

```php
protected function getAdapters(): array;
```

Returns the available adapters

<h1 id="Cache_Cache">Class Phalcon\Cache\Cache</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/cache.zep)

| Namespace | Phalcon\Cache | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Cache\Exception\Exception, Phalcon\Cache\Exception\InvalidArgumentException, Psr\SimpleCache\CacheInterface | | Implements | CacheInterface |

This component offers caching capabilities for your application. Phalcon\Cache implements PSR-16.

## Properties

```php
/**
 * The adapter
 *
 * @var AdapterInterface
 */
protected adapter;

```

## Methods

```php
public function __construct( mixed $adapter ): void;
```

Constructor.

@param AdapterInterface adapter The cache adapter

```php
public function clear(): bool;
```

Wipes clean the entire cache's keys.

@return bool True on success and false on failure.

```php
public function delete( mixed $key ): bool;
```

Delete an item from the cache by its unique key.

@param string $key The unique cache key of the item to delete.

@return bool True if the item was successfully removed. False if there was an error.

@throws Phalcon\Cache\Exception\InvalidArgumentException MUST be thrown if the $key string is not a legal value.

```php
public function deleteMultiple( mixed $keys ): bool;
```

Deletes multiple cache items in a single operation.

@param iterable $keys A list of string-based keys to be deleted.

@return bool True if the items were successfully removed. False if there was an error.

@throws Phalcon\Cache\Exception\InvalidArgumentException MUST be thrown if $keys is neither an array nor a Traversable, or if any of the $keys are not a legal value.

```php
public function get( mixed $key, mixed $defaultValue ): mixed;
```

Fetches a value from the cache.

@param string $key The unique key of this item in the cache. @param mixed $default Default value to return if the key does not exist.

@return mixed The value of the item from the cache, or $default in case of cache miss.

@throws Phalcon\Cache\Exception\InvalidArgumentException MUST be thrown if the $key string is not a legal value.

```php
public function getAdapter(): AdapterInterface
```

```php
public function getMultiple( mixed $keys, mixed $defaultValue ): mixed;
```

Obtains multiple cache items by their unique keys.

@param iterable $keys A list of keys that can obtained in a single operation. @param mixed $default Default value to return for keys that do not exist.

@return iterable A list of key => value pairs. Cache keys that do not exist or are stale will have $default as value.

@throws Phalcon\Cache\Exception\InvalidArgumentException MUST be thrown if $keys is neither an array nor a Traversable, or if any of the $keys are not a legal value.

```php
public function has( mixed $key ): bool;
```

Determines whether an item is present in the cache.

@param string $key The cache item key.

@return bool

@throws Phalcon\Cache\Exception\InvalidArgumentException MUST be thrown if the $key string is not a legal value.

```php
public function set( mixed $key, mixed $value, mixed $ttl ): bool;
```

Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.

@param string $key The key of the item to store. @param mixed $value The value of the item to store. Must be serializable. @param null|int|\DateInterval $ttl Optional. The TTL value of this item. If no value is sent and the driver supports TTL then the library may set a default value for it or let the driver take care of that.

@return bool True on success and false on failure.

@throws Phalcon\Cache\Exception\InvalidArgumentException MUST be thrown if the $key string is not a legal value.

```php
public function setMultiple( mixed $values, mixed $ttl ): bool;
```

Persists a set of key => value pairs in the cache, with an optional TTL.

@param iterable $values A list of key => value pairs for a multiple-set operation. @param null|int|\DateInterval $ttl Optional. The TTL value of this item. If no value is sent and the driver supports TTL then the library may set a default value for it or let the driver take care of that.

@return bool True on success and false on failure.

@throws Phalcon\Cache\Exception\InvalidArgumentException MUST be thrown if $values is neither an array nor a Traversable, or if any of the $values are not a legal value.

```php
protected function checkKey( mixed $key ): void;
```

Checks the key. If it contains invalid characters an exception is thrown

```php
protected function checkKeys( mixed $keys ): void;
```

Checks the key. If it contains invalid characters an exception is thrown

<h1 id="Cache_CacheFactory">Class Phalcon\Cache\CacheFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/cachefactory.zep)

| Namespace | Phalcon\Cache | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Cache\AdapterFactory, Phalcon\Cache\Cache, Phalcon\Cache\CacheInterface, Phalcon\Cache\Exception\Exception, Phalcon\Config\Config, Phalcon\Factory\AbstractFactory, Phalcon\Helper\Arr |

Creates a new Cache class

## Properties

```php
/**
 * @var AdapterFactory
 */
protected adapterFactory;

```

## Methods

```php
public function __construct( mixed $factory );
```

Constructor

```php
public function load( mixed $config ): mixed;
```

Factory to create an instace from a Config object

```php
public function newInstance( string $name, array $options ): CacheInterface;
```

Constructs a new Cache instance.

<h1 id="Cache_Exception_Exception">Class Phalcon\Cache\Exception\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/exception/exception.zep)

| Namespace | Phalcon\Cache\Exception | | Extends | \Exception | | Implements | \Psr\SimpleCache\CacheException |

Exceptions thrown in Phalcon\Cache will use this class

<h1 id="Cache_Exception_InvalidArgumentException">Class Phalcon\Cache\Exception\InvalidArgumentException</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/exception/invalidargumentexception.zep)

| Namespace | Phalcon\Cache\Exception | | Extends | \Exception | | Implements | \Psr\SimpleCache\InvalidArgumentException |

Exceptions thrown in Phalcon\Cache will use this class