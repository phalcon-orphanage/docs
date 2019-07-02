---
layout: default
language: 'en'
version: '4.0'
title: 'Phalcon\Container'
---

* [Phalcon\Container\Container](#container-container)
        
<h1 id="container-container">Class Phalcon\Container\Container</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/container/container.zep)

| Namespace  | Phalcon\Container |
| Uses       | Psr\Container\ContainerInterface, Phalcon\DiInterface |
| Implements | ContainerInterface |

PSR-11 Wrapper for `Phalcon\Di`


## Properties
```php
/**
 * @var <DiInterface>
 */
protected container;

```

## Methods
```php
public function __construct( DiInterface $container ): void;
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


