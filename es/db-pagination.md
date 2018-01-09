<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Paginación</a> 
      <ul>
        <li>
          <a href="#data-adapters">Adaptadores de datos</a>
        </li>
        <li>
          <a href="#examples">Examples</a>
        </li>
        <li>
          <a href="#using-adapters">Using Adapters</a>
        </li>
        <li>
          <a href="#page-attributes">Page Attributes</a>
        </li>
        <li>
          <a href="#custom">Implementing your own adapters</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Paginación

El proceso de paginación ocurre cuando tenemos que presentar gradualmente grandes grupos de datos. `Phalcon\Paginator` ofrece una manera rápida y conveniente para dividir estos conjuntos de datos en páginas navegables.

<a name='data-adapters'></a>

## Adaptadores de datos

Este componente hace uso de adaptadores para encapsular diferentes fuentes de datos:

| Adaptador                                   | Descripción                                                                                                                                                                                     |
| ------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Paginator\Adapter\NativeArray`  | Usa un array PHP como origen de datos                                                                                                                                                           |
| `Phalcon\Paginator\Adapter\Model`        | Utiliza un objeto `Phalcon\Mvc\Model\Resultset` como origen de datos. Ya que PDO no admite cursores desplazables este adaptador no se debe utilizar para paginar un gran número de registros |
| `Phalcon\Paginator\Adapter\QueryBuilder` | Utiliza un objeto `Phalcon\Mvc\Model\Query\Builder` como origen de datos                                                                                                                    |

<a name='factory'></a>

## Factory

Carga un adaptador de Paginator utilizando la opción `adapter`

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

| Atributos     | Descripción                                                        |
| ------------- | ------------------------------------------------------------------ |
| `items`       | El conjunto de registros o elementos a mostrar en la página actual |
| `current`     | Número de página actual                                            |
| `before`      | Número de página anterior a la actual                              |
| `next`        | Número de página siguiente a la actual                             |
| `last`        | Número de la última página                                         |
| `total_pages` | Cantidad de páginas                                                |
| `total_items` | El número total de elementos de los datos de origen                |

<a name='custom'></a>

## Implementing your own adapters

The `Phalcon\Paginator\AdapterInterface` interface must be implemented in order to create your own paginator adapters or extend the existing ones:

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