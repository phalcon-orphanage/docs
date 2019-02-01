---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Di\Injectable'
---
# Abstract class **Phalcon\Di\Injectable**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di/injectable.zep)

This class allows to access services in the services container by just only accessing a public property with the same name of a registered service

## 方法

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

设置依赖注入器

public **getDI** ()

返回内部依赖注入器

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

设置事件管理器

public **getEventsManager** ()

返回内部事件管理器

public **__get** (*string* $propertyName)

Magic method __get to easily get access to services through the name of them