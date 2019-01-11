---
layout: default
language: 'en'
version: '4.0'
title: 'Phalcon\Image\Factory'
---
# Class **Phalcon\Image\Factory**

*extends* abstract class [Phalcon\Factory](/3.4/en/api/Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](/3.4/en/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/image/factory.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Loads Image Adapter class using 'adapter' option

```php
<?php

use Phalcon\Image\Factory;

$options = [
    "width"   => 200,
    "height"  => 200,
    "file"    => "upload/test.jpg",
    "adapter" => "imagick",
];
$image = Factory::load($options);

```

## Methods

public static **load** ([Phalcon\Config](/3.4/en/api/Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config)

...