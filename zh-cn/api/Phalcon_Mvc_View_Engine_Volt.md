---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Mvc\View\Engine\Volt'
---
# Class **Phalcon\Mvc\View\Engine\Volt**

*extends* abstract class [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

*implements* [Phalcon\Mvc\View\EngineInterface](Phalcon_Mvc_View_EngineInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/view/engine/volt.zep)

Zephir/C 编写的 PHP 设计器的友好和快速模板引擎

## 方法

public **setOptions** (*array* $options)

设置 Volt 的选项

public **getOptions** ()

返回 Volt 的选项

public **getCompiler** ()

返回 Volt 的编译器

public **render** (*mixed* $templatePath, *mixed* $params, [*mixed* $mustClean])

呈现一个视图，使用模板引擎

public **length** (*mixed* $item)

Length filter. If an array/object is passed a count is performed otherwise a strlen/mb_strlen

public **isIncluded** (*mixed* $needle, *mixed* $haystack)

检查是否针包括在haystack

public **convertEncoding** (*mixed* $text, *mixed* $from, *mixed* $to)

执行字符串转换

public **slice** (*mixed* $value, [*mixed* $start], [*mixed* $end])

从一个字符串/数组/可遍历对象值提取一部分

public **sort** (*array* $value)

对数组进行排序

public **callMacro** (*mixed* $name, [*array* $arguments])

检查是否宏定义和调用它

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