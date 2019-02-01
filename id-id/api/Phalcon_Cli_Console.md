---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cli\Console'
---
# Class **Phalcon\Cli\Console**

*extends* abstract class [Phalcon\Application](Phalcon_Application)

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/console.zep)

Komponen ini memungkinkan untuk membuat aplikasi CLI menggunakan Phalcon

## Metode

public **tambahkanmodul</0 1array<M 1 $modules</p> 

Gabung modul dengan yang sudah ada

```php
<?php

$application->addModules(
    [
        "admin" => [
            "className" => "Multiple\Admin\Module",
            "path"      => "../apps/admin/Module.php",
        ],
    ]
);

```

public **menangani** ([*array* $arguments])

Tangani seluruh tugas baris perintah

public **setArgument** ([*array* $arguments], [*campuran* $str], [*campuran* $shift])

Menetapkan sebuah argumen tertentu

public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector]) inherited from [Phalcon\Application](Phalcon_Application)

Phalcon\Aplikasi

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Application](Phalcon_Application)

Menyetel pengelola acara

public **getEventsManager** () inherited from [Phalcon\Application](Phalcon_Application)

Mengembalikan manajer acara internal

public **registerModules** (*array* $modules, [*mixed* $merge]) inherited from [Phalcon\Application](Phalcon_Application)

Daftarkan sebuah array modul yang ada dalam aplikasi

```php
<?php

$this->registerModules(
    [
        "frontend" => [
            "className" => "Multiple\Frontend\Module",
            "path"      => "../apps/frontend/Module.php",
        ],
        "backend" => [
            "className" => "Multiple\Backend\Module",
            "path"      => "../apps/backend/Module.php",
        ],
    ]
);

```

public **getModules** () inherited from [Phalcon\Application](Phalcon_Application)

Kembalikan modul yang terdaftar dalam aplikasi

public **getModule** (*mixed* $name) inherited from [Phalcon\Application](Phalcon_Application)

Mendapat definisi modul yang terdaftar dalam aplikasi melalui nama modul

public **setDefaultModule** (*mixed* $defaultModule) inherited from [Phalcon\Application](Phalcon_Application)

Menetapkan nama modul yang akan digunakan jika router tidak mengembalikan modul yang valid

public **getDefaultModule** () inherited from [Phalcon\Application](Phalcon_Application)

Mengembalikan nama modul default

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Mengatur injector ketergantungan

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Mengembalikan injector ketergantungan internal

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Metode __get