Abstract class **Phalcon\\Di\\Injectable**
==========================================

*implements* :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

This class allows to access services in the services container by just only accessing a public property with the same name of a registered service


Methods
-------

public  **setDI** (*unknown* $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public  **setEventsManager** (*unknown* $eventsManager)

Sets the event manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()

Returns the internal event manager



public  **__get** (*unknown* $propertyName)

Magic method __get



