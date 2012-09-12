Class **Phalcon\\CLI\\Dispatcher**
==================================

*extends* :doc:`Phalcon\\Dispatcher <Phalcon_Dispatcher>`

Dispatching is the process of taking the command-line arguments, extracting the module name, task name, action name, and optional parameters contained in it, and then instantiating a task and calling an action on it. 

.. code-block:: php

    <?php

    $di = new Phalcon\DI();
    
    $dispatcher = new Phalcon\CLI\Dispatcher();
    
      $dispatcher->setDI($di);
    
    $dispatcher->setTaskName('posts');
    $dispatcher->setActionName('index');
    $dispatcher->setParams(array());
    
    $handle = $dispatcher->dispatch();



Methods
---------

public **setTaskSuffix** (*string* $taskSuffix)

Sets the default task suffix



public **setDefaultTask** (*string* $taskName)

Sets the default task name



public **setTaskName** (*string* $taskName)

Sets the task name to be dispatched



*string* public **getTaskName** ()

Gets last dispatched task name



protected **_throwDispatchException** ()

Throws an internal exception



:doc:`Phalcon\\CLI\\Task <Phalcon_CLI_Task>` public **getLastTask** ()

Returns the lastest dispatched controller



:doc:`Phalcon\\CLI\\Task <Phalcon_CLI_Task>` public **getActiveTask** ()

Returns the active task in the dispatcher



public **__construct** () inherited from Phalcon_Dispatcher

...


public **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector) inherited from Phalcon_Dispatcher

Sets the dependency injector



:doc:`Phalcon\\DI <Phalcon_DI>` public **getDI** () inherited from Phalcon_Dispatcher

Returns the internal dependency injector



public **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager) inherited from Phalcon_Dispatcher

Sets the events manager



:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` public **getEventsManager** () inherited from Phalcon_Dispatcher

Returns the internal event manager



public **setActionSuffix** (*string* $actionSuffix) inherited from Phalcon_Dispatcher

Sets the default action suffix



public **setDefaultNamespace** (*string* $namespace) inherited from Phalcon_Dispatcher

Sets the default namespace



public **setDefaultAction** (*string* $actionName) inherited from Phalcon_Dispatcher

Sets the default action name



public **setActionName** (*string* $actionName) inherited from Phalcon_Dispatcher

Sets the action name to be dispatched



*string* public **getActionName** () inherited from Phalcon_Dispatcher

Gets last dispatched action name



public **setParams** (*array* $params) inherited from Phalcon_Dispatcher

Sets action params to be dispatched



*array* public **getParams** () inherited from Phalcon_Dispatcher

Gets action params



public **setParam** (*mixed* $param, *mixed* $value) inherited from Phalcon_Dispatcher

Set a param by its name or numeric index



*mixed* public **getParam** (*mixed* $param) inherited from Phalcon_Dispatcher

Gets a param by its name or numeric index



*boolean* public **isFinished** () inherited from Phalcon_Dispatcher

Checks if the dispatch loop is finished or have more pendent controllers/tasks to disptach



*mixed* public **getReturnedValue** () inherited from Phalcon_Dispatcher

Returns value returned by the lastest dispatched action



*object* public **dispatch** () inherited from Phalcon_Dispatcher

Dispatches a handle action taking into account the routing parameters



public **forward** (*array* $forward) inherited from Phalcon_Dispatcher





