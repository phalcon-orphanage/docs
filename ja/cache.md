<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">キャッシュによるパフォーマンスの向上</a> 
      <ul>
        <li>
          <a href="#implementation">いつキャッシュを実装する？</a>
        </li>
        <li>
          <a href="#caching-behavior">キャッシュの振る舞い</a>
        </li>
        <li>
          <a href="#factory">Factory</a>
        </li>
        <li>
          <a href="#output-fragments">Caching Output Fragments</a>
        </li>
        <li>
          <a href="#arbitrary-data">Caching Arbitrary Data</a> 
          <ul>
            <li>
              <a href="#backend-file-example">File Backend Example</a>
            </li>
            <li>
              <a href="#backend-memcached-example">Memcached Backend Example</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#read">Querying the cache</a>
        </li>
        <li>
          <a href="#delete">Deleting data from the cache</a>
        </li>
        <li>
          <a href="#exists">Checking cache existence</a>
        </li>
        <li>
          <a href="#lifetime">Lifetime</a>
        </li>
        <li>
          <a href="#multi-level">Multi-Level Cache</a>
        </li>
        <li>
          <a href="#adapters-frontend">Frontend Adapters</a> 
          <ul>
            <li>
              <a href="#adapters-frontend-custom">Implementing your own Frontend adapters</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#adapters-backend">Backend Adapters</a> 
          <ul>
            <li>
              <a href="#adapters-backend-factory">Factory</a>
            </li>
            <li>
              <a href="#adapters-backend-custom">Implementing your own Backend adapters</a>
            </li>
            <li>
              <a href="#adapters-backend-file">File Backend Options</a>
            </li>
            <li>
              <a href="#adapters-backend-libmemcached">Libmemcached Backend Options</a>
            </li>
            <li>
              <a href="#adapters-backend-memcache">Memcache Backend Options</a>
            </li>
            <li>
              <a href="#adapters-backend-apc">APC Backend Options</a>
            </li>
            <li>
              <a href="#adapters-backend-apcu">APCU Backend Options</a>
            </li>
            <li>
              <a href="#adapters-backend-mongo">Mongo Backend Options</a>
            </li>
            <li>
              <a href="#adapters-backend-xcache">XCache Backend Options</a>
            </li>
            <li>
              <a href="#adapters-backend-redis">Redis Backend Options</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# キャッシュによるパフォーマンスの向上

Phalcon は、頻繁に使用される、またはすでに処理されたデータに、高速なアクセスを行う `Phalcon\Cache` クラスを提供しています。 `Phalcon\Cache` は C で実装され、バックエンドからアイテムを取得する際にオーバーヘッドを減らし、高いパフォーマンスで動作します。 このクラスでは、フロントエンドとバックエンドのコンポーネントの内部構造を使用します。 フロントエンドコンポーネントは、バックエンドコンポーネントクラスにストレージオプションを提供しながら入力ソースまたはインターフェイスとして機能します。

<a name='implementation'></a>

## いつキャッシュを実装する？

このコンポーネントは非常に高速ですが、必要でないケースで実装すると、利用することで得られるメリットよりも、パフォーマンスの低下によるデメリットの方が大きくなる可能性があります。キャッシュを利用する前に、次のケースについて確認する事をお勧めします。

* 毎回同じ結果 (変更頻度の低い) を返す複雑な計算をしている
* 多くのヘルパを利用し、生成される出力がほとんど同じである
* You are accessing database data constantly and these data rarely change

<div class='alert alert-warning'>
    <p>
        <strong>メモ</strong> キャッシュを実装した後でも、一定の期間でキャッシュのヒット率を確認するようにしましょう。 This can easily be done, especially in the case of Memcache or Apc, with the relevant tools that the backends provide.
    </p>
</div>

<a name='caching-behavior'></a>

## キャッシュの振る舞い

The caching process is divided into 2 parts:

* **Frontend**: This part is responsible for checking if a key has expired and perform additional transformations to the data before storing and after retrieving them from the backend-
* **Backend**: This part is responsible for communicating, writing/reading the data required by the frontend.

<a name='factory'></a>

## Factory

Instantiating frontend or backend adapters can be achieved by two ways:

Traditional way

