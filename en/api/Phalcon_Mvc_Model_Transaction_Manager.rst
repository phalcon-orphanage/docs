Class **Phalcon\\Mvc\\Model\\Transaction\\Manager**
===================================================

A transaction acts on a single database connection. If you have multiple class-specific databases, the transaction will not protect interaction among them. This class manages the objects that compose a transaction. A trasaction produces a unique connection that is passed to every object part of the transaction. 

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

public **__construct** (*unknown* $dependencyInjector)

...


public **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)

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



public **notifyRollback** (:doc:`Phalcon\\Mvc\\Model\\Transaction <Phalcon_Mvc_Model_Transaction>` $transaction)

Notifies the manager about a rollbacked transaction



public **notifyCommit** (:doc:`Phalcon\\Mvc\\Model\\Transaction <Phalcon_Mvc_Model_Transaction>` $transaction)

Notifies the manager about a commited transaction



private **_collectTransaction** ()

...


public **collectTransactions** ()

Remove all the transactions from the manager



