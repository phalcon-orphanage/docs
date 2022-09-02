---
layout: default
language: 'es-es'
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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Adapter/AbstractAdapter.zep)

| Namespace | Phalcon\Storage\Adapter | | Uses | DateInterval, DateTime, Phalcon\Helper\Arr, Phalcon\Helper\Str, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Storage\Serializer\SerializerInterface | | Implements | AdapterInterface |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

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

## Métodos

```php
protected function __construct( SerializerFactory $factory, array $options = [] );
```

Establece parámetros basándose en opciones

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
abstract public function get( string $key, mixed $defaultValue = null ): mixed;
```

Lee datos desde el adaptador

```php
abstract public function getAdapter(): mixed;
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
public function getPrefix(): string
```

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
public function setDefaultSerializer( string $defaultSerializer )
```

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

Almacena datos en el adaptador

<h1 id="storage-adapter-apcu">Class Phalcon\Storage\Adapter\Apcu</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Adapter/Apcu.zep)

| Namespace | Phalcon\Storage\Adapter | | Uses | APCuIterator, Phalcon\Helper\Arr, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Storage\Serializer\SerializerInterface | | Extends | AbstractAdapter |

Adaptador Apcu

## Propiedades

```php
/**
 * @var array
 */
protected options;

```

## Métodos

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```

Constructor

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
public function getAdapter(): mixed;
```

Siempre devuelve nulo

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

Almacena datos en el adaptador

<h1 id="storage-adapter-libmemcached">Class Phalcon\Storage\Adapter\Libmemcached</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Adapter/Libmemcached.zep)

| Namespace | Phalcon\Storage\Adapter | | Uses | Phalcon\Helper\Arr, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Storage\Serializer\SerializerInterface | | Extends | AbstractAdapter |

Adaptador Libmemcached

## Propiedades

```php
/**
 * @var array
 */
protected options;

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
public function get( string $key, mixed $defaultValue = null ): mixed;
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

Almacena datos en el adaptador

<h1 id="storage-adapter-memory">Class Phalcon\Storage\Adapter\Memory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Adapter/Memory.zep)

| Namespace | Phalcon\Storage\Adapter | | Uses | Phalcon\Collection, Phalcon\Collection\CollectionInterface, Phalcon\Helper\Arr, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Storage\Serializer\SerializerInterface | | Extends | AbstractAdapter |

Adaptador de Memoria

## Propiedades

```php
/**
 * @var Collection|CollectionInterface
 */
protected data;

/**
 * @var array
 */
protected options;

```

## Métodos

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```

Constructor

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
public function getAdapter(): mixed;
```

Siempre devuelve nulo

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

Almacena datos en el adaptador

<h1 id="storage-adapter-redis">Class Phalcon\Storage\Adapter\Redis</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Adapter/Redis.zep)

| Namespace | Phalcon\Storage\Adapter | | Uses | Phalcon\Helper\Arr, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Storage\Serializer\SerializerInterface | | Extends | AbstractAdapter |

Adaptador Redis

## Propiedades

```php
/**
 * @var array
 */
protected options;

```

## Métodos

```php
public function __construct( SerializerFactory $factory, array $options = [] );
```

Constructor

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

Devuelve el adaptador ya conectado o conecta al/los servidor/es de Redis

```php
public function getKeys( string $prefix = string ): array;
```

Obtiene las claves del adaptador. Acepta un prefijo opcional que filtrará las claves devueltas

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

Almacena datos en el adaptador. Si no se da ningún ttl, se usará el valor por defecto (3600s en este momento).

<h1 id="storage-adapter-stream">Class Phalcon\Storage\Adapter\Stream</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Adapter/Stream.zep)

| Namespace | Phalcon\Storage\Adapter | | Uses | FilesystemIterator, Iterator, Phalcon\Helper\Arr, Phalcon\Helper\Str, Phalcon\Storage\Exception, Phalcon\Storage\SerializerFactory, Phalcon\Storage\Serializer\SerializerInterface, RecursiveDirectoryIterator, RecursiveIteratorIterator | | Extends | AbstractAdapter |

Adaptador de Flujo

## Propiedades

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
public function getAdapter(): mixed;
```

Siempre devuelve nulo

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

Almacena datos en el adaptador

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
protected function getAdapters(): array;
```

<h1 id="storage-exception">Class Phalcon\Storage\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Exception.zep)

| Namespace | Phalcon\Storage | | Extends | \Phalcon\Exception |

Phalcon\Storage\Exception

Las excepciones lanzadas en Phalcon\Storage usarán esta clase

<h1 id="storage-serializer-abstractserializer">Abstract Class Phalcon\Storage\Serializer\AbstractSerializer</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/AbstractSerializer.zep)

| Namespace | Phalcon\Storage\Serializer | | Uses | Phalcon\Storage\Exception | | Implements | SerializerInterface |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Propiedades

```php
/**
 * @var mixed
 */
protected data;

```

## Métodos

```php
public function __construct( mixed $data = null );
```

Constructor

```php
public function getData(): mixed;
```

```php
public function setData( mixed $data ): void;
```

```php
protected function isSerializable( mixed $data ): bool;
```

Si devuelve verdadero, entonces los datos se devuelven tal cual

<h1 id="storage-serializer-base64">Class Phalcon\Storage\Serializer\Base64</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/Base64.zep)

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

<h1 id="storage-serializer-igbinary">Class Phalcon\Storage\Serializer\Igbinary</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/Igbinary.zep)

| Namespace | Phalcon\Storage\Serializer | | Extends | AbstractSerializer |

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

<h1 id="storage-serializer-json">Class Phalcon\Storage\Serializer\Json</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/Json.zep)

| Namespace | Phalcon\Storage\Serializer | | Uses | InvalidArgumentException, JsonSerializable, Phalcon\Helper\Json | | Extends | AbstractSerializer |

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

<h1 id="storage-serializer-msgpack">Class Phalcon\Storage\Serializer\Msgpack</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/Msgpack.zep)

| Namespace | Phalcon\Storage\Serializer | | Extends | AbstractSerializer |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Métodos

```php
public function serialize(): string | null;
```

Serializa los datos

```php
public function unserialize( mixed $data ): void;
```

Deserializa los datos

<h1 id="storage-serializer-none">Class Phalcon\Storage\Serializer\None</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/None.zep)

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

<h1 id="storage-serializer-php">Class Phalcon\Storage\Serializer\Php</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/Php.zep)

| Namespace | Phalcon\Storage\Serializer | | Uses | InvalidArgumentException, Phalcon\Storage\Exception | | Extends | AbstractSerializer |

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

<h1 id="storage-serializer-serializerinterface">Interface Phalcon\Storage\Serializer\SerializerInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Storage/Serializer/SerializerInterface.zep)

| Namespace | Phalcon\Storage\Serializer | | Uses | Serializable | | Extends | Serializable |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

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
protected function getAdapters(): array;
```
