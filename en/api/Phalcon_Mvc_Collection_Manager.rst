Class **Phalcon\\Mvc\\Collection\\Manager**
===========================================

*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Mvc\\Collection\\ManagerInterface <Phalcon_Mvc_Collection_ManagerInterface>`

This components controls the initialization of models, keeping record of relations between the different models of the application.  A CollectionManager is injected to a model via a Dependency Injector Container such as Phalcon\\DI.  

.. code-block:: php

    <?php

     $di = new Phalcon\DI();
    
     $di->set('collectionManager', function(){
          return new Phalcon\Mvc\Collection\Manager();
     });
    
     $robot = new Robots($di);



Methods
---------

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



public  **initialize** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Initializes a model in the models manager



public *bool*  **isInitialized** (*string* $modelName)

Check whether a model is already initialized



public :doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>`  **getLastInitialized** ()

Get the latest initialized model



public  **setConnectionService** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model, *string* $connectionService)

Sets a connection service for a specific model



public  **useImplicitObjectIds** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model, *boolean* $useImplicitObjectIds)

Sets if a model must use implicit objects ids



public *boolean*  **isUsingImplicitObjectIds** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Checks if a model is using implicit object ids



public :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>` (?) MongoDB **getConnection** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Returns the connection related to a model



public  **notifyEvent** (*string* $eventName, :doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Receives events generated in the models and dispatches them to a events-manager if available Notify the behaviors that are listening in the model



