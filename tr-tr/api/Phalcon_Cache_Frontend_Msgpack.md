---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Msgpack'
---
# Class **Phalcon\Cache\Frontend\Msgpack**

*extends* class [Phalcon\Cache\Frontend\Data](Phalcon_Cache_Frontend_Data)

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/msgpack.zep)

Msgpack uzantısını kullanarak yerel PHP verilerini seri haline getirilmiş biçimde önbelleğe almaya izin verir.

```php
<?php

use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Frontend\Msgpack;

// Cache the files for 2 days using Msgpack frontend
$frontCache = new Msgpack(
    [
        "lifetime" => 172800,
    ]
);

// Create the component that will cache "Msgpack" to a "File" backend
// Set the cache file directory - important to keep the "/" at the end of
// of the value for the folder
$cache = new File(
    $frontCache,
    [
        "cacheDir" => "../app/cache/",
    ]
);

$cacheKey = "robots_order_id.cache";

// Try to get cached records
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robots is null due to cache expiration or data do not exist
    // Make the database call and populate the variable
    $robots = Robots::find(
        [
            "order" => "id",
        ]
    );

    // Store it in the cache
    $cache->save($cacheKey, $robots);
}

// Use $robots
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

```

## Metodlar

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Msgpack constructor

public **getLifetime** ()

Returns the cache lifetime

public **isBuffering** ()

Check whether if frontend is buffering output

public **start** ()

Starts output frontend. Actually, does nothing

herkese açık **İçeriğe Eriş** ()

Çıktı önbelleğine alınan içeriği getirir

public **stop** ()

Çıktının frontend'ini durdurur

public **beforeStore** (*mixed* $data)

Verileri depolamadan önce seri hale getirir

public **afterRetrieve** (*mixed* $data)

Unserializes verisini sonradan geri alır