---
layout: article
language: 'el-gr'
version: '4.0'
title: 'Phalcon\Cache\Backend\Factory'
---
# Class **Phalcon\Cache\Backend\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/factory.zep)

Loads Backend Cache Adapter class using 'adapter' option, if frontend will be provided as array it will call Frontend Cache Factory

```php
<?php

use Phalcon\Cache\Backend\Factory;
use Phalcon\Cache\Frontend\Data;

$options = [
    "prefix"   => "app-data",
    "frontend" => new Data(),
    "adapter"  => "apc",
];
$backendCache = Factory::load($options);

```

## Methods

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config)

...