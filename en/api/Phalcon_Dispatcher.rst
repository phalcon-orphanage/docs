Class **Phalcon\\Dispatcher**
=============================

This is the base class for Phalcon\\Mvc\\Dispatcher and Phalcon\\CLI\\Dispatcher


Constants
---------

*integer* **EXCEPTION_NO_DI**

*integer* **EXCEPTION_CYCLIC_ROUTING**

*integer* **EXCEPTION_HANDLER_NOT_FOUND**

*integer* **EXCEPTION_INVALID_PARAMS**

*integer* **EXCEPTION_ACTION_NOT_FOUND**

Methods
---------

public  **__construct** ()

...


public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** ()

Returns the internal dependency injector



public  **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager)

Sets the events manager



public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** ()

Returns the internal event manager



public  **setActionSuffix** (*string* $actionSuffix)

Sets the default action suffix



public  **setDefaultNamespace** (*string* $namespace)

Sets the default namespace



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



public *mixed*  **getParam** (*mixed* $param, *string|array* $filters)

Gets a param by its name or numeric index



public *boolean*  **isFinished** ()

Checks if the dispatch loop is finished or have more pendent controllers/tasks to disptach



public *mixed*  **getReturnedValue** ()

Returns value returned by the lastest dispatched action



public *object*  **dispatch** ()

Dispatches a handle action taking into account the routing parameters



public  **forward** (*array* $forward)

Forwards the execution flow to another controller/action



