Abstract class **Phalcon\\Dispatcher**
======================================

*implements* :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

This is the base class for Phalcon\\Mvc\\Dispatcher and Phalcon\\CLI\\Dispatcher. This class can't be instantiated directly, you can use it to create your own dispatchers


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

public  **__construct** ()

Phalcon\\Dispatcher constructor



public  **setDI** (*unknown* $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public  **setEventsManager** (*unknown* $eventsManager)

Sets the events manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()

Returns the internal event manager



public  **setActionSuffix** (*unknown* $actionSuffix)

Sets the default action suffix



public  **setModuleName** (*unknown* $moduleName)

Sets the module where the controller is (only informative)



public *string*  **getModuleName** ()

Gets the module where the controller class is



public  **setNamespaceName** (*unknown* $namespaceName)

Sets the namespace where the controller class is



public *string*  **getNamespaceName** ()

Gets a namespace to be prepended to the current handler name



public  **setDefaultNamespace** (*unknown* $namespaceName)

Sets the default namespace



public *string*  **getDefaultNamespace** ()

Returns the default namespace



public  **setDefaultAction** (*unknown* $actionName)

Sets the default action name



public  **setActionName** (*unknown* $actionName)

Sets the action name to be dispatched



public *string*  **getActionName** ()

Gets the latest dispatched action name



public  **setParams** (*unknown* $params)

Sets action params to be dispatched



public *array*  **getParams** ()

Gets action params



public  **setParam** (*unknown* $param, *unknown* $value)

Set a param by its name or numeric index



public *mixed*  **getParam** (*unknown* $param, [*unknown* $filters], [*unknown* $defaultValue])

Gets a param by its name or numeric index



public *string*  **getActiveMethod** ()

Returns the current method to be/executed in the dispatcher



public *boolean*  **isFinished** ()

Checks if the dispatch loop is finished or has more pendent controllers/tasks to dispatch



public  **setReturnedValue** (*unknown* $value)

Sets the latest returned value by an action manually



public *mixed*  **getReturnedValue** ()

Returns value returned by the lastest dispatched action



public *object*  **dispatch** ()

Dispatches a handle action taking into account the routing parameters



public  **forward** (*unknown* $forward)

Forwards the execution flow to another controller/action Dispatchers are unique per module. Forwarding between modules is not allowed 

.. code-block:: php

    <?php

      $this->dispatcher->forward(array("controller" => "posts", "action" => "index"));




public *boolean*  **wasForwarded** ()

Check if the current executed action was forwarded by another one



