---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Factory'
---

- Class [Phalcon\Factory\AbstractFactory](#Phalcon_Factory_AbstractFactory)
- Class [Phalcon\Factory\Exception](#Phalcon_Factory_Exception)

<a name="Phalcon_Factory_AbstractFactory"></a>

# Abstract Class **Phalcon\Factory\AbstractFactory**

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Factory/AbstractFactory.zep)

## Property

```php
// array
protected $mapper   = []; // Holds the mapping of names to classes
// array 
protected $services = []; // Holds the resolved instances
```

## メソッド

```php
protected function checkService( string $name ): void
```

Checks if a service exists and throws an exception

```php
protected function checkConfig( mixed $config ): array
```

Checks the config if it is a valid object

```php
abstract protected function getAdapters(): array
```

Returns the adapters for the factory

```php
protected function init( array $services = [] ): void
```

Populates the internal array of services

<hr />

<a name="Phalcon_Factory_Exception"></a>

# Class **Phalcon\Factory\Exception**

*extends* [Phalcon\Exception](Phalcon_Exception)

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Factory/Exception.zep)