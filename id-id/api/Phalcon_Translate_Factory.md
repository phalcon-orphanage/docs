---
layout: default
language: 'id-id'
version: '4.0'
title: 'Phalcon\Translate\Factory'
---
# Class **Phalcon\Translate\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/translate/factory.zep)

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

## Methods

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config) inherited from [Phalcon\Factory](Phalcon_Factory)

...