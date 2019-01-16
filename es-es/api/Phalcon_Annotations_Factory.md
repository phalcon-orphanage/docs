---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Annotations\Factory'
---
# Class **Phalcon\Annotations\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/annotations/factory.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Clase de adaptador de anotaciones de cargas usando la opción 'adapter'

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

## Métodos

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config) inherited from [Phalcon\Factory](Phalcon_Factory)

...