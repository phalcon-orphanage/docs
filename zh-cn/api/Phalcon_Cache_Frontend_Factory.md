---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Factory'
---
# Class **Phalcon\Cache\Frontend\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/factory.zep)

使用 适配器 选项，加载缓存适配器类

```php
<?php

use Phalcon\Cache\Frontend\Factory;

$options = [
    "lifetime" => 172800,
    "adapter"  => "data",
];
$frontendCache = Factory::load($options);

```

## 方法

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config)

...