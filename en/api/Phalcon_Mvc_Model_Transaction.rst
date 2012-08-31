Class **Phalcon\\Mvc\\Model\\Transaction**
==========================================

Phalcon\\Mvc\\Model\\Transaction   Transactions are protective blocks where SQL statements are only permanent if they can  all succeed as one atomic action. Phalcon\\Transaction is intended to be used with Phalcon_Model_Base.  Phalcon Transactions should be created using Phalcon\\Transaction\\Manager.  

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

**__construct** (*Phalcon\DI* **$dependencyInjector**, *boolean* **$autoBegin**)

**setTransactionManager** (*Phalcon\Mvc\Model\Transaction\Manager* **$manager**)

*boolean* **begin** ()

*boolean* **commit** ()

*boolean* **rollback** (*string* **$rollbackMessage**, *Phalcon\Mvc\Model* **$rollbackRecord**)

*string* **getConnection** ()

**setIsNewTransaction** (*boolean* **$isNew**)

**setRollbackOnAbort** (*boolean* **$rollbackOnAbort**)

*boolean* **isManaged** ()

*array* **getMessages** ()

*boolean* **isValid** ()

**setRollbackedRecord** (*Phalcon\Mvc\Model* **$record**)

