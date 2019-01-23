---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Mvc\Router'
---
# Class **Phalcon\Mvc\Router**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\RouterInterface](Phalcon_Mvc_RouterInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/router.zep)

Phalcon\Mvc\Router is the standard framework router. Routing is the process of taking a URI endpoint (that part of the URI which comes after the base URL) and decomposing it into parameters to determine which module, controller, and action of that controller should receive the request

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->add(
    "/documentation/{chapter}/{name}\.{type:[a-z]+}",
    [
        "controller" => "documentation",
        "action"     => "show",
    ]
);

$router->handle();

echo $router->getControllerName();

```

## 常量

*integer* **URI_SOURCE_GET_URL**

*integer* **URI_SOURCE_SERVER_REQUEST_URI**

*integer* **POSITION_FIRST**

*integer* **POSITION_LAST**

## 方法

public **__construct** ([*mixed* $defaultRoutes])

Phalcon\Mvc\Router constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

设置依赖注入器

public **getDI** ()

返回内部依赖注入器

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

设置事件管理器

public **getEventsManager** ()

返回内部事件管理器

public **getRewriteUri** ()

Get rewrite info. This info is read from $_GET["_url"]. This returns '/' if the rewrite information cannot be read

public **setUriSource** (*mixed* $uriSource)

Sets the URI source. One of the URI_SOURCE_* constants

```php
<?php

$router->setUriSource(
    Router::URI_SOURCE_SERVER_REQUEST_URI
);

```

public **removeExtraSlashes** (*mixed* $remove)

设置是否在已处理的路由，路由器必须移除多余的斜线

public **setDefaultNamespace** (*mixed* $namespaceName)

设置默认命名空间的名称

public **setDefaultModule** (*mixed* $moduleName)

设置默认模块的名称

public **setDefaultController** (*mixed* $controllerName)

设置默认控制器名称

public **setDefaultAction** (*mixed* $actionName)

设置默认操作名称

public **setDefaults** (*array* $defaults)

Sets an array of default paths. If a route is missing a path the router will use the defined here This method must not be used to set a 404 route

```php
<?php

$router->setDefaults(
    [
        "module" => "common",
        "action" => "index",
    ]
);

```

public **getDefaults** ()

返回一个数组的默认参数

public **handle** ([*mixed* $uri])

Handles routing information received from the rewrite engine

```php
<?php

// Read the info from the rewrite engine
$router->handle();

// Manually passing an URL
$router->handle("/posts/edit/1");

```

public **add** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods], [*mixed* $position])

将路由添加到路由器没有任何 HTTP 约束

```php
<?php

use Phalcon\Mvc\Router;

$router->add("/about", "About::index");
$router->add("/about", "About::index", ["GET", "POST"]);
$router->add("/about", "About::index", ["GET", "POST"], Router::POSITION_FIRST);

```

public **addGet** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Adds a route to the router that only match if the HTTP method is GET

public **addPost** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

将路由添加到路由器只匹配如果 HTTP 方法是 POST

public **addPut** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

将路由添加到路由器只匹配如果 HTTP 方法是 PUT

public **addPatch** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

添加到路由器，如果 HTTP 方法是只匹配路由修补

public **addDelete** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

将路由添加到路由器只匹配如果 HTTP 方法是 DELETE

public **addOptions** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

将路由添加到路由器只匹配如果 HTTP 方法是OPTIONS

public **addHead** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

将路由添加到路由器只匹配如果 HTTP 方法是HEAD

public **addPurge** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

将路由添加到路由器只匹配如果 HTTP 方法是PURGE （Squid 和Varnish 支持）

public **addTrace** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

将路由添加到路由器只匹配如果 HTTP 方法是TRACE

public **addConnect** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

将路由添加到路由器只匹配如果 HTTP 方法是 CONNECT

public **mount** ([Phalcon\Mvc\Router\GroupInterface](Phalcon_Mvc_Router_GroupInterface) $group)

安装路由器中的路由组

public **notFound** (*mixed* $paths)

设置路径时没有已定义的路由匹配返回一组

public **clear** ()

删除所有预定义的路由

public **getNamespaceName** ()

返回已处理命名空间名称

public **getModuleName** ()

返回已处理的模块名称

public **getControllerName** ()

返回已处理的控制器名称

public **getActionName** ()

返回相应的加工的操作名称

public **getParams** ()

返回的加工的参数

public **getMatchedRoute** ()

返回匹配处理的 URI 的路线

public **getMatches** ()

返回的子表达式匹配的正则表达式

public **wasMatched** ()

检查是否路由器匹配任何已定义的路由

public **getRoutes** ()

返回所有定义在路由器中的路由

public **getRouteById** (*mixed* $id)

按其 id 返回路由对象

public **getRouteByName** (*mixed* $name)

按其名称返回路由对象

public **isExactControllerName** ()

返回是否不应该出错的控制器的名称