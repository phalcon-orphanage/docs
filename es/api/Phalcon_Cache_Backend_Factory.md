# Clase **Phalcon\\Cache\\Backend\\Factory**

*extende* de la clase abstracta [Phalcon\Factory](/en/3.2/api/Phalcon_Factory)

*implementa* [Phalcon\FactoryInterface](/en/3.2/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backend/factory.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Carga la clase del Adaptador de almacenamiento en caché de backend usando la opción 'adapter', si el frontend es abastecido como matriz se llamara Frontend Cache Factory

```php
<?php

use Phalcon\Cache\Backend\Factory;
use Phalcon\Cache\Frontend\Data;

$options = [
    "prefix"   => "app-data",
    "frontend" => new Data(),
    "adapter"  => "apc",
];
$backendCache = Factory::load($options);

```

## Métodos

public static **load** ([Phalcon\Config](/en/3.2/api/Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config)

...