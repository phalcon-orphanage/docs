Class **Phalcon\\Mvc\\Model\\Transaction\\Manager**
===================================================

*implements* :doc:`Phalcon\\Mvc\\Model\\Transaction\\ManagerInterface <Phalcon_Mvc_Model_Transaction_ManagerInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

A transaction acts on a single database connection. If you have multiple class-specific databases, the transaction will not protect interaction among them.  This class manages the objects that compose a transaction. A trasaction produces a unique connection that is passed to every object part of the transaction.  

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
    
    } catch (Phalcon\Mvc\Model\Transaction\Failed $e) {
      echo 'Failed, reason: ', $e->getMessage();
    }



Methods
-------

public  **__construct** ([*unknown* $dependencyInjector])

Phalcon\\Mvc\\Model\\Transaction\\Manager constructor



public  **setDI** (*unknown* $dependencyInjector)

Sets the dependency injection container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the dependency injection container



public :doc:`Phalcon\\Mvc\\Model\\Transaction\\Manager <Phalcon_Mvc_Model_Transaction_Manager>`  **setDbService** (*unknown* $service)

Sets the database service used to run the isolated transactions



public *string*  **getDbService** ()

Returns the database service used to isolate the transaction



public :doc:`Phalcon\\Mvc\\Model\\Transaction\\Manager <Phalcon_Mvc_Model_Transaction_Manager>`  **setRollbackPendent** (*unknown* $rollbackPendent)

Set if the transaction manager must register a shutdown function to clean up pendent transactions



public *boolean*  **getRollbackPendent** ()

Check if the transaction manager is registering a shutdown function to clean up pendent transactions



public *boolean*  **has** ()

Checks whether the manager has an active transaction



public :doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>`  **get** ([*unknown* $autoBegin])

Returns a new \\Phalcon\\Mvc\\Model\\Transaction or an already created once This method registers a shutdown function to rollback active connections



public :doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>`  **getOrCreateTransaction** ([*unknown* $autoBegin])

Create/Returns a new transaction or an existing one



public  **rollbackPendent** ()

Rollbacks active transactions within the manager



public  **commit** ()

Commmits active transactions within the manager



public  **rollback** ([*unknown* $collect])

Rollbacks active transactions within the manager Collect will remove the transaction from the manager



public  **notifyRollback** (*unknown* $transaction)

Notifies the manager about a rollbacked transaction



public  **notifyCommit** (*unknown* $transaction)

Notifies the manager about a commited transaction



protected  **_collectTransaction** (*unknown* $transaction)

Removes transactions from the TransactionManager



public  **collectTransactions** ()

Remove all the transactions from the manager



