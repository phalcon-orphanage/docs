Interface **Phalcon\\Mvc\\Model\\TransactionInterface**
=======================================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/transactioninterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **setTransactionManager** (*unknown* $manager)

...


abstract public  **begin** ()

...


abstract public  **commit** ()

...


abstract public  **rollback** ([*unknown* $rollbackMessage], [*unknown* $rollbackRecord])

...


abstract public  **getConnection** ()

...


abstract public  **setIsNewTransaction** (*unknown* $isNew)

...


abstract public  **setRollbackOnAbort** (*unknown* $rollbackOnAbort)

...


abstract public  **isManaged** ()

...


abstract public  **getMessages** ()

...


abstract public  **isValid** ()

...


abstract public  **setRollbackedRecord** (*unknown* $record)

...


