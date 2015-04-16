Abstract class **Phalcon\\Mvc\\View\\Engine**
=============================================

*extends* abstract class :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

All the template engine adapters must inherit this class. This provides basic interfacing between the engine and the Phalcon\\Mvc\\View component.


Methods
-------

public  **__construct** (*unknown* $view, [*unknown* $dependencyInjector])

Phalcon\\Mvc\\View\\Engine constructor



public *string*  **getContent** ()

Returns cached ouput on another view stage



public *string*  **partial** (*unknown* $partialPath, [*unknown* $params])

Renders a partial inside another view



public :doc:`Phalcon\\Mvc\\ViewInterface <Phalcon_Mvc_ViewInterface>`  **getView** ()

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



