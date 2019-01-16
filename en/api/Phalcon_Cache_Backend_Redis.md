---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Cache\Backend\Redis'
---
# Class **Phalcon\Cache\Backend\Redis**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/backend/redis.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Allows to cache output fragments, PHP data or raw data to a redis backend

This adapter uses the special redis key "_PHCR" to store all the keys internally used by the adapter

```php
<?php

use Phalcon\Cache\Backend\Redis;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cache data for 2 days
$frontCache = new FrontData(
    [
        "lifetime" => 172800,
    ]
);

// Create the Cache setting redis connection options
$cache = new Redis(
    $frontCache,
    [
        "host"       => "localhost",
        "port"       => 6379,
        "auth"       => "foobared",
        "persistent" => false,
        "index"      => 0,
    ]
);

// Cache arbitrary data
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Get data
$data = $cache->get("my-data");

```


## Methods
public  **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend\Redis constructor



public  **_connect** ()

Create internal connection to redis



public  **get** (*mixed* $keyName, [*mixed* $lifetime])

Returns a cached content



public  **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Stores cached content into the file backend and stops the frontend

```php
<?php

$cache->save("my-key", $data);

// Save data termlessly
$cache->save("my-key", $data, -1);

```



public  **delete** (*int* | *string* $keyName)

Deletes a value from the cache by its key



public  **queryKeys** ([*mixed* $prefix])

Query the existing cached keys.

```php
<?php

$cache->save("users-ids", [1, 2, 3]);
$cache->save("projects-ids", [4, 5, 6]);

var_dump($cache->queryKeys("users")); // ["users-ids"]

```



public  **exists** ([*string* $keyName], [*int* $lifetime])

Checks if cache exists and it isn't expired



public  **increment** ([*string* $keyName], [*mixed* $value])

Increment of given $keyName by $value



public  **decrement** ([*string* $keyName], [*mixed* $value])

Decrement of $keyName by given $value



public  **flush** ()

Immediately invalidates all existing items.



public  **getFrontend** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...


public  **setFrontend** (*mixed* $frontend) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...


public  **getOptions** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...


public  **setOptions** (*mixed* $options) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...


public  **getLastKey** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...


public  **setLastKey** (*mixed* $lastKey) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...


public *mixed* **start** (*int* | *string* $keyName, [*int* $lifetime]) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Starts a cache. The keyname allows to identify the created fragment



public  **stop** ([*mixed* $stopBuffer]) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Stops the frontend without store any cached content



public  **isFresh** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Checks whether the last cache is fresh or cached



public  **isStarted** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Checks whether the cache has starting buffering or not



public *int* **getLifetime** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Gets the last lifetime set



