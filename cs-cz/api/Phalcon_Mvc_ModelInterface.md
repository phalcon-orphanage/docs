* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\ModelInterface'

* * *

# Interface **Phalcon\Mvc\ModelInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/modelinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods

abstract public **setTransaction** ([Phalcon\Mvc\Model\TransactionInterface](/4.0/en/api/Phalcon_Mvc_Model_TransactionInterface) $transaction)

...

abstract public **getSource** ()

...

abstract public **getSchema** ()

...

abstract public **setConnectionService** (*mixed* $connectionService)

...

abstract public **setWriteConnectionService** (*mixed* $connectionService)

...

abstract public **setReadConnectionService** (*mixed* $connectionService)

...

abstract public **getReadConnectionService** ()

...

abstract public **getWriteConnectionService** ()

...

abstract public **getReadConnection** ()

...

abstract public **getWriteConnection** ()

...

abstract public **setDirtyState** (*mixed* $dirtyState)

...

abstract public **getDirtyState** ()

...

abstract public **assign** (*array* $data, [*mixed* $dataColumnMap], [*mixed* $whiteList])

...

abstract public static **cloneResultMap** (*mixed* $base, *array* $data, *mixed* $columnMap, [*mixed* $dirtyState], [*mixed* $keepSnapshots])

...

abstract public static **cloneResult** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $base, *array* $data, [*mixed* $dirtyState])

...

abstract public static **cloneResultMapHydrate** (*array* $data, *mixed* $columnMap, *mixed* $hydrationMode)

...

abstract public static **find** ([*mixed* $parameters])

...

abstract public static **findFirst** ([*mixed* $parameters])

...

abstract public static **query** ([[Phalcon\DiInterface](/4.0/en/api/Phalcon_DiInterface) $dependencyInjector])

...

abstract public static **count** ([*mixed* $parameters])

...

abstract public static **sum** ([*mixed* $parameters])

...

abstract public static **maximum** ([*mixed* $parameters])

...

abstract public static **minimum** ([*mixed* $parameters])

...

abstract public static **average** ([*mixed* $parameters])

...

abstract public **fireEvent** (*mixed* $eventName)

...

abstract public **fireEventCancel** (*mixed* $eventName)

...

abstract public **appendMessage** ([Phalcon\Mvc\Model\MessageInterface](/4.0/en/api/Phalcon_Mvc_Model_MessageInterface) $message)

...

abstract public **validationHasFailed** ()

...

abstract public **getMessages** ()

...

abstract public **save** ([*mixed* $data], [*mixed* $whiteList])

...

abstract public **create** ([*mixed* $data], [*mixed* $whiteList])

...

abstract public **update** ([*mixed* $data], [*mixed* $whiteList])

...

abstract public **delete** ()

...

abstract public **getOperationMade** ()

...

abstract public **refresh** ()

...

abstract public **skipOperation** (*mixed* $skip)

...

abstract public **getRelated** (*mixed* $alias, [*mixed* $arguments])

...

abstract public **setSnapshotData** (*array* $data, [*mixed* $columnMap])

...

abstract public **reset** ()

...