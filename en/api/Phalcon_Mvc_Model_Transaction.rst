Class **Phalcon\\Mvc\\Model\\Transaction**
==========================================

*implements* :doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>`

Methods
---------

public  **__construct** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector, [*boolean* $autoBegin], [*string* $service])

Phalcon\\Mvc\\Model\\Transaction constructor



public  **setTransactionManager** (:doc:`Phalcon\\Mvc\\Model\\Transaction\\ManagerInterface <Phalcon_Mvc_Model_Transaction_ManagerInterface>` $manager)

Sets transaction manager related to the transaction



public *boolean*  **begin** ()

Starts the transaction



public *boolean*  **commit** ()

Commits the transaction



public *boolean*  **rollback** ([*string* $rollbackMessage], [:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $rollbackRecord])

Rollbacks the transaction



public :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>`  **getConnection** ()

Returns the connection related to transaction



public  **setIsNewTransaction** (*boolean* $isNew)

Sets if is a reused transaction or new once



public  **setRollbackOnAbort** (*boolean* $rollbackOnAbort)

Sets flag to rollback on abort the HTTP connection



public *boolean*  **isManaged** ()

Checks whether transaction is managed by a transaction manager



public *array*  **getMessages** ()

Returns validations messages from last save try



public *boolean*  **isValid** ()

Checks whether internal connection is under an active transaction



public  **setRollbackedRecord** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $record)

Sets object which generates rollback action



