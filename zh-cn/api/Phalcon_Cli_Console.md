---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Cli\Console'
---
# Class **Phalcon\Cli\Console**

*extends* abstract class [Phalcon\Application](Phalcon_Application)

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/console.zep)

此组件允许创建使用Phalcon的 CLI 应用程序

## 方法

public **addModules** (*array* $modules)

合并模块与现有的

```php
<?php

$application->addModules(
    [
        "admin" => [
            "className" => "Multiple\Admin\Module",
            "path"      => "../apps/admin/Module.php",
        ],
    ]
);

```

public **handle** ([*array* $arguments])

处理整个命令行任务

public **setArgument** ([*array* $arguments], [*mixed* $str], [*mixed* $shift])

将特定的参数设置

public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector]) inherited from [Phalcon\Application](Phalcon_Application)

Phalcon\Application

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Application](Phalcon_Application)

设置事件管理器

public **getEventsManager** () inherited from [Phalcon\Application](Phalcon_Application)

返回内部事件管理器

public **registerModules** (*array* $modules, [*mixed* $merge]) inherited from [Phalcon\Application](Phalcon_Application)

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

public **getModules** () inherited from [Phalcon\Application](Phalcon_Application)

返回在应用程序中注册模块

public **getModule** (*mixed* $name) inherited from [Phalcon\Application](Phalcon_Application)

获取注册的应用程序通过模块名称的模块定义

public **setDefaultModule** (*mixed* $defaultModule) inherited from [Phalcon\Application](Phalcon_Application)

设置要用于如果路由器不返回有效的模块的模块名称

public **getDefaultModule** () inherited from [Phalcon\Application](Phalcon_Application)

返回默认模块名称

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

设置依赖注入器

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

返回内部依赖注入器

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get