---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Filter\FilterLocator'
---
# Class **Phalcon\Filter\FilterLocator**

**implements** [Phalcon\Service\LocatorInterface](Phalcon_Service_LocatorInterface)
**extends** [Phalcon\Service\Locator](Phalcon_Service_Locator)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/filterlocator.zep)

## Constants
* FILTER_ABSINT      = "absint";
* FILTER_ALNUM       = "alnum";
* FILTER_ALPHA       = "alpha";
* FILTER_BOOL        = "bool";
* FILTER_EMAIL       = "email";
* FILTER_FLOAT       = "float";
* FILTER_INT         = "int";
* FILTER_LOWER       = "lower";
* FILTER_LOWERFIRST  = "lowerFirst";
* FILTER_REGEX       = "regex";
* FILTER_REMOVE      = "remove";
* FILTER_REPLACE     = "replace";
* FILTER_SPECIAL     = "special";
* FILTER_SPECIALFULL = "specialFull";
* FILTER_STRING      = "string";
* FILTER_STRIPTAGS   = "striptags";
* FILTER_TRIM        = "trim";
* FILTER_UPPER       = "upper";
* FILTER_UPPERFIRST  = "upperFirst";
* FILTER_UPPERWORDS  = "upperWords";
* FILTER_URL         = "url";

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
Inherited from [Phalcon\Service\Locator](Phalcon_Service_Locator)

```php
public function __call( string $name, array $parameters ): mixed
```
Services being called via magic methods
Inherited from [Phalcon\Service\Locator](Phalcon_Service_Locator)

```php
public function get( string $name ): object
```
Get a service. If it is not in the mapper array, create a new object, set it and then return it.
Inherited from [Phalcon\Service\Locator](Phalcon_Service_Locator)

```php
public function has( string $name ): bool
```
Checks if a service exists in the map array
Inherited from [Phalcon\Service\Locator](Phalcon_Service_Locator)

```php
public function sanitize( mixed $value, mixed $sanitizers, bool $noRecursive = false): mixed
```
Sanitizes a value with a specified single or set of sanitizers

```php
public function set( string $name, callable $service ): void
```
Set a new service to the mapper array
Inherited from [Phalcon\Service\Locator](Phalcon_Service_Locator)