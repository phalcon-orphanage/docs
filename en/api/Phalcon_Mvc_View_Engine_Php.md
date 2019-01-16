---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Mvc\View\Engine\Php'
---
# Class **Phalcon\Mvc\View\Engine\Php**

*extends* abstract class [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

*implements* [Phalcon\Mvc\View\EngineInterface](Phalcon_Mvc_View_EngineInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/view/engine/php.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Adapter to use PHP itself as templating engine


## Methods
public  **render** (*mixed* $path, *mixed* $params, [*mixed* $mustClean])

Renders a view using the template engine



public  **__construct** ([Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface) $view, [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector]) inherited from [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

Phalcon\Mvc\View\Engine constructor



public  **getContent** () inherited from [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

Returns cached output on another view stage



public *string* **partial** (*string* $partialPath, [*array* $params]) inherited from [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

Renders a partial inside another view



public  **getView** () inherited from [Phalcon\Mvc\View\Engine](Phalcon_Mvc_View_Engine)

Returns the view component related to the adapter



public  **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Sets the dependency injector



public  **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Returns the internal dependency injector



public  **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Sets the event manager



public  **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Returns the internal event manager



public  **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get



