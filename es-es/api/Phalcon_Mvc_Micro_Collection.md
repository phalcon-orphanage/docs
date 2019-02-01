---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Mvc\Micro\Collection'
---
# Class **Phalcon\Mvc\Micro\Collection**

*implements* [Phalcon\Mvc\Micro\CollectionInterface](Phalcon_Mvc_Micro_CollectionInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/micro/collection.zep)

Agrupa controladores Micro-Mvc como controladores

```php
<?php

$app = new \Phalcon\Mvc\Micro();

$collection = new Collection();

$collection->setHandler(
    new PostsController()
);

$collection->get("/posts/edit/{id}", "edit");

$app->mount($collection);

```

## Métodos

protected **_addMap** (*string* | *array* $method, *string* $routePattern, *mixed* $handler, *string* $name)

Una función interna para agregar un controlador al grupo

public **setPrefix** (*mixed* $prefix)

Configura un prefijo para todas las rutas agregadas a la colección

public **getPrefix** ()

Devuelve el prefijo de la colección si hay alguno

public *array* **getHandlers** ()

Devuelve los controladores registrados

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **setHandler** (*mixed* $handler, [*boolean* $lazy])

Configura el controlador principal

public **setLazy** (*mixed* $lazy)

Establece si el controlador principal debe ser cargado de forma diferida

public **isLazy** ()

Devuelve si el controlador principal debe ser cargado de forma diferida

public *mixed* **getHandler** ()

Devuelve el controlador principal

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **map** (*string* $routePattern, *callable* $handler, [*string* $name])

Asigna una ruta a un controlador

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **get** (*string* $routePattern, *callable* $handler, [*string* $name])

Asigna una ruta a un controlador que solo coincide si el método HTTP es GET

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **post** (*string* $routePattern, *callable* $handler, [*string* $name])

Asigna una ruta a un controlador que solo coincide si el método HTTP es POST

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **put** (*string* $routePattern, *callable* $handler, [*string* $name])

Asigna una ruta a un controlador que solo coincide si el método HTTP es PUT

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **patch** (*string* $routePattern, *callable* $handler, [*string* $name])

Asigna una ruta a un controlador que solo coincide si el método HTTP es PATCH

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **head** (*string* $routePattern, *callable* $handler, [*string* $name])

Asigna una ruta a un controlador que solo coincide si el método HTTP es HEAD

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **delete** (*string* $routePattern, *callable* $handler, [*string* $name])

Asigna una ruta a un controlador que solo coincide si el método HTTP es DELETE

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **options** (*string* $routePattern, *callable* $handler, [*mixed* $name])

Asigna una ruta a un controlador que solo coincide si el método HTTP es OPTIONS