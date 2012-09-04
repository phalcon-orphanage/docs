Class **Phalcon\\Mvc\\Dispatcher**
==================================

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

public **__construct** ()

public **setDI** (*Phalcon\DI* $dependencyInjector)

Sets the dependency injector



:doc:`Phalcon\\DI <Phalcon_DI>` public **getDI** ()

Returns the internal dependency injector



public **setEventsManager** (*Phalcon\Events\Manager* $eventsManager)

Sets the events manager



:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` public **getEventsManager** ()

Returns the internal event manager



public **setDefaultNamespace** (*string* $namespace)

Sets the default namespace



public **setDefaultController** (*string* $controllerName)

Sets the default controller name



public **setDefaultAction** (*string* $actionName)

Sets the default action name



public **setControllerName** (*string* $controllerName)

Sets the controller name to be dispatched



*string* public **getControllerName** ()

Gets last dispatched controller name



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



:doc:`Phalcon\\Mvc\\Controller <Phalcon_Mvc_Controller>` public **dispatch** ()

Dispatches a controller action taking into account the routing parameters



protected **_throwDispatchException** ()

Throws an internal exception



public **forward** (*array* $forward)





*boolean* public **isFinished** ()

Checks if the dispatch loop is finished or have more pendent controller to disptach



:doc:`Phalcon\\Mvc\\Controller <Phalcon_Mvc_Controller>` public **getLastController** ()

Returns the lastest dispatched controller



*mixed* public **getReturnedValue** ()

Returns value returned by the lastest dispatched action



:doc:`Phalcon\\Mvc\\Controller <Phalcon_Mvc_Controller>` public **getActiveController** ()

Returns the active controller in the dispatcher



