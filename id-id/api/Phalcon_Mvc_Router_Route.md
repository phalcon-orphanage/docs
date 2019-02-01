---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Router\Route'
---
# Class **Phalcon\Mvc\Router\Route**

*implements* [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/router/route.zep)

Kelas ini mewakili setiap rute yang ditambahkan ke router

## Metode

public **__construct** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods])

Phalcon\Mvc\Router\Route constructor

publik **kompilasiPola** (*campuraduk* $pattern)

Mengganti placeholder dari pola yang mengembalikan ekspresi reguler PCRE yang valid

public **via** (*mixed* $httpMethods)

Tetapkan satu atau lebih metode HTTP yang membatasi pencocokan rute

```php
<?php

$route->via("GET");

$route->via(
    [
        "GET",
        "POST",
    ]
);

```

public **extractNamedParams** (*mixed* $pattern)

Ekstrak parameter dari sebuah string

public **reConfigure** (*mixed* $pattern, [*mixed* $paths])

Konfigurasikan ulang rute untuk menambahkan pola baru dan satu set jalur

public static **getRoutePaths** ([*mixed* $paths])

Kembali routePaths

publik **getNama** ()

Mengembalikan nama rute

publik **setNama** (*dicampur* $name)

Menetapkan nama rute

```php
<?php

$router->add(
    "/about",
    [
        "controller" => "about",
    ]
)->setName("about");

```

public **beforeMatch** (*mixed* $callback)

Sets a callback that is called if the route is matched. The developer can implement any arbitrary conditions here If the callback returns false the route is treated as not matched

```php
<?php

$router->add(
    "/login",
    [
        "module"     => "admin",
        "controller" => "session",
    ]
)->beforeMatch(
    function ($uri, $route) {
        // Check if the request was made with Ajax
        if ($_SERVER["HTTP_X_REQUESTED_WITH"] === "xmlhttprequest") {
            return false;
        }

        return true;
    }
);

```

public **getBeforeMatch** ()

Mengembalikan callback 'sebelum pertandingan' jika ada

public **match** (*mixed* $callback)

Memungkinkan untuk mengatur panggilan balik untuk menangani permintaan langsung di rute

```php
<?php

$router->add(
    "/help",
    []
)->match(
    function () {
        return $this->getResponse()->redirect("https://support.google.com/", true);
    }
);

```

public **getMatch** ()

Mengembalikan 'pertandingan' callback jika ada

publik **mendapatkanRute** ()

Mengembalikan nomor rute

publik **mendapatkanPola** ()

Mengembalikan pola rute

publik **dapatkanPolaTerkompilasi** ()

Mengembalikan pola yang dikompilasi rute

publik **mendapatkanJalan** ()

Mengembalikan jalan

public **dapatkanJalanTerbalik** ()

Mengembalikan jalur menggunakan posisi sebagai kunci dan nama sebagai nilai

public **setHttpMethods** (*mixed* $httpMethods)

Sets a set of HTTP methods that constraint the matching of the route (alias of via)

```php
<?php

$route->setHttpMethods("GET");
$route->setHttpMethods(["GET", "POST"]);

```

public **getHttpMethods** ()

Mengembalikan metode HTTP itu kendala sesuai rute

public **setHostname** (*mixed* $hostname)

Set hostname pembatasan untuk rute

```php
<?php

$route->setHostname("localhost");

```

public **getHostname** ()

Kembali hostname pembatasan jika ada

public **setGroup** ([Phalcon\Mvc\Router\GroupInterface](Phalcon_Mvc_Router_GroupInterface) $group)

Menetapkan kelompok yang terkait dengan rute

public **getGroup** ()

Returns the group associated with the route

public **convert** (*mixed* $name, *mixed* $converter)

Menambahkan konverter untuk melakukan transformasi tambahan untuk parameter tertentu

publik **mendapatkankonventer** ()

Mengembalikan konverter router

publik static **reset** ()

Menyetel ulang generator id rute internal