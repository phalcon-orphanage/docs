---
layout: article
language: 'en'
version: '4.0'
---
##### This article reflects v3.4 and has not yet been revised
{:.alert .alert-danger}

<a name='overview'></a>
# Pagination
The process of pagination takes place when we need to present big groups of arbitrary data gradually. `Phalcon\Paginator` offers a fast and convenient way to split these sets of data into browsable pages.

<a name='data-adapters'></a>
## Data Adapters
This component makes use of adapters to encapsulate different sources of data:

| Adapter                                  | Description                                                                                                                                                                  |
|------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| [Phalcon\Paginator\Adapter\NativeArray](api/Phalcon_Paginator_Adapter_NativeArray)  | Use a PHP array as source data                                                                                                                                               |
| [Phalcon\Paginator\Adapter\Model](api/Phalcon_Paginator_Adapter_Model)        | Use a [Phalcon\Mvc\Model\Resultset](api/Phalcon_Mvc_Model_Resultset) object as source data. Since PDO doesn't support scrollable cursors this adapter shouldn't be used to paginate a large number of records |
| [Phalcon\Paginator\Adapter\QueryBuilder](api/Phalcon_Paginator_Adapter_QueryBuilder) | Use a [Phalcon\Mvc\Model\Query\Builder](api/Phalcon_Mvc_Model_Query_Builder) object as source data                                                                                                                |

<a name='factory'></a>
## Factory
Loads Paginator Adapter class using `adapter` option

```php
<?php

use Phalcon\Paginator\Factory;
 
$builder = $this->modelsManager->createBuilder()
                ->columns('id, name')
                ->from('Robots')
                ->orderBy('name');

$options = [
    'builder' => $builder,
    'limit'   => 20,
    'page'    => 1,
    'adapter' => 'queryBuilder',
];

$paginator = Factory::load($options);

```

<a name='examples'></a>
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
$robots = Robots::find();

// Create a Model paginator, show 10 rows by page starting from $currentPage
$paginator = new PaginatorModel(
    [
        'data'  => $robots,
        'limit' => 10,
        'page'  => $currentPage,
    ]
);

// Get the paginated results
$page = $paginator->getPaginate();
```

The `$currentPage` variable controls the page to be displayed. The `$paginator->getPaginate()` returns a `$page` object that contains the paginated data. It can be used for generating the pagination:

```php
<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Type</th>
    </tr>
    <?php foreach ($page->items as $item) { ?>
    <tr>
        <td><?php echo $item->id; ?></td>
        <td><?php echo $item->name; ?></td>
        <td><?php echo $item->type; ?></td>
    </tr>
    <?php } ?>
</table>
```

The `$page` object also contains navigation data:

```php
<a href='/robots/search'>First</a>
<a href='/robots/search?page=<?= $page->before; ?>'>Previous</a>
<a href='/robots/search?page=<?= $page->next; ?>'>Next</a>
<a href='/robots/search?page=<?= $page->last; ?>'>Last</a>

<?php echo 'You are in page ', $page->current, ' of ', $page->total_pages; ?>
```

<a name='using-adapters'></a>
## Using Adapters
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

<a name='page-attributes'></a>
## Page Attributes
The `$page` object has the following attributes:

| Attribute     | Description                                            |
|---------------|--------------------------------------------------------|
| `items`       | The set of records to be displayed at the current page |
| `current`     | The current page                                       |
| `before`      | The previous page to the current one                   |
| `next`        | The next page to the current one                       |
| `last`        | The last page in the set of records                    |
| `total_pages` | The number of pages                                    |
| `total_items` | The number of items in the source data                 |

<a name='custom'></a>
## Implementing your own adapters
The [Phalcon\Paginator\AdapterInterface](api/Phalcon_Paginator_AdapterInterface) interface must be implemented in order to create your own paginator adapters or extend the existing ones:

```php
<?php

use Phalcon\Paginator\AdapterInterface as PaginatorInterface;

class MyPaginator implements PaginatorInterface
{
    /**
     * Adapter constructor
     *
     * @param array $config
     */
    public function __construct($config);

    /**
     * Set the current page number
     *
     * @param int $page
     */
    public function setCurrentPage($page);

    /**
     * Returns a slice of the resultset to show in the pagination
     *
     * @return stdClass
     */
    public function getPaginate();
}
```