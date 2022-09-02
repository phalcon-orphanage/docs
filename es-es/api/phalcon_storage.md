---
layout: default
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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Adapter/AbstractAdapter.zep)

| Namespace  | Phalcon\Storage\Adapter | | Uses       | DateInterval, DateTime, Exception, Phalcon\Storage\Serializer\SerializerInterface, Phalcon\Storage\SerializerFactory, Phalcon\Support\Exception | | Implements | AdapterInterface |

Class AbstractAdapter

@package Phalcon\Storage\Adapter

@property mixed               $adapter @property string              $defaultSerializer @property int                 $lifetime @property array               $options @property string              $prefix @property SerializerInterface $serializer @property SerializerFactory   $serializerFactory


## Propiedades
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

## Métodos

```php
protected function __construct( SerializerFactory $factory, array $options = [] );
```
AbstractAdapter constructor.


```php
abstract public function clear(): bool;
```
Vacía/Limpia la caché


```php
abstract public function decrement( string $key, int $value = int ): int | bool;
```
Decrementa el número almacenado


```php
abstract public function delete( string $key ): bool;
```
Borra datos desde el adaptador


```php
public function get( string $key, mixed $defaultValue = null ): mixed;
```
Lee datos desde el adaptador


```php
public function getAdapter(): mixed;
```
Devuelve el adaptador - se conecta al almacenamiento si no está conectado


```php
public function getDefaultSerializer(): string
```

```php
abstract public function getKeys( string $prefix = string ): array;
```
Devuelve todas las claves almacenadas


```php
public function getPrefix(): string;
```
Returns the prefix


```php
abstract public function has( string $key ): bool;
```
Comprueba si un elemento existe en el caché


```php
abstract public function increment( string $key, int $value = int ): int | bool;
```
Incrementa un número almacenado


```php
abstract public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```
Almacena datos en el adaptador


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
Filtra el vector de claves basado en global y el prefijo pasado


```php
protected function getPrefixedKey( mixed $key ): string;
```
Devuelve la clave solicitada, prefijada


```php
protected function getSerializedData( mixed $content ): mixed;
```
Devuelve datos serializados


```php
protected function getTtl( mixed $ttl ): int;
```
Calcula el TTL para un elemento de caché


```php
protected function getUnserializedData( mixed $content, mixed $defaultValue = null ): mixed;
```
Devuelve datos sin serializar


```php
protected function initSerializer(): void;
```
Inicializa el serializador

@throws SupportException




<h1 id="storage-adapter-adapterinterface">Interface Phalcon\Storage\Adapter\AdapterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Adapter/AdapterInterface.zep)

| Namespace | Phalcon\Storage\Adapter | | Uses | Phalcon\Storage\Serializer\SerializerInterface |

Interfaz para adaptadores Phalcon\Logger


## Métodos

```php
public function clear(): bool;
```
Vacía/Limpia la caché


```php
public function decrement( string $key, int $value = int ): int | bool;
```
Decrementa el número almacenado


```php
public function delete( string $key ): bool;
```
Borra datos desde el adaptador


```php
public function get( string $key, mixed $defaultValue = null ): mixed;
```
Lee datos desde el adaptador


```php
public function getAdapter(): mixed;
```
Devuelve el adaptador ya conectado o conecta al/los servidor/es de *backend*


```php
public function getKeys( string $prefix = string ): array;
```
Devuelve todas las claves almacenadas


```php
public function getPrefix(): string;
```
Devuelve el prefijo de las claves


```php
public function has( string $key ): bool;
```
Comprueba si un elemento existe en el caché


```php
public function increment( string $key, int $value = int ): int | bool;
```
Incrementa un número almacenado


```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```
Almacena datos en el adaptador. If the TTL is `null` (default) or not defined then the default TTL will be used, as set in this adapter. If the TTL is `0` or a negative number, a `delete()` will be issued, since this item has expired. If you need to set this key forever, you should use the `setForever()` method.


```php
public function setForever( string $key, mixed $value ): bool;
```
Stores data in the adapter forever. The key needs to manually deleted from the adapter.




<h1 id="storage-adapter-apcu">Class Phalcon\Storage\Adapter\Apcu</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Adapter/Apcu.zep)

| Namespace  | Phalcon\Storage\Adapter | | Uses       | APCuIterator, DateInterval, Exception, Phalcon\Storage\SerializerFactory, Phalcon\Support\Exception | | Extends    | AbstractAdapter |

