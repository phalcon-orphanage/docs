---
layout: default
language: 'el-gr'
version: '5.0'
title: 'Storage'
upgrade: '#storage'
keywords: 'storage, stream, redis, memcached'
---

# Storage Component
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Επισκόπηση
The `Phalcon\Storage` namespace contains components that help with storing data in different storages. The component is heavily integrated in [Phalcon\Cache\Cache](cache) as well as [Phalcon\Session](session). It offers serialization of data based on various serialization adapters, and storage of data based on various storage adapters. Factories help with the creation of all necessary objects for the component to work.

## Serializers
The `Phalcon\Storage\Serializer` namespace offers classes that implement the [Serializable][serializable] interface and thus expose the `serialize` and `unserialize` methods. The purpose of these classes is to transform the data before saving it to the storage and after retrieving it from the storage.

> **NOTE**: The default serializer for all adapters is `Phalcon\Storage\Serializer\Php` which uses PHP's `serialize` and `unserialize` methods. These methods can suit most applications. However, the developer might want to use something more efficient such as [igbinary][igbinary] which is faster and achieves a better compression. 
> 
> {: .alert .alert-info }

The storage adapter can be configured to use a different serializer. The available serializers are:

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
Although all serializer classes can be instantiated using the `new` keyword, Phalcon offers the [Phalcon\Storage\SerializerFactory][storage-serializerfactory] class, so that developers can easily instantiate serializer classes. All the above serializers are registered in the factory and lazy loaded when called. The factory also allows you to register additional (custom) serializer classes. The only thing to consider is choosing the name of the serializer in comparison to the existing ones. If you define the same name, you will overwrite the built-in one. The objects are cached in the factory so if you call the `newInstance()` method with the same parameters during the same request, you will get the same object back.

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
The `Phalcon\Storage\Adapter` namespace offers classes that implement the [Phalcon\Storage\Adapter\AdapterInterface][storage-adapter-adapterinterface] interface. It exposes common methods that are used to perform operations on the storage adapter. These adapters act as wrappers to respective backend code.

The available methods are:

| Method       | Περιγραφή                                                                  |
| ------------ | -------------------------------------------------------------------------- |
| `clear`      | Flushes/clears the store                                                   |
| `decrement`  | Decrements a stored number                                                 |
| `delete`     | Deletes data from the adapter                                              |
| `get`        | Reads data from the adapter                                                |
| `getAdapter` | Returns the already connected adapter or connects to the backend server(s) |
| `getKeys`    | Returns all the keys stored (optional filter parameter)                    |
| `getPrefix`  | Returns the prefix for the keys                                            |
| `has`        | Checks if an element exists in the store                                   |
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

The following example demonstrates how to create a new `Libmemcached` storage adapter, which will use the [Phalcon\Storage\Serializer\Json][storage-serializer-json] serializer and have a default lifetime of 7200. It will use the `10.4.13.100` as the first server with weight `1` connecting to port `11211` and `10.4.13.110` as the second server with weight `5` again connecting to port `11211`.

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

**Serializers**: The `Memcached` class which is the adapter that the [Phalcon\Storage\Adapter\Libmemcached][storage-adapter-libmemcached] uses, offers support for serializing out of the box. The built-in serializers are:

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

The following example demonstrates how to create a new `Redis` storage adapter, which will use the [Phalcon\Storage\Serializer\Json][storage-serializer-json] serializer and have a default lifetime of 7200. It will use the `10.4.13.100` as the host, connect to port `6379` and select the index `1`.

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

**Serializers**: The `Redis` class which is the adapter that the [Phalcon\Storage\Adapter\Redis][storage-adapter-redis] uses, offers support for serializing out of the box. The built-in serializers are:

* `\Redis::SERIALIZER_NONE`
* `\Redis::SERIALIZER_PHP`
* `\Redis::SERIALIZER_IGBINARY`
* `\Redis::SERIALIZER_MSGPACK`

The [igbinary][igbinary] and built-in serializer is only available if `igbinary` is present in the target system and [Redis][redis] extension is compiled with it. The same applies to [msgpack][msgpack] built-in serializer. It is only available if `msgpack` is present in the target system and the [Redis][redis] extension is compiled with it. To enable these serializers, you can use the [Phalcon\Storage\Serializer\RedisIgbinary][storage-serializer-redis-igbinary], [Phalcon\Storage\Serializer\RedisJson][storage-serializer-redis-json], [Phalcon\Storage\Serializer\RedisMsgpack][storage-serializer-redis-msgpack], [Phalcon\Storage\Serializer\RedisNone][storage-serializer-redis-none] or [Phalcon\Storage\Serializer\RedisPhp][storage-serializer-redis-php].

**NOTE** `increment` - `decrement`

At this point in time there is an issue with `Redis`, where the internal `Redis` serializer does not skip scalar values because it can only store strings. As a result, if you use `increment` after a `set` for a number, will not return a number:

The way to store numbers and use the `increment` (or `decrement`) is to either remove the internal serializer for `Redis`

```php
$storage->getAdapter()->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_NONE);
```

or you could use `increment` instead of using `set` at the first setting of the value to the key:

```php
$storage->delete('my-key');
$storage->increment('my-key', 2);
echo $storage->get('my-key');      // 2
$storage->increment('my-key', 3);
echo $storage->get('my-key');      // 3
```

### `Stream`
This adapter is the simplest to set up since it uses the target system's file system (it only requires a storage path that is writeable). It is one of the slowest storage adapters since the data has to be written to the file system. Each file created corresponds to a key stored. The file contains additional metadata to calculate the lifetime of the storage element, resulting in additional reads and writes to the file system.

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

### Custom
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

use MyApp\Storage\Adapter\Custom;

$custom = new Custom();

$custom->set('my-key', $data);
```

## Adapter Factory
Although all adapter classes can be instantiated using the `new` keyword, Phalcon offers the \[Phalcon\Storage\AdapterFactory\]\[cache-adapterfactory\] class, so that you can easily instantiate cache adapter classes. All the above adapters are registered in the factory and lazy loaded when called. The factory also allows you to register additional (custom) adapter classes. The only thing to consider is choosing the name of the adapter in comparison to the existing ones. If you define the same name, you will overwrite the built-in one. The objects are cached in the factory so if you call the `newInstance()` method with the same parameters during the same request, you will get the same object back.

The example below shows how you can create a `Apcu` cache adapter with the `new` keyword or the factory:
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

The parameters you can use for the factory are:

| Name           | Adapter                                                                   |
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
