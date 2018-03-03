# Sınıf **Phalcon\\Önbellek\\Başlangıç Aşaması\\Msg paketi**

*uzanır* sınıf [Phalcon\Önbellek\Başlangıç aşaması\Veri](/en/3.2/api/Phalcon_Cache_Frontend_Data)

*Uygulamalar* [Phalcon\Önbellek\Ön uç ara yüz](/en/3.2/api/Phalcon_Cache_FrontendInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/frontend/msgpack.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Allows to cache native PHP data in a serialized form using msgpack extension This adapter uses a Msgpack frontend to store the cached content and requires msgpack extension.

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

## Methods

herkese açık **__düzenle** ([*dizi* $Ön uç Seçenekleri])

Phalcon\\Cache\\Frontend\\Msgpack constructor

herkese açık **Ömürboyu al** ()

Returns the cache lifetime

Herkese açık **korumak** ()

Önyüzün arabelleğe çıktı alınmış olup olmadığını kontrol edin

herkese açık **başlat** ()

Başlangıç aşaması çıktıyı başlatır. Aslında, hiçbir şey yapmıyor

herkese açık **İçeriğe Eriş** ()

Çıktı önbelleğe alınan içeriği çevirir

herkese açık **Durdur** ()

Stops output frontend

herkese açık **Eski mağaza** (*karışık* $veri)

Verileri saklamadan önce dizili hale getirir

herkese açık **alındıktan sonra** (*karışık* $veri)

Unserializes data after retrieval