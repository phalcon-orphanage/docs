---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Session\Factory'
---
# Class **Phalcon\Session\Factory**

*extends* abstract class [Phalcon\Factory](/4.0/en/api/Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](/4.0/en/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/session/factory.zep" class="btn btn-default btn-sm">源码在GitHub</a>

Loads Session Adapter class using 'adapter' option

```php
<?php

use Phalcon\Session\Factory;

$options = [
    "uniqueId"   => "my-private-app",
    "host"       => "127.0.0.1",
    "port"       => 11211,
    "persistent" => true,
    "lifetime"   => 3600,
    "prefix"     => "my_",
    "adapter"    => "memcache",
];
$session = Factory::load($options);

```

## 方法

public static **load** ([Phalcon\Config](/4.0/en/api/Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config) inherited from [Phalcon\Factory](/4.0/en/api/Phalcon_Factory)

...