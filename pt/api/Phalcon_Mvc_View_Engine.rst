Abstract class **Phalcon\\Mvc\\View\\Engine**
=============================================

*extends* abstract class :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/view/engine.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

All the template engine adapters must inherit this class. This provides basic interfacing between the engine and the Phalcon\\Mvc\\View component.


Methods
-------

public  **__construct** (:doc:`Phalcon\\Mvc\\ViewBaseInterface <Phalcon_Mvc_ViewBaseInterface>` $view, [:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector])

Phalcon\\Mvc\\View\\Engine constructor



public  **getContent** ()

Returns cached output on another view stage



public *string*  **partial** (*string* $partialPath, [*array* $params])

Renders a partial inside another view



public  **getView** ()

Returns the view component related to the adapter



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\Di\\Injectable

Sets the dependency injector



public  **getDI** () inherited from Phalcon\\Di\\Injectable

Returns the internal dependency injector



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from Phalcon\\Di\\Injectable

Sets the event manager



public  **getEventsManager** () inherited from Phalcon\\Di\\Injectable

Returns the internal event manager



public  **__get** (*unknown* $propertyName) inherited from Phalcon\\Di\\Injectable

Magic method __get



