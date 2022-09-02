---
layout: default
title: 'Registro'
upgrade: '#storage'
keywords: 'storage, stream, redis, memcached'
---

# Storage Component
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
The `Phalcon\Storage` namespace contains components that help with storing data in different storages. The component is heavily integrated in [Phalcon\Cache\Cache](cache) as well as [Phalcon\Session](session). It offers serialization of data based on various serialization adapters, and storage of data based on various storage adapters. Factories help with the creation of all necessary objects for the component to work.

## Serializadores
The `Phalcon\Storage\Serializer` namespace offers classes that implement the [Serializable][serializable] interface and thus expose the `serialize` and `unserialize` methods. El propósito de estas clases es transformar los datos antes de guardarlos en el almacén y después recuperarlos del almacén.

> **NOTE**: The default serializer for all adapters is `Phalcon\Storage\Serializer\Php` which uses PHP's `serialize` and `unserialize` methods. Éstos métodos se adaptan a la mayoría de aplicaciones. However, the developer might want to use something more efficient such as [igbinary][igbinary] which is faster and achieves a better compression. 
> 
> {: .alert .alert-info }

The storage adapter can be configured to use a different serializer. Los serializadores disponibles son:

### `Base64`
Este serializador usa los métodos `base64_encode` y `base64_decode` para serializar los datos. La entrada debe ser del tipo `string`, por lo que este serializador tiene limitaciones evidentes

### `Igbinary`
La serialización de `igbinary` se basa en los métodos `igbinary_serialize` y `igbinary_unserialize`. Those methods are exposed via the [igbinary][igbinary] PHP extension, which has to be installed and loaded on the target system.

### `Json`
El serializador `JSON` usa `json_encode` y `json_decode`. El sistema de destino debe tener soporte JSON disponible para PHP.

### `MemcachedIgbinary`
This serializer can be used when using `Memcached`. It corresponds to the built-in Igbinary serializer that `Memcached` has.

### `MemcachedJson`
This serializer can be used when using `Memcached`. It corresponds to the built-in JSON serializer that `Memcached` has.

### `MemcachedPhp`
This serializer can be used when using `Memcached`. It corresponds to the built-in PHP serializer that `Memcached` has.

### `Msgpack`
Similar a `igbinary` el serializador `msgpack` usa `msgpack_pack` y `msgpack_unpack` para serializar y desserializar datos. Este, junto con `igbinary` es uno de los serializadores más rápidos y eficientes. However, it requires that the [msgpack][msgpack] PHP extension is loaded on the target system.

### `None`
Este serializador no transforma los datos en absoluto. Tanto `serialize` como `unserialize` obtienen y almacenan los datos sin alterarlos.

### `Php`
Este es el serializador predeterminado. Usa los métodos PHP `serialize` y `unserialize` para transformar los datos.

### `RedisIgbinary`
This serializer can be used when using `Redis`. It corresponds to the built-in Igbinary serializer that `Redis` has.

### `RedisJson`
This serializer can be used when using `Redis`. It corresponds to the built-in JSON serializer that `Redis` has.

### `RedisMsgpack`
This serializer can be used when using `Redis`. It corresponds to the built-in Msgpack serializer that `Redis` has.

### `RedisNone`
This serializer can be used when using `Redis`. It corresponds to the built-in None serializer that `Redis` has.

### `RedisPhp`
This serializer can be used when using `Redis`. It corresponds to the built-in PHP serializer that `Redis` has.


### Personalizado
Phalcon also offers the [Phalcon\Storage\Serializer\SerializerInterface][storage-serializer-serializerinterface]` which can be implemented in a custom class. La clase puede ofrecer la serialización que necesite.

```php
<?php

namespace MyApp\Storage\Serializer;

use Phalcon\Storage\SerializerInterface;

class Garble implements SerializerInterface
{
    /**
     * #01
     * 
     * @var string
     */
    private $data = '';

    /**
     * #02
     * 
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }       

    /**
     * #03
     */
    public function serialize(): string
    {
        return rot13($this->data);
    }

