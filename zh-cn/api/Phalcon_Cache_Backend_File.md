---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Cache\Backend\File'
---
# Class **Phalcon\Cache\Backend\File**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/file.zep)

允许缓存输出片段使用文件后端

```php
<?php

use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Frontend\Output as FrontOutput;

// 文件缓存有效期2天
$frontendOptions = [
    "lifetime" => 172800,
];

// 创建一个缓存输出
$frontCache = FrontOutput($frontOptions);

// 设置缓存文件的存在文件夹
$backendOptions = [
    "cacheDir" => "../app/cache/",
];

// 创建一个文件缓存的后端
$cache = new File($frontCache, $backendOptions);

$content = $cache->start("my-cache");

if ($content === null) {
    echo "<h1>", time(), "</h1>";

    $cache->save();
} else {
    echo $content;
}

```

## 方法

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, *array* $options)

Phalcon\Cache\Backend\File constructor

public **get** (*mixed* $keyName, [*mixed* $lifetime])

返回缓存的内容

public **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

将缓存的内容存储到文件后端和前端停止

public **delete** (*int* | *string* $keyName)

将一个值从缓存中删除由它的键

public **queryKeys** ([*mixed* $prefix])

查询现有的缓存的键。

```php
<?php

$cache->save("users-ids", [1, 2, 3]);
$cache->save("projects-ids", [4, 5, 6]);

var_dump($cache->queryKeys("users")); // ["users-ids"]

```

public **exists** ([*string* | *int* $keyName], [*int* $lifetime])

检查是否存在缓存并没有过期

public **increment** ([*string* | *int* $keyName], [*mixed* $value])

给定的键，通过编号 $value 的增量

public **decrement** ([*string* | *int* $keyName], [*mixed* $value])

给定的键，编号 $value 的减量化

public **flush** ()

立即使无效所有现有项目。

public **getKey** (*mixed* $key)

返回给定的密钥文件系统安全标识符

public **useSafeKey** (*mixed* $useSafeKey)

设置是使用还是不使用 safekey

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