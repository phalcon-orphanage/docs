---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Config\Factory'
---
# Class **Phalcon\Config\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/config/factory.zep)

'adapter' parametresini kullanarak Config Adapter sınıfını yükler. Eğer uzantı belirtilmemişse 'adapter' parametresi filePath değişkenine eklenir

```php
<?php

use Phalcon\Config\Factory;

$options = [
    "filePath" => "path/config",
    "adapter"  => "php",
];
$config = Factory::load($options);

```

## Metodlar

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static **loadClass** (*mixed* $namespace, *mixed* $config)

...