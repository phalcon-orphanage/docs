---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Paginator\Factory'
---
# Class **Phalcon\Paginator\Factory**

*extends* abstract class [Phalcon\Factory](/4.0/en/api/Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](/4.0/en/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/paginator/factory.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Carga un adaptador de Paginator utilizando la opción 'adapter'

```php
<?php

use Phalcon\Paginator\Factory;

/**
 * The `modelsManager` is automatically created when you instantiate your DI
 * container using the `FactoryDefault` class. It returns a 
 * [Phalcon\Mvc\Model\Manager](/4.0/en/api/Phalcon_Mvc_Model_Manager) object
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

## Métodos

public static **load** ([Phalcon\Config](/4.0/en/api/Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config) inherited from [Phalcon\Factory](/4.0/en/api/Phalcon_Factory)

...