---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Data'
---
# Class **Phalcon\Cache\Frontend\Data**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/data.zep)

Permite almacenar datos nativos PHP en una forma serializada

```php
<?php

use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Frontend\Data;

// Cache the files for 2 days using a Data frontend
$frontCache = new Data(
    [
        "lifetime" => 172800,
    ]
);

// Create the component that will cache "Data" to a 'File' backend
// Set the cache file directory - important to keep the '/' at the end of
// of the value for the folder
$cache = new File(
    $frontCache,
    [
        "cacheDir" => "../app/cache/",
    ]
);

$cacheKey = "robots_order_id.cache";

// Try to get cached records
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robots is null due to cache expiration or data does not exist
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