Class **Phalcon\\Mvc\\Dispatcher**
==================================

*extends* :doc:`Phalcon\\Dispatcher <Phalcon_Dispatcher>`

<<<<<<< HEAD
Dispatching is the process of taking the request object, extracting the module name, controller name, action name, and optional parameters contained in it, and then instantiating a controller and calling an action of that controller. 
=======
*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`, :doc:`Phalcon\\Mvc\\DispatcherInterface <Phalcon_Mvc_DispatcherInterface>`

Dispatching is the process of taking the request object, extracting the module name, controller name, action name, and optional parameters contained in it, and then instantiating a controller and calling an action of that controller.  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    $di = new Phalcon\DI();
    
    $dispatcher = new Phalcon\Mvc\Dispatcher();
    
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

<<<<<<< HEAD
=======
*integer* **EXCEPTION_INVALID_HANDLER**

>>>>>>> 0.7.0
*integer* **EXCEPTION_INVALID_PARAMS**

*integer* **EXCEPTION_ACTION_NOT_FOUND**

Methods
---------

public  **setControllerSuffix** (*string* $controllerSuffix)

Sets the default controller suffix



public  **setDefaultController** (*string* $controllerName)

Sets the default controller name



public  **setControllerName** (*string* $controllerName)

Sets the controller name to be dispatched



public *string*  **getControllerName** ()

Gets last dispatched controller name



protected  **_throwDispatchException** ()

Throws an internal exception



public :doc:`Phalcon\\Mvc\\Controller <Phalcon_Mvc_Controller>`  **getLastController** ()

Returns the lastest dispatched controller



public :doc:`Phalcon\\Mvc\\Controller <Phalcon_Mvc_Controller>`  **getActiveController** ()

Returns the active controller in the dispatcher



public  **__construct** () inherited from Phalcon\\Dispatcher

<<<<<<< HEAD
...


public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector) inherited from Phalcon\\Dispatcher
=======
Phalcon\\Dispatcher constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\Dispatcher
>>>>>>> 0.7.0

Sets the dependency injector



<<<<<<< HEAD
public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** () inherited from Phalcon\\Dispatcher
=======
public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** () inherited from Phalcon\\Dispatcher
>>>>>>> 0.7.0

Returns the internal dependency injector



<<<<<<< HEAD
public  **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager) inherited from Phalcon\\Dispatcher
=======
public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from Phalcon\\Dispatcher
>>>>>>> 0.7.0

Sets the events manager



<<<<<<< HEAD
public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** () inherited from Phalcon\\Dispatcher
=======
public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** () inherited from Phalcon\\Dispatcher
>>>>>>> 0.7.0

Returns the internal event manager



public  **setActionSuffix** (*string* $actionSuffix) inherited from Phalcon\\Dispatcher

Sets the default action suffix



<<<<<<< HEAD
=======
public  **setNamespaceName** (*string* $namespaceName) inherited from Phalcon\\Dispatcher

Sets a namespace to be prepended to the handler name



public *string*  **getNamespaceName** () inherited from Phalcon\\Dispatcher

Gets a namespace to be prepended to the current handler name



>>>>>>> 0.7.0
public  **setDefaultNamespace** (*string* $namespace) inherited from Phalcon\\Dispatcher

Sets the default namespace



<<<<<<< HEAD
=======
public *string*  **getDefaultNamespace** () inherited from Phalcon\\Dispatcher

Returns the default namespace



>>>>>>> 0.7.0
public  **setDefaultAction** (*string* $actionName) inherited from Phalcon\\Dispatcher

Sets the default action name



public  **setActionName** (*string* $actionName) inherited from Phalcon\\Dispatcher

Sets the action name to be dispatched



public *string*  **getActionName** () inherited from Phalcon\\Dispatcher

Gets last dispatched action name



public  **setParams** (*array* $params) inherited from Phalcon\\Dispatcher

Sets action params to be dispatched



public *array*  **getParams** () inherited from Phalcon\\Dispatcher

Gets action params



public  **setParam** (*mixed* $param, *mixed* $value) inherited from Phalcon\\Dispatcher

Set a param by its name or numeric index



<<<<<<< HEAD
public *mixed*  **getParam** (*mixed* $param, *string|array* $filters) inherited from Phalcon\\Dispatcher
=======
public *mixed*  **getParam** (*mixed* $param, *string|array* $filters, *mixed* $defaultValue) inherited from Phalcon\\Dispatcher
>>>>>>> 0.7.0

Gets a param by its name or numeric index



public *boolean*  **isFinished** () inherited from Phalcon\\Dispatcher

<<<<<<< HEAD
Checks if the dispatch loop is finished or have more pendent controllers/tasks to disptach
=======
Checks if the dispatch loop is finished or has more pendent controllers/tasks to disptach
>>>>>>> 0.7.0



public *mixed*  **getReturnedValue** () inherited from Phalcon\\Dispatcher

Returns value returned by the lastest dispatched action



public *object*  **dispatch** () inherited from Phalcon\\Dispatcher

Dispatches a handle action taking into account the routing parameters



public  **forward** (*array* $forward) inherited from Phalcon\\Dispatcher

Forwards the execution flow to another controller/action



