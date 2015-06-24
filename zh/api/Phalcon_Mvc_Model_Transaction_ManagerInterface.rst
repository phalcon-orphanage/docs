Interface **Phalcon\\Mvc\\Model\\Transaction\\ManagerInterface**
================================================================

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


