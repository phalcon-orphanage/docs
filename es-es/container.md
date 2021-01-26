---
layout: default
language: 'es-es'
version: '4.0'
title: 'Contenedor de inyección de dependencias (PSR-11)'
keywords: 'psr-11, di, contenedor, inyección de dependencias'
---

# Contenedor de inyección de dependencias (PSR-11)
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Preámbulo
[Phalcon\Container](api/phalcon_container#container) is an implementation of the [PSR-11](https://www.php-fig.org/psr/psr-11/) Container interface as defined by [PHP-FIG](https://www.php-fig.org/).

![](/assets/images/implements-psr--11-blue.svg)

This component aids with receiving and setting services in the DI container

> **NOTA**: [Phalcon\Container](api/phalcon_container#container) no es una _verdadera_ implementación de [PSR-11](https://www.php-fig.org/psr/psr-11/). Por ahora actúa como un *proxy* del contenedor [Phalcon\Di](di). En versiones futuras, implementaremos este componente completamente y reemplazará el contenedor actual de inyección de dependencias. 
> 
> {: .alert .alert-warning }

## Activación
To set the container up, you first need to have a [Phalcon\Di](di) object already set up.

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Container;

$default   = new FactoryDefault();
$container = new Container($default);

$request = $container->get('request');
```

