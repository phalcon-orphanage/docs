---
layout: default
title: 'Phalcon\Container'
---

* [Phalcon\Container\Container](#container-container)

<h1 id="container-container">Class Phalcon\Container\Container</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Container/Container.zep)

| Namespace  | Phalcon\Container | | Uses       | Psr\Container\ContainerInterface, Phalcon\Di\DiInterface | | Implements | ContainerInterface |

Envoltura PSR-11 para `Phalcon\Di`


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
Constructor Phalcon\Container


```php
public function get( string $name ): mixed;
```
Devuelve el servicio


```php
public function has( string $name ): bool;
```
Si el servicio existe o no en el contenedor
