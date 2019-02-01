---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cli\Router'
---
# Class **Phalcon\Cli\Router**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/router.zep)

Phalcon\Cli\Router is the standard framework router. Routing adalah proses mengambil argumen baris perintah dan mendekomposisinya menjadi parameter untuk menentukan modul, tugas, dan tindakan dari tugas itu harus menerima permintaan tersebut

```php
<?php

$router = new \Phalcon\Cli\Router();

$router->handle(
    [
        "module" => "main",
        "task"   => "videos",
        "action" => "process",
    ]
);

echo $router->getTaskName();

```

## Metode

public **__construct** ([*mixed* $defaultRoutes])

Phalcon\Cli\Router constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Mengatur injector ketergantungan

publik **mendapatkanDI** ()

Mengembalikan injector ketergantungan internal

public **setDefaultModule** (*mixed* $moduleName)

Menetapkan nama modul default

umum **setDefaultTask** (*campuran* $taskName)

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

public **menangani** ([*array* $arguments])

Menangani informasi routing yang diterima dari argumen command-line

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **add** (*string* $pattern, [*string/array* $paths])

Menambahkan rute ke router

```php
<?php

$router->add("/about", "About::main");

```

publik **mendapatkanNamaModul** ()

Mengembalikan nama modul yang diproses

umum **getActiveRole** ()

Kembali memproses nama tugas

publik **dapatkanNamaAksi** ()

Mengembalikan nama tindakan yang diproses

publik *array* **MendapatkanParams** ()

Mengembalikan params ekstra yang diproses

publik **DapatkanRuteyangsesuai** ()

Mengembalikan rute yang sesuai dengan URI yang ditangani

publiK *array* **dapatkanPertandingan** ()

Mengembalikan sub ekspresi dalam ekspresi reguler yang sesuai

publik **telahDicantumkan** ()

Memeriksa apakah router cocok dengan rute yang ditentukan

publik **mendapatkanRute** ()

Mengembalikan semua rute yang didefinisikan di router

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **getRouteById** (*int* $id)

Mengembalikan objek rute dengan idnya

public **getRouteByName** (*mixed* $name)

Mengembalikan objek rute dengan namanya