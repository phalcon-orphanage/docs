---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Cache\Backend\Redis'
---
# Class **Phalcon\Cache\Backend\Redis**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/redis.zep)

Ermöglicht es Ausgabe-Fragmente, PHP Daten oder Rohdaten in einem Redis-Backend zu cachen

Dieser Adapter verwendet den speziellen Redis-Schlüssel "_PHCR" zum Speichern von alle Schlüsseln, die intern vom Adapter verwendet werden

```php
<?php

use Phalcon\Cache\Backend\Redis;
use Phalcon\Cache\Frontend\Data as FrontData;

// Daten für 2 days cachen
$frontCache = new FrontData(
    [
        "lifetime" => 172800,
    ]
);

// Cache mit den Einstellungen für Redis-Verbindung erzeugen
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

// Willkürliche Daten speichern
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Daten erhalten
$data = $cache->get("my-data");

```

## Methoden

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend\Redis constructor

public **_connect** ()

Interne Verbindung mit Redis erstellen

public **get** (*mixed* $keyName, [*mixed* $lifetime])

Liefert einen zwischengespeicherten Inhalt

public **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Stores cached content into the file backend and stops the frontend

```php
<?php

$cache->save("my-key", $data);

// Sichert Daten begriffslos
$cache->save("my-key", $data, -1);

```

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

public **exists** ([*string* $keyName], [*int* $lifetime])

Überprüft, ob Cache vorhanden und nicht abgelaufen ist

public **increment** ([*string* $keyName], [*mixed* $value])

Increment of given $keyName by $value

public **decrement** ([*string* $keyName], [*mixed* $value])

Decrement of $keyName by given $value

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