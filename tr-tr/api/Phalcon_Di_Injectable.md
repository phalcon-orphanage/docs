---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Di\Injectable'
---
# Abstract class **Phalcon\Di\Injectable**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di/injectable.zep)

Bu sınıf, yalnızca kayıtlı bir hizmetin aynı adlı halka açık bir mülkiyete erişerek hizmetler kapsayıcısındaki hizmetlere erişmesine olanak tanır

## Metodlar

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Bağımlılık enjektörünü ayarlar

public **getDI** ()

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Olay yöneticisi ayarlar

herkes **Olay yöneticisini al** ()

Dahili olay yöneticisini döndürür

public **__get** (*string* $propertyName)

Magic method __get, hizmetlerin adını kullanarak kolayca erişmesini sağlar