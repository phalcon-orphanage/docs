---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cache\Multiple'
---
# Class **Phalcon\Cache\Multiple**

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/multiple.zep)

Permite leer adaptadores encadenados back-end escribiendo a múltiples backends

```php
<?php

use Phalcon\Cache\Frontend\Data as DataFrontend;
use Phalcon\Cache\Multiple;
use Phalcon\Cache\Backend\Apc as ApcCache;
use Phalcon\Cache\Backend\Memcache as MemcacheCache;
use Phalcon\Cache\Backend\File as FileCache;

$ultraFastFrontend = new DataFrontend(
    [
        "lifetime" => 3600,
    ]
);

$fastFrontend = new DataFrontend(
    [
        "lifetime" => 86400,
    ]
);

$slowFrontend = new DataFrontend(
    [
        "lifetime" => 604800,
    ]
);

//Backends are registered from the fastest to the slower
$cache = new Multiple(
    [
        new ApcCache(
            $ultraFastFrontend,
            [
                "prefix" => "cache",
            ]
        ),
        new MemcacheCache(
            $fastFrontend,
            [
                "prefix" => "cache",
                "host"   => "localhost",
                "port"   => "11211",
            ]
        ),
        new FileCache(
            $slowFrontend,
            [
                "prefix"   => "cache",
                "cacheDir" => "../app/cache/",
            ]
        ),
    ]
);

//Save, saves in every backend
$cache->save("my-key", $data);

```

## Métodos

public **__construct** ([[Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface) $backends])

Phalcon\Cache\Multiple constructor

public **push** ([Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface) $backend)

Adiciona un backend

public *mixed* **get** (*string* | *int* $keyName, [*int* $lifetime])

Devuelve un contenido almacenado leyendo en backend interno

public **start** (*string* | *int* $keyName, [*int* $lifetime])

Inicia cada backend

public **save** ([*string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Almacena contenidos cache en todos los backends y detiene la interfaz

public *boolean* **delete** (*string* | *int* $keyName)

Elimina un valor de cada backend

public **exists** ([*string* | *int* $keyName], [*int* $lifetime])

Verifica si el cache existe en al menos un backend

public **flush** ()

Vaciar todos los backends