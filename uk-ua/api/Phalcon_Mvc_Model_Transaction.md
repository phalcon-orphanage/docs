* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Model\Transaction'

* * *

# Class **Phalcon\Mvc\Model\Transaction**

*implements* [Phalcon\Mvc\Model\TransactionInterface](/4.0/en/api/Phalcon_Mvc_Model_TransactionInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/model/transaction.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Transactions are protective blocks where SQL statements are only permanent if they can all succeed as one atomic action. Phalcon\Transaction is intended to be used with Phalcon_Model_Base. Phalcon Transactions should be created using Phalcon\Transaction\Manager.

```php
<?php

try {
    $manager = new \Phalcon\Mvc\Model\Transaction\Manager();

    $transaction = $manager->get();

    $robot = new Robots();

    $robot->setTransaction($transaction);

    $robot->name       = "WALL·E";
    $robot->created_at = date("Y-m-d");

    if ($robot->save() === false) {
        $transaction->rollback("Can't save robot");
    }

    $robotPart = new RobotParts();

    $robotPart->setTransaction($transaction);

    $robotPart->type = "head";

    if ($robotPart->save() === false) {
        $transaction->rollback("Can't save robot part");
    }

    $transaction->commit();
} catch(Phalcon\Mvc\Model\Transaction\Failed $e) {
    echo "Failed, reason: ", $e->getMessage();
}

```

## Methods

public **__construct** ([Phalcon\DiInterface](/4.0/en/api/Phalcon_DiInterface) $dependencyInjector, [*boolean* $autoBegin], [*string* $service])

Phalcon\Mvc\Model\Transaction constructor

public **setTransactionManager** ([Phalcon\Mvc\Model\Transaction\ManagerInterface](/4.0/en/api/Phalcon_Mvc_Model_Transaction_ManagerInterface) $manager)

Sets transaction manager related to the transaction

public **begin** ()

Starts the transaction

public **commit** ()

Commits the transaction

public *boolean* **rollback** ([*string* $rollbackMessage], [[Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $rollbackRecord])

Rollbacks the transaction

public **getConnection** ()

Returns the connection related to transaction

public **setIsNewTransaction** (*mixed* $isNew)

Sets if is a reused transaction or new once

public **setRollbackOnAbort** (*mixed* $rollbackOnAbort)

Sets flag to rollback on abort the HTTP connection

public **isManaged** ()

Checks whether transaction is managed by a transaction manager

public **getMessages** ()

Returns validations messages from last save try

public **isValid** ()

Checks whether internal connection is under an active transaction

public **setRollbackedRecord** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $record)

Sets object which generates rollback action