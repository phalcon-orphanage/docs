Class **Phalcon\\Mvc\\View\\Engine**
====================================

*extends* :doc:`Phalcon\\DI\\Injectable <Phalcon_DI_Injectable>`

All the template engine adapters must inherit this class. This provides basic interfacing between the engine and the Phalcon\\Mvc\\View component.


Methods
---------

public **__construct** (:doc:`Phalcon\\Mvc\\View <Phalcon_Mvc_View>` $view, *unknown* $dependencyInjector)

Phalcon\\Mvc\\View\\Engine constructor



*array* public **getContent** ()

Returns cached ouput on another view stage



public **partial** (*string* $partialPath)

Renders a partial inside another view



public **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector) inherited from Phalcon_DI_Injectable

Sets the dependency injector



:doc:`Phalcon\\DI <Phalcon_DI>` public **getDI** () inherited from Phalcon_DI_Injectable

Returns the internal dependency injector



public **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager) inherited from Phalcon_DI_Injectable

Sets the event manager



:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` public **getEventsManager** () inherited from Phalcon_DI_Injectable

Returns the internal event manager



public **__get** (*string* $propertyName) inherited from Phalcon_DI_Injectable

Magic method __get



