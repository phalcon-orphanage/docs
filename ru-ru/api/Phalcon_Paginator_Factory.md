---
layout: article
language: 'ru-ru'
version: '4.0'
title: 'Phalcon\Paginator\Factory'
---
# Class **Phalcon\Paginator\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/paginator/factory.zep)

Loads Paginator Adapter class using 'adapter' option

```php
<?php

use Phalcon\Paginator\Factory;

/**
 * The `modelsManager` is automatically created when you instantiate your DI
 * container using the `FactoryDefault` class. It returns a 
 * [Phalcon\Mvc\Model\Manager](Phalcon_Mvc_Model_Manager) object
 */

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

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config) inherited from [Phalcon\Factory](Phalcon_Factory)

...