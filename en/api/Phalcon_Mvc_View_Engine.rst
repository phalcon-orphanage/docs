Class **Phalcon\\Mvc\\View\\Engine**
====================================

*extends* :doc:`Phalcon\\DI\\Injectable <Phalcon_DI_Injectable>`

All the template engine adapters must inherit this class. This provides basic interfacing between the engine and the Phalcon\\Mvc\\View component.


Methods
---------

public  **__construct** (:doc:`Phalcon\\Mvc\\View <Phalcon_Mvc_View>` $view, *unknown* $dependencyInjector)

Phalcon\\Mvc\\View\\Engine constructor



public *array*  **getContent** ()

Returns cached ouput on another view stage



public  **partial** (*string* $partialPath)

Renders a partial inside another view



public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector) inherited from Phalcon\DI\Injectable

Sets the dependency injector



public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** () inherited from Phalcon\DI\Injectable

Returns the internal dependency injector



public  **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager) inherited from Phalcon\DI\Injectable

Sets the event manager



public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** () inherited from Phalcon\DI\Injectable

Returns the internal event manager



public  **__get** (*string* $propertyName) inherited from Phalcon\DI\Injectable

Magic method __get



