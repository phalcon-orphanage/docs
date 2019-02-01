---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Logger\Factory'
---
# Class **Phalcon\Logger\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/factory.zep)

Mengisi kelas Adapter Logger menggunakan opsi 'adaptor'

```php
<?php

use Phalcon\Logger\Factory;

$options = [
    "name"    => "log.txt",
    "adapter" => "file",
];
$logger = Factory::load($options);

```

## Metode

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static ** loadClass ** (* mixed * $namespace, * mixed * $config)

...