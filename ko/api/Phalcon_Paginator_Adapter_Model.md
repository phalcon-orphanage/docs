# Class **Phalcon\\Paginator\\Adapter\\Model**

*extends* abstract class [Phalcon\Paginator\Adapter](/[[language]]/[[version]]/api/Phalcon_Paginator_Adapter)

*implements* [Phalcon\Paginator\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Paginator_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/paginator/adapter/model.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This adapter allows to paginate data using a Phalcon\\Mvc\\Model resultset as a base.

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

## Methods

public **__construct** (*array* $config)

Phalcon\\Paginator\\Adapter\\Model constructor

public **getPaginate** ()

Returns a slice of the resultset to show in the pagination

public **setCurrentPage** (*mixed* $page) inherited from [Phalcon\Paginator\Adapter](/[[language]]/[[version]]/api/Phalcon_Paginator_Adapter)

Set the current page number

public **setLimit** (*mixed* $limitRows) inherited from [Phalcon\Paginator\Adapter](/[[language]]/[[version]]/api/Phalcon_Paginator_Adapter)

Set current rows limit

public **getLimit** () inherited from [Phalcon\Paginator\Adapter](/[[language]]/[[version]]/api/Phalcon_Paginator_Adapter)

Get current rows limit