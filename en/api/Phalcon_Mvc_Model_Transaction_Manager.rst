Class **Phalcon\\Mvc\\Model\\Transaction\\Manager**
===================================================

*implements* :doc:`Phalcon\\Mvc\\Model\\Transaction\\ManagerInterface <Phalcon_Mvc_Model_Transaction_ManagerInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

Methods
---------

public  **__construct** ([:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector])

Phalcon\\Mvc\\Model\\Transaction\\Manager constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injection container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the dependency injection container



public :doc:`Phalcon\\Mvc\\Model\\Transaction\\Manager <Phalcon_Mvc_Model_Transaction_Manager>`  **setDbService** (*string* $service)

Sets the database service used to run the isolated transactions



public *string*  **getDbService** ()

Returns the database service used to isolate the transaction



public :doc:`Phalcon\\Mvc\\Model\\Transaction\\Manager <Phalcon_Mvc_Model_Transaction_Manager>`  **setRollbackPendent** (*boolean* $rollbackPendent)

Set if the transaction manager must register a shutdown function to clean up pendent transactions



public *boolean*  **getRollbackPendent** ()

Check if the transaction manager is registering a shutdown function to clean up pendent transactions



public *boolean*  **has** ()

Checks whether the manager has an active transaction



public :doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>`  **get** ([*boolean* $autoBegin])

Returns a new Phalcon\\Mvc\\Model\\Transaction or an already created once This method registers a shutdown function to rollback active connections



public :doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>`  **getOrCreateTransaction** ([*boolean* $autoBegin])

Create/Returns a new transaction or an existing one



public  **rollbackPendent** ()

Rollbacks active transactions within the manager



public  **commit** ()

Commmits active transactions within the manager



public  **rollback** ([*boolean* $collect])

Rollbacks active transactions within the manager Collect will remove transaction from the manager



public  **notifyRollback** (:doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>` $transaction)

Notifies the manager about a rollbacked transaction



public  **notifyCommit** (:doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>` $transaction)

Notifies the manager about a commited transaction



protected  **_collectTransaction** ()

Removes transactions from the TransactionManager



public  **collectTransactions** ()

Remove all the transactions from the manager



