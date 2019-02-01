---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Msgpack'
---
# Class **Phalcon\Cache\Frontend\Msgpack**

*extends* class [Phalcon\Cache\Frontend\Data](Phalcon_Cache_Frontend_Data)

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/msgpack.zep)

Permite almacenar en caché los datos nativos de PHP en forma serializada usando la extensión msgpack Este adaptador usa una interfaz Msgpack para almacenar el contenido en caché y requiere la extensión msgpack.

```php
<?php

use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Frontend\Msgpack;

// Cache the files for 2 days using Msgpack frontend
$frontCache = new Msgpack(
    [
        "lifetime" => 172800,
    ]
);

// Create the component that will cache "Msgpack" to a "File" backend
// Set the cache file directory - important to keep the "/" at the end of
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

// Use $robots
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

```

## Métodos

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Msgpack constructor

public **getLifetime** ()

Devuelve el tiempo de vida del cache

public **isBuffering** ()

Verifique si el frontend está almacenando la salida

public **start** ()

Starts output frontend. Actually, does nothing

public **getContent** ()

Regresa contenido almacenado saliente

public **stop** ()

Detiene la salida del frontend

public **beforeStore** (*mixed* $data)

Serializa los datos antes de almacenarlos

public **afterRetrieve** (*mixed* $data)

Deserializa los datos después de la recuperación