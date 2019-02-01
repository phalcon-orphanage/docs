---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cache\Antarmuka\Pabrik'
---
# Class **Phalcon\Cache\Frontend\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/factory.zep)

Mengisi kelas Adaptor Sudut Pengaman dengan menggunakan opsi 'adaptor'

```php
<?php

use Phalcon\Cache\Frontend\Factory;

$options = [
    "lifetime" => 172800,
    "adapter"  => "data",
];
$frontendCache = Factory::load($options);

```

## Metode

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static ** loadClass ** (* mixed * $namespace, * mixed * $config)

...