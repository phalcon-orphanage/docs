---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Cache\Multiple'
---
# Class **Phalcon\Cache\Multiple**

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/multiple.zep)

Birden çok arka plana yazılmış zincirleme arka uç bağdaştırıcılarını okumaya izin verir

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

## Metodlar

public **__construct** ([[Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface) $backends])

Phalcon\Cache\Multiple constructor

public **push** ([Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface) $backend)

Bir arka uç ekler

public *mixed* **get** (*string* | *int* $keyName, [*int* $lifetime])

Dahili arka yüzleri okuyan önbelleklenmiş bir içerik döner

public **start** (*string* | *int* $keyName, [*int* $lifetime])

Her arka planı başlatır

yerel **kaydet** ([*dizi* $keyName], [*dizi* $content], [*int* $lifetime], [*booledeğeri* $stopBuffer])

Önbelleğe alınan içeriği tüm arka uçlara depolar ve ön ucu durdurur

public *boolean* **delete** (*string* | *int* $keyName)

Her arka planda bir değeri siler

public **exists** ([*string* | *int* $keyName], [*int* $lifetime])

Önbelleğin en az bir arka yüzde var olup olmadığını kontrol eder

public **flush** ()

Flush all backend(s)