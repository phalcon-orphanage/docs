---
layout: default
title: 'Contenedor de inyección de dependencias (PSR-11)'
keywords: 'psr-11, di, contenedor, inyección de dependencias'
---

# Contenedor de inyección de dependencias (PSR-11)
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
[Phalcon\Container][container] is an implementation of the [PSR-11][psr-11] Container interface as defined by [PHP-FIG][php-fig].

![](/assets/images/implements-psr--11-blue.svg)

Este componente ayuda a recibir y establecer servicios en el contenedor DI

> **NOTE**: [Phalcon\Container][container] is not a _real_ implementation of [PSR-11][psr-11]. Por ahora actúa como un *proxy* del contenedor [Phalcon\Di](di). En versiones futuras, implementaremos este componente completamente y reemplazará el contenedor actual de inyección de dependencias. 
> 
> {: .alert .alert-warning }

## Activación
Para configurar el contenedor, primero necesita tener un objeto [Phalcon\Di](di) ya configurado.

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Container;

$default   = new FactoryDefault();
$container = new Container($default);

$request = $container->get('request');
```

[php-fig]: https://www.php-fig.org/
[psr-11]: https://www.php-fig.org/psr/psr-11/
[container]: api/phalcon_container#container
