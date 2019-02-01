---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Cli\Router'
---
# Class **Phalcon\Cli\Router**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/router.zep)

Phalcon\Cli\Router is the standard framework router. 路由是以命令行参数的过程和将它分解为参数，以确定哪些模块、 任务和行动这一任务应接收该请求

```php
<?php

$router = new \Phalcon\Cli\Router();

$router->handle(
    [
        "module" => "main",
        "task"   => "videos",
        "action" => "process",
    ]
);

echo $router->getTaskName();

```

## 方法

public **__construct** ([*mixed* $defaultRoutes])

Phalcon\Cli\Router constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

设置依赖注入器

public **getDI** ()

返回内部依赖注入器

public **setDefaultModule** (*mixed* $moduleName)

设置默认模块的名称

public **setDefaultTask** (*mixed* $taskName)

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

public **handle** ([*array* $arguments])

处理路由收到命令行参数的信息

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **add** (*string* $pattern, [*string/array* $paths])

将路由添加到路由器

```php
<?php

$router->add("/about", "About::main");

```

public **getModuleName** ()

返回处理模块名称

public **getTaskName** ()

返回处理任务名称

public **getActionName** ()

返回处理操作名称

public *array* **getParams** ()

返回处理额外的参数

public **getMatchedRoute** ()

返回匹配处理的 URI 的路线

public *array* **getMatches** ()

返回的子表达式匹配的正则表达式

public **wasMatched** ()

检查是否路由器匹配任何已定义的路由

public **getRoutes** ()

返回所有定义在路由器中的路由

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **getRouteById** (*int* $id)

按其 id 返回路由对象

public **getRouteByName** (*mixed* $name)

按其名称返回路由对象