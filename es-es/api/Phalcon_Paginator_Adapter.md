* * *

layout: article language: 'es-es' version: '4.0' title: 'Phalcon\Paginator\Adapter'

* * *

# Abstract class **Phalcon\Paginator\Adapter**

*implements* [Phalcon\Paginator\AdapterInterface](/4.0/en/api/Phalcon_Paginator_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/paginator/adapter.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

## Métodos

public **setCurrentPage** (*mixed* $page)

Establecer el número de página actual

public **setLimit** (*mixed* $limitRows)

Establecer límite de filas

public **getLimit** ()

Obtener el límite actual de filas

abstract public **getPaginate** () inherited from [Phalcon\Paginator\AdapterInterface](/4.0/en/api/Phalcon_Paginator_AdapterInterface)

...