Adaptador Apcu

@property array $options


## Propiedades
```php
/**
 * @var string
 */
protected prefix = ph-apcu-;

```

## Métodos

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```
Apcu constructor.


```php
public function clear(): bool;
```
Vacía/Limpia la caché


```php
public function decrement( string $key, int $value = int ): int | bool;
```
Decrementa el número almacenado


```php
public function delete( string $key ): bool;
```
Lee datos desde el adaptador


```php
public function getKeys( string $prefix = string ): array;
```
Almacena datos en el adaptador


```php
public function has( string $key ): bool;
```
Comprueba si un elemento existe en el caché


```php
public function increment( string $key, int $value = int ): int | bool;
```
Incrementa un número almacenado


```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```
Almacena datos en el adaptador. If the TTL is `null` (default) or not defined then the default TTL will be used, as set in this adapter. If the TTL is `0` or a negative number, a `delete()` will be issued, since this item has expired. If you need to set this key forever, you should use the `setForever()` method.


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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Adapter/Libmemcached.zep)

| Namespace  | Phalcon\Storage\Adapter | | Uses       | DateInterval, Exception, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Support\Exception | | Extends    | AbstractAdapter |

Adaptador Libmemcached


## Propiedades
```php
/**
 * @var string
 */
protected prefix = ph-memc-;

```

## Métodos

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```
Constructor Libmemcached.


```php
public function clear(): bool;
```
Vacía/Limpia la caché


```php
public function decrement( string $key, int $value = int ): int | bool;
```
Decrementa el número almacenado


```php
public function delete( string $key ): bool;
```
Lee datos desde el adaptador


```php
public function getAdapter(): mixed;
```
Devuelve el adaptador ya conectado o conecta al/los servidor/es de Memcached


```php
public function getKeys( string $prefix = string ): array;
```
Almacena datos en el adaptador


```php
public function has( string $key ): bool;
```
Comprueba si un elemento existe en el caché


```php
public function increment( string $key, int $value = int ): int | bool;
```
Incrementa un número almacenado


```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```
Almacena datos en el adaptador. If the TTL is `null` (default) or not defined then the default TTL will be used, as set in this adapter. If the TTL is `0` or a negative number, a `delete()` will be issued, since this item has expired. If you need to set this key forever, you should use the `setForever()` method.


```php
public function setForever( string $key, mixed $value ): bool;
```
Stores data in the adapter forever. The key needs to manually deleted from the adapter.




<h1 id="storage-adapter-memory">Class Phalcon\Storage\Adapter\Memory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Adapter/Memory.zep)

| Namespace  | Phalcon\Storage\Adapter | | Uses       | DateInterval, Exception, Phalcon\Storage\SerializerFactory, Phalcon\Support\Exception | | Extends    | AbstractAdapter |

Adaptador de Memoria

@property array $data @property array $options


## Propiedades
```php
/**
 * @var array
 */
protected data;

```

## Métodos

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```
Memory constructor.


```php
public function clear(): bool;
```
Vacía/Limpia la caché


```php
public function decrement( string $key, int $value = int ): int | bool;
```
Decrementa el número almacenado


```php
public function delete( string $key ): bool;
```
Borra datos desde el adaptador


```php
public function getKeys( string $prefix = string ): array;
```
Almacena datos en el adaptador


```php
public function has( string $key ): bool;
```
Comprueba si un elemento existe en el caché


```php
public function increment( string $key, int $value = int ): int | bool;
```
Incrementa un número almacenado


```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```
Almacena datos en el adaptador. If the TTL is `null` (default) or not defined then the default TTL will be used, as set in this adapter. If the TTL is `0` or a negative number, a `delete()` will be issued, since this item has expired. If you need to set this key forever, you should use the `setForever()` method.


```php
public function setForever( string $key, mixed $value ): bool;
```
Stores data in the adapter forever. The key needs to manually deleted from the adapter.


```php
protected function doGet( string $key );
```





<h1 id="storage-adapter-redis">Class Phalcon\Storage\Adapter\Redis</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Adapter/Redis.zep)

| Namespace  | Phalcon\Storage\Adapter | | Uses       | DateInterval, Exception, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Support\Exception | | Extends    | AbstractAdapter |

Adaptador Redis

@property array $options


## Propiedades
```php
/**
 * @var string
 */
protected prefix = ph-reds-;

