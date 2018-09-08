# Class **Phalcon\\Image\\Factory**

*extends* abstract class [Phalcon\Factory](/[[language]]/[[version]]/api/Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](/[[language]]/[[version]]/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/image/factory.zep" class="btn btn-default btn-sm">Source on GitHub</a>

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
public static  **load** ([Phalcon\Config](/[[language]]/[[version]]/api/Phalcon_Config) | *array* $config)





protected static  **loadClass** (*mixed* $namespace, *mixed* $config)

...


