---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Cache\Backend\Mongo'
---
# Class **Phalcon\Cache\Backend\Mongo**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/mongo.zep)

Allows to cache output fragments, PHP data or raw data to a MongoDb backend

```php
<?php

use Phalcon\Cache\Backend\Mongo;
use Phalcon\Cache\Frontend\Base64;

// Cache data for 2 days
$frontCache = new Base64(
    [
        "lifetime" => 172800,
    ]
);

// Create a MongoDB cache
$cache = new Mongo(
    $frontCache,
    [
        "server"     => "mongodb://localhost",
        "db"         => "caches",
        "collection" => "images",
    ]
);

// Cache arbitrary data
$cache->save(
    "my-data",
    file_get_contents("some-image.jpg")
);

// Get data
$data = $cache->get("my-data");

```

## Methoden

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend\Mongo constructor

final protected *MongoCollection* **_getCollection** ()

Gibt eine MongoDb-Auflistung anhand der Back-End-Parameter

public **get** (*mixed* $keyName, [*mixed* $lifetime])

Liefert einen zwischengespeicherten Inhalt

public **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Stores cached content into the file backend and stops the frontend

public *boolean* **delete** (*int* | *string* $keyName)

Löscht einen Wert aus dem Cache anhand seines Schlüssels

public **queryKeys** ([*mixed* $prefix])

Query the existing cached keys.

```php
<?php

$cache->save("users-ids", [1, 2, 3]);
$cache->save("projects-ids", [4, 5, 6]);

var_dump($cache->queryKeys("users")); // ["users-ids"]

```

public **exists** ([*string* $keyName], [*int* $lifetime])

Überprüft, ob Cache vorhanden und nicht abgelaufen ist

public *collection->remove(...)* **gc** ()

gc

public **increment** (*int* | *string* $keyName, [*mixed* $value])

Increment of a given key by $value

public **decrement** (*int* | *string* $keyName, [*mixed* $value])

Decrement of a given key by $value

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

Stoppt das Frontend ohne zwischengespeicherte Inhalte zu speichern

public **isFresh** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Prüft, ob der letzte Cache frisch oder zwischengespeichert ist

public **isStarted** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Prüft, ob der Cache mit der Pufferung begonnen hat oder nicht

public *int* **getLifetime** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Ermittelt die zuletzt gespeicherte Lebensdauer