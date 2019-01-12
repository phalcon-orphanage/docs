* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Model\TransactionInterface'

* * *

# Interface **Phalcon\Mvc\Model\TransactionInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/model/transactioninterface.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

## メソッド

abstract public **setTransactionManager** ([Phalcon\Mvc\Model\Transaction\ManagerInterface](/4.0/en/api/Phalcon_Mvc_Model_Transaction_ManagerInterface) $manager)

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

abstract public **setRollbackedRecord** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $record)

...