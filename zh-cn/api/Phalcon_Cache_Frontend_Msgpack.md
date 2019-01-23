---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Msgpack'
---
# Class **Phalcon\Cache\Frontend\Msgpack**

*extends* class [Phalcon\Cache\Frontend\Data](Phalcon_Cache_Frontend_Data)

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/msgpack.zep)

允许缓存本机 PHP 数据序列化的形式，使用 msgpack 扩展此适配器使用 Msgpack 前端来存储缓存的内容和需要 msgpack 扩展。

```php
<?php

use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Frontend\Msgpack;

// Cache the files for 2 days using Msgpack frontend
$frontCache = new Msgpack(
    [
        "lifetime" => 172800,
    ]
);

// Create the component that will cache "Msgpack" to a "File" backend
// Set the cache file directory - important to keep the "/" at the end of
// of the value for the folder
$cache = new File(
    $frontCache,
    [
        "cacheDir" => "../app/cache/",
    ]
);

$cacheKey = "robots_order_id.cache";

// Try to get cached records
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robots is null due to cache expiration or data do not exist
    // Make the database call and populate the variable
    $robots = Robots::find(
        [
            "order" => "id",
        ]
    );

    // Store it in the cache
    $cache->save($cacheKey, $robots);
}

// Use $robots
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

```

## 方法

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Msgpack constructor

public **getLifetime** ()

返回缓存生存期

public **isBuffering** ()

检查是否如果前端缓冲输出

public **start** ()

Starts output frontend. Actually, does nothing

public **getContent** ()

返回输出缓存的内容

public **stop** ()

停止输出前端

public **beforeStore** (*mixed* $data)

将数据序列化存储他们之前

public **afterRetrieve** (*mixed* $data)

Unserializes 后检索数据