---
layout: default
language: 'th-th'
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

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/Adapter/AbstractAdapter.zep)

| Namespace | Phalcon\Paginator\Adapter | | Uses | Phalcon\Paginator\Exception, Phalcon\Paginator\Repository, Phalcon\Paginator\RepositoryInterface | | Implements | AdapterInterface |

Phalcon\Paginator\Adapter\AbstractAdapter

## Properties

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

## Methods

Phalcon\Paginator\Adapter\AbstractAdapter constructor

```php
public function __construct( array $config );
```

Get current rows limit

```php
public function getLimit(): int;
```

Set the current page number

```php
public function setCurrentPage( int $page ): AdapterInterface;
```

Set current rows limit

```php
public function setLimit( int $limitRows ): AdapterInterface;
```

Sets current repository for pagination

```php
public function setRepository( RepositoryInterface $repository ): AdapterInterface;
```

Gets current repository for pagination

```php
protected function getRepository( array $properties = null ): RepositoryInterface;
```

<h1 id="paginator-adapter-adapterinterface">Interface Phalcon\Paginator\Adapter\AdapterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/Adapter/AdapterInterface.zep)

| Namespace | Phalcon\Paginator\Adapter | | Uses | Phalcon\Paginator\RepositoryInterface |

Phalcon\Paginator\AdapterInterface

Interface for Phalcon\Paginator adapters

## Methods

Get current rows limit

```php
public function getLimit(): int;
```

Returns a slice of the resultset to show in the pagination

```php
public function paginate(): RepositoryInterface;
```

Set the current page number

```php
public function setCurrentPage( int $page );
```

Set current rows limit

```php
public function setLimit( int $limit );
```

<h1 id="paginator-adapter-model">Class Phalcon\Paginator\Adapter\Model</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/Adapter/Model.zep)

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

## Methods

Returns a slice of the resultset to show in the pagination

```php
public function paginate(): RepositoryInterface;
```

<h1 id="paginator-adapter-nativearray">Class Phalcon\Paginator\Adapter\NativeArray</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/Adapter/NativeArray.zep)

| Namespace | Phalcon\Paginator\Adapter | | Uses | Phalcon\Paginator\Exception, Phalcon\Paginator\RepositoryInterface | | Extends | AbstractAdapter |

Phalcon\Paginator\Adapter\NativeArray

Pagination using a PHP array as source of data

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

## Methods

Returns a slice of the resultset to show in the pagination

```php
public function paginate(): RepositoryInterface;
```

<h1 id="paginator-adapter-querybuilder">Class Phalcon\Paginator\Adapter\QueryBuilder</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/Adapter/QueryBuilder.zep)

| Namespace | Phalcon\Paginator\Adapter | | Uses | Phalcon\Db\Enum, Phalcon\Mvc\Model\Query\Builder, Phalcon\Paginator\RepositoryInterface, Phalcon\Paginator\Exception | | Extends | AbstractAdapter |

Phalcon\Paginator\Adapter\QueryBuilder

Pagination using a PHQL query builder as source of data

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

## Properties

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

## Methods

Phalcon\Paginator\Adapter\QueryBuilder

```php
public function __construct( array $config );
```

Get the current page number

```php
public function getCurrentPage(): int;
```

Get query builder object

```php
public function getQueryBuilder(): Builder;
```

Returns a slice of the resultset to show in the pagination

```php
public function paginate(): RepositoryInterface;
```

Set query builder object

```php
public function setQueryBuilder( Builder $builder ): QueryBuilder;
```

<h1 id="paginator-exception">Class Phalcon\Paginator\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/Exception.zep)

| Namespace | Phalcon\Paginator | | Extends | \Phalcon\Exception |

Phalcon\Paginator\Exception

Exceptions thrown in Phalcon\Paginator will use this class

<h1 id="paginator-paginatorfactory">Class Phalcon\Paginator\PaginatorFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/PaginatorFactory.zep)

| Namespace | Phalcon\Paginator | | Uses | Phalcon\Paginator\Adapter\AdapterInterface, Phalcon\Factory\AbstractFactory, Phalcon\Helper\Arr | | Extends | AbstractFactory |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

## Methods

AdapterFactory constructor.

```php
public function __construct( array $services = [] );
```

Factory to create an instance from a Config object

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
public function load( mixed $config ): AdapterInterface;
```

Create a new instance of the adapter

```php
public function newInstance( string $name, array $options = [] ): AdapterInterface;
```

```php
protected function getAdapters(): array;
```

<h1 id="paginator-repository">Class Phalcon\Paginator\Repository</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/Repository.zep)

| Namespace | Phalcon\Paginator | | Uses | JsonSerializable, Phalcon\Helper\Arr | | Implements | RepositoryInterface, JsonSerializable |

Phalcon\Paginator\Repository

Repository of current state Phalcon\Paginator\AdapterInterface::paginate()

## Properties

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

## Methods

{@inheritdoc}
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

See [jsonSerialize](https://php.net/manual/en/jsonserializable.jsonserialize.php)

```php
public function jsonSerialize(): array;
```

{@inheritdoc}
```php
public function setAliases( array $aliases ): RepositoryInterface;
```

{@inheritdoc}
```php
public function setProperties( array $properties ): RepositoryInterface;
```

Gets value of property by name

```php
protected function getProperty( string $property, mixed $defaultValue = null ): mixed;
```

Resolve alias property name

```php
protected function getRealNameProperty( string $property ): string;
```

<h1 id="paginator-repositoryinterface">Interface Phalcon\Paginator\RepositoryInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/RepositoryInterface.zep)

| Namespace | Phalcon\Paginator |

Phalcon\Paginator\RepositoryInterface

Interface for the repository of current state Phalcon\Paginator\AdapterInterface::paginate()

## Constants

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

## Methods

Gets the aliases for properties repository

```php
public function getAliases(): array;
```

Gets number of the current page

```php
public function getCurrent(): int;
```

Gets number of the first page

```php
public function getFirst(): int;
```

Gets the items on the current page

```php
public function getItems(): mixed;
```

Gets number of the last page

```php
public function getLast(): int;
```

Gets current rows limit

```php
public function getLimit(): int;
```

Gets number of the next page

```php
public function getNext(): int;
```

Gets number of the previous page

```php
public function getPrevious(): int;
```

Gets the total number of items

```php
public function getTotalItems(): int;
```

Sets the aliases for properties repository

```php
public function setAliases( array $aliases ): RepositoryInterface;
```

Sets values for properties of the repository

```php
public function setProperties( array $properties ): RepositoryInterface;
```