```php
<?php

use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data as FrontData;

// Create an Output frontend. Cache the files for 2 days
$frontCache = new FrontData(
    [
        'lifetime' => 172800,
    ]
);

// Create the component that will cache from the 'Output' to a 'File' backend
// Set the cache file directory - it's important to keep the '/' at the end of
// the value for the folder
$cache = new BackFile(
    $frontCache,
    [
        'cacheDir' => '../app/cache/',
    ]
);
```

or using the Factory object as follows:

```php
<?php

use Phalcon\Cache\Frontend\Factory as FFactory;
use Phalcon\Cache\Backend\Factory as BFactory;

 $options = [
     'lifetime' => 172800,
     'adapter'  => 'data',
 ];
 $frontendCache = FFactory::load($options);


$options = [
    'cacheDir' => '../app/cache/',
    'prefix'   => 'app-data',
    'frontend' => $frontendCache,
    'adapter'  => 'file',
];

$backendCache = BFactory::load($options);
```

<a name='output-fragments'></a>

## Caching Output Fragments

An output fragment is a piece of HTML or text that is cached as is and returned as is. The output is automatically captured from the `ob_*` functions or the PHP output so that it can be saved in the cache. The following example demonstrates such usage. It receives the output generated by PHP and stores it into a file. The contents of the file are refreshed every 172,800 seconds (2 days).

The implementation of this caching mechanism allows us to gain performance by not executing the helper `Phalcon\Tag::linkTo()` call whenever this piece of code is called.

```php
<?php

use Phalcon\Tag;
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Output as FrontOutput;

// Create an Output frontend. Cache the files for 2 days
$frontCache = new FrontOutput(
    [
        'lifetime' => 172800,
    ]
);

// Create the component that will cache from the 'Output' to a 'File' backend
// Set the cache file directory - it's important to keep the '/' at the end of
// the value for the folder
$cache = new BackFile(
    $frontCache,
    [
        'cacheDir' => '../app/cache/',
    ]
);

// Get/Set the cache file to ../app/cache/my-cache.html
$content = $cache->start('my-cache.html');

// If $content is null then the content will be generated for the cache
if ($content === null) {
    // Print date and time
    echo date('r');

    // Generate a link to the sign-up action
    echo Tag::linkTo(
        [
            'user/signup',
            'Sign Up',
            'class' => 'signup-button',
        ]
    );

    // Store the output into the cache file
    $cache->save();
} else {
    // Echo the cached output
    echo $content;
}
```

<div class='alert alert-warning'>
    <p>
        <strong>NOTE</strong> In the example above, our code remains the same, echoing output to the user as it has been doing before. Our cache component transparently captures that output and stores it in the cache file (when the cache is generated) or it sends it back to the user pre-compiled from a previous call, thus avoiding expensive operations.
    </p>
</div>

<a name='arbitrary-data'></a>

## Caching Arbitrary Data

Caching just data is equally important for your application. Caching can reduce database load by reusing commonly used (but not updated) data, thus speeding up your application.

<a name='backend-file-example'></a>

### File Backend Example

One of the caching adapters is `File`. The only key area for this adapter is the location of where the cache files will be stored. This is controlled by the `cacheDir` option which *must* have a backslash at the end of it.

```php
<?php

use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cache the files for 2 days using a Data frontend
$frontCache = new FrontData(
    [
        'lifetime' => 172800,
    ]
);

// Create the component that will cache 'Data' to a 'File' backend
// Set the cache file directory - important to keep the `/` at the end of
// the value for the folder
$cache = new BackFile(
    $frontCache,
    [
        'cacheDir' => '../app/cache/',
    ]
);

$cacheKey = 'robots_order_id.cache';

// Try to get cached records
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robots is null because of cache expiration or data does not exist
    // Make the database call and populate the variable
    $robots = Robots::find(
        [
            'order' => 'id',
        ]
    );

    // Store it in the cache
    $cache->save($cacheKey, $robots);
}

// Use $robots :)
foreach ($robots as $robot) {
   echo $robot->name, '\n';
}
```

<a name='backend-memcached-example'></a>

### Memcached Backend Example

The above example changes slightly (especially in terms of configuration) when we are using a Memcached backend.

