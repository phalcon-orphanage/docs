# Class **Phalcon\\Session\\Factory**

*extends* abstract class [Phalcon\Factory](/[[language]]/[[version]]/api/Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](/[[language]]/[[version]]/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/session/factory.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Loads Session Adapter class using 'adapter' option

```php
<?php

use Phalcon\Session\Factory;

$options = [
    "uniqueId"   => "my-private-app",
    "host"       => "127.0.0.1",
    "port"       => 11211,
    "persistent" => true,
    "lifetime"   => 3600,
    "prefix"     => "my_",
    "adapter"    => "memcache",
];
$session = Factory::load($options);

```


## Methods
public static  **load** ([Phalcon\Config](/[[language]]/[[version]]/api/Phalcon_Config) | *array* $config)





protected static  **loadClass** (*mixed* $namespace, *mixed* $config) inherited from [Phalcon\Factory](/[[language]]/[[version]]/api/Phalcon_Factory)

...


