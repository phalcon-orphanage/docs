---
layout: default
language: 'en'
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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache.zep)

| Namespace  | Phalcon |
| Uses       | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Cache\Exception\Exception, Phalcon\Cache\Exception\InvalidArgumentException, Psr\SimpleCache\CacheInterface, Traversable |
| Implements | CacheInterface |

This component offers caching capabilities for your application.
Phalcon\Cache implements PSR-16.


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

Constructor.
```php
public function __construct( AdapterInterface $adapter );
```

Wipes clean the entire cache's keys.
```php
public function clear(): bool;
```

Delete an item from the cache by its unique key.
```php
public function delete( mixed $key ): bool;
```

Deletes multiple cache items in a single operation.
```php
public function deleteMultiple( mixed $keys ): bool;
```

Fetches a value from the cache.
```php
public function get( mixed $key, mixed $defaultValue = null ): mixed;
```


```php
public function getAdapter(): AdapterInterface
```

Obtains multiple cache items by their unique keys.
```php
public function getMultiple( mixed $keys, mixed $defaultValue = null ): mixed;
```

Determines whether an item is present in the cache.
```php
public function has( mixed $key ): bool;
```

Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.
```php
public function set( mixed $key, mixed $value, mixed $ttl = null ): bool;
```

Persists a set of key => value pairs in the cache, with an optional TTL.
```php
public function setMultiple( mixed $values, mixed $ttl = null ): bool;
```

Checks the key. If it contains invalid characters an exception is thrown
```php
protected function checkKey( mixed $key ): void;
```

Checks the key. If it contains invalid characters an exception is thrown
```php
protected function checkKeys( mixed $keys ): void;
```



<h1 id="cache-adapter-adapterinterface">Interface Phalcon\Cache\Adapter\AdapterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Adapter/AdapterInterface.zep)

| Namespace  | Phalcon\Cache\Adapter |
| Uses       | Phalcon\Storage\Adapter\AdapterInterface |
| Extends    | StorageAdapterInterface |

Interface for Phalcon\Cache adapters



<h1 id="cache-adapter-apcu">Class Phalcon\Cache\Adapter\Apcu</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Adapter/Apcu.zep)

| Namespace  | Phalcon\Cache\Adapter |
| Uses       | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Apcu |
| Extends    | StorageApcu |
| Implements | CacheAdapterInterface |

Apcu adapter



<h1 id="cache-adapter-libmemcached">Class Phalcon\Cache\Adapter\Libmemcached</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Adapter/Libmemcached.zep)

| Namespace  | Phalcon\Cache\Adapter |
| Uses       | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Libmemcached |
| Extends    | StorageLibmemcached |
| Implements | CacheAdapterInterface |

Libmemcached adapter



<h1 id="cache-adapter-memory">Class Phalcon\Cache\Adapter\Memory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Adapter/Memory.zep)

| Namespace  | Phalcon\Cache\Adapter |
| Uses       | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Memory |
| Extends    | StorageMemory |
| Implements | CacheAdapterInterface |

Memory adapter



<h1 id="cache-adapter-redis">Class Phalcon\Cache\Adapter\Redis</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Adapter/Redis.zep)

| Namespace  | Phalcon\Cache\Adapter |
| Uses       | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Redis |
| Extends    | StorageRedis |
| Implements | CacheAdapterInterface |

Redis adapter



<h1 id="cache-adapter-stream">Class Phalcon\Cache\Adapter\Stream</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Adapter/Stream.zep)

| Namespace  | Phalcon\Cache\Adapter |
| Uses       | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Stream |
| Extends    | StorageStream |
| Implements | CacheAdapterInterface |

Stream adapter



<h1 id="cache-adapterfactory">Class Phalcon\Cache\AdapterFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/AdapterFactory.zep)

| Namespace  | Phalcon\Cache |
| Uses       | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Cache\Exception\Exception, Phalcon\Factory\AbstractFactory, Phalcon\Storage\SerializerFactory |
| Extends    | AbstractFactory |

Factory to create Cache adapters


## Properties
```php
/**
 * @var SerializerFactory
 */
private serializerFactory;

```

## Methods

AdapterFactory constructor.
```php
public function __construct( SerializerFactory $factory = null, array $services = [] );
```

Create a new instance of the adapter
```php
public function newInstance( string $name, array $options = [] ): AdapterInterface;
```

Returns the available adapters
```php
protected function getAdapters(): array;
```



<h1 id="cache-cachefactory">Class Phalcon\Cache\CacheFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/CacheFactory.zep)

| Namespace  | Phalcon\Cache |
| Uses       | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Cache, Psr\SimpleCache\CacheInterface, Phalcon\Cache\Exception\Exception, Phalcon\Config, Phalcon\Helper\Arr |

Creates a new Cache class


## Properties
```php
/**
 * @var AdapterFactory
 */
protected adapterFactory;

```

## Methods

Constructor
```php
public function __construct( AdapterFactory $factory );
```

Factory to create an instance from a Config object
```php
public function load( mixed $config ): mixed;
```

Constructs a new Cache instance.
```php
public function newInstance( string $name, array $options = [] ): CacheInterface;
```



<h1 id="cache-exception-exception">Class Phalcon\Cache\Exception\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Exception/Exception.zep)

| Namespace  | Phalcon\Cache\Exception |
| Extends    | \Phalcon\Exception |
| Implements | \Psr\SimpleCache\CacheException |

Exceptions thrown in Phalcon\Cache will use this class



<h1 id="cache-exception-invalidargumentexception">Class Phalcon\Cache\Exception\InvalidArgumentException</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Cache/Exception/InvalidArgumentException.zep)

| Namespace  | Phalcon\Cache\Exception |
| Extends    | \Phalcon\Exception |
| Implements | \Psr\SimpleCache\InvalidArgumentException |

Exceptions thrown in Phalcon\Cache will use this class

