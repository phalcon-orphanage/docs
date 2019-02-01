---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Loader'
---
# Class **Phalcon\Loader**

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/loader.zep)

此组件帮助加载自动基于一些约定你项目类

```php
<?php

use Phalcon\Loader;

// Creates the autoloader
$loader = new Loader();

// Register some namespaces
$loader->registerNamespaces(
    [
        "Example\Base"    => "vendor/example/base/",
        "Example\Adapter" => "vendor/example/adapter/",
        "Example"          => "vendor/example/",
    ]
);

// Register autoloader
$loader->register();

// Requiring this class will automatically include file vendor/example/adapter/Some.php
$adapter = new \Example\Adapter\Some();

```

## 方法

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

设置事件管理器

public **getEventsManager** ()

返回内部事件管理器

public **setExtensions** (*array* $extensions)

设置数组加载程序必须尝试在每次尝试找到该文件的文件扩展名

public **getExtensions** ()

返回加载器中注册的文件扩展名

public **registerNamespaces** (*array* $namespaces, [*mixed* $merge])

注册命名空间和其相关的目录

public **setFileCheckingCallback** (*mixed* $callback = null): [Phalcon\Loader](Phalcon_Loader)

Sets the file check callback.

```php
<?php

// Default behavior.
$loader->setFileCheckingCallback("is_file");

// Faster than `is_file()`, but implies some issues if
// the file is removed from the filesystem.
$loader->setFileCheckingCallback("stream_resolve_include_path");

// Do not check file existence.
$loader->setFileCheckingCallback(null);
```

A [Phalcon\Loader\Exception](Phalcon_Loader_Exception) is thrown if the $callback parameter is not a `callable` or `null`;

protected **prepareNamespace** (*array* $namespace)

...

public **getNamespaces** ()

返回当前已注册的自动加载器的命名空间

public **registerDirs** (*array* $directories, [*mixed* $merge])

注册可以在其中找到"没有发现"类的目录

public **getDirs** ()

返回当前已注册的自动加载的目录

public **registerFiles** (*array* $files, [*mixed* $merge])

Registers files that are "non-classes" hence need a "require". This is very useful for including files that only have functions

public **getFiles** ()

返回当前已注册的自动加载的文件

public **registerClasses** (*array* $classes, [*mixed* $merge])

注册类和它们的位置

public **getClasses** ()

返回当前已注册的自动加载的类映射

public **register** ([*mixed* $prepend])

注册自动加载方法

public **unregister** ()

注销自动加载方法

public **loadFiles** ()

如果文件存在，然后将该文件添加做虚拟的检查要求

public **autoLoad** (*mixed* $className)

支持自动装载注册类

public **getFoundPath** ()

当一个类被发现获取的路径

public **getCheckedPath** ()

获取路径检查加载程序的路径