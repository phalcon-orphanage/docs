Class **Phalcon\\Dispatcher**
=============================

This is the base class for Phalcon\\Mvc\\Dispatcher and Phalcon\\CLI\\Dispatcher


Methods
---------

public **__construct** ()

public **setDI** (*Phalcon\DI* $dependencyInjector)

Sets the dependency injector



:doc:`Phalcon\\DI <Phalcon_DI>` public **getDI** ()

Returns the internal dependency injector



public **setEventsManager** (*Phalcon\Events\Manager* $eventsManager)

Sets the events manager



:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` public **getEventsManager** ()

Returns the internal event manager



public **setActionSuffix** (*string* $actionSuffix)

Sets the default action suffix



public **setDefaultNamespace** (*string* $namespace)

Sets the default namespace



public **setDefaultAction** (*string* $actionName)

Sets the default action name



public **setActionName** (*string* $actionName)

Sets the action name to be dispatched



*string* public **getActionName** ()

Gets last dispatched action name



public **setParams** (*array* $params)

Sets action params to be dispatched



*array* public **getParams** ()

Gets action params



public **setParam** (*mixed* $param, *mixed* $value)

Set a param by its name or numeric index



*mixed* public **getParam** (*mixed* $param)

Gets a param by its name or numeric index



*boolean* public **isFinished** ()

Checks if the dispatch loop is finished or have more pendent controllers/tasks to disptach



*mixed* public **getReturnedValue** ()

Returns value returned by the lastest dispatched action



*object* public **dispatch** ()

Dispatches a handle action taking into account the routing parameters



public **forward** (*array* $forward)





