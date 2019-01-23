---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Output'
---
# Class **Phalcon\Cache\Frontend\Output**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/output.zep)

允许缓存输出片段与 ob_ * 函数捕获

```php <?php

* * use Phalcon\Tag; * use Phalcon\Cache\Backend\File; * use Phalcon\Cache\Frontend\Output; * * // Create an Output frontend. Cache the files for 2 days * $frontCache = new Output( * [ * "lifetime" => 172800, * ] * ); * * // Create the component that will cache from the "Output" to a "File" backend * // Set the cache file directory - it's important to keep the "/" at the end of * // the value for the folder * $cache = new File( * $frontCache, * [ * "cacheDir" => "../app/cache/", * ] * ); * * // Get/Set the cache file to ../app/cache/my-cache.html * $content = $cache->start("my-cache.html"); * * // If $content is null then the content will be generated for the cache * if (null === $content) { * // Print date and time * echo date("r"); * * // Generate a link to the sign-up action * echo Tag::linkTo( * [ * "user/signup", * "Sign Up", * "class" => "signup-button", * ] * ); * * // Store the output into the cache file * $cache->save(); * } else { * // Echo the cached output * echo $content; * }

*```

## 方法

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Output constructor

public **getLifetime** ()

返回缓存生存期

public **isBuffering** ()

检查是否如果前端缓冲输出

public **start** ()

Starts output frontend. Currently, does nothing

public *string* **getContent** ()

返回输出缓存的内容

public **stop** ()

停止输出前端

public **beforeStore** (*mixed* $data)

将数据序列化存储他们之前

public **afterRetrieve** (*mixed* $data)

Unserializes 后检索数据