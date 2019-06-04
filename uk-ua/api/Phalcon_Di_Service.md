---
layout: default
language: 'uk-ua'
version: '4.0'
title: 'Phalcon\Di\Service'
---

# Class **Phalcon\Di\Service**

*implements* [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di/service.zep)

Represents individually a service in the services container

```php
<?php

$service = new \Phalcon\Di\Service(
    "request",
    "Phalcon\Http\Request"
);

$request = service->resolve();
```

## Methods

final public **__construct** (*string* $name, *mixed* $definition, [*boolean* $shared])

public **getName** ()

Повертає ім'я служби

public **setShared** (*mixed* $shared)

Встановлює, чи є служба спільною чи ні

public **isShared** ()

Перевіряє, чи служба є спільною

public **setSharedInstance** (*mixed* $sharedInstance)

Встановлює/скидає спільний екземпляр пов'язаний із службою

public **setDefinition** (*mixed* $definition)

Встановлює визначення служби

public *mixed* **getDefinition** ()

Повертає визначення служби

public *mixed* **resolve** ([*array* $parameters], [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Resolves the service

public **setParameter** (*mixed* $position, *array* $parameter)

Changes a parameter in the definition without resolve the service

public *array* **getParameter** (*int* $position)

Returns a parameter in a specific position

public **isResolved** ()

Returns true if the service was resolved

public static **__set_state** (*array* $attributes)

Відновлює внутрішній стан служби