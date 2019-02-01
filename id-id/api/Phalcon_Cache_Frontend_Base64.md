---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Data'
---
# Class **Phalcon\Cache\Frontend\Base64**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/base64.zep)

Memungkinkan untuk meng-cache data yang mengkonversi / deconverting mereka ke base64.

Adaptor ini menggunakan fungsi base64_encode / base64_decode PHP

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

## Metode

umum **__membangun** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Base64 constructor

publik ** getLifetime ** ()

Mengembalikan masa pakai cache

public ** isBuffering ** ()

Periksa apakah frontend adalah buffering output

publik ** mulai ** ()

Starts output frontend. Actually, does nothing in this adapter

public *string * **getContent** ()

Mengembalikan hasil konten dalam cache

publik ** berhenti ** ()

Menghentikan output frontend

public ** beforeStore ** ( * mixed * $data)

Serializes data sebelum menyimpannya

public ** afterRetrieve ** ( * mixed * $data)

Unserializes data setelah pengambilan