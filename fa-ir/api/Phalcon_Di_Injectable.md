---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Di\Injectable'
---
# Abstract class **Phalcon\Di\Injectable**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di/injectable.zep)

This class allows to access services in the services container by just only accessing a public property with the same name of a registered service

## روش ها

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injector

public **getDI** ()

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Sets the event manager

عمومی **مدیریت رویداد** ()

مدیر رویداد داخلی را برمی گرداند

public **__get** (*string* $propertyName)

Magic method __get to easily get access to services through the name of them