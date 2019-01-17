* * *

layout: article language: 'es-es' version: '4.0' title: 'Phalcon\Paginator\Adapter\NativeArray'

* * *

# Class **Phalcon\Paginator\Adapter\NativeArray**

*extends* abstract class [Phalcon\Paginator\Adapter](/4.0/en/api/Phalcon_Paginator_Adapter)

*implements* [Phalcon\Paginator\AdapterInterface](/4.0/en/api/Phalcon_Paginator_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/paginator/adapter/nativearray.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

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

public **setCurrentPage** (*mixed* $page) inherited from [Phalcon\Paginator\Adapter](/4.0/en/api/Phalcon_Paginator_Adapter)

Establecer el número de página actual

public **setLimit** (*mixed* $limitRows) inherited from [Phalcon\Paginator\Adapter](/4.0/en/api/Phalcon_Paginator_Adapter)

Establecer límite de filas

public **getLimit** () inherited from [Phalcon\Paginator\Adapter](/4.0/en/api/Phalcon_Paginator_Adapter)

Obtener el límite actual de filas