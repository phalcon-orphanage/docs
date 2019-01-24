---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Aplikasi'
---
# Abstract class **Phalcon\Application**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/application.zep)

Base class for Phalcon\Cli\Console and Phalcon\Mvc\Application.

## Metode

public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Phalcon\Application Constructor

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Menyetel pengelola acara

publik **getEventsManager** ()

Mengembalikan manajer acara internal

public **registerModules** (*array* $modules, [*mixed* $merge])

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

public **getModules** ()

Kembalikan modul yang terdaftar dalam aplikasi

public **getModule** (*mixed* $name)

Mendapat definisi modul yang terdaftar dalam aplikasi melalui nama modul

public **setDefaultModule** (*mixed* $defaultModule)

Menetapkan nama modul yang akan digunakan jika router tidak mengembalikan modul yang valid

public **getDefaultModule** ()

Mengembalikan nama modul default

publik abstrak **menangani** ()

Menangani permintaan

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Mengatur injector ketergantungan

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Mengembalikan injector ketergantungan internal

public **__get** (*string* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Metode __get