    /**
     * #04
     * 
     * @var Garble
     *
     * @return Garble
     */
    public function setData($data): Garble
    {
        $this->data = (string) $data;

        return $this;
    }       

    /**
     * #05
     */
    public function unserialize($data): void
    {
        $this->data = str_rot13($data);
    }
}
```
> **Legend**
> 
> 1. Data storage
> 
> 2. Return the stored data
> 
> 3. Serializa los datos
> 
> 4. Set the data
> 
> 5. Deserializa los datos 
>     
>     {: .alert .alert-info }

Usándolo:
```php
<?php

namespace MyApp;

use MyApp\Storage\Serializer\Garble;

$data = 'I came, I saw, I conquered.';
$garble = new Garble();

$garble
    ->setData($data)
    ->serialize()  
;

echo $garble->getData(); // "V pnzr, V fnj, V pbadhrerq."

$encrypted = 'V pnzr, V fnj, V pbadhrerq.';

$garble->unserialize($encrypted);

echo $garble->getData(); // "I came, I saw, I conquered."
```

## Fábrica de Serializador
Although all serializer classes can be instantiated using the `new` keyword, Phalcon offers the [Phalcon\Storage\SerializerFactory][storage-serializerfactory] class, so that developers can easily instantiate serializer classes. Todos los serializadores anteriores están registrados en la fábrica y son cargados perezosamente cuando se llaman. La fábrica también le permite registrar clases de serializadores adicionales (personalizadas). Lo único a considerar es elegir el nombre del serializador en comparación con los ya existentes. Si define el mismo nombre, sobreescribirá el integrado. Los objetos son cacheados en la fábrica, así que si llama al método `newInstance()` con los mismos parámetros durante la misma petición, recibirá el mismo objeto de vuelta.

El siguiente ejemplo muestra como podemos crear un serializador `Json` usando la palabra clave `new` o la fábrica:

```php
<?php

use Phalcon\Storage\Serializer\Json; 
use Phalcon\Storage\SerializerFactory;

$jsonSerializer = new Json();

