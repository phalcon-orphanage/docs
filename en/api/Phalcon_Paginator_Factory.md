# Class **Phalcon\\Paginator\\Factory**

*extends* abstract class [Phalcon\Factory](/[[language]]/[[version]]/api/Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](/[[language]]/[[version]]/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/paginator/factory.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Loads Paginator Adapter class using 'adapter' option

```php
<?php

use Phalcon\Paginator\Factory;
$builder = $this->modelsManager->createBuilder()
                ->columns("id, name")
                ->from("Robots")
                ->orderBy("name");

$options = [
    "builder" => $builder,
    "limit"   => 20,
    "page"    => 1,
    "adapter" => "queryBuilder",
];
$paginator = Factory::load($options);

```


## Methods
public static  **load** ([Phalcon\Config](/[[language]]/[[version]]/api/Phalcon_Config) | *array* $config)





protected static  **loadClass** (*mixed* $namespace, *mixed* $config) inherited from [Phalcon\Factory](/[[language]]/[[version]]/api/Phalcon_Factory)

...


