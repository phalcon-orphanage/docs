Abstract class **Phalcon\\Di\\Injectable**
==========================================

*implements* :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/di/injectable.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This class allows to access services in the services container by just only accessing a public property
with the same name of a registered service


Methods
-------

public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injector



public  **getDI** ()

Returns the internal dependency injector



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets the event manager



public  **getEventsManager** ()

Returns the internal event manager



public  **__get** (*mixed* $propertyName)

Magic method __get