$factory        = new SerializerFactory();
$jsonSerializer = $factory->newInstance('json');
```
Los parámetros que puede usar para la fábrica son:

| **Nombre**           | **Clase**                                                                                |
| -------------------- | ---------------------------------------------------------------------------------------- |
| `base64`             | [Phalcon\Storage\Serializer\Base64][storage-serializer-base64]                        |
| `igbinary`           | [Phalcon\Storage\Serializer\Igbinary][storage-serializer-igbinary]                    |
| `json`               | [Phalcon\Storage\Serializer\Json][storage-serializer-json]                            |
| `memcached_igbinary` | [Phalcon\Storage\Serializer\MemcachedIgbinary][storage-serializer-memcached-igbinary] |
| `memcached_json`     | [Phalcon\Storage\Serializer\MemcachedJson][storage-serializer-memcached-json]         |
| `memcached_php`      | [Phalcon\Storage\Serializer\MemcachedPhp][storage-serializer-memcached-php]           |
| `msgpack`            | [Phalcon\Storage\Serializer\Msgpack][storage-serializer-msgpack]                      |
| `none`               | [Phalcon\Storage\Serializer\None][storage-serializer-none]                            |
| `php`                | [Phalcon\Storage\Serializer\Php][storage-serializer-php]                              |
| `redis_igbinary`     | [Phalcon\Storage\Serializer\RedisIgbinary][storage-serializer-redis-igbinary]         |
| `redis_json`         | [Phalcon\Storage\Serializer\RedisJson][storage-serializer-redis-json]                 |
| `redis_msgpack`      | [Phalcon\Storage\Serializer\RedisMsgpack][storage-serializer-redis-msgpack]           |
| `redis_none`         | [Phalcon\Storage\Serializer\RedisNone][storage-serializer-redis-none]                 |
| `redis_php`          | [Phalcon\Storage\Serializer\RedisPhp][storage-serializer-redis-php]                   |

## Adaptadores
The `Phalcon\Storage\Adapter` namespace offers classes that implement the [Phalcon\Storage\Adapter\AdapterInterface][storage-adapter-adapterinterface] interface. It exposes common methods that are used to perform operations on the storage adapter. Estos adaptadores actúan como envoltorios de su respectivo código de *backend*.

The available methods are:

| Método       | Descripción                                                           |
| ------------ | --------------------------------------------------------------------- |
| `clear`      | Flushes/clears the store                                              |
| `decrement`  | Decrementa el número almacenado                                       |
| `delete`     | Borra datos desde el adaptador                                        |
| `get`        | Lee datos desde el adaptador                                          |
| `getAdapter` | Devuelve el adaptador ya conectado o conecta al servidor de *backend* |
| `getKeys`    | Devuelve todas las claves almacenadas (parámetro de filtro opcional)  |
| `getPrefix`  | Devuelve el prefijo de las claves                                     |
| `has`        | Checks if an element exists in the store                              |
| `increment`  | Incrementa un número almacenado                                       |
| `set`        | Almacena datos en el adaptador                                        |

> **NOTE**: The `getAdapter()` method returns the connected adapter. Esto ofrece más flexibilidad al desarrollador, ya que se puede usar para ejecutar métodos adicionales que ofrece cada adaptador. Por ejemplo, para el adaptador `Redis` puede usar `getAdapter()` para obtener el objeto conectado y llamar `zAdd`, `zRange` y otros métodos no expuestos por el adaptador Phalcon. 
> 
> {: .alert .alert-info }

To construct one of these objects, you will need to pass a [Phalcon\Storage\SerializerFactory][storage-serializerfactory] object in the constructor and optionally some parameters required for the adapter of your choice. La lista de opciones se describe a continuación.

Los adaptadores disponibles son:

### `Apcu`
Este adaptador usa `Apcu` para almacenar los datos. In order to use this adapter, you will need to have [apcu][apcu] enabled in your target system. This class does not use an actual _adapter_, since the `apcu` functionality is exposed using the `apcu_*` PHP functions.

| Opción              | Predeterminado |
| ------------------- | -------------- |
| `defaultSerializer` | `Php`          |
| `lifetime`          | `3600`         |
| `serializer`        | `null`         |
| `prefix`            | `ph-apcu-`     |

The following example demonstrates how to create a new `Apcu` storage adapter, which will use the [Phalcon\Storage\Serializer\Json][storage-serializer-json] serializer and have a default lifetime of 7200.

```php
<?php

use Phalcon\Storage\Adapter\Apcu;
use Phalcon\Storage\SerializerFactory;

$serializerFactory = new SerializerFactory();

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200,
];

$adapter = new Apcu($serializerFactory, $options);
```

The above example used a [Phalcon\Storage\SerializerFactory][storage-serializerfactory] object and the `defaultSerializer` option to tell the adapter to instantiate the relevant serializer.

### `Libmemcached`
This adapter utilizes PHP's [memcached][memcached] extension to connect to Memcached servers. El adaptador usado es una instancia de la clase `Memcached`, creada después del primer evento que requiera que la conexión esté activa.

| Opción                                           | Predeterminado                         |
| ------------------------------------------------ | -------------------------------------- |
| `defaultSerializer`                              | `Php`                                  |
| `lifetime`                                       | `3600`                                 |
| `serializer`                                     | `null`                                 |
| `prefix`                                         | `ph-memc-`                             |
| `servers[0]['host']`                             | `127.0.0.1`                            |
| `servers[0]['port']`                             | `11211`                                |
| `servers[0]['weight']`                           | `1`                                    |
| `persistentId`                                   | `ph-mcid-`                             |
| `saslAuthData['user']`                           |                                        |
| `saslAuthData['pass']`                           |                                        |
| `client[\Memcached::OPT_CONNECT_TIMEOUT]`       | `10`                                   |
| `client[\Memcached::OPT_DISTRIBUTION]`          | `\Memcached::DISTRIBUTION_CONSISTENT` |
| `client[\Memcached::OPT_SERVER_FAILURE_LIMIT]`  | `2`                                    |
| `client[\Memcached::OPT_REMOVE_FAILED_SERVERS]` | `true`                                 |
| `client[\Memcached::OPT_RETRY_TIMEOUT]`         | `1`                                    |

Puede especificar más de un servidor en el vector de las opciones pasadas en el constructor. Si se definen datos `SASL`, el adaptador intentará autenticarse usando los datos pasados. Si hay un error en las opciones o la clase no puede añadir uno o más servidores al *pool*, se lanzará `Phalcon\Storage\Exception`.

The following example demonstrates how to create a new `Libmemcached` storage adapter, which will use the [Phalcon\Storage\Serializer\Json][storage-serializer-json] serializer and have a default lifetime of 7200. Usará `10.4.13.100` como primer servidor con peso `1` conectando al puerto `11211` y `10.4.13.110` como segundo servidor con peso `5` otra vez conectando al puerto `11211`.

```php
<?php

