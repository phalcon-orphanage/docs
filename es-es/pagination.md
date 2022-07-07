---
layout: default
language: 'es-es'
version: '5.0'
title: 'Paginación'
keywords: 'paginación, paginación modelos, paginación bd, paginación vector, paginación consulta'
---

# Paginación
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
Un paginador es un componente que ayuda a dividir una gran cantidad de datos gradualmente. Un ejemplo sería mostrar todos los mensajes de un blog, 5 cada vez. El Paginador de Phalcon acepta parámetros y basado en ellos devuelve la _porción_ correspondiente de todo el conjunto de resultados para que el desarrollador pueda presentar los datos paginados.

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

El ejemplo anterior usa un vector como fuente, y limita los resultados a 2 registros cada vez. Devolverá los elementos con id `3` y `4` porque `page` se ha establecido a `2`.

## Adaptadores
Para la fuente de datos, el componente usa adaptadores. Viene con los siguientes adaptadores:

| Adaptador                                                                   | Descripción                                                                                |
| --------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------ |
| [Phalcon\Paginator\Adapter\Model][paginator-adapter-model]               | Use a [Phalcon\Mvc\Model\Resultset][mvc-model-resultset] object as source data.         |
| [Phalcon\Paginator\Adapter\NativeArray][paginator-adapter-nativearray]   | Usa un vector PHP como origen de datos                                                     |
| [Phalcon\Paginator\Adapter\QueryBuilder][paginator-adapter-querybuilder] | Use a [Phalcon\Mvc\Model\Query\Builder][mvc-model-query-builder] object as source data |

> **NOTE**: Since PDO does not support scrollable cursors, [Phalcon\Paginator\Adapter\Model][paginator-adapter-model] should not be used to paginate a large number of records 
> 
> {: .alert .alert-warning}


### Métodos
```php
public function __construct(array $config)
```

Cada adaptador requiere opciones para funcionar correctamente. Estas opciones se pasan como vector clave/valor en el constructor del adaptador.

- `builder` - Used only for the [Phalcon\Paginator\Adapter\QueryBuilder][paginator-adapter-querybuilder] to pass the builder object
- `data` - Los datos a paginar. ([Phalcon\Paginator\Adapter\NativeArray][paginator-adapter-nativearray] adapter)
- `limit` - `int` - El tamaño de la porción de página. Si `limit` es negativo, se lanzará una excepción.
- `model` - Los datos a paginar. ([Phalcon\Paginator\Adapter\Model][paginator-adapter-model] adapter)
- `page` - `int` - La página actual
- `repository` - [Phalcon\Paginator\RepositoryInterface][paginator-repositoryinterface] - A repository object setting up the resultset. Para más información sobre repositorios ver a continuación.

Los métodos expuestos son:

- `getLimit()` - `int` - Obtiene el límite de filas actual
- `getRepository(array $properties = null)` - `RepositoryInterface` - Obtiene el repositorio actual para la paginación
- `setCurrentPage(int $page)` - `AdapterInterface` - Establece el número de página actual
- `setLimit(int $limitRows)` - `AdapterInterface` - Establece el límite de filas actual
- `setRepository(RepositoryInterface $repository)` - `AdapterInterface` - Establece el repositorio actual para la paginación

### Modelo
The [Phalcon\Paginator\Adapter\Model][paginator-adapter-model] adapter uses a [Phalcon\Mvc\Model\Resultset][mvc-model-resultset] as the source of the data. Este ese el resultado del método `find()` en un modelo.

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

El vector acepta `model` para la clase de modelo a usar. Se llamará al método `find()` sobre él. Adicionalmente este adaptador puede aceptar `parámetros` como el vector que puede usar `find()` con todas las condiciones relevantes requeridas.

### Vector
The [Phalcon\Paginator\Adapter\NativeArray][paginator-adapter-nativearray] accepts a PHP array as the source of the data.

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

### Constructor de Consultas
The [Phalcon\Paginator\Adapter\QueryBuilder][paginator-adapter-querybuilder] adapter uses a [Phalcon\Mvc\Model\Query\Builder][mvc-model-query-builder] object to perform a PHQL query against the database.

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

## Repositorio
El método `paginate()` hace todo el trabajo para paginar los datos. It returns a [Phalcon\Paginator\Repository][paginator-repository] object which stores all the necessary elements for the pagination. El objeto expone las siguientes constantes:

- `PROPERTY_CURRENT_PAGE`  = "current";
- `PROPERTY_FIRST_PAGE`    = "first";
- `PROPERTY_ITEMS`         = "items";
- `PROPERTY_LAST_PAGE`     = "last";
- `PROPERTY_LIMIT`         = "limit";
- `PROPERTY_NEXT_PAGE`     = "next";
- `PROPERTY_PREVIOUS_PAGE` = "previous";
- `PROPERTY_TOTAL_ITEMS`   = "total_items";

### Métodos
Los métodos expuestos son:

- `getAliases()` - `array` - Obtiene los alias para el repositorio de propiedades
- `getCurrent()` - `int` - Obtiene el número de la página actual
- `getFirst()` - `int` - Obtiene el número de la primera página
- `getItems()` - `mixed` - Obtiene los elementos de la página actual
- `getLast()` - `int` - Obtiene el número de la última página
- `getLimit()` - `int` - Obtiene el límite de filas actual
- `getNext()` - `int` - Obtiene el número de la siguiente página
- `getPrevious()` - `int` - Obtiene el número de la página anterior
- `getTotalItems()` - `int` - Obtiene el número total de elementos
- `setAliases(array $aliases)` - `RepositoryInterface` - Establece los alias para el repositorio de propiedades
- `setProperties(array $properties)` - `RepositoryInterface` - Establece los valores para las propiedades del repositorio

