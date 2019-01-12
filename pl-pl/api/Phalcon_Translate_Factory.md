---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Translate\Factory'
---
# Class **Phalcon\Translate\Factory**

*extends* abstract class [Phalcon\Factory](/4.0/en/api/Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](/4.0/en/api/Phalcon_FactoryInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/translate/factory.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Loads Translate Adapter class using 'adapter' option

```php
<?php

use Phalcon\Translate\Factory;

$options = [
    "locale"        => "de_DE.UTF-8",
    "defaultDomain" => "translations",
    "directory"     => "/path/to/application/locales",
    "category"      => LC_MESSAGES,
    "adapter"       => "gettext",
];
$translate = Factory::load($options);

```

## Metody

public static **load** ([Phalcon\Config](/4.0/en/api/Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config) inherited from [Phalcon\Factory](/4.0/en/api/Phalcon_Factory)

...