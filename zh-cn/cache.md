* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# 使用高速缓存提高性能

Phacon提供 `Phalcon\Cache` 类允许更快地访问常用或已处理的数据。 `Phalcon\Cache` 是用 C 编写的实现更高的性能和降低开销，当从后端获取项目。 此类使用前端和后端组件的内部的结构。 前端组件作为输入的源或接口后, 端组件提供对类的存储选项。

<a name='implementation'></a>

## When to implement cache?

Although this component is very fast, implementing it in cases that are not needed could lead to a loss of performance rather than gain. We recommend you check this cases before using a cache:

* 你使复杂的运算，每次都返回相同的结果 （不经常更改）
* 你正在使用大量的助手和生成的输出几乎都是一样
* 你正在不断地访问数据库中的数据，这些数据很少更改

<div class='alert alert-warning'>
    <p>
        <strong>注意</strong>即使在执行缓存之后, 应在一段时间检查您的缓存的命中率。 这能很容易做到，尤其是 Memcache 或 Apc，与后端提供的相关工具。
    </p>
</div>

<a name='caching-behavior'></a>

## 缓存行为

缓存的过程分为 2 个部分：

* <0Frontend</strong>： 这一部分是负责检查，如果密钥已过期，并且执行更多转换对数据存储之前和之后从后端-检索
* **Backend**： 这部分是负责沟通，写/读前端所需的数据。

<a name='factory'></a>

## 工厂

实例化前端或后端适配器可以通过两种方式实现：

传统的方式

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

或使用工厂对象，如下所示：

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

## 缓存的视图片段

输出片段是一块的 HTML 或文本，缓存是原样退回。 从 `ob_ *` 函数或 PHP 输出，这样它可以保存在缓存中，将自动捕获输出。 下面的示例演示这种用法。 它接收由 PHP 生成的输出，并将其存储到一个文件。 该文件的内容是每 172,800 秒刷新 （2 天）。

这种缓存机制的实施使我们能够通过不执行该佣工 `Phalcon\Tag::linkTo()` 调用获得性能，任何时候调用这段代码。

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
        <strong>注意</strong>在上面的示例中，我们的代码保持不变，回显输出给用户，像之前它做的那样。 我们缓存组件透明地捕获该输出并将其存储在缓存文件中 （当生成缓存时） 或它将其发送回用户预编译从以前的调用，从而避免昂贵的操作。
    </p>
</div>

<a name='arbitrary-data'></a>

## 任意的数据缓存

缓存只是数据是同样重要的是您的应用程序。缓存可以减少数据库负载，通过重用常用 （但不是更新） 的数据，从而加快您的应用程序。

<a name='backend-file-example'></a>

### 文件后端示例

缓存的适配器之`File`。 此适配器的唯一的重点区域是位置的将存储缓存文件的位置。 这是由 `cacheDir` 选项，其中 *必须* 有一个反斜杠在结束了它的控制。

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

### Memcached 后端示例

上面的例子会略有改变 （尤其是在职权配置） 当我们使用 Memcached 后端。

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
        <strong>注意</strong><code>Save （）</code> 调用此方法将返回一个布尔值，该值指示成功 (<code>true</code>) 或失败 (<code>false</code>)。 根据您使用的后端，需要看看相关的日志，以确定故障。
    </p>
</div>

<a name='read'></a>

## 查询缓存

添加到缓存中的元素由一个密钥是唯一的标识。 在文件的后端，关键是实际的文件名。 要从缓存中检索数据，我们只需要调用它使用的唯一键。 如果不存在的键，get 方法将返回 null。

```php
<?php

// Retrieve products by key 'myProducts'
$products = $cache->get('myProducts');
```

如果你想要知道哪些键存储在缓存中你可以调用 `queryKeys` 方法：

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

## 从缓存中删除数据

有次在那里，您将需要强行无效 （由于缓存的数据更新） 的缓存条目。唯一的要求是要知道数据存储在一起的关键。

```php
<?php

// Delete an item with a specific key
$cache->delete('someKey');

$keys = $cache->queryKeys();

// 从缓存中删除这些数据
foreach ($keys as $key) {
    $cache->delete($key);
}
```

<a name='exists'></a>

## 检查缓存中存在

它是可能要检查是否缓存中已存在具有给定的键：

```php
<?php

if ($cache->exists('someKey')) {
    echo $cache->get('someKey');
} else {
    echo 'Cache does not exists!';
}
```

<a name='lifetime'></a>

## 生命周期

`lifetime` 是以秒为单位，缓存可以活没有到期的时间。 默认情况下，所有创建的缓存使用设置前端创作中的生存期。 在创建或从缓存中数据的检索，您可以设置特定的生存期：

