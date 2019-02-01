---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cache\Backend\Apc'
---
# Class **Phalcon\Cache\Backend\Apc**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/apc.zep)

Memungkinkan untuk cache fragmen output, data PHP dan data mentah menggunakan backend APC

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

publik **dapat** (*campuran* $keyName, [*campuran* $lifetime])

Mengembalikan konten dalam cache

publik **simpan** ([*sejajar* | *int* $keyName], [*sejajar* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Menyimpan isi cache ke dalam APC backend dan menghentikan frontend

public **kenaikan** ([*sejajar* $keyName], [*campuran* $value])

Kenaikan kunci yang diberikan, dengan nilai $ harga

publik **penurunan** ([*jaringan* $keyName], [<1campuran</em> $value])

Penurunan kunci yang diberikan, dengan nilai $value

publik **hapus** (*campuran* $keyName)

Menghapus nilai dari cache dengan kuncinya

publik **Kunci kueri** ([*campuran* $prefix])

Permintaan kunci cache yang ada.

```php
<?php

$cache->simpan("para pengguna-ids", [1, 2, 3]);
$cache->simpan("Rancangan-ids", [4, 5, 6]);

var_dump($cache->Kunci kueri ("Para Pengguna")); // ["Para pengguna-ids"]

```

publik **ada** ([*jaringan* | *int* $keyName], [*int* $lifetime])

Memeriksa apakah cache ada dan belum kedaluwarsa

publik **flush** ()

Segera batalkan semua item yang ada.

```php
<?php

gunakan Phalcon\Cache\Backend\Apc;

$cache = Apc baru($frontCache, ["diawal" => "app-data"]);

$cache->simpan("Data saya", [1, 2, 3, 4, 5]);

// data saya' dan Seluruh kunci yang pernah digunakan terhapus.
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

Menghentikan frontend tanpa menyimpan konten dalam cache

public **isFresh** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Memeriksa apakah cache terakhir masih segar atau di-cache

public **isStarted** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Memeriksa apakah cache sudah mulai buffering atau tidak

public *int* **getLifetime** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

Dapat di set seumur hidup