---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Cache\Backend\File'
---
# Class **Phalcon\Cache\Backend\File**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/file.zep)

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

## Methoden

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, *array* $options)

Phalcon\Cache\Backend\File constructor

public **get** (*mixed* $keyName, [*mixed* $lifetime])

Liefert einen zwischengespeicherten Inhalt

public **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Stores cached content into the file backend and stops the frontend

public **delete** (*int* | *string* $keyName)

Löscht einen Wert aus dem Cache anhand seines Schlüssels

public **queryKeys** ([*mixed* $prefix])

Query the existing cached keys.

```php
<?php

$cache->save("users-ids", [1, 2, 3]);
$cache->save("projects-ids", [4, 5, 6]);

var_dump($cache->queryKeys("users")); // ["users-ids"]

```

public **exists** ([*string* | *int* $keyName], [*int* $lifetime])

Überprüft, ob Cache vorhanden und nicht abgelaufen ist

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

Stoppt das Frontend ohne zwischengespeicherte Inhalte zu speichern

public **isFresh** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Prüft, ob der letzte Cache frisch oder zwischengespeichert ist

public **isStarted** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Prüft, ob der Cache mit der Pufferung begonnen hat oder nicht

public *int* **getLifetime** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Ermittelt die zuletzt gespeicherte Lebensdauer