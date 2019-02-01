---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Json'
---
# Class **Phalcon\Cache\Frontend\Json**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/json.zep)

Permite almacenar en caché los datos convirtiéndolos/des-convirtiéndolos en JSON.

Este adaptador usa las funciones de json_encode/json_decode de PHP

Como los datos están codificados en JSON, otros sistemas que acceden al mismo back-end podrían procesarlos

```php
<?php

<?php

// Cache the data for 2 days
$frontCache = new \Phalcon\Cache\Frontend\Json(
    [
        "lifetime" => 172800,
    ]
);

// Create the Cache setting memcached connection options
$cache = new \Phalcon\Cache\Backend\Memcache(
    $frontCache,
    [
        "host"       => "localhost",
        "port"       => 11211,
        "persistent" => false,
    ]
);

// Cache arbitrary data
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Get data
$data = $cache->get("my-data");

```

## Métodos

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Base64 constructor

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