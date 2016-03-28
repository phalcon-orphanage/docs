Class **Phalcon\\Mvc\\Dispatcher**
==================================

*extends* abstract class :doc:`Phalcon\\Dispatcher <Phalcon_Dispatcher>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`, :doc:`Phalcon\\Mvc\\DispatcherInterface <Phalcon_Mvc_DispatcherInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/dispatcher.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

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

public  **setControllerSuffix** (*mixed* $controllerSuffix)

Sets the default controller suffix



public  **setDefaultController** (*mixed* $controllerName)

Sets the default controller name



public  **setControllerName** (*mixed* $controllerName)

Sets the controller name to be dispatched



public  **getControllerName** ()

Gets last dispatched controller name



public  **getPreviousControllerName** ()

Gets previous dispatched controller name



public  **getPreviousActionName** ()

Gets previous dispatched action name



protected  **_throwDispatchException** (*mixed* $message, [*mixed* $exceptionCode])

Throws an internal exception



protected  **_handleException** (*Exception* $exception)

Handles a user exception



public  **getControllerClass** ()

Possible controller class name that will be located to dispatch the request



public  **getLastController** ()

Returns the lastest dispatched controller



public  **getActiveController** ()

Returns the active controller in the dispatcher



public  **__construct** () inherited from Phalcon\\Dispatcher

Phalcon\\Dispatcher constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\Dispatcher

Sets the dependency injector



public  **getDI** () inherited from Phalcon\\Dispatcher

Returns the internal dependency injector



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from Phalcon\\Dispatcher

Sets the events manager



public  **getEventsManager** () inherited from Phalcon\\Dispatcher

Returns the internal event manager



public  **setActionSuffix** (*mixed* $actionSuffix) inherited from Phalcon\\Dispatcher

Sets the default action suffix



public  **getActionSuffix** () inherited from Phalcon\\Dispatcher

...


public  **setModuleName** (*mixed* $moduleName) inherited from Phalcon\\Dispatcher

Sets the module where the controller is (only informative)



public  **getModuleName** () inherited from Phalcon\\Dispatcher

Gets the module where the controller class is



public  **setNamespaceName** (*mixed* $namespaceName) inherited from Phalcon\\Dispatcher

Sets the namespace where the controller class is



public  **getNamespaceName** () inherited from Phalcon\\Dispatcher

Gets a namespace to be prepended to the current handler name



public  **setDefaultNamespace** (*mixed* $namespaceName) inherited from Phalcon\\Dispatcher

Sets the default namespace



public  **getDefaultNamespace** () inherited from Phalcon\\Dispatcher

Returns the default namespace



public  **setDefaultAction** (*mixed* $actionName) inherited from Phalcon\\Dispatcher

Sets the default action name



public  **setActionName** (*mixed* $actionName) inherited from Phalcon\\Dispatcher

Sets the action name to be dispatched



public  **getActionName** () inherited from Phalcon\\Dispatcher

Gets the latest dispatched action name



public  **setParams** (*array* $params) inherited from Phalcon\\Dispatcher

Sets action params to be dispatched



public  **getParams** () inherited from Phalcon\\Dispatcher

Gets action params



public  **setParam** (*mixed* $param, *mixed* $value) inherited from Phalcon\\Dispatcher

Set a param by its name or numeric index



public *mixed*  **getParam** (*mixed* $param, [*string|array* $filters], [*mixed* $defaultValue]) inherited from Phalcon\\Dispatcher

Gets a param by its name or numeric index



public  **getActiveMethod** () inherited from Phalcon\\Dispatcher

Returns the current method to be/executed in the dispatcher



public  **isFinished** () inherited from Phalcon\\Dispatcher

Checks if the dispatch loop is finished or has more pendent controllers/tasks to dispatch



public  **setReturnedValue** (*mixed* $value) inherited from Phalcon\\Dispatcher

Sets the latest returned value by an action manually



public *mixed*  **getReturnedValue** () inherited from Phalcon\\Dispatcher

Returns value returned by the lastest dispatched action



public  **setModelBinding** (*mixed* $value) inherited from Phalcon\\Dispatcher

...


public *object*  **dispatch** () inherited from Phalcon\\Dispatcher

Dispatches a handle action taking into account the routing parameters



public  **forward** (*array* $forward) inherited from Phalcon\\Dispatcher

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



