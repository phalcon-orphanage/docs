---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Db\Adapter\Pdo\Factory'
---
# Class **Phalcon\Db\Adapter\Pdo\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/db/adapter/pdo/factory.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Loads PDO Adapter class using 'adapter' option

```php
<?php

use Phalcon\Db\Adapter\Pdo\Factory;

$options = [
    "host"     => "localhost",
    "dbname"   => "blog",
    "port"     => 3306,
    "username" => "sigma",
    "password" => "secret",
    "adapter"  => "mysql",
];
$db = Factory::load($options);

```


## Methods
public static  **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)





protected static  **loadClass** (*mixed* $namespace, *mixed* $config) inherited from [Phalcon\Factory](Phalcon_Factory)

...


