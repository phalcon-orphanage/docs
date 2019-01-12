* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Model\Transaction\Manager'

* * *

# Class **Phalcon\Mvc\Model\Transaction\Manager**

*implements* [Phalcon\Mvc\Model\Transaction\ManagerInterface](/4.0/en/api/Phalcon_Mvc_Model_Transaction_ManagerInterface), [Phalcon\Di\InjectionAwareInterface](/4.0/en/api/Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/model/transaction/manager.zep" class="btn btn-default btn-sm">Source on GitHub</a>

A transaction acts on a single database connection. If you have multiple class-specific databases, the transaction will not protect interaction among them.

This class manages the objects that compose a transaction. A transaction produces a unique connection that is passed to every object part of the transaction.

```php
<?php

try {
   use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;

   $transactionManager = new TransactionManager();

   $transaction = $transactionManager->get();

   $robot = new Robots();

   $robot->setTransaction($transaction);

   $robot->name       = "WALL·E";
   $robot->created_at = date("Y-m-d");

   if ($robot->save() === false){
       $transaction->rollback("Can't save robot");
   }

   $robotPart = new RobotParts();

   $robotPart->setTransaction($transaction);

   $robotPart->type = "head";

   if ($robotPart->save() === false) {
       $transaction->rollback("Can't save robot part");
   }

   $transaction->commit();
} catch (Phalcon\Mvc\Model\Transaction\Failed $e) {
   echo "Failed, reason: ", $e->getMessage();
}

```

## Methods

public **__construct** ([[Phalcon\DiInterface](/4.0/en/api/Phalcon_DiInterface) $dependencyInjector])

Phalcon\Mvc\Model\Transaction\Manager constructor

public **setDI** ([Phalcon\DiInterface](/4.0/en/api/Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injection container

public **getDI** ()

Returns the dependency injection container

public **setDbService** (*mixed* $service)

Sets the database service used to run the isolated transactions

public *string* **getDbService** ()

Returns the database service used to isolate the transaction

public **setRollbackPendent** (*mixed* $rollbackPendent)

Set if the transaction manager must register a shutdown function to clean up pendent transactions

public **getRollbackPendent** ()

Check if the transaction manager is registering a shutdown function to clean up pendent transactions

public **has** ()

Checks whether the manager has an active transaction

public **get** ([*mixed* $autoBegin])

Returns a new \Phalcon\Mvc\Model\Transaction or an already created once This method registers a shutdown function to rollback active connections

public **getOrCreateTransaction** ([*mixed* $autoBegin])

Create/Returns a new transaction or an existing one

public **rollbackPendent** ()

Rollbacks active transactions within the manager

public **commit** ()

Commits active transactions within the manager

public **rollback** ([*boolean* $collect])

Rollbacks active transactions within the manager Collect will remove the transaction from the manager

public **notifyRollback** ([Phalcon\Mvc\Model\TransactionInterface](/4.0/en/api/Phalcon_Mvc_Model_TransactionInterface) $transaction)

Notifies the manager about a rollbacked transaction

public **notifyCommit** ([Phalcon\Mvc\Model\TransactionInterface](/4.0/en/api/Phalcon_Mvc_Model_TransactionInterface) $transaction)

Notifies the manager about a committed transaction

protected **_collectTransaction** ([Phalcon\Mvc\Model\TransactionInterface](/4.0/en/api/Phalcon_Mvc_Model_TransactionInterface) $transaction)

Removes transactions from the TransactionManager

public **collectTransactions** ()

Remove all the transactions from the manager