Class **Phalcon\\DI\\Injectable**
=================================

This class allows to access services in the services container by just only accessing a public property with the same name of a registered service


Methods
---------

public **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)

Sets the dependency injector



:doc:`Phalcon\\DI <Phalcon_DI>` public **getDI** ()

Returns the internal dependency injector



public **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager)

Sets the event manager



:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` public **getEventsManager** ()

Returns the internal event manager



public **__get** (*string* $propertyName)

Magic method __get



