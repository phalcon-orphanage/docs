---
layout: default
language: 'sr-sp'
version: '4.0'
title: 'Phalcon\Filter\FilterLocator'
---

# Class [Phalcon\Filter\FilterLocator](Phalcon_Filter_FilterLocator)

**extends** [Phalcon\Service\Locator](Phalcon_Service_Locator)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/filterlocator.zep)

Creates a [Phalcon\Filter\FilterLocator](Phalcon_Filter_FilterLocator) class. You can add any sanitizers you want in it.

### Constants

```php
<br />const FILTER_ABSINT      = 'absint';
const FILTER_ALNUM       = 'alnum';
const FILTER_ALPHA       = 'alpha';
const FILTER_BOOL        = 'bool';
const FILTER_EMAIL       = 'email';
const FILTER_FLOAT       = 'float';
const FILTER_INT         = 'int';
const FILTER_LOWER       = 'lower';
const FILTER_LOWERFIRST  = 'lowerFirst';
const FILTER_REGEX       = 'regex';
const FILTER_REMOVE      = 'remove';
const FILTER_REPLACE     = 'replace';
const FILTER_SPECIAL     = 'special';
const FILTER_SPECIALFULL = 'specialFull';
const FILTER_STRING      = 'string';
const FILTER_STRIPTAGS   = 'striptags';
const FILTER_TRIM        = 'trim';
const FILTER_UPPER       = 'upper';
const FILTER_UPPERFIRST  = 'upperFirst';
const FILTER_UPPERWORDS  = 'upperWords';
const FILTER_URL         = 'url';
```

## Properties

### Protected

```php
protected $services = array();
protected $mapper   = array();
```

## Methods

```php
public function sanitize( mixed $value, string|array $sanitizers, bool $noRecursive = false ): mixed
```

Sanitizes a value with a specified single or set of sanitizers

```php
public function __construct( array $mapper = array() )
```

Key value pairs with name as the key and a callable as the value for the service object

```php
public function __call( string $name, array $parameters ): mixed 
```

Services being called via magic methods

```php
public function get( string $name ): object
```

Get a service. If it is not in the mapper array, create a new object, set it and then return it.

```php
public function has( string $name ): bool
```

Checks if a service exists in the map array

```php
public function set( string $name, Callable $service ): void
```

Set a new service to the mapper array