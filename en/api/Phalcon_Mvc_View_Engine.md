# Abstract class **Phalcon\\Mvc\\View\\Engine**

*extends* abstract class [Phalcon\Di\Injectable](/[[language]]/[[version]]/api/Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](/[[language]]/[[version]]/api/Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](/[[language]]/[[version]]/api/Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\View\EngineInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_View_EngineInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/view/engine.zep" class="btn btn-default btn-sm">Source on GitHub</a>

All the template engine adapters must inherit this class. This provides
basic interfacing between the engine and the Phalcon\\Mvc\\View component.


## Methods
public  **__construct** ([Phalcon\Mvc\ViewBaseInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_ViewBaseInterface) $view, [[Phalcon\DiInterface](/[[language]]/[[version]]/api/Phalcon_DiInterface) $dependencyInjector])

Phalcon\\Mvc\\View\\Engine constructor



public  **getContent** ()

Returns cached output on another view stage



public *string* **partial** (*string* $partialPath, [*array* $params])

Renders a partial inside another view



public  **getView** ()

Returns the view component related to the adapter



public  **setDI** ([Phalcon\DiInterface](/[[language]]/[[version]]/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di\Injectable](/[[language]]/[[version]]/api/Phalcon_Di_Injectable)

Sets the dependency injector



public  **getDI** () inherited from [Phalcon\Di\Injectable](/[[language]]/[[version]]/api/Phalcon_Di_Injectable)

Returns the internal dependency injector



public  **setEventsManager** ([Phalcon\Events\ManagerInterface](/[[language]]/[[version]]/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](/[[language]]/[[version]]/api/Phalcon_Di_Injectable)

Sets the event manager



public  **getEventsManager** () inherited from [Phalcon\Di\Injectable](/[[language]]/[[version]]/api/Phalcon_Di_Injectable)

Returns the internal event manager



public  **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](/[[language]]/[[version]]/api/Phalcon_Di_Injectable)

Magic method __get



abstract public  **render** (*mixed* $path, *mixed* $params, [*mixed* $mustClean]) inherited from [Phalcon\Mvc\View\EngineInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_View_EngineInterface)

...


