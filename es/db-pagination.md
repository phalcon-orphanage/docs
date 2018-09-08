<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Paginación</a> 
      <ul>
        <li>
          <a href="#data-adapters">Adaptadores de datos</a>
        </li>
        <li>
          <a href="#examples">Ejemplos</a>
        </li>
        <li>
          <a href="#using-adapters">Usando Adaptadores</a>
        </li>
        <li>
          <a href="#page-attributes">Atributos de Página</a>
        </li>
        <li>
          <a href="#custom">Implementando sus propios adaptadores</a>
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

| Adaptador                                   | Descripción                                                                                                                                                                                   |
| ------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Paginator\Adapter\NativeArray`  | Usa un array PHP como origen de datos                                                                                                                                                         |
| `Phalcon\Paginator\Adapter\Model`        | Utiliza un objeto `Phalcon\Mvc\Model\Resultset` como origen de datos. Como PDO no admite cursores desplazables, este adaptador no se debe usar para paginar una gran cantidad de registros |
| `Phalcon\Paginator\Adapter\QueryBuilder` | Utiliza un objeto `Phalcon\Mvc\Model\Query\Builder` como origen de datos                                                                                                                  |

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

## Ejemplos

En el siguiente ejemplo, el paginator utilizará el resultado de una consulta de un modelo como el origen de sus datos y limitará los datos mostrados, 10 registros por página:

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

La variable `$currentPage` controla la página que se mostrará. El `$paginator->getPaginate()` devuelve un objeto `$page` que contiene los datos paginados. Puede ser utilizado para la generación de la paginación:

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

El objeto `$page` también contiene datos de navegación:

```php
<a href='/robots/search'>Primera</a>
<a href='/robots/search?page=<?= $page->before; ?>'>Anterior</a>
<a href='/robots/search?page=<?= $page->next; ?>'>Siguiente</a>
<a href='/robots/search?page=<?= $page->last; ?>'>Última</a>

<?php echo 'Estas en la página ', $page->current, ' de ', $page->total_pages; ?>
```

<a name='using-adapters'></a>

## Uso de adaptadores

Un ejemplo de los datos de origen que deben utilizarse para cada adaptador:

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

El objeto `$page` tiene los siguientes atributos:

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

## Implementar tus propios adaptadores

Debe implementar la interfaz `Phalcon\Paginator\AdapterInterface` para crear sus propios adaptadores o extender los ya existentes:

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