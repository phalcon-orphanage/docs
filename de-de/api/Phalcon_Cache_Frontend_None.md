---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Cache\Frontend\None'
---
# Class **Phalcon\Cache\Frontend\None**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/none.zep)

Discards any kind of frontend data input. This frontend does not have expiration time or any other options

```php
<?php

<?php

//Erzeuge einen "None Cache"
$frontCache = new \Phalcon\Cache\Frontend\None();

// Erzeugt eine Komponente, die "Data" in ein "Memcached" backend cached
// Memcached Verbindungseinstellungen
$cache = new \Phalcon\Cache\Backend\Memcache(
    $frontCache,
    [
        "host" => "localhost",
        "port" => "11211",
    ]
);

$cacheKey = "robots_order_id.cache";

// Das Frontend wird immer die Daten zurückgeben, die schon das backend zurückgegeben hatte
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // Dieser Cache prüft nicht auf Ablaufdaten, sodass die Daten immer abgelaufen sind
    // Ruft die Datenbank auf und übergibt die variable
    $robots = Robots::find(
        [
            "order" => "id",
        ]
    );

    $cache->save($cacheKey, $robots);
}

// $robots benutzen :)
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

```

## Methoden

public **getLifetime** ()

Renditen Cache Lebenszeit, immer eine Sekunde auslaufenden Inhalt

public **isBuffering** ()

Prüft, ob das Frontend Ausgaben puffert, ansonsten false

public **start** ()

Startet Frontend Ausgabe

public *string* **getContent** ()

Liefert einen zwischengespeicherten Inhalt

public **stop** ()

Stoppt die Frontend Ausgabe

public **beforeStore** (*mixed* $data)

Bereitet zu speichernden Daten vor

public **afterRetrieve** (*mixed* $data)

Bereitet die Daten, welche vom Benutzer abgerufen werden, vor