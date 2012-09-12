Class **Phalcon\\Mvc\\Dispatcher**
==================================

*extends* :doc:`Phalcon\\Dispatcher <Phalcon_Dispatcher>`

Dispatching is the process of taking the request object, extracting the module name, controller name, action name, and optional parameters contained in it, and then instantiating a controller and calling an action of that controller. 

.. code-block:: php

    <?php

    $di = new Phalcon\DI();
    
    $dispatcher = new Phalcon\Mvc\Dispatcher();
    
      $dispatcher->setDI($di);
    
    $dispatcher->setControllerName('posts');
    $dispatcher->setActionName('index');
    $dispatcher->setParams(array());
    
    $controller = $dispatcher->dispatch();



Methods
---------

public **setControllerSuffix** (*string* $controllerSuffix)

Sets the default controller suffix



public **setDefaultController** (*string* $controllerName)

Sets the default controller name



public **setControllerName** (*string* $controllerName)

Sets the controller name to be dispatched



*string* public **getControllerName** ()

Gets last dispatched controller name



protected **_throwDispatchException** ()

Throws an internal exception



:doc:`Phalcon\\Mvc\\Controller <Phalcon_Mvc_Controller>` public **getLastController** ()

Returns the lastest dispatched controller



:doc:`Phalcon\\Mvc\\Controller <Phalcon_Mvc_Controller>` public **getActiveController** ()

Returns the active controller in the dispatcher



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