use Phalcon\Storage\Adapter\Libmemcached;
use Phalcon\Storage\SerializerFactory;

$serializerFactory = new SerializerFactory();

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200,
    'servers'           => [
        0 => [
            'host'   => '10.4.13.100',
            'port'   => 11211,
            'weight' => 1,
        ],
        1 => [
            'host'   => '10.4.13.110',
            'port'   => 11211,
            'weight' => 5,
        ],
    ],
];

$adapter = new Libmemcached($serializerFactory, $options);
```

The above example used a [Phalcon\Storage\SerializerFactory][storage-serializerfactory] object and the `defaultSerializer` option to tell the adapter to instantiate the relevant serializer.

**Serializers**: The `Memcached` class which is the adapter that the [Phalcon\Storage\Adapter\Libmemcached][storage-adapter-libmemcached] uses, offers support for serializing out of the box. Los serializadores integrados son:

* `\Memcached::SERIALIZER_PHP`
* `\Memcached::SERIALIZER_JSON`
* `\Memcached::SERIALIZER_IGBINARY`

The [igbinary][igbinary] built-in serializer is only available if `igbinary` is present in the target system and [Memcached][memcached] extension is compiled with it. To enable these serializers, you can use the [Phalcon\Storage\Serializer\MemcachedIgbinary][storage-serializer-memcached-igbinary], [Phalcon\Storage\Serializer\MemcachedJson][storage-serializer-memcached-json] or [Phalcon\Storage\Serializer\MemcachedPhp][storage-serializer-memcached-php]

### `Memory`
Este adaptador usa la memoria del ordenador para almacenar los datos. Como todos los datos se almacenan en memoria, no hay persistencia, lo que significa que una vez la petición se ha completado, se pierden los datos. Este adaptador se puede usar para testear o almacenar temporalmente durante una petición determinada. Las opciones disponibles para el constructor son:

| Opción              | Predeterminado |
| ------------------- | -------------- |
| `defaultSerializer` | `Php`          |
| `lifetime`          | `3600`         |
| `serializer`        | `null`         |
| `prefix`            | `ph-memo-`     |

The following example demonstrates how to create a new `Memory` storage adapter, which will use the [Phalcon\Storage\Serializer\Json][storage-serializer-json] serializer and have a default lifetime of 7200.

```php
<?php

use Phalcon\Storage\Adapter\Memory;
use Phalcon\Storage\SerializerFactory;

$serializerFactory = new SerializerFactory();

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200,
];

