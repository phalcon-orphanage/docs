---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Cli\Router'
---
# Class **Phalcon\Cli\Router**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/router.zep)

Phalcon\Cli\Router is the standard framework router. Yönlendirme, komut satırı bağımsız değişkenlerini alma ve bu görevi hangi modül, görev ve eylemin gerçekleştireceğini belirlemek için parametrelere bölme işlemidir

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

## Metodlar

public **__construct** ([*mixed* $defaultRoutes])

Phalcon\Cli\Router constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Bağımlılık enjektörünü ayarlar

public **getDI** ()

Returns the internal dependency injector

public **setDefaultModule** (*mixed* $moduleName)

Varsayılan modülün ismini ayarlar

public **setDefaultTask** (*mixed* $taskName)

Varsayılan denetleyici ismini ayarlar

public **setDefaultAction** (*mixed* $actionName)

Varsayılan eylem ismini ayarlar

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

public **handle** ([*array* $arguments])

Komut satırı argümanlarından alınan yönlendirme bilgilerini yönetir

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **add** (*string* $pattern, [*string/array* $paths])

Yönelticiye bir rota ekler

```php
<?php

$router->add("/about", "About::main");

```

public **getModuleName** ()

Işlenen modül adını getirir

public **getTaskName** ()

İşlenmiş görevin ismini döndürür

public **getActionName** ()

İşlenen eylem adını getirir

public *array* **getParams** ()

İşlenen ek parametreleri getirir

public **getMatchedRoute** ()

İşlenen URI ile eşleşen yolu getirir

public *array* **getMatches** ()

Eşleşen düzenli ifadedeki alt ifadeleri geri getirir

public **wasMatched** ()

Yönlendiricinin tanımlanmış rotalardan herhangi biriyle eşleşip eşleşmediğini kontrol eder

public **getRoutes** ()

Yönlendiricide tanımlanan tüm rotaları getir

public [Phalcon\Cli\Router\Route](Phalcon_Cli_Router_Route) **getRouteById** (*int* $id)

Bir güzergah nesnesini onun kimliğiyle geri döndürür

public **getRouteByName** (*mixed* $name)

Bir güzergah nesnesini onun ismiyle geri döndürür