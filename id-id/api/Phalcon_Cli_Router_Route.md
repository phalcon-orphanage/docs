---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cli\Router\Route'
---
# Class **Phalcon\Cli\Router\Route**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/router/route.zep)

Kelas ini mewakili setiap rute yang ditambahkan ke router

## Constants

*tali* **DEFAULT_DELIMITER**

## Metode

public **__construct** (*string* $pattern, [*array* $paths])

Phalcon\Cli\Router\Route constructor

publik **kompilasiPola** (*campuraduk* $pattern)

Mengganti placeholder dari pola yang mengembalikan ekspresi reguler PCRE yang valid

public *array* | *boolean* **extractNamedParams** (*string* $pattern)

Ekstrak parameter dari sebuah string

public **reConfigure** (*string* $pattern, [*array* $paths])

Konfigurasikan ulang rute untuk menambahkan pola baru dan satu set jalur

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

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **beforeMatch** (*callback* $callback)

Sets a callback that is called if the route is matched. The developer can implement any arbitrary conditions here If the callback returns false the route is treated as not matched

public *mixed* **getBeforeMatch** ()

Mengembalikan callback 'sebelum pertandingan' jika ada

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

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **convert** (*string* $name, *callable* $converter)

Menambahkan konverter untuk melakukan transformasi tambahan untuk parameter tertentu

publik **mendapatkankonventer** ()

Mengembalikan konverter router

publik static **reset** ()

Menyetel ulang generator id rute internal

public static **delimiter** ([*mixed* $delimiter])

Tetapkan pembatas rute

publik statis **mendapatkanDelimiter** ()

Dapatkan perutean routing