$adapter = new Memory($serializerFactory, $options);
```

The above example used a [Phalcon\Storage\SerializerFactory][storage-serializerfactory] object and the `defaultSerializer` option to tell the adapter to instantiate the relevant serializer.

### `Redis`
This adapter utilizes PHP's [redis][redis] extension to connect to a Redis server. El adaptador usado es una instancia de la clase `Redis`, creada después del primer evento que requiera que la conexión esté activa.

| Opción              | Predeterminado |
| ------------------- | -------------- |
| `defaultSerializer` | `Php`          |
| `lifetime`          | `3600`         |
| `serializer`        | `null`         |
| `prefix`            | `ph-reds-`     |
| `host`              | `127.0.0.1`    |
| `port`              | `6379`         |
| `index`             | `1`            |
| `persistent`        | `false`        |
| `auth`              |                |
| `socket`            |                |

Si se definen los datos `auth`, el adaptador intentará autenticarse usando los datos pasados. Si hay un error en las opciones, o el servidor no puede conectar o autenticarse, se lanzará `Phalcon\Storage\Exception`.

The following example demonstrates how to create a new `Redis` storage adapter, which will use the [Phalcon\Storage\Serializer\Json][storage-serializer-json] serializer and have a default lifetime of 7200. Usará `10.4.13.100` como servidor, conectará al puerto `6379` y seleccionará el índice `1`.

```php
<?php

use Phalcon\Storage\Adapter\Redis;
use Phalcon\Storage\SerializerFactory;

$serializerFactory = new SerializerFactory();

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200,
    'host'              => '10.4.13.100',
    'port'              => 6379,
    'index'             => 1,
];

$adapter = new Redis($serializerFactory, $options);
```

The above example used a [Phalcon\Storage\SerializerFactory][storage-serializerfactory] object and the `defaultSerializer` option to tell the adapter to instantiate the relevant serializer.

**Serializers**: The `Redis` class which is the adapter that the [Phalcon\Storage\Adapter\Redis][storage-adapter-redis] uses, offers support for serializing out of the box. Los serializadores integrados son:

* `\Redis::SERIALIZER_NONE`
* `\Redis::SERIALIZER_PHP`
* `\Redis::SERIALIZER_IGBINARY`
* `\Redis::SERIALIZER_MSGPACK`

The [igbinary][igbinary] and built-in serializer is only available if `igbinary` is present in the target system and [Redis][redis] extension is compiled with it. The same applies to [msgpack][msgpack] built-in serializer. It is only available if `msgpack` is present in the target system and the [Redis][redis] extension is compiled with it. To enable these serializers, you can use the [Phalcon\Storage\Serializer\RedisIgbinary][storage-serializer-redis-igbinary], [Phalcon\Storage\Serializer\RedisJson][storage-serializer-redis-json], [Phalcon\Storage\Serializer\RedisMsgpack][storage-serializer-redis-msgpack], [Phalcon\Storage\Serializer\RedisNone][storage-serializer-redis-none] or [Phalcon\Storage\Serializer\RedisPhp][storage-serializer-redis-php].

**NOTE** `increment` - `decrement`

En este momento hay un problema con `Redis`, donde el serializador interno `Redis` no omite valores escalares porque sólo puede almacenar cadenas. Como resultado, si usas `increment` después de un `set` para un número, no devolverá un número:

La forma de almacenar números y utilizar el `increment` (o `decrement`) es eliminar el serializador interno para `Redis`

```php
$storage->getAdapter()->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_NONE);
```

o podría usar `increment` en lugar de usar `set` en el primer ajuste del valor de la clave:

```php
$storage->delete('my-key');
$storage->increment('my-key', 2);
echo $storage->get('my-key');      // 2
$storage->increment('my-key', 3);
echo $storage->get('my-key');      // 3
```

### `Flujo (Stream)`
This adapter is the simplest to set up since it uses the target system's file system (it only requires a storage path that is writeable). It is one of the slowest storage adapters since the data has to be written to the file system. Cada fichero creado corresponde a una clave almacenada. The file contains additional metadata to calculate the lifetime of the storage element, resulting in additional reads and writes to the file system.

| Opción              | Predeterminado |
| ------------------- | -------------- |
| `defaultSerializer` | `Php`          |
| `lifetime`          | `3600`         |
| `serializer`        | `null`         |
| `prefix`            | `phstrm-`      |
| `storageDir`        |                |

Si no se define `storageDir` se lanzará `Phalcon\Storage\Exception`.

> **NOTE**: The adapter utilizes logic to store files in separate subdirectories based on the name of the key passed, thus avoiding the `too many files in one folder` limit present in Windows or Linux based systems. 
> 
> {: .alert .alert-info }

The following example demonstrates how to create a new `Stream` storage adapter, which will use the [Phalcon\Storage\Serializer\Json][storage-serializer-json] serializer and have a default lifetime of 7200. It will store the data in `/data/storage`.

```php
<?php

