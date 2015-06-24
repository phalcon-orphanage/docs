Class **Phalcon\\Mvc\\View\\Engine\\Php**
=========================================

*extends* abstract class :doc:`Phalcon\\Mvc\\View\\Engine <Phalcon_Mvc_View_Engine>`

*implements* :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Mvc\\View\\EngineInterface <Phalcon_Mvc_View_EngineInterface>`

Adapter to use PHP itself as templating engine


Methods
-------

public  **render** (*unknown* $path, *unknown* $params, [*unknown* $mustClean])

Renders a view using the template engine



public  **__construct** (*unknown* $view, [*unknown* $dependencyInjector]) inherited from Phalcon\\Mvc\\View\\Engine

Phalcon\\Mvc\\View\\Engine constructor



public *string*  **getContent** () inherited from Phalcon\\Mvc\\View\\Engine

Returns cached ouput on another view stage



public *string*  **partial** (*unknown* $partialPath, [*unknown* $params]) inherited from Phalcon\\Mvc\\View\\Engine

Renders a partial inside another view



public :doc:`Phalcon\\Mvc\\ViewInterface <Phalcon_Mvc_ViewInterface>`  **getView** () inherited from Phalcon\\Mvc\\View\\Engine

Returns the view component related to the adapter



public  **setDI** (*unknown* $dependencyInjector) inherited from Phalcon\\Di\\Injectable

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** () inherited from Phalcon\\Di\\Injectable

Returns the internal dependency injector



public  **setEventsManager** (*unknown* $eventsManager) inherited from Phalcon\\Di\\Injectable

Sets the event manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** () inherited from Phalcon\\Di\\Injectable

Returns the internal event manager



public  **__get** (*unknown* $propertyName) inherited from Phalcon\\Di\\Injectable

Magic method __get



