---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Base64'
---
# Class **Phalcon\Cache\Frontend\Base64**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/base64.zep)

允许缓存数据转换/deconverting 使用base64。

此适配器使用 base64_encode/base64_decode PHP 的功能

```php
<?php

<?php

// Cache the files for 2 days using a Base64 frontend
$frontCache = new \Phalcon\Cache\Frontend\Base64(
    [
        "lifetime" => 172800,
    ]
);

//Create a MongoDB cache
$cache = new \Phalcon\Cache\Backend\Mongo(
    $frontCache,
    [
        "server"     => "mongodb://localhost",
        "db"         => "caches",
        "collection" => "images",
    ]
);

$cacheKey = "some-image.jpg.cache";

// Try to get cached image
$image = $cache->get($cacheKey);

if ($image === null) {
    // Store the image in the cache
    $cache->save(
        $cacheKey,
        file_get_contents("tmp-dir/some-image.jpg")
    );
}

header("Content-Type: image/jpeg");

echo $image;

```

## 方法

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Base64 constructor

public **getLifetime** ()

返回缓存生存期

public **isBuffering** ()

检查是否如果前端缓冲输出

public **start** ()

Starts output frontend. Actually, does nothing in this adapter

public *string* **getContent** ()

返回输出缓存的内容

public **stop** ()

停止输出前端

public **beforeStore** (*mixed* $data)

将数据序列化存储他们之前

public **afterRetrieve** (*mixed* $data)

Unserializes 后检索数据