---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Paginator\Adapter'
---
# Abstract class **Phalcon\Paginator\Adapter**

*implements* [Phalcon\Paginator\AdapterInterface](Phalcon_Paginator_AdapterInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/paginator/adapter.zep)

## Métodos

public **setCurrentPage** (*mixed* $page)

Establecer el número de página actual

public **setLimit** (*mixed* $limitRows)

Establecer límite de filas

public **getLimit** ()

Obtener el límite actual de filas

abstract public **getPaginate** () inherited from [Phalcon\Paginator\AdapterInterface](Phalcon_Paginator_AdapterInterface)

...