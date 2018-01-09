# Interface **Phalcon\\Mvc\\Collection\\ManagerInterface**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/collection/managerinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods
abstract public  **setCustomEventsManager** ([Phalcon\Mvc\CollectionInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_CollectionInterface) $model, [Phalcon\Events\ManagerInterface](/[[language]]/[[version]]/api/Phalcon_Events_ManagerInterface) $eventsManager)

...


abstract public  **getCustomEventsManager** ([Phalcon\Mvc\CollectionInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_CollectionInterface) $model)

...


abstract public  **initialize** ([Phalcon\Mvc\CollectionInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_CollectionInterface) $model)

...


abstract public  **isInitialized** (*mixed* $modelName)

...


abstract public  **getLastInitialized** ()

...


abstract public  **setConnectionService** ([Phalcon\Mvc\CollectionInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_CollectionInterface) $model, *mixed* $connectionService)

...


abstract public  **useImplicitObjectIds** ([Phalcon\Mvc\CollectionInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_CollectionInterface) $model, *mixed* $useImplicitObjectIds)

...


abstract public  **isUsingImplicitObjectIds** ([Phalcon\Mvc\CollectionInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_CollectionInterface) $model)

...


abstract public  **getConnection** ([Phalcon\Mvc\CollectionInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_CollectionInterface) $model)

...


abstract public  **notifyEvent** (*mixed* $eventName, [Phalcon\Mvc\CollectionInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_CollectionInterface) $model)

...


abstract public  **addBehavior** ([Phalcon\Mvc\CollectionInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_CollectionInterface) $model, [Phalcon\Mvc\Collection\BehaviorInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_Collection_BehaviorInterface) $behavior)

...


