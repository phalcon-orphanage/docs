---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Mvc\View\Engine\Php'
---
# Class **Phalcon\Mvc\View\Engine\Php**

*extends* abstract class [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

*implements* [Phalcon\Mvc\View\EngineInterface](Phalcon_Mvc_View_EngineInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/view/engine/php.zep)

适配器可以使用 PHP 本身作为模板化引擎

## 方法

public **render** (*mixed* $path, *mixed* $params, [*mixed* $mustClean])

呈现一个视图，使用模板引擎

public **__construct** ([Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface) $view, [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector]) inherited from [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

Phalcon\Mvc\View\Engine constructor

public **getContent** () inherited from [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

返回缓存输出在另一个视图舞台上

public *string* **partial** (*string* $partialPath, [*array* $params]) inherited from [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

将呈现偏内另一种观点

public **getView** () inherited from [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

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