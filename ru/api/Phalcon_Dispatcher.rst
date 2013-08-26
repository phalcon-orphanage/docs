Class **Phalcon\\Dispatcher**
=============================

*implements* :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

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
---------

public  **__construct** ()

Phalcon\\Dispatcher constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets the events manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()

Returns the internal event manager



public  **setActionSuffix** (*string* $actionSuffix)

Sets the default action suffix



public  **setModuleName** (*string* $moduleName)

Sets the module where the controller is (only informative)



public *string*  **getModuleName** ()

Gets the module where the controller class is



public  **setNamespaceName** (*string* $namespaceName)

Sets the namespace where the controller class is



public *string*  **getNamespaceName** ()

Gets a namespace to be prepended to the current handler name



public  **setDefaultNamespace** (*string* $namespace)

Sets the default namespace



public *string*  **getDefaultNamespace** ()

Returns the default namespace



public  **setDefaultAction** (*string* $actionName)

Sets the default action name



public  **setActionName** (*string* $actionName)

Sets the action name to be dispatched



public *string*  **getActionName** ()

Gets the lastest dispatched action name



public  **setParams** (*array* $params)

Sets action params to be dispatched



public *array*  **getParams** ()

Gets action params



public  **setParam** (*mixed* $param, *mixed* $value)

Set a param by its name or numeric index



public *mixed*  **getParam** (*mixed* $param, [*string|array* $filters], [*mixed* $defaultValue])

Gets a param by its name or numeric index



public *string*  **getActiveMethod** ()

Returns the current method to be/executed in the dispatcher



public *boolean*  **isFinished** ()

Checks if the dispatch loop is finished or has more pendent controllers/tasks to disptach



public  **setReturnedValue** (*mixed* $value)

Sets the latest returned value by an action manually



public *mixed*  **getReturnedValue** ()

Returns value returned by the lastest dispatched action



public *object*  **dispatch** ()

Dispatches a handle action taking into account the routing parameters



public  **forward** (*array* $forward)

Forwards the execution flow to another controller/action Dispatchers are unique per module. Forwarding between modules is not allowed 

.. code-block:: php

    <?php

      $this->dispatcher->forward(array('controller' => 'posts', 'action' => 'index'));




public *boolean*  **wasForwarded** ()

Check if the current executed action was forwarded by another one



public *string*  **getHandlerClass** ()

Possible class name that will be located to dispatch the request