```php
<?php

use Phalcon\Cache\Frontend\Data as FrontData;
use Phalcon\Cache\Backend\Libmemcached as BackMemCached;

// Cache data for one hour
$frontCache = new FrontData(
    [
        'lifetime' => 3600,
    ]
);

// Create the component that will cache 'Data' to a 'Memcached' backend
// Memcached connection settings
$cache = new BackMemCached(
    $frontCache,
    [
        'servers' => [
            [
                'host'   => '127.0.0.1',
                'port'   => '11211',
                'weight' => '1',
            ]
        ]
    ]
);

$cacheKey = 'robots_order_id.cache';

// Try to get cached records
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robots is null because of cache expiration or data does not exist
    // Make the database call and populate the variable
    $robots = Robots::find(
        [
            'order' => 'id',
        ]
    );

    // Store it in the cache
    $cache->save($cacheKey, $robots);
}

// Use $robots :)
foreach ($robots as $robot) {
   echo $robot->name, '\n';
}
```

<div class='alert alert-warning'>
    <p>
        <strong>NOTE</strong> Calling <code>save()</code> will return a boolean, indicating success (<code>true</code>) or failure (<code>false</code>). Depending on the backend that you use, you will need to look at the relevant logs to identify failures.
    </p>
</div>

<a name='read'></a>

## Querying the cache

The elements added to the cache are uniquely identified by a key. In the case of the File backend, the key is the actual filename. To retrieve data from the cache, we just have to call it using the unique key. If the key does not exist, the get method will return null.

```php
<?php

// Retrieve products by key 'myProducts'
$products = $cache->get('myProducts');
```

If you want to know which keys are stored in the cache you could call the `queryKeys` method:

```php
<?php

// Query all keys used in the cache
$keys = $cache->queryKeys();

foreach ($keys as $key) {
    $data = $cache->get($key);

    echo 'Key=', $key, ' Data=', $data;
}

// Query keys in the cache that begins with 'my-prefix'
$keys = $cache->queryKeys('my-prefix');
```

<a name='delete'></a>

## Deleting data from the cache

There are times where you will need to forcibly invalidate a cache entry (due to an update in the cached data). The only requirement is to know the key that the data have been stored with.

```php
<?php

// Delete an item with a specific key
$cache->delete('someKey');

$keys = $cache->queryKeys();

// Delete all items from the cache
foreach ($keys as $key) {
    $cache->delete($key);
}
```

<a name='exists'></a>

## Checking cache existence

It is possible to check if a cache already exists with a given key:

```php
<?php

if ($cache->exists('someKey')) {
    echo $cache->get('someKey');
} else {
    echo 'Cache does not exists!';
}
```

<a name='lifetime'></a>

## Lifetime

A `lifetime` is a time in seconds that a cache could live without expire. By default, all the created caches use the lifetime set in the frontend creation. You can set a specific lifetime in the creation or retrieving of the data from the cache:

Setting the lifetime when retrieving:

```php
<?php

$cacheKey = 'my.cache';

// Setting the cache when getting a result
$robots = $cache->get($cacheKey, 3600);

if ($robots === null) {
    $robots = 'some robots';

    // Store it in the cache
    $cache->save($cacheKey, $robots);
}
```

Setting the lifetime when saving:

```php
<?php

$cacheKey = 'my.cache';

$robots = $cache->get($cacheKey);

if ($robots === null) {
    $robots = 'some robots';

    // Setting the cache when saving data
    $cache->save($cacheKey, $robots, 3600);
}
```

<a name='multi-level'></a>

## Multi-Level Cache

This feature of the cache component, allows the developer to implement a multi-level cache. This new feature is very useful because you can save the same data in several cache locations with different lifetimes, reading first from the one with the faster adapter and ending with the slowest one until the data expires:

```php
<?php

use Phalcon\Cache\Multiple;
use Phalcon\Cache\Backend\Apc as ApcCache;
use Phalcon\Cache\Backend\File as FileCache;
use Phalcon\Cache\Frontend\Data as DataFrontend;
use Phalcon\Cache\Backend\Memcache as MemcacheCache;

$ultraFastFrontend = new DataFrontend(
    [
        'lifetime' => 3600,
    ]
);

$fastFrontend = new DataFrontend(
    [
        'lifetime' => 86400,
    ]
);

$slowFrontend = new DataFrontend(
    [
        'lifetime' => 604800,
    ]
);

// Backends are registered from the fastest to the slower
$cache = new Multiple(
    [
        new ApcCache(
            $ultraFastFrontend,
            [
                'prefix' => 'cache',
            ]
        ),
        new MemcacheCache(
            $fastFrontend,
            [
                'prefix' => 'cache',
                'host'   => 'localhost',
                'port'   => '11211',
            ]
        ),
        new FileCache(
            $slowFrontend,
            [
                'prefix'   => 'cache',
                'cacheDir' => '../app/cache/',
            ]
        ),
    ]
);

// Save, saves in every backend
$cache->save('my-key', $data);
```

