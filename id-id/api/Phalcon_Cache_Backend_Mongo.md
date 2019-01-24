---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cache\Belakang\Mongo'
---
# Class **Phalcon\Cache\Backend\Mongo**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/mongo.zep)

Memungkinkan cache fragmen cache, data PHP atau data mentah ke reden backend

```php
<?php

gunakan Phalcon\Cache\Backend\Apc;
gunakan Phalcon\Cache\Frontend\Data as FrontData;

// Cache data untuk 2 hari
$frontCache = Tampilan data terbaru(
    [
        "masaberlaku" => 172800,
    ]
);

$cache = Aplikasi baru(
    $frontCache,
    [
        "diawal" => "data-app",
    ]
);

// Cache arbitrary data
$cache->simpan("data-saya", [1, 2, 3, 4, 5]);

// Dapatkan data
$data = $cache->dapatkan("data saya");

```

## Metode

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend\Mongo constructor

final dilindungi *MongoCollection* **_getCollection**)

Mengembalikan koleksi MongoDb berdasarkan parameter backend

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

umum *collection->remove(...)* **Gc** ()

gc

public **increment** ([*string* | *int* $keyName], [*mixed* $value])

Penurunan kunci yang diberikan sebesar $value

public **increment** ([*string* | *int* $keyName], [*mixed* $value])

Penurunan kunci yang diberikan sebesar $value

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