* * *

layout: default language: 'en' version: '3.4' title: 'Phalcon\Annotations\Factory'

* * *

# Class **Phalcon\Annotations\Factory**

*extends* abstract class [Phalcon\Factory](/3.4/en/api/Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](/3.4/en/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/annotations/factory.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

'adaper'オプションを使用してAnnotations Adapterクラスをロードします。

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

## メソッド

public static **load** ([Phalcon\Config](/3.4/en/api/Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config) inherited from [Phalcon\Factory](/3.4/en/api/Phalcon_Factory)

...