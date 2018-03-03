# Class **Phalcon\\Cache\\Backend\\File**

*uzanır* soyut sınıf [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)

*uygulamalar* [Phalcon\Önbellek\Arkayüz Ara birimi](/en/3.2/api/Phalcon_Cache_BackendInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backend/file.zep" class="btn btn-default btn-sm">Source on GitHub</a>

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

herkese açık **__düzenle** ([Phalcon\Önbellek\Önyüz Ara birimi](/en/3.2/api/Phalcon_Cache_FrontendInterface) $başlangıç aşaması, [*dizi* $seçenekler)

Phalcon\\Cache\\Backend\\File constructor

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

herkese açık **Önyüz al** () [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)'den alındı

...

herkese açık **Önyüz ayarla** (*karışık* $başlangıç aşaması) [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)'den alındı

...

herkese açık **Seçenekleri al** () [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)'den alındı

...

herkese açık **Seçenekleri ayarla** (*karışık* $Seçenekler) [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)'den alındı

...

herkese açık **son anahtarı al** () [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)'den alındı

...

herkese açık **son anahtar ayarla** (*karışık* $Son Anahtar) [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)'den alındı

...

herkese açık *karışık* **başlat** (*int* | *dizi* $anahtar Adı, [*int* $ömür]) [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)'den alındı

Starts a cache. The keyname allows to identify the created fragment

herkese açık **durdur** (*karışık* $Arabelleği durdur) [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)'den alındı

Stops the frontend without store any cached content

herkese açık **Taze** () [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)'den alındı

Checks whether the last cache is fresh or cached

herkese açık **Başladı** () [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)'den alındı

Checks whether the cache has starting buffering or not

herkese açık *int* **ömür süresi** () [Phalcon\Önbellek\Arkayüz](/en/3.2/api/Phalcon_Cache_Backend)'den alındı

Gets the last lifetime set