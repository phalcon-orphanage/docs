Interface **Phalcon\\Mvc\\ModelInterface**
==========================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/modelinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **setTransaction** (:doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>` $transaction)

...


abstract public  **getSource** ()

...


abstract public  **getSchema** ()

...


abstract public  **setConnectionService** (*unknown* $connectionService)

...


abstract public  **setWriteConnectionService** (*unknown* $connectionService)

...


abstract public  **setReadConnectionService** (*unknown* $connectionService)

...


abstract public  **getReadConnectionService** ()

...


abstract public  **getWriteConnectionService** ()

...


abstract public  **getReadConnection** ()

...


abstract public  **getWriteConnection** ()

...


abstract public  **setDirtyState** (*unknown* $dirtyState)

...


abstract public  **getDirtyState** ()

...


abstract public  **assign** (*array* $data, [*unknown* $dataColumnMap], [*unknown* $whiteList])

...


abstract public static  **cloneResultMap** (*unknown* $base, *array* $data, *unknown* $columnMap, [*unknown* $dirtyState], [*unknown* $keepSnapshots])

...


abstract public static  **cloneResult** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $base, *array* $data, [*unknown* $dirtyState])

...


abstract public static  **cloneResultMapHydrate** (*array* $data, *unknown* $columnMap, *unknown* $hydrationMode)

...


abstract public static  **find** ([*unknown* $parameters])

...


abstract public static  **findFirst** ([*unknown* $parameters])

...


abstract public static  **query** ([:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector])

...


abstract public static  **count** ([*unknown* $parameters])

...


abstract public static  **sum** ([*unknown* $parameters])

...


abstract public static  **maximum** ([*unknown* $parameters])

...


abstract public static  **minimum** ([*unknown* $parameters])

...


abstract public static  **average** ([*unknown* $parameters])

...


abstract public  **fireEvent** (*unknown* $eventName)

...


abstract public  **fireEventCancel** (*unknown* $eventName)

...


abstract public  **appendMessage** (:doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>` $message)

...


abstract public  **validationHasFailed** ()

...


abstract public  **getMessages** ()

...


abstract public  **save** ([*unknown* $data], [*unknown* $whiteList])

...


abstract public  **create** ([*unknown* $data], [*unknown* $whiteList])

...


abstract public  **update** ([*unknown* $data], [*unknown* $whiteList])

...


abstract public  **delete** ()

...


abstract public  **getOperationMade** ()

...


abstract public  **refresh** ()

...


abstract public  **skipOperation** (*unknown* $skip)

...


abstract public  **getRelated** (*unknown* $alias, [*unknown* $arguments])

...


abstract public  **setSnapshotData** (*array* $data, [*unknown* $columnMap])

...


abstract public  **reset** ()

...


