---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon \ Db \ Adaptor \ Pdo \ Factory'
---
# Class **Phalcon\Db\Adapter\Pdo\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/adapter/pdo/factory.zep)

Muat kelas Adaptor PDO menggunakan opsi 'adaptor'

```php
<?php

gunakan Phalcon\Db\Adaptor\Pdo\Pabrik;

$options = [
    "host"     => "host area",
    "dbname"   => "blog",
    "port"     => 3306,
    "username" => "sigma",
    "katasandi" => "rahasia",
    "adaptor"  => "mysql",
];
$db = Factory::load($options);

```

## Metode

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config) inherited from [Phalcon\Factory](Phalcon_Factory)

...