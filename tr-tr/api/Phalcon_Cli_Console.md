---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Cli\Console'
---
# Class **Phalcon\Cli\Console**

*extends* abstract class [Phalcon\Application](Phalcon_Application)

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/console.zep)

Bu bileşen Phalcon'u kullanarak CLI uygulamaları oluşturmayı sağlar

## Metodlar

public **addModules** (*array* $modules)

Modülleri mevcut olan modüller ile birleştir

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

public **handle** ([*array* $arguments])

Tüm komut satırı görevlerini yönetin

public **setArgument** ([*array* $arguments], [*mixed* $str], [*mixed* $shift])

Belirli bir argüman ayarla

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