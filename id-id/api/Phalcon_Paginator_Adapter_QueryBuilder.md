* * *

<<<<<<< HEAD
layout: default language: 'en' version: '4.0' title: 'Phalcon\Paginator\Adapter\QueryBuilder'
=======
layout: article language: 'en' version: '4.0' title: 'Phalcon\Paginator\Adapter\QueryBuilder'
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

* * *

# Class **Phalcon\Paginator\Adapter\QueryBuilder**

<<<<<<< HEAD
*extends* abstract class [Phalcon\Paginator\Adapter](/3.4/en/api/Phalcon_Paginator_Adapter)

*implements* [Phalcon\Paginator\AdapterInterface](/3.4/en/api/Phalcon_Paginator_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/paginator/adapter/querybuilder.zep" class="btn btn-default btn-sm">Source on GitHub</a>
=======
*extends* abstract class [Phalcon\Paginator\Adapter](/4.0/en/api/Phalcon_Paginator_Adapter)

*implements* [Phalcon\Paginator\AdapterInterface](/4.0/en/api/Phalcon_Paginator_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/paginator/adapter/querybuilder.zep" class="btn btn-default btn-sm">Source on GitHub</a>
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

Pagination using a PHQL query builder as source of data

```php
<?php

use Phalcon\Paginator\Adapter\QueryBuilder;

$builder = $this->modelsManager->createBuilder()
                ->columns("id, name")
                ->from("Robots")
                ->orderBy("name");

$paginator = new QueryBuilder(
    [
        "builder" => $builder,
        "limit"   => 20,
        "page"    => 1,
    ]
);

```

## Methods

public **__construct** (*array* $config)

public **getCurrentPage** ()

Get the current page number

<<<<<<< HEAD
public **setQueryBuilder** ([Phalcon\Mvc\Model\Query\Builder](/3.4/en/api/Phalcon_Mvc_Model_Query_Builder) $builder)
=======
public **setQueryBuilder** ([Phalcon\Mvc\Model\Query\Builder](/4.0/en/api/Phalcon_Mvc_Model_Query_Builder) $builder)
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

Set query builder object

public **getQueryBuilder** ()

Get query builder object

public **getPaginate** ()

Returns a slice of the resultset to show in the pagination

<<<<<<< HEAD
public **setCurrentPage** (*mixed* $page) inherited from [Phalcon\Paginator\Adapter](/3.4/en/api/Phalcon_Paginator_Adapter)

Set the current page number

public **setLimit** (*mixed* $limitRows) inherited from [Phalcon\Paginator\Adapter](/3.4/en/api/Phalcon_Paginator_Adapter)

Set current rows limit

public **getLimit** () inherited from [Phalcon\Paginator\Adapter](/3.4/en/api/Phalcon_Paginator_Adapter)
=======
public **setCurrentPage** (*mixed* $page) inherited from [Phalcon\Paginator\Adapter](/4.0/en/api/Phalcon_Paginator_Adapter)

Set the current page number

public **setLimit** (*mixed* $limitRows) inherited from [Phalcon\Paginator\Adapter](/4.0/en/api/Phalcon_Paginator_Adapter)

Set current rows limit

public **getLimit** () inherited from [Phalcon\Paginator\Adapter](/4.0/en/api/Phalcon_Paginator_Adapter)
>>>>>>> 73fa73b040c87e5bc28ac848a5de044aaa9774c5

Get current rows limit