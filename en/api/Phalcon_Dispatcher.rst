Abstract class **Phalcon\\Dispatcher**
======================================

*implements* :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/dispatcher.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This is the base class for Phalcon\\Mvc\\Dispatcher and Phalcon\\Cli\\Dispatcher. This class can't be instantiated directly, you can use it to create your own dispatchers.


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

public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injector



public  **getDI** ()

Returns the internal dependency injector



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets the events manager



public  **getEventsManager** ()

Returns the internal event manager



public  **setActionSuffix** (*mixed* $actionSuffix)

Sets the default action suffix



public  **getActionSuffix** ()

Gets the default action suffix



public  **setModuleName** (*mixed* $moduleName)

Sets the module where the controller is (only informative)



public  **getModuleName** ()

Gets the module where the controller class is



public  **setNamespaceName** (*mixed* $namespaceName)

Sets the namespace where the controller class is



public  **getNamespaceName** ()

Gets a namespace to be prepended to the current handler name



public  **setDefaultNamespace** (*mixed* $namespaceName)

Sets the default namespace



public  **getDefaultNamespace** ()

Returns the default namespace



public  **setDefaultAction** (*mixed* $actionName)

Sets the default action name



public  **setActionName** (*mixed* $actionName)

Sets the action name to be dispatched



public  **getActionName** ()

Gets the latest dispatched action name



public  **setParams** (*array* $params)

Sets action params to be dispatched



public  **getParams** ()

Gets action params



public  **setParam** (*mixed* $param, *mixed* $value)

Set a param by its name or numeric index



public *mixed* **getParam** (*mixed* $param, [*string* | *array* $filters], [*mixed* $defaultValue])

Gets a param by its name or numeric index



public *boolean* **hasParam** (*mixed* $param)

Check if a param exists



public  **getActiveMethod** ()

Returns the current method to be/executed in the dispatcher



public  **isFinished** ()

Checks if the dispatch loop is finished or has more pendent controllers/tasks to dispatch



public  **setReturnedValue** (*mixed* $value)

Sets the latest returned value by an action manually



public *mixed* **getReturnedValue** ()

Returns value returned by the latest dispatched action



public  **setModelBinding** (*boolean* $value)

Enable/Disable model binding during dispatch



public *object* **dispatch** ()

Dispatches a handle action taking into account the routing parameters



protected *object* **_dispatch** ()

Dispatches a handle action taking into account the routing parameters



public  **forward** (*array* $forward)

Forwards the execution flow to another controller/action Dispatchers are unique per module. Forwarding between modules is not allowed 

.. code-block:: php

    <?php

      $this->dispatcher->forward(array("controller" => "posts", "action" => "index"));




public  **wasForwarded** ()

Check if the current executed action was forwarded by another one



public  **getHandlerClass** ()

Possible class name that will be located to dispatch the request



public  **callActionMethod** (*mixed* $handler, *mixed* $actionMethod, [*array* $params])

...


protected  **_resolveEmptyProperties** ()

Set empty properties to their defaults (where defaults are available)



