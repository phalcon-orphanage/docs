Class **Phalcon\\Mvc\\Model\\Transaction\\Manager**
===================================================

Methods
---------

public **__construct** (*unknown* $dependencyInjector)

public **setDI** (*Phalcon\DI* $dependencyInjector)

Sets the dependency injection container



:doc:`Phalcon\\DI <Phalcon_DI>` public **getDI** ()

Returns the dependency injection container



*boolean* public **has** ()

Checks whether manager has an active transaction



:doc:`Phalcon\\Mvc\\Model\\Transaction <Phalcon_Mvc_Model_Transaction>` public **get** (*boolean* $autoBegin)

Returns a new Phalcon\\Mvc\\Model\\Transaction or an already created once



public **rollbackPendent** ()

Rollbacks active transactions within the manager



public **commit** ()

Commmits active transactions within the manager



public **rollback** (*boolean* $collect)

Rollbacks active transactions within the manager Collect will remove transaction from the manager



public **notifyRollback** (*Phalcon\Mvc\Model\Transaction* $transaction)

Notifies the manager about a rollbacked transaction



public **notifyCommit** (*Phalcon\Mvc\Model\Transaction* $transaction)

Notifies the manager about a commited transaction



private **_collectTransaction** ()

public **collectTransactions** ()

Remove all the transactions from the manager



