Interface **Phalcon\\Mvc\\Model\\TransactionInterface**
=======================================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/transactioninterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **setTransactionManager** (:doc:`Phalcon\\Mvc\\Model\\Transaction\\ManagerInterface <Phalcon_Mvc_Model_Transaction_ManagerInterface>` $manager)

...


abstract public  **begin** ()

...


abstract public  **commit** ()

...


abstract public  **rollback** ([*mixed* $rollbackMessage], [*mixed* $rollbackRecord])

...


abstract public  **getConnection** ()

...


abstract public  **setIsNewTransaction** (*mixed* $isNew)

...


abstract public  **setRollbackOnAbort** (*mixed* $rollbackOnAbort)

...


abstract public  **isManaged** ()

...


abstract public  **getMessages** ()

...


abstract public  **isValid** ()

...


abstract public  **setRollbackedRecord** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $record)

...


