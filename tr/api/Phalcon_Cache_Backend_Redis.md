# Phalcon sınıfı**\\Önbellek\\Arkayüz\\Redis**

*uzanır* soyut sınıf [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)

*uygulamalar* [Phalcon\Önbellek\Arkayüz Ara birimi](/en/3.2/api/Phalcon_Cache_BackendInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backend/redis.zep" class="btn btn-default btn-sm">Source on GitHub</a>

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

herkese açık **__düzenle** ([Phalcon\Önbellek\Önyüz Ara birimi](/en/3.2/api/Phalcon_Cache_FrontendInterface) $başlangıç aşaması, [*dizi* $seçenekler])

Phalcon\\Önbellek\\Arkayüz\\Redis yapıcı

herkese açık **_bağla** ()

Create internal connection to redis

public **get** (*mixed* $keyName, [*mixed* $lifetime])

Returns a cached content

public **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Önbellek içeriğini dosya arka yüzüne depolar ve önyükü durdurur

```php
<?php

$cache->save("my-key", $data);

// Save data termlessly
$cache->save("my-key", $data, -1);

```

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

public **exists** ([*string* $keyName], [*int* $lifetime])

Önbellek var olup olmadığını ve süresi dolmadığını denetler

public **increment** ([*string* $keyName], [*mixed* $value])

Increment of given $keyName by $value

public **decrement** ([*string* $keyName], [*mixed* $value])

Decrement of $keyName by given $value

public **flush** ()

Immediately invalidates all existing items.

herkese açık **Önyüz al** () [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)'den alındı

...

herkese açık **Önyüz ayarla** (*karışık* $başlangıç aşaması) [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)'den alındı

...

public **getOptions** () inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

...

herkese açık **Seçenekler ayarla** (*karışık* $Seçenekler) [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)'den alındı

...

herkese açık **son anahtarı al** () [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)'den alındı

...

herkese açık **son anahtar ayarla** (*karışık* $Son Anahtar) [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)'den alındı

...

public *mixed* **start** (*int* | *string* $keyName, [*int* $lifetime]) inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

Starts a cache. The keyname allows to identify the created fragment

public **stop** ([*mixed* $stopBuffer]) inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

Stops the frontend without store any cached content

public **isFresh** () inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

Checks whether the last cache is fresh or cached

public **isStarted** () inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

Checks whether the cache has starting buffering or not

public *int* **getLifetime** () inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

Gets the last lifetime set