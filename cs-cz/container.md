---
layout: default
language: 'cs-cz'
title: 'Dependency Injection Container (PSR-11)'
keywords: 'psr-11, di, container, dependency injection'
---

# Dependency Injection Container (PSR-11)
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Overview
[Phalcon\Container][container] is an implementation of the [PSR-11][psr-11] Container interface as defined by [PHP-FIG][php-fig].

![](/assets/images/implements-psr--11-blue.svg)

This component aids with receiving and setting services in the DI container

> **NOTE**: [Phalcon\Container][container] is not a _real_ implementation of [PSR-11][psr-11]. For now it acts as a proxy to the [Phalcon\Di](di) container. In future versions, we will implement this component fully and it will replace the current Dependency Injection container. 
> 
> {: .alert .alert-warning }

## Activation
To set the container up, you first need to have a [Phalcon\Di](di) object already set up.

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
