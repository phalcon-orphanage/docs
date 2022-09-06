---
layout: default
title: 'Phalcon\Container'
---

* [Phalcon\Container\Container](#container-container)

<h1 id="container-container">Class Phalcon\Container\Container</h1>

[Source sur GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Container/Container.zep)

| Namespace  | Phalcon\Container | | Uses       | Psr\Container\ContainerInterface, Phalcon\Di\DiInterface | | Implements | ContainerInterface |

PSR-11 Wrapper for `Phalcon\Di`


## Properties
```php
/**
 * @var DiInterface
 */
protected container;

```

## Méthodes

```php
public function __construct( DiInterface $container );
```
Phalcon\Container constructor


```php
public function get( string $name ): mixed;
```
Return the service


```php
public function has( string $name ): bool;
```
Whether a service exists or not in the container
