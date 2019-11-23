---
layout: default
language: 'fr-fr'
version: '4.0'
---

# Model Transactions

* * *

![](/assets/images/document-status-under-review-red.svg)

## Overview

When a process performs multiple database operations, it might be important that each step is completed successfully so that data integrity can be maintained. Transactions offer the ability to ensure that all database operations have been executed successfully before the data is committed to the database.

Transactions in Phalcon allow you to commit all operations if they were executed successfully or rollback all operations if something went wrong.

## Manual Transactions

If an application only uses one connection and the transactions are not very complex, a transaction can be created by just moving the current connection into transaction mode and then commit or rollback the operation whether it is successful or not:

```php
<?php

use Phalcon\Mvc\Controller;

class RobotsController extends Controller
{
    public function saveAction()
    {
        // Start a transaction
        $this->db->begin();

        $robot = new Robots();

        $robot->name       = 'WALL-E';
        $robot->created_at = date('Y-m-d');

        // The model failed to save, so rollback the transaction
        if ($robot->save() === false) {
            $this->db->rollback();

            return;
        }

        $robotPart = new RobotParts();

        $robotPart->robots_id = $robot->id;
        $robotPart->type      = 'head';

        // The model failed to save, so rollback the transaction
        if ($robotPart->save() === false) {
            $this->db->rollback();

            return;
        }

        // Commit the transaction
        $this->db->commit();
    }
}
```

## Implicit Transactions

Existing relationships can be used to store records and their related instances, this kind of operation implicitly creates a transaction to ensure that data is correctly stored:

```php
<?php

$robotPart = new RobotParts();

$robotPart->type = 'head';



$robot = new Robots();

$robot->name       = 'WALL-E';
$robot->created_at = date('Y-m-d');
$robot->robotPart  = $robotPart;

// Creates an implicit transaction to store both records
$robot->save();
```

## Isolated Transactions

Isolated transactions are executed in a new connection ensuring that all the generated SQL, virtual foreign key checks and business rules are isolated from the main connection. This kind of transaction requires a transaction manager that globally manages each transaction created ensuring that they are correctly rolled back/committed before ending the request:

```php
<?php

use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

try {
    // Create a transaction manager
    $manager = new TxManager();

    // Request a transaction
    $transaction = $manager->get();

    $robot = new Robots();

    $robot->setTransaction($transaction);

    $robot->name       = 'WALL·E';
    $robot->created_at = date('Y-m-d');

    if ($robot->save() === false) {
        $transaction->rollback(
            'Cannot save robot'
        );
    }

    $robotPart = new RobotParts();

    $robotPart->setTransaction($transaction);

    $robotPart->robots_id = $robot->id;
    $robotPart->type      = 'head';

    if ($robotPart->save() === false) {
        $transaction->rollback(
            'Cannot save robot part'
        );
    }

    // Everything's gone fine, let's commit the transaction
    $transaction->commit();
} catch (TxFailed $e) {
    echo 'Failed, reason: ', $e->getMessage();
}
```

Transactions can be used to delete many records in a consistent way:

```php
<?php

use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

try {
    // Create a transaction manager
    $manager = new TxManager();

    // Request a transaction
    $transaction = $manager->get();

    // Get the robots to be deleted
    $robots = Robots::find(
        "type = 'mechanical'"
    );

    foreach ($robots as $robot) {
        $robot->setTransaction($transaction);

        // Something's gone wrong, we should rollback the transaction
        if ($robot->delete() === false) {
            $messages = $robot->getMessages();

            foreach ($messages as $message) {
                $transaction->rollback(
                    $message->getMessage()
                );
            }
        }
    }

    // Everything's gone fine, let's commit the transaction
    $transaction->commit();

    echo 'Robots were deleted successfully!';
} catch (TxFailed $e) {
    echo 'Failed, reason: ', $e->getMessage();
}
```

Transactions are reused no matter where the transaction object is retrieved. A new transaction is generated only when a `commit()` or :code:`rollback()` is performed. You can use the service container to create the global transaction manager for the entire application:

```php
<?php

use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;

$di->setShared(
    'transactions',
    function () {
        return new TransactionManager();
    }
);
```

Then access it from a controller or view:

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function saveAction()
    {
        // Obtain the TransactionsManager from the services container
        $manager = $this->di->getTransactions();

        // Or
        $manager = $this->transactions;

        // Request a transaction
        $transaction = $manager->get();

        // ...
    }
}
```

While a transaction is active, the transaction manager will always return the same transaction across the application.