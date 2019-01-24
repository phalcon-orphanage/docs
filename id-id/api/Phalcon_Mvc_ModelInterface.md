---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\ModelInterface'
---
# Interface **Phalcon\Mvc\ModelInterface**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/modelinterface.zep)

## Metode

abstract public **setTransaction** ([Phalcon\Mvc\Model\TransactionInterface](Phalcon_Mvc_Model_TransactionInterface) $transaction)

...

publik abstrak **getSource** ()

...

abstrak publik ** getSchema </ 0> ()</p> 

...

publik abstrak **setConnectionService**(*campuran* $connectionService)

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

abstrak publik **setDirtyState**(*dicampur* $dirtyState)

...

abstrak Umum **getdirtystate** ()

...

abstract public **assign** (*array* $data, [*mixed* $dataColumnMap], [*mixed* $whiteList])

...

abstract public static **cloneResultMap** (*mixed* $base, *array* $data, *mixed* $columnMap, [*mixed* $dirtyState], [*mixed* $keepSnapshots])

...

abstract public static **cloneResult** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $base, *array* $data, [*mixed* $dirtyState])

...

abstract public static **cloneResultMapHydrate** (*array* $data, *mixed* $columnMap, *mixed* $hydrationMode)

...

abstract public static **find** ([*mixed* $parameters])

...

abstract public static **findFirst** ([*mixed* $parameters])

...

abstract public static **query** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

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

abstrak Umum **acarakebakaran**(*dicampur* $eventName)

...

abstrak Umum **acarakebakaranbatal**(*dicampur* $eventName)

...

abstract public **appendMessage** ([Phalcon\Mvc\Model\MessageInterface](Phalcon_Mvc_Model_MessageInterface) $message)

...

abstrak Umum **validasiTelahGagal**()

...

abstrak publik **getMessages** ()

...

abstract public **save** ([*mixed* $data], [*mixed* $whiteList])

...

abstract public **create** ([*mixed* $data], [*mixed* $whiteList])

...

abstract public **update** ([*mixed* $data], [*mixed* $whiteList])

...

abstrak publik **hapus** ()

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

abstrak publik **reset** ()

...