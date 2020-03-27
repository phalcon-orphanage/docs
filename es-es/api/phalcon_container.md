---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Container'
---

* [Phalcon\Container](#container)

<h1 id="container">Class Phalcon\Container</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/container.zep)

| Namespace | Phalcon | | Uses | Psr\Container\ContainerInterface, Phalcon\Di\DiInterface | | Implements | ContainerInterface |

PSR-11 Wrapper for `Phalcon\Di`

## Propiedades

```php
/**
 * @var DiInterface
 */
protected container;

```

## Métodos

```php
public function __construct( DiInterface $container );
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