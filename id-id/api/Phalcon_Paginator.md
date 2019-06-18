---
layout: default
language: 'id-id'
version: '4.0'
title: 'Phalcon\Paginator'
---

<a name="Phalcon_Paginator_PaginatorFactory"></a>

# Class **Phalcon\Paginator\PaginatorFactory**

*extends* [Phalcon\Factory\AbstractFactory](Phalcon_Factory)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/PaginatorFactory.zep)

## Methods

```php
public function __construct(array $services = [])
```

Constructor. Accepts an array of key/value pairs for Paginator objects. Key is the unique name, while the value holds the class name.

```php
public function load(mixed $config): PaginatorAdapterInterface
```

Constructs a Paginator adapter based on configuration passed. The configuration can be either an array or a [Phalcon\Config](Phalcon_Config) object.

```php
public function newInstance(string $name, array $options = []): AbstractAdapter
```

Creates a new Paginator object based on the passed name and adapter options.

```php
protected function getAdapters(): array
```

Returns an array of available adapters

<hr />

<a name="Phalcon_Paginator_Repository"></a>

# Class **Phalcon\Paginator\Repository**

*implements* [Phalcon\Paginator\RepositoryInterface](#Phalcon_Paginator_RepositoryInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/Repository.zep)

## Properties

```php
/**
 * @var array
 */
protected aliases    = [];

/**
 * @var array
 */
protected properties = [];
```

## Methods

```php
public function __get(string $property): mixed | null
```

Magic get method for available properties

```php
public function getAliases(): array
```

Gets the aliases for properties repository

```php
public function getCurrent(): int
```

Gets number of the current page

```php
public function getFirst(): int
```

Gets number of the first page

```php
public function getItems(): mixed
```

Gets the items on the current page

```php
public function getLast(): int
```

Gets number of the last page

```php
public function getLimit(): int
```

Gets current rows limit

```php
public function getNext(): int
```

Gets number of the next page

```php
public function getPrevious(): int
```

Gets number of the previous page

```php
public function getTotalItems(): int
```

Gets the total number of items

```php
public function setAliases(array $aliases): \Phalcon\Paginator\RepositoryInterface
```

Sets the aliases for properties repository

```php
public function setProperties(array $properties): \Phalcon\Paginator\RepositoryInterface
 ```

Sets values for properties of the repository

```php
protected function getProperty(string $property, mixed $defaultValue = null): mixed
```

Gets value of property by name

```php
protected function getRealNameProperty(string $property): string
```

Resolve alias property name

<hr />

<a name="Phalcon_Paginator_RepositoryInterface"></a>

# Interface **Phalcon\Paginator\RepositoryInterface**

*implements* [Phalcon\Paginator\RepositoryInterface](#Phalcon_Paginator_RepositoryInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/RepositoryInterface.zep)

## Constants

```php
const PROPERTY_CURRENT_PAGE  = "current";
const PROPERTY_FIRST_PAGE    = "first";
const PROPERTY_ITEMS         = "items";
const PROPERTY_LAST_PAGE     = "last";
const PROPERTY_LIMIT         = "limit";
const PROPERTY_NEXT_PAGE     = "next";
const PROPERTY_PREVIOUS_PAGE = "previous";
const PROPERTY_TOTAL_ITEMS   = "total_items";
```

## Methods

```php
public function getAliases(): array
```

Gets the aliases for properties repository

```php
public function getCurrent(): int
```

Gets number of the current page

```php
public function getFirst(): int
```

Gets number of the first page

```php
public function getItems(): mixed
```

Gets the items on the current page

```php
public function getLast(): int
```

Gets number of the last page

```php
public function getLimit(): int
```

Gets current rows limit

```php
public function getNext(): int
```

Gets number of the next page

```php
public function getPrevious(): int
```

Gets number of the previous page

```php
public function getTotalItems(): int
```

Gets the total number of items

```php
public function setAliases(array $aliases): \Phalcon\Paginator\RepositoryInterface
```

Sets the aliases for properties repository

```php
public function setProperties(array $properties): \Phalcon\Paginator\RepositoryInterface
```

Sets values for properties of the repository

<hr />

<a name="Phalcon_Paginator_Exception"></a>

# Class **Phalcon\Paginator\Exception**

*extends* [Phalcon\Exception](Phalcon_Exception)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Exception.zep)

<hr />

<a name="Phalcon_Paginator_Adapter\AdapterInterface"></a>

# Interface **Phalcon\Paginator\Adapter\AdapterInterface**

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/Adapter/AdapterInterface.zep)

