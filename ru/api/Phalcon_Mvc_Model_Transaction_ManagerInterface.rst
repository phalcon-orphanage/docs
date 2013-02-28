Interface **Phalcon\\Mvc\\Model\\Transaction\\ManagerInterface**
================================================================

Phalcon\\Mvc\\Model\\Transaction\\ManagerInterface initializer


Methods
---------

abstract public  **__construct** ([*Phalcon\\DiInterface* $dependencyInjector])

Phalcon\\Mvc\\Model\\Transaction\\Manager



abstract public *boolean*  **has** ()

Checks whether manager has an active transaction



abstract public :doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>`  **get** ([*boolean* $autoBegin])

Returns a new Phalcon\\Mvc\\Model\\Transaction or an already created once



abstract public  **rollbackPendent** ()

Rollbacks active transactions within the manager



abstract public  **commit** ()

Commmits active transactions within the manager



abstract public  **rollback** ([*boolean* $collect])

Rollbacks active transactions within the manager Collect will remove transaction from the manager



abstract public  **notifyRollback** (*Phalcon\\Mvc\\Model\\TransactionInterface* $transaction)

Notifies the manager about a rollbacked transaction



abstract public  **notifyCommit** (*Phalcon\\Mvc\\Model\\TransactionInterface* $transaction)

Notifies the manager about a commited transaction



abstract public  **collectTransactions** ()

Remove all the transactions from the manager



