Class **Phalcon\\Mvc\\Collection\\Manager**
===========================================

*implements* :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

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

public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the DependencyInjector container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the DependencyInjector container



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets the event manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()

Returns the internal event manager



public  **setCustomEventsManager** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model, :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets a custom events manager for a specific model



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getCustomEventsManager** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Returns a custom events manager related to a model



public  **initialize** (*unknown* $model)

Initializes a model in the models manager



public *bool*  **isInitialized** (*string* $modelName)

Check whether a model is already initialized



public :doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>`  **getLastInitialized** ()

Get the latest initialized model



public  **setConnectionService** (*unknown* $model, *unknown* $connectionService)

Sets a connection service for a specific model



public  **useImplicitObjectIds** (*unknown* $model, *unknown* $useImplicitObjectIds)

Sets whether a model must use implicit objects ids



public *boolean*  **isUsingImplicitObjectIds** (*unknown* $model)

Checks if a model is using implicit object ids



public *\Mongo*  **getConnection** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Returns the connection related to a model



public  **notifyEvent** (*unknown* $eventName, *unknown* $model)

Receives events generated in the models and dispatches them to a events-manager if available Notify the behaviors that are listening in the model



