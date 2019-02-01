---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Router\Group'
---
# Class **Phalcon\Mvc\Router\Group**

*implements* [Phalcon\Mvc\Router\GroupInterface](Phalcon_Mvc_Router_GroupInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/router/group.zep)

Kelas pembantu membuat kelompok rute dengan atribut umum

```php
<?php

$router = new \Phalcon\Mvc\Router();

//Create a group with a common module and controller
$blog = new Group(
    [
        "module"     => "blog",
        "controller" => "index",
    ]
);

//All the routes start with /blog
$blog->setPrefix("/blog");

//Add a route to the group
$blog->add(
    "/save",
    [
        "action" => "save",
    ]
);

//Add another route to the group
$blog->add(
    "/edit/{id}",
    [
        "action" => "edit",
    ]
);

//This route maps to a controller different than the default
$blog->add(
    "/blog",
    [
        "controller" => "about",
        "action"     => "index",
    ]
);

//Add the group to the router
$router->mount($blog);

```

## Metode

public **__construct** ([*mixed* $paths])

Phalcon\Mvc\Router\Group constructor

public **setHostname** (*mixed* $hostname)

Tetapkan batasan nama host untuk semua rute dalam grup

public **getHostname** ()

Mengembalikan batasan hostname

public **setPrefix** (*mixed* $prefix)

Tetapkan awalan umum uri untuk semua rute dalam grup ini

public **getPrefix** ()

Mengembalikan awalan umum untuk semua rute

public **beforeMatch** (*mixed* $beforeMatch)

Sets a callback that is called if the route is matched. The developer can implement any arbitrary conditions here If the callback returns false the route is treated as not matched

public **getBeforeMatch** ()

Mengembalikan callback 'sebelum pertandingan' jika ada

public **setPaths** (*mixed* $paths)

Tetapkan jalur umum untuk semua rute dalam grup

publik **mendapatkanJalan** ()

Mengembalikan jalur umum yang ditetapkan untuk grup ini

publik **mendapatkanRute** ()

Mengembalikan rute yang ditambahkan ke grup

public **add** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods])

Menambahkan rute ke router pada setiap metode HTTP

```php
<?php

$router->add("/about", "About::index");

```

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addGet** (*string* $pattern, [*string/array* $paths])

Menambahkan rute ke router yang hanya cocok jika metode HTTP nya MENDAPATKAN

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addPost** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is POST

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addPut** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is PUT

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addPatch** (*string* $pattern, [*string/array* $paths])

Menambahkan rute ke router yang hanya cocok jika metode HTTP adalah PATCH

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addDelete** (*string* $pattern, [*string/array* $paths])

Menambahkan rute ke router yang hanya cocok jika metode HTTP adalah DELETE

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addOptions** (*string* $pattern, [*string/array* $paths])

Tambahkan rute ke router yang hanya cocok jika metode HTTP adalah OPTIONS

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addHead** (*string* $pattern, [*string/array* $paths])

Menambahkan rute ke router yang hanya cocok jika metode HTTP adalah KEPALA

publik **jelas** ()

Menghapus semua rute yang telah ditentukan sebelumnya

protected **_addRoute** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods])

Menambahkan rute yang menerapkan atribut umum