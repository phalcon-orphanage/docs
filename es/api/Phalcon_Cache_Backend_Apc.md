# Clase **Phalcon\\Cache\\Backend\\Apc**

*extendiende* de la clase abstracta [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

*implementa* [Phalcon\Cache\BackendInterface](/en/3.2/api/Phalcon_Cache_BackendInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backend/apc.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Permite almacenar en caché fragmentos de salida, datos PHP y datos sin procesar utilizando un backend APC

```php
<?php

use Phalcon\Cache\Backend\Apc;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cachear datos por 2 días
$frontCache = new FrontData(
    [
        "lifetime" => 172800,
    ]
);

$cache = new Apc(
    $frontCache,
    [
        "prefix" => "app-data",
    ]
);

// Cachear datos arbitrários
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Obtener datos
$data = $cache->get("my-data");

```

## Métodos

public **get** (*mixed* $keyName, [*mixed* $lifetime])

Returns a cached content

public **save** ([*string* | *int* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Stores cached content into the APC backend and stops the frontend

public **increment** ([*string* $keyName], [*mixed* $value])

Increment of a given key, by number $value

public **decrement** ([*string* $keyName], [*mixed* $value])

Decrement of a given key, by number $value

public **delete** (*mixed* $keyName)

Deletes a value from the cache by its key

public **queryKeys** ([*mixed* $prefix])

Query the existing cached keys.

```php
<?php

$cache->save("users-ids", [1, 2, 3]);
$cache->save("projects-ids", [4, 5, 6]);

var_dump($cache->queryKeys("users")); // ["users-ids"]

```

public **exists** ([*string* | *int* $keyName], [*int* $lifetime])

Checks if cache exists and it hasn't expired

public **flush** ()

Immediately invalidates all existing items.

```php
<?php

use Phalcon\Cache\Backend\Apc;

$cache = new Apc($frontCache, ["prefix" => "app-data"]);

$cache->save("my-data", [1, 2, 3, 4, 5]);

// 'my-data' and all other used keys are deleted
$cache->flush();

```

public **getFrontend** () inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

...

public **setFrontend** (*mixed* $frontend) inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

...

public **getOptions** () inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

...

public **setOptions** (*mixed* $options) inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

...

public **getLastKey** () inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

...

public **setLastKey** (*mixed* $lastKey) inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

...

public **__construct** ([Phalcon\Cache\FrontendInterface](/en/3.2/api/Phalcon_Cache_FrontendInterface) $frontend, [*array* $options]) inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

Phalcon\\Cache\\Backend constructor

public *mixed* **start** (*int* | *string* $keyName, [*int* $lifetime]) inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

Starts a cache. The keyname allows to identify the created fragment

public **stop** ([*mixed* $stopBuffer]) inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

Stops the frontend without store any cached content

public **isFresh** () inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

Checks whether the last cache is fresh or cached

public **isStarted** () inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

Checks whether the cache has starting buffering or not

public *int* **getLifetime** () inherited from [Phalcon\Cache\Backend](/en/3.2/api/Phalcon_Cache_Backend)

Gets the last lifetime set