```

## Métodos

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```
Redis constructor.


```php
public function clear(): bool;
```
Vacía/Limpia la caché


```php
public function decrement( string $key, int $value = int ): int | bool;
```
Decrementa el número almacenado


```php
public function delete( string $key ): bool;
```
Lee datos desde el adaptador


```php
public function getAdapter(): mixed;
```
Devuelve el adaptador ya conectado o conecta al/los servidor/es de Redis


```php
public function getKeys( string $prefix = string ): array;
```
Almacena datos en el adaptador


```php
public function has( string $key ): bool;
```
Comprueba si un elemento existe en el caché


```php
public function increment( string $key, int $value = int ): int | bool;
```
Incrementa un número almacenado


```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```
Almacena datos en el adaptador. If the TTL is `null` (default) or not defined then the default TTL will be used, as set in this adapter. If the TTL is `0` or a negative number, a `delete()` will be issued, since this item has expired. If you need to set this key forever, you should use the `setForever()` method.


```php
public function setForever( string $key, mixed $value ): bool;
```
Stores data in the adapter forever. The key needs to manually deleted from the adapter.




<h1 id="storage-adapter-stream">Class Phalcon\Storage\Adapter\Stream</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Adapter/Stream.zep)

| Namespace  | Phalcon\Storage\Adapter | | Uses       | DateInterval, FilesystemIterator, Iterator, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Storage\Traits\StorageErrorHandlerTrait, Phalcon\Support\Exception, RecursiveDirectoryIterator, RecursiveIteratorIterator | | Extends    | AbstractAdapter |

Adaptador de Flujo

@property string $storageDir @property array  $options


## Propiedades
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

## Métodos

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```
Constructor Stream.


```php
public function clear(): bool;
```
Vacía/Limpia la caché


```php
public function decrement( string $key, int $value = int ): int | bool;
```
Decrementa el número almacenado


```php
public function delete( string $key ): bool;
```
Lee datos desde el adaptador


```php
public function get( string $key, mixed $defaultValue = null ): mixed;
```
Lee datos desde el adaptador


```php
public function getKeys( string $prefix = string ): array;
```
Almacena datos en el adaptador


```php
public function has( string $key ): bool;
```
Comprueba si un elemento existe en el caché y no ha expirado


```php
public function increment( string $key, int $value = int ): int | bool;
```
Incrementa un número almacenado


```php
public function set( string $key, mixed $value, mixed $ttl = null ): bool;
```
Almacena datos en el adaptador. If the TTL is `null` (default) or not defined then the default TTL will be used, as set in this adapter. If the TTL is `0` or a negative number, a `delete()` will be issued, since this item has expired. If you need to set this key forever, you should use the `setForever()` method.


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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/AdapterFactory.zep)

| Namespace | Phalcon\Storage | | Uses | Phalcon\Factory\AbstractFactory, Phalcon\Storage\Adapter\AdapterInterface | | Extends | AbstractFactory |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.


## Propiedades
```php
/**
 * @var SerializerFactory
 */
private serializerFactory;

