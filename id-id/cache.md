---
layout: default
language: 'id-id'
version: '5.0'
upgrade: '#cache'
title: 'Cache'
keywords: 'cache, base64, igbinary, json, msgpack, serialize, redis, memcached, apcu, factory, memory, stream'
---

# Cache
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview
The [Phalcon\Cache\Cache][cache-cache] is a component that offers a lightweight yet flexible caching mechanism to be used with your Phalcon applications.

Frequently used data or already processed/calculated data, can be stored in a cache storage for easier and faster retrieval. Since [Phalcon\Cache\Cache][cache-cache] is written in Zephir, and therefore compiled as C code, it can achieve higher performance, while reducing the overhead that comes with getting data from any storage container. Some examples that warrant the use of cache are:

* You are making complex calculations and the output does not change frequently
* You are producing HTML using the same data all the time (same HTML)
* You are accessing database data constantly which does not change often.

> **NOTE** Even after implementing the cache, you should always check the hit ratio of your cache backend over a period of time, to ensure that your cache strategy is optimal. 
> 
> {: .alert .alert-warning}

[Phalcon\Cache\Cache][cache-cache] components rely on `Phalcon\Storage` components. `Phalcon\Storage` is split into two categories: Serializers and Adapters.

## Cache
In order to instantiate a new [Phalcon\Cache\Cache][cache-cache] component, you will need to pass a `Phalcon\Cache\Adapter\*` class in it or one that implements the [Phalcon\Cache\Adapter\AdapterInterface][cache-adapter-adapterinterface]. For a detailed explanation on adapters and serializers, see below.

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

### Operations
The cache component implements methods that are inline with [PSR-16][psr-16], but does not implement the particular interface. A package that implements [PSR-16][psr-16] is available, that uses [Phalcon\Cache\Cache][cache-cache]. The package is located [here][proxy-psr16]. To use it, you will need to have Phalcon installed and then using composer you can install the proxy package.

```sh
composer require phalcon/proxy-psr16
```

Using the proxy classes allows you to follow [PSR-16][psr-16] and use it with any other package that needs that interface.

Each Cache component contains a supplied Cache adapter which in turn is responsible for all operations.

### `get` - `getMultiple`
To get data from the cache you need to call the `get()` method with a key and a default value. If the key exists, or it has not been expired, the data stored in it will be returned. Alternatively the passed `defaultValue` will be returned (default `null`).

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
We can easily create a [Phalcon\Cache\Cache][cache-cache] class using the `new` keyword. However, Phalcon offers the [Phalcon\Cache\CacheFactory][cache-cachefactory] class, so that developers can easily instantiate cache objects. The factory accepts a [Phalcon\Cache\AdapterFactory][cache-adapterfactory] object (which in turn requires a `Phalcon\Storage\SerializerFactory` object) and can instantiate the necessary Cache class with the selected adapter and options. The factory always returns a new instance of [Phalcon\Cache\Cache][cache-cache].

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
Any exceptions thrown in the Cache component will be of type [Phalcon\Cache\Exception\Exception][cache-exception-exception] which implements [Psr\SimpleCache\CacheException][psr-cache-exception]. Additionally the [Phalcon\Cache\Exception\InvalidArgumentException][cache-exception-invalidargumentexception] which implements also the [Psr\SimpleCache\CacheException][psr-invalidargumentexception]. It is thrown when the data supplied to the component or any subcomponents is not valid. You can use these exceptions to selectively catch exceptions thrown only from this component.

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

## Serializers
The `Phalcon\Storage\Serializer` namespace offers classes that implement the [Serializable][serializable] interface and thus expose the `serialize` and `unserialize` methods. The purpose of these classes is to transform the data before saving it to the storage and after retrieving it from the storage.

> **NOTE**: The default serializer for all adapters is `Phalcon\Storage\Serializer\Php` which uses PHP's `serialize` and `unserialize` methods. These methods can suit most applications. However, the developer might want to use something more efficient such as [igbinary][igbinary] which is faster and achieves a better compression. 
> 
> {: .alert .alert-info }

The cache adapter can be configured to use a different serializer. The available serializers are:

### `Base64`
This serializer uses the `base64_encode` and `base64_decode` methods to serialize data. The input must be of type `string`, therefore this serializer has obvious limitations

### `Igbinary`
The `igbinary` serializes relies on the `igbinary_serialize` and `igbinary_unserialize` methods. Those methods are exposed via the [igbinary][igbinary] PHP extension, which has to be installed and loaded on the target system.

### `Json`
The `JSON` serializer uses `json_encode` and `json_decode`. The target system must have JSON support available for PHP.

### `MemcachedIgbinary`
This serializer can be used when using `Memcached`. It corresponds to the built-in Igbinary serializer that `Memcached` has.

### `MemcachedJson`
This serializer can be used when using `Memcached`. It corresponds to the built-in JSON serializer that `Memcached` has.

### `MemcachedPhp`
This serializer can be used when using `Memcached`. It corresponds to the built-in PHP serializer that `Memcached` has.

