---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon \ Config \ Factory'
---
# Class **Phalcon\Config\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/config/factory.zep)

Beban Config Adapter kelas menggunakan pilihan 'adaptor', jika ekstensi tidak disediakan itu akan ditambahkan ke filePath

```php
<?php

use Phalcon\Config\Factory;

$options = [
    "filePath" => "path/config",
    "adapter"  => "php",
];
$config = Factory::load($options);

```

## Metode

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static ** loadClass ** (* mixed * $namespace, * mixed * $config)

...