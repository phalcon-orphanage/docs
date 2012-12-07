Class **Phalcon\\Mvc\\View\\Engine\\Php**
=========================================

*extends* :doc:`Phalcon\\Mvc\\View\\Engine <Phalcon_Mvc_View_Engine>`

<<<<<<< HEAD
=======
*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Mvc\\View\\EngineInterface <Phalcon_Mvc_View_EngineInterface>`

>>>>>>> 0.7.0
Adapter to use PHP itself as templating engine


Methods
---------

<<<<<<< HEAD
public  **render** (*string* $path, *array* $params, *bool* $mustClean)
=======
public  **render** (*string* $path, *array* $params, *boolean* $mustClean)
>>>>>>> 0.7.0

Renders a view using the template engine



<<<<<<< HEAD
public  **__construct** (:doc:`Phalcon\\Mvc\\View <Phalcon_Mvc_View>` $view, :doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector) inherited from Phalcon\\Mvc\\View\\Engine
=======
public  **__construct** (:doc:`Phalcon\\Mvc\\ViewInterface <Phalcon_Mvc_ViewInterface>` $view, :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\Mvc\\View\\Engine
>>>>>>> 0.7.0

Phalcon\\Mvc\\View\\Engine constructor



public *array*  **getContent** () inherited from Phalcon\\Mvc\\View\\Engine

Returns cached ouput on another view stage



public *string*  **partial** (*string* $partialPath) inherited from Phalcon\\Mvc\\View\\Engine

Renders a partial inside another view



<<<<<<< HEAD
public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector) inherited from Phalcon\\DI\\Injectable
=======
public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\DI\\Injectable
>>>>>>> 0.7.0

Sets the dependency injector



<<<<<<< HEAD
public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** () inherited from Phalcon\\DI\\Injectable
=======
public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** () inherited from Phalcon\\DI\\Injectable
>>>>>>> 0.7.0

Returns the internal dependency injector



<<<<<<< HEAD
public  **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager) inherited from Phalcon\\DI\\Injectable
=======
public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from Phalcon\\DI\\Injectable
>>>>>>> 0.7.0

Sets the event manager



<<<<<<< HEAD
public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** () inherited from Phalcon\\DI\\Injectable
=======
public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** () inherited from Phalcon\\DI\\Injectable
>>>>>>> 0.7.0

Returns the internal event manager



public  **__get** (*string* $propertyName) inherited from Phalcon\\DI\\Injectable

Magic method __get