### `Msgpack`
Similar to `igbinary` the `msgpack` serializer uses `msgpack_pack` and `msgpack_unpack` for serializing and unserializing data. This, along with `igbinary` is one of the fastest and most efficient serializers. However, it requires that the [msgpack][msgpack] PHP extension is loaded on the target system.

### `None`
This serializer does not transform the data at all. Both its `serialize` and `unserialize` get and set the data without altering it.

### `Php`
This is the default serializer. It uses PHP's `serialize` and `unserialize` methods for data transformations.

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


### Custom
Phalcon also offers the [Phalcon\Storage\Serializer\SerializerInterface][storage-serializer-serializerinterface]` which can be implemented in a custom class. The class can offer the serialization you require.

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
> 3. Serializes data
> 
> 4. Set the data
> 
> 5. Unserializes data 
>     
>     {: .alert .alert-info }

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
Although all serializer classes can be instantiated using the `new` keyword, Phalcon offers the [Phalcon\Storage\SerializerFactory][storage-serializerfactory] class, so that developers can easily instantiate serializer classes. All the above serializers are registered in the factory and lazy loaded when called. The factory also allows you to register additional (custom) serializer classes. The only thing to consider is choosing the name of the serializer in comparison to the existing ones. If you define the same name, you will overwrite the built-in one.The objects are cached in the factory so if you call the `newInstance()` method with the same parameters during the same request, you will get the same object back.

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

| **Name**             | **Class**                                                                                |
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

## Adapters
The `Phalcon\Cache\Adapter` namespace offers classes that implement the [Phalcon\Cache\Adapter\AdapterInterface][cache-adapter-adapterinterface] interface. It exposes common methods that are used to perform operations on the storage adapter or cache backend. These adapters act as wrappers to respective backend code.

The available methods are:

| Method       | Description                                                                |
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
> 
> {: .alert .alert-info }

To construct one of these objects, you will need to pass a [Phalcon\Storage\SerializerFactory][storage-serializerfactory] object in the constructor and optionally some parameters required for the adapter of your choice. The list of options is outlined below.

The available adapters are:

### `Apcu`
This adapter uses `Apcu` to store the data. In order to use this adapter, you will need to have [apcu][apcu] enabled in your target system. This class does not use an actual _adapter_, since the `apcu` functionality is exposed using the `apcu_*` PHP functions.

| Option              | Default    |
| ------------------- | ---------- |
| `defaultSerializer` | `Php`      |
| `lifetime`          | `3600`     |
| `serializer`        | `null`     |
| `prefix`            | `ph-apcu-` |

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
This adapter utilizes PHP's [memcached][memcached] extension to connect to Memcached servers. The adapter used is an instance of the `Memcached` class, created after the first event that requires the connection to be active.

| Option                                           | Default                                |
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

The following example demonstrates how to create a new `Libmemcached` cache adapter, which will use the [Phalcon\Storage\Serializer\Json][storage-serializer-json] serializer and have a default lifetime of 7200. It will use the `10.4.13.100` as the first server with weight `1` connecting to port `11211` and `10.4.13.110` as the second server with weight `5` again connecting to port `11211`.

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

**Serializers**: The `Memcached` class which is the adapter that the [Phalcon\Cache\Adapter\Libmemcached][cache-adapter-libmemcached] uses, offers support for serializing out of the box. The built-in serializers are:

* `\Memcached::SERIALIZER_PHP`
* `\Memcached::SERIALIZER_JSON`
* `\Memcached::SERIALIZER_IGBINARY`

The [igbinary][igbinary] built-in serializer is only available if `igbinary` is present in the target system and [Memcached][memcached] extension is compiled with it. To enable these serializers, you can use the [Phalcon\Storage\Serializer\MemcachedIgbinary][storage-serializer-memcached-igbinary], [Phalcon\Storage\Serializer\MemcachedJson][storage-serializer-memcached-json] or [Phalcon\Storage\Serializer\MemcachedPhp][storage-serializer-memcached-php]

### `Memory`
This adapter uses the computer's memory to store the data. As all data is stored in memory, there is no persistence, meaning that once the request is completed, the data is lost. This adapter can be used for testing or temporary storage during a particular request. The options available for the constructor are:

| Option              | Default    |
| ------------------- | ---------- |
| `defaultSerializer` | `Php`      |
| `lifetime`          | `3600`     |
| `serializer`        | `null`     |
| `prefix`            | `ph-memo-` |

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
This adapter utilizes PHP's [redis][redis] extension to connect to a Redis server. The adapter used is an instance of the `Redis` class, created after the first event that requires the connection to be active.

| Option              | Default     |
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

The following example demonstrates how to create a new `Redis` cache adapter, which will use the [Phalcon\Storage\Serializer\Json][storage-serializer-json] serializer and have a default lifetime of 7200. It will use the `10.4.13.100` as the host, connect to port `6379` and select the index `1`.

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

**Serializers**: The `Redis` class which is the adapter that the [Phalcon\Cache\Adapter\Redis][cache-adapter-redis] uses, offers support for serializing out of the box. The built-in serializers are:

* `\Redis::SERIALIZER_NONE`
* `\Redis::SERIALIZER_PHP`
* `\Redis::SERIALIZER_IGBINARY`
* `\Redis::SERIALIZER_MSGPACK`

The [igbinary][igbinary] and built-in serializer is only available if `igbinary` is present in the target system and [Redis][redis] extension is compiled with it. The same applies to [msgpack][msgpack] built-in serializer. It is only available if `msgpack` is present in the target system and the [Redis][redis] extension is compiled with it. To enable these serializers, you can use the [Phalcon\Storage\Serializer\RedisIgbinary][storage-serializer-redis-igbinary], [Phalcon\Storage\Serializer\RedisJson][storage-serializer-redis-json], [Phalcon\Storage\Serializer\RedisMsgpack][storage-serializer-redis-msgpack], [Phalcon\Storage\Serializer\RedisNone][storage-serializer-redis-none] or [Phalcon\Storage\Serializer\RedisPhp][storage-serializer-redis-php].

**NOTE** `increment` - `decrement`

At this point in time there is an issue with `Redis`, where the internal `Redis` serializer does not skip scalar values because it can only store strings. As a result, if you use `increment` after a `set` for a number, will not return a number:

The way to store numbers and use the `increment` (or `decrement`) is to either remove the internal serializer for `Redis`

```php
$cache->getAdapter()->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_NONE);
```

or you could use `increment` instead of using `set` at the first setting of the value to the key:

```php
$cache->delete('my-key');
$cache->increment('my-key', 2);
echo $cache->get('my-key');      // 2
$cache->increment('my-key', 3);
echo $cache->get('my-key');      // 3
```

### `Stream`
This adapter is the simplest to set up since it uses the target system's file system (it only requires a cache path that is writeable). It is one of the slowest cache adapters since the data has to be written to the file system. Each file created corresponds to a key stored. The file contains additional metadata to calculate the lifetime of the cache element, resulting in additional reads and writes to the file system.

| Option              | Default   |
| ------------------- | --------- |
| `defaultSerializer` | `Php`     |
| `lifetime`          | `3600`    |
| `serializer`        | `null`    |
| `prefix`            | `phstrm-` |
| `storageDir`        |           |

If the `storageDir` is not defined a `Phalcon\Storage\Exception` will be thrown.

> **NOTE**: The adapter utilizes logic to store files in separate subdirectories based on the name of the key passed, thus avoiding the `too many files in one folder` limit present in Windows or Linux based systems. 
> 
> {: .alert .alert-info }

The following example demonstrates how to create a new `Stream` cache adapter, which will use the [Phalcon\Storage\Serializer\Json][storage-serializer-json] serializer and have a default lifetime of 7200. It will store the cached data in `/data/storage/cache`.

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

### Custom
Phalcon also offers the [Phalcon\Cache\Adapter\AdapterInterface][cache-adapter-adapterinterface] which can be implemented in a custom class. The class can offer the cache adapter functionality you require.

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
> 1. Flushes/clears the cache
> 
> 2. Custom implementation
> 
> 3. Decrements a stored number
> 
> 4. Custom implementation
> 
> 5. Deletes data from the adapter
> 
> 6. Custom implementation
> 
> 7. Reads data from the adapter
> 
> 8. Custom implementation
> 
> 9. Returns the already connected adapter or connects to the backend server(s)
> 
> 10. Custom implementation
> 
> 11. Returns all the keys stored. If a filter has been passed the keys that match the filter will be returned
> 
> 12. Custom implementation
> 
> 13. Returns the prefix for the keys
> 
> 14. Custom implementation
> 
> 15. Checks if an element exists in the cache
> 
> 16. Custom implementation
> 
> 17. Increments a stored number
> 
> 18. Custom implementation
> 
> 19. Stores data in the adapter
> 
> 20. Custom implementation 
>     
>     {: .alert .alert-info }

Using it:
```php
<?php

