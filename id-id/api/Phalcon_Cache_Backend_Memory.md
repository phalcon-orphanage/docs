---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cache\Belakang\Memory'
---
# Class **Phalcon\Cache\Backend\Memory**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface), [Serializable](https://php.net/manual/en/class.serializable.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/backend/memory.zep)

Stores content in memory. Data is lost when the request is finished

```php
<?php

use Phalcon\Cache\Backend\Memory;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cache data
$frontCache = new FrontData();

$cache = new Memory($frontCache);

// Cache arbitrary data
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Get data
$data = $cache->get("my-data");

```

## Metode

publik **dapat** (*campuran* $keyName, [*campuran* $lifetime])

Mengembalikan konten dalam cache

public **simpan** ([int | *string* $keyName], [* string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Menyimpan isi cache ke dalam Apc backend dan menghentikan frontend

public *boolean* **hapus** (*string* | *int* $keyName)

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

public **kenaikan** ([*sejajar* $keyName], [*campuran* $value])

Kenaikan yang diberikan $keyName dari $value

publik **penurunan** ([*jaringan* $keyName], [<1campuran</em> $value])

Pengurangan $keyName dengan diberikan $value

publik **flush** ()

Segera batalkan semua item yang ada.

publik **getName** ()

Required for interface \Serializable

public ** beforeStore ** ( * mixed * $data)

Required for interface \Serializable

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