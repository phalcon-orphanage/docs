---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Application'
---
# Class **Phalcon\Mvc\Application**

*extends* abstract class [Phalcon\Application](Phalcon_Application)

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/application.zep)

Komponen ini merangkum semua operasi kompleks di balik instantiating setiap komponen diperlukan dan mengintegrasikannya dengan yang lain untuk memungkinkan pola MVC beroperasi sesuai keinginan.

```php
<?php

use Phalcon\Mvc\Application;

class MyApp extends Application
{
    /**
     * Register the services here to make them general or register
     * in the ModuleDefinition to make them module-specific
     */
    protected function registerServices()
    {

    }

    /**
     * This method registers all the modules in the application
     */
    public function main()
    {
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
    }
}

$application = new MyApp();

$application->main();

```

## Metode

public **useImplicitView** (*mixed* $implicitView)

By default. The view is implicitly buffering all the output You can full disable the view component using this method

public **handle** ([*mixed* $uri])

Menangani permintaan MVC

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