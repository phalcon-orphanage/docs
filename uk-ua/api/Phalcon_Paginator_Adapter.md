---
layout: default
language: 'uk-ua'
version: '4.0'
title: 'Phalcon\Paginator\Adapter'
---
# Abstract class **Phalcon\Paginator\Adapter**

*implements* [Phalcon\Paginator\AdapterInterface](Phalcon_Paginator_AdapterInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/paginator/adapter.zep)

## Methods

public **setCurrentPage** (*mixed* $page)

Set the current page number

public **setLimit** (*mixed* $limitRows)

Set current rows limit

public **getLimit** ()

Get current rows limit

abstract public **getPaginate** () inherited from [Phalcon\Paginator\AdapterInterface](Phalcon_Paginator_AdapterInterface)

...