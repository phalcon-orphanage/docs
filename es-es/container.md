---
layout: default
language: 'es-es'
version: '4.0'
title: 'Contenedor de inyección de dependencias (PSR-11)'
keywords: 'psr-11, di, contenedor, inyección de dependencias'
---

# Contenedor de inyección de dependencias (PSR-11)
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Preámbulo
[Phalcon\Container](api/phalcon_container#container) es una implementación del Interfaz de Contenedor [PSR-11](https://www.php-fig.org/psr/psr-11/) definido por [PHP-FIG](https://www.php-fig.org/).

![](/assets/images/implements-psr--11-blue.svg)

Este componente ayuda a recibir y establecer servicios en el contenedor DI

> **NOTA**: [Phalcon\Container](api/phalcon_container#container) no es una _verdadera_ implementación de [PSR-11](https://www.php-fig.org/psr/psr-11/). Por ahora actúa como un *proxy* del contenedor [Phalcon\Di](di). En versiones futuras, implementaremos este componente completamente y reemplazará el contenedor actual de inyección de dependencias. 
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
