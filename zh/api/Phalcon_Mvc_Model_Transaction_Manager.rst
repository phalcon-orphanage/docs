Class **Phalcon\\Mvc\\Model\\Transaction\\Manager**
===================================================

<<<<<<< HEAD
A transaction acts on a single database connection. If you have multiple class-specific databases, the transaction will not protect interaction among them. This class manages the objects that compose a transaction. A trasaction produces a unique connection that is passed to every object part of the transaction. 
=======
*implements* :doc:`Phalcon\\Mvc\\Model\\Transaction\\ManagerInterface <Phalcon_Mvc_Model_Transaction_ManagerInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

A transaction acts on a single database connection. If you have multiple class-specific databases, the transaction will not protect interaction among them.  This class manages the objects that compose a transaction. A trasaction produces a unique connection that is passed to every object part of the transaction.  
>>>>>>> 0.7.0

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

<<<<<<< HEAD
public  **__construct** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)
=======
public  **__construct** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)
>>>>>>> 0.7.0





<<<<<<< HEAD
public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)
=======
public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)
>>>>>>> 0.7.0

Sets the dependency injection container



<<<<<<< HEAD
public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** ()
=======
public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()
>>>>>>> 0.7.0

Returns the dependency injection container



public *boolean*  **has** ()

Checks whether manager has an active transaction



<<<<<<< HEAD
public :doc:`Phalcon\\Mvc\\Model\\Transaction <Phalcon_Mvc_Model_Transaction>`  **get** (*boolean* $autoBegin)
=======
public :doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>`  **get** (*boolean* $autoBegin)
>>>>>>> 0.7.0

Returns a new Phalcon\\Mvc\\Model\\Transaction or an already created once



public  **rollbackPendent** ()

Rollbacks active transactions within the manager



public  **commit** ()

Commmits active transactions within the manager



public  **rollback** (*boolean* $collect)

Rollbacks active transactions within the manager Collect will remove transaction from the manager



<<<<<<< HEAD
public  **notifyRollback** (:doc:`Phalcon\\Mvc\\Model\\Transaction <Phalcon_Mvc_Model_Transaction>` $transaction)
=======
public  **notifyRollback** (:doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>` $transaction)
>>>>>>> 0.7.0

Notifies the manager about a rollbacked transaction



<<<<<<< HEAD
public  **notifyCommit** (:doc:`Phalcon\\Mvc\\Model\\Transaction <Phalcon_Mvc_Model_Transaction>` $transaction)
=======
public  **notifyCommit** (:doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>` $transaction)
>>>>>>> 0.7.0

Notifies the manager about a commited transaction



<<<<<<< HEAD
private  **_collectTransaction** ()

...
=======
protected  **_collectTransaction** ()

Removes transactions from the TransactionManager

>>>>>>> 0.7.0


public  **collectTransactions** ()

Remove all the transactions from the manager



