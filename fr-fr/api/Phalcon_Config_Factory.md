---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Config\Factory'
---
# Class **Phalcon\Config\Factory**

*extends* abstract class [Phalcon\Factory](/4.0/en/api/Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](/4.0/en/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/config/factory.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Loads Config Adapter class using 'adapter' option, if no extension is provided it will be added to filePath

```php
<?php

use Phalcon\Config\Factory;

$options = [
    "filePath" => "path/config",
    "adapter"  => "php",
];
$config = Factory::load($options);

```

## Methods

public static **load** ([Phalcon\Config](/4.0/en/api/Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config)

...