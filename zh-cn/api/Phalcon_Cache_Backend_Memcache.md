---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Cache\Backend\Memcache'
---
# Class **Phalcon\Cache\Backend\Memcache**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/memcache.zep)

允许缓存输出片段、 PHP 数据或向 memcache 后端的原始数据

此适配器使用特殊 memcached 密钥"_PHCM"来存储适配器内部使用的所有密钥

```php
<?php

use Phalcon\Cache\Backend\Memcache;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cache data for 2 days
$frontCache = new FrontData(
    [
        "lifetime" => 172800,
    ]
);

// Create the Cache setting memcached connection options
$cache = new Memcache(
    $frontCache,
    [
        "host"       => "localhost",
        "port"       => 11211,
        "persistent" => false,
    ]
);

// Cache arbitrary data
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Get data
$data = $cache->get("my-data");

```

## 方法

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend\Memcache constructor

public **_connect** ()

创建内部连接到 memcached

public **addServers** (*mixed* $host, *mixed* $port, [*mixed* $persistent])

将服务器添加到 memcache 池

public **get** (*mixed* $keyName, [*mixed* $lifetime])

返回缓存的内容

public **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

将缓存的内容存储到文件后端和前端停止

public *boolean* **delete** (*int* | *string* $keyName)

将一个值从缓存中删除由它的键

public **queryKeys** ([*mixed* $prefix])

查询现有的缓存的键。

```php
<?php

$cache->save("users-ids", [1, 2, 3]);
$cache->save("projects-ids", [4, 5, 6]);

var_dump($cache->queryKeys("users")); // ["users-ids"]

```

public **exists** ([*string* $keyName], [*int* $lifetime])

检查是否存在缓存并没有过期

public **increment** ([*string* $keyName], [*mixed* $value])

增量的受到 $keyName $value

public **decrement** ([*string* $keyName], [*mixed* $value])

$keyName 通过减量给出 $value

public **flush** ()

立即使无效所有现有项目。

public **getFrontend** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public **setFrontend** (*mixed* $frontend) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public **getOptions** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public **setOptions** (*mixed* $options) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public **getLastKey** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public **setLastKey** (*mixed* $lastKey) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public *mixed* **start** (*int* | *string* $keyName, [*int* $lifetime]) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Starts a cache. The keyname allows to identify the created fragment

public **stop** ([*mixed* $stopBuffer]) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

停止前端, 不存储任何缓存的内容

public **isFresh** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

检查最后一个缓存是否新鲜或缓存

public **isStarted** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

检查缓存中是否已经开始缓冲或不

public *int* **getLifetime** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

获取最后一个生命周期