Class **Phalcon\\Mvc\\Model\\Transaction**
==========================================

Transactions are protective blocks where SQL statements are only permanent if they can all succeed as one atomic action. Phalcon\\Transaction is intended to be used with Phalcon_Model_Base. Phalcon Transactions should be created using Phalcon\\Transaction\\Manager. 

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

public **__construct** (*Phalcon\DI* $dependencyInjector, *boolean* $autoBegin)

Phalcon\\Mvc\\Model\\Transaction constructor



public **setTransactionManager** (*Phalcon\Mvc\Model\Transaction\Manager* $manager)

Sets transaction manager related to the transaction



*boolean* public **begin** ()

Starts the transaction



*boolean* public **commit** ()

Commits the transaction



*boolean* public **rollback** (*string* $rollbackMessage, *Phalcon\Mvc\Model* $rollbackRecord)

Rollbacks the transaction



*string* public **getConnection** ()

Returns connection related to transaction



public **setIsNewTransaction** (*boolean* $isNew)

Sets if is a reused transaction or new once



public **setRollbackOnAbort** (*boolean* $rollbackOnAbort)

Sets flag to rollback on abort the HTTP connection



*boolean* public **isManaged** ()

Checks whether transaction is managed by a transaction manager



*array* public **getMessages** ()

Returns validations messages from last save try



*boolean* public **isValid** ()

Checks whether internal connection is under an active transaction



public **setRollbackedRecord** (*Phalcon\Mvc\Model* $record)

Sets object which generates rollback action



