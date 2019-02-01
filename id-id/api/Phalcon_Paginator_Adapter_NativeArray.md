---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Paginator\Adapter\NativeArray'
---
# Class **Phalcon\Paginator\Adapter\NativeArray**

*extends* abstract class [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

*implements* [Phalcon\Paginator\AdapterInterface](Phalcon_Paginator_AdapterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/paginator/adapter/nativearray.zep)

Pagination menggunakan array PHP sebagai sumber data

```php
<?php

use Phalcon\Paginator\Adapter\NativeArray;

$paginator = new NativeArray(
    [
        "data"  => [
            ["id" => 1, "name" => "Artichoke"],
            ["id" => 2, "name" => "Carrots"],
            ["id" => 3, "name" => "Beet"],
            ["id" => 4, "name" => "Lettuce"],
            ["id" => 5, "name" => ""],
        ],
        "limit" => 2,
        "page"  => $currentPage,
    ]
);

```

## Metode

public **__construct** (*array* $config)

Phalcon\Paginator\Adapter\NativeArray constructor

public **getPaginate** ()

Mengembalikan sepotong hasil untuk ditampilkan dalam pagination

public **setCurrentPage** (*mixed* $page) inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

Setel nomor halaman saat ini

public **setLimit** (*mixed* $limitRows) inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

Tetapkan batas baris saat ini

public **getLimit** () inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

Dapatkan batas baris sekarang