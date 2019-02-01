---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Cache\Multiple'
---
# Class **Phalcon\Cache\Multiple**

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/multiple.zep)

允许读取写入多个后端的链接后端适配器

```php
<?php

use Phalcon\Cache\Frontend\Data as DataFrontend;
use Phalcon\Cache\Multiple;
use Phalcon\Cache\Backend\Apc as ApcCache;
use Phalcon\Cache\Backend\Memcache as MemcacheCache;
use Phalcon\Cache\Backend\File as FileCache;

$ultraFastFrontend = new DataFrontend(
    [
        "lifetime" => 3600,
    ]
);

$fastFrontend = new DataFrontend(
    [
        "lifetime" => 86400,
    ]
);

$slowFrontend = new DataFrontend(
    [
        "lifetime" => 604800,
    ]
);

//Backends are registered from the fastest to the slower
$cache = new Multiple(
    [
        new ApcCache(
            $ultraFastFrontend,
            [
                "prefix" => "cache",
            ]
        ),
        new MemcacheCache(
            $fastFrontend,
            [
                "prefix" => "cache",
                "host"   => "localhost",
                "port"   => "11211",
            ]
        ),
        new FileCache(
            $slowFrontend,
            [
                "prefix"   => "cache",
                "cacheDir" => "../app/cache/",
            ]
        ),
    ]
);

//Save, saves in every backend
$cache->save("my-key", $data);

```

## 方法

public **__construct** ([[Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface) $backends])

Phalcon\Cache\Multiple constructor

public **push** ([Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface) $backend)

添加后端

public *mixed* **get** (*string* | *int* $keyName, [*int* $lifetime])

返回缓存的内容，阅读，对内部的后端

public **start** (*string* | *int* $keyName, [*int* $lifetime])

开始每个后端

public **save** ([*string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

将缓存的内容存储到所有的后端和前端停止

public *boolean* **delete** (*string* | *int* $keyName)

从每个后端删除一个值

public **exists** ([*string* | *int* $keyName], [*int* $lifetime])

检查缓存中是否存在中至少一个后端

public **flush** ()

刷新所有 backend(s)