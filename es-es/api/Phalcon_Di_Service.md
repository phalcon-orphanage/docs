---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Di\Service'
---
# Class **Phalcon\Di\Service**

*implements* [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di/service.zep)

Representa individualmente un servicio en el contenedor de servicios

```php
<?php

$service = new \Phalcon\Di\Service(
    "request",
    "Phalcon\Http\Request"
);

$request = service->resolve();
```

## Métodos

final public **__construct** (*string* $name, *mixed* $definition, [*boolean* $shared])

public **getName** ()

Devuelve el nombre del servicio

public **setShared** (*mixed* $shared)

Establece si el servicio es compartido o no

public **isShared** ()

Comprueba si el servicio es compartido o no

public **setSharedInstance** (*mixed* $sharedInstance)

Establece o restablece la instancia compartida relacionada al servicio

public **setDefinition** (*mixed* $definition)

Establece la definición del servicio

public *mixed* **getDefinition** ()

Devuelve la definición del servicio

public *mixed* **resolve** ([*array* $parameters], [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Resuelve el servicio

public **setParameter** (*mixed* $position, *array* $parameter)

Cambia un parámetro en la definición sin resolver el servicio

public *array* **getParameter** (*int* $position)

Devuelve un parámetro en una posición específica

public **isResolved** ()

Devuelve truve si se resolvió el servicio

public static **__set_state** (*array* $attributes)

Restaura el estado interno de un servicio