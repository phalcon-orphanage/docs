# Clase abstracta **Phalcon\\Paginator\\Adapter**

*implementa* [Phalcon\Paginator\AdapterInterface](/en/3.2/api/Phalcon_Paginator_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/paginator/adapter.zep" class="btn btn-default btn-sm">Codigo fuente en GitHub</a>

## Métodos

public **setCurrentPage** (*mixed* $page)

Establecer el número de página actual

public **setLimit** (*mixed* $limitRows)

Establecer límite de filas

public **getLimit** ()

Obtener el límite actual de filas

abstract public **getPaginate** () inherited from [Phalcon\Paginator\AdapterInterface](/en/3.2/api/Phalcon_Paginator_AdapterInterface)

...