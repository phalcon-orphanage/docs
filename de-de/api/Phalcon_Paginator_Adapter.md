---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Paginator\Adapter'
---
# Abstract class **Phalcon\Paginator\Adapter**

*implements* [Phalcon\Paginator\AdapterInterface](Phalcon_Paginator_AdapterInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/paginator/adapter.zep)

## Methoden

public **setCurrentPage** (*mixed* $page)

Legen Sie die aktuelle Seitenzahl fest

public **setLimit** (*mixed* $limitRows)

Legt die maximale Anzahl Zeilen pro Seite fest

public **getLimit** ()

Gibt die maximale Anzahl Zeilen pro Seite zurück

abstract public **getPaginate** () inherited from [Phalcon\Paginator\AdapterInterface](Phalcon_Paginator_AdapterInterface)

...