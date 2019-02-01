---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Cache\Backend\Factory'
---
# Class **Phalcon\Cache\Backend\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/factory.zep)

Backend Cache Adapter sınıf'ı 'adapter' seçeneğiyle yüklenir, eğer ön yüz ok olarak sağlanırsa bu 'Fronted Cache Factory' olarak adlandırılır

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

## Metodlar

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config)

...