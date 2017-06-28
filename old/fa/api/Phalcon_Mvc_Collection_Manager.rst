Class **Phalcon\\Mvc\\Collection\\Manager**
===========================================

*implements* :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/collection/manager.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This components controls the initialization of models, keeping record of relations
between the different models of the application.

A CollectionManager is injected to a model via a Dependency Injector Container such as Phalcon\\Di.

.. code-block:: php

    <?php

    $di = new \Phalcon\Di();

    $di->set(
        "collectionManager",
        function () {
            return new \Phalcon\Mvc\Collection\Manager();
        }
    );

    $robot = new Robots($di);



Methods
-------

public  **getServiceName** ()

...


public  **setServiceName** (*mixed* $serviceName)

...


public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the DependencyInjector container



public  **getDI** ()

Returns the DependencyInjector container



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets the event manager



public  **getEventsManager** ()

Returns the internal event manager



public  **setCustomEventsManager** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model, :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets a custom events manager for a specific model



public  **getCustomEventsManager** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Returns a custom events manager related to a model



public  **initialize** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Initializes a model in the models manager



public  **isInitialized** (*mixed* $modelName)

Check whether a model is already initialized



public  **getLastInitialized** ()

Get the latest initialized model



public  **setConnectionService** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model, *mixed* $connectionService)

Sets a connection service for a specific model



public  **getConnectionService** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Gets a connection service for a specific model



public  **useImplicitObjectIds** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model, *mixed* $useImplicitObjectIds)

Sets whether a model must use implicit objects ids



public  **isUsingImplicitObjectIds** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Checks if a model is using implicit object ids



public *Mongo* **getConnection** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Returns the connection related to a model



public  **notifyEvent** (*mixed* $eventName, :doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Receives events generated in the models and dispatches them to an events-manager if available
Notify the behaviors that are listening in the model



public  **missingMethod** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model, *mixed* $eventName, *mixed* $data)

Dispatch an event to the listeners and behaviors
This method expects that the endpoint listeners/behaviors returns true
meaning that at least one was implemented



public  **addBehavior** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model, :doc:`Phalcon\\Mvc\\Collection\\BehaviorInterface <Phalcon_Mvc_Collection_BehaviorInterface>` $behavior)

Binds a behavior to a model



