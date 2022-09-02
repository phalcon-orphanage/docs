---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Container'
---

* [Phalcon\Container](#container)

<h1 id="container">Class Phalcon\Container</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Container.zep)

| Namespace | Phalcon | | Uses | Psr\Container\ContainerInterface, Phalcon\Di\DiInterface | | Implements | ContainerInterface |

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
public function get( mixed $name ): mixed;
```

Devuelve el servicio

```php
public function has( mixed $name ): bool;
```

Si el servicio existe o no en el contenedor
