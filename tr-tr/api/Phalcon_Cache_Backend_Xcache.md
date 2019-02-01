---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Cache\Backend\Xcache'
---
# Class **Phalcon\Cache\Backend\Xcache**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/xcache.zep)

Allows to cache output fragments, PHP data and raw data using an XCache backend

```php
<?php

use Phalcon\Cache\Backend\Xcache;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cache data for 2 days
$frontCache = new FrontData(
    [
       "lifetime" => 172800,
    ]
);

$cache = new Xcache(
    $frontCache,
    [
        "prefix" => "app-data",
    ]
);

// Cache arbitrary data
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Get data
$data = $cache->get("my-data");

```

## Metodlar

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend\Xcache constructor

public **get** (*mixed* $keyName, [*mixed* $lifetime])

Ön bellekte saklanan içeriği döndürür

public **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Önbellek içeriğini dosya arka ucuna depolar ve önden yüklenmesini durdurur

public *boolean* **delete** (*int* | *string* $keyName)

Ön bellekteki bir değeri anahtarı ile birlikte siler

public **queryKeys** ([*mixed* $prefix])

Varolan bekletilmiş anahtarları sorgulayın.

```php
<?php

$cache->save("users-ids", [1, 2, 3]);
$cache->save("projects-ids", [4, 5, 6]);

var_dump($cache->queryKeys("users")); // ["users-ids"]

```

herkese açık **var** ([dizi</em> $anahtar adı], [*int* $ömür])

Ön bellekte olup olmadığını ve süresinin dolup dolmadığını denetler

public **increment** (*string* $keyName, [*mixed* $value])

Verilen bir anahtarın sayıya göre $value çok küçük artması

public **decrement** (*string* $keyName, [*mixed* $value])

Verilen bir anahtarın sayıya göre $value çok küçük azalması

public **flush** ()

Mevcut öğelerin tümünü geçersiz kılar.

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

Starts a cache. The keyname allows to identify the created fragment

public **stop** ([*mixed* $stopBuffer]) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Herhangi bir önbelleklenmiş içerik depolamadan ön yüzü durdurur

public **isFresh** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Son önbelleğin yeni ya da önbelleklenmiş olup olmadığını kontrol eder

public **isStarted** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Ön belleğin ara belleğe aktarımına başlamış olup olmadığını denetler

public *int* **getLifetime** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Son çalışma zamanı ayarını getir