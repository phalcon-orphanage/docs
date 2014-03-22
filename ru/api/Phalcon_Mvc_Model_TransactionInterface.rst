Interface **Phalcon\\Mvc\\Model\\TransactionInterface**
=======================================================

Phalcon\\Mvc\\Model\\TransactionInterface initializer


Methods
-------
<<<<<<< HEAD
=======

abstract public  **__construct** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector, [*boolean* $autoBegin], [*string* $service])

Phalcon\\Mvc\\Model\\Transaction constructor


>>>>>>> master

abstract public  **setTransactionManager** (:doc:`Phalcon\\Mvc\\Model\\Transaction\\ManagerInterface <Phalcon_Mvc_Model_Transaction_ManagerInterface>` $manager)

Sets transaction manager related to the transaction



abstract public *boolean*  **begin** ()

Starts the transaction



abstract public *boolean*  **commit** ()

Commits the transaction



abstract public *boolean*  **rollback** ([*string* $rollbackMessage], [:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $rollbackRecord])

Rollbacks the transaction



abstract public *string*  **getConnection** ()

Returns connection related to transaction



abstract public  **setIsNewTransaction** (*boolean* $isNew)

Sets if is a reused transaction or new once



abstract public  **setRollbackOnAbort** (*boolean* $rollbackOnAbort)

Sets flag to rollback on abort the HTTP connection



abstract public *boolean*  **isManaged** ()

Checks whether transaction is managed by a transaction manager



abstract public *array*  **getMessages** ()

Returns validations messages from last save try



abstract public *boolean*  **isValid** ()

Checks whether internal connection is under an active transaction



abstract public  **setRollbackedRecord** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $record)

Sets object which generates rollback action



