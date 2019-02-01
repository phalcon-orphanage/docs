---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Msgpack'
---
# Class **Phalcon\Cache\Frontend\Msgpack**

*extends* class [Phalcon\Cache\Frontend\Data](Phalcon_Cache_Frontend_Data)

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/msgpack.zep)

Memungkinkan untuk menyimpan data asli PHP dalam bentuk serial menggunakan ekstensi pesan Pack Adaptor ini menggunakan frontend Msgpack untuk menyimpan konten dalam cache dan memerlukan ekstensi pesan.

```php
& lt;? php

gunakan Phalcon \ Cache \ Backend \ File;
gunakan Phalcon \ Cache \ Frontend \ Msgpack;

// Cache file selama 2 hari dengan menggunakan frontend Msgpack
$ frontCache = new Msgpack
     [
         "seumur hidup" = & gt; 172800,
     ]
);

// Buat komponen yang akan men-cache "Msgpack" ke sebuah "File" backend
// Setel direktori file cache - penting untuk menyimpan "/" di penghujung
// dari nilai untuk folder
$ cache = new File (
     $ frontCache,
     [
         "cacheDir" = & gt; "../app/cache/",
     ]
);

$ cacheKey = "robots_order_id.cache";

// Cobalah untuk mendapatkan catatan dalam cache
$ robots = $ cache- & gt; get ($ cacheKey);

jika ($ robots === null) {
     // $ robot dibatalkan karena kadaluwarsa cache atau data tidak ada
     / / Membuat panggilan database dan mengisi variabel
     $ robots = Robot :: temukan (
         [
             "pesanan" = & gt; "id",
         ]
     );

     // simpan di cache
     $ cache- & gt; save ($ cacheKey, $ robots);
}

// Gunakan $ robots
foreach ($ robot sebagai $ robot) {
     echo $ robot- & gt; nama, "\ n";
}

```

## Metode

umum **__membangun** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Msgpack constructor

publik ** getLifetime ** ()

Mengembalikan masa pakai cache

public ** isBuffering ** ()

Periksa apakah frontend adalah buffering output

publik ** mulai ** ()

Starts output frontend. Actually, does nothing

public ** getContent </ 0> ()</p> 

Mengembalikan hasil konten dalam cache

publik ** berhenti ** ()

Menghentikan output frontend

public ** beforeStore ** ( * mixed * $data)

Serializes data sebelum menyimpannya

public ** afterRetrieve ** ( * mixed * $data)

Unserializes data setelah pengambilan