<a name='adapters-frontend'></a>

## Frontend Adapters

The available frontend adapters that are used as interfaces or input sources to the cache are:

| Adapter                              | Description                                                                                                                                                    |
| ------------------------------------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Cache\Frontend\Output`   | Read input data from standard PHP output.                                                                                                                      |
| `Phalcon\Cache\Frontend\Data`     | It's used to cache any kind of PHP data (big arrays, objects, text, etc). Data is serialized before stored in the backend.                                     |
| `Phalcon\Cache\Frontend\Base64`   | It's used to cache binary data. The data is serialized using `base64_encode` before be stored in the backend.                                                  |
| `Phalcon\Cache\Frontend\Json`     | Data is encoded in JSON before be stored in the backend. Decoded after be retrieved. This frontend is useful to share data with other languages or frameworks. |
| `Phalcon\Cache\Frontend\Igbinary` | It's used to cache any kind of PHP data (big arrays, objects, text, etc). Data is serialized using `Igbinary` before be stored in the backend.                 |
| `Phalcon\Cache\Frontend\None`     | It's used to cache any kind of PHP data without serializing them.                                                                                              |

<a name='adapters-frontend-custom'></a>

### Implementing your own Frontend adapters

The `Phalcon\Cache\FrontendInterface` interface must be implemented in order to create your own frontend adapters or extend the existing ones.

<a name='adapters-backend'></a>

## Backend Adapters

The backend adapters available to store cache data are:

| Adapter                                 | Description                                          | Info                                      | Required Extensions                                |
| --------------------------------------- | ---------------------------------------------------- | ----------------------------------------- | -------------------------------------------------- |
| `Phalcon\Cache\Backend\Apc`          | Stores data to the Alternative PHP Cache (APC).      | [APC](http://php.net/apc)                 | [APC](http://pecl.php.net/package/APC)             |
| `Phalcon\Cache\Backend\Apcu`         | Stores data to the APCu (APC without opcode caching) | [APCu](http://php.net/apcu)               | [APCu](http://pecl.php.net/package/APCu)           |
| `Phalcon\Cache\Backend\File`         | Stores data to local plain files.                    |                                           |                                                    |
| `Phalcon\Cache\Backend\Libmemcached` | Stores data to a memcached server.                   | [Memcached](http://www.php.net/memcached) | [Memcached](http://pecl.php.net/package/memcached) |
| `Phalcon\Cache\Backend\Memcache`     | Stores data to a memcached server.                   | [Memcache](http://www.php.net/memcache)   | [Memcache](http://pecl.php.net/package/memcache)   |
| `Phalcon\Cache\Backend\Memory`       | Stores data in memory                                |                                           |                                                    |
| `Phalcon\Cache\Backend\Mongo`        | Stores data to Mongo Database.                       | [MongoDB](http://mongodb.org/)            | [Mongo](http://mongodb.org/)                       |
| `Phalcon\Cache\Backend\Redis`        | Stores data in Redis.                                | [Redis](http://redis.io/)                 | [Redis](http://pecl.php.net/package/redis)         |
| `Phalcon\Cache\Backend\Xcache`       | Stores data in XCache.                               | [XCache](http://xcache.lighttpd.net/)     | [XCache](http://pecl.php.net/package/xcache)       |

<a name='adapters-backend-factory'></a>

### Factory

There are many backend adapters (see [Backend Adapters](#adapters-backend)). The one you use will depend on the needs of your application. The following example loads the Backend Cache Adapter class using `adapter` option, if frontend will be provided as array it will call Frontend Cache Factory

```php
<?php

use Phalcon\Cache\Backend\Factory;
use Phalcon\Cache\Frontend\Data;

