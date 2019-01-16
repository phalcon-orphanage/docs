* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Cache\Frontend\Msgpack'

* * *

# Class **Phalcon\Cache\Frontend\Msgpack**

*extends* class [Phalcon\Cache\Frontend\Data](Phalcon_Cache_Frontend_Data)

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/frontend/msgpack.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

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

## Métodos

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Msgpack constructor

public **getLifetime** ()

Returns the cache lifetime

public **isBuffering** ()

Check whether if frontend is buffering output

public **start** ()

Starts output frontend. Actually, does nothing

public **getContent** ()

Returns output cached content

public **stop** ()

Stops output frontend

public **beforeStore** (*mixed* $data)

Serializes data before storing them

public **afterRetrieve** (*mixed* $data)

Unserializes data after retrieval