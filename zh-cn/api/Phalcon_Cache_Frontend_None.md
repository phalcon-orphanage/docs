---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Cache\Frontend\None'
---
# Class **Phalcon\Cache\Frontend\None**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/none.zep)

Discards any kind of frontend data input. This frontend does not have expiration time or any other options

```php
<?php

<?php

//Create a None Cache
$frontCache = new \Phalcon\Cache\Frontend\None();

// Create the component that will cache "Data" to a "Memcached" backend
// Memcached connection settings
$cache = new \Phalcon\Cache\Backend\Memcache(
    $frontCache,
    [
        "host" => "localhost",
        "port" => "11211",
    ]
);

$cacheKey = "robots_order_id.cache";

// This Frontend always return the data as it's returned by the backend
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // This cache doesn't perform any expiration checking, so the data is always expired
    // Make the database call and populate the variable
    $robots = Robots::find(
        [
            "order" => "id",
        ]
    );

    $cache->save($cacheKey, $robots);
}

// Use $robots :)
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

```

## 方法

public **getLifetime** ()

返回缓存生存期，总是一秒过期内容

public **isBuffering** ()

检查是否如果前端总是 false 缓冲输出，

public **start** ()

开始输出前端

public *string* **getContent** ()

返回输出缓存的内容

public **stop** ()

停止输出前端

public **beforeStore** (*mixed* $data)

准备要存储的数据

public **afterRetrieve** (*mixed* $data)

准备数据检索到用户