use Phalcon\Storage\Adapter\Stream;
use Phalcon\Storage\SerializerFactory;

$serializerFactory = new SerializerFactory();

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200,
    'storageDir'        => '/data/storage',
];

$adapter = new Stream($serializerFactory, $options);
```

The above example used a [Phalcon\Storage\SerializerFactory][storage-serializerfactory] object and the `defaultSerializer` option to tell the adapter to instantiate the relevant serializer.

### Personalizado
Phalcon also offers the [Phalcon\Storage\Adapter\AdapterInterface][storage-adapter-adapterinterface] which can be implemented in a custom class. The class can offer the storage adapter functionality you require.

```php
<?php

namespace MyApp\Storage\Adapter;

use Phalcon\Storage\Adapter\AdapterInterface;

class Custom implements AdapterInterface
{
    /**
     * #01
     */
    public function clear(): bool
    {
        // #02
    }

    /**
     * #03
     */
    public function decrement(string $key, int $value = 1)
    {
        // #04
    }

    /**
     * #05
     */
    public function delete(string $key): bool
    {
        // #06
    }

    /**
     * #07
     */
    public function get(string $key)
    {
        // #08
    }

    /**
     * #09
     */
    public function getAdapter()
    {
        // #10
    }

    /**
     * #11 
     */
    public function getKeys(string $prefix = ""): array
    {
        // #12
    }

    /**
     * #13
     */
    public function getPrefix(): string
    {
        // #14
    }

    /**
     * #15
     */
    public function has(string $key): bool
    {
        // #16
    }

    /**
     * #17
     */
    public function increment(string $key, int $value = 1)
    {
        // #18
    }

    /**
     * #19
     */
    public function set(string $key, $value, $ttl = null): bool
    {
        // #20
    }
}
```
> **Legend**
> 
> 1. Vacía/Limpia la caché
> 
> 2. Custom implementation
> 
> 3. Decrementa el número almacenado
> 
> 4. Custom implementation
> 
> 5. Borra datos desde el adaptador
> 
> 6. Custom implementation
> 
> 7. Lee datos desde el adaptador
> 
> 8. Custom implementation
> 
> 9. Devuelve el adaptador ya conectado o conecta al servidor de *backend*
> 
> 10. Custom implementation
> 
> 11. Returns all the keys stored. If a filter has been passed the keys that match the filter will be returned
> 
> 12. Custom implementation
> 
> 13. Devuelve el prefijo de las claves
> 
> 14. Custom implementation
> 
> 15. Comprueba si un elemento existe en el caché
> 
> 16. Custom implementation
> 
> 17. Incrementa un número almacenado
> 
> 18. Custom implementation
> 
> 19. Almacena datos en el adaptador
> 
> 20. Custom implementation 
>     
>     {: .alert .alert-info }

Usándolo:
```php
<?php

namespace MyApp;

use MyApp\Storage\Adapter\Custom;

$custom = new Custom();

$custom->set('my-key', $data);
```

## Fábrica de Adaptadores
Although all adapter classes can be instantiated using the `new` keyword, Phalcon offers the \[Phalcon\Storage\AdapterFactory\]\[cache-adapterfactory\] class, so that you can easily instantiate cache adapter classes. Todos los adaptadores de arriba están registrados en la fábrica y son cargados perezosamente cuando se llaman. La factoría también le permite registrar clases de adaptadores adicionales (personalizadas). Lo único a considerar es elegir el nombre del adaptador en comparación con los existentes. Si define el mismo nombre, sobreescribirá el integrado. Los objetos son cacheados en la fábrica, así que si llama al método `newInstance()` con los mismos parámetros durante la misma petición, recibirá el mismo objeto de vuelta.

The siguiente ejemplo muestra como puede crear un adaptador de caché `Apcu` con la palabra clave `new` o la factoría:
```php
<?php

