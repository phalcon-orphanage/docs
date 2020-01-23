---
layout: default
language: 'ru-ru'
version: '4.0'
title: 'Phalcon\Cache'
---

* [Phalcon\Cache](#cache)
* [Phalcon\Cache\Adapter\AdapterInterface](#cache-adapter-adapterinterface)
* [Phalcon\Cache\Adapter\Apcu](#cache-adapter-apcu)
* [Phalcon\Cache\Adapter\Libmemcached](#cache-adapter-libmemcached)
* [Phalcon\Cache\Adapter\Memory](#cache-adapter-memory)
* [Phalcon\Cache\Adapter\Redis](#cache-adapter-redis)
* [Phalcon\Cache\Adapter\Stream](#cache-adapter-stream)
* [Phalcon\Cache\AdapterFactory](#cache-adapterfactory)
* [Phalcon\Cache\CacheFactory](#cache-cachefactory)
* [Phalcon\Cache\Exception\Exception](#cache-exception-exception)
* [Phalcon\Cache\Exception\InvalidArgumentException](#cache-exception-invalidargumentexception)

<h1 id="cache">Class Phalcon\Cache</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache.zep)

| Namespace | Phalcon | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Cache\Exception\Exception, Phalcon\Cache\Exception\InvalidArgumentException, Psr\SimpleCache\CacheInterface, Traversable | | Implements | CacheInterface |

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

## Методы

```php
public function __construct( AdapterInterface $adapter );
```

Constructor.

```php
public function clear(): bool;
```

Wipes clean the entire cache's keys.

@return bool True on success and false on failure.

```php
public function delete( mixed $key ): bool;
```

Delete an item from the cache by its unique key.

@return bool True if the item was successfully removed. False if there was an error.

@throws InvalidArgumentException MUST be thrown if the $key string is not a legal value.

```php
public function deleteMultiple( mixed $keys ): bool;
```

Deletes multiple cache items in a single operation.

@return bool True if the items were successfully removed. False if there was an error.

@throws InvalidArgumentException MUST be thrown if $keys is neither an array nor a Traversable, or if any of the $keys are not a legal value.

```php
public function get( mixed $key, mixed $defaultValue = null ): mixed;
```

Fetches a value from the cache.

@return mixed The value of the item from the cache, or $default in case of cache miss.

@throws InvalidArgumentException MUST be thrown if the $key string is not a legal value.

```php
public function getAdapter(): AdapterInterface
```

```php
public function getMultiple( mixed $keys, mixed $defaultValue = null ): mixed;
```

Obtains multiple cache items by their unique keys.

@return iterable A list of key => value pairs. Cache keys that do not exist or are stale will have $default as value.

@throws InvalidArgumentException MUST be thrown if $keys is neither an array nor a Traversable, or if any of the $keys are not a legal value.

```php
public function has( mixed $key ): bool;
```

Determines whether an item is present in the cache.

@return bool

@throws InvalidArgumentException MUST be thrown if the $key string is not a legal value.

```php
public function set( mixed $key, mixed $value, mixed $ttl = null ): bool;
```

Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.

                                     the driver supports TTL then the library may set a default value
                                     for it or let the driver take care of that.
    

@return bool True on success and false on failure.

@throws InvalidArgumentException MUST be thrown if the $key string is not a legal value.

```php
public function setMultiple( mixed $values, mixed $ttl = null ): bool;
```

Persists a set of key => value pairs in the cache, with an optional TTL.

                                      the driver supports TTL then the library may set a default value
                                      for it or let the driver take care of that.
    

@return bool True on success and false on failure.

@throws InvalidArgumentException MUST be thrown if $values is neither an array nor a Traversable, or if any of the $values are not a legal value.

```php
protected function checkKey( mixed $key ): void;
```

Checks the key. If it contains invalid characters an exception is thrown

```php
protected function checkKeys( mixed $keys ): void;
```

Checks the key. If it contains invalid characters an exception is thrown

<h1 id="cache-adapter-adapterinterface">Interface Phalcon\Cache\Adapter\AdapterInterface</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/adapter/adapterinterface.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Storage\Adapter\AdapterInterface | | Extends | StorageAdapterInterface |

Interface for Phalcon\Cache adapters

<h1 id="cache-adapter-apcu">Class Phalcon\Cache\Adapter\Apcu</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/adapter/apcu.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Apcu | | Extends | StorageApcu | | Implements | CacheAdapterInterface |

Apcu adapter

<h1 id="cache-adapter-libmemcached">Class Phalcon\Cache\Adapter\Libmemcached</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/adapter/libmemcached.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Libmemcached | | Extends | StorageLibmemcached | | Implements | CacheAdapterInterface |

Libmemcached adapter

<h1 id="cache-adapter-memory">Class Phalcon\Cache\Adapter\Memory</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/adapter/memory.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Memory | | Extends | StorageMemory | | Implements | CacheAdapterInterface |

Memory adapter

<h1 id="cache-adapter-redis">Class Phalcon\Cache\Adapter\Redis</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/adapter/redis.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Redis | | Extends | StorageRedis | | Implements | CacheAdapterInterface |

Redis adapter

<h1 id="cache-adapter-stream">Class Phalcon\Cache\Adapter\Stream</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/adapter/stream.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Stream | | Extends | StorageStream | | Implements | CacheAdapterInterface |

Stream adapter

<h1 id="cache-adapterfactory">Class Phalcon\Cache\AdapterFactory</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/adapterfactory.zep)

| Namespace | Phalcon\Cache | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Cache\Exception\Exception, Phalcon\Factory\AbstractFactory, Phalcon\Storage\SerializerFactory | | Extends | AbstractFactory |

Factory to create Cache adapters

## Properties

```php
/**
 * @var SerializerFactory
 */
private serializerFactory;

```

## Методы

```php
public function __construct( SerializerFactory $factory = null, array $services = [] );
```

AdapterFactory constructor.

```php
public function newInstance( string $name, array $options = [] ): AdapterInterface;
```

Create a new instance of the adapter

```php
protected function getAdapters(): array;
```

Returns the available adapters

<h1 id="cache-cachefactory">Class Phalcon\Cache\CacheFactory</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/cachefactory.zep)

| Namespace | Phalcon\Cache | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Cache, Psr\SimpleCache\CacheInterface, Phalcon\Cache\Exception\Exception, Phalcon\Config, Phalcon\Helper\Arr |

Creates a new Cache class

## Properties

```php
/**
 * @var AdapterFactory
 */
protected adapterFactory;

```

## Методы

```php
public function __construct( AdapterFactory $factory );
```

Constructor

```php
public function load( mixed $config ): mixed;
```

Factory to create an instance from a Config object

```php
public function newInstance( string $name, array $options = [] ): CacheInterface;
```

Constructs a new Cache instance.

<h1 id="cache-exception-exception">Class Phalcon\Cache\Exception\Exception</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/exception/exception.zep)

| Namespace | Phalcon\Cache\Exception | | Extends | \Phalcon\Exception | | Implements | \Psr\SimpleCache\CacheException |

Exceptions thrown in Phalcon\Cache will use this class

<h1 id="cache-exception-invalidargumentexception">Class Phalcon\Cache\Exception\InvalidArgumentException</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/exception/invalidargumentexception.zep)

| Namespace | Phalcon\Cache\Exception | | Extends | \Phalcon\Exception | | Implements | \Psr\SimpleCache\InvalidArgumentException |

Exceptions thrown in Phalcon\Cache will use this class