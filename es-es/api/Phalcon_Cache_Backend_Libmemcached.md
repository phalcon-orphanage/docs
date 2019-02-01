---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cache\Backend\Libmemcached'
---
# Class **Phalcon\Cache\Backend\Libmemcached**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/libmemcached.zep)

Allows to cache output fragments, PHP data or raw data to a libmemcached backend. Per default persistent memcached connection pools are used.

```php
<?php

use Phalcon\Cache\Backend\Libmemcached;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cache data for 2 days
$frontCache = new FrontData(
    [
        "lifetime" => 172800,
    ]
);

// Create the Cache setting memcached connection options
$cache = new Libmemcached(
    $frontCache,
    [
        "servers" => [
            [
                "host"   => "127.0.0.1",
                "port"   => 11211,
                "weight" => 1,
            ],
        ],
        "client" => [
            \Memcached::OPT_HASH       => \Memcached::HASH_MD5,
            \Memcached::OPT_PREFIX_KEY => "prefix.",
        ],
    ]
);

// Cache arbitrary data
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Get data
$data = $cache->get("my-data");

```

## Métodos

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend\Memcache constructor

public **_connect** ()

Crea una conexión interna a memcached

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

public **increment** ([*string* $keyName], [*mixed* $value])

Incremento del $keyName dado por $value

public **decrement** ([*string* $keyName], [*mixed* $value])

Reducción del $keyName por el $value predeterminado

public **flush** ()

Anula inmediatamente todos los elementos existentes. Memcached no soporta flush() por defecto. Si necesita asistencia flush(), ajustar $config["statsKey"]. Todas las claves modificadas son almacenadas en "statskey". Nota: statsKey tiene un impacto negativo de performance.

```php
<?php

$cache = new \Phalcon\Cache\Backend\Libmemcached(
    $frontCache,
    [
        "statsKey" => "_PHCM",
    ]
);

$cache->save("my-data", [1, 2, 3, 4, 5]);

// 'my-data' and all other used keys are deleted
$cache->flush();

```

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