---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Base64'
---
# Class **Phalcon\Cache\Frontend\Base64**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/base64.zep)

Ermöglicht es Daten über (de-) konvertierung nach base64 zu cachen.

Dieser Adapter nutzt die base64_encode/base64_decode PHP Funktionen

```php
<?php

<?php

// Dateien für 2 Tage mittels Base64 frontend cachen
$frontCache = new \Phalcon\Cache\Frontend\Base64(
    [
        "lifetime" => 172800,
    ]
);

//MongoDB Cache erstellen
$cache = new \Phalcon\Cache\Backend\Mongo(
    $frontCache,
    [
        "server"     => "mongodb://localhost",
        "db"         => "caches",
        "collection" => "images",
    ]
);

$cacheKey = "some-image.jpg.cache";

// Try to get cached image
$image = $cache->get($cacheKey);

if ($image === null) {
    // Store the image in the cache
    $cache->save(
        $cacheKey,
        file_get_contents("tmp-dir/some-image.jpg")
    );
}

header("Content-Type: image/jpeg");

echo $image;

```

## Methoden

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Base64 constructor

public **getLifetime** ()

Liefert die Cache-Lebensdauer

public **isBuffering** ()

Prüft, ob das Frontend Ausgaben puffert

public **start** ()

Starts output frontend. Actually, does nothing in this adapter

public *string* **getContent** ()

Liefert einen zwischengespeicherten Inhalt

public **stop** ()

Stoppt die Frontend Ausgabe

public **beforeStore** (*mixed* $data)

Serialisiert Daten vor dem Speichern

public **afterRetrieve** (*mixed* $data)

Unserializes Daten nach der Entnahme