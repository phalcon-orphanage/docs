Class **Phalcon\\DI\\Injectable**
=================================

*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

This class allows to access services in the services container by just only accessing a public property with the same name of a registered service


Methods
---------

public  **setDI** (*Phalcon\\DiInterface* $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public  **setEventsManager** (*Phalcon\\Events\\ManagerInterface* $eventsManager)

Sets the event manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()

Returns the internal event manager



public  **__get** (*string* $propertyName)

Magic method __get



