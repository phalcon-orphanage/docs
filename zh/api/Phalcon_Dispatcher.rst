Class **Phalcon\\Dispatcher**
=============================

<<<<<<< HEAD
This is the base class for Phalcon\\Mvc\\Dispatcher and Phalcon\\CLI\\Dispatcher
=======
*implements* :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

This is the base class for Phalcon\\Mvc\\Dispatcher and Phalcon\\CLI\\Dispatcher. This class can't be instantiated directly, you can use it to create your own dispatchers
>>>>>>> 0.7.0


Constants
---------

*integer* **EXCEPTION_NO_DI**

*integer* **EXCEPTION_CYCLIC_ROUTING**

*integer* **EXCEPTION_HANDLER_NOT_FOUND**

<<<<<<< HEAD
=======
*integer* **EXCEPTION_INVALID_HANDLER**

>>>>>>> 0.7.0
*integer* **EXCEPTION_INVALID_PARAMS**

*integer* **EXCEPTION_ACTION_NOT_FOUND**

Methods
---------

public  **__construct** ()

<<<<<<< HEAD
...


public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)
=======
Phalcon\\Dispatcher constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)
>>>>>>> 0.7.0

Sets the dependency injector



<<<<<<< HEAD
public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** ()
=======
public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()
>>>>>>> 0.7.0

Returns the internal dependency injector



<<<<<<< HEAD
public  **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager)
=======
public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)
>>>>>>> 0.7.0

Sets the events manager



<<<<<<< HEAD
public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** ()
=======
public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()
>>>>>>> 0.7.0

Returns the internal event manager



public  **setActionSuffix** (*string* $actionSuffix)

Sets the default action suffix



<<<<<<< HEAD
=======
public  **setNamespaceName** (*string* $namespaceName)

Sets a namespace to be prepended to the handler name



public *string*  **getNamespaceName** ()

Gets a namespace to be prepended to the current handler name



>>>>>>> 0.7.0
public  **setDefaultNamespace** (*string* $namespace)

Sets the default namespace



<<<<<<< HEAD
=======
public *string*  **getDefaultNamespace** ()

Returns the default namespace



>>>>>>> 0.7.0
public  **setDefaultAction** (*string* $actionName)

Sets the default action name



public  **setActionName** (*string* $actionName)

Sets the action name to be dispatched



public *string*  **getActionName** ()

Gets last dispatched action name



public  **setParams** (*array* $params)

Sets action params to be dispatched



public *array*  **getParams** ()

Gets action params



public  **setParam** (*mixed* $param, *mixed* $value)

Set a param by its name or numeric index



<<<<<<< HEAD
public *mixed*  **getParam** (*mixed* $param, *string|array* $filters)
=======
public *mixed*  **getParam** (*mixed* $param, *string|array* $filters, *mixed* $defaultValue)
>>>>>>> 0.7.0

Gets a param by its name or numeric index



public *boolean*  **isFinished** ()

<<<<<<< HEAD
Checks if the dispatch loop is finished or have more pendent controllers/tasks to disptach
=======
Checks if the dispatch loop is finished or has more pendent controllers/tasks to disptach
>>>>>>> 0.7.0



public *mixed*  **getReturnedValue** ()

Returns value returned by the lastest dispatched action



public *object*  **dispatch** ()

Dispatches a handle action taking into account the routing parameters



public  **forward** (*array* $forward)

Forwards the execution flow to another controller/action



