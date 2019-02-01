---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Annotations\Faktör'
---
# Class **Phalcon\Annotations\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/factory.zep)

'adapter' tercihini kullanarak Annotations Adapter sınıfını yükler

```php
<?php

use Phalcon\Annotations\Factory;

$options = [
    "prefix"   => "annotations",
    "lifetime" => "3600",
    "adapter"  => "apc",
];
$annotations = Factory::load($options);

```

## Metodlar

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config) inherited from [Phalcon\Factory](Phalcon_Factory)

...