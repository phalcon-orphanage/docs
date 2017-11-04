# Class **Phalcon\\Paginator\\Factory**

*extiende* abstract class [Phalcon\Factory](/en/3.2/api/Phalcon_Factory)

*implementa* [Phalcon\FactoryInterface](/en/3.2/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/paginator/factory.zep" class="btn btn-default btn-sm">Codigo fuente en GitHub</a>

Carga un adaptador de Paginator utilizando la opción 'adapter'

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

## Métodos

public static **load** ([Phalcon\Config](/en/3.2/api/Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config) heredado desde [Phalcon\Factory](/en/3.2/api/Phalcon_Factory)

...