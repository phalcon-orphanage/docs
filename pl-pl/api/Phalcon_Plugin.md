---
layout: default
language: 'pl-pl'
version: '4.0'
title: 'Phalcon\Plugin'
---
# Class **Phalcon\Plugin**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/user/plugin.zep)

## Metody

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Sets the dependency injector

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Sets the event manager

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Returns the internal event manager

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get