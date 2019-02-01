---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Json'
---
# Class **Phalcon\Cache\Frontend\None**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/none.zep)

Discards any kind of frontend data input. This frontend does not have expiration time or any other options

```php
<? php / / Cache file selama 2 hari menggunakan Igbinary frontend$frontCache baru \Phalcon\Cache\Frontend\Igbinary = (["seumur hidup" = > 172800,]);  Membuat komponen yang akan cache "Igbinary" untuk backend "File" / / Set direktori file cache - penting untuk menjaga "/" pada akhir / / nilai untuk folder$cache baru \Phalcon\Cache\Backend\File = ($frontCache, ["cacheDir" = > "... /App/cache / ",]);$cacheKey = "robots_order_id.cache";  Mencoba untuk mendapatkan catatan cache$robots = $cache -> get($cacheKey);  Jika ($robots === null) {/ / $robots null karena cache kedaluwarsa atau data tidak ada / / membuat database panggilan dan mengisi $robots variabel = Robots::find (["order" = > "id",]);      Toko di cache $cache -> Simpan ($cacheKey, $robots); } / / Menggunakan foreach ($robots sebagai $robot) $robots :) {echo $robot -> nama, "\n";}

```

## Metode

publik ** getLifetime ** ()

Mengembalikan masa pakai cache, selalu konten kedaluwarsa kedua

public ** isBuffering ** ()

Periksa apakah frontend adalah buffering output

publik ** mulai ** ()

Menghentikan keluaran paling depan

public *string * **getContent** ()

Mengembalikan hasil konten dalam cache

publik ** berhenti ** ()

Menghentikan output frontend

public ** beforeStore ** ( * mixed * $data)

Mempersiapkan data-data untuk disimpan

public ** afterRetrieve ** ( * mixed * $data)

Siapkan data yang akan diambil ke pengguna