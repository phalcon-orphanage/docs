---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Json'
---
# Class **Phalcon\Cache\Frontend\Json**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/json.zep)

Allows to cache data converting/deconverting them to JSON.

This adapter uses the json_encode/json_decode PHP's functions

As the data is encoded in JSON other systems accessing the same backend could process them

```php
<?php

<?php

// Cache the data for 2 days
$frontCache = new \Phalcon\Cache\Frontend\Json(
    [
        "lifetime" => 172800,
    ]
);

// Create the Cache setting memcached connection options
$cache = new \Phalcon\Cache\Backend\Memcache(
    $frontCache,
    [
        "host"       => "localhost",
        "port"       => 11211,
        "persistent" => false,
    ]
);

// Cache arbitrary data
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Get data
$data = $cache->get("my-data");

```

## 方法

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Base64 constructor

public **getLifetime** ()

Returns the cache lifetime

public **isBuffering** ()

Check whether if frontend is buffering output

public **start** ()

Starts output frontend. Actually, does nothing

public *string* **getContent** ()

Returns output cached content

public **stop** ()

Stops output frontend

public **beforeStore** (*mixed* $data)

Serializes data before storing them

public **afterRetrieve** (*mixed* $data)

Unserializes data after retrieval