namespace MyApp;

use MyApp\Cache\Adapter\Custom;

$custom = new Custom();

$custom->set('my-key', $data);
```

## Adapter Factory
Although all adapter classes can be instantiated using the `new` keyword, Phalcon offers the [Phalcon\Cache\AdapterFactory][cache-adapterfactory] class, so that you can easily instantiate cache adapter classes. All the above adapters are registered in the factory and lazy loaded when called. The factory also allows you to register additional (custom) adapter classes. The only thing to consider is choosing the name of the adapter in comparison to the existing ones. If you define the same name, you will overwrite the built-in one. The objects are cached in the factory so if you call the `newInstance()` method with the same parameters during the same request, you will get the same object back.

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

The parameters you can use for the factory are:

| Name           | Adapter                                                             |
| -------------- | ------------------------------------------------------------------- |
| `apcu`         | [Phalcon\Cache\Adapter\Apcu][cache-adapter-apcu]                 |
| `libmemcached` | [Phalcon\Cache\Adapter\Libmemcached][cache-adapter-libmemcached] |
| `memory`       | [Phalcon\Cache\Adapter\Memory][cache-adapter-memory]             |
| `redis`        | [Phalcon\Cache\Adapter\Redis][cache-adapter-redis]               |
| `stream`       | [Phalcon\Cache\Adapter\Stream][cache-adapter-stream]             |

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
