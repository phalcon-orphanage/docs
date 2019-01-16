---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Image\Factory'
---
# Class **Phalcon\Image\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/image/factory.zep" class="btn btn-default btn-sm">源码在GitHub</a>

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

## 方法

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config)

...