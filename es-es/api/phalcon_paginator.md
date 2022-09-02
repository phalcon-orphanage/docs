---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Paginator'
---

* [Phalcon\Paginator\Adapter\AbstractAdapter](#paginator-adapter-abstractadapter)
* [Phalcon\Paginator\Adapter\AdapterInterface](#paginator-adapter-adapterinterface)
* [Phalcon\Paginator\Adapter\Model](#paginator-adapter-model)
* [Phalcon\Paginator\Adapter\NativeArray](#paginator-adapter-nativearray)
* [Phalcon\Paginator\Adapter\QueryBuilder](#paginator-adapter-querybuilder)
* [Phalcon\Paginator\Exception](#paginator-exception)
* [Phalcon\Paginator\PaginatorFactory](#paginator-paginatorfactory)
* [Phalcon\Paginator\Repository](#paginator-repository)
* [Phalcon\Paginator\RepositoryInterface](#paginator-repositoryinterface)

<h1 id="paginator-adapter-abstractadapter">Abstract Class Phalcon\Paginator\Adapter\AbstractAdapter</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Paginator/Adapter/AbstractAdapter.zep)

| Namespace | Phalcon\Paginator\Adapter | | Uses | Phalcon\Paginator\Exception, Phalcon\Paginator\Repository, Phalcon\Paginator\RepositoryInterface | | Implements | AdapterInterface |

Phalcon\Paginator\Adapter\AbstractAdapter

## Propiedades

```php
/**
 * Configuration of paginator
 */
protected config;

/**
 * Number of rows to show in the paginator. By default is null
 */
protected limitRows;

/**
 * Current page in paginate
 */
protected page;

/**
 * Repository for pagination
 *
 * @var RepositoryInterface
 */
protected repository;

```

## Métodos

```php
public function __construct( array $config );
```

Constructor Phalcon\Paginator\Adapter\AbstractAdapter

```php
public function getLimit(): int;
```

Obtener el límite actual de filas

```php
public function setCurrentPage( int $page ): AdapterInterface;
```

Establece el número de página actual

```php
public function setLimit( int $limitRows ): AdapterInterface;
```

Establece el límite de filas actual

```php
public function setRepository( RepositoryInterface $repository ): AdapterInterface;
```

Establece el repositorio actual para la paginación

```php
protected function getRepository( array $properties = null ): RepositoryInterface;
```

Obtiene el repositorio actual para la paginación

<h1 id="paginator-adapter-adapterinterface">Interface Phalcon\Paginator\Adapter\AdapterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Paginator/Adapter/AdapterInterface.zep)

| Namespace | Phalcon\Paginator\Adapter | | Uses | Phalcon\Paginator\RepositoryInterface |

Phalcon\Paginator\AdapterInterface

Interfaz para adaptadores Phalcon\Paginator

## Métodos

```php
public function getLimit(): int;
```

Obtener el límite actual de filas

```php
public function paginate(): RepositoryInterface;
```

Devuelve un segmento del conjunto de resultados para mostrar en la paginación

```php
public function setCurrentPage( int $page );
```

Establece el número de página actual

```php
public function setLimit( int $limit );
```

Establece el límite de filas actual

<h1 id="paginator-adapter-model">Class Phalcon\Paginator\Adapter\Model</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Paginator/Adapter/Model.zep)

| Namespace | Phalcon\Paginator\Adapter | | Uses | Phalcon\Helper\Arr, Phalcon\Mvc\ModelInterface, Phalcon\Mvc\Model\ResultsetInterface, Phalcon\Paginator\Exception, Phalcon\Paginator\RepositoryInterface | | Extends | AbstractAdapter |

Phalcon\Paginator\Adapter\Model

This adapter allows to paginate data using a Phalcon\Mvc\Model resultset as a base.

```php
use Phalcon\Paginator\Adapter\Model;

$paginator = new Model(
    [
        "model" => Robots::class,
        "limit" => 25,
        "page"  => $currentPage,
    ]
);


$paginator = new Model(
    [
        "model" => Robots::class,
        "parameters" => [
             "columns" => "id, name"
        ],
        "limit" => 12,
        "page"  => $currentPage,
    ]
);


$paginator = new Model(
    [
        "model" => Robots::class,
        "parameters" => [
             "type = :type:",
             "bind" => [
                 "type" => "mechanical"
             ],
             "order" => "name"
        ],
        "limit" => 16,
        "page"  => $currentPage,
    ]
);

$paginator = new Model(
    [
        "model" => Robots::class,
        "parameters" => "(id % 2) = 0",
        "limit" => 8,
        "page"  => $currentPage,
    ]
);


$paginator = new Model(
    [
        "model" => Robots::class,
        "parameters" => [ "(id % 2) = 0" ],
        "limit" => 8,
        "page"  => $currentPage,
    ]
);

$paginate = $paginator->paginate();
```

## Métodos

```php
public function paginate(): RepositoryInterface;
```

Devuelve un segmento del conjunto de resultados para mostrar en la paginación

<h1 id="paginator-adapter-nativearray">Class Phalcon\Paginator\Adapter\NativeArray</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Paginator/Adapter/NativeArray.zep)

| Namespace | Phalcon\Paginator\Adapter | | Uses | Phalcon\Paginator\Exception, Phalcon\Paginator\RepositoryInterface | | Extends | AbstractAdapter |

Phalcon\Paginator\Adapter\NativeArray

Paginación usando un vector PHP como origen de datos

```php
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

```php
public function paginate(): RepositoryInterface;
```

Devuelve un segmento del conjunto de resultados para mostrar en la paginación

<h1 id="paginator-adapter-querybuilder">Class Phalcon\Paginator\Adapter\QueryBuilder</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Paginator/Adapter/QueryBuilder.zep)

| Namespace | Phalcon\Paginator\Adapter | | Uses | Phalcon\Db\Enum, Phalcon\Mvc\Model\Query\Builder, Phalcon\Paginator\RepositoryInterface, Phalcon\Paginator\Exception | | Extends | AbstractAdapter |

Phalcon\Paginator\Adapter\QueryBuilder

Paginación usando un constructor de consultas PHQL como origen de datos

```php
use Phalcon\Paginator\Adapter\QueryBuilder;

$builder = $this->modelsManager->createBuilder()
                ->columns("id, name")
                ->from(Robots::class)
                ->orderBy("name");

$paginator = new QueryBuilder(
    [
        "builder" => $builder,
        "limit"   => 20,
        "page"    => 1,
    ]
);
```

## Propiedades

```php
/**
 * Paginator's data
 */
protected builder;

/**
 * Columns for count query if builder has having
 */
protected columns;

```

## Métodos

```php
public function __construct( array $config );
```

Phalcon\Paginator\Adapter\QueryBuilder

```php
public function getCurrentPage(): int;
```

Obtiene el número de página actual

```php
public function getQueryBuilder(): Builder;
```

Obtiene el objeto constructor de consultas

```php
public function paginate(): RepositoryInterface;
```

Devuelve un segmento del conjunto de resultados para mostrar en la paginación

```php
public function setQueryBuilder( Builder $builder ): QueryBuilder;
```

Establece el objeto constructor de consultas

<h1 id="paginator-exception">Class Phalcon\Paginator\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Paginator/Exception.zep)

| Namespace | Phalcon\Paginator | | Extends | \Phalcon\Exception |

Phalcon\Paginator\Exception

Las excepciones lanzadas en Phalcon\Paginator usarán esta clase

<h1 id="paginator-paginatorfactory">Class Phalcon\Paginator\PaginatorFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Paginator/PaginatorFactory.zep)

| Namespace | Phalcon\Paginator | | Uses | Phalcon\Paginator\Adapter\AdapterInterface, Phalcon\Factory\AbstractFactory, Phalcon\Helper\Arr | | Extends | AbstractFactory |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Métodos

```php
public function __construct( array $services = [] );
```

Constructor AdapterFactory.

```php
public function load( mixed $config ): AdapterInterface;
```

Factoría para crear una instancia desde un objeto Config

```php
use Phalcon\Paginator\PaginatorFactory;

$builder = $this
     ->modelsManager
     ->createBuilder()
     ->columns("id, name")
     ->from(Robots::class)
     ->orderBy("name");

$options = [
    "builder" => $builder,
    "limit"   => 20,
    "page"    => 1,
    "adapter" => "queryBuilder",
];

$paginator = (new PaginatorFactory())->load($options);
```

```php
public function newInstance( string $name, array $options = [] ): AdapterInterface;
```

Crea una nueva instancia del adaptador

```php
protected function getAdapters(): array;
```

<h1 id="paginator-repository">Class Phalcon\Paginator\Repository</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Paginator/Repository.zep)

| Namespace | Phalcon\Paginator | | Uses | JsonSerializable, Phalcon\Helper\Arr | | Implements | RepositoryInterface, JsonSerializable |

Phalcon\Paginator\Repository

Repositorio del estado actual Phalcon\Paginator\AdapterInterface::paginate()

## Propiedades

```php
/**
 * @var array
 */
protected aliases;

/**
 * @var array
 */
protected properties;

```

## Métodos

```php
public function __get( string $property ): mixed | null;
```
{@inheritdoc}


```php
public function getAliases(): array;
```
{@inheritdoc}


```php
public function getCurrent(): int;
```
{@inheritdoc}


```php
public function getFirst(): int;
```
{@inheritdoc}


```php
public function getItems(): mixed;
```
{@inheritdoc}


```php
public function getLast(): int;
```
{@inheritdoc}


```php
public function getLimit(): int;
```
{@inheritdoc}


```php
public function getNext(): int;
```
{@inheritdoc}


```php
public function getPrevious(): int;
```
{@inheritdoc}


```php
public function getTotalItems(): int;
```
{@inheritdoc}


```php
public function jsonSerialize(): array;
```

Ver [jsonSerialize](https://php.net/manual/en/jsonserializable.jsonserialize.php)

```php
public function setAliases( array $aliases ): RepositoryInterface;
```
{@inheritdoc}


```php
public function setProperties( array $properties ): RepositoryInterface;
```
{@inheritdoc}


```php
protected function getProperty( string $property, mixed $defaultValue = null ): mixed;
```

Obtiene el valor de la propiedad por nombre

```php
protected function getRealNameProperty( string $property ): string;
```

Resuelve el alias del nombre de propiedad

<h1 id="paginator-repositoryinterface">Interface Phalcon\Paginator\RepositoryInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Paginator/RepositoryInterface.zep)

| Namespace | Phalcon\Paginator |

Phalcon\Paginator\RepositoryInterface

Interfaz para el repositorio del estado actual Phalcon\Paginator\AdapterInterface::paginate()

## Constantes

```php
const PROPERTY_CURRENT_PAGE = current;
const PROPERTY_FIRST_PAGE = first;
const PROPERTY_ITEMS = items;
const PROPERTY_LAST_PAGE = last;
const PROPERTY_LIMIT = limit;
const PROPERTY_NEXT_PAGE = next;
const PROPERTY_PREVIOUS_PAGE = previous;
const PROPERTY_TOTAL_ITEMS = total_items;
```

## Métodos

```php
public function getAliases(): array;
```

Obtiene los alias del repositorio de propiedades

```php
public function getCurrent(): int;
```

Obtiene el número de la página actual

```php
public function getFirst(): int;
```

Obtiene el número de la primera página

```php
public function getItems(): mixed;
```

Obtiene los elementos de la página actual

```php
public function getLast(): int;
```

Obtiene el número de la última página

```php
public function getLimit(): int;
```

Obtiene el límite actual de filas

```php
public function getNext(): int;
```

Obtiene el número de la siguiente página

```php
public function getPrevious(): int;
```

Obtiene el número de la página anterior

```php
public function getTotalItems(): int;
```

Obtiene el número total de elementos

```php
public function setAliases( array $aliases ): RepositoryInterface;
```

Establece los alias del repositorio de propiedades

```php
public function setProperties( array $properties ): RepositoryInterface;
```

Establece valores para las propiedades del repositorio
