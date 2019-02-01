---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Json'
---
# Class **Phalcon\Cache\Frontend\Json**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/json.zep)

Ermöglicht es Daten über (de-)konvertierung nach JSON zu cachen.

Dieser Adapter nutzt die json_encode/Json_decode PHP Funktionen

Da die Daten in JSON codiert sind, können andere Systemen mit Zugriff auf dasselbe Backend diese verarbeiten

```php
<?php

<?php

// Daten für 2 days cachen
$frontCache = new \Phalcon\Cache\Frontend\Json(
    [
        "lifetime" => 172800,
    ]
);

// Cache mittels memcached Einstellungesoptionen erstellen
$cache = new \Phalcon\Cache\Backend\Memcache(
    $frontCache,
    [
        "host"       => "localhost",
        "port"       => 11211,
        "persistent" => false,
    ]
);

// Willkürliche Date ccachen
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Daten holen
$data = $cache->get("my-data");

```

## Methoden

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Base64 constructor

public **getLifetime** ()

Liefert die Cache-Lebensdauer

public **isBuffering** ()

Prüft, ob das Frontend Ausgaben puffert

public **start** ()

Starts output frontend. Actually, does nothing

public *string* **getContent** ()

Liefert einen zwischengespeicherten Inhalt

public **stop** ()

Stoppt die Frontend Ausgabe

public **beforeStore** (*mixed* $data)

Serialisiert Daten vor dem Speichern

public **afterRetrieve** (*mixed* $data)

Unserializes Daten nach der Entnahme