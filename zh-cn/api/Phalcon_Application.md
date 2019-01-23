---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Application'
---
# Abstract class **Phalcon\Application**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/application.zep)

Base class for Phalcon\Cli\Console and Phalcon\Mvc\Application.

## 方法

public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Phalcon\Application Constructor

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

设置事件管理器

public **getEventsManager** ()

返回内部事件管理器

public **registerModules** (*array* $modules, [*mixed* $merge])

注册模块目前在应用程序中的数组

```php
<?php

$this->registerModules(
    [
        "frontend" => [
            "className" => "Multiple\Frontend\Module",
            "path"      => "../apps/frontend/Module.php",
        ],
        "backend" => [
            "className" => "Multiple\Backend\Module",
            "path"      => "../apps/backend/Module.php",
        ],
    ]
);

```

public **getModules** ()

返回在应用程序中注册模块

public **getModule** (*mixed* $name)

获取注册的应用程序通过模块名称的模块定义

public **setDefaultModule** (*mixed* $defaultModule)

设置要用于如果路由器不返回有效的模块的模块名称

public **getDefaultModule** ()

返回默认模块名称

abstract public **handle** ()

处理请求

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

设置依赖注入器

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

返回内部依赖注入器

public **__get** (*string* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get