---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Session\Factory'
---
# Class **Phalcon\Session\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/session/factory.zep)

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

## メソッド

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config) inherited from [Phalcon\Factory](Phalcon_Factory)

...