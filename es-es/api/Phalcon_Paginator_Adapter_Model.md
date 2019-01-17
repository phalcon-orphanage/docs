* * *

layout: article language: 'es-es' version: '4.0' title: 'Phalcon\Paginator\Adapter\Model'

* * *

# Class **Phalcon\Paginator\Adapter\Model**

*extends* abstract class [Phalcon\Paginator\Adapter](/4.0/en/api/Phalcon_Paginator_Adapter)

*implements* [Phalcon\Paginator\AdapterInterface](/4.0/en/api/Phalcon_Paginator_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/paginator/adapter/model.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

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

## Métodos

public **__construct** (*array* $config)

Phalcon\Paginator\Adapter\Model constructor

public **getPaginate** ()

Returns a slice of the resultset to show in the pagination

public **setCurrentPage** (*mixed* $page) inherited from [Phalcon\Paginator\Adapter](/4.0/en/api/Phalcon_Paginator_Adapter)

Establecer el número de página actual

public **setLimit** (*mixed* $limitRows) inherited from [Phalcon\Paginator\Adapter](/4.0/en/api/Phalcon_Paginator_Adapter)

Establecer límite de filas

public **getLimit** () inherited from [Phalcon\Paginator\Adapter](/4.0/en/api/Phalcon_Paginator_Adapter)

Obtener el límite actual de filas