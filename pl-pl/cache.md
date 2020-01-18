---
layout: default
language: 'pl-pl'
version: '4.0'
upgrade: '#cache'
title: 'Cache'
keywords: 'cache, psr-16, base64, igbinary, json, msgpack, serialize, redis, memcached, apcu, factory, memory, stream'
---

# Cache

<hr />

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

The [Phalcon\Cache](api/phalcon_cache#cache) namespace offers a Cache component, that implements the [PSR-16](psr-16) interface, making it compatible with any component that requires that interface for its cache.

![](/assets/images/implements-psr--16-blue.svg)

Frequently used data or already processed/calculated data, can be stored in a cache storage for easier and faster retrieval. Since [Phalcon\Cache](api/phalcon_cache#cache) components are written in Zephir, and therefore compiled as C code, they can achieve higher performance, while reducing the overhead that comes with getting data from any storage container. Some examples that warrant the use of cache are:

* You are making complex calculations and the output does not change frequently
* You are producing HTML using the same data all the time (same HTML)
* You are accessing database data constantly which does not change often.

> **NOTE** Even after implementing the cache, you should always check the hit ratio of your cache backend over a period of time, to ensure that your cache strategy is optimal.
{: .alert .alert-warning}

[Phalcon\Cache](api/phalcon_cache#cache) components rely on `Phalcon\Storage` components. `Phalcon\Storage` is split into two categories: Serializers and Adapters.

## Cache

In order to instantiate a new [Phalcon\Cache](api/phalcon_cache#cache) component, you will need to pass a `Phalcon\Cache\Adapter\*` class in it or one that implements the [Phalcon\Cache\Adapter\AdapterInterface](api/phalcon_cache#cache-adapter-adapterinterface). For a detailed explanation on adapters and serializers, see below.

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

### Operations

Since the cache component is [PSR-16](https://www.php-fig.org/psr/psr-16/) compatible it implements all the necessary methods to satisfy the PSR-16 interfaces. Each Cache component contains a supplied Cache adapter which in turn is responsible for all operations.

### `get` - `getMultiple`

To get data from the cache you need to call the `get()` method with a key and a default value. If the key exists or it has not been expired, the data stored in it will be returned. Alternatively the passed `defaultValue` will be returned (default `null`).

```php
$value = $cache->get('my-key');

$value = $cache->get('my-key', 'default');
```

If you wish to retrieve more than one key with one call, you can call `getMultiple()`, passing an array with the keys needed. The method will return an array of `key` => `value` pairs. Cache keys that do not exist or have expired will have `defaultValue` as a value (default `null`).

```php
$value = $cache->getMultiple(['my-key1', 'my-key2']);

$value = $cache->getMultiple(['my-key1', 'my-key2'], 'default');
```

### `has`

To check whether a key exists in the cache (or it has not expired) you can call the `has()` method. The method will return `true` if the key exists, or `false` otherwise.

```php
$exists = $cache->has('my-key');
```

### `set` - `setMultiple`

To save the data in the cache, you will need to use the `set()` method. The method accepts the key we wish to store the data under and the value of the item to store. The data needs to be of a type that supports serialization i.e. PHP type or an object that implements serialization. The last (optional) parameter is the TTL (time to live) value for this item. This option might not always be available, if the underlying adapter does not support it. The method will return `true` if the key exists, or `false` otherwise. If even one key is not successfully stored, the method will return `false`.

```php
$result = $cache->set('my-key', $data);
```

If you wish to store more than one element with one call, you can call `setMultiple()`, passing an array of key => value pairs for the multiple-set operation. As with `set` the last (optional) parameter is the TTL (time to live). The method will return `true` if the key exists, or `false` otherwise.

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

To delete an item from the cache you need to call the `delete()` method with a key. The method returns `true` on success and `false` on failure. `

```php
$result = $cache->delete('my-key');
```

If you wish to delete more than one key with one call, you can call `deleteMultiple()`, passing an array with the keys needed. The method returns `true` on success and `false` on failure. If even one key is not successfully deleted, the method will return `false`. `

```php
$result = $cache->deleteMultiple(['my-key1', 'my-key2']);
```

If you wish to clear all the keys, you can call the `clear()` method. The method returns `true` on success and `false` on failure.

## Factory

### `newInstance`

We can easily create a [Phalcon\Cache](api/phalcon_cache#cache) class using the `new` keyword. However Phalcon offers the [Phalcon\Cache\CacheFactory](api/phalcon_cache#cache-cachefactory) class, so that developers can easily instantiate cache objects. The factory will accept a [Phalcon\Cache\AdapterFactory](api/phalcon_cache#cache-adapterfactory) object which will in turn be used to instantiate the necessary Cache class with the selected adapter and options. The factory always returns a new instance of [Phalcon\Cache](api/phalcon_cache#cache).

The example below shows how you can create a cache object using the `Apcu` adapter and `Json` serializer:

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

The Cache Factory also offers the `load` method, which accepts a configuration object. This object can be an array or a [Phalcon\Config](config) object, with directives that are used to set up the cache. The object requires the `adapter` element, as well as the `options` element with the necessary directives.

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

## Exceptions

Any exceptions thrown in the Cache component will be of type [Phalcon\Cache\Exception\Exception](api/phalcon_cache#cache-exception-exception) which implements [Psr\SimpleCache\CacheException](https://www.php-fig.org/psr/psr-16/#22-cacheexception). Additionally the [Phalcon\Cache\Exception\InvalidArgumentException](api/phalcon_cache#cache-exception-invalidargumentexception) which implements also the [Psr\SimpleCache\CacheException](https://www.php-fig.org/psr/psr-16/#23-invalidargumentexception). It is thrown when the data supplied to the component or any sub components is not valid. You can use these exceptions to selectively catch exceptions thrown only from this component.

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

## Serializers

The `Phalcon\Storage\Serializer` namespace offers classes that implement the [Serializable](https://secure.php.net/manual/en/class.serializable.php) interface and thus expose the `serialize` and `unserialize` methods. The purpose of these classes is to transform the data before saving it to the storage and after retrieving it from the storage.

> **NOTE**: The default serializer for all adapters is `Phalcon\Storage\Serializer\Php` which uses PHP's `serialize` and `unserialize` methods. These methods can suit most applications. However the developer might want to use something more efficient such as [igbinary](https://github.com/igbinary/igbinary7) which is faster and achieves a better compression. 
{: .alert .alert-info }

The cache adapter can be configured to use a different serializer. The available serializers are:

### `Base64`

This serializer uses the `base64_encode` and `base64_decode` methods to serialize data. The input must be of type `string`, therefore this serializer has obvious limitations

### `Igbinary`

The `igbinary` serializes relies on the `igbinary_serialize` and `igbinary_unserialize` methods. Those methods are exposed via the [igbinary](https://github.com/igbinary/igbinary7) PHP extension, which has to be installed and loaded on the target system.

### `Json`

The `JSON` serializer uses `json_encode` and `json_decode`. The target system must have JSON support available for PHP.

### `Msgpack`

Similar to `igbinary` the `msgpack` serializer uses `msgpack_pack` and `msgpack_unpack` for serializing and unserializing data. This, along with `igbinary` is one of the fastest and most efficient serializers. However, it requires that the [msgpack](https://msgpack.org/) PHP extension is loaded on the target system.

### `Brak`

This serializer does not transform the data at all. Both its `serialize` and `unserialize` get and set the data without altering it.

### `Php`

This is the default serializer. It uses PHP's `serialize` and `unserialize` methods for data transformations.

### Custom

Phalcon also offers the [Phalcon\Storage\Serializer\SerializerInterface](api/phalcon_storage#storage-serializer-serializerinterface)` which can be implemented in a custom class. The class can offer the serialization you require.

```php
<?php

namespace MyApp\Storage\Serializer;

use Phalcon\Storage\SerializerInterface;

class Garble extends SerializerInterface
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

Using it:

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

## Serializer Factory

Although all serializer classes can be instantiated using the `new` keyword, Phalcon offers the [Phalcon\Storage\SerializerFactory](api/phalcon_storage#storage-serializerfactory) class, so that developers can easily instantiate serializer classes. All the above serializers are registered in the factory and lazy loaded when called. The factory also allows you to register additional (custom) serializer classes. The only thing to consider is choosing the name of the serializer in comparison to the existing ones. If you define the same name, you will overwrite the built-in one.The objects are cached in the factory so if you call the `newInstance()` method with the same parameters during the same request, you will get the same object back.

The example below shows how you can create a `Json` serializer either using the `new` keyword or the factory:

```php
<?php

use Phalcon\Storage\Serializer\Json; 
use Phalcon\Storage\SerializerFactory;

$jsonSerializer = new Json();

$factory        = new SerializerFactory();
$jsonSerializer = $factory->newInstance('json');
```

The parameters you can use for the factory are:

* `base64` for [Phalcon\Storage\Serializer\Base64](api/phalcon_storage#storage-serializer-base64)
* `igbinary` for [Phalcon\Storage\Serializer\Igbinary](api/phalcon_storage#storage-serializer-igbinary)
* `json` for [Phalcon\Storage\Serializer\Json](api/phalcon_storage#storage-serializer-json)
* `msgpack` for [Phalcon\Storage\Serializer\Msgpack](api/phalcon_storage#storage-serializer-msgpack)
* `none` for [Phalcon\Storage\Serializer\None](api/phalcon_storage#storage-serializer-none)
* `php` for [Phalcon\Storage\Serializer\Php](api/phalcon_storage#storage-serializer-php)

## Adapters

The `Phalcon\Cache\Adapter` namespace offers classes that implement the [Phalcon\Cache\Adapter\AdapterInterface](api/phalcon_cache#cache-adapter-adapterinterface) interface. It exposes common methods that are used to perform operations on the storage adapter or cache backend. These adapters act as wrappers to respective backend code.

The available methdods are:

| Metoda       | Description                                                                |
| ------------ | -------------------------------------------------------------------------- |
| `clear`      | Flushes/clears the cache                                                   |
| `decrement`  | Decrements a stored number                                                 |
| `delete`     | Deletes data from the adapter                                              |
| `get`        | Reads data from the adapter                                                |
| `getAdapter` | Returns the already connected adapter or connects to the backend server(s) |
| `getKeys`    | Returns all the keys stored (optional filter parameter)                    |
| `getPrefix`  | Returns the prefix for the keys                                            |
| `has`        | Checks if an element exists in the cache                                   |
| `increment`  | Increments a stored number                                                 |
| `set`        | Stores data in the adapter                                                 |

> **NOTE**: The `getAdapter()` method returns the connected adapter. This offers more flexibility to the developer, since it can be used to execute additional methods that each adapter offers. For instance for the `Redis` adapter you can use the `getAdapter()` to obtain the connected object and call `zAdd`, `zRange` and other methods not exposed by the Phalcon adapter.
{: .alert .alert-info }

To construct one of these objects, you will need to pass a [Phalcon\Storage\SerializerFactory](api/phalcon_storage#storage-serializerfactory) object in the constructor and optionally some parameters required for the adapter of your choice. The list of options is outlined below.

The available adapters are:

### `Apcu`

This adapter uses `Apcu` to store the data. In order to use this adapter, you will need to have [apcu](https://www.php.net/manual/en/book.apcu.php) enabled in your target system. This class does not use an actual *adapter*, since the `apcu` functionality is exposed using the `apcu_*` PHP functions.

| Opcja               | Domyślne   |
| ------------------- | ---------- |
| `defaultSerializer` | `Php`      |
| `lifetime`          | `3600`     |
| `serializer`        | `null`     |
| `prefix`            | `ph-apcu-` |

The following example demonstrates how to create a new `Apcu` cache adapter, which will use the [Phalcon\Storage\Serializer\Json](api/phalcon_storage#storage-serializer-json) serializer and have a default lifetime of 7200.

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

The above example used a [Phalcon\Storage\SerializerFactory](api/phalcon_storage#storage-serializerfactory) object and the `defaultSerializer` option to tell the adapter to instantiate the relevant serializer. If you already have a serializer instantiated, you can pass `null` for the serializer factory, and set the serializer in the options as shown below:

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

### `Libmemcached`

This adapter utilizes PHP's [memcached](https://www.php.net/manual/en/book.memcached.php) extension to connect to Memcached servers. The adapter used is an instance of the `Memcached` class, created after the first event that requires the connection to be active.

| Opcja                                            | Domyślne                               |
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

You can specify more than one server in the options array passed in the constructor. If `SASL` data is defined, the adapter will try to authenticate using the passed data. If there is an error in the options or the class cannot add one or more servers in the pool, a `Phalcon\Storage\Exception` will be thrown.

The following example demonstrates how to create a new `Libmemcached` cache adapter, which will use the [Phalcon\Storage\Serializer\Json](api/phalcon_storage#storage-serializer-json) serializer and have a default lifetime of 7200. It will use the `10.4.13.100` as the first server with weight `1` connecting to port `11211` and `10.4.13.110` as the second server with weight `5` again connecting to port `11211`.

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

The above example used a [Phalcon\Storage\SerializerFactory](api/phalcon_storage#storage-serializerfactory) object and the `defaultSerializer` option to tell the adapter to instantiate the relevant serializer. If you already have a serializer instantiated, you can pass `null` for the serializer factory, and set the serializer in the options as shown below:

```php
<?php

use Phalcon\Cache\Adapter\Libmemcached;
use Phalcon\Storage\Serializer\Json;

$jsonSerializer = new Json();

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200,
    'serializer'        => $jsonSerializer,
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

$adapter = new Libmemcached(null, $options);
```

**Serializers**: The `Memcached` class which is the adapter that the [Phalcon\Cache\Adapter\Libmemcached](api/phalcon_cache#cache-adapter-libmemcached) uses, offers support for serializing out of the box. The built-in serializers are:

* `\Memcached::SERIALIZER_PHP`
* `\Memcached::SERIALIZER_JSON`
* `\Memcached::SERIALIZER_IGBINARY`

The [igbinary](https://github.com/igbinary/igbinary7) built-in serializer is only available if `igbinary` is present in the target system and [Memcached](https://www.php.net/manual/en/book.memcached.php) extension is compiled with it.

> **NOTE**: If the `defaultSerializer` or the selected serializer for `Libmemcached` is supported as a built-in serializer (`PHP`, `JSON`, `IGBINARY`), the built-in one will be used, resulting in more speed and less resource utilization.
{: .alert .alert-info }

### `Memory`

This adapter uses the computer's memory to store the data. As all data is stored in memory, there is no persistence, meaning that once the request is completed, the data is lost. This adapter can be used for testing or temporary storage during a particular request. The options available for the constructor are:

| Opcja               | Domyślne   |
| ------------------- | ---------- |
| `defaultSerializer` | `Php`      |
| `lifetime`          | `3600`     |
| `serializer`        | `null`     |
| `prefix`            | `ph-memo-` |

The following example demonstrates how to create a new `Memory` cache adapter, which will use the [Phalcon\Storage\Serializer\Json](api/phalcon_storage#storage-serializer-json) serializer and have a default lifetime of 7200.

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

The above example used a [Phalcon\Storage\SerializerFactory](api/phalcon_storage#storage-serializerfactory) object and the `defaultSerializer` option to tell the adapter to instantiate the relevant serializer. If you already have a serializer instantiated, you can pass `null` for the serializer factory, and set the serializer in the options as shown below:

```php
<?php

use Phalcon\Cache\Adapter\Memory;
use Phalcon\Storage\Serializer\Json;

$jsonSerializer = new Json();

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200,
    'serializer'        => $jsonSerializer,
];

$adapter = new Memory(null, $options);
```

### `Redis`

This adapter utilizes PHP's [redis](https://github.com/phpredis/phpredis) extension to connect to a Redis server. The adapter used is an instance of the `Redis` class, created after the first event that requires the connection to be active.

| Opcja               | Domyślne    |
| ------------------- | ----------- |
| `defaultSerializer` | `Php`       |
| `lifetime`          | `3600`      |
| `serializer`        | `null`      |
| `prefix`            | `ph-reds-`  |
| `host`              | `127.0.0.1` |
| `port`              | `6379`      |
| `index`             | `1`         |
| `persistent`        | `false`     |
| `auth`              |             |
| `socket`            |             |

If `auth` data is defined, the adapter will try to authenticate using the passed data. If there is an error in the options, or the server cannot connect or authenticate, a `Phalcon\Storage\Exception` will be thrown.

The following example demonstrates how to create a new `Redis` cache adapter, which will use the [Phalcon\Storage\Serializer\Json](api/phalcon_storage#storage-serializer-json) serializer and have a default lifetime of 7200. It will use the `10.4.13.100` as the host, connect to port `6379` and select the index `1`.

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

The above example used a [Phalcon\Storage\SerializerFactory](api/phalcon_storage#storage-serializerfactory) object and the `defaultSerializer` option to tell the adapter to instantiate the relevant serializer. If you already have a serializer instantiated, you can pass `null` for the serializer factory, and set the serializer in the options as shown below:

```php
<?php

use Phalcon\Cache\Adapter\Redis;
use Phalcon\Storage\Serializer\Json;

$jsonSerializer = new Json();

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200,
    'host'              => '10.4.13.100',
    'port'              => 6379,
    'index'             => 1,
];

$adapter = new Redis(null, $options);
```

**Serializers**: The `Redis` class which is the adapter that the [Phalcon\Cache\Adapter\Redis](api/phalcon_cache#cache-adapter-redis) uses, offers support for serializing out of the box. The built-in serializers are:

* `\Redis::SERIALIZER_NONE`
* `\Redis::SERIALIZER_PHP`
* `\Redis::SERIALIZER_IGBINARY`
* `\Redis::SERIALIZER_MSGPACK`

The [igbinary](https://github.com/igbinary/igbinary7) and built-in serializer is only available if `igbinary` is present in the target system and [Redis](https://github.com/phpredis/phpredis) extension is compiled with it. The same applies to [msgpack](https://msgpack.org/) built-in serializer. It is only available if `msgpack` is present in the target system and the [Redis](https://github.com/phpredis/phpredis) extension is compiled with it.

> **NOTE**: If the `defaultSerializer` or the selected serializer for `Redis` is supported as a built-in serializer (`NONE`, `PHP`, `IGBINARY`, `MSGPACK`), the built-in one will be used, resulting in more speed and less resource utilization.
{: .alert .alert-info }

### `Stream`

This adapter is the simplest to setup since it uses the target system's file system (it only requires a cache path that is writeable). It is one of the slowest cache adapters since the data has to be written to the file system. Each file created corresponds to a key stored. The file contains additional metadata to calculate the lifetime of the cache element, resulting in additional reads and writes to the file system.

| Opcja               | Domyślne  |
| ------------------- | --------- |
| `defaultSerializer` | `Php`     |
| `lifetime`          | `3600`    |
| `serializer`        | `null`    |
| `prefix`            | `phstrm-` |
| `storageDir`        |           |

If the `storageDir` is not defined a `Phalcon\Storage\Exception` will be thrown.

> **NOTE**: The adapter utilizes logic to store files in separate sub directories based on the name of the key passed, thus avoiding the `too many files in one folder` limit present in Windows or Linux based systems.
{: .alert .alert-info }

The following example demonstrates how to create a new `Stream` cache adapter, which will use the [Phalcon\Storage\Serializer\Json](api/phalcon_storage#storage-serializer-json) serializer and have a default lifetime of 7200. It will store the cached data in `/data/storage/cache`.

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

The above example used a [Phalcon\Storage\SerializerFactory](api/phalcon_storage#storage-serializerfactory) object and the `defaultSerializer` option to tell the adapter to instantiate the relevant serializer. If you already have a serializer instantiated, you can pass `null` for the serializer factory, and set the serializer in the options as shown below:

```php
<?php

use Phalcon\Cache\Adapter\Stream;
use Phalcon\Storage\Serializer\Json;

$jsonSerializer = new Json();

$options = [
    'defaultSerializer' => 'Json',
    'lifetime'          => 7200,
    'storageDir'        => '/data/storage/cache',
];

$adapter = new Stream(null, $options);
```

### Custom

Phalcon also offers the [Phalcon\Cache\Adapter\AdapterInterface](api/phalcon_cache#cache-adapter-adapterinterface) which can be implemented in a custom class. The class can offer the cache adapter functionality you require.

```php
<?php

namespace MyApp\Cache\Adapter;

use Phalcon\Cache\Adapter\AdapterInterface;

class Custom extends AdapterInterface
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

Using it:

```php
<?php

namespace MyApp;

use MyApp\Cache\Adapter\Custom;

$custom = new Custom();

$custom->set('my-key', $data);
```

## Adapter Factory

Although all adapter classes can be instantiated using the `new` keyword, Phalcon offers the [Phalcon\Cache\AdapterFactory](api/phalcon_cache#cache-adapterfactory) class, so that you can easily instantiate cache adapter classes. All the above adapters are registered in the factory and lazy loaded when called. The factory also allows you to register additional (custom) adapter classes. The only thing to consider is choosing the name of the adapter in comparison to the existing ones. If you define the same name, you will overwrite the built-in one. The objects are cached in the factory so if you call the `newInstance()` method with the same parameters during the same request, you will get the same object back.

The example below shows how you can create a `Apcu` cache adapter with the `new` keyword or the factory:

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

The parameters you can use for the factory are: * `apcu` for [Phalcon\Cache\Adapter\Apcu](api/phalcon_cache#cache-adapter-apcu)  
* `libmemcached` for [Phalcon\Cache\Adapter\Libmemcached](api/phalcon_cache#cache-adapter-libmemcached) * `memory` for [Phalcon\Cache\Adapter\Memory](api/phalcon_cache#cache-adapter-memory)  
* `redis` for [Phalcon\Cache\Adapter\Redis](api/phalcon_cache#cache-adapter-redis)  
* `stream` for [Phalcon\Cache\Adapter\Stream](api/phalcon_cache#cache-adapter-stream)