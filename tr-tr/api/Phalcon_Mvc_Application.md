---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Mvc\Application'
---
# Class **Phalcon\Mvc\Application**

*extends* abstract class [Phalcon\Application](Phalcon_Application)

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/application.zep)

Bu bileşen, gereken her bileşeni örneklendirmenin ardındaki tüm karmaşık işlemleri kapsar ve MVC deseninin istenen şekilde çalışmasına izin vermek için geri kalanı ile bütünleştirir.

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

## Metodlar

public **useImplicitView** (*mixed* $implicitView)

By default. The view is implicitly buffering all the output You can full disable the view component using this method

public **handle** ([*mixed* $uri])

Handles a MVC request

public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector]) inherited from [Phalcon\Application](Phalcon_Application)

Phalcon\Application

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Application](Phalcon_Application)

Olay yöneticisini ayarlar

public **getEventsManager** () inherited from [Phalcon\Application](Phalcon_Application)

Dahili olay yöneticisini döndürür

public **registerModules** (*array* $modules, [*mixed* $merge]) inherited from [Phalcon\Application](Phalcon_Application)

Uygulamada mevcut bir modüller dizisi kaydedin

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

Uygulamada kayıtlı modülleri dönün

public **getModule** (*mixed* $name) inherited from [Phalcon\Application](Phalcon_Application)

Modül adını kullanarak uygulamada kayıtlı modül tanımını getirir

public **setDefaultModule** (*mixed* $defaultModule) inherited from [Phalcon\Application](Phalcon_Application)

Eğer yönlendirici geçerli bir modül döndürmezse kullanılacak modül adını ayarlar

public **getDefaultModule** () inherited from [Phalcon\Application](Phalcon_Application)

Varsayılan modül adını döner

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Bağımlılık enjektörünü ayarlar

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Returns the internal dependency injector

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get