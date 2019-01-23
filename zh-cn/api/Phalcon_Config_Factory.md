---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Config\Factory'
---
# Class **Phalcon\Config\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/config/factory.zep)

使用 adapter 选项加载配置适配器类，如果没有扩展提供，它将被添加到 文件的路径

```php
<?php

use Phalcon\Config\Factory;

$options = [
    "filePath" => "path/config",
    "adapter"  => "php",
];
$config = Factory::load($options);

```

## 方法

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config)

...