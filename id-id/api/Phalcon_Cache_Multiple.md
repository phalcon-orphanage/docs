---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cache\Multiple'
---
# Class **Phalcon\Cache\Multiple**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/multiple.zep)

Memungkinkan untuk membaca untuk adaptor backend yang dirantai untuk menulis ke beberapa backends

```php
<?php

Gunakan Phalcon\Cache\Frontend\Data sebagai DataFrontend;
Gunakan Phalcon\Cache\Multiple;
Gunakan Phalcon\Cache\Backend\Apc sebagai ApcCache;
Gunakan Phalcon\Cache\Backend\Memcache sebagai MemcacheCache;
Gunakan Phalcon\Cache\Backend\File sebagai FileCache;

$ultraFastFrontend = Data baruFrontend(
    [
        "lifetime" => 3600,
    ]
);

$fastFrontend = Data baruFrontend(
    [
        "lifetime" => 86400,
    ]
);

$slowFrontend = Data baruFrontend(
    [
        "lifetime" => 604800,
    ]
);

//Backends terdaftar dari yang tercepat ke yang lebih lambat
$cache = new Multiple(
    [
        new ApcCache(
            $ultraFastFrontend,
            [
                "prefix" => "cache",
            ]
        ),
        new MemcacheCache(
            $fastFrontend,
            [
                "prefix" => "cache",
                "host"   => "localhost",
                "port"   => "11211",
            ]
        ),
        new FileCache(
            $slowFrontend,
            [
                "prefix"   => "cache",
                "cacheDir" => "../app/cache/",
            ]
        ),
    ]
);

//Simpan, simpan di setiap backend
$cache->save("my-key", $data);

```

## Metode

public **__construct** ([[Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface) $backends])

Phalcon\Cache\Multiple constructor

public **push** ([Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface) $backend)

Menambahkan backend

public * mixed </ 0> ** dapatkan </ 1> (* string </ 0> | * int 0 $ keyName, [<0 int </ 0> $ lifetime</p> 

Mengembalikan konten dalam cache yang membaca backends internal

public ** mulai </ 0> (* string </ 1> * int </ 1> $ keyname, [* int </ 1> $ lifetime</p> 

Mulai setiap backend

public **simpan** ([int | *string* $keyName], [* string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Menyimpan konten dalam cache ke semua backend dan menghentikan frontend

public *boolean* **hapus** (*string* | *int* $keyName)

Menghapus nilai dari masing-masing backend

publik **ada** ([*jaringan* | *int* $keyName], [*int* $lifetime])

Memeriksa apakah cache ada setidaknya satu backend

publik **flush** ()

Flush semua backend (s)