```

## Métodos

```php
public function __construct( SerializerFactory $factory, array $services = [] );
```
Constructor AdapterFactory.


```php
public function newInstance( string $name, array $options = [] ): AdapterInterface;
```
Crea una nueva instancia del adaptador


```php
protected function getExceptionClass(): string;
```

```php
protected function getServices(): array;
```
Devuelve los adaptadores disponibles




<h1 id="storage-exception">Class Phalcon\Storage\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Exception.zep)

| Namespace  | Phalcon\Storage | | Extends    | \Exception |

Phalcon\Storage\Exception

Las excepciones lanzadas en Phalcon\Storage usarán esta clase




<h1 id="storage-serializer-abstractserializer">Abstract Class Phalcon\Storage\Serializer\AbstractSerializer</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/AbstractSerializer.zep)

| Namespace  | Phalcon\Storage\Serializer | | Implements | SerializerInterface |



## Propiedades
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

## Métodos

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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/Base64.zep)

| Namespace | Phalcon\Storage\Serializer | | Uses | InvalidArgumentException | | Extends | AbstractSerializer |



## Métodos

```php
public function serialize(): string;
```
Serializa los datos


```php
public function unserialize( mixed $data ): void;
```
Deserializa los datos


```php
protected function phpBase64Decode( string $input, bool $strict = bool );
```
Wrapper for base64_decode




<h1 id="storage-serializer-igbinary">Class Phalcon\Storage\Serializer\Igbinary</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/Igbinary.zep)

| Namespace | Phalcon\Storage\Serializer | | Extends | AbstractSerializer |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.


## Métodos

```php
public function serialize();
```
Serializa los datos


```php
public function unserialize( mixed $data ): void;
```
Deserializa los datos


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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/Json.zep)

| Namespace  | Phalcon\Storage\Serializer | | Uses       | InvalidArgumentException, JsonSerializable | | Extends    | AbstractSerializer |



## Métodos

```php
public function serialize();
```
Serializa los datos


```php
public function unserialize( mixed $data ): void;
```
Deserializa los datos




<h1 id="storage-serializer-memcachedigbinary">Class Phalcon\Storage\Serializer\MemcachedIgbinary</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/MemcachedIgbinary.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | None |

Serializer using the built-in Memcached 'igbinary' serializer



<h1 id="storage-serializer-memcachedjson">Class Phalcon\Storage\Serializer\MemcachedJson</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/MemcachedJson.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | None |

Serializer using the built-in Memcached 'json' serializer



<h1 id="storage-serializer-memcachedphp">Class Phalcon\Storage\Serializer\MemcachedPhp</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/MemcachedPhp.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | None |

Serializer using the built-in Memcached 'php' serializer



<h1 id="storage-serializer-msgpack">Class Phalcon\Storage\Serializer\Msgpack</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/Msgpack.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | Igbinary |


## Métodos

```php
protected function doSerialize( mixed $value ): string;
```
Serializa los datos


```php
protected function doUnserialize( mixed $value );
```





<h1 id="storage-serializer-none">Class Phalcon\Storage\Serializer\None</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/None.zep)

| Namespace | Phalcon\Storage\Serializer | | Extends | AbstractSerializer |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.


## Métodos

```php
public function serialize(): mixed;
```
Serializa los datos


```php
public function unserialize( mixed $data ): void;
```
Deserializa los datos




<h1 id="storage-serializer-php">Class Phalcon\Storage\Serializer\Php</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/Php.zep)

| Namespace | Phalcon\Storage\Serializer | | Uses | InvalidArgumentException | | Extends | AbstractSerializer |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.


## Métodos

```php
public function serialize(): string;
```
Serializa los datos


```php
public function unserialize( mixed $data ): void;
```
Deserializa los datos




<h1 id="storage-serializer-redisigbinary">Class Phalcon\Storage\Serializer\RedisIgbinary</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/RedisIgbinary.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | None |

Serializer using the built-in Redis 'igbinary' serializer



<h1 id="storage-serializer-redisjson">Class Phalcon\Storage\Serializer\RedisJson</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/RedisJson.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | None |

Serializer using the built-in Redis 'json' serializer



<h1 id="storage-serializer-redismsgpack">Class Phalcon\Storage\Serializer\RedisMsgpack</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/RedisMsgpack.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | None |

Serializer using the built-in Redis 'msgpack' serializer



<h1 id="storage-serializer-redisnone">Class Phalcon\Storage\Serializer\RedisNone</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/RedisNone.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | None |

Serializer using the built-in Redis 'none' serializer



<h1 id="storage-serializer-redisphp">Class Phalcon\Storage\Serializer\RedisPhp</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/RedisPhp.zep)

| Namespace  | Phalcon\Storage\Serializer | | Extends    | None |

Serializer using the built-in Redis 'php' serializer



<h1 id="storage-serializer-serializerinterface">Interface Phalcon\Storage\Serializer\SerializerInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/SerializerInterface.zep)

| Namespace | Phalcon\Storage\Serializer | | Uses | Serializable | | Extends | Serializable |



## Métodos

```php
public function getData(): mixed;
```

```php
public function setData( mixed $data ): void;
```





<h1 id="storage-serializerfactory">Class Phalcon\Storage\SerializerFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/SerializerFactory.zep)

| Namespace | Phalcon\Storage | | Uses | Phalcon\Factory\AbstractFactory, Phalcon\Storage\Serializer\SerializerInterface | | Extends | AbstractFactory |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.


## Métodos

```php
public function __construct( array $services = [] );
```
Constructor SerializerFactory.


```php
public function newInstance( string $name ): SerializerInterface;
```

```php
protected function getExceptionClass(): string;
```

```php
protected function getServices(): array;
```
Devuelve los adaptadores disponibles
