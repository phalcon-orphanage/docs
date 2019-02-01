---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Cli\Router\Route'
---
# Class **Phalcon\Cli\Router\Route**

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/router/route.zep)

此类表示每个路由添加到路由器

## 常量

*string* **DEFAULT_DELIMITER**

## 方法

public **__construct** (*string* $pattern, [*array* $paths])

Phalcon\Cli\Router\Route constructor

public **compilePattern** (*mixed* $pattern)

从模式返回有效 PCRE 正则表达式替换占位符

public *array* | *boolean* **extractNamedParams** (*string* $pattern)

从字符串中提取参数

public **reConfigure** (*string* $pattern, [*array* $paths])

重新配置路由添加一个新的模式和路径集

public **getName** ()

返回路由的名称

public **setName** (*mixed* $name)

设置路由的名称

```php
<?php

$router->add(
    "/about",
    [
        "controller" => "about",
    ]
)->setName("about");

```

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **beforeMatch** (*callback* $callback)

Sets a callback that is called if the route is matched. The developer can implement any arbitrary conditions here If the callback returns false the route is treated as not matched

public *mixed* **getBeforeMatch** ()

如果任何，返回 'before match' 回调

public **getRouteId** ()

返回的路线 id

public **getPattern** ()

返回路由的模式

public **getCompiledPattern** ()

返回路由的编译的模式

public **getPaths** ()

返回的路径

public **getReversedPaths** ()

返回的路径作为值作为键和名称使用位置

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **convert** (*string* $name, *callable* $converter)

添加一个转换器来为某些参数执行额外的转换

public **getConverters** ()

返回路由器转换器

public static **reset** ()

重置内部路由 id 生成器

public static **delimiter** ([*mixed* $delimiter])

设置路由的分隔符

public static **getDelimiter** ()

获取路由分隔符