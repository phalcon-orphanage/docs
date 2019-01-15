* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Cache\Frontend\Base64'

* * *

# Class **Phalcon\Cache\Frontend\Base64**

*implements* [Phalcon\Cache\FrontendInterface](/4.0/en/api/Phalcon_Cache_FrontendInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/frontend/base64.zep" class="btn btn-default btn-sm">源码在GitHub</a>

Allows to cache data converting/deconverting them to base64.

This adapter uses the base64_encode/base64_decode PHP's functions

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

## 方法

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Base64 constructor

public **getLifetime** ()

Returns the cache lifetime

public **isBuffering** ()

Check whether if frontend is buffering output

public **start** ()

Starts output frontend. Actually, does nothing in this adapter

public *string* **getContent** ()

Returns output cached content

public **stop** ()

Stops output frontend

public **beforeStore** (*mixed* $data)

Serializes data before storing them

public **afterRetrieve** (*mixed* $data)

Unserializes data after retrieval