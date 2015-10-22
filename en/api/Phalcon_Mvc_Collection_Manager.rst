Class **Phalcon\\Mvc\\Collection\\Manager**
===========================================

*implements* :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/collection/manager.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This components controls the initialization of models, keeping record of relations between the different models of the application.  A CollectionManager is injected to a model via a Dependency Injector Container such as Phalcon\\Di.  

.. code-block:: php

    <?php

     $di = new \Phalcon\Di();
    
     $di->set('collectionManager', function(){
          return new \Phalcon\Mvc\Collection\Manager();
     });
    
     $robot = new Robots($di);



Methods
-------

public  **setDI** (*unknown* $dependencyInjector)

Sets the DependencyInjector container



public  **getDI** ()

Returns the DependencyInjector container



public  **setEventsManager** (*unknown* $eventsManager)

Sets the event manager



public  **getEventsManager** ()

Returns the internal event manager



public  **setCustomEventsManager** (*unknown* $model, *unknown* $eventsManager)

Sets a custom events manager for a specific model



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getCustomEventsManager** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Returns a custom events manager related to a model



public  **initialize** (*unknown* $model)

Initializes a model in the models manager



public  **isInitialized** (*unknown* $modelName)

Check whether a model is already initialized



public  **getLastInitialized** ()

Get the latest initialized model



public  **setConnectionService** (*unknown* $model, *unknown* $connectionService)

Sets a connection service for a specific model



public  **useImplicitObjectIds** (*unknown* $model, *unknown* $useImplicitObjectIds)

Sets whether a model must use implicit objects ids



public  **isUsingImplicitObjectIds** (*unknown* $model)

Checks if a model is using implicit object ids



public *\Mongo*  **getConnection** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Returns the connection related to a model



public  **notifyEvent** (*unknown* $eventName, *unknown* $model)

Receives events generated in the models and dispatches them to a events-manager if available Notify the behaviors that are listening in the model



public  **missingMethod** (*unknown* $model, *unknown* $eventName, *unknown* $data)

Dispatch a event to the listeners and behaviors This method expects that the endpoint listeners/behaviors returns true meaning that a least one was implemented



public  **addBehavior** (*unknown* $model, *unknown* $behavior)

Binds a behavior to a model



