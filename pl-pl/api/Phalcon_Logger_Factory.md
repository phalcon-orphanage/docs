---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Logger\Factory'
---
# Class **Phalcon\Logger\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/factory.zep)

Loads Logger Adapter class using 'adapter' option

```php
<?php

use Phalcon\Logger\Factory;

$options = [
    "name"    => "log.txt",
    "adapter" => "file",
];
$logger = Factory::load($options);

```

## Metody

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config)

...