---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Msgpack'
---
# Class **Phalcon\Cache\Frontend\Msgpack**

*extends* class [Phalcon\Cache\Frontend\Data](Phalcon_Cache_Frontend_Data)

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/msgpack.zep)

Ermöglicht es, native PHP Daten in serialisierter Form mittels der Msgpack Erweiterung zu cachen Dieser Adapter benutzt ein Msgpack-Frontend um zwischengespeicherte Inhalte speichern und erfordert die Msgpack Erweiterung.

```php
<?php

use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Frontend\Msgpack;

// Cached die Dateien für 2 Tage mit dem Msgpack frontend
$frontCache = new Msgpack(
    [
        "lifetime" => 172800,
    ]
);

// Erzeugt eine Komponente welche "Msgpack" in ein "Datei" backend cached
// Setzt das cache Verzeichnis - Es ist wichtig das "/" am Ende
// des Verzeichnisnamens zu behalten
$cache = new File(
    $frontCache,
    [
        "cacheDir" => "../app/cache/",
    ]
);

$cacheKey = "robots_order_id.cache";

// Versuche gecachte Datensätze zu erhalten
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robots ist null weil der cache abgelaufen ist oder weil keine Daten existieren
    // Ruft die Datenbank auf und übergibt die variablen
    $robots = Robots::find(
        [
            "order" => "id",
        ]
    );

    // Im Cache speichern
    $cache->save($cacheKey, $robots);
}

// $robots benutzen
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

```

## Methoden

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Msgpack constructor

public **getLifetime** ()

Liefert die Cache-Lebensdauer

public **isBuffering** ()

Prüft, ob das Frontend Ausgaben puffert

public **start** ()

Starts output frontend. Actually, does nothing

public **getContent** ()

Liefert einen zwischengespeicherten Inhalt

public **stop** ()

Stoppt die Frontend Ausgabe

public **beforeStore** (*mixed* $data)

Serialisiert Daten vor dem Speichern

public **afterRetrieve** (*mixed* $data)

Unserializes Daten nach der Entnahme