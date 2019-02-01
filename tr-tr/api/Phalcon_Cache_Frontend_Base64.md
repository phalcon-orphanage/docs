---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Base64'
---
# Class **Phalcon\Cache\Frontend\Base64**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/base64.zep)

Önbellek verisinin onları base64'e dönüştürmesini/geri dönüştürmesini sağlar.

Bu adaptör, base64_encode / base64_decode PHP'nin işlevlerini kullanmaktadır

```php
<?php

<?php

// Cache the files for 2 days using a Base64 frontend
$frontCache = new \Phalcon\Cache\Frontend\Base64(
    [
        "lifetime" => 172800,
    ]
);

//Create a MongoDB cache
$cache = new \Phalcon\Cache\Backend\Mongo(
    $frontCache,
    [
        "server"     => "mongodb://localhost",
        "db"         => "caches",
        "collection" => "images",
    ]
);

$cacheKey = "some-image.jpg.cache";

// Try to get cached image
$image = $cache->get($cacheKey);

if ($image === null) {
    // Store the image in the cache
    $cache->save(
        $cacheKey,
        file_get_contents("tmp-dir/some-image.jpg")
    );
}

header("Content-Type: image/jpeg");

echo $image;

```

## Metodlar

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Base64 constructor

public **getLifetime** ()

Returns the cache lifetime

public **isBuffering** ()

Check whether if frontend is buffering output

public **start** ()

Starts output frontend. Actually, does nothing in this adapter

public *string* **getContent** ()

Çıktı önbelleğine alınan içeriği getirir

public **stop** ()

Çıktının frontend'ini durdurur

public **beforeStore** (*mixed* $data)

Verileri depolamadan önce seri hale getirir

public **afterRetrieve** (*mixed* $data)

Unserializes verisini sonradan geri alır