Interface **Phalcon\\Mvc\\Model\\Transaction\\ManagerInterface**
================================================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/transaction/managerinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **__construct** ([*unknown* $dependencyInjector])

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


abstract public  **notifyRollback** (*unknown* $transaction)

...


abstract public  **notifyCommit** (*unknown* $transaction)

...


abstract public  **collectTransactions** ()

...