设置生存期时检索：

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

在保存时设置生存期：

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

## 多级缓存

高速缓存组件，此功能允许开发人员来实现多级缓存。 这一新功能是十分有用的因为你可以将相同的数据保存在几个缓存位置具有不同的生存期，首先阅读从一个更快的适配器和结束与最慢的一个，直到数据过期：

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

## 前端适配器

使用可用的前端适配器接口或输入的源到缓存中：

| 适配器                                                                       | 描述                                                                                                                                                             |
| ------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Cache\Frontend\Output](api/Phalcon_Cache_Frontend_Output)     | 从标准的 PHP 输出中读取输入的数据。                                                                                                                                           |
| [Phalcon\Cache\Frontend\Data](api/Phalcon_Cache_Frontend_Data)         | 它用来缓存任何类型的 PHP 数据 （大数组、 对象、 文本等）。数据序列化之前存储在后端。                                                                                                                 |
| [Phalcon\Cache\Frontend\Base64](api/Phalcon_Cache_Frontend_Base64)     | 它用来缓存二进制数据。使用 `base64_encode` 序列化数据之前将存储在后端。                                                                                                                   |
| [Phalcon\Cache\Frontend\Json](api/Phalcon_Cache_Frontend_Json)         | Data is encoded in JSON before be stored in the backend. Decoded after be retrieved. This frontend is useful to share data with other languages or frameworks. |
| [Phalcon\Cache\Frontend\Igbinary](api/Phalcon_Cache_Frontend_Igbinary) | 它用来缓存任何类型的 PHP 数据 （大数组、 对象、 文本等）。使用 `Igbinary` 序列化数据之前将存储在后端。                                                                                                  |
| [Phalcon\Cache\Frontend\None](api/Phalcon_Cache_Frontend_None)         | 它用来缓存任何类型的 PHP 数据没有将其序列化。                                                                                                                                      |

<a name='adapters-frontend-custom'></a>

### 执行您自己的前端适配器

The [Phalcon\Cache\FrontendInterface](api/Phalcon_Cache_FrontendInterface) interface must be implemented in order to create your own frontend adapters or extend the existing ones.

<a name='adapters-backend'></a>

## 后端适配器

后端适配器可用于存储缓存数据如下：

