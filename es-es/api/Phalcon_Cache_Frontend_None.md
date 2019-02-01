---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cache\Frontend\None'
---
# Class **Phalcon\Cache\Frontend\None**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/none.zep)

Discards any kind of frontend data input. This frontend does not have expiration time or any other options

```php
<?php

<?php

//Create a None Cache
$frontCache = new \Phalcon\Cache\Frontend\None();

// Create the component that will cache "Data" to a "Memcached" backend
// Memcached connection settings
$cache = new \Phalcon\Cache\Backend\Memcache(
    $frontCache,
    [
        "host" => "localhost",
        "port" => "11211",
    ]
);

$cacheKey = "robots_order_id.cache";

// This Frontend always return the data as it's returned by the backend
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // This cache doesn't perform any expiration checking, so the data is always expired
    // Make the database call and populate the variable
    $robots = Robots::find(
        [
            "order" => "id",
        ]
    );

    $cache->save($cacheKey, $robots);
}

// Use $robots :)
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

```

## Métodos

public **getLifetime** ()

Devuelve el tiempo de vida del almacenamiento en caché, solo los contenidos que hayan expirado luego de un segundo

public **isBuffering** ()

Verifica si el frontend esta almacenando la salida, siempre falso

public **start** ()

Inicia el frontend de salida

public *string* **getContent** ()

Regresa contenido almacenado saliente

public **stop** ()

Detiene la salida del frontend

public **beforeStore** (*mixed* $data)

Prepara los datos para ser almacenados

public **afterRetrieve** (*mixed* $data)

Prepara los datos para ser regresados al usuario