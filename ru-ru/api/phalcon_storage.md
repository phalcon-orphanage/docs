---
layout: default
language: 'ru-ru'
version: '5.0'
title: 'Phalcon\Storage'
---

* [Phalcon\Storage\Adapter\AbstractAdapter](#storage-adapter-abstractadapter)
* [Phalcon\Storage\Adapter\AdapterInterface](#storage-adapter-adapterinterface)
* [Phalcon\Storage\Adapter\Apcu](#storage-adapter-apcu)
* [Phalcon\Storage\Adapter\Libmemcached](#storage-adapter-libmemcached)
* [Phalcon\Storage\Adapter\Memory](#storage-adapter-memory)
* [Phalcon\Storage\Adapter\Redis](#storage-adapter-redis)
* [Phalcon\Storage\Adapter\Stream](#storage-adapter-stream)
* [Phalcon\Storage\AdapterFactory](#storage-adapterfactory)
* [Phalcon\Storage\Exception](#storage-exception)
* [Phalcon\Storage\Serializer\AbstractSerializer](#storage-serializer-abstractserializer)
* [Phalcon\Storage\Serializer\Base64](#storage-serializer-base64)
* [Phalcon\Storage\Serializer\Igbinary](#storage-serializer-igbinary)
* [Phalcon\Storage\Serializer\Json](#storage-serializer-json)
* [Phalcon\Storage\Serializer\MemcachedIgbinary](#storage-serializer-memcachedigbinary)
* [Phalcon\Storage\Serializer\MemcachedJson](#storage-serializer-memcachedjson)
* [Phalcon\Storage\Serializer\MemcachedPhp](#storage-serializer-memcachedphp)
* [Phalcon\Storage\Serializer\Msgpack](#storage-serializer-msgpack)
* [Phalcon\Storage\Serializer\None](#storage-serializer-none)
* [Phalcon\Storage\Serializer\Php](#storage-serializer-php)
* [Phalcon\Storage\Serializer\RedisIgbinary](#storage-serializer-redisigbinary)
* [Phalcon\Storage\Serializer\RedisJson](#storage-serializer-redisjson)
* [Phalcon\Storage\Serializer\RedisMsgpack](#storage-serializer-redismsgpack)
* [Phalcon\Storage\Serializer\RedisNone](#storage-serializer-redisnone)
* [Phalcon\Storage\Serializer\RedisPhp](#storage-serializer-redisphp)
* [Phalcon\Storage\Serializer\SerializerInterface](#storage-serializer-serializerinterface)
* [Phalcon\Storage\SerializerFactory](#storage-serializerfactory)

<h1 id="storage-adapter-abstractadapter">Abstract Class Phalcon\Storage\Adapter\AbstractAdapter</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Adapter/AbstractAdapter.zep)

| Namespace  | Phalcon\Storage\Adapter | | Uses       | DateInterval, DateTime, Exception, Phalcon\Storage\Serializer\SerializerInterface, Phalcon\Storage\SerializerFactory, Phalcon\Support\Exception | | Implements | AdapterInterface |

Class AbstractAdapter

@package Phalcon\Storage\Adapter

@property mixed               $adapter @property string              $defaultSerializer @property int                 $lifetime @property array               $options @property string              $prefix @property SerializerInterface $serializer @property SerializerFactory   $serializerFactory


## Properties
```php
/**
 * @var mixed
 */
protected adapter;

/**
 * Name of the default serializer class
 *
 * @var string
 */
protected defaultSerializer = php;

/**
 * Name of the default TTL (time to live)
 *
 * @var int
 */
protected lifetime = 3600;

/**
 * @var array
 */
protected options;

/**
 * @var string
 */
protected prefix = ph-memo-;

/**
 * Serializer
 *
 * @var SerializerInterface|null
 */
protected serializer;

/**
 * Serializer Factory
 *
 * @var SerializerFactory
 */
protected serializerFactory;

```

## Методы

```php
protected function __construct( SerializerFactory $factory, array $options = [] );
```
AbstractAdapter constructor.


```php
abstract public function clear(): bool;
```
Flushes/clears the cache


```php
abstract public function decrement( string $key, int $value = int ): int | bool;
```
Decrements a stored number


```php
abstract public function delete( string $key ): bool;
```
Deletes data from the adapter


```php
public function get( string $key, mixed $defaultValue = null ): mixed;
```
Reads data from the adapter


```php
public function getAdapter(): mixed;
```
Returns the adapter - connects to the storage if not connected


```php
public function getDefaultSerializer(): string
```

```php
abstract public function getKeys( string $prefix = string ): array;
```
Returns all the keys stored


```php
public function getPrefix(): string;
```
Returns the prefix


```php
abstract public function has( string $key ): bool;
```
Checks if an element exists in the cache


```php
abstract public function increment( string $key, int $value = int ): int | bool;
```
Increments a stored number


```php
abstract public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```
Stores data in the adapter


```php
public function setDefaultSerializer( string $serializer ): void;
```

```php
protected function doGet( string $key );
```

```php
protected function getArrVal( array $collection, mixed $index, mixed $defaultValue = null, string $cast = null ): mixed;
```
@todo Remove this when we get traits


```php
protected function getFilteredKeys( mixed $keys, string $prefix ): array;
```
Filters the keys array based on global and passed prefix


```php
protected function getPrefixedKey( mixed $key ): string;
```
Returns the key requested, prefixed


```php
protected function getSerializedData( mixed $content ): mixed;
```
Returns serialized data


```php
protected function getTtl( mixed $ttl ): int;
```
Calculates the TTL for a cache item


```php
protected function getUnserializedData( mixed $content, mixed $defaultValue = null ): mixed;
```
Returns unserialized data


```php
protected function initSerializer(): void;
```
Initializes the serializer

@throws SupportException




<h1 id="storage-adapter-adapterinterface">Interface Phalcon\Storage\Adapter\AdapterInterface</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Adapter/AdapterInterface.zep)

| Namespace  | Phalcon\Storage\Adapter | | Uses       | Phalcon\Storage\Serializer\SerializerInterface |

Interface for Phalcon\Logger adapters


## Методы

```php
public function clear(): bool;
```
Flushes/clears the cache


```php
public function decrement( string $key, int $value = int ): int | bool;
```
Decrements a stored number


```php
public function delete( string $key ): bool;
```
Deletes data from the adapter


```php
public function get( string $key, mixed $defaultValue = null ): mixed;
```
Reads data from the adapter


```php
public function getAdapter(): mixed;
```
Returns the already connected adapter or connects to the backend server(s)


```php
public function getKeys( string $prefix = string ): array;
```
Returns all the keys stored


```php
public function getPrefix(): string;
```
Returns the prefix for the keys


```php
public function has( string $key ): bool;
```
Checks if an element exists in the cache


```php
public function increment( string $key, int $value = int ): int | bool;
```
Increments a stored number


```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```
Stores data in the adapter. If the TTL is `null` (default) or not defined then the default TTL will be used, as set in this adapter. If the TTL is `0` or a negative number, a `delete()` will be issued, since this item has expired. If you need to set this key forever, you should use the `setForever()` method.


```php
public function setForever( string $key, mixed $value ): bool;
```
Stores data in the adapter forever. The key needs to manually deleted from the adapter.




<h1 id="storage-adapter-apcu">Class Phalcon\Storage\Adapter\Apcu</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Adapter/Apcu.zep)

| Namespace  | Phalcon\Storage\Adapter | | Uses       | APCuIterator, DateInterval, Exception, Phalcon\Storage\SerializerFactory, Phalcon\Support\Exception | | Extends    | AbstractAdapter |

Apcu adapter

@property array $options


## Properties
```php
/**
 * @var string
 */
protected prefix = ph-apcu-;

```

## Методы

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```
Apcu constructor.


```php
public function clear(): bool;
```
Flushes/clears the cache


```php
public function decrement( string $key, int $value = int ): int | bool;
```
Decrements a stored number


```php
public function delete( string $key ): bool;
```
Reads data from the adapter


```php
public function getKeys( string $prefix = string ): array;
```
Stores data in the adapter


```php
public function has( string $key ): bool;
```
Checks if an element exists in the cache


```php
public function increment( string $key, int $value = int ): int | bool;
```
Increments a stored number


```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```
Stores data in the adapter. If the TTL is `null` (default) or not defined then the default TTL will be used, as set in this adapter. If the TTL is `0` or a negative number, a `delete()` will be issued, since this item has expired. If you need to set this key forever, you should use the `setForever()` method.


```php
public function setForever( string $key, mixed $value ): bool;
```
Stores data in the adapter forever. The key needs to manually deleted from the adapter.


```php
protected function doGet( string $key );
```

```php
protected function phpApcuDec( mixed $key, int $step = int, mixed $success = null, int $ttl = int ): bool | int;
```
@todo Remove the below once we get traits


```php
protected function phpApcuDelete( mixed $key ): bool | array;
```

```php
protected function phpApcuExists( mixed $key ): bool | array;
```

```php
protected function phpApcuFetch( mixed $key, mixed $success = null ): mixed;
```

```php
protected function phpApcuInc( mixed $key, int $step = int, mixed $success = null, int $ttl = int ): bool | int;
```

```php
protected function phpApcuIterator( string $pattern ): APCuIterator | bool;
```

```php
protected function phpApcuStore( mixed $key, mixed $payload, int $ttl = int ): bool | array;
```





<h1 id="storage-adapter-libmemcached">Class Phalcon\Storage\Adapter\Libmemcached</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Adapter/Libmemcached.zep)

| Namespace  | Phalcon\Storage\Adapter | | Uses       | DateInterval, Exception, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Support\Exception | | Extends    | AbstractAdapter |

Libmemcached adapter


## Properties
```php
/**
 * @var string
 */
protected prefix = ph-memc-;

```

## Методы

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```
Libmemcached constructor.


```php
public function clear(): bool;
```
Flushes/clears the cache


```php
public function decrement( string $key, int $value = int ): int | bool;
```
Decrements a stored number


```php
public function delete( string $key ): bool;
```
Reads data from the adapter


```php
public function getAdapter(): mixed;
```
Returns the already connected adapter or connects to the Memcached server(s)


```php
public function getKeys( string $prefix = string ): array;
```
Stores data in the adapter


```php
public function has( string $key ): bool;
```
Checks if an element exists in the cache


```php
public function increment( string $key, int $value = int ): int | bool;
```
Increments a stored number


```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```
Stores data in the adapter. If the TTL is `null` (default) or not defined then the default TTL will be used, as set in this adapter. If the TTL is `0` or a negative number, a `delete()` will be issued, since this item has expired. If you need to set this key forever, you should use the `setForever()` method.


```php
public function setForever( string $key, mixed $value ): bool;
```
Stores data in the adapter forever. The key needs to manually deleted from the adapter.




<h1 id="storage-adapter-memory">Class Phalcon\Storage\Adapter\Memory</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Adapter/Memory.zep)

| Namespace  | Phalcon\Storage\Adapter | | Uses       | DateInterval, Exception, Phalcon\Storage\SerializerFactory, Phalcon\Support\Exception | | Extends    | AbstractAdapter |

Memory adapter

@property array $data @property array $options


## Properties
```php
/**
 * @var array
 */
protected data;

```

## Методы

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```
Memory constructor.


```php
public function clear(): bool;
```
Flushes/clears the cache


```php
public function decrement( string $key, int $value = int ): int | bool;
```
Decrements a stored number


```php
public function delete( string $key ): bool;
```
Deletes data from the adapter


```php
public function getKeys( string $prefix = string ): array;
```
Stores data in the adapter


```php
public function has( string $key ): bool;
```
Checks if an element exists in the cache


```php
public function increment( string $key, int $value = int ): int | bool;
```
Increments a stored number


```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```
Stores data in the adapter. If the TTL is `null` (default) or not defined then the default TTL will be used, as set in this adapter. If the TTL is `0` or a negative number, a `delete()` will be issued, since this item has expired. If you need to set this key forever, you should use the `setForever()` method.


```php
public function setForever( string $key, mixed $value ): bool;
```
Stores data in the adapter forever. The key needs to manually deleted from the adapter.


```php
protected function doGet( string $key );
```





<h1 id="storage-adapter-redis">Class Phalcon\Storage\Adapter\Redis</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Adapter/Redis.zep)

| Namespace  | Phalcon\Storage\Adapter | | Uses       | DateInterval, Exception, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Support\Exception | | Extends    | AbstractAdapter |

Redis adapter

@property array $options


## Properties
```php
/**
 * @var string
 */
protected prefix = ph-reds-;

```

## Методы

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```
Redis constructor.


```php
public function clear(): bool;
```
Flushes/clears the cache


```php
public function decrement( string $key, int $value = int ): int | bool;
```
Decrements a stored number


```php
public function delete( string $key ): bool;
```
Reads data from the adapter


```php
public function getAdapter(): mixed;
```
Returns the already connected adapter or connects to the Redis server(s)


```php
public function getKeys( string $prefix = string ): array;
```
Stores data in the adapter


```php
public function has( string $key ): bool;
```
Checks if an element exists in the cache


```php
public function increment( string $key, int $value = int ): int | bool;
```
Increments a stored number


```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```
Stores data in the adapter. If the TTL is `null` (default) or not defined then the default TTL will be used, as set in this adapter. If the TTL is `0` or a negative number, a `delete()` will be issued, since this item has expired. If you need to set this key forever, you should use the `setForever()` method.


```php
public function setForever( string $key, mixed $value ): bool;
```
Stores data in the adapter forever. The key needs to manually deleted from the adapter.




<h1 id="storage-adapter-stream">Class Phalcon\Storage\Adapter\Stream</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Adapter/Stream.zep)

| Namespace  | Phalcon\Storage\Adapter | | Uses       | DateInterval, FilesystemIterator, Iterator, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Storage\Traits\StorageErrorHandlerTrait, Phalcon\Support\Exception, RecursiveDirectoryIterator, RecursiveIteratorIterator | | Extends    | AbstractAdapter |

Stream adapter

@property string $storageDir @property array  $options


## Properties
```php
/**
 * @var string
 */
protected prefix = ph-strm;

/**
 * @var string
 */
protected storageDir = ;

```

## Методы

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```
Stream constructor.


```php
public function clear(): bool;
```
Flushes/clears the cache


```php
public function decrement( string $key, int $value = int ): int | bool;
```
Decrements a stored number


```php
public function delete( string $key ): bool;
```
Reads data from the adapter


```php
public function get( string $key, mixed $defaultValue = null ): mixed;
```
Reads data from the adapter


```php
public function getKeys( string $prefix = string ): array;
```
Stores data in the adapter


```php
public function has( string $key ): bool;
```
Checks if an element exists in the cache and is not expired


```php
public function increment( string $key, int $value = int ): int | bool;
```
Increments a stored number


```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```
Stores data in the adapter. If the TTL is `null` (default) or not defined then the default TTL will be used, as set in this adapter. If the TTL is `0` or a negative number, a `delete()` will be issued, since this item has expired. If you need to set this key forever, you should use the `setForever()` method.


```php
public function setForever( string $key, mixed $value ): bool;
```
Stores data in the adapter forever. The key needs to manually deleted from the adapter.


```php
protected function phpFileExists( string $filename ): bool;
```
@todo Remove the methods below when we get traits


```php
protected function phpFileGetContents( string $filename ): string | bool;
```

```php
protected function phpFilePutContents( string $filename, mixed $data, int $flags = int, mixed $context = null ): int | bool;
```

```php
protected function phpFopen( string $filename, string $mode ): mixed;
```

```php
protected function phpUnlink( string $filename ): bool;
```





<h1 id="storage-adapterfactory">Class Phalcon\Storage\AdapterFactory</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/AdapterFactory.zep)

| Namespace  | Phalcon\Storage | | Uses       | Phalcon\Factory\AbstractFactory, Phalcon\Storage\Adapter\AdapterInterface | | Extends    | AbstractFactory |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.


## Properties
```php
/**
 * @var SerializerFactory
 */
private serializerFactory;

```

## Методы

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




<h1 id="storage-exception">Class Phalcon\Storage\Exception</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Exception.zep)

| Namespace  | Phalcon\Storage | | Extends    | \Exception |

Phalcon\Storage\Exception

Exceptions thrown in Phalcon\Storage will use this class




<h1 id="storage-serializer-abstractserializer">Abstract Class Phalcon\Storage\Serializer\AbstractSerializer</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Serializer/AbstractSerializer.zep)

| Namespace  | Phalcon\Storage\Serializer | | Implements | SerializerInterface |



## Properties
```php
/**
 * @var mixed
 */
protected data;

/**
 * @var bool
 */
protected isSuccess = true;

```

## Методы

```php
public function __construct( mixed $data = null );
```
AbstractSerializer constructor.


```php
public function __serialize(): array;
```
Serialize data


```php
public function __unserialize( array $data ): void;
```
Unserialize data


```php
public function getData();
```

```php
public function isSuccess(): bool;
```
Returns `true` if the serialize/unserialize operation was successful; `false` otherwise


```php
public function setData( mixed $data ): void;
```

```php
protected function isSerializable( mixed $data ): bool;
```
If this returns true, then the data is returned as is




<h1 id="storage-serializer-base64">Class Phalcon\Storage\Serializer\Base64</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Serializer/Base64.zep)

| Namespace  | Phalcon\Storage\Serializer | | Uses       | InvalidArgumentException | | Extends    | AbstractSerializer |



## Методы

```php
public function serialize(): string;
```
Serializes data


```php
public function unserialize( mixed $data ): void;
```
Unserializes data


```php
protected function phpBase64Decode( string $input, bool $strict = bool );
```
Wrapper for base64_decode




<h1 id="storage-serializer-igbinary">Class Phalcon\Storage\Serializer\Igbinary</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Serializer/Igbinary.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | AbstractSerializer |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.


## Методы

```php
public function serialize();
```
Serializes data


```php
public function unserialize( mixed $data ): void;
```
Unserializes data


```php
protected function doSerialize( mixed $value ): string | null;
```
Serialize


```php
protected function doUnserialize( mixed $value );
```
Unserialize


```php
protected function phpIgbinarySerialize( mixed $value ): string | null;
```
Wrapper for `igbinary_serialize`




<h1 id="storage-serializer-json">Class Phalcon\Storage\Serializer\Json</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Serializer/Json.zep)

| Namespace  | Phalcon\Storage\Serializer | | Uses       | InvalidArgumentException, JsonSerializable | | Extends    | AbstractSerializer |



## Методы

```php
public function serialize();
```
Serializes data


```php
public function unserialize( mixed $data ): void;
```
Unserializes data




<h1 id="storage-serializer-memcachedigbinary">Class Phalcon\Storage\Serializer\MemcachedIgbinary</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Serializer/MemcachedIgbinary.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | None |

Serializer using the built-in Memcached 'igbinary' serializer



<h1 id="storage-serializer-memcachedjson">Class Phalcon\Storage\Serializer\MemcachedJson</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Serializer/MemcachedJson.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | None |

Serializer using the built-in Memcached 'json' serializer



<h1 id="storage-serializer-memcachedphp">Class Phalcon\Storage\Serializer\MemcachedPhp</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Serializer/MemcachedPhp.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | None |

Serializer using the built-in Memcached 'php' serializer



<h1 id="storage-serializer-msgpack">Class Phalcon\Storage\Serializer\Msgpack</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Serializer/Msgpack.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | Igbinary |


## Методы

```php
protected function doSerialize( mixed $value ): string;
```
Serializes data


```php
protected function doUnserialize( mixed $value );
```





<h1 id="storage-serializer-none">Class Phalcon\Storage\Serializer\None</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Serializer/None.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | AbstractSerializer |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.


## Методы

```php
public function serialize(): mixed;
```
Serializes data


```php
public function unserialize( mixed $data ): void;
```
Unserializes data




<h1 id="storage-serializer-php">Class Phalcon\Storage\Serializer\Php</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Serializer/Php.zep)

| Namespace  | Phalcon\Storage\Serializer | | Uses       | InvalidArgumentException | | Extends    | AbstractSerializer |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.


## Методы

```php
public function serialize(): string;
```
Serializes data


```php
public function unserialize( mixed $data ): void;
```
Unserializes data




<h1 id="storage-serializer-redisigbinary">Class Phalcon\Storage\Serializer\RedisIgbinary</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Serializer/RedisIgbinary.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | None |

Serializer using the built-in Redis 'igbinary' serializer



<h1 id="storage-serializer-redisjson">Class Phalcon\Storage\Serializer\RedisJson</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Serializer/RedisJson.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | None |

Serializer using the built-in Redis 'json' serializer



<h1 id="storage-serializer-redismsgpack">Class Phalcon\Storage\Serializer\RedisMsgpack</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Serializer/RedisMsgpack.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | None |

Serializer using the built-in Redis 'msgpack' serializer



<h1 id="storage-serializer-redisnone">Class Phalcon\Storage\Serializer\RedisNone</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Serializer/RedisNone.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | None |

Serializer using the built-in Redis 'none' serializer



<h1 id="storage-serializer-redisphp">Class Phalcon\Storage\Serializer\RedisPhp</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Serializer/RedisPhp.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | None |

Serializer using the built-in Redis 'php' serializer



<h1 id="storage-serializer-serializerinterface">Interface Phalcon\Storage\Serializer\SerializerInterface</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/Serializer/SerializerInterface.zep)

| Namespace  | Phalcon\Storage\Serializer | | Uses       | Serializable | | Extends    | Serializable |



## Методы

```php
public function getData(): mixed;
```

```php
public function setData( mixed $data ): void;
```





<h1 id="storage-serializerfactory">Class Phalcon\Storage\SerializerFactory</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Storage/SerializerFactory.zep)

| Namespace  | Phalcon\Storage | | Uses       | Phalcon\Factory\AbstractFactory, Phalcon\Storage\Serializer\SerializerInterface | | Extends    | AbstractFactory |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.


## Методы

```php
public function __construct( array $services = [] );
```
SerializerFactory constructor.


```php
public function newInstance( string $name ): SerializerInterface;
```

```php
protected function getExceptionClass(): string;
```

```php
protected function getServices(): array;
```
Returns the available adapters


