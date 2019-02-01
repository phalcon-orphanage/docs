---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cache\Backend\Mongo'
---
# Class **Phalcon\Cache\Backend\Mongo**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/mongo.zep)

Permite almacenar en cache fragmentos de producción, datos PHP o datos sin procesar hacia un MongoDb backend

```php
<?php

use Phalcon\Cache\Backend\Mongo;
use Phalcon\Cache\Frontend\Base64;

// Cache data for 2 days
$frontCache = new Base64(
    [
        "lifetime" => 172800,
    ]
);

// Create a MongoDB cache
$cache = new Mongo(
    $frontCache,
    [
        "server"     => "mongodb://localhost",
        "db"         => "caches",
        "collection" => "images",
    ]
);

// Cache arbitrary data
$cache->save(
    "my-data",
    file_get_contents("some-image.jpg")
);

// Get data
$data = $cache->get("my-data");

```

## Métodos

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend\Mongo constructor

final protected *MongoCollection* **_getCollection** ()

Devuelve una colección de MongoDb basándose en los parámetros de backend

public **get** (*mixed* $keyName, [*mixed* $lifetime])

Devuelve el contenido almacenado en caché

public **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Almacena el contenido en caché en el backend del archivo y detiene el Frontend

public *boolean* **delete** (*int* | *string* $keyName)

Elimina el valor almacenado en caché por la clave

public **queryKeys** ([*mixed* $prefix])

Indagar las claves almacenadas en caché existentes.

```php
<?php

$cache->save("users-ids", [1, 2, 3]);
$cache->save("projects-ids", [4, 5, 6]);

var_dump($cache->queryKeys("users")); // ["users-ids"]

```

public **exists** ([*string* $keyName], [*int* $lifetime])

Verifica si existe el caché y que no está expirado

public *collection->remove(...)* **gc** ()

gc

public **increment** (*int* | *string* $keyName, [*mixed* $value])

Incremento de la llave predeterminado, por el numero $value

public **decrement** (*int* | *string* $keyName, [*mixed* $value])

Reducción de la llave predeterminada, por el numero $value

public **flush** ()

Anula inmediatamente todos los elementos existentes.

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

Comienza una caché. El KeyName permite identificar el fragmento creado

public **stop** ([*mixed* $stopBuffer]) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Detiene el frontend sin almacenar ningún contenido almacenado en caché

public **isFresh** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Comprueba si el último almacenamiento en caché esta actualizado o no

public **isStarted** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Comprueba si el caché ha empezado a almacenarse o no

public *int* **getLifetime** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Obtiene la última duración establecida