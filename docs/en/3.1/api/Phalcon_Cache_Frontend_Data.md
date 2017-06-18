# Class **Phalcon\\Cache\\Frontend\\Data**

*implements* [Phalcon\Cache\FrontendInterface](/en/3.1.2/api/Phalcon_Cache_FrontendInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/frontend/data.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Allows to cache native PHP data in a serialized form

```php
<?php

use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Frontend\Data;

// Cache the files for 2 days using a Data frontend
$frontCache = new Data(
    [
        "lifetime" => 172800,
    ]
);

// Create the component that will cache "Data" to a 'File' backend
// Set the cache file directory - important to keep the '/' at the end of
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
    // $robots is null due to cache expiration or data does not exist
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

Phalcon\\Cache\\Frontend\\Data constructor



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



