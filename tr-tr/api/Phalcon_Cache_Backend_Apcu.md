---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Cache\Backend\Apcu'
---
# Class **Phalcon\Cache\Backend\Apcu**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/apcu.zep)

Bir APCu arka uç kullanarak çıktı parçalarını, PHP verilerini ve ham verileri önbelleğe almalarını sağlar

```php
<?php

use Phalcon\Cache\Backend\Apcu;
use Phalcon\Cache\Frontend\Data as FrontData;

// 2 günlük önbellek verisi
$frontCache = new FrontData(
    [
        "lifetime" => 172800,
    ]
);

$cache = new Apcu(
    $frontCache,
    [
        "prefix" => "app-data",
    ]
);

// Rastgele önbellek verisi
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Verileri getir
$data = $cache->get("my-data");

```

## Metodlar

public **get** (*mixed* $keyName, [*mixed* $lifetime])

Ön bellekte saklanan içeriği döndürür

public **save** ([*string* | *int* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Önbelleklenmiş içeriği APCu arka yüzünde depolar ve ön yüzü durdurur

public **increment** ([*string* $keyName], [*mixed* $value])

Verilen bir anahtarın sayıya göre artması $value

public **decrement** ([*string* $keyName], [*mixed* $value])

Decrement of a given key, by number $value

public **delete** (*mixed* $keyName)

Ön bellekteki bir değeri anahtarı ile birlikte siler

public **queryKeys** ([*mixed* $prefix])

Varolan bekletilmiş anahtarları sorgulayın.

```php
<?php

$cache->save("users-ids", [1, 2, 3]);
$cache->save("projects-ids", [4, 5, 6]);

var_dump($cache->queryKeys("users")); // ["users-ids"]

```

public **exists** ([*string* | *int* $keyName], [*int* $lifetime])

Ön belleğin var olup olmadığını ve süresinin dolup dolmadığını denetler

public **flush** ()

Mevcut öğelerin tümünü geçersiz kılar.

```php
<?php

use Phalcon\Cache\Backend\Apcu;

$cache = new Apcu($frontCache, ["prefix" => "app-data"]);

$cache->save("my-data", [1, 2, 3, 4, 5]);

// 'my-data' ve kullanılan diğer tüm tuşlar silinir
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

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options]) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Phalcon\Cache\Backend constructor

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