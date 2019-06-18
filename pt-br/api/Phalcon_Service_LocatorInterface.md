---
layout: default
language: 'pt-br'
version: '4.0'
title: 'Phalcon\Service\LocatorInterface'
---

# Class **Phalcon\Service\LocatorInterface**

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/service/locatorinterface.zep)

## Methods

```php
public function get( string $name ): object
```

Get a helper. If it is not in the mapper array, create a new object, set it and then return it.

* * *

```php
public function has( string $name ): bool;
```

Checks if a helper exists in the map array

* * *

```php
public function set( string $name, callable $helper ): void;
```

Set a new helper to the mapper array

* * *