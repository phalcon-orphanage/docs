---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Data'
---
# Class **Phalcon\Cache\Frontend\Data**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/data.zep)

允许缓存本机 PHP 数据中的序列化形式

```php
<?php

use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Frontend\Data;

// Cache the files for 2 days using a Data frontend
$frontCache = new Data(
    [
        "lifetime" => 172800,
    ]
);

// Create the component that will cache "Data" to a 'File' backend
// Set the cache file directory - important to keep the '/' at the end of
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
    // $robots is null due to cache expiration or data does not exist
    // Make the database call and populate the variable
    $robots = Robots::find(
        [
            "order" => "id",
        ]
    );

    // Store it in the cache
    $cache->save($cacheKey, $robots);
}

// Use $robots :)
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

```

## 方法

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Data constructor

public **getLifetime** ()

返回缓存生存期

public **isBuffering** ()

检查是否如果前端缓冲输出

public **start** ()

Starts output frontend. Actually, does nothing

public *string* **getContent** ()

返回输出缓存的内容

public **stop** ()

停止输出前端

public **beforeStore** (*mixed* $data)

将数据序列化存储他们之前

public **afterRetrieve** (*mixed* $data)

Unserializes 后检索数据