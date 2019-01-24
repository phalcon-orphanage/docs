---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Micro\Collection'
---
# Class **Phalcon\Mvc\Micro\Collection**

*implements* [Phalcon\Mvc\Micro\CollectionInterface](Phalcon_Mvc_Micro_CollectionInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/micro/collection.zep)

Groups Micro-Mvc handlers as controllers

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

## Metode

protected **_addMap** (*string* | *array* $method, *string* $routePattern, *mixed* $handler, *string* $name)

Fungsi internal untuk menambahkan handler ke grup

public **setPrefix** (*mixed* $prefix)

Menetapkan awalan untuk semua rute yang ditambahkan ke koleksi

public **getPrefix** ()

Mengembalikan awalan koleksi jika ada

public *array* **getHandlers** ()

Mengembalikan penangan yang terdaftar

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **setHandler** (*mixed* $handler, [*boolean* $lazy])

Menetapkan penangan utama

public **setLazy** (*mixed* $lazy)

Menetapkan apakah penangan utama harus malas dimuat

public **isLazy** ()

Kembali jika pawang utama harus malas dimuat

public *mixed* **getHandler** ()

Mengembalikan pawang utama

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **map** (*string* $routePattern, *callable* $handler, [*string* $name])

Memandu rute ke pawang

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **get** (*string* $routePattern, *callable* $handler, [*string* $name])

Peta rute ke handler yang hanya cocok jika metode HTTP nya adalah GET

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **post** (*string* $routePattern, *callable* $handler, [*string* $name])

Peta rute ke handler yang hanya cocok jika metode HTTP adalah POST

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **put** (*string* $routePattern, *callable* $handler, [*string* $name])

Peta rute ke handler yang hanya cocok jika metode HTTP adalah PUT

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **patch** (*string* $routePattern, *callable* $handler, [*string* $name])

Peta rute ke handler yang hanya cocok jika metode HTTP adalah PATCH

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **head** (*string* $routePattern, *callable* $handler, [*string* $name])

Peta rute ke handler yang hanya cocok jika metode HTTP adalah HEAD

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **delete** (*string* $routePattern, *callable* $handler, [*string* $name])

Peta rute ke handler yang hanya cocok jika metode HTTP adalah DELETE

public [Phalcon\Mvc\Micro\Collection](Phalcon_Mvc_Micro_Collection) **options** (*string* $routePattern, *callable* $handler, [*mixed* $name])

Peta rute ke handler yang hanya cocok jika metode HTTP adalah OPTIONS