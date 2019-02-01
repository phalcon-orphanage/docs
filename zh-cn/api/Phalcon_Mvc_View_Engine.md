---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Mvc\View\Engine'
---
# Abstract class **Phalcon\Mvc\View\Engine**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\View\EngineInterface](Phalcon_Mvc_View_EngineInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/view/engine.zep)

All the template engine adapters must inherit this class. This provides basic interfacing between the engine and the Phalcon\Mvc\View component.

## 方法

public **__construct** ([Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface) $view, [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Phalcon\Mvc\View\Engine constructor

public **getContent** ()

返回缓存输出在另一个视图舞台上

public *string* **partial** (*string* $partialPath, [*array* $params])

将呈现偏内另一种观点

public **getView** ()

返回有关适配器的视图组件

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

设置依赖注入器

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

返回内部依赖注入器

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

设置事件管理器

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

返回内部事件管理器

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get

abstract public **render** (*mixed* $path, *mixed* $params, [*mixed* $mustClean]) inherited from [Phalcon\Mvc\View\EngineInterface](Phalcon_Mvc_View_EngineInterface)

...