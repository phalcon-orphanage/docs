# Sınıf **Phalcon\\Önbellek\\Arkayüz\\Bellek**

*extends* abstract class [Phalcon\Factory](/en/3.2/api/Phalcon_Factory)

*Uygulamalar* [Phalcon\Fabrika Arayüzü](/en/3.2/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backend/factory.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Loads Backend Cache Adapter class using 'adapter' option, if frontend will be provided as array it will call Frontend Cache Factory

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

## Methods

public static **load** ([Phalcon\Config](/en/3.2/api/Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config)

...