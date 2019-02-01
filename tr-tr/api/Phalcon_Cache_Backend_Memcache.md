---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Cache\Backend\Memcache'
---
# Class **Phalcon\Cache\Backend\Memcache**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/memcache.zep)

Allows to cache output fragments, PHP data or raw data to a memcache backend

Bu bağdaştırıcı, özel olarak belirtilen memcached anahtarı "_PHCM" kullanarak, bağdaştırıcı tarafından dahili olarak kullanılan tüm anahtarları depolar

```php
<?php

use Phalcon\Cache\Backend\Memcache;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cache data for 2 days
$frontCache = new FrontData(
    [
        "lifetime" => 172800,
    ]
);

// Create the Cache setting memcached connection options
$cache = new Memcache(
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

## Metodlar

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend\Memcache constructor

public **_connect** ()

Memcached'a iç bağlantı oluştur

public **addServers** (*mixed* $host, *mixed* $port, [*mixed* $persistent])

Memcache havuzuna sunucular ekleyin

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

public **increment** ([*string* $keyName], [*mixed* $value])

Increment of given $keyName by $value

public **decrement** ([*string* $keyName], [*mixed* $value])

Verilen $value ile $keyName azalması

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