---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cache\Backend\Libmemcached'
---
# Class **Phalcon\Cache\Backend\Libmemcached**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/libmemcached.zep)

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

## Metode

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend\Memcache constructor

publik **_connect** ()

Buat koneksi internal ke memcached

publik **dapat** (*campuran* $keyName, [*campuran* $lifetime])

Mengembalikan konten dalam cache

publik **simpan** ([*int* | *rangkaian* $keyName], [* rangkaian* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Menyimpan isi cache ke file backend dan menghentikan frontend

public *boolean* **hapus** (*int* | *string* $keyName)

Menghapus nilai dari cache dengan kuncinya

publik **Kunci kueri** ([*campuran* $prefix])

Permintaan kunci cache yang ada.

```php
<?php

$cache->simpan("para pengguna-ids", [1, 2, 3]);
$cache->simpan("Rancangan-ids", [4, 5, 6]);

var_dump($cache->Kunci kueri ("Para Pengguna")); // ["Para pengguna-ids"]

```

publik **ada** ([*string* $keyName], [*int* $lifetime])

Memeriksa apakah cache ada dan tidak kedaluwarsa

public **kenaikan** ([*sejajar* $keyName], [*campuran* $value])

Kenaikan yang diberikan $keyName dari $value

publik **penurunan** ([*jaringan* $keyName], [<1campuran</em> $value])

Pengurangan $keyName dengan diberikan $value

publik **flush** ()

Segera batalkan semua item yang ada. Memcached tidak mendukung flush() per default. Jika Anda membutuhkan flush(), mendukung, set $config["statsKey"]. Semua kunci yang diubah disimpan di "statsKey". Catatan: statsKey memiliki dampak negatif pada kinerja.

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

Starts a cache. The keyname allows to identify the created fragment

public **stop** ([*mixed* $stopBuffer]) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Menghentikan frontend tanpa menyimpan konten dalam cache

public **isFresh** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Memeriksa apakah cache terakhir masih segar atau di-cache

public **isStarted** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Memeriksa apakah cache sudah mulai buffering atau tidak

public *int* **getLifetime** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Dapat di set seumur hidup