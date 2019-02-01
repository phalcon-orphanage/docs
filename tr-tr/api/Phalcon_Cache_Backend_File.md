---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Cache\Backend\File'
---
# Class **Phalcon\Cache\Backend\File**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/file.zep)

Bir dosya arka planı kullanarak çıktı parçalarını önbelleğe almaya izin verir

```php
<?php

use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Frontend\Output as FrontOutput;

// Cache the file for 2 days
$frontendOptions = [
    "lifetime" => 172800,
];

// Create an output cache
$frontCache = FrontOutput($frontOptions);

// Set the cache directory
$backendOptions = [
    "cacheDir" => "../app/cache/",
];

// Create the File backend
$cache = new File($frontCache, $backendOptions);

$content = $cache->start("my-cache");

if ($content === null) {
    echo "<h1>", time(), "</h1>";

    $cache->save();
} else {
    echo $content;
}

```

## Metodlar

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, *array* $options)

Phalcon\Cache\Backend\File constructor

public **get** (*mixed* $keyName, [*mixed* $lifetime])

Ön bellekte saklanan içeriği döndürür

public **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Önbellek içeriğini dosya arka ucuna depolar ve önden yüklenmesini durdurur

public **delete** (*int* | *string* $keyName)

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

Ön bellekte olup olmadığını ve süresinin dolup dolmadığını denetler

public **increment** ([*string* | *int* $keyName], [*mixed* $value])

Verilen bir anahtarın sayıya göre artması $value

public **decrement** ([*string* | *int* $keyName], [*mixed* $value])

Decrement of a given key, by number $value

public **flush** ()

Mevcut öğelerin tümünü geçersiz kılar.

public **getKey** (*mixed* $key)

Belirli bir anahtarın güvenli bir dosya sistemi tanımlayıcısını döndürür

public **useSafeKey** (*mixed* $useSafeKey)

Güvenli anahtarı kullanıp kullanmamayı ayarla

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