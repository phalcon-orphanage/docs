---
layout: default
language: 'ru-ru'
version: '4.0'
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
* [Phalcon\Storage\Serializer\Msgpack](#storage-serializer-msgpack)
* [Phalcon\Storage\Serializer\None](#storage-serializer-none)
* [Phalcon\Storage\Serializer\Php](#storage-serializer-php)
* [Phalcon\Storage\Serializer\SerializerInterface](#storage-serializer-serializerinterface)
* [Phalcon\Storage\SerializerFactory](#storage-serializerfactory)

<h1 id="storage-adapter-abstractadapter">Abstract Class Phalcon\Storage\Adapter\AbstractAdapter</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/adapter/abstractadapter.zep)

| Namespace | Phalcon\Storage\Adapter | | Uses | DateInterval, DateTime, Phalcon\Helper\Arr, Phalcon\Helper\Str, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Storage\Serializer\SerializerInterface | | Implements | AdapterInterface |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

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
protected defaultSerializer = Php;

/**
 * Name of the default TTL (time to live)
 *
 * @var int
 */
protected lifetime = 3600;

/**
 * @var string
 */
protected prefix = ;

/**
 * Serializer
 *
 * @var SerializerInterface
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

Sets parameters based on options

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
abstract public function get( string $key, mixed $defaultValue = null ): mixed;
```

Reads data from the adapter

```php
abstract public function getAdapter(): mixed;
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
public function getPrefix(): string
```

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
public function setDefaultSerializer( string $defaultSerializer )
```

```php
protected function getFilteredKeys( mixed $keys, string $prefix ): array;
```

Filters the keys array based on global and passed prefix

@return array

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

@return int @throws Exception

```php
protected function getUnserializedData( mixed $content, mixed $defaultValue = null ): mixed;
```

Returns unserialized data

```php
protected function initSerializer(): void;
```

Initializes the serializer

<h1 id="storage-adapter-adapterinterface">Interface Phalcon\Storage\Adapter\AdapterInterface</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/adapter/adapterinterface.zep)

| Namespace | Phalcon\Storage\Adapter | | Uses | Phalcon\Storage\Serializer\SerializerInterface |

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

Stores data in the adapter

<h1 id="storage-adapter-apcu">Class Phalcon\Storage\Adapter\Apcu</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/adapter/apcu.zep)

| Namespace | Phalcon\Storage\Adapter | | Uses | APCuIterator, Phalcon\Helper\Arr, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Storage\Serializer\SerializerInterface | | Extends | AbstractAdapter |

Apcu adapter

## Properties

```php
/**
 * @var array
 */
protected options;

```

## Методы

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```

Constructor

```php
public function clear(): bool;
```

Flushes/clears the cache

```php
public function decrement( string $key, int $value = int ): int | bool;
```

Decrements a stored number

@return bool|int

```php
public function delete( string $key ): bool;
```

Reads data from the adapter

@return bool

```php
public function get( string $key, mixed $defaultValue = null ): mixed;
```

Reads data from the adapter

@return mixed

```php
public function getAdapter(): mixed;
```

Always returns null

@return null

```php
public function getKeys( string $prefix = string ): array;
```

Stores data in the adapter

@return array

```php
public function has( string $key ): bool;
```

Checks if an element exists in the cache

@return bool

```php
public function increment( string $key, int $value = int ): int | bool;
```

Increments a stored number

@return bool|int

```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```

Stores data in the adapter

@return bool @throws \Exception

<h1 id="storage-adapter-libmemcached">Class Phalcon\Storage\Adapter\Libmemcached</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/adapter/libmemcached.zep)

| Namespace | Phalcon\Storage\Adapter | | Uses | Phalcon\Helper\Arr, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Storage\Serializer\SerializerInterface | | Extends | AbstractAdapter |

Libmemcached adapter

## Properties

```php
/**
 * @var array
 */
protected options;

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

@return bool @throws Exception

```php
public function decrement( string $key, int $value = int ): int | bool;
```

Decrements a stored number

```php
public function delete( string $key ): bool;
```

Reads data from the adapter

@return bool @throws Exception

```php
public function get( string $key, mixed $defaultValue = null ): mixed;
```

Reads data from the adapter

@return mixed @throws Exception

```php
public function getAdapter(): mixed;
```

Returns the already connected adapter or connects to the Memcached server(s)

@return \Memcached @throws Exception

```php
public function getKeys( string $prefix = string ): array;
```

Stores data in the adapter

@return array

```php
public function has( string $key ): bool;
```

Checks if an element exists in the cache

@return bool @throws Exception

```php
public function increment( string $key, int $value = int ): int | bool;
```

Increments a stored number

@return bool|int @throws Exception

```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```

Stores data in the adapter

@return bool @throws Exception

<h1 id="storage-adapter-memory">Class Phalcon\Storage\Adapter\Memory</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/adapter/memory.zep)

| Namespace | Phalcon\Storage\Adapter | | Uses | Phalcon\Collection, Phalcon\Helper\Arr, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Storage\Serializer\SerializerInterface | | Extends | AbstractAdapter |

Memory adapter

## Properties

```php
/**
 * @var Collection
 */
protected data;

/**
 * @var array
 */
protected options;

```

## Методы

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```

Constructor

```php
public function clear(): bool;
```

Flushes/clears the cache

```php
public function decrement( string $key, int $value = int ): int | bool;
```

Decrements a stored number

@return bool|int

```php
public function delete( string $key ): bool;
```

Reads data from the adapter

@return bool

```php
public function get( string $key, mixed $defaultValue = null ): mixed;
```

Reads data from the adapter

@return mixed

```php
public function getAdapter(): mixed;
```

Always returns null

@return null

```php
public function getKeys( string $prefix = string ): array;
```

Stores data in the adapter

@return array

```php
public function has( string $key ): bool;
```

Checks if an element exists in the cache

@return bool

```php
public function increment( string $key, int $value = int ): int | bool;
```

Increments a stored number

@return bool|int

```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```

Stores data in the adapter

@return bool

<h1 id="storage-adapter-redis">Class Phalcon\Storage\Adapter\Redis</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/adapter/redis.zep)

| Namespace | Phalcon\Storage\Adapter | | Uses | Phalcon\Helper\Arr, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Storage\Serializer\SerializerInterface | | Extends | AbstractAdapter |

Redis adapter

## Properties

```php
/**
 * @var array
 */
protected options;

```

## Методы

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```

Constructor

```php
public function clear(): bool;
```

Flushes/clears the cache

@return bool @throws Exception

```php
public function decrement( string $key, int $value = int ): int | bool;
```

Decrements a stored number

@return bool|int @throws Exception

```php
public function delete( string $key ): bool;
```

Reads data from the adapter

@return bool @throws Exception

```php
public function get( string $key, mixed $defaultValue = null ): mixed;
```

Reads data from the adapter

@return mixed @throws Exception

```php
public function getAdapter(): mixed;
```

Returns the already connected adapter or connects to the Redis server(s)

@return mixed|\Redis @throws Exception

```php
public function getKeys( string $prefix = string ): array;
```

Gets the keys from the adapter. Accepts an optional prefix which will filter the keys returned

@return array @throws Exception

```php
public function has( string $key ): bool;
```

Checks if an element exists in the cache

@return bool @throws Exception

```php
public function increment( string $key, int $value = int ): int | bool;
```

Increments a stored number

@return bool|int @throws Exception

```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```

Stores data in the adapter

@return bool @throws Exception

<h1 id="storage-adapter-stream">Class Phalcon\Storage\Adapter\Stream</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/adapter/stream.zep)

| Namespace | Phalcon\Storage\Adapter | | Uses | FilesystemIterator, Iterator, Phalcon\Helper\Arr, Phalcon\Helper\Str, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Storage\Serializer\SerializerInterface, RecursiveDirectoryIterator, RecursiveIteratorIterator | | Extends | AbstractAdapter |

Stream adapter

## Properties

```php
/**
    * @var string
    */
protected storageDir = ;

/**
 * @var array
 */
protected options;

```

## Методы

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```

Stream constructor.

@throws Exception

```php
public function clear(): bool;
```

Flushes/clears the cache

```php
public function decrement( string $key, int $value = int ): int | bool;
```

Decrements a stored number

@return bool|int @throws \Exception

```php
public function delete( string $key ): bool;
```

Reads data from the adapter

@return bool

```php
public function get( string $key, mixed $defaultValue = null ): mixed;
```

Reads data from the adapter

@return mixed|null

```php
public function getAdapter(): mixed;
```

Always returns null

@return null

```php
public function getKeys( string $prefix = string ): array;
```

Stores data in the adapter

```php
public function has( string $key ): bool;
```

Checks if an element exists in the cache and is not expired

@return bool

```php
public function increment( string $key, int $value = int ): int | bool;
```

Increments a stored number

@return bool|int @throws \Exception

```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```

Stores data in the adapter

@return bool @throws \Exception

<h1 id="storage-adapterfactory">Class Phalcon\Storage\AdapterFactory</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/adapterfactory.zep)

| Namespace | Phalcon\Storage | | Uses | Phalcon\Factory\AbstractFactory, Phalcon\Storage\Adapter\AdapterInterface | | Extends | AbstractFactory |

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
protected function getAdapters(): array;
```

//

<h1 id="storage-exception">Class Phalcon\Storage\Exception</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/exception.zep)

| Namespace | Phalcon\Storage | | Extends | \Phalcon\Exception |

Phalcon\Storage\Exception

Exceptions thrown in Phalcon\Storage will use this class

<h1 id="storage-serializer-abstractserializer">Abstract Class Phalcon\Storage\Serializer\AbstractSerializer</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/serializer/abstractserializer.zep)

| Namespace | Phalcon\Storage\Serializer | | Uses | Phalcon\Storage\Exception | | Implements | SerializerInterface |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

## Properties

```php
/**
 * @var mixed
 */
protected data;

```

## Методы

```php
public function __construct( mixed $data = null );
```

    Constructor
    

```php
public function getData(): mixed;
```

@return mixed

```php
public function setData( mixed $data ): void;
```

```php
protected function isSerializable( mixed $data ): bool;
```

If this returns true, then the data returns back as is

<h1 id="storage-serializer-base64">Class Phalcon\Storage\Serializer\Base64</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/serializer/base64.zep)

| Namespace | Phalcon\Storage\Serializer | | Uses | InvalidArgumentException | | Extends | AbstractSerializer |

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
    

<h1 id="storage-serializer-igbinary">Class Phalcon\Storage\Serializer\Igbinary</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/serializer/igbinary.zep)

| Namespace | Phalcon\Storage\Serializer | | Extends | AbstractSerializer |

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
    

<h1 id="storage-serializer-json">Class Phalcon\Storage\Serializer\Json</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/serializer/json.zep)

| Namespace | Phalcon\Storage\Serializer | | Uses | InvalidArgumentException, JsonSerializable, Phalcon\Helper\Json | | Extends | AbstractSerializer |

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
    

<h1 id="storage-serializer-msgpack">Class Phalcon\Storage\Serializer\Msgpack</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/serializer/msgpack.zep)

| Namespace | Phalcon\Storage\Serializer | | Extends | AbstractSerializer |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

## Методы

```php
public function serialize(): string | null;
```

    Serializes data
    

```php
public function unserialize( mixed $data ): void;
```

    Unserializes data
    

<h1 id="storage-serializer-none">Class Phalcon\Storage\Serializer\None</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/serializer/none.zep)

| Namespace | Phalcon\Storage\Serializer | | Uses | InvalidArgumentException | | Extends | AbstractSerializer |

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
    

<h1 id="storage-serializer-php">Class Phalcon\Storage\Serializer\Php</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/serializer/php.zep)

| Namespace | Phalcon\Storage\Serializer | | Uses | InvalidArgumentException, Phalcon\Storage\Exception | | Extends | AbstractSerializer |

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
    

<h1 id="storage-serializer-serializerinterface">Interface Phalcon\Storage\Serializer\SerializerInterface</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/serializer/serializerinterface.zep)

| Namespace | Phalcon\Storage\Serializer | | Uses | Serializable | | Extends | Serializable |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

## Методы

```php
public function getData(): mixed;
```

@return mixed

```php
public function setData( mixed $data ): void;
```

<h1 id="storage-serializerfactory">Class Phalcon\Storage\SerializerFactory</h1>

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/storage/serializerfactory.zep)

| Namespace | Phalcon\Storage | | Uses | Phalcon\Factory\AbstractFactory, Phalcon\Storage\Serializer\SerializerInterface | | Extends | AbstractFactory |

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

@return SerializerInterface @throws Exception

```php
protected function getAdapters(): array;
```

//