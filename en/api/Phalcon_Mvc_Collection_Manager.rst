Class **Phalcon\\Mvc\\Collection\\Manager**
===========================================

*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

This components controls the initialization of models, keeping record of relations between the different models of the application.  A CollectionManager is injected to a model via a Dependency Injector Container such as Phalcon\\DI.  

.. code-block:: php

    <?php

     $dependencyInjector = new Phalcon\DI();
    
     $dependencyInjector->set('collectionManager', function(){
          return new Phalcon\Mvc\Collection\Manager();
     });
    
     $robot = new Robots($dependencyInjector);



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

Initializes a model in the model manager



public *bool*  **isInitialized** (*string* $modelName)

Check whether a model is already initialized



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getLastInitialized** ()

Get the lastest initialized model



public  **setConnectionService** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *string* $connectionService)

Set a connection service for a model



public :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>`  **getConnection** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Returns the connection related to a model



public  **notifyEvent** (*string* $eventName, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Receives events generated in the models and dispatches them to a events-manager if available Notify the behaviors that are listening in the model



