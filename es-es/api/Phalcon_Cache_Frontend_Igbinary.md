---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Igbinary'
---
# Class **Phalcon\Cache\Frontend\Igbinary**

*extends* class [Phalcon\Cache\Frontend\Data](Phalcon_Cache_Frontend_Data)

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/igbinary.zep)

Permite almacenar datos PHP nativos de una forma serializada usando extensión igbinary

```php
<?php

// Cache the files for 2 days using Igbinary frontend
$frontCache = new \Phalcon\Cache\Frontend\Igbinary(
    [
        "lifetime" => 172800,
    ]
);

// Create the component that will cache "Igbinary" to a "File" backend
// Set the cache file directory - important to keep the "/" at the end of
// of the value for the folder
$cache = new \Phalcon\Cache\Backend\File(
    $frontCache,
    [
        "cacheDir" => "../app/cache/",
    ]
);

$cacheKey = "robots_order_id.cache";

// Try to get cached records
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robots is null due to cache expiration or data do not exist
    // Make the database call and populate the variable
    $robots = Robots::find(
        [
            "order" => "id",
        ]
    );

    // Store it in the cache
    $cache->save($cacheKey, $robots);
}

// Use $robots :)
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

```

## Métodos

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Data constructor

public **getLifetime** ()

Devuelve el tiempo de vida del cache

public **isBuffering** ()

Verifique si el frontend está almacenando la salida

public **start** ()

Starts output frontend. Actually, does nothing

public *string* **getContent** ()

Regresa contenido almacenado saliente

public **stop** ()

Detiene la salida del frontend

public **beforeStore** (*mixed* $data)

Serializa los datos antes de almacenarlos

public **afterRetrieve** (*mixed* $data)

Deserializa los datos después de la recuperación