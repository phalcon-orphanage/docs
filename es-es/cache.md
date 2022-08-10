---
layout: default
language: 'es-es'
version: '5.0'
upgrade: '#cache'
title: 'Cache'
keywords: 'cache, base64, igbinary, json, msgpack, serialize, redis, memcached, apcu, factory, memory, stream'
---

# Cache
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
The [Phalcon\Cache\Cache][cache-cache] is a component that offers a lightweight yet flexible caching mechanism to be used with your Phalcon applications.

Los datos usados frecuentemente o datos ya procesados/calculados, se pueden almacenar en un almacén de cache para obtenerlos más fácil y rápidamente. Since [Phalcon\Cache\Cache][cache-cache] is written in Zephir, and therefore compiled as C code, it can achieve higher performance, while reducing the overhead that comes with getting data from any storage container. Algunos ejemplos que garantizan el uso del caché son:

* Está haciendo cálculos complejos y la salida no cambia frecuentemente
* Está produciendo HTML usando los mismos datos todo el tiempo (mismo HTML)
* Está accediendo a datos de la base de datos constantemente que no cambian muy a menudo.

> **NOTE** Even after implementing the cache, you should always check the hit ratio of your cache backend over a period of time, to ensure that your cache strategy is optimal. 
> 
> {: .alert .alert-warning}

[Phalcon\Cache\Cache][cache-cache] components rely on `Phalcon\Storage` components. `Phalcon\Storage` se divide en dos categorías: Serializadores y Adaptadores.

## Cache
In order to instantiate a new [Phalcon\Cache\Cache][cache-cache] component, you will need to pass a `Phalcon\Cache\Adapter\*` class in it or one that implements the [Phalcon\Cache\Adapter\AdapterInterface][cache-adapter-adapterinterface]. Para una explicación detallada de adaptadores y serializadores, consulte a continuación.

```php
<?php

use Phalcon\Cache\Cache;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Storage\SerializerFactory;

$serializerFactory = new SerializerFactory();
$adapterFactory    = new AdapterFactory($serializerFactory);

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200
];

$adapter = $adapterFactory->newInstance('apcu', $options);

$cache = new Cache($adapter);
```

### Operaciones
The cache component implements methods that are inline with [PSR-16][psr-16], but does not implement the particular interface. A package that implements [PSR-16][psr-16] is available, that uses [Phalcon\Cache\Cache][cache-cache]. The package is located [here][proxy-psr16]. To use it, you will need to have Phalcon installed and then using composer you can install the proxy package.

```sh
composer require phalcon/proxy-psr16
```

Using the proxy classes allows you to follow [PSR-16][psr-16] and use it with any other package that needs that interface.

Cada componente Cache contiene un adaptador de Cache suministrado que es responsable de todas las operaciones.

### `get` - `getMultiple`
Para obtener datos desde el cache necesita llamar al método `get()` con una clave y un valor por defecto. If the key exists, or it has not been expired, the data stored in it will be returned. En caso contrario, se devolverá el `defaultValue` indicado (por defecto `null`).

```php
$value = $cache->get('my-key');

$value = $cache->get('my-key', 'default');
```

Si desea obtener más de una clave en una llamada, puede llamar `getMultiple()`, pasando un vector con las claves necesarias. The method will return an array of `key` => `value` pairs. Las claves del caché que no existan o hayan expirado tendrán `defaultValue` como valor (por defecto `null`).

```php
$value = $cache->getMultiple(['my-key1', 'my-key2']);

$value = $cache->getMultiple(['my-key1', 'my-key2'], 'default');
```

### `has`
Para comprobar si una clave existe en el cache (o que no ha expirado) puede llamar al método `has()`. El método devolverá `true` si la clave existe, o `false` en caso contrario.

```php
$exists = $cache->has('my-key');
```

### `set` - `setMultiple`
Para guardar los datos en el caché, necesitará usar el método `set()`. El método acepta la clave bajo la que queramos almacenar los datos y el valor del elemento a almacenar. The data needs to be of a type that supports serialization i.e. PHP type or an object that implements serialization. El último parámetro (opcional) es el valor TTL (tiempo para vivir) para este elemento. Esta opción podrían no estar siempre disponible, si el adaptador subyacente no lo soporta. El método devolverá `true` si la clave existe, o `false` en caso contrario. Si una clave no se almacena correctamente, el método devolverá `false`.

```php
$result = $cache->set('my-key', $data);
```

If you wish to store more than one element with one call, you can call `setMultiple()`, passing an array of key => value pairs for the multiple-set operation. Al igual que `set` el último parámetro (opcional) es TTL (tiempo para vivir). El método devolverá `true` si la clave existe, o `false` en caso contrario.

```php
$value = $cache->setMultiple(
    [
        'my-key1' => $data1, 
        'my-key2' => $data2,
    ],
    9600
);
```

### `delete` - `deleteMultiple` - `clear`
Para eliminar un elemento del cache necesita llamar al método `delete()` con una clave. El método devuelve `true` en caso de éxito y `false` en fallo. `
```php
$result = $cache->delete('my-key');
```

Si desea eliminar más de una clave en una llamada, puede llamar a `deleteMultiple()`, pasando un vector con las claves necesarias. El método devuelve `true` en caso de éxito y `false` en fallo. Si una clave no se elimina correctamente, el método devolverá `false`. `
```php
$result = $cache->deleteMultiple(['my-key1', 'my-key2']);
```

Si desea limpiar todas las claves, puede llamar al método `clear()`. El método devuelve `true` en caso de éxito y `false` en fallo.

## Fábrica (Factory)
### `newInstance`
We can easily create a [Phalcon\Cache\Cache][cache-cache] class using the `new` keyword. However, Phalcon offers the [Phalcon\Cache\CacheFactory][cache-cachefactory] class, so that developers can easily instantiate cache objects. The factory accepts a [Phalcon\Cache\AdapterFactory][cache-adapterfactory] object (which in turn requires a `Phalcon\Storage\SerializerFactory` object) and can instantiate the necessary Cache class with the selected adapter and options. The factory always returns a new instance of [Phalcon\Cache\Cache][cache-cache].

El siguiente ejemplo muestra como se puede crear un objeto de cache usando el adaptador `Apcu` y serializador `Json`:

```php
<?php

use Phalcon\Cache\CacheFactory;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Storage\SerializerFactory;

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200,
];

$serializerFactory = new SerializerFactory();
$adapterFactory    = new AdapterFactory(
    $serializerFactory,
    $options
);

$cacheFactory = new CacheFactory($adapterFactory);

$cache = $cacheFactory->newInstance('apcu');
```

### `load`
La Fábrica de Cache también ofrece el método `load`, que acepta un objeto de configuración. Este objeto puede ser un vector o un objeto [Phalcon\Config](config), con las directivas que se usan para configurar el cache. El objeto requiere el elemento `adapter`, así como el elemento `options` con las directivas necesarias.

```php
<?php

use Phalcon\Cache\CacheFactory;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Storage\SerializerFactory;

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200,
];

$serializerFactory = new SerializerFactory();
$adapterFactory    = new AdapterFactory(
    $serializerFactory,
    $options
);

$cacheFactory = new CacheFactory($adapterFactory);

$cacheOptions = [
    'adapter' => 'apcu',
    'options' => [
        'prefix' => 'my-prefix',
    ],
];

$cache = $cacheFactory->load($cacheOptions);
```

## Excepciones
Any exceptions thrown in the Cache component will be of type [Phalcon\Cache\Exception\Exception][cache-exception-exception] which implements [Psr\SimpleCache\CacheException][psr-cache-exception]. Additionally the [Phalcon\Cache\Exception\InvalidArgumentException][cache-exception-invalidargumentexception] which implements also the [Psr\SimpleCache\CacheException][psr-invalidargumentexception]. Se lanza cuando los datos suministrador al componente o cualquier subcomponente no son válidos. Puede usar estas excepciones para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Cache\Exception\Exception;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        try {
            $content = $this->cache->get('some-key');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## Serializadores
The `Phalcon\Storage\Serializer` namespace offers classes that implement the [Serializable][serializable] interface and thus expose the `serialize` and `unserialize` methods. El propósito de estas clases es transformar los datos antes de guardarlos en el almacén y después recuperarlos del almacén.

> **NOTE**: The default serializer for all adapters is `Phalcon\Storage\Serializer\Php` which uses PHP's `serialize` and `unserialize` methods. Éstos métodos se adaptan a la mayoría de aplicaciones. However, the developer might want to use something more efficient such as [igbinary][igbinary] which is faster and achieves a better compression. 
> 
> {: .alert .alert-info }

El adaptador de caché se puede configurar para usar un serializador diferente. Los serializadores disponibles son:

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
Although all serializer classes can be instantiated using the `new` keyword, Phalcon offers the [Phalcon\Storage\SerializerFactory][storage-serializerfactory] class, so that developers can easily instantiate serializer classes. Todos los serializadores anteriores están registrados en la fábrica y son cargados perezosamente cuando se llaman. La fábrica también le permite registrar clases de serializadores adicionales (personalizadas). Lo único a considerar es elegir el nombre del serializador en comparación con los ya existentes. Si define el mismo nombre, sobreescribirá el incorporado. Los objetos están cacheados en la fábrica, con lo que si llama al método `newInstance()` con los mismos parámetros durante la misma petición, obtendrá el mismo objeto de vuelta.

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

* `base64` for [Phalcon\Storage\Serializer\Base64][storage-serializer-base64]
* `igbinary` for [Phalcon\Storage\Serializer\Igbinary][storage-serializer-igbinary]
* `json` for [Phalcon\Storage\Serializer\Json][storage-serializer-json]
* `memcached_igbinary` for \[Phalcon\Storage\Serializer\MemcachedIgbinary\]\[storage-serializer-memcached-igbinary\]
* `memcached_json` for \[Phalcon\Storage\Serializer\MemcachedJson\]\[storage-serializer-memcached-json\]
* `memcached_php` for \[Phalcon\Storage\Serializer\MemcachedPhp\]\[storage-serializer-memcached-php\]
* `msgpack` for [Phalcon\Storage\Serializer\Msgpack][storage-serializer-msgpack]
* `none` for [Phalcon\Storage\Serializer\None][storage-serializer-none]
* `php` for [Phalcon\Storage\Serializer\Php][storage-serializer-php]
* `redis_igbinary` for \[Phalcon\Storage\Serializer\RedisIgbinary\]\[storage-serializer-redis-igbinary\]
* `redis_json` for \[Phalcon\Storage\Serializer\RedisJson\]\[storage-serializer-redis-json\]
* `redis_msgpack` for \[Phalcon\Storage\Serializer\RedisMsgpack\]\[storage-serializer-redis-msgpack\]
* `redis_none` for \[Phalcon\Storage\Serializer\RedisNone\]\[storage-serializer-redis-none\]
* `redis_php` for \[Phalcon\Storage\Serializer\RedisPhp\]\[storage-serializer-redis-php\]

## Adaptadores
The `Phalcon\Cache\Adapter` namespace offers classes that implement the [Phalcon\Cache\Adapter\AdapterInterface][cache-adapter-adapterinterface] interface. Expone métodos comunes que se usan para ejecutar operaciones sobre el adaptador de almacenamiento o el *backend* de caché. Estos adaptadores actúan como envoltorios de su respectivo código de *backend*.

Los métodos disponibles son:

| Método       | Descripción                                                           |
| ------------ | --------------------------------------------------------------------- |
| `clear`      | Vacía/Limpia la caché                                                 |
| `decrement`  | Decrementa el número almacenado                                       |
| `delete`     | Borra datos desde el adaptador                                        |
| `get`        | Lee datos desde el adaptador                                          |
| `getAdapter` | Devuelve el adaptador ya conectado o conecta al servidor de *backend* |
| `getKeys`    | Devuelve todas las claves almacenadas (parámetro de filtro opcional)  |
| `getPrefix`  | Devuelve el prefijo de las claves                                     |
| `has`        | Comprueba si un elemento existe en el caché                           |
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

The following example demonstrates how to create a new `Apcu` cache adapter, which will use the [Phalcon\Storage\Serializer\Json][storage-serializer-json] serializer and have a default lifetime of 7200.

```php
<?php

use Phalcon\Cache\Adapter\Apcu;
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

The following example demonstrates how to create a new `Libmemcached` cache adapter, which will use the [Phalcon\Storage\Serializer\Json][storage-serializer-json] serializer and have a default lifetime of 7200. Usará `10.4.13.100` como primer servidor con peso `1` conectando al puerto `11211` y `10.4.13.110` como segundo servidor con peso `5` otra vez conectando al puerto `11211`.

```php
<?php

use Phalcon\Cache\Adapter\Libmemcached;
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

**Serializers**: The `Memcached` class which is the adapter that the [Phalcon\Cache\Adapter\Libmemcached][cache-adapter-libmemcached] uses, offers support for serializing out of the box. Los serializadores integrados son:

* `\Memcached::SERIALIZER_PHP`
* `\Memcached::SERIALIZER_JSON`
* `\Memcached::SERIALIZER_IGBINARY`

The [igbinary][igbinary] built-in serializer is only available if `igbinary` is present in the target system and [Memcached][memcached] extension is compiled with it. To enable these serializers, you can use the \[Phalcon\Storage\Serializer\MemcachedIgbinary\]\[storage-serializer-memcached-igbinary\], \[Phalcon\Storage\Serializer\MemcachedJson\]\[storage-serializer-memcached-json\] or \[Phalcon\Storage\Serializer\MemcachedPhp\]\[storage-serializer-memcached-php\]

### `Memory`
Este adaptador usa la memoria del ordenador para almacenar los datos. Como todos los datos se almacenan en memoria, no hay persistencia, lo que significa que una vez la petición se ha completado, se pierden los datos. Este adaptador se puede usar para testear o almacenar temporalmente durante una petición determinada. Las opciones disponibles para el constructor son:

| Opción              | Predeterminado |
| ------------------- | -------------- |
| `defaultSerializer` | `Php`          |
| `lifetime`          | `3600`         |
| `serializer`        | `null`         |
| `prefix`            | `ph-memo-`     |

The following example demonstrates how to create a new `Memory` cache adapter, which will use the [Phalcon\Storage\Serializer\Json][storage-serializer-json] serializer and have a default lifetime of 7200.

```php
<?php

use Phalcon\Cache\Adapter\Memory;
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

The following example demonstrates how to create a new `Redis` cache adapter, which will use the [Phalcon\Storage\Serializer\Json][storage-serializer-json] serializer and have a default lifetime of 7200. Usará `10.4.13.100` como servidor, conectará al puerto `6379` y seleccionará el índice `1`.

```php
<?php

use Phalcon\Cache\Adapter\Redis;
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

**Serializers**: The `Redis` class which is the adapter that the [Phalcon\Cache\Adapter\Redis][cache-adapter-redis] uses, offers support for serializing out of the box. Los serializadores integrados son:

* `\Redis::SERIALIZER_NONE`
* `\Redis::SERIALIZER_PHP`
* `\Redis::SERIALIZER_IGBINARY`
* `\Redis::SERIALIZER_MSGPACK`

The [igbinary][igbinary] and built-in serializer is only available if `igbinary` is present in the target system and [Redis][redis] extension is compiled with it. The same applies to [msgpack][msgpack] built-in serializer. It is only available if `msgpack` is present in the target system and the [Redis][redis] extension is compiled with it. To enable these serializers, you can use the \[Phalcon\Storage\Serializer\RedisIgbinary\]\[storage-serializer-redis-igbinary\], \[Phalcon\Storage\Serializer\RedisJson\]\[storage-serializer-redis-json\], \[Phalcon\Storage\Serializer\RedisMsgpack\]\[storage-serializer-redis-msgpack\], \[Phalcon\Storage\Serializer\RedisNone\]\[storage-serializer-redis-none\] or \[Phalcon\Storage\Serializer\RedisPhp\]\[storage-serializer-redis-php\].

**NOTE** `increment` - `decrement`

En este momento hay un problema con `Redis`, donde el serializador interno `Redis` no omite valores escalares porque sólo puede almacenar cadenas. Como resultado, si usas `increment` después de un `set` para un número, no devolverá un número:

La forma de almacenar números y utilizar el `increment` (o `decrement`) es eliminar el serializador interno para `Redis`

```php
$cache->getAdapter()->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_NONE);
```

o podría usar `increment` en lugar de usar `set` en el primer ajuste del valor de la clave:

```php
$cache->delete('my-key');
$cache->increment('my-key', 2);
echo $cache->get('my-key');      // 2
$cache->increment('my-key', 3);
echo $cache->get('my-key');      // 3
```

### `Flujo (Stream)`
Este adaptador es el más simple de configurar ya que usa el sistema de archivos del sistema de destino (sólo requiere una ruta de caché que sea escribible). Es uno de los adaptadores de caché más lentos, ya que los datos se tienen que escribir en el sistema de archivos. Cada fichero creado corresponde a una clave almacenada. El fichero contiene metadatos adicionales para calcular el tiempo de vida del elemento de caché, resultando en lecturas y escrituras adicionales en el sistema de archivos.

| Opción              | Predeterminado |
| ------------------- | -------------- |
| `defaultSerializer` | `Php`          |
| `lifetime`          | `3600`         |
| `serializer`        | `null`         |
| `prefix`            | `phstrm-`      |
| `storageDir`        |                |

Si no se define `storageDir` se lanzará `Phalcon\Storage\Exception`.

> **NOTE**: The adapter utilizes logic to store files in separate sub directories based on the name of the key passed, thus avoiding the `too many files in one folder` limit present in Windows or Linux based systems. 
> 
> {: .alert .alert-info }

The following example demonstrates how to create a new `Stream` cache adapter, which will use the [Phalcon\Storage\Serializer\Json][storage-serializer-json] serializer and have a default lifetime of 7200. Almacenará los datos cacheados en `/data/storage/cache`.

```php
<?php

use Phalcon\Cache\Adapter\Stream;
use Phalcon\Storage\SerializerFactory;

$serializerFactory = new SerializerFactory();

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200,
    'storageDir'        => '/data/storage/cache',
];

$adapter = new Stream($serializerFactory, $options);
```

The above example used a [Phalcon\Storage\SerializerFactory][storage-serializerfactory] object and the `defaultSerializer` option to tell the adapter to instantiate the relevant serializer.

### Personalizado
Phalcon also offers the [Phalcon\Cache\Adapter\AdapterInterface][cache-adapter-adapterinterface] which can be implemented in a custom class. La clase puede ofrecer la funcionalidad de adaptador de caché que necesite.

```php
<?php

namespace MyApp\Cache\Adapter;

use Phalcon\Cache\Adapter\AdapterInterface;

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

use MyApp\Cache\Adapter\Custom;

$custom = new Custom();

$custom->set('my-key', $data);
```

## Fábrica de Adaptadores
Although all adapter classes can be instantiated using the `new` keyword, Phalcon offers the [Phalcon\Cache\AdapterFactory][cache-adapterfactory] class, so that you can easily instantiate cache adapter classes. Todos los adaptadores de arriba están registrados en la fábrica y son cargados perezosamente cuando se llaman. La factoría también le permite registrar clases de adaptadores adicionales (personalizadas). Lo único a considerar es elegir el nombre del adaptador en comparación con los existentes. Si define el mismo nombre, sobreescribirá el integrado. Los objetos son cacheados en la fábrica, así que si llama al método `newInstance()` con los mismos parámetros durante la misma petición, recibirá el mismo objeto de vuelta.

The siguiente ejemplo muestra como puede crear un adaptador de caché `Apcu` con la palabra clave `new` o la factoría:
```php
<?php

use Phalcon\Cache\Adapter\Apcu;
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

use Phalcon\Cache\AdapterFactory;
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
* `apcu` for [Phalcon\Cache\Adapter\Apcu][cache-adapter-apcu]
* `libmemcached` for [Phalcon\Cache\Adapter\Libmemcached][cache-adapter-libmemcached]
* `memory` for [Phalcon\Cache\Adapter\Memory][cache-adapter-memory]
* `redis` for [Phalcon\Cache\Adapter\Redis][cache-adapter-redis]
* `stream` for [Phalcon\Cache\Adapter\Stream][cache-adapter-stream]

[psr-16]: https://www.php-fig.org/psr/psr-16/
[serializable]: https://www.php.net/manual/en/class.serializable.php
[igbinary]: https://github.com/igbinary/igbinary7
[msgpack]: https://msgpack.org/
[apcu]: https://www.php.net/manual/en/book.apcu.php
[memcached]: https://www.php.net/manual/en/book.memcached.php
[memcached]: https://www.php.net/manual/en/book.memcached.php
[redis]: https://github.com/phpredis/phpredis
[redis]: https://github.com/phpredis/phpredis
[psr-cache-exception]: https://www.php-fig.org/psr/psr-16/#22-cacheexception
[psr-invalidargumentexception]: https://www.php-fig.org/psr/psr-16/#23-invalidargumentexception
[cache-cache]: api/phalcon_cache#cache
[cache-adapter-adapterinterface]: api/phalcon_cache#cache-adapter-adapterinterface
[cache-adapter-apcu]: api/phalcon_cache#cache-adapter-apcu
[cache-adapter-libmemcached]: api/phalcon_cache#cache-adapter-libmemcached
[cache-adapter-memory]: api/phalcon_cache#cache-adapter-memory
[cache-adapter-redis]: api/phalcon_cache#cache-adapter-redis
[cache-adapter-stream]: api/phalcon_cache#cache-adapter-stream
[cache-adapterfactory]: api/phalcon_cache#cache-adapterfactory
[cache-cachefactory]: api/phalcon_cache#cache-cachefactory
[cache-exception-exception]: api/phalcon_cache#cache-exception-exception
[cache-exception-invalidargumentexception]: api/phalcon_cache#cache-exception-invalidargumentexception
[proxy-psr16]: https://github.com/phalcon/proxy-psr16
[storage-serializer-base64]: api/phalcon_storage#storage-serializer-base64
[storage-serializer-igbinary]: api/phalcon_storage#storage-serializer-igbinary
[storage-serializer-json]: api/phalcon_storage#storage-serializer-json
[storage-serializer-msgpack]: api/phalcon_storage#storage-serializer-msgpack
[storage-serializer-none]: api/phalcon_storage#storage-serializer-none
[storage-serializer-php]: api/phalcon_storage#storage-serializer-php

[storage-serializer-serializerinterface]: api/phalcon_storage#storage-serializer-serializerinterface
[storage-serializerfactory]: api/phalcon_storage#storage-serializerfactory
