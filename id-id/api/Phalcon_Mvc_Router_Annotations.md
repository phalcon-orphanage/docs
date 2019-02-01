---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Router\Annotations'
---
# Class **Phalcon\Mvc\Router\Annotations**

*extends* class [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Mvc\RouterInterface](Phalcon_Mvc_RouterInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/router/annotations.zep)

Sebuah router yang membaca anotasi rute dari kelas sumber-kesumber

```php
<?php

use Phalcon\Mvc\Router\Annotations;

$di->setShared(
    "router",
    function() {
        // Use the annotations router
        $router = new Annotations(false);

        // This will do the same as above but only if the handled uri starts with /robots
        $router->addResource("Robots", "/robots");

        return $router;
    }
);

```

## Constants

*integer* **URI_SOURCE_GET_URL**

*integer* **URI_SOURCE_SERVER_REQUEST_URI**

*integer* **POSITION_FIRST**

*integer* **POSITION_LAST**

## Metode

publik **menambahkan Sumber** (*campur aduk* $handler, [*campur aduk* $prefix])

Menambahkan sumber daya ke penangan anotasi Sumber daya adalah kelas yang berisi anotasi rute

publik **tambahkan Modul Sumber** (*Bercampur* $module, *Bercampur* $handler, [*Bercampur* $prefix])

Menambahkan sumber daya ke penangan anotasi Sumber daya adalah kelas yang berisi anotasi rute Kelas berada dalam modul

public **handle** ([*mixed* $uri])

Menghasilkan parameter Menghasilkan parameter rute dari informasi penulisan ulang dari informasi penulisan ulang

public **processControllerAnnotation** (*mixed* $handler, [Phalcon\Annotations\Annotation](Phalcon_Annotations_Annotation) $annotation)

Cek anotasi di blok doc pengontrol

public **processActionAnnotation** (*mixed* $module, *mixed* $namespaceName, *mixed* $controller, *mixed* $action, [Phalcon\Annotations\Annotation](Phalcon_Annotations_Annotation) $annotation)

Cek anotasi dalam metode umum pengontrol

public **setControllerSuffix** (*mixed* $controllerSuffix)

Mengubah akhiran kelas atur

umum ** setActionSuffix ** (* campuran * $actionSuffix)

Mengubah akhiran metode tindakan

publik **dapatkansumberdaya** ()

Return sumber daya yang terdaftar

public **__construct** ([*mixed* $defaultRoutes]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Phalcon\Mvc\Router constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mengatur injector ketergantungan

public **getDI** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mengembalikan injector ketergantungan internal

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Menyetel pengelola acara

public **getEventsManager** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mengembalikan manajer acara internal

public **getRewriteUri** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Get rewrite info. This info is read from $_GET["_url"]. This returns '/' if the rewrite information cannot be read

public **setUriSource** (*mixed* $uriSource) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Sets the URI source. One of the URI_SOURCE_* constants

```php
<?php

$router->setUriSource(
    Router::URI_SOURCE_SERVER_REQUEST_URI
);

```

public **removeExtraSlashes** (*mixed* $remove) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Tetapkan apakah router harus menghapus garis miring tambahan pada rute yang ditangani

public **setDefaultNamespace** (*mixed* $namespaceName) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Menetapkan nama ruang nama default

public **setDefaultModule** (*mixed* $moduleName) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Menetapkan nama modul default

public **setDefaultController** (*mixed* $controllerName) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Menetapkan nama pengontrol default

public **setDefaultAction** (*mixed* $actionName) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Sets the default action name

public **setDefaults** (*array* $defaults) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Sets an array of default paths. If a route is missing a path the router will use the defined here This method must not be used to set a 404 route

```php
<?php

$router->setDefaults(
    [
        "module" => "common",
        "action" => "index",
    ]
);

```

public **getDefaults** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mengembalikan array parameter default

public **add** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Menambahkan rute ke router tanpa batasan HTTP

```php
<?php

use Phalcon\Mvc\Router;

$router->add("/about", "About::index");
$router->add("/about", "About::index", ["GET", "POST"]);
$router->add("/about", "About::index", ["GET", "POST"], Router::POSITION_FIRST);

```

public **addGet** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Menambahkan rute ke router yang hanya cocok jika metode HTTP nya MENDAPATKAN

public **addPost** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is POST

public **addPut** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is PUT

public **addPatch** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Menambahkan rute ke router yang hanya cocok jika metode HTTP adalah PATCH

public **addDelete** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Menambahkan rute ke router yang hanya cocok jika metode HTTP adalah DELETE

public **addOptions** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Tambahkan rute ke router yang hanya cocok jika metode HTTP adalah OPTIONS

public **addHead** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Menambahkan rute ke router yang hanya cocok jika metode HTTP adalah KEPALA

public **addPurge** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Menambahkan rute ke router yang hanya cocok jika metode HTTP adalah PURGE (dukungan Squid dan Varnish)

public **addTrace** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is TRACE

public **addConnect** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position]) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Adds a route to the router that only match if the HTTP method is CONNECT

public **mount** ([Phalcon\Mvc\Router\GroupInterface](Phalcon_Mvc_Router_GroupInterface) $group) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mounts a group of routes in the router

public **notFound** (*mixed* $paths) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Tetapkan sekelompok jalur yang akan dikembalikan bila tidak ada rute yang ditentukan yang cocok

public **clear** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Menghapus semua rute yang telah ditentukan sebelumnya

public **getNamespaceName** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mengembalikan nama namespace yang diproses

public **getModuleName** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mengembalikan nama modul yang diproses

public **getControllerName** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mengembalikan nama pengontrol yang diproses

public **getActionName** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mengembalikan nama tindakan yang diproses

public **getParams** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mengembalikan parameter yang diproses

public **getMatchedRoute** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mengembalikan rute yang sesuai dengan URI yang ditangani

public **getMatches** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mengembalikan sub ekspresi dalam ekspresi reguler yang sesuai

public **wasMatched** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Memeriksa apakah router cocok dengan rute yang ditentukan

public **getRoutes** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mengembalikan semua rute yang didefinisikan di router

public **getRouteById** (*mixed* $id) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mengembalikan objek rute dengan idnya

public **getRouteByName** (*mixed* $name) inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mengembalikan objek rute dengan namanya

public **isExactControllerName** () inherited from [Phalcon\Mvc\Router](Phalcon_Mvc_Router)

Mengembalikan apakah nama pengontrol tidak boleh hancur