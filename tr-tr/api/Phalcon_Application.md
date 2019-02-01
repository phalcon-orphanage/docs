---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Application'
---
# Abstract class **Phalcon\Application**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/application.zep)

Base class for Phalcon\Cli\Console and Phalcon\Mvc\Application.

## Metodlar

public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Phalcon\Application Constructor

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Olay yöneticisini ayarlar

herkes **Olay yöneticisini al** ()

Dahili olay yöneticisini döndürür

public **registerModules** (*array* $modules, [*mixed* $merge])

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

public **getModules** ()

Uygulamada kayıtlı modülleri dönün

public **getModule** (*mixed* $name)

Modül adını kullanarak uygulamada kayıtlı modül tanımını getirir

public **setDefaultModule** (*mixed* $defaultModule)

Eğer yönlendirici geçerli bir modül döndürmezse kullanılacak modül adını ayarlar

public **getDefaultModule** ()

Varsayılan modül adını döner

abstract public **handle** ()

Talebi yönetir

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Bağımlılık enjektörünü ayarlar

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Returns the internal dependency injector

public **__get** (*string* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get