Class **Phalcon\\Mvc\\Model\\Transaction**
==========================================

<<<<<<< HEAD
Transactions are protective blocks where SQL statements are only permanent if they can all succeed as one atomic action. Phalcon\\Transaction is intended to be used with Phalcon_Model_Base. Phalcon Transactions should be created using Phalcon\\Transaction\\Manager. 
=======
*implements* :doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>`

Transactions are protective blocks where SQL statements are only permanent if they can all succeed as one atomic action. Phalcon\\Transaction is intended to be used with Phalcon_Model_Base. Phalcon Transactions should be created using Phalcon\\Transaction\\Manager.  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    try {
    
      $transaction = Phalcon\Mvc\Model\Transaction\Manager::get();
    
      $robot = new Robots();
      $robot->setTransaction($transaction);
      $robot->name = 'WALL·E';
      $robot->created_at = date('Y-m-d');
      if($robot->save()==false){
        $transaction->rollback("Can't save robot");
      }
    
      $robotPart = new RobotParts();
      $robotPart->setTransaction($transaction);
      $robotPart->type = 'head';
      if($robotPart->save()==false){
        $transaction->rollback("Can't save robot part");
      }
    
      $transaction->commit();
    
    }
    catch(Phalcon\Mvc\Model\Transaction\Failed $e){
      echo 'Failed, reason: ', $e->getMessage();
    }



Methods
---------

<<<<<<< HEAD
public  **__construct** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector, *boolean* $autoBegin)
=======
public  **__construct** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector, *boolean* $autoBegin)
>>>>>>> 0.7.0

Phalcon\\Mvc\\Model\\Transaction constructor



<<<<<<< HEAD
public  **setTransactionManager** (:doc:`Phalcon\\Mvc\\Model\\Transaction\\Manager <Phalcon_Mvc_Model_Transaction_Manager>` $manager)
=======
public  **setTransactionManager** (:doc:`Phalcon\\Mvc\\Model\\Transaction\\ManagerInterface <Phalcon_Mvc_Model_Transaction_ManagerInterface>` $manager)
>>>>>>> 0.7.0

Sets transaction manager related to the transaction



public *boolean*  **begin** ()

Starts the transaction



public *boolean*  **commit** ()

Commits the transaction



<<<<<<< HEAD
public *boolean*  **rollback** (*string* $rollbackMessage, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $rollbackRecord)
=======
public *boolean*  **rollback** (*string* $rollbackMessage, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $rollbackRecord)
>>>>>>> 0.7.0

Rollbacks the transaction



public *string*  **getConnection** ()

Returns connection related to transaction



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



<<<<<<< HEAD
public  **setRollbackedRecord** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $record)
=======
public  **setRollbackedRecord** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $record)
>>>>>>> 0.7.0

Sets object which generates rollback action



