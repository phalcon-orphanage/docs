---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Factory'
---
# Class **Phalcon\Cache\Frontend\Factory**

*extends* abstract class [Phalcon\Factory](/4.0/en/api/Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](/4.0/en/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/frontend/factory.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Loads Frontend Cache Adapter class using 'adapter' option

```php
<?php

use Phalcon\Cache\Frontend\Factory;

$options = [
    "lifetime" => 172800,
    "adapter"  => "data",
];
$frontendCache = Factory::load($options);

```

## Methods

public static **load** ([Phalcon\Config](/4.0/en/api/Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config)

...