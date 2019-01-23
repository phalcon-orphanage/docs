---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Mvc\Router\Route'
---
# Class **Phalcon\Mvc\Router\Route**

*implements* [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/router/route.zep)

此类表示每个路由添加到路由器

## 方法

public **__construct** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods])

Phalcon\Mvc\Router\Route constructor

public **compilePattern** (*mixed* $pattern)

从模式返回有效 PCRE 正则表达式替换占位符

public **via** (*mixed* $httpMethods)

设置一个或多个 HTTP 方法的约束匹配的路由

```php
<?php

$route->via("GET");

$route->via(
    [
        "GET",
        "POST",
    ]
);

```

public **extractNamedParams** (*mixed* $pattern)

从字符串中提取参数

public **reConfigure** (*mixed* $pattern, [*mixed* $paths])

重新配置路由添加一个新的模式和路径集

public static **getRoutePaths** ([*mixed* $paths])

返回 routePaths

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

public **beforeMatch** (*mixed* $callback)

Sets a callback that is called if the route is matched. The developer can implement any arbitrary conditions here If the callback returns false the route is treated as not matched

```php
<?php

$router->add(
    "/login",
    [
        "module"     => "admin",
        "controller" => "session",
    ]
)->beforeMatch(
    function ($uri, $route) {
        // Check if the request was made with Ajax
        if ($_SERVER["HTTP_X_REQUESTED_WITH"] === "xmlhttprequest") {
            return false;
        }

        return true;
    }
);

```

public **getBeforeMatch** ()

如果任何，返回 'before match' 回调

public **match** (*mixed* $callback)

允许设置回调来处理该请求直接在路线

```php
<?php

$router->add(
    "/help",
    []
)->match(
    function () {
        return $this->getResponse()->redirect("https://support.google.com/", true);
    }
);

```

public **getMatch** ()

如果任何，返回 'match' 回调

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

public **setHttpMethods** (*mixed* $httpMethods)

设置的 HTTP 方法的约束匹配的路由 （别名的通过）

```php
<?php

$route->setHttpMethods("GET");
$route->setHttpMethods(["GET", "POST"]);

```

public **getHttpMethods** ()

返回的 HTTP 方法的约束路由匹配的

public **setHostname** (*mixed* $hostname)

设置主机名限制到route

```php
<?php

$route->setHostname("localhost");

```

public **getHostname** ()

如果任何，返回主机名限制

public **setGroup** ([Phalcon\Mvc\Router\GroupInterface](Phalcon_Mvc_Router_GroupInterface) $group)

设置与路由关联的组

public **getGroup** ()

返回与路由关联的组

public **convert** (*mixed* $name, *mixed* $converter)

添加一个转换器来为某些参数执行额外的转换

public **getConverters** ()

返回路由器转换器

public static **reset** ()

重置内部路由 id 生成器