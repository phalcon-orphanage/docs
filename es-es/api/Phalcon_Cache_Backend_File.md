---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cache\Backend\File'
---
# Class **Phalcon\Cache\Backend\File**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/file.zep)

Permite almacenar en caché los fragmentos de salida usando un backend de archivo

```php
<?php

use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Frontend\Output as FrontOutput;

// Almacena el archivo por dos días
$frontendOptions = [
    "lifetime" => 172800,
];

// Crea un cache de salida
$frontCache = FrontOutput($frontOptions);

// Establece el directorio de cacheo
$backendOptions = [
    "cacheDir" => "../app/cache/",
];

// Crea el archivo en el backend
$cache = new File($frontCache, $backendOptions);

$content = $cache->start("my-cache");

if ($content === null) {
    echo "<h1>", time(), "</h1>";

    $cache->save();
} else {
    echo $content;
}

```

## Métodos

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, *array* $options)

Phalcon\Cache\Backend\File constructor

public **get** (*mixed* $keyName, [*mixed* $lifetime])

Devuelve el contenido almacenado en caché

public **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Almacena el contenido en caché en el backend del archivo y detiene el Frontend

public **delete** (*int* | *string* $keyName)

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

Verifica si existe el caché y que no está expirado

public **increment** ([*string* | *int* $keyName], [*mixed* $value])

Incremento de la clave predeterminada, por el número $value

public **decrement** ([*string* | *int* $keyName], [*mixed* $value])

Decremento de la clave predeterminada, por el número $value

public **flush** ()

Anula inmediatamente todos los elementos existentes.

public **getKey** (*mixed* $key)

Devolver un identificador de sistema de archivos seguros para una clave determinada

public **useSafeKey** (*mixed* $useSafeKey)

Establece si se usa safekey o no

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