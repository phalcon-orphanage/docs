* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Di\Injectable'

* * *

# Abstract class **Phalcon\Di\Injectable**

*implements* [Phalcon\Di\InjectionAwareInterface](/4.0/en/api/Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](/4.0/en/api/Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/di/injectable.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This class allows to access services in the services container by just only accessing a public property with the same name of a registered service

## Methods

public **setDI** ([Phalcon\DiInterface](/4.0/en/api/Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injector

public **getDI** ()

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/4.0/en/api/Phalcon_Events_ManagerInterface) $eventsManager)

Sets the event manager

public **getEventsManager** ()

Повертає внутрішній диспетчер подій

public **__get** (*string* $propertyName)

Magic method __get to easily get access to services through the name of them