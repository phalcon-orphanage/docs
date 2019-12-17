---
layout: default
language: 'fr-fr'
version: '4.0'
title: 'Pagination'
keywords: 'pagination, model pagination, db pagination, array pagination, query pagination'
---

# Pagination
<hr />
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Vue d'ensemble
A paginator is a component which helps with splitting a large amount of data gradually. An example would be displaying all the posts of a blog, 5 at a time. The Phalcon Paginator accepts parameters and based on those returns the relevant _slice_ of the whole resultset so that the developer can present the paginated data.

 ```php
<?php 

use Phalcon\Paginator\Adapter\NativeArray;

$currentPage = 2;
$paginator   = new NativeArray(
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

$paginate = $paginator->paginate();
 ```

The example above uses an array as the source, and limits the results to 2 records at a time. It will return elements with id `3` and `4` because the `page` has been set to `2`.

## Adapters
For the source of the data, the component uses adapters. It comes with the following adapters:

| Adapter                                                                                           | Description                                                                                                |
| ------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------- |
| [Phalcon\Paginator\Adapter\Model](api/phalcon_paginator#paginator-adapter-model)               | Use a [Phalcon\Mvc\Model\Resultset](api/phalcon_mvc#mvc-model-resultset) object as source data.         |
| [Phalcon\Paginator\Adapter\NativeArray](api/phalcon_paginator#paginator-adapter-nativearray)   | Use a PHP array as source data                                                                             |
| [Phalcon\Paginator\Adapter\QueryBuilder](api/phalcon_paginator#paginator-adapter-querybuilder) | Use a [Phalcon\Mvc\Model\Query\Builder](api/phalcon_mvc#mvc-model-query-builder) object as source data |

> **NOTE**: Since PDO does not support scrollable cursors, [Phalcon\Paginator\Adapter\Model](api/phalcon_paginator#paginator-adapter-model) should not be used to paginate a large number of records 
> 
> {: .alert .alert-warning}


### Méthodes
```php
public function __construct(array $config)
```

Every adapter requires options to operate properly. These options are passed as a key/value array in the constructor of the adapter.

- `builder` - Used only for the [Phalcon\Paginator\Adapter\QueryBuilder](api/phalcon_paginator#paginator-adapter-querybuilder) to pass the builder object
- `data` - The data to paginate. ([Phalcon\Paginator\Adapter\NativeArray](api/phalcon_paginator#paginator-adapter-nativearray) adapter)
- `limit` - `int` - The size of the page slice. If `limit` is negative, an exception will be thrown.
- `model` - The data to paginate. ([Phalcon\Paginator\Adapter\Model](api/phalcon_paginator#paginator-adapter-model) adapter)
- `page` - `int` - The current page
- `repository` - [Phalcon\Paginator\RepositoryInterface](api/phalcon_paginator#paginator-repositoryinterface) - A repository object setting up the resultset. For more about repositories see below.

The methods exposed are:

- `getLimit()` - `int` - Get current rows limit
- `getRepository(array $properties = null)` - `RepositoryInterface` - Gets current repository for pagination
- `setCurrentPage(int $page)` - `AdapterInterface` - Set the current page number
- `setLimit(int $limitRows)` - `AdapterInterface` - Set current rows limit
- `setRepository(RepositoryInterface $repository)` - `AdapterInterface` - Sets current repository for pagination

### Model
The [Phalcon\Paginator\Adapter\Model](api/phalcon_paginator#paginator-adapter-model) adapter uses a [Phalcon\Mvc\Model\Resultset](api/phalcon_mvc#mvc-model-resultset) as the source of the data. This is the result of the `find()` method on a model.

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Paginator\Adapter\Model;

$currentPage = 2;
$paginator   = new Model(
    [
        "model"      => Invoices::class,
        "parameters" => [
            "inv_cst_id = :cst_id:",
              "bind" => [
                  "cst_id" => 1
              ],
              "order" => "inv_title"
        ],
        "limit"      => 25,
        "page"       => $currentPage,
    ]
);

$paginate = $paginator->paginate();
```

The array accepts `model` for the model class to be used. The method `find()` will be called on it. Additionally this adapter can accept `parameters` as the array that `find()` can use with all the relevant conditionals required.

### Array
The [Phalcon\Paginator\Adapter\NativeArray](api/phalcon_paginator#paginator-adapter-nativearray) accepts a PHP array as the source of the data.

```php
<?php

use Phalcon\Paginator\Adapter\NativeArray;

$currentPage = 2;
$paginator   = new NativeArray(
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

$paginate = $paginator->paginate();
```

### Query Builder
The [Phalcon\Paginator\Adapter\QueryBuilder](api/phalcon_paginator#paginator-adapter-querybuilder) adapter uses a [Phalcon\Mvc\Model\Query\Builder](api/phalcon_mvc#mvc-model-query-builder) object to perform a PHQL query against the database.

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Paginator\Adapter\QueryBuilder;

$builder = $this
    ->modelsManager
    ->createBuilder()
    ->columns("inv_id, inv_title")
    ->from(Invoices::class)
    ->orderBy("inv_title");

$paginator = new QueryBuilder(
    [
        "builder" => $builder,
        "limit"   => 20,
        "page"    => 1,
    ]
);

$paginate = $paginator->paginate();
```

## Repository
The `paginate()` method does all the work to paginate the data. It returns a [Phalcon\Paginator\Repository](api/phalcon_paginator#paginator-repository) object which stores all the necessary elements for the pagination. The object exposes the following constants:

- `PROPERTY_CURRENT_PAGE`  = "current";
- `PROPERTY_FIRST_PAGE`    = "first";
- `PROPERTY_ITEMS`         = "items";
- `PROPERTY_LAST_PAGE`     = "last";
- `PROPERTY_LIMIT`         = "limit";
- `PROPERTY_NEXT_PAGE`     = "next";
- `PROPERTY_PREVIOUS_PAGE` = "previous";
- `PROPERTY_TOTAL_ITEMS`   = "total_items";

### Méthodes
The methods exposed are:

- `getAliases()` - `array` - Gets the aliases for properties repository
- `getCurrent()` - `int` - Gets number of the current page
- `getFirst()` - `int` - Gets number of the first page
- `getItems()` - `mixed` - Gets the items on the current page
- `getLast()` - `int` - Gets number of the last page
- `getLimit()` - `int` - Gets current rows limit
- `getNext()` - `int` - Gets number of the next page
- `getPrevious()` - `int` - Gets number of the previous page
- `getTotalItems()` - `int` - Gets the total number of items
- `setAliases(array $aliases)` - `RepositoryInterface` - Sets the aliases for properties repository
- `setProperties(array $properties)` - `RepositoryInterface` - Sets values for properties of the repository

You can access the data by using the methods above or use the magic properties as defined in the constants:

```php
<?php

use Phalcon\Paginator\Adapter\NativeArray;

$currentPage = 2;
$paginator   = new NativeArray(
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

$paginate = $paginator->paginate();

echo $paginate->getCurrent();    // 2
echo $paginate->current     ;    // 2
echo $paginate->getFirst();      // 1
echo $paginate->first;           // 1
var_dump($paginate->getItems());  
// [
//     [
//         'id'   => 3
//         'name' => "Beet",
//     ],
//     [
//         'id'   => 4,
//         'name' => "Lettuce",
//     ]
// ]
var_dump($paginate->getItems());  
echo $paginate->getLast();       // 3
echo $paginate->last;            // 3
echo $paginate->getLimit();      // 2
echo $paginate->limit;           // 2
echo $paginate->getNext();       // 3
echo $paginate->next;            // 3
echo $paginate->getPrevious();   // 1
echo $paginate->previous;        // 1
echo $paginate->getTotalItems(); // 5 
echo $paginate->total_items;     // 5 
```

### Aliases
If you want to use your own names for each magic property the Repository object exposes, you can use the `setAliases()` method to do so.

```php
<?php

use Phalcon\Paginator\Repository;
use Phalcon\Paginator\Adapter\NativeArray;

$repository = = new Repository();
$repository->setAliases(
    [
        'myCurrentPage' => $repository::PROPERTY_CURRENT_PAGE,
        'myFirstPage'   => $repository::PROPERTY_FIRST_PAGE,
        'myLastPage'    => $repository::PROPERTY_LAST_PAGE,
        'myLimit'       => $repository::PROPERTY_LIMIT,
        'myNextPage'    => $repository::PROPERTY_NEXT_PAGE,
        'myTotalItems'  => $repository::PROPERTY_TOTAL_ITEMS,
    ]
);

$currentPage = 2;
$paginator   = new NativeArray(
    [
        "data"       => [
            ["id" => 1, "name" => "Artichoke"],
            ["id" => 2, "name" => "Carrots"],
            ["id" => 3, "name" => "Beet"],
            ["id" => 4, "name" => "Lettuce"],
            ["id" => 5, "name" => ""],
        ],
        "limit"      => 2,
        "page"       => $currentPage,
        'repository' => $repository,
    ]
);

$paginate = $paginator->paginate();

echo $paginate->myCurrentPage;   // 2
echo $paginate->myFirstPage;     // 1
echo $paginate->myLastPage;      // 3
echo $paginate->myLimit;         // 2
echo $paginate->myNextPage;      // 3
echo $paginate->myTotalItems;    // 1
```

You can also create your custom repository class by implementing the [Phalcon\Paginator\RepositoryInterface](api/phalcon_paginator#paginator-repositoryinterface) interface.

## Factory
You can use the Pagination Factory class to instantiate a new paginator object. The names of the services are:

- `model` - [Phalcon\Paginator\Adapter\Model](api/phalcon_paginator#paginator-adapter-model)
- `nativeArray` - [Phalcon\Paginator\Adapter\NativeArray](api/phalcon_paginator#paginator-adapter-nativearray)
- `queryBuilder` - [Phalcon\Paginator\Adapter\QueryBuilder](api/phalcon_paginator#paginator-adapter-querybuilder)

### New Instance
One method that you can use is `newInstance()`:

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Paginator\PaginatorFactory;

$builder = $this
    ->modelsManager
    ->createBuilder()
    ->columns('inv_id, inv_title')
    ->from(Invoices::class)
    ->orderBy('name')
;

$options = [
    'builder' => $builder,
    'limit'   => 20,
    'page'    => 1,
];

$factory   = new PaginatorFactory();
$paginator = $factory->newInstance('queryBuilder');

```

### Load
Loads Paginator Adapter class using `adapter` option. The configuration passed can be an array or a [Phalcon\Config](config) object with the necessary entries for the class to be instantiated.

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Paginator\PaginatorFactory;

$builder = $this
    ->modelsManager
    ->createBuilder()
    ->columns('inv_id, inv_title')
    ->from(Invoices::class)
    ->orderBy('inv_title')
;

$options = [
    'builder' => $builder,
    'limit'   => 20,
    'page'    => 1,
    'adapter' => 'queryBuilder',
];

$paginator = (new PaginatorFactory())->load($options);
```

A sample configuration object is:

```ini
[paginator]
adapter = queryBuilder
options.limit = 20
options.page = 1
```

The configuration expects an element `adapter` for the relevant adapter and an `options` array with the necessary options for the adapter.

## Exception
Any exceptions thrown in the Paginator component will be of type [Phalcon\Paginator\Exception](api/phalcon_paginator#paginator-exception). You can use this exception to selectively catch exceptions thrown only from this component.


```php
<?php

use Phalcon\Paginator\Adapter\NativeArray;
use Phalcon\Paginator\Exception;

try {
    $currentPage = 2;
    $paginator   = new NativeArray(
        [
            "data"  => [
                ["id" => 1, "name" => "Artichoke"],
                ["id" => 2, "name" => "Carrots"],
                ["id" => 3, "name" => "Beet"],
                ["id" => 4, "name" => "Lettuce"],
                ["id" => 5, "name" => ""],
            ],
            "limit" => -5,
            "page"  => $currentPage,
        ]
    );

    $paginate = $paginator->paginate();
} catch (Exception $ex) {
    echo $ex->getMessage();
}
```

## Examples
In the example below, the paginator will use the result of a query from a model as its source data, and limit the displayed data to 10 records per page:

### Full
```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

/**
 * @property Request $request
 * @property View    $view
 */
class InvoicesController extends Controller
{
    public function listAction()
    {
        $currentPage = $this->request->getQuery('page', 'int');
        $invoices    = Invoices::find();
        $paginator   = new PaginatorModel(
            [
                'data'  => $invoices,
                'limit' => 10,
                'page'  => $currentPage,
            ]
        );

        $page = $paginator->paginate();

        $this->view->setVar('page', $page);

    }
}
```

In the example above `$currentPage` contains an integer, user supplied variable, for the page to be displayed. The `$paginator->paginate()` returns a [Phalcon\Paginator\Repository](api/phalcon_paginator#paginator-repository) object that contains the paginated data. It can be used for generating the pagination in a view for instance:

```php
<table>
    <tr>
        <th>Id</th>
        <th>Status</th>
        <th>Title</th>
    </tr>
    <?php foreach ($page->getItems() as $item) { ?>
    <tr>
        <td><?php echo $item->inv_id; ?></td>
        <td><?php echo ($item->inv_status_flag) ? 'Paid' : ''; ?></td>
        <td><?php echo $item->inv_title; ?></td>
    </tr>
    <?php } ?>
</table>
```

The `$page` object also contains navigation data:

```php
<a href="/invoices/list">First</a>
<a href="/invoices/list?page=<?= $page->getPrevious(); ?>">Previous</a>
<a href="/invoices/list?page=<?= $page->getNext(); ?>">Next</a>
<a href="/invoices/list?page=<?= $page->getLast(); ?>">Last</a>

<?php echo "Page {$page->getCurrent()}  of {$page->getLast()}"; ?>
```

### Factory
You can instantiate a Paginator class using the `AdapterFactory`.

**Model**
```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Paginator\PaginatorFactory;

$factory = new PaginatorFactory();

$currentPage = 2;
$options     = [
   'data'  => Invoices::find(),
   'limit' => 10,
   'page'  => $currentPage,
];

$paginator = $factory->newInstance('model', $options);
```

**Array**
```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Paginator\PaginatorFactory;

$factory = new PaginatorFactory();

$currentPage = 2;
$options     = [
    'data'  => [
        ['id' => 1, 'name' => 'Artichoke'],
        ['id' => 2, 'name' => 'Carrots'],
        ['id' => 3, 'name' => 'Beet'],
        ['id' => 4, 'name' => 'Lettuce'],
        ['id' => 5, 'name' => ''],
    ],
    'limit' => 2,
    'page'  => $currentPage,
];

$paginator = $factory->newInstance('nativeArray', $options);
```

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Paginator\PaginatorFactory;

$factory = new PaginatorFactory();

$currentPage = 2;
$builder     = $this
    ->modelsManager
    ->createBuilder()
    ->columns('id, name')
    ->from('Robots')
    ->orderBy('name');
$options = [
    'builder' => $builder,
    'limit'   => 20,
    'page'    => $currentPage,
];

$paginator = $factory->newInstance('queryBuilder', $options);
```

### Individual Classes
An example of the source data that must be used for each adapter:

**Model**
```php
<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

$currentPage = 2;
$paginator   = new PaginatorModel(
    [
       'data'  => Invoices::find(),
       'limit' => 10,
       'page'  => $currentPage,
    ]
);
```

**Array**
```php
<?php

use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;

$currentPage = 2;
$paginator   = new PaginatorArray(
    [
        'data'  => [
            ['id' => 1, 'name' => 'Artichoke'],
            ['id' => 2, 'name' => 'Carrots'],
            ['id' => 3, 'name' => 'Beet'],
            ['id' => 4, 'name' => 'Lettuce'],
            ['id' => 5, 'name' => ''],
        ],
        'limit' => 2,
        'page'  => $currentPage,
    ]
);
```

**Query Builder**
```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;

$currentPage = 2;
$builder     = $this
    ->modelsManager
    ->createBuilder()
    ->columns('id, name')
    ->from('Robots')
    ->orderBy('name');

$paginator = new PaginatorQueryBuilder(
    [
        'builder' => $builder,
        'limit'   => 20,
        'page'    => $currentPage,
    ]
);
```

## Custom
The [Phalcon\Paginator\AdapterInterface](api/phalcon_paginator#paginator-adapter-adapterinterface) interface must be implemented in order to create your own paginator adapters or extend the existing ones:

```php
<?php

use Phalcon\Paginator\AdapterInterface as PaginatorInterface;
use Phalcon\Paginator\RepositoryInterface;

class MyPaginator implements PaginatorInterface
{
    /**
     * Get current rows limit
     */
    public function getLimit(): int;

    /**
     * Returns a slice of the resultset to show in the pagination
     */
    public function paginate(): RepositoryInterface;

    /**
     * Set the current page number
     */
    public function setCurrentPage(int $page);

    /**
     * Set current rows limit
     */
    public function setLimit(int $limit);
}
```