Puede acceder a los datos usando los métodos anteriores o usar las propiedades mágicas como las definidas en las constantes:

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

### Alias
Si quiere usar sus propios nombres para cada propiedad mágica que el objeto Repositorio expone, puede usar el método `setAliases()` para hacerlo.

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

You can also create your custom repository class by implementing the [Phalcon\Paginator\RepositoryInterface][paginator-repositoryinterface] interface.

## Fábrica (Factory)
Puede usar la clase Fábrica de Paginación para instanciar un nuevo objeto paginador. Los nombres del servicio son:

- `model` - [Phalcon\Paginator\Adapter\Model][paginator-adapter-model]
- `nativeArray` - [Phalcon\Paginator\Adapter\NativeArray][paginator-adapter-nativearray]
- `queryBuilder` - [Phalcon\Paginator\Adapter\QueryBuilder][paginator-adapter-querybuilder]

### Nueva Instancia
Un método que puede usar es `newInstance()`:

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

### Cargar
Carga la clase Adaptador de Paginador usando la opción `adapter`. La configuración pasada puede ser un vector o un objeto [Phalcon\Config](config) con las entradas necesarias para que se instancie la clase.

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

Un objeto de configuración de ejemplo es:

```ini
[paginator]
adapter = queryBuilder
options.limit = 20
options.page = 1
```

La configuración espera un elemento `adapter` para el adaptador relevante y un vector `options` con las opciones necesarias para el adaptador.

## Excepción
Any exceptions thrown in the Paginator component will be of type [Phalcon\Paginator\Exception][paginator-exception]. Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.


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

## Ejemplos
En el ejemplo anterior, el paginador usará el resultado de una consulta de un modelo como su fuente de datos, y limitará los datos mostrados a 10 registros por página:

### Completo
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
        $currentPage = $this->request->getQuery('page', 'int', 1);
        $paginator   = new PaginatorModel(
            [
                'model'  => Invoices::class,
                'limit' => 10,
                'page'  => $currentPage,
            ]
        );

        $page = $paginator->paginate();

        $this->view->setVar('page', $page);

    }
}
```

En el ejemplo anterior `$currentPage` contiene un entero, variable proporcionada por el usuario, con la página a mostrar. The `$paginator->paginate()` returns a [Phalcon\Paginator\Repository][paginator-repository] object that contains the paginated data. Se puede usar para generar la paginación en una vista por ejemplo:

```php
<table>
    <tr>
        <th>Id</th>
        <th>Status</th>
        <th>Title</th>
    </tr>
    <?php foreach ($page->getItems() as $item) { ?>
    <tr>
        <td><?php echo $item['inv_id']; ?></td>
        <td><?php echo ($item['inv_status_flag']) ? 'Paid' : ''; ?></td>
        <td><?php echo $item['inv_title']; ?></td>
    </tr>
    <?php } ?>
</table>
```

El objeto `$page` también contiene datos de navegación:

```php
<a href="/invoices/list">First</a>
<a href="/invoices/list?page=<?= $page->getPrevious(); ?>">Previous</a>
<a href="/invoices/list?page=<?= $page->getNext(); ?>">Next</a>
<a href="/invoices/list?page=<?= $page->getLast(); ?>">Last</a>

<?php echo "Page {$page->getCurrent()}  of {$page->getLast()}"; ?>
```

### Fábrica (Factory)
Puede instanciar una clase Paginador usando `AdapterFactory`.

**Modelo**
```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Paginator\PaginatorFactory;

$factory = new PaginatorFactory();

$currentPage = 2;
$options     = [
   'model'  => Invoices::class,
   'limit' => 10,
   'page'  => $currentPage,
];

$paginator = $factory->newInstance('model', $options);
```

**Vector**
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

### Clases Individuales
Un ejemplo de fuente de datos que se debe usar para cada adaptador:

**Modelo**
```php
<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

$currentPage = 2;
$paginator   = new PaginatorModel(
    [
       'model'  => Invoices::class,
       'limit' => 10,
       'page'  => $currentPage,
    ]
);
```

**Vector**
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

**Constructor de Consultas**
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

## Personalizado
The [Phalcon\Paginator\AdapterInterface][paginator-adapter-adapterinterface] interface must be implemented in order to create your own paginator adapters or extend the existing ones:

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

[mvc-model-query-builder]: api/phalcon_mvc#mvc-model-query-builder
[mvc-model-resultset]: api/phalcon_mvc#mvc-model-resultset
[paginator-adapter-adapterinterface]: api/phalcon_paginator#paginator-adapter-adapterinterface
[paginator-adapter-model]: api/phalcon_paginator#paginator-adapter-model
[paginator-adapter-nativearray]: api/phalcon_paginator#paginator-adapter-nativearray
[paginator-adapter-querybuilder]: api/phalcon_paginator#paginator-adapter-querybuilder
[paginator-exception]: api/phalcon_paginator#paginator-exception
[paginator-repository]: api/phalcon_paginator#paginator-repository
[paginator-repositoryinterface]: api/phalcon_paginator#paginator-repositoryinterface