| 适配器                                                                             | 描述                             | 信息                                         | 所需的扩展                                               |
| ------------------------------------------------------------------------------- | ------------------------------ | ------------------------------------------ | --------------------------------------------------- |
| [Phalcon\Cache\Backend\Apc](api/Phalcon_Cache_Backend_Apc)                   | 存储数据到替代 PHP 缓存 (APC)。          | [APC](https://php.net/apc)                 | [APC](https://pecl.php.net/package/APC)             |
| `Phalcon\Cache\Backend\Apcu`                                                 | 存储数据的处理 (APC 不操作码缓存)           | [APCu](https://php.net/apcu)               | [APCu](https://pecl.php.net/package/APCu)           |
| [Phalcon\Cache\Backend\File](api/Phalcon_Cache_Backend_File)                 | 存储到本地普通文件的数据。                  |                                            |                                                     |
| [Phalcon\Cache\Backend\Libmemcached](api/Phalcon_Cache_Backend_Libmemcached) | 存储到 memcached 服务器数据。           | [Memcached](https://www.php.net/memcached) | [Memcached](https://pecl.php.net/package/memcached) |
| [Phalcon\Cache\Backend\Memcache](api/Phalcon_Cache_Backend_Memcache)         | 存储到 memcached 服务器数据。           | [Memcache](https://www.php.net/memcache)   | [Memcache](https://pecl.php.net/package/memcache)   |
| [Phalcon\Cache\Backend\Memory](api/Phalcon_Cache_Backend_Memory)             | Stores data in memory          |                                            |                                                     |
| [Phalcon\Cache\Backend\Mongo](api/Phalcon_Cache_Backend_Mongo)               | Stores data to Mongo Database. | [MongoDB](https://mongodb.org/)            | [Mongo](https://mongodb.org/)                       |
| [Phalcon\Cache\Backend\Redis](api/Phalcon_Cache_Backend_Redis)               | Stores data in Redis.          | [Redis](https://redis.io/)                 | [Redis](https://pecl.php.net/package/redis)         |
| [Phalcon\Cache\Backend\Xcache](api/Phalcon_Cache_Backend_Xcache)             | Stores data in XCache.         | [XCache](https://xcache.lighttpd.net/)     | [XCache](https://pecl.php.net/package/xcache)       |

##### **NOTE** In PHP 7 to use phalcon `apc` based adapter classes you needed to install `apcu` and `apcu_bc` package from pecl. Now in Phalcon 4.0.0 you can switch your `<em>\Apc` classes to `</em>\Apcu` and remove `apcu_bc`. Keep in mind that in Phalcon 4 we will most likely remove all `*\Apc` classes. {.alert.alert-warning}

<a name='adapters-backend-factory'></a>

### 工厂

有很多 （见 [后端适配器](#adapters-backend)） 的后端适配器。 您使用将取决于您的应用程序的需要。 下面的示例加载后端缓存适配器类使用 `适配器` 选项，如果前端将提供数组作为它将调用前端缓存工厂

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

### 执行您自己的后端适配器

The [Phalcon\Cache\BackendInterface](api/Phalcon_Cache_BackendInterface) interface must be implemented in order to create your own backend adapters or extend the existing ones.

<a name='adapters-backend-file'></a>

### 文件后端选项

这个后端会将缓存的内容存储到本地服务器中的文件。这个后端的可用选项有：

| 选项         | 描述           |
| ---------- | ------------ |
| `前缀`       | 自动预置到缓存键的前缀。 |
| `cacheDir` | 将缓存的文件可写目录。  |

<a name='adapters-backend-libmemcached'></a>

### Libmemcached 后端选项

这个后端将 memcached 服务器上存储缓存的内容。每个默认使用持久性 memcached 连接池。这个后端的可用选项有：

**常规选项**

| 选项              | 描述                                               |
| --------------- | ------------------------------------------------ |
| `statsKey`      | 用于动态跟踪的缓存键。                                      |
| `前缀`            | 自动预置到缓存键的前缀。                                     |
| `persistent_id` | 若要创建一个请求之间仍然存在的实例，使用 `persistent_id` 指定实例的唯一 ID。 |

**服务器选项**

| 选项       | 描述                          |
| -------- | --------------------------- |
| `host`   | `Memcached` 主机。             |
| `port`   | `Memcached` 端口。             |
| `weight` | 重量参数影响一致性哈希用于确定哪个服务器读/写钥匙从。 |

**客户端选项**

Used for setting Memcached options. See [Memcached::setOptions](https://php.net/manual/en/memcached.setoptions.php) for more.

**示例**

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

### Memcache 后端选项

这个后端将 memcached 服务器上存储缓存的内容。这个后端的可用选项有：

| 选项           | 描述                     |
| ------------ | ---------------------- |
| `前缀`         | 自动预置到缓存键的前缀。           |
| `host`       | Memcached 主机。          |
| `port`       | Memcached 端口。          |
| `persistent` | 创建到 memcached 的持久性连接吗？ |

<a name='adapters-backend-apc'></a>

### APC 后端选项

This backend will store cached content on Alternative PHP Cache ([APC](https://php.net/apc)). The available options for this backend are:

| 选项   | 描述           |
| ---- | ------------ |
| `前缀` | 自动预置到缓存键的前缀。 |

<a name='adapters-backend-apcu'></a>

### APCU 后端选项

This backend will store cached content on Alternative PHP Cache ([APCU](https://php.net/apcu)). The available options for this backend are:

| 选项   | 描述           |
| ---- | ------------ |
| `前缀` | 自动预置到缓存键的前缀。 |

<a name='adapters-backend-mongo'></a>

### Mongo后端选项

This backend will store cached content on a MongoDB server ([MongoDB](https://mongodb.org/)). The available options for this backend are:

| 选项           | 描述              |
| ------------ | --------------- |
| `前缀`         | 自动预置到缓存键的前缀。    |
| `服务器`        | MongoDB 的连接字符串。 |
| `db`         | 输入数据库名称。        |
| `collection` | Mongo 集合在数据库中。  |

<a name='adapters-backend-xcache'></a>

### XCache 后端选项

This backend will store cached content on XCache ([XCache](https://xcache.lighttpd.net/)). The available options for this backend are:

| 选项   | 描述           |
| ---- | ------------ |
| `前缀` | 自动预置到缓存键的前缀。 |

<a name='adapters-backend-redis'></a>

### Redis后端选项

This backend will store cached content on a Redis server ([Redis](https://redis.io/)). The available options for this backend are:

| 选项           | 描述                     |
| ------------ | ---------------------- |
| `前缀`         | 自动预置到缓存键的前缀。           |
| `host`       | Redis的主机。              |
| `port`       | Redis的端口               |
| `auth`       | 密码保护Redis服务器进行身份验证的密码。 |
| `persistent` | 创建与Redis持久连接。          |
| `index`      | Frontend数据库使用的索引。      |

There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator)