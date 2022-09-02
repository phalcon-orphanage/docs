---
layout: default
language: 'es-es'
version: '4.0'
upgrade: '#cache'
title: 'Cache'
keywords: 'cache, psr-16, base64, igbinary, json, msgpack, serializar, redis, memcached, apcu, fábrica, memory, stream'
---

# Cache

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

El espacio de nombres [Phalcon\Cache](api/phalcon_cache#cache) ofrece un componente Cache, que implementa el interfaz [PSR-16](psr-16), haciéndolo compatible con cualquier componente que requiera ese interfaz para su caché.

![](/assets/images/implements-psr--16-blue.svg)

Los datos usados frecuentemente o datos ya procesados/calculados, se pueden almacenar en un almacén de cache para obtenerlos más fácil y rápidamente. Ya que los componentes [Phalcon\Cache](api/phalcon_cache#cache) están escritos en Zephir, y por tanto compilados como código C, pueden lograr un rendimiento mayor, mientras que reduce la sobrecarga al obtener datos de cualquier contenedor de almacenamiento. Algunos ejemplos que garantizan el uso del caché son:

* Está haciendo cálculos complejos y la salida no cambia frecuentemente
* Está produciendo HTML usando los mismos datos todo el tiempo (mismo HTML)
* Está accediendo a datos de la base de datos constantemente que no cambian muy a menudo.

> **NOTA** Incluso después de implementar el caché, debería comprobar siempre si el ratio de acierto de su *backend* de caché durante un periodo de tiempo, para asegurarse de que su estrategia de caché es óptima.
{: .alert .alert-warning}

Los componentes [Phalcon\Cache](api/phalcon_cache#cache) dependen de componentes `Phalcon\Storage`. `Phalcon\Storage` se divide en dos categorías: Serializadores y Adaptadores.

## Cache

Para instanciar un nuevo componente [Phalcon\Cache](api/phalcon_cache#cache), necesitará pasarle una clase `Phalcon\Cache\Adapter\*` o una que implemente [Phalcon\Cache\Adapter\AdapterInterface](api/phalcon_cache#cache-adapter-adapterinterface). Para una explicación detallada de adaptadores y serializadores, consulte a continuación.

```php
<?php

use Phalcon\Cache;
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

Ya que el componente de caché es compatible con [PSR-16](https://www.php-fig.org/psr/psr-16/) implementa todos los métodos necesarios para satisfacer los interfaces PSR-16. Cada componente Cache contiene un adaptador de Cache suministrado que es responsable de todas las operaciones.

### `get` - `getMultiple`

Para obtener datos desde el cache necesita llamar al método `get()` con una clave y un valor por defecto. Si la clave existe y no ha expirado, los datos almacenados en ella serán devueltos. En caso contrario, se devolverá el `defaultValue` indicado (por defecto `null`).

```php
$value = $cache->get('my-key');

$value = $cache->get('my-key', 'default');
```

Si desea obtener más de una clave en una llamada, puede llamar `getMultiple()`, pasando un vector con las claves necesarias. El método devolverá un vector de pares `clave` => `valor`. Las claves del caché que no existan o hayan expirado tendrán `defaultValue` como valor (por defecto `null`).

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

Para guardar los datos en el caché, necesitará usar el método `set()`. El método acepta la clave bajo la que queramos almacenar los datos y el valor del elemento a almacenar. Los datos necesitan ser de un tipo que soporte serialización, es decir, el tipo PHP o un objeto que implemente serialización. El último parámetro (opcional) es el valor TTL (tiempo para vivir) para este elemento. Esta opción podrían no estar siempre disponible, si el adaptador subyacente no lo soporta. El método devolverá `true` si la clave existe, o `false` en caso contrario. Si una clave no se almacena correctamente, el método devolverá `false`.

```php
$result = $cache->set('my-key', $data);
```

Si desea almacenar más de un elemento en una llamada, puede llamar `setMultiple()`, pasando un vector de pares clave => valor para la operación de conjunto múltiple. Al igual que `set` el último parámetro (opcional) es TTL (tiempo para vivir). El método devolverá `true` si la clave existe, o `false` en caso contrario.

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

Podemos crear fácilmente una clase [Phalcon\Cache](api/phalcon_cache#cache) usando la palabra clave `new`. Sin embargo, Phalcon ofrece la clase [Phalcon\Cache\CacheFactory](api/phalcon_cache#cache-cachefactory), para que los desarrolladores puedan instanciar los objetos de caché más fácilmente. La fábrica aceptará un objeto [Phalcon\Cache\AdapterFactory](api/phalcon_cache#cache-adapterfactory) que a su vez se usará para instanciar la clase de Cache necesaria con el adaptador y opciones seleccionadas. La fábrica siempre devuelve una nueva instancia de [Phalcon\Cache](api/phalcon_cache#cache).

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

Cualquier excepción lanzada en el componente Cache será del tipo [Phalcon\Cache\Exception\Exception](api/phalcon_cache#cache-exception-exception) que implementa [Psr\SimpleCache\CacheException](https://www.php-fig.org/psr/psr-16/#22-cacheexception). Adicionalmente, [Phalcon\Cache\Exception\InvalidArgumentException](api/phalcon_cache#cache-exception-invalidargumentexception) implementa también [Psr\SimpleCache\CacheException](https://www.php-fig.org/psr/psr-16/#23-invalidargumentexception). Se lanza cuando los datos suministrador al componente o cualquier subcomponente no son válidos. Puede usar estas excepciones para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Cache\Exception\Exception;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        try {
            // Get some configuration values
            $this->cache->get('some-key');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## Serializadores

The `Phalcon\Storage\Serializer` namespace offers classes that implement the [Serializable](https://www.php.net/manual/en/class.serializable.php) interface and thus expose the `serialize` and `unserialize` methods. El propósito de estas clases es transformar los datos antes de guardarlos en el almacén y después recuperarlos del almacén.

> **NOTA**: El serializador por defecto para todos los serializadores es `Phalcon\Storage\Serializer\Php` que usa los métodos de PHP `serialize` y `unserialize`. Éstos métodos se adaptan a la mayoría de aplicaciones. Sin embargo, el desarrollador podría querer usar cualquier otro más eficiente como [igbinary](https://github.com/igbinary/igbinary7) que es más rápido y consigue una mejor compresión. 
{: .alert .alert-info }

El adaptador de caché se puede configurar para usar un serializador diferente. Los serializadores disponibles son:

### `Base64`

Este serializador usa los métodos `base64_encode` y `base64_decode` para serializar los datos. La entrada debe ser del tipo `string`, por lo que este serializador tiene limitaciones evidentes

### `Igbinary`

La serialización de `igbinary` se basa en los métodos `igbinary_serialize` y `igbinary_unserialize`. Estos métodos se exponen vía la extensión PHP [igbinary](https://github.com/igbinary/igbinary7), que tiene que ser instalada y cargada en el sistema de destino.

### `Json`

El serializador `JSON` usa `json_encode` y `json_decode`. El sistema de destino debe tener soporte JSON disponible para PHP.

### `Msgpack`

Similar a `igbinary` el serializador `msgpack` usa `msgpack_pack` y `msgpack_unpack` para serializar y desserializar datos. Este, junto con `igbinary` es uno de los serializadores más rápidos y eficientes. Sin embargo, requiere que se cargue en el sistema destino la extensión PHP [msgpack](https://msgpack.org/).

### `None`

Este serializador no transforma los datos en absoluto. Tanto `serialize` como `unserialize` obtienen y almacenan los datos sin alterarlos.

### `Php`

Este es el serializador predeterminado. Usa los métodos PHP `serialize` y `unserialize` para transformar los datos.

### Personalizado

Phalcon también ofrece [Phalcon\Storage\Serializer\SerializerInterface](api/phalcon_storage#storage-serializer-serializerinterface)` que puede ser implementada en una clase personalizada. La clase puede ofrecer la serialización que necesite.

```php
<?php

namespace MyApp\Storage\Serializer;

use Phalcon\Storage\SerializerInterface;

class Garble implements SerializerInterface
{
    /**
     * Data storage
     * 
     * @var string
     */
    private $data = '';

    /**
     * Return the stored data
     * 
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }       

    /**
    * Serializes data
    */
    public function serialize(): string
    {
        return rot13($this->data);
    }

    /**
     * Set the data
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
     * Unserializes data
     */
    public function unserialize($data): void
    {
        $this->data = str_rot13($data);
    }
}
```

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

Aunque todas las clases serializadoras se pueden instanciar usando la palabra clave `new`, Phalcon ofrece la clase [Phalcon\Storage\SerializerFactory](api/phalcon_storage#storage-serializerfactory), para que los desarrolladores puedan fácilmente instanciar clases serializadoras. Todos los serializadores anteriores están registrados en la fábrica y son cargados perezosamente cuando se llaman. La fábrica también le permite registrar clases de serializadores adicionales (personalizadas). Lo único a considerar es elegir el nombre del serializador en comparación con los ya existentes. Si define el mismo nombre, sobreescribirá el incorporado. Los objetos están cacheados en la fábrica, con lo que si llama al método `newInstance()` con los mismos parámetros durante la misma petición, obtendrá el mismo objeto de vuelta.

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

* `base64` para [Phalcon\Storage\Serializer\Base64](api/phalcon_storage#storage-serializer-base64)
* `igbinary` para [Phalcon\Storage\Serializer\Igbinary](api/phalcon_storage#storage-serializer-igbinary)
* `json` para [Phalcon\Storage\Serializer\Json](api/phalcon_storage#storage-serializer-json)
* `msgpack` para [Phalcon\Storage\Serializer\Msgpack](api/phalcon_storage#storage-serializer-msgpack)
* `none` para [Phalcon\Storage\Serializer\None](api/phalcon_storage#storage-serializer-none)
* `php` para [Phalcon\Storage\Serializer\Php](api/phalcon_storage#storage-serializer-php)

## Adaptadores

El espacio de nombres `Phalcon\Cache\Adapter` ofrece clases que implementan la interfaz [Phalcon\Cache\Adapter\AdapterInterface](api/phalcon_cache#cache-adapter-adapterinterface). Expone métodos comunes que se usan para ejecutar operaciones sobre el adaptador de almacenamiento o el *backend* de caché. Estos adaptadores actúan como envoltorios de su respectivo código de *backend*.

Los métodos disponibles son:

| Método       | Descripción                                                           |
| ------------ | --------------------------------------------------------------------- |
| `clear`      | Vacía/Limpia la caché                                                 |
| `decrement`  | Decrementa el número almacenado                                       |
| `delete`     | Borra datos desde un adaptador                                        |
| `get`        | Lee datos desde el adaptador                                          |
| `getAdapter` | Devuelve el adaptador ya conectado o conecta al servidor de *backend* |
| `getKeys`    | Devuelve todas las claves almacenadas (parámetro de filtro opcional)  |
| `getPrefix`  | Devuelve el prefijo de las claves                                     |
| `has`        | Comprueba si el elemento existe en el caché                           |
| `increment`  | Incrementa un número almacenado                                       |
| `set`        | Almacena datos en el adaptador                                        |

> **NOTA**: El método `getAdapter()` devuelve el adaptador conectado. Esto ofrece más flexibilidad al desarrollador, ya que se puede usar para ejecutar métodos adicionales que ofrece cada adaptador. Por ejemplo, para el adaptador `Redis` puede usar `getAdapter()` para obtener el objeto conectado y llamar `zAdd`, `zRange` y otros métodos no expuestos por el adaptador Phalcon.
{: .alert .alert-info }

Para construir uno de estos objetos, necesitará pasar un objeto [Phalcon\Storage\SerializerFactory](api/phalcon_storage#storage-serializerfactory) en el constructor y opcionalmente algunos parámetros obligatorios para el adaptador de su elección. La lista de opciones se describe a continuación.

Los adaptadores disponibles son:

### `Apcu`

Este adaptador usa `Apcu` para almacenar los datos. Para poder usar este adaptador, necesitará tener [apcu](https://www.php.net/manual/en/book.apcu.php) habilitado en su sistema de destino. Esta clase no usa un *adapter* actual, ya que la funcionalidad `apcu` se expone usando las funciones PHP `apcu_*`.

| Opción              | Predeterminado |
| ------------------- | -------------- |
| `defaultSerializer` | `Php`          |
| `lifetime`          | `3600`         |
| `serializer`        | `null`         |
| `prefix`            | `ph-apcu-`     |

El siguiente ejemplo demuestra cómo crear un nuevo adaptador de caché `Apcu`, que usará el serializador [Phalcon\Storage\Serializer\Json](api/phalcon_storage#storage-serializer-json) y tendrá un tiempo de vida predeterminado de 7200.

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

El ejemplo anterior usó un objeto [Phalcon\Storage\SerializerFactory](api/phalcon_storage#storage-serializerfactory) y la opción `defaultSerializer` para indicar al adaptador el serializador relevante a instanciar.

### `Libmemcached`

Este adaptador usa la extensión de PHP [memcached](https://www.php.net/manual/en/book.memcached.php) para conectar a los servidores Memcached. El adaptador usado es una instancia de la clase `Memcached`, creada después del primer evento que requiera que la conexión esté activa.

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

El siguiente ejemplo demuestra como crear un nuevo adaptador de caché `Libmemcached`, que usará el serializador [Phalcon\Storage\Serializer\Json](api/phalcon_storage#storage-serializer-json) y un tiempo de vida predeterminado de 7200. Usará `10.4.13.100` como primer servidor con peso `1` conectando al puerto `11211` y `10.4.13.110` como segundo servidor con peso `5` otra vez conectando al puerto `11211`.

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

El ejemplo anterior usó un objeto [Phalcon\Storage\SerializerFactory](api/phalcon_storage#storage-serializerfactory) y la opción `defaultSerializer` para indicar al adaptador el serializador relevante a instanciar.

**Serializadores**: La clase `Memcached` que es el adaptador que usa [Phalcon\Cache\Adapter\Libmemcached](api/phalcon_cache#cache-adapter-libmemcached), ofrece soporte para serializar listo para usar. Los serializadores integrados son:

* `\Memcached::SERIALIZER_PHP`
* `\Memcached::SERIALIZER_JSON`
* `\Memcached::SERIALIZER_IGBINARY`

El serializador integrado [igbinary](https://github.com/igbinary/igbinary7) sólo está disponible si `igbinary` está presente en el sistema de destino y la extensión [Memcached](https://www.php.net/manual/en/book.memcached.php) está compilada en él.

> **NOTA**: Si `defaultSerializer` o el serializador seleccionado para `Libmemcached` se soporta como serializador integrado (`PHP`, `JSON`, `IGBINARY`), se usará el integrado, dando lugar a una mayor velocidad y una menor utilización de recursos.
{: .alert .alert-info }

### `Memory`

Este adaptador usa la memoria del ordenador para almacenar los datos. Como todos los datos se almacenan en memoria, no hay persistencia, lo que significa que una vez la petición se ha completado, se pierden los datos. Este adaptador se puede usar para testear o almacenar temporalmente durante una petición determinada. Las opciones disponibles para el constructor son:

| Opción              | Predeterminado |
| ------------------- | -------------- |
| `defaultSerializer` | `Php`          |
| `lifetime`          | `3600`         |
| `serializer`        | `null`         |
| `prefix`            | `ph-memo-`     |

El siguiente ejemplo demuestra como crear un nuevo adaptador de caché `Memory`, que usará el serializador [Phalcon\Storage\Serializer\Json](api/phalcon_storage#storage-serializer-json) y tendrá un tiempo de vida predeterminado de 7200.

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

El ejemplo anterior usó un objeto [Phalcon\Storage\SerializerFactory](api/phalcon_storage#storage-serializerfactory) y la opción `defaultSerializer` para indicar al adaptador el serializador relevante a instanciar.

### `Redis`

Este adaptador usa la extensión PHP [redis](https://github.com/phpredis/phpredis) para conectar al servidor Redis. El adaptador usado es una instancia de la clase `Redis`, creada después del primer evento que requiera que la conexión esté activa.

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

El siguiente ejemplo demuestra cómo crear un nuevo adaptador de caché `Redis`, que usará el serializador [Phalcon\Storage\Serializer\Json](api/phalcon_storage#storage-serializer-json) y tendrá un tiempo de vida predeterminado de 7200. Usará `10.4.13.100` como servidor, conectará al puerto `6379` y seleccionará el índice `1`.

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

El ejemplo anterior usó un objeto [Phalcon\Storage\SerializerFactory](api/phalcon_storage#storage-serializerfactory) y la opción `defaultSerializer` para indicar al adaptador el serializador relevante a instanciar.

**Serializadores**: La clase `Redis` que es el adaptador que usa [Phalcon\Cache\Adapter\Redis](api/phalcon_cache#cache-adapter-redis), ofrece soporte para serializar listo para usar. Los serializadores integrados son:

* `\Redis::SERIALIZER_NONE`
* `\Redis::SERIALIZER_PHP`
* `\Redis::SERIALIZER_IGBINARY`
* `\Redis::SERIALIZER_MSGPACK`

El serializador integrado [Igbinary](https://github.com/igbinary/igbinary7) sólo está disponible si `igbinary` está presente en el sistema de destino y la extensión [Redis](https://github.com/phpredis/phpredis) está compilada en él. Lo mismo se aplica al serializador integrado [msgpack](https://msgpack.org/). Sólo está disponible si `msgpack` está presente en el sistema de destino y la extensión [Redis](https://github.com/phpredis/phpredis) está compilada en él.

> **NOTA**: Si `defaultSerializer` o el serializador seleccionado para `Redis` se soporta como serializador integrado (`NONE`, `PHP`, `IGBINARY`, `MSGPACK`), se usará el integrado, dando lugar a una mayor velocidad y una menor utilización de recursos.
{: .alert .alert-info }

**NOTA** `increment` - `decrement`

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

### `Stream (flujo)`

Este adaptador es el más simple de configurar ya que usa el sistema de archivos del sistema de destino (sólo requiere una ruta de caché que sea escribible). Es uno de los adaptadores de caché más lentos, ya que los datos se tienen que escribir en el sistema de archivos. Cada fichero creado corresponde a una clave almacenada. El fichero contiene metadatos adicionales para calcular el tiempo de vida del elemento de caché, resultando en lecturas y escrituras adicionales en el sistema de archivos.

| Opción              | Predeterminado |
| ------------------- | -------------- |
| `defaultSerializer` | `Php`          |
| `lifetime`          | `3600`         |
| `serializer`        | `null`         |
| `prefix`            | `phstrm-`      |
| `storageDir`        |                |

Si no se define `storageDir` se lanzará `Phalcon\Storage\Exception`.

> **NOTA**: El adaptador usa lógica para almacenar los ficheros en subdirectorios separados basados en el nombre de la clave pasada, lo que evita el límite `demasiados ficheros en una carpeta` presente en sistemas basados en Windows o Linux.
{: .alert .alert-info }

El siguiente ejemplo demuestra cómo crear un nuevo adaptador de caché `Stream`, que usará el serializador [Phalcon\Storage\Serializer\Json](api/phalcon_storage#storage-serializer-json) y un tiempo de vida predeterminado de 7200. Almacenará los datos cacheados en `/data/storage/cache`.

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

El ejemplo anterior usó un objeto [Phalcon\Storage\SerializerFactory](api/phalcon_storage#storage-serializerfactory) y la opción `defaultSerializer` para indicar al adaptador el serializador relevante a instanciar.

### Personalizado

Phalcon también ofrece [Phalcon\Cache\Adapter\AdapterInterface](api/phalcon_cache#cache-adapter-adapterinterface) que se puede implementar en una clase personalizada. La clase puede ofrecer la funcionalidad de adaptador de caché que necesite.

```php
<?php

namespace MyApp\Cache\Adapter;

use Phalcon\Cache\Adapter\AdapterInterface;

class Custom implements AdapterInterface
{
    /**
     * Flushes/clears the cache
     */
    public function clear(): bool
    {
        // Custom implementation
    }

    /**
     * Decrements a stored number
     */
    public function decrement(string $key, int $value = 1)
    {
        // Custom implementation
    }

    /**
     * Deletes data from the adapter
     */
    public function delete(string $key): bool
    {
        // Custom implementation
    }

    /**
     * Reads data from the adapter
     */
    public function get(string $key)
    {
        // Custom implementation
    }

    /**
     * Returns the already connected adapter or connects to the backend
     * server(s)
     */
    public function getAdapter()
    {
        // Custom implementation
    }

    /**
     * Returns all the keys stored. If a filter has been passed the keys that 
     * match the filter will be returned 
     */
    public function getKeys(string $prefix = ""): array
    {
        // Custom implementation
    }

    /**
     * Returns the prefix for the keys
     */
    public function getPrefix(): string
    {
        // Custom implementation
    }

    /**
     * Checks if an element exists in the cache
     */
    public function has(string $key): bool
    {
        // Custom implementation
    }

    /**
     * Increments a stored number
     */
    public function increment(string $key, int $value = 1)
    {
        // Custom implementation
    }

    /**
     * Stores data in the adapter
     */
    public function set(string $key, $value, $ttl = null): bool
    {
        // Custom implementation
    }
}
```

Usándolo:

```php
<?php

namespace MyApp;

use MyApp\Cache\Adapter\Custom;

$custom = new Custom();

$custom->set('my-key', $data);
```

## Fábrica de Adaptadores

Aunque todas las clases de adaptadores se pueden instanciar usando la palabra clave `new`, Phalcon ofrece la clase [Phalcon\Cache\AdapterFactory](api/phalcon_cache#cache-adapterfactory), para que pueda instanciar fácilmente las clases de adaptadores de caché. Todos los adaptadores de arriba están registrados en la fábrica y son cargados perezosamente cuando se llaman. La factoría también le permite registrar clases de adaptadores adicionales (personalizadas). Lo único a considerar es elegir el nombre del adaptador en comparación con los existentes. Si define el mismo nombre, sobreescribirá el integrado. Los objetos son cacheados en la fábrica, así que si llama al método `newInstance()` con los mismos parámetros durante la misma petición, recibirá el mismo objeto de vuelta.

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

Los parámetros que puede usar para la factoría son: * `apcu` para [Phalcon\Cache\Adapter\Apcu](api/phalcon_cache#cache-adapter-apcu)  
* `libmemcached` para [Phalcon\Cache\Adapter\Libmemcached](api/phalcon_cache#cache-adapter-libmemcached) * `memory` para [Phalcon\Cache\Adapter\Memory](api/phalcon_cache#cache-adapter-memory)  
* `redis` para [Phalcon\Cache\Adapter\Redis](api/phalcon_cache#cache-adapter-redis)  
* `stream` para [Phalcon\Cache\Adapter\Stream](api/phalcon_cache#cache-adapter-stream)
