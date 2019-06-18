---
layout: default
language: 'pt-br'
version: '4.0'
title: 'Phalcon\Service\Locator'
---

# Class **Phalcon\Service\Locatorr**

**implements** [Phalcon\Service\LocatorInterface](Phalcon_Service_LocatorInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/service/locator.zep)

## Properties

### Protected

```php
array $services = [];

array $mapper = [];
```

## Methods

```php
public function __construct( array $mapper = [] ): void
```

Key value pairs with name as the key and a callable as the value for the service object

* * *

```php
public function __call( string $name, array $parameters ): mixed
```

Services being called via magic methods

* * *

```php
public function get( string $name ): object
```

Get a service. If it is not in the mapper array, create a new object, set it and then return it.

* * *

```php
public function has( string $name ): bool
```

Checks if a service exists in the map array

* * *

```php
public function set( string $name, callable $service ): void
```

Set a new service to the mapper array

* * *