---
layout: default
language: 'nl-nl'
version: '4.0'
title: 'Phalcon\Container'
---

* [Phalcon\Container](#Container)

<h1 id="Container">Class Phalcon\Container</h1>

[Broncode op GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/container.zep)

| Namespace | Phalcon | | Uses | Psr\Container\ContainerInterface, Phalcon\DiInterface | | Implements | ContainerInterface |

PSR-11 Wrapper for `Phalcon\Di`

## Properties

```php
/**
 * @var <DiInterface>
 */
protected container;

```

## Methoden

```php
public function __construct( mixed $container ): void;
```

Phalcon\Container constructor

```php
public function get( mixed $name ): mixed;
```

Return the service

```php
public function has( mixed $name ): bool;
```

Whether a service exists or not in the container