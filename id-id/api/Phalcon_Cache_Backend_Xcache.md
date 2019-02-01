---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cache\Belakang\Xcache'
---
# Class **Phalcon\Cache\Backend\Xcache**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/xcache.zep)

Memungkinkan untuk cache fragmen output, PHP data atau data mentah ke memcache backend

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

## Metode

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend\Xcache constructor

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

publik **kenaikan** (*rangkaian* $keyName, [*campuran* $value])

Kenaikan kunci yang diberikan, dengan nilai $value

publik **pengurangan** (*rangkaian* $keyName, [*campuran* $value])

Kenaikan kunci yang diberikan, dengan nilai $ harga

publik **flush** ()

Segera batalkan semua item yang ada.

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