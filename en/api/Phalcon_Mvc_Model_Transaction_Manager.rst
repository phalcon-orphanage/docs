Class **Phalcon\\Mvc\\Model\\Transaction\\Manager**
===================================================

Phalcon\\Mvc\\Model\\Transaction\\Manager   A transaction acts on a single database connection. If you have multiple class-specific  databases, the transaction will not protect interaction among them  

.. code-block:: php

    <?php

    
    try {
    
      use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;
    
      $transactionManager = new TransactionManager();
    
      $transaction = $transactionManager->get();
    
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

**__construct** (*unknown* **$dependencyInjector**)

**setDI** (*Phalcon\DI* **$dependencyInjector**)

:doc:`Phalcon\\DI <Phalcon_DI>` **getDI** ()

*boolean* **has** ()

:doc:`Phalcon\\Mvc\\Model\\Transaction <Phalcon_Mvc_Model_Transaction>` **get** (*boolean* **$autoBegin**)

**rollbackPendent** ()

**commit** ()

**rollback** (*boolean* **$collect**)

**notifyRollback** (*Phalcon\Mvc\Model\Transaction* **$transaction**)

**notifyCommit** (*Phalcon\Mvc\Model\Transaction* **$transaction**)

**_collectTransaction** ()

**collectTransactions** ()

