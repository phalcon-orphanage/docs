---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Mvc\View\Engine\Volt'
---
# Class **Phalcon\Mvc\View\Engine\Volt**

*extends* abstract class [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

*implements* [Phalcon\Mvc\View\EngineInterface](Phalcon_Mvc_View_EngineInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/view/engine/volt.zep)

Diseñador de plantilla amigable y rápido para PHP escrito en Zephir/C

## Métodos

public **setOptions** (*array* $options)

Establecer las opciones del Volt

public **getOptions** ()

Obtener las opciones de Volt

public **getCompiler** ()

Devuelve el compilador del Volt

public **render** (*mixed* $templatePath, *mixed* $params, [*mixed* $mustClean])

Renders a view using the template engine

public **length** (*mixed* $item)

Length filter. If an array/object is passed a count is performed otherwise a strlen/mb_strlen

public **isIncluded** (*mixed* $needle, *mixed* $haystack)

Comprueba si se incluye la aguja en el pajar

public **convertEncoding** (*mixed* $text, *mixed* $from, *mixed* $to)

Realiza una conversión cadena

public **slice** (*mixed* $value, [*mixed* $start], [*mixed* $end])

Extrae un trozo de un valor de un string/array/objecto iterable

public **sort** (*array* $value)

Ordena una matriz

public **callMacro** (*mixed* $name, [*array* $arguments])

Comprueba si una macro está definida y la llama

public **__construct** ([Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface) $view, [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector]) inherited from [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

Phalcon\Mvc\View\Engine constructor

public **getContent** () inherited from [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

Returns cached output on another view stage

public *string* **partial** (*string* $partialPath, [*array* $params]) inherited from [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

Renders a partial inside another view

public **getView** () inherited from [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

Returns the view component related to the adapter

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Sets the dependency injector

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Sets the event manager

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Devuelve el administrador de eventos interno

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get