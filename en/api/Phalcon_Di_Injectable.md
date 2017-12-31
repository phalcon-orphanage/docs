# Abstract class **Phalcon\\Di\\Injectable**

*implements* [Phalcon\Di\InjectionAwareInterface](/en/3.1.2/api/Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](/en/3.1.2/api/Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/di/injectable.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This class allows to access services in the services container by just only accessing a public property
with the same name of a registered service

## Methods
public  **setDI** ([Phalcon\DiInterface](/en/3.1.2/api/Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injector

public  **getDI** ()

Returns the internal dependency injector

public  **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.1.2/api/Phalcon_Events_ManagerInterface) $eventsManager)

Sets the event manager

public  **getEventsManager** ()

Returns the internal event manager

public  **__get** (*mixed* $propertyName)

Magic method __get

