---
layout: default
language: 'es-es'
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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cache.zep)

| Namespace | Phalcon | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Cache\Exception\Exception, Phalcon\Cache\Exception\InvalidArgumentException, Psr\SimpleCache\CacheInterface, Traversable | | Implements | CacheInterface |

Este componente ofrece capacidades de caché para su aplicación. Phalcon\Cache implementa PSR-16.

## Propiedades

```php
/**
 * The adapter
 *
 * @var AdapterInterface
 */
protected adapter;

```

## Métodos

```php
public function __construct( AdapterInterface $adapter );
```

Constructor.

```php
public function clear(): bool;
```

Limpia las claves de todo el caché.

```php
public function delete( mixed $key ): bool;
```

Elimina un elemento del caché por su clave única.

```php
public function deleteMultiple( mixed $keys ): bool;
```

Elimina múltiples elementos del caché en una única operación.

```php
public function get( mixed $key, mixed $defaultValue = null ): mixed;
```

Obtiene un valor del caché.

```php
public function getAdapter(): AdapterInterface
```

```php
public function getMultiple( mixed $keys, mixed $defaultValue = null ): mixed;
```

Obtiene múltiples elementos del caché usando sus claves únicas.

```php
public function has( mixed $key ): bool;
```

Determina si un elemento está presente en el caché.

```php
public function set( mixed $key, mixed $value, mixed $ttl = null ): bool;
```

Almacena datos en el caché, referenciados únicamente por una clave con un tiempo TTL de expiración opcional.

```php
public function setMultiple( mixed $values, mixed $ttl = null ): bool;
```

Almacena un conjunto de pares clave => valor en el cache, con un opcional TTL.

```php
protected function checkKey( mixed $key ): void;
```

Comprueba la clave. Si contiene caracteres inválidos lanzará una excepción

```php
protected function checkKeys( mixed $keys ): void;
```

Comprueba la clave. Si contiene caracteres inválidos lanzará una excepción

<h1 id="cache-adapter-adapterinterface">Interface Phalcon\Cache\Adapter\AdapterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cache/Adapter/AdapterInterface.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Storage\Adapter\AdapterInterface | | Extends | StorageAdapterInterface |

Interfaz para adaptadores Phalcon\Cache

<h1 id="cache-adapter-apcu">Class Phalcon\Cache\Adapter\Apcu</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cache/Adapter/Apcu.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Apcu | | Extends | StorageApcu | | Implements | CacheAdapterInterface |

Adaptador Apcu

<h1 id="cache-adapter-libmemcached">Class Phalcon\Cache\Adapter\Libmemcached</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cache/Adapter/Libmemcached.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Libmemcached | | Extends | StorageLibmemcached | | Implements | CacheAdapterInterface |

Adaptador Libmemcached

<h1 id="cache-adapter-memory">Class Phalcon\Cache\Adapter\Memory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cache/Adapter/Memory.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Memory | | Extends | StorageMemory | | Implements | CacheAdapterInterface |

Adaptador de Memoria

<h1 id="cache-adapter-redis">Class Phalcon\Cache\Adapter\Redis</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cache/Adapter/Redis.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Redis | | Extends | StorageRedis | | Implements | CacheAdapterInterface |

Adaptador Redis

<h1 id="cache-adapter-stream">Class Phalcon\Cache\Adapter\Stream</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cache/Adapter/Stream.zep)

| Namespace | Phalcon\Cache\Adapter | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Storage\Adapter\Stream | | Extends | StorageStream | | Implements | CacheAdapterInterface |

Adaptador de Flujo

<h1 id="cache-adapterfactory">Class Phalcon\Cache\AdapterFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cache/AdapterFactory.zep)

| Namespace | Phalcon\Cache | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Cache\Exception\Exception, Phalcon\Factory\AbstractFactory, Phalcon\Storage\SerializerFactory | | Extends | AbstractFactory |

Fábrica para crear adaptadores de Cache

## Propiedades

```php
/**
 * @var SerializerFactory
 */
private serializerFactory;

```

## Métodos

```php
public function __construct( SerializerFactory $factory = null, array $services = [] );
```

Constructor AdapterFactory.

```php
public function newInstance( string $name, array $options = [] ): AdapterInterface;
```

Crea una nueva instancia del adaptador

```php
protected function getAdapters(): array;
```

Devuelve los adaptadores disponibles

<h1 id="cache-cachefactory">Class Phalcon\Cache\CacheFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cache/CacheFactory.zep)

| Namespace | Phalcon\Cache | | Uses | Phalcon\Cache\Adapter\AdapterInterface, Phalcon\Cache, Psr\SimpleCache\CacheInterface, Phalcon\Cache\Exception\Exception, Phalcon\Config, Phalcon\Config\ConfigInterface, Phalcon\Helper\Arr |

Crea una nueva clase Cache

## Propiedades

```php
/**
 * @var AdapterFactory
 */
protected adapterFactory;

```

## Métodos

```php
public function __construct( AdapterFactory $factory );
```

Constructor

```php
public function load( mixed $config ): mixed;
```

Fábrica para crear una instancia desde un objeto Config

```php
public function newInstance( string $name, array $options = [] ): CacheInterface;
```

Construye una nueva instancia Cache.

<h1 id="cache-exception-exception">Class Phalcon\Cache\Exception\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cache/Exception/Exception.zep)

| Namespace | Phalcon\Cache\Exception | | Extends | \Phalcon\Exception | | Implements | \Psr\SimpleCache\CacheException |

Las excepciones lanzadas en Phalcon\Cache usarán esta clase

<h1 id="cache-exception-invalidargumentexception">Class Phalcon\Cache\Exception\InvalidArgumentException</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Cache/Exception/InvalidArgumentException.zep)

| Namespace | Phalcon\Cache\Exception | | Extends | \Phalcon\Exception | | Implements | \Psr\SimpleCache\InvalidArgumentException |

Las excepciones lanzadas en Phalcon\Cache usarán esta clase
