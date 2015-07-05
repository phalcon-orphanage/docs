Class **Phalcon\\Mvc\\Dispatcher**
==================================

*extends* abstract class :doc:`Phalcon\\Dispatcher <Phalcon_Dispatcher>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`, :doc:`Phalcon\\Mvc\\DispatcherInterface <Phalcon_Mvc_DispatcherInterface>`

Dispatching is the process of taking the request object, extracting the module name, controller name, action name, and optional parameters contained in it, and then instantiating a controller and calling an action of that controller.  

.. code-block:: php

    <?php

    $di = new \Phalcon\Di();
    
    $dispatcher = new \Phalcon\Mvc\Dispatcher();
    
      $dispatcher->setDI($di);
    
    $dispatcher->setControllerName('posts');
    $dispatcher->setActionName('index');
    $dispatcher->setParams(array());
    
    $controller = $dispatcher->dispatch();



Constants
---------

*integer* **EXCEPTION_NO_DI**

*integer* **EXCEPTION_CYCLIC_ROUTING**

*integer* **EXCEPTION_HANDLER_NOT_FOUND**

*integer* **EXCEPTION_INVALID_HANDLER**

*integer* **EXCEPTION_INVALID_PARAMS**

*integer* **EXCEPTION_ACTION_NOT_FOUND**

Methods
-------

public  **setControllerSuffix** (*unknown* $controllerSuffix)

Sets the default controller suffix



public  **setDefaultController** (*unknown* $controllerName)

Sets the default controller name



public  **setControllerName** (*unknown* $controllerName)

Sets the controller name to be dispatched



public  **getControllerName** ()

Gets last dispatched controller name



public  **getPreviousControllerName** ()

Gets previous dispatched controller name



public  **getPreviousActionName** ()

Gets previous dispatched action name



protected  **_throwDispatchException** (*unknown* $message, [*unknown* $exceptionCode])

Throws an internal exception



protected  **_handleException** (*unknown* $exception)

Handles a user exception



public  **getControllerClass** ()

Possible controller class name that will be located to dispatch the request



public  **getLastController** ()

Returns the lastest dispatched controller



public  **getActiveController** ()

Returns the active controller in the dispatcher



public  **__construct** () inherited from Phalcon\\Dispatcher

Phalcon\\Dispatcher constructor



public  **setDI** (*unknown* $dependencyInjector) inherited from Phalcon\\Dispatcher

Sets the dependency injector



public  **getDI** () inherited from Phalcon\\Dispatcher

Returns the internal dependency injector



public  **setEventsManager** (*unknown* $eventsManager) inherited from Phalcon\\Dispatcher

Sets the events manager



public  **getEventsManager** () inherited from Phalcon\\Dispatcher

Returns the internal event manager



public  **setActionSuffix** (*unknown* $actionSuffix) inherited from Phalcon\\Dispatcher

Sets the default action suffix



public  **setModuleName** (*unknown* $moduleName) inherited from Phalcon\\Dispatcher

Sets the module where the controller is (only informative)



public  **getModuleName** () inherited from Phalcon\\Dispatcher

Gets the module where the controller class is



public  **setNamespaceName** (*unknown* $namespaceName) inherited from Phalcon\\Dispatcher

Sets the namespace where the controller class is



public  **getNamespaceName** () inherited from Phalcon\\Dispatcher

Gets a namespace to be prepended to the current handler name



public  **setDefaultNamespace** (*unknown* $namespaceName) inherited from Phalcon\\Dispatcher

Sets the default namespace



public  **getDefaultNamespace** () inherited from Phalcon\\Dispatcher

Returns the default namespace



public  **setDefaultAction** (*unknown* $actionName) inherited from Phalcon\\Dispatcher

Sets the default action name



public  **setActionName** (*unknown* $actionName) inherited from Phalcon\\Dispatcher

Sets the action name to be dispatched



public  **getActionName** () inherited from Phalcon\\Dispatcher

Gets the latest dispatched action name



public  **setParams** (*unknown* $params) inherited from Phalcon\\Dispatcher

Sets action params to be dispatched



public  **getParams** () inherited from Phalcon\\Dispatcher

Gets action params



public  **setParam** (*unknown* $param, *unknown* $value) inherited from Phalcon\\Dispatcher

Set a param by its name or numeric index



public *mixed*  **getParam** (*unknown* $param, [*unknown* $filters], [*unknown* $defaultValue]) inherited from Phalcon\\Dispatcher

Gets a param by its name or numeric index



public  **getActiveMethod** () inherited from Phalcon\\Dispatcher

Returns the current method to be/executed in the dispatcher



public  **isFinished** () inherited from Phalcon\\Dispatcher

Checks if the dispatch loop is finished or has more pendent controllers/tasks to dispatch



public  **setReturnedValue** (*unknown* $value) inherited from Phalcon\\Dispatcher

Sets the latest returned value by an action manually



public *mixed*  **getReturnedValue** () inherited from Phalcon\\Dispatcher

Returns value returned by the lastest dispatched action



public *object*  **dispatch** () inherited from Phalcon\\Dispatcher

Dispatches a handle action taking into account the routing parameters



public  **forward** (*unknown* $forward) inherited from Phalcon\\Dispatcher

Forwards the execution flow to another controller/action Dispatchers are unique per module. Forwarding between modules is not allowed 

.. code-block:: php

    <?php

      $this->dispatcher->forward(array("controller" => "posts", "action" => "index"));




public  **wasForwarded** () inherited from Phalcon\\Dispatcher

Check if the current executed action was forwarded by another one



public  **getHandlerClass** () inherited from Phalcon\\Dispatcher

Possible class name that will be located to dispatch the request



protected  **_resolveEmptyProperties** () inherited from Phalcon\\Dispatcher

Set empty properties to their defaults (where defaults are available)



