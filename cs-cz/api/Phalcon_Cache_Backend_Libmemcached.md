* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Cache\Backend\Libmemcached'

* * *

# Class **Phalcon\Cache\Backend\Libmemcached**

*extends* abstract class [Phalcon\Cache\Backend](/4.0/en/api/Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](/4.0/en/api/Phalcon_Cache_BackendInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/backend/libmemcached.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Allows to cache output fragments, PHP data or raw data to a libmemcached backend. Per default persistent memcached connection pools are used.

```php
<?php

use Phalcon\Cache\Backend\Libmemcached;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cache data for 2 days
$frontCache = new FrontData(
    [
        "lifetime" => 172800,
    ]
);

// Create the Cache setting memcached connection options
$cache = new Libmemcached(
    $frontCache,
    [
        "servers" => [
            [
                "host"   => "127.0.0.1",
                "port"   => 11211,
                "weight" => 1,
            ],
        ],
        "client" => [
            \Memcached::OPT_HASH       => \Memcached::HASH_MD5,
            \Memcached::OPT_PREFIX_KEY => "prefix.",
        ],
    ]
);

// Cache arbitrary data
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Get data
$data = $cache->get("my-data");

```

## Methods

public **__construct** ([Phalcon\Cache\FrontendInterface](/4.0/en/api/Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend\Memcache constructor

public **_connect** ()

Create internal connection to memcached

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

public **increment** ([*string* $keyName], [*mixed* $value])

Increment of given $keyName by $value

public **decrement** ([*string* $keyName], [*mixed* $value])

Decrement of $keyName by given $value

public **flush** ()

Immediately invalidates all existing items. Memcached does not support flush() per default. If you require flush() support, set $config["statsKey"]. All modified keys are stored in "statsKey". Note: statsKey has a negative performance impact.

```php
<?php

$cache = new \Phalcon\Cache\Backend\Libmemcached(
    $frontCache,
    [
        "statsKey" => "_PHCM",
    ]
);

$cache->save("my-data", [1, 2, 3, 4, 5]);

// 'my-data' and all other used keys are deleted
$cache->flush();

```

public **getFrontend** () inherited from [Phalcon\Cache\Backend](/4.0/en/api/Phalcon_Cache_Backend)

...

public **setFrontend** (*mixed* $frontend) inherited from [Phalcon\Cache\Backend](/4.0/en/api/Phalcon_Cache_Backend)

...

public **getOptions** () inherited from [Phalcon\Cache\Backend](/4.0/en/api/Phalcon_Cache_Backend)

...

public **setOptions** (*mixed* $options) inherited from [Phalcon\Cache\Backend](/4.0/en/api/Phalcon_Cache_Backend)

...

public **getLastKey** () inherited from [Phalcon\Cache\Backend](/4.0/en/api/Phalcon_Cache_Backend)

...

public **setLastKey** (*mixed* $lastKey) inherited from [Phalcon\Cache\Backend](/4.0/en/api/Phalcon_Cache_Backend)

...

public *mixed* **start** (*int* | *string* $keyName, [*int* $lifetime]) inherited from [Phalcon\Cache\Backend](/4.0/en/api/Phalcon_Cache_Backend)

Starts a cache. The keyname allows to identify the created fragment

public **stop** ([*mixed* $stopBuffer]) inherited from [Phalcon\Cache\Backend](/4.0/en/api/Phalcon_Cache_Backend)

Stops the frontend without store any cached content

public **isFresh** () inherited from [Phalcon\Cache\Backend](/4.0/en/api/Phalcon_Cache_Backend)

Checks whether the last cache is fresh or cached

public **isStarted** () inherited from [Phalcon\Cache\Backend](/4.0/en/api/Phalcon_Cache_Backend)

Checks whether the cache has starting buffering or not

public *int* **getLifetime** () inherited from [Phalcon\Cache\Backend](/4.0/en/api/Phalcon_Cache_Backend)

Gets the last lifetime set