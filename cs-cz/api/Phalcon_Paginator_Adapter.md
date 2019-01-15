* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Paginator\Adapter'

* * *

# Abstract class **Phalcon\Paginator\Adapter**

*implements* [Phalcon\Paginator\AdapterInterface](/4.0/en/api/Phalcon_Paginator_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/paginator/adapter.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods

public **setCurrentPage** (*mixed* $page)

Set the current page number

public **setLimit** (*mixed* $limitRows)

Set current rows limit

public **getLimit** ()

Get current rows limit

abstract public **getPaginate** () inherited from [Phalcon\Paginator\AdapterInterface](/4.0/en/api/Phalcon_Paginator_AdapterInterface)

...