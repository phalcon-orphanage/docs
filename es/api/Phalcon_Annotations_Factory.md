# Clase **Phalcon\\Annotations\\Factory**

*extends* abstract class [Phalcon\Factory](/[[language]]/[[version]]/api/Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](/[[language]]/[[version]]/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/factory.zep" class="btn btn-default btn-sm">Codigo fuente en GitHub</a>

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

public static **load** ([Phalcon\Config](/[[language]]/[[version]]/api/Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config) inherited from [Phalcon\Factory](/[[language]]/[[version]]/api/Phalcon_Factory)

...