---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Mvc\Router\Annotations'
---
# Class **Phalcon\Mvc\Router\Annotations**

*extends* class [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Mvc\RouterInterface](Phalcon_Mvc_RouterInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/router/annotations.zep)

路由器，，读取的类和资源的路线注释

```php
<?php

use Phalcon\Mvc\Router\Annotations;

$di->setShared(
    "router",
    function() {
        // Use the annotations router
        $router = new Annotations(false);

        // This will do the same as above but only if the handled uri starts with /robots
        $router->addResource("Robots", "/robots");

        return $router;
    }
);

```

## 常量

*integer* **URI_SOURCE_GET_URL**

*integer* **URI_SOURCE_SERVER_REQUEST_URI**

*integer* **POSITION_FIRST**

*integer* **POSITION_LAST**

## 方法

public **addResource** (*mixed* $handler, [*mixed* $prefix])

添加资源到注释处理程序 A 资源是一个类，包含路由的批注

public **addModuleResource** (*mixed* $module, *mixed* $handler, [*mixed* $prefix])

将资源添加到处理程序 A 资源是一个类，包含类位于模块中的路由批注的批注

public **handle** ([*mixed* $uri])

生产中的重写信息的路由参数

public **processControllerAnnotation** (*mixed* $handler, [Phalcon\Annotations\Annotation](Phalcon_Annotations_Annotation) $annotation)

检查控制器块中的注释

public **processActionAnnotation** (*mixed* $module, *mixed* $namespaceName, *mixed* $controller, *mixed* $action, [Phalcon\Annotations\Annotation](Phalcon_Annotations_Annotation) $annotation)

检查中的公共方法的控制器的注释

public **setControllerSuffix** (*mixed* $controllerSuffix)

更改控制器类后缀

public **setActionSuffix** (*mixed* $actionSuffix)

更改操作方法后缀

public **getResources** ()

返回注册的资源

public **__construct** ([*mixed* $defaultRoutes]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Phalcon\Mvc\Router constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

设置依赖注入器

public **getDI** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

返回内部依赖注入器

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

设置事件管理器

public **getEventsManager** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

返回内部事件管理器

public **getRewriteUri** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Get rewrite info. This info is read from $_GET["_url"]. This returns '/' if the rewrite information cannot be read

public **setUriSource** (*mixed* $uriSource) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Sets the URI source. One of the URI_SOURCE_* constants

```php
<?php

$router->setUriSource(
    Router::URI_SOURCE_SERVER_REQUEST_URI
);

```

public **removeExtraSlashes** (*mixed* $remove) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

设置是否在已处理的路由，路由器必须移除多余的斜线

public **setDefaultNamespace** (*mixed* $namespaceName) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

设置默认命名空间的名称

public **setDefaultModule** (*mixed* $moduleName) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

设置默认模块的名称

public **setDefaultController** (*mixed* $controllerName) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

设置默认控制器名称

public **setDefaultAction** (*mixed* $actionName) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

设置默认操作名称

public **setDefaults** (*array* $defaults) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

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

public **getDefaults** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

返回一个数组的默认参数

public **add** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

将路由添加到路由器没有任何 HTTP 约束

```php
<?php

use Phalcon\Mvc\Router;

$router->add("/about", "About::index");
$router->add("/about", "About::index", ["GET", "POST"]);
$router->add("/about", "About::index", ["GET", "POST"], Router::POSITION_FIRST);

```

public **addGet** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is GET

public **addPost** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

将路由添加到路由器只匹配如果 HTTP 方法是 POST

public **addPut** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

将路由添加到路由器只匹配如果 HTTP 方法是 PUT

public **addPatch** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

添加到路由器，如果 HTTP 方法是只匹配路由修补

public **addDelete** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

将路由添加到路由器只匹配如果 HTTP 方法是 DELETE

public **addOptions** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

将路由添加到路由器只匹配如果 HTTP 方法是OPTIONS

public **addHead** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

将路由添加到路由器只匹配如果 HTTP 方法是HEAD

public **addPurge** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

将路由添加到路由器只匹配如果 HTTP 方法是PURGE （Squid 和Varnish 支持）

public **addTrace** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

将路由添加到路由器只匹配如果 HTTP 方法是TRACE

public **addConnect** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

将路由添加到路由器只匹配如果 HTTP 方法是 CONNECT

public **mount** ([Phalcon\Mvc\Router\GroupInterface](Phalcon_Mvc_Router_GroupInterface) $group) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

安装路由器中的路由组

public **notFound** (*mixed* $paths) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

设置路径时没有已定义的路由匹配返回一组

public **clear** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

删除所有预定义的路由

public **getNamespaceName** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

返回已处理命名空间名称

public **getModuleName** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

返回已处理的模块名称

public **getControllerName** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

返回已处理的控制器名称

public **getActionName** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

返回相应的加工的操作名称

public **getParams** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

返回的加工的参数

public **getMatchedRoute** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

返回匹配处理的 URI 的路线

public **getMatches** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

返回的子表达式匹配的正则表达式

public **wasMatched** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

检查是否路由器匹配任何已定义的路由

public **getRoutes** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

返回所有定义在路由器中的路由

public **getRouteById** (*mixed* $id) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

按其 id 返回路由对象

public **getRouteByName** (*mixed* $name) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

按其名称返回路由对象

public **isExactControllerName** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

返回是否不应该出错的控制器的名称