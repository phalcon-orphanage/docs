---
layout: article
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Mvc\Model\TransactionInterface'
---
# Interface **Phalcon\Mvc\Model\TransactionInterface**

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/transactioninterface.zep)

## メソッド

abstract public **setTransactionManager** ([Phalcon\Mvc\Model\Transaction\ManagerInterface](Phalcon_Mvc_Model_Transaction_ManagerInterface) $manager)

...

abstract public **begin** ()

...

abstract public **commit** ()

...

abstract public **rollback** ([*mixed* $rollbackMessage], [*mixed* $rollbackRecord])

...

abstract public **getConnection** ()

...

abstract public **setIsNewTransaction** (*mixed* $isNew)

...

abstract public **setRollbackOnAbort** (*mixed* $rollbackOnAbort)

...

abstract public **isManaged** ()

...

abstract public **getMessages** ()

...

abstract public **isValid** ()

...

abstract public **setRollbackedRecord** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $record)

...