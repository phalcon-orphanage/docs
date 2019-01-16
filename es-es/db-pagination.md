* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Paginación

The process of pagination takes place when we need to present big groups of arbitrary data gradually. `Phalcon\Paginator` offers a fast and convenient way to split these sets of data into browsable pages.

<a name='data-adapters'></a>

## Adaptadores de datos

This component makes use of adapters to encapsulate different sources of data:

| Adaptador                                                                               | Descripción                                                                                                                                                                                                         |
| --------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Paginator\Adapter\NativeArray](api/Phalcon_Paginator_Adapter_NativeArray)   | Usa un array PHP como origen de datos                                                                                                                                                                               |
| [Phalcon\Paginator\Adapter\Model](api/Phalcon_Paginator_Adapter_Model)               | Use a [Phalcon\Mvc\Model\Resultset](api/Phalcon_Mvc_Model_Resultset) object as source data. Como PDO no admite cursores desplazables, este adaptador no se debe usar para paginar una gran cantidad de registros |
| [Phalcon\Paginator\Adapter\QueryBuilder](api/Phalcon_Paginator_Adapter_QueryBuilder) | Use a [Phalcon\Mvc\Model\Query\Builder](api/Phalcon_Mvc_Model_Query_Builder) object as source data                                                                                                              |

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

## Ejemplos

In the example below, the paginator will use the result of a query from a model as its source data, and limit the displayed data to 10 records per page:

```php
<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

// Página actual para mostrar
// En un controlador/componente este puede ser
// $this->request->getQuery('page', 'int'); // GET
// $this->request->getPost('page', 'int'); // POST
$currentPage = (int) $_GET['page'];

// El conjunto de datos a paginar
$robots = Robots::find();

// Crear un paginador del modelo, mostrando 10 registros por página empezando desde $currentPage
$paginator = new PaginatorModel(
    [
        'data'  => $robots,
        'limit' => 10,
        'page'  => $currentPage,
    ]
);

// Obtener los resultados paginados
$page = $paginator->getPaginate();
```

The `$currentPage` variable controls the page to be displayed. The `$paginator->getPaginate()` returns a `$page` object that contains the paginated data. It can be used for generating the pagination:

```php
<table>
    <tr>
        <th>Id</th>
        <th>Nombre</th>
        <th>Tipo</th>
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
<a href='/robots/search'>Primera</a>
<a href='/robots/search?page=<?= $page->before; ?>'>Anterior</a>
<a href='/robots/search?page=<?= $page->next; ?>'>Siguiente</a>
<a href='/robots/search?page=<?= $page->last; ?>'>Última</a>

<?php echo 'Estas en la página ', $page->current, ' de ', $page->total_pages; ?>
```

<a name='using-adapters'></a>

## Uso de adaptadores

An example of the source data that must be used for each adapter:

```php
<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Paginator\Adapter\NativeArray as PaginatorArray;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;

// Pasando un conjunto de resultados como datos
$paginator = new PaginatorModel(
    [
        'data'  => Products::find(),
        'limit' => 10,
        'page'  => $currentPage,
    ]
);

// Pasando un array como datos
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

// Pasando un QueryBuilder como datos
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

## Atributos de Página

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

## Implementando sus propios adaptadores

The [Phalcon\Paginator\AdapterInterface](api/Phalcon_Paginator_AdapterInterface) interface must be implemented in order to create your own paginator adapters or extend the existing ones:

```php
<?php

use Phalcon\Paginator\AdapterInterface as PaginatorInterface;

class MyPaginator implements PaginatorInterface
{
    /**
     * Constructor del adaptador
     *
     * @param array $config
     */
    public function __construct($config);

    /**
     * Establece la página actual
     *
     * @param int $page
     */
    public function setCurrentPage($page);

    /**
     * Devuelve una parte del conjunto de resultados para mostrar en la paginación
     *
     * @return stdClass
     */
    public function getPaginate();
}
```