use Phalcon\Storage\Adapter\Apcu;
use Phalcon\Storage\Serializer\Json;

$jsonSerializer = new Json();

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200,
    'serializer'        => $jsonSerializer,
];

$adapter = new Apcu(null, $options);
```

```php
<?php

use Phalcon\Storage\AdapterFactory;
use Phalcon\Storage\SerializerFactory;

$serializerFactory = new SerializerFactory();
$adapterFactory    = new AdapterFactory($serializerFactory);

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200,
];

$adapter = $adapterFactory->newInstance('apcu', $options);
```

Los parámetros que puede usar para la fábrica son:

| Nombre         | Adaptador                                                                 |
| -------------- | ------------------------------------------------------------------------- |
| `apcu`         | \[Phalcon\Storage\Adapter\Apcu\]\[cache-adapter-apcu\]                 |
| `libmemcached` | \[Phalcon\Storage\Adapter\Libmemcached\]\[cache-adapter-libmemcached\] |
| `memory`       | \[Phalcon\Storage\Adapter\Memory\]\[cache-adapter-memory\]             |
| `redis`        | \[Phalcon\Storage\Adapter\Redis\]\[cache-adapter-redis\]               |
| `stream`       | \[Phalcon\Storage\Adapter\Stream\]\[cache-adapter-stream\]             |


[serializable]: https://www.php.net/manual/en/class.serializable.php
[igbinary]: https://github.com/igbinary/igbinary7
[msgpack]: https://msgpack.org/
[apcu]: https://www.php.net/manual/en/book.apcu.php
[memcached]: https://www.php.net/manual/en/book.memcached.php
[memcached]: https://www.php.net/manual/en/book.memcached.php
[redis]: https://github.com/phpredis/phpredis
[redis]: https://github.com/phpredis/phpredis
[storage-adapter-adapterinterface]: api/phalcon_storage#storage-adapter-adapterinterface
[storage-adapter-libmemcached]: api/phalcon_storage#storage-adapter-libmemcached
[storage-adapter-redis]: api/phalcon_storage#storage-adapter-redis
[storage-serializer-base64]: api/phalcon_storage#storage-serializer-base64
[storage-serializer-igbinary]: api/phalcon_storage#storage-serializer-igbinary
[storage-serializer-json]: api/phalcon_storage#storage-serializer-json
[storage-serializer-msgpack]: api/phalcon_storage#storage-serializer-msgpack
[storage-serializer-none]: api/phalcon_storage#storage-serializer-none
[storage-serializer-php]: api/phalcon_storage#storage-serializer-php
[storage-serializer-memcached-igbinary]: api/phalcon_storage#storage-serializer-memcached-igbinary
[storage-serializer-memcached-json]: api/phalcon_storage#storage-serializer-memcached-json
[storage-serializer-memcached-php]: api/phalcon_storage#storage-serializer-memcached-php
[storage-serializer-redis-igbinary]: api/phalcon_storage#storage-serializer-redis-igbinary
[storage-serializer-redis-json]: api/phalcon_storage#storage-serializer-redis-json
[storage-serializer-redis-msgpack]: api/phalcon_storage#storage-serializer-redis-msgpack
[storage-serializer-redis-none]: api/phalcon_storage#storage-serializer-redis-none
[storage-serializer-redis-php]: api/phalcon_storage#storage-serializer-redis-php
[storage-serializer-serializerinterface]: api/phalcon_storage#storage-serializer-serializerinterface
[storage-serializerfactory]: api/phalcon_storage#storage-serializerfactory
