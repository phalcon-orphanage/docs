Interface **Phalcon\\Mvc\\Model\\Transaction\\ManagerInterface**
================================================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/transaction/managerinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **__construct** ([:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector])

...


abstract public  **has** ()

...


abstract public  **get** ([*unknown* $autoBegin])

...


abstract public  **rollbackPendent** ()

...


abstract public  **commit** ()

...


abstract public  **rollback** ([*unknown* $collect])

...


abstract public  **notifyRollback** (:doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>` $transaction)

...


abstract public  **notifyCommit** (:doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>` $transaction)

...


abstract public  **collectTransactions** ()

...


