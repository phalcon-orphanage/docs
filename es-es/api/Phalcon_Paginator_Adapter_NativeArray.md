---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Paginator\Adapter\NativeArray'
---
# Class **Phalcon\Paginator\Adapter\NativeArray**

*extends* abstract class [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

*implements* [Phalcon\Paginator\AdapterInterface](Phalcon_Paginator_AdapterInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/paginator/adapter/nativearray.zep)

Pagination using a PHP array as source of data

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

## Métodos

public **__construct** (*array* $config)

Phalcon\Paginator\Adapter\NativeArray constructor

public **getPaginate** ()

Returns a slice of the resultset to show in the pagination

public **setCurrentPage** (*mixed* $page) inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

Establecer el número de página actual

public **setLimit** (*mixed* $limitRows) inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

Establecer límite de filas

public **getLimit** () inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

Obtener el límite actual de filas