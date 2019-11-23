---
layout: default
language: 'fr-fr'
version: '4.0'
---

# Pagination

* * *

![](/assets/images/document-status-under-review-red.svg)

## Overview

The process of pagination takes place when we need to present big groups of arbitrary data gradually. `Phalcon\Paginator` offers a fast and convenient way to split these sets of data into browsable pages.

## Data Adapters

This component makes use of adapters to encapsulate different sources of data:

| Adapter                                                                                                   | Description                                                                                                                                                                                                      |
| --------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Paginator\Adapter\NativeArray](api/Phalcon_Paginator#Phalcon_Paginator_Adapter_NativeArray)   | Use a PHP array as source data                                                                                                                                                                                   |
| [Phalcon\Paginator\Adapter\Model](api/Phalcon_Paginator#Phalcon_Paginator_Adapter_Model)               | Use a [Phalcon\Mvc\Model\Resultset](api/Phalcon_Mvc_Model_Resultset) object as source data. Since PDO doesn't support scrollable cursors this adapter shouldn't be used to paginate a large number of records |
| [Phalcon\Paginator\Adapter\QueryBuilder](api/Phalcon_Paginator$Phalcon_Paginator_Adapter_QueryBuilder) | Use a [Phalcon\Mvc\Model\Query\Builder](api/Phalcon_Mvc_Model_Query_Builder) object as source data                                                                                                           |

## Factory

### New Instance

You can use the Pagination Factory class to instantiate a new paginator object:

```php
<?php

use Phalcon\Paginator\PaginatorFactory;

$builder = $this
    ->modelsManager
    ->createBuilder()
    ->columns('id, name')
    ->from(Users::class)
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

use Phalcon\Paginator\PaginatorFactory;

$builder = $this
    ->modelsManager
    ->createBuilder()
    ->columns('id, lastName, firstName')
    ->from(Users::class)
    ->orderBy('name')
;

$options = [
    'builder' => $builder,
    'limit'   => 20,
    'page'    => 1,
    'adapter' => 'queryBuilder',
];

$paginator = (new PaginatorFactory())->load($options);

```

## Examples

In the example below, the paginator will use the result of a query from a model as its source data, and limit the displayed data to 10 records per page:

```php
<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

// Current page to show
// In a controller/component this can be:
// $this->request->getQuery('page', 'int'); // GET
// $this->request->getPost('page', 'int'); // POST
$currentPage = (int) $_GET['page'];

// The data set to paginate
$robots = Users::find();

// Create a Model paginator, show 10 rows by page starting from $currentPage
$paginator = new PaginatorModel(
    [
        'data'  => $robots,
        'limit' => 10,
        'page'  => $currentPage,
    ]
);

// Get the paginated results
$page = $paginator->paginate();
```

The `$currentPage` variable controls the page to be displayed. The `$paginator->paginate()` returns a `$page` object that contains the paginated data. It can be used for generating the pagination:

```php
<table>
    <tr>
        <th>Id</th>
        <th>Active</th>
        <th>Last Name</th>
        <th>First Name</th>
    </tr>
    <?php foreach ($page->items as $item) { ?>
    <tr>
        <td><?php echo $item->id; ?></td>
        <td><?php echo ($item->active) ? 'Y' : 'N'; ?></td>
        <td><?php echo $item->lastName; ?></td>
        <td><?php echo $item->firstName; ?></td>
    </tr>
    <?php } ?>
</table>
```

The `$page` object also contains navigation data:

```php
<a href="/users/list">First</a>
<a href="/users/list?page=<?= $page->previous; ?>">Previous</a>
<a href="/users/list?page=<?= $page->next; ?>">Next</a>
<a href="/users/list?page=<?= $page->last; ?>">Last</a>

<?php echo "You are in page {$page->current}  of {$page->total_pages}"; ?>
```

## Using Adapters

### Factory

You can instantiate a Paginator class using the `AdapterFactory`.

```php
<?php

use Phalcon\Paginator\AdapterFactory;

$factory = new AdapterFactory();

// Passing a resultset as data
$options = [
   'data'  => Products::find(),
   'limit' => 10,
   'page'  => $currentPage,
];

$paginator = $factory->newInstance('model', $options);

// Passing an array as data
$options = [
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

// Passing a QueryBuilder as data

$builder = $this
    ->modelsManager
    ->createBuilder()
    ->columns('id, name')
    ->from('Robots')
    ->orderBy('name');
$options = [
    'builder' => $builder,
    'limit'   => 20,
    'page'    => 1,
];

$paginator = $factory->newInstance('queryBuilder', $options);
```

### Individual classes

An example of the source data that must be used for each adapter:

```php
<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;

// Passing a resultset as data
$paginator = new PaginatorModel(
    [
        'data'  => Products::find(),
        'limit' => 10,
        'page'  => $currentPage,
    ]
);

// Passing an array as data
$paginator = new PaginatorArray(
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

// Passing a QueryBuilder as data

$builder = $this->modelsManager->createBuilder()
    ->columns('id, name')
    ->from('Robots')
    ->orderBy('name');

$paginator = new PaginatorQueryBuilder(
    [
        'builder' => $builder,
        'limit'   => 20,
        'page'    => 1,
    ]
);
```

## Page Attributes

The `$page` object has the following attributes:

| Attribute     | Description                                            |
| ------------- | ------------------------------------------------------ |
| `items`       | The set of records to be displayed at the current page |
| `current`     | The current page                                       |
| `previous`    | The previous page to the current one                   |
| `next`        | The next page to the current one                       |
| `last`        | The last page in the set of records                    |
| `total_items` | The number of items in the source data                 |

## Implementing your own adapters

The [Phalcon\Paginator\AdapterInterface](api/Phalcon_Paginator_Adapter_AdapterInterface) interface must be implemented in order to create your own paginator adapters or extend the existing ones:

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