$options = [
    'prefix'   => 'app-data',
    'frontend' => new Data(),
    'adapter'  => 'apc',
];
$backendCache = Factory::load($options);
```

<a name='adapters-backend-custom'></a>

### Implementing your own Backend adapters

The `Phalcon\Cache\BackendInterface` interface must be implemented in order to create your own backend adapters or extend the existing ones.

<a name='adapters-backend-file'></a>

### File Backend Options

This backend will store cached content into files in the local server. The available options for this backend are:

| Option     | Description                                                 |
| ---------- | ----------------------------------------------------------- |
| `prefix`   | A prefix that is automatically prepended to the cache keys. |
| `cacheDir` | A writable directory on which cached files will be placed.  |

<a name='adapters-backend-libmemcached'></a>

### Libmemcached Backend Options

This backend will store cached content on a memcached server. Per default persistent memcached connection pools are used. The available options for this backend are:

**General options**

| Option          | Description                                                                                                        |
| --------------- | ------------------------------------------------------------------------------------------------------------------ |
| `statsKey`      | Used to tracking of cached keys.                                                                                   |
| `prefix`        | A prefix that is automatically prepended to the cache keys.                                                        |
| `persistent_id` | To create an instance that persists between requests, use `persistent_id` to specify a unique ID for the instance. |

**Servers options**

| Option   | Description                                                                                                 |
| -------- | ----------------------------------------------------------------------------------------------------------- |
| `host`   | The `memcached` host.                                                                                       |
| `port`   | The `memcached` port.                                                                                       |
| `weight` | The weight parameter effects the consistent hashing used to determine which server to read/write keys from. |

**Client options**

Used for setting Memcached options. See [Memcached::setOptions](http://php.net/manual/en/memcached.setoptions.php) for more.

**Example**

```php
<?php
use Phalcon\Cache\Backend\Libmemcached;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cache data for 2 days
$frontCache = new FrontData(
    [
        'lifetime' => 172800,
    ]
);

// Create the Cache setting memcached connection options
$cache = new Libmemcached(
    $frontCache,
    [
        'servers' => [
            [
                'host'   => '127.0.0.1',
                'port'   => 11211,
                'weight' => 1,
            ],
        ],
        'client' => [
            \Memcached::OPT_HASH       => \Memcached::HASH_MD5,
            \Memcached::OPT_PREFIX_KEY => 'prefix.',
        ],
        'persistent_id' => 'my_app_cache',
    ]
);
```

<a name='adapters-backend-memcache'></a>

### Memcache Backend Options

This backend will store cached content on a memcached server. The available options for this backend are:

| Option       | Description                                                 |
| ------------ | ----------------------------------------------------------- |
| `prefix`     | A prefix that is automatically prepended to the cache keys. |
| `host`       | The memcached host.                                         |
| `port`       | The memcached port.                                         |
| `persistent` | Create a persistent connection to memcached?                |

<a name='adapters-backend-apc'></a>

### APC Backend Options

This backend will store cached content on Alternative PHP Cache ([APC](http://php.net/apc)). The available options for this backend are:

| Option   | Description                                                 |
| -------- | ----------------------------------------------------------- |
| `prefix` | A prefix that is automatically prepended to the cache keys. |

<a name='adapters-backend-apcu'></a>

### APCU Backend Options

This backend will store cached content on Alternative PHP Cache ([APCU](http://php.net/apcu)). The available options for this backend are:

| Option   | Description                                                 |
| -------- | ----------------------------------------------------------- |
| `prefix` | A prefix that is automatically prepended to the cache keys. |

<a name='adapters-backend-mongo'></a>

### Mongo Backend Options

This backend will store cached content on a MongoDB server ([MongoDB](http://mongodb.org/)). The available options for this backend are:

| Option       | Description                                                 |
| ------------ | ----------------------------------------------------------- |
| `prefix`     | A prefix that is automatically prepended to the cache keys. |
| `server`     | A MongoDB connection string.                                |
| `db`         | Mongo database name.                                        |
| `collection` | Mongo collection in the database.                           |

<a name='adapters-backend-xcache'></a>

### XCache Backend Options

This backend will store cached content on XCache ([XCache](http://xcache.lighttpd.net/)). The available options for this backend are:

| Option   | Description                                                 |
| -------- | ----------------------------------------------------------- |
| `prefix` | A prefix that is automatically prepended to the cache keys. |

<a name='adapters-backend-redis'></a>

### Redis Backend Options

This backend will store cached content on a Redis server ([Redis](http://redis.io/)). The available options for this backend are:

| Option       | Description                                                    |
| ------------ | -------------------------------------------------------------- |
| `prefix`     | A prefix that is automatically prepended to the cache keys.    |
| `host`       | Redis host.                                                    |
| `port`       | Redis port.                                                    |
| `auth`       | Password to authenticate to a password-protected Redis server. |
| `persistent` | Create a persistent connection to Redis.                       |
| `index`      | The index of the Redis database to use.                        |

There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator)