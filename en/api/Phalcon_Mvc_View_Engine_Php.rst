Class **Phalcon\\Mvc\\View\\Engine\\Php**
=========================================

*extends* :doc:`Phalcon\\Mvc\\View\\Engine <Phalcon_Mvc_View_Engine>`

Adapter to use PHP itself as templating engine


Methods
---------

public **render** (*string* $path, *array* $params, *bool* $mustClean)

Renders a view using the template engine



public **__construct** (:doc:`Phalcon\\Mvc\\View <Phalcon_Mvc_View>` $view, *unknown* $dependencyInjector) inherited from Phalcon_Mvc_View_Engine

Phalcon\\Mvc\\View\\Engine constructor



*array* public **getContent** () inherited from Phalcon_Mvc_View_Engine

Returns cached ouput on another view stage



public **partial** (*string* $partialPath) inherited from Phalcon_Mvc_View_Engine

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



