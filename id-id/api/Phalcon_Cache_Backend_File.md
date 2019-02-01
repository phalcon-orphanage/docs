---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cache\Backend\File'
---
# Class **Phalcon\Cache\Backend\File**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/file.zep)

Memungkinkan fragmen keluaran cache menggunakan file backend

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

## Metode

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, *array* $options)

Phalcon\Cache\Backend\File constructor

publik **dapat** (*campuran* $keyName, [*campuran* $lifetime])

Mengembalikan konten dalam cache

publik **simpan** ([*int* | *rangkaian* $keyName], [* rangkaian* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Menyimpan isi cache ke file backend dan menghentikan frontend

publik **hapus** (*int* | *string* $keyName)

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

Memeriksa apakah cache ada dan tidak kedaluwarsa

publik **kenaikan** ([*string* | *int* $keyName], [*mixed* $value])

Kenaikan kunci yang diberikan, dengan nilai $ harga

public **decrement** ([*string* | *int* $keyName], [*mixed* $value])

Penurunan kunci yang diberikan, dengan nilai $value

publik **flush** ()

Segera batalkan semua item yang ada.

public **getKey** (*mixed* $key)

Kembalikan pengenal berkas-sistem yang aman untuk kunci yang diberikan

public **useSafeKey** (*mixed* $useSafeKey)

Tetapkan apakah akan menggunakan safekey atau tidak

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