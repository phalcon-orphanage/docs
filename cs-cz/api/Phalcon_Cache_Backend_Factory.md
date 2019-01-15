---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Cache\Backend\Factory'
---
# Class **Phalcon\Cache\Backend\Factory**

*extends* abstract class [Phalcon\Factory](/4.0/en/api/Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](/4.0/en/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/backend/factory.zep" class="btn btn-default btn-sm">Source on GitHub</a>

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

public static **load** ([Phalcon\Config](/4.0/en/api/Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config)

...