---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Paginator\Adapter\Model'
---
# Class **Phalcon\Paginator\Adapter\Model**

*extends* abstract class [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

*implements* [Phalcon\Paginator\AdapterInterface](Phalcon_Paginator_AdapterInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/paginator/adapter/model.zep)

This adapter allows to paginate data using a Phalcon\Mvc\Model resultset as a base.

```php
<?php

use Phalcon\Paginator\Adapter\Model;

$paginator = new Model(
    [
        "data"  => Robots::find(),
        "limit" => 25,
        "page"  => $currentPage,
    ]
);

$paginate = $paginator->getPaginate();

```

## Methoden

public **__construct** (*array* $config)

Phalcon\Paginator\Adapter\Model constructor

public **getPaginate** ()

Returns a slice of the resultset to show in the pagination

public **setCurrentPage** (*mixed* $page) inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

Legen Sie die aktuelle Seitenzahl fest

public **setLimit** (*mixed* $limitRows) inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

Legt die maximale Anzahl Zeilen pro Seite fest

public **getLimit** () inherited from [Phalcon\Paginator\Adapter](Phalcon_Paginator_Adapter)

Gibt die maximale Anzahl Zeilen pro Seite zurück