* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Cache\Backend\Xcache'

* * *

# Class **Phalcon\Cache\Backend\Xcache**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/backend/xcache.zep" class="btn btn-default btn-sm">源码在GitHub</a>

Allows to cache output fragments, PHP data and raw data using an XCache backend

```php
<?php

use Phalcon\Cache\Backend\Xcache;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cache data for 2 days
$frontCache = new FrontData(
    [
       "lifetime" => 172800,
    ]
);

$cache = new Xcache(
    $frontCache,
    [
        "prefix" => "app-data",
    ]
);

// Cache arbitrary data
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Get data
$data = $cache->get("my-data");

```

## 方法

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend\Xcache constructor

public **get** (*mixed* $keyName, [*mixed* $lifetime])

Returns a cached content

public **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Stores cached content into the file backend and stops the frontend

public *boolean* **delete** (*int* | *string* $keyName)

Deletes a value from the cache by its key

public **queryKeys** ([*mixed* $prefix])

Query the existing cached keys.

```php
<?php

$cache->save("users-ids", [1, 2, 3]);
$cache->save("projects-ids", [4, 5, 6]);

var_dump($cache->queryKeys("users")); // ["users-ids"]

```

public **exists** ([*string* $keyName], [*int* $lifetime])

Checks if cache exists and it isn't expired

public **increment** (*string* $keyName, [*mixed* $value])

Atomic increment of a given key, by number $value

public **decrement** (*string* $keyName, [*mixed* $value])

Atomic decrement of a given key, by number $value

public **flush** ()

Immediately invalidates all existing items.

public **getFrontend** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public **setFrontend** (*mixed* $frontend) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public **getOptions** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public **setOptions** (*mixed* $options) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public **getLastKey** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public **setLastKey** (*mixed* $lastKey) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public *mixed* **start** (*int* | *string* $keyName, [*int* $lifetime]) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Starts a cache. The keyname allows to identify the created fragment

public **stop** ([*mixed* $stopBuffer]) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Stops the frontend without store any cached content

public **isFresh** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Checks whether the last cache is fresh or cached

public **isStarted** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Checks whether the cache has starting buffering or not

public *int* **getLifetime** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Gets the last lifetime set