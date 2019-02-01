---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Paginator\Adapter\QueryBuilder'
---
# Class **Phalcon\Paginator\Adapter\QueryBuilder**

*extends* abstract class [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

*implements* [Phalcon\Paginator\AdapterInterface](Phalcon_Paginator_AdapterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/paginator/adapter/querybuilder.zep)

Pagination menggunakan pembangun query PHQL sebagai sumber data

```php
<?php

use Phalcon\Paginator\Adapter\QueryBuilder;

$builder = $this->modelsManager->createBuilder()
                ->columns("id, name")
                ->from("Robots")
                ->orderBy("name");

$paginator = new QueryBuilder(
    [
        "builder" => $builder,
        "limit"   => 20,
        "page"    => 1,
    ]
);

```

## Metode

public **__construct** (*array* $config)

public **getCurrentPage** ()

Dapatkan nomor halaman saat ini

public **setQueryBuilder** ([Phalcon\Mvc\Model\Query\Builder](Phalcon_Mvc_Model_Query_Builder) $builder)

Setel objek pembangun query

public **getQueryBuilder** ()

Dapatkan query builder object

public **getPaginate** ()

Mengembalikan sepotong hasil untuk ditampilkan dalam pagination

public **setCurrentPage** (*mixed* $page) inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

Setel nomor halaman saat ini

public **setLimit** (*mixed* $limitRows) inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

Tetapkan batas baris saat ini

public **getLimit** () inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

Dapatkan batas baris sekarang