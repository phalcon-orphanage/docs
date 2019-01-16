* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Cache\Backend\File'

* * *

# Class **Phalcon\Cache\Backend\File**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/backend/file.zep" class="btn btn-default btn-sm">Исходный код на GitHub</a>

Allows to cache output fragments using a file backend

```php
<?php

use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Frontend\Output as FrontOutput;

// Cache the file for 2 days
$frontendOptions = [
    "lifetime" => 172800,
];

// Create an output cache
$frontCache = FrontOutput($frontOptions);

// Set the cache directory
$backendOptions = [
    "cacheDir" => "../app/cache/",
];

// Create the File backend
$cache = new File($frontCache, $backendOptions);

$content = $cache->start("my-cache");

if ($content === null) {
    echo "<h1>", time(), "</h1>";

    $cache->save();
} else {
    echo $content;
}

```

## Methods

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, *array* $options)

Phalcon\Cache\Backend\File constructor

public **get** (*mixed* $keyName, [*mixed* $lifetime])

Returns a cached content

public **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Stores cached content into the file backend and stops the frontend

public **delete** (*int* | *string* $keyName)

Deletes a value from the cache by its key

public **queryKeys** ([*mixed* $prefix])

Query the existing cached keys.

```php
<?php

$cache->save("users-ids", [1, 2, 3]);
$cache->save("projects-ids", [4, 5, 6]);

var_dump($cache->queryKeys("users")); // ["users-ids"]

```

public **exists** ([*string* | *int* $keyName], [*int* $lifetime])

Checks if cache exists and it isn't expired

public **increment** ([*string* | *int* $keyName], [*mixed* $value])

Increment of a given key, by number $value

public **decrement** ([*string* | *int* $keyName], [*mixed* $value])

Decrement of a given key, by number $value

public **flush** ()

Immediately invalidates all existing items.

public **getKey** (*mixed* $key)

Return a file-system safe identifier for a given key

public **useSafeKey** (*mixed* $useSafeKey)

Set whether to use the safekey or not

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