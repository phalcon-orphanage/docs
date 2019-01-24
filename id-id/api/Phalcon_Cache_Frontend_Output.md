---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Output'
---
# Class **Phalcon\Cache\Frontend\Output**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/output.zep)

Memungkinkan fragmen keluaran cache ditangkap dengan fungsi ob

php <?php

* * Gunakan Phalcon\Tag; * Gunakan Phalcon\Cache\Backend\File; * Gunakan Phalcon\Cache\Frontend\Output; * *Buat frontend Output. Cache file selama 2 hari $frontCache = Output baru "seumur hidup" => 172800, Membuat komponen yang akan cache dari "Output" ke "File" backend * Set direktori file cache - sangat penting untuk menjaga "/" pada akhir nilai untuk folder * $cache = File baru (* $frontCache, * [* "cacheDir" =>"... /App/cache /Mendapatkan/Set cache file... /App/cache/My-cache.html * $content = $cache->start my-cache.html /Jika $content null maka konten akan dihasilkan untuk cache * jika (null $content) {* / / Print tanggal dan waktu * echo date("r"); ** / / menghasilkan link ke tindakan sign-up * echo Tag::linkTo (* [* "pengguna/signup", * "Sign Up", * "kelas" => "signup-tombol", *] *); ** / / Menyimpan output ke cache file * $cache->save(); *} lain {* / / Echo output cache * echo $content; *}

* `` `

## Metode

umum **__membangun** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Output constructor

publik ** getLifetime ** ()

Mengembalikan masa pakai cache

public ** isBuffering ** ()

Periksa apakah frontend adalah buffering output

publik ** mulai ** ()

Starts output frontend. Currently, does nothing

public *string * **getContent** ()

Mengembalikan hasil konten dalam cache

publik ** berhenti ** ()

Menghentikan output frontend

public ** beforeStore ** ( * mixed * $data)

Serializes data sebelum menyimpannya

public ** afterRetrieve ** ( * mixed * $data)

Unserializes data setelah pengambilan