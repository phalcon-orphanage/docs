Interface **Phalcon\\Mvc\\Collection\\ManagerInterface**
========================================================

Phalcon\\Mvc\\Collection\\ManagerInterface initializer


Methods
---------

abstract public  **setCustomEventsManager** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model, :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets a custom events manager for a specific model



abstract public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getCustomEventsManager** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Returns a custom events manager related to a model



abstract public  **initialize** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Initializes a model in the models manager



abstract public *bool*  **isInitialized** (*string* $modelName)

Check whether a model is already initialized



abstract public :doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>`  **getLastInitialized** ()

Get the latest initialized model



abstract public  **setConnectionService** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model, *string* $connectionService)

Sets a connection service for a specific model



abstract public  **useImplicitObjectIds** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model, *boolean* $useImplicitObjectIds)

Sets if a model must use implicit objects ids



abstract public *boolean*  **isUsingImplicitObjectIds** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Checks if a model is using implicit object ids



abstract public :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>`  **getConnection** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Returns the connection related to a model



abstract public  **notifyEvent** (*string* $eventName, :doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Receives events generated in the models and dispatches them to a events-manager if available Notify the behaviors that are listening in the model



