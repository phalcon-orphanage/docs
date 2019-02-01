---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Anotasi\Pabrik'
---
# Class **Phalcon\Annotations\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/factory.zep)

Beban anotasi Adapter kelas menggunakan opsi 'adapter'

```php
<?php

gunakan Phalcon\Anotasi\Factory;

$options = [
     "awalan" => "anotasi",
     "seumur hidup" => "3600",
     "adaptor" => "apc",
];
$annotations = Factory::load($options);

```

## Metode

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config) inherited from [Phalcon\Factory](Phalcon_Factory)

...