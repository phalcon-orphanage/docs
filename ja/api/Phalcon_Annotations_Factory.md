# Class **Phalcon\\Annotations\\Factory**

*拡張*: [Phalcon\Factory](/[[language]]/[[version]]/api/Phalcon_Factory)抽象クラス

*実装*: [Phalcon\FactoryInterface](/[[language]]/[[version]]/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/factory.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

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

public static **load** ([Phalcon\Config](/[[language]]/[[version]]/api/Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config) inherited from [Phalcon\Factory](/[[language]]/[[version]]/api/Phalcon_Factory)

...