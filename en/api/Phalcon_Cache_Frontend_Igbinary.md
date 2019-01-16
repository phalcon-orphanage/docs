---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Igbinary'
---
# Class **Phalcon\Cache\Frontend\Igbinary**

*extends* class [Phalcon\Cache\Frontend\Data](Phalcon_Cache_Frontend_Data)

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/frontend/igbinary.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Allows to cache native PHP data in a serialized form using igbinary extension

```php
<?php

// Cache the files for 2 days using Igbinary frontend
$frontCache = new \Phalcon\Cache\Frontend\Igbinary(
    [
        "lifetime" => 172800,
    ]
);

// Create the component that will cache "Igbinary" to a "File" backend
// Set the cache file directory - important to keep the "/" at the end of
// of the value for the folder
$cache = new \Phalcon\Cache\Backend\File(
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

// Use $robots :)
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

```


## Methods
public  **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Data constructor



public  **getLifetime** ()

Returns the cache lifetime



public  **isBuffering** ()

Check whether if frontend is buffering output



public  **start** ()

Starts output frontend. Actually, does nothing



public *string* **getContent** ()

Returns output cached content



public  **stop** ()

Stops output frontend



public  **beforeStore** (*mixed* $data)

Serializes data before storing them



public  **afterRetrieve** (*mixed* $data)

Unserializes data after retrieval



