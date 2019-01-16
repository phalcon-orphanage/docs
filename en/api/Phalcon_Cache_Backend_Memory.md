---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Cache\Backend\Memory'
---
# Class **Phalcon\Cache\Backend\Memory**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface), [Serializable](https://php.net/manual/en/class.serializable.php)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/backend/memory.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Stores content in memory. Data is lost when the request is finished

```php
<?php

use Phalcon\Cache\Backend\Memory;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cache data
$frontCache = new FrontData();

$cache = new Memory($frontCache);

// Cache arbitrary data
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Get data
$data = $cache->get("my-data");

```


## Methods
public  **get** (*mixed* $keyName, [*mixed* $lifetime])

Returns a cached content



public  **save** ([*string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Stores cached content into the backend and stops the frontend



public *boolean* **delete** (*string* $keyName)

Deletes a value from the cache by its key



public  **queryKeys** ([*mixed* $prefix])

Query the existing cached keys.

```php
<?php

$cache->save("users-ids", [1, 2, 3]);
$cache->save("projects-ids", [4, 5, 6]);

var_dump($cache->queryKeys("users")); // ["users-ids"]

```



public  **exists** ([*string* | *int* $keyName], [*int* $lifetime])

Checks if cache exists and it hasn't expired



public  **increment** ([*string* $keyName], [*mixed* $value])

Increment of given $keyName by $value



public  **decrement** ([*string* $keyName], [*mixed* $value])

Decrement of $keyName by given $value



public  **flush** ()

Immediately invalidates all existing items.



public  **serialize** ()

Required for interface \Serializable



public  **unserialize** (*mixed* $data)

Required for interface \Serializable



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


public  **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options]) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Phalcon\Cache\Backend constructor



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



