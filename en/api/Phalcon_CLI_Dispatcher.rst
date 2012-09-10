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



public **__construct** ()

public **setDI** (*unknown* $dependencyInjector)

public **getDI** ()

public **setEventsManager** (*unknown* $eventsManager)

public **getEventsManager** ()

public **setActionSuffix** (*unknown* $actionSuffix)

public **setDefaultNamespace** (*unknown* $namespace)

public **setDefaultAction** (*unknown* $actionName)

public **setActionName** (*unknown* $actionName)

public **getActionName** ()

public **setParams** (*unknown* $params)

public **getParams** ()

public **setParam** (*unknown* $param, *unknown* $value)

public **getParam** (*unknown* $param)

public **isFinished** ()

public **getReturnedValue** ()

public **dispatch** ()

public **forward** (*unknown* $forward)

