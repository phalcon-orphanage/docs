---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Mvc\Router\Group'
---
# Class **Phalcon\Mvc\Router\Group**

*implements* [Phalcon\Mvc\Router\GroupInterface](Phalcon_Mvc_Router_GroupInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/router/group.zep)

创建路由组具有共同属性的帮助器类

```php
<?php

$router = new \Phalcon\Mvc\Router();

//Create a group with a common module and controller
$blog = new Group(
    [
        "module"     => "blog",
        "controller" => "index",
    ]
);

//All the routes start with /blog
$blog->setPrefix("/blog");

//Add a route to the group
$blog->add(
    "/save",
    [
        "action" => "save",
    ]
);

//Add another route to the group
$blog->add(
    "/edit/{id}",
    [
        "action" => "edit",
    ]
);

//This route maps to a controller different than the default
$blog->add(
    "/blog",
    [
        "controller" => "about",
        "action"     => "index",
    ]
);

//Add the group to the router
$router->mount($blog);

```

## 方法

public **__construct** ([*mixed* $paths])

Phalcon\Mvc\Router\Group constructor

public **setHostname** (*mixed* $hostname)

设置在组中的所有路由的主机名限制

public **getHostname** ()

返回主机名限制

public **setPrefix** (*mixed* $prefix)

在此组中设置公共 uri 前缀的所有路由

public **getPrefix** ()

返回的常见前缀的所有路由

public **beforeMatch** (*mixed* $beforeMatch)

Sets a callback that is called if the route is matched. The developer can implement any arbitrary conditions here If the callback returns false the route is treated as not matched

public **getBeforeMatch** ()

如果任何，返回 'before match' 回调

public **setPaths** (*mixed* $paths)

共同为设置路径的所有路由组中

public **getPaths** ()

返回为此组定义的常见路径

public **getRoutes** ()

返回添加到组中的路由

public **add** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods])

将路由添加到路由器的任何 HTTP 方法

```php
<?php

$router->add("/about", "About::index");

```

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addGet** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is GET

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addPost** (*string* $pattern, [*string/array* $paths])

将路由添加到路由器只匹配如果 HTTP 方法是 POST

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addPut** (*string* $pattern, [*string/array* $paths])

将路由添加到路由器只匹配如果 HTTP 方法是 PUT

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addPatch** (*string* $pattern, [*string/array* $paths])

添加到路由器，如果 HTTP 方法是只匹配路由修补

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addDelete** (*string* $pattern, [*string/array* $paths])

将路由添加到路由器只匹配如果 HTTP 方法是 DELETE

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addOptions** (*string* $pattern, [*string/array* $paths])

将路由添加到路由器只匹配如果 HTTP 方法是OPTIONS

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addHead** (*string* $pattern, [*string/array* $paths])

将路由添加到路由器只匹配如果 HTTP 方法是HEAD

public **clear** ()

删除所有预定义的路由

protected **_addRoute** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods])

添加路由应用的常见属性