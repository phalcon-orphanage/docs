---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cache\Backend\Memory'
---
# Class **Phalcon\Cache\Backend\Memory**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface), [Serializable](https://php.net/manual/en/class.serializable.php)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/memory.zep)

Stores content in memory. Data is lost when the request is finished

```php
<?php

use Phalcon\Cache\Backend\Memory;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cache data
$frontCache = new FrontData();

$cache = new Memory($frontCache);

// Cache arbitrary data
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Get data
$data = $cache->get("my-data");

```

## Métodos

public **get** (*mixed* $keyName, [*mixed* $lifetime])

Devuelve el contenido almacenado en caché

public **save** ([*string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Almacena el contenido almacenado en caché dentro del backend y detiene el frontend

public *boolean* **delete** (*string* $keyName)

Elimina el valor almacenado en caché por la clave

public **queryKeys** ([*mixed* $prefix])

Indagar las claves almacenadas en caché existentes.

```php
<?php

$cache->save("users-ids", [1, 2, 3]);
$cache->save("projects-ids", [4, 5, 6]);

var_dump($cache->queryKeys("users")); // ["users-ids"]

```

public **exists** ([*string* | *int* $keyName], [*int* $lifetime])

Comprueba si el almacenamiento en caché existe y no ha expirado

public **increment** ([*string* $keyName], [*mixed* $value])

Incremento del $keyName dado por $value

public **decrement** ([*string* $keyName], [*mixed* $value])

Reducción del $keyName por el $value predeterminado

public **flush** ()

Anula inmediatamente todos los elementos existentes.

public **serialize** ()

Required for interface \Serializable

public **unserialize** (*mixed* $data)

Required for interface \Serializable

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

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options]) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Phalcon\Cache\Backend constructor

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