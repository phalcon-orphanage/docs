---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Igbinary'
---
# Class **Phalcon\Cache\Frontend\Igbinary**

*extends* class [Phalcon\Cache\Frontend\Data](Phalcon_Cache_Frontend_Data)

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/igbinary.zep)

Memungkinkan untuk cache data PHP asli dalam bentuk serial menggunakan ekstensi igbinary

```php
<? php / / Cache file selama 2 hari menggunakan Igbinary frontend$frontCache baru \Phalcon\Cache\Frontend\Igbinary = (["seumur hidup" = > 172800,]);  Membuat komponen yang akan cache "Igbinary" untuk backend "File" / / Set direktori file cache - penting untuk menjaga "/" pada akhir / / nilai untuk folder$cache baru \Phalcon\Cache\Backend\File = ($frontCache, ["cacheDir" = > "... /App/cache / ",]);$cacheKey = "robots_order_id.cache";  Mencoba untuk mendapatkan catatan cache$robots = $cache -> get($cacheKey);  Jika ($robots === null) {/ / $robots null karena cache kedaluwarsa atau data tidak ada / / membuat database panggilan dan mengisi $robots variabel = Robots::find (["order" = > "id",]);      Toko di cache $cache -> Simpan ($cacheKey, $robots); } / / Menggunakan foreach ($robots sebagai $robot) $robots :) {echo $robot -> nama, "\n";}

```

## Metode

umum **__membangun** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Data constructor

publik ** getLifetime ** ()

Mengembalikan masa pakai cache

public ** isBuffering ** ()

Periksa apakah frontend adalah buffering output

publik ** mulai ** ()

Starts output frontend. Actually, does nothing

public *string * **getContent** ()

Mengembalikan hasil konten dalam cache

publik ** berhenti ** ()

Menghentikan output frontend

public ** beforeStore ** ( * mixed * $data)

Serializes data sebelum menyimpannya

public ** afterRetrieve ** ( * mixed * $data)

Unserializes data setelah pengambilan