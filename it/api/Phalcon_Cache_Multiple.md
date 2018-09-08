# Class **Phalcon\\Cache\\Multiple**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/multiple.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Allows to read to chained backend adapters writing to multiple backends

```php
<?php

use Phalcon\Cache\Frontend\Data as DataFrontend;
use Phalcon\Cache\Multiple;
use Phalcon\Cache\Backend\Apc as ApcCache;
use Phalcon\Cache\Backend\Memcache as MemcacheCache;
use Phalcon\Cache\Backend\File as FileCache;

$ultraFastFrontend = new DataFrontend(
    [
        "lifetime" => 3600,
    ]
);

$fastFrontend = new DataFrontend(
    [
        "lifetime" => 86400,
    ]
);

$slowFrontend = new DataFrontend(
    [
        "lifetime" => 604800,
    ]
);

//Backends are registered from the fastest to the slower
$cache = new Multiple(
    [
        new ApcCache(
            $ultraFastFrontend,
            [
                "prefix" => "cache",
            ]
        ),
        new MemcacheCache(
            $fastFrontend,
            [
                "prefix" => "cache",
                "host"   => "localhost",
                "port"   => "11211",
            ]
        ),
        new FileCache(
            $slowFrontend,
            [
                "prefix"   => "cache",
                "cacheDir" => "../app/cache/",
            ]
        ),
    ]
);

//Save, saves in every backend
$cache->save("my-key", $data);

```

## Methods

public **__construct** ([[Phalcon\Cache\BackendInterface](/[[language]]/[[version]]/api/Phalcon_Cache_BackendInterface) $backends])

Phalcon\\Cache\\Multiple constructor

public **push** ([Phalcon\Cache\BackendInterface](/[[language]]/[[version]]/api/Phalcon_Cache_BackendInterface) $backend)

Adds a backend

public *mixed* **get** (*string* | *int* $keyName, [*int* $lifetime])

Returns a cached content reading the internal backends

public **start** (*string* | *int* $keyName, [*int* $lifetime])

Starts every backend

public **save** ([*string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Stores cached content into all backends and stops the frontend

public *boolean* **delete** (*string* | *int* $keyName)

Deletes a value from each backend

public **exists** ([*string* | *int* $keyName], [*int* $lifetime])

Checks if cache exists in at least one backend

public **flush** ()

Flush all backend(s)