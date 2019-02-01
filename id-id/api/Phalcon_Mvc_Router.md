---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Router'
---
# Class **Phalcon\Mvc\Router**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\RouterInterface](Phalcon_Mvc_RouterInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/router.zep)

Phalcon\Mvc\Router is the standard framework router. Routing is the process of taking a URI endpoint (that part of the URI which comes after the base URL) and decomposing it into parameters to determine which module, controller, and action of that controller should receive the request

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->add(
    "/documentation/{chapter}/{name}\.{type:[a-z]+}",
    [
        "controller" => "documentation",
        "action"     => "show",
    ]
);

$router->handle();

echo $router->getControllerName();

```

## Constants

*integer* **URI_SOURCE_GET_URL**

*integer* **URI_SOURCE_SERVER_REQUEST_URI**

*integer* **POSITION_FIRST**

*integer* **POSITION_LAST**

## Metode

public **__construct** ([*mixed* $defaultRoutes])

Phalcon\Mvc\Router constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Mengatur injector ketergantungan

publik **mendapatkanDI** ()

Mengembalikan injector ketergantungan internal

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Menyetel pengelola acara

publik **getEventsManager** ()

Mengembalikan manajer acara internal

public **getRewriteUri** ()

Get rewrite info. This info is read from $_GET["_url"]. This returns '/' if the rewrite information cannot be read

public **setUriSource** (*mixed* $uriSource)

Sets the URI source. One of the URI_SOURCE_* constants

```php
<?php

$router->setUriSource(
    Router::URI_SOURCE_SERVER_REQUEST_URI
);

```

public **removeExtraSlashes** (*mixed* $remove)

Tetapkan apakah router harus menghapus garis miring tambahan pada rute yang ditangani

umum ** setDefaultNamespace ** (* mixed * $namespaceName)

Menetapkan nama ruang nama default

public **setDefaultModule** (*mixed* $moduleName)

Menetapkan nama modul default

public **setDefaultController** (*mixed* $controllerName)

Menetapkan nama pengontrol default

publik **setDefaultTindakan** (*campuraduk* $actionName)

Sets the default action name

public **setDefaults** (*array* $defaults)

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

public **getDefaults** ()

Mengembalikan array parameter default

public **handle** ([*mixed* $uri])

Handles routing information received from the rewrite engine

```php
<?php

// Read the info from the rewrite engine
$router->handle();

// Manually passing an URL
$router->handle("/posts/edit/1");

```

public **add** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods], [*mixed* $position])

Menambahkan rute ke router tanpa batasan HTTP

```php
<?php

use Phalcon\Mvc\Router;

$router->add("/about", "About::index");
$router->add("/about", "About::index", ["GET", "POST"]);
$router->add("/about", "About::index", ["GET", "POST"], Router::POSITION_FIRST);

```

public **addGet** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Menambahkan rute ke router yang hanya cocok jika metode HTTP nya MENDAPATKAN

public **addPost** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Adds a route to the router that only match if the HTTP method is POST

public **addPut** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Adds a route to the router that only match if the HTTP method is PUT

public **addPatch** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Menambahkan rute ke router yang hanya cocok jika metode HTTP adalah PATCH

public **addDelete** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Menambahkan rute ke router yang hanya cocok jika metode HTTP adalah DELETE

public **addOptions** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Tambahkan rute ke router yang hanya cocok jika metode HTTP adalah OPTIONS

public **addHead** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Menambahkan rute ke router yang hanya cocok jika metode HTTP adalah KEPALA

public **addPurge** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Menambahkan rute ke router yang hanya cocok jika metode HTTP adalah PURGE (dukungan Squid dan Varnish)

public **addTrace** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Adds a route to the router that only match if the HTTP method is TRACE

public **addConnect** (*mixed* $pattern, [*mixed* $paths], [*mixed* $position])

Adds a route to the router that only match if the HTTP method is CONNECT

public **mount** ([Phalcon\Mvc\Router\GroupInterface](Phalcon_Mvc_Router_GroupInterface) $group)

Mounts a group of routes in the router

public **notFound** (*mixed* $paths)

Tetapkan sekelompok jalur yang akan dikembalikan bila tidak ada rute yang ditentukan yang cocok

publik **jelas** ()

Menghapus semua rute yang telah ditentukan sebelumnya

umum **getNamespaceName **()

Mengembalikan nama namespace yang diproses

publik **mendapatkanNamaModul** ()

Mengembalikan nama modul yang diproses

public **getControllerName** ()

Mengembalikan nama pengontrol yang diproses

publik **dapatkanNamaAksi** ()

Mengembalikan nama tindakan yang diproses

umum **getParams** ()

Mengembalikan parameter yang diproses

publik **DapatkanRuteyangsesuai** ()

Mengembalikan rute yang sesuai dengan URI yang ditangani

public **getMatches** ()

Mengembalikan sub ekspresi dalam ekspresi reguler yang sesuai

publik **telahDicantumkan** ()

Memeriksa apakah router cocok dengan rute yang ditentukan

publik **mendapatkanRute** ()

Mengembalikan semua rute yang didefinisikan di router

public **getRouteById** (*mixed* $id)

Mengembalikan objek rute dengan idnya

public **getRouteByName** (*mixed* $name)

Mengembalikan objek rute dengan namanya

public **isExactControllerName** ()

Mengembalikan apakah nama pengontrol tidak boleh hancur