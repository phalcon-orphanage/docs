---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cache\Belakang\Pabrik'
---
# Class **Phalcon\Cache\Backend\Factory**

*extends* abstract class [Phalcon\Factory](Phalcon_Factory)

*implements* [Phalcon\FactoryInterface](Phalcon_FactoryInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/factory.zep)

Load backend Cache Adapter class menggunakan opsi 'adapter', jika frontend akan disediakan sebagai array maka akan memanggil Frontend Cache Factory

```php
<? php menggunakan Phalcon\Cache\Backend\Factory; menggunakan Phalcon\Cache\Frontend\Data;$options = ["awalan" = > "app-data", "frontend" = > Data() baru, "adaptor" = > "apc",];$backendCache = Factory::load($options);

```

## Metode

public static **load** ([Phalcon\Config](Phalcon_Config) | *array* $config)

protected static ** loadClass ** (* mixed * $namespace, * mixed * $config)

...