## Methods

```php
public function getLimit(): int;
```

Get current rows limit

```php
public function paginate():  \Phalcon\Paginator\RepositoryInterface;
```

Returns a slice of the resultset to show in the pagination

```php
public function setCurrentPage(int $page);
```

Set the current page number

```php
public function setLimit(int $limit);
```

Set current rows limit

<hr />

<a name="Phalcon_Paginator_Adapter_AbstractAdapter"></a>

# Abstract Class **Phalcon\Paginator\Adapter\AbstractAdapter**

*implements* [Phalcon\Paginator\Adapter\AdapterInterface](#Phalcon_Paginator_Adapter_AdapterInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/Adapter/AbstractAdapter.zep)

## Properties

```php
/**
 * @var array
 */
protected config;
```

Configuration of paginator

```php
/**
 * @var int|null
 */
protected limitRows = null;
```

Number of rows to show in the paginator. By default is null

```php
/**
 * @var int|null
 */
protected page = null;
```

Current page in paginate

```php
/**
 * @var RepositoryInterface
 */
protected repository;
```

Repository for pagination

## Methods

```php
public function getLimit(): int;
```

Get current rows limit

```php
public function __construct(array $config): void
```

Constructor

```php
public function getLimit(): int
```

Get current rows limit

```php
public function setCurrentPage(int $page): \Phalcon\Paginator\Adapter\AbstractAdapter
```

Set the current page number

```php
public function setLimit(int $limitRows): \Phalcon\Paginator\Adapter\AbstractAdapter
```

Set current rows limit

```php
public function setRepository(\Phalcon\Paginator\RepositoryInterface $repository): \Phalcon\Paginator\Adapter\AbstractAdapter
```

Sets current repository for pagination

```php
protected function getRepository(array $properties = null): \Phalcon\Paginator\RepositoryInterface
```

Gets current repository for pagination

<hr />

<a name="Phalcon_Paginator_Adapter\Model"></a>

# Class **Phalcon\Paginator\Adapter\Model**

*extends* [Phalcon\Paginator\Adapter\AbstractAdapter](#Phalcon_Paginator_Adapter_AbstractAdapter)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/Adapter/Model.zep)

## Methods

```php
public function paginate(): \Phalcon\Paginator\RepositoryInterface
```

Returns a slice of the resultset to show in the pagination

<hr />

<a name="Phalcon_Paginator_Adapter\NativeArray"></a>

# Class **Phalcon\Paginator\Adapter\NativeArray**

*extends* [Phalcon\Paginator\Adapter\AbstractAdapter](#Phalcon_Paginator_Adapter_AbstractAdapter)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/Adapter/NativeArray.zep)

## Methods

```php
public function paginate(): \Phalcon\Paginator\RepositoryInterface
```

Returns a slice of the resultset to show in the pagination

<hr />

<a name="Phalcon_Paginator_Adapter\QueryBuilder"></a>

# Class **Phalcon\Paginator\Adapter\QueryBuilder**

*extends* [Phalcon\Paginator\Adapter\AbstractAdapter](#Phalcon_Paginator_Adapter_AbstractAdapter)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Paginator/Adapter/QueryBuilder.zep)

## Properties

```php
/**
 * @var \Phalcon\Mvc\Model\Query\Builder
 */
protected $builder
```

Paginator's data

```php
protected $columns
```

Columns for count query if builder has having

## Methods

```php
public function __construct(array $config)
```

Constructor

```php
public function getCurrentPage(): int
```

Get the current page number

```php
public function getQueryBuilder(): \Phalcon\Mvc\Model\Query\Builder
```

Get query builder object

```php
public function paginate(): \Phalcon\Paginator\RepositoryInterface
```

Returns a slice of the resultset to show in the pagination

```php
public function setQueryBuilder(\Phalcon\Mvc\Model\Query\Builder $builder): Phalcon\Paginator\Adapter\QueryBuilder
```

Set query builder object