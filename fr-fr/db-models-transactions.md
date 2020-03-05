---
layout: default
language: 'fr-fr'
version: '4.0'
title: 'Model Transactions'
keywords: 'models, transactions'
---

# Model Transactions

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Vue d'ensemble

When a process performs multiple database operations, it is important to perform all these operations as a single unit of work. This way if one of the operations fails, we do not end up with corrupted data or orphaned records. Database transactions offer this functionality and ensure that all database operations have been executed successfully prior to storing the data in the database.

Transactions in Phalcon allow you to commit all operations if they were executed successfully or rollback all operations if something went wrong.

## Manual

If an application only uses one connection and the transactions are not very complex, a transaction can be created by beginning a transaction on the connection and if everything is OK commit the transaction or roll it back:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Db\Adapter\Pdo\Mysql;
/**
 * @property Mysql $db
 */
class InvoicesController extends Controller
{
    public function saveAction()
    {
        $this->db->begin();

        try {
            $customer = Customers::findFirst(
                [
                    'conditions' => 'cst_id = :cst_id:',
                    'bind'       => [
                        'cst_id' => 10,
                    ]    
                ]  
            );

            $customer->cst_has_unpaid = true;
            $result = $customer->save();

            if (false === $result) {
                throw new \Exception('Error saving file');
            }

            $invoice = new Invoices();
            $invoice->inv_cst_id     = $customer->cst_id;
            $invoice->inv_number     = 'INV-00001';
            $invoice->inv_name       = 'Invoice for Goods';
            $invoice->inv_created_at = date('Y-m-d');

            $result = $invoice->save();

            if (false === $result) {
                throw new \Exception('Error saving file');
            }

            $this->db->commit();
        } catch (\Exception $ex) {
            $this->db->rollback();
            echo $ex->getMessage();
        }
    }
}
```

## Implicit

Existing relationships can be used to store records and their related instances. An operation like this implicitly creates a transaction to ensure that data is correctly stored:

```php
<?php

use MyApp\Models\Invoices;
use MyApp\Models\Customers;

$invoice = new Invoices();
$invoice->inv_cst_id     = $customer->cst_id;
$invoice->inv_number     = 'INV-00001';
$invoice->inv_name       = 'Invoice for Goods';
$invoice->inv_created_at = date('Y-m-d');

$customer = new Customers();
$customer->cst_name       = 'John Wick';
$customer->cst_has_unpaid = true;
$customer->invoices       = $invoice;

$customer->save();
```

## Isolated

Isolated transactions are executed in a new connection ensuring that all the generated SQL, virtual foreign key checks and business rules are isolated from the main connection. This kind of transaction requires a transaction manager that globally manages each transaction created ensuring that they are correctly rolled back or committed before ending the request:

```php
<?php

use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

// Create a transaction manager
$manager = new TxManager();

// Request a transaction
$transaction = $manager->get();

try {
    $customer = Customers::findFirst(
        [
            'conditions' => 'cst_id = :cst_id:',
            'bind'       => [
                'cst_id' => 10,
            ]    
        ]  
    );

    $customer->cst_has_unpaid = true;
    $result = $customer->save();

    if (false === $result) {
        throw new \Exception('Error saving file');
    }

    $invoice = new Invoices();
    $invoice->inv_cst_id     = $customer->cst_id;
    $invoice->inv_number     = 'INV-00001';
    $invoice->inv_name       = 'Invoice for Goods';
    $invoice->inv_created_at = date('Y-m-d');

    $result = $invoice->save();

    if (false === $result) {
        throw new \Exception('Error saving file');
    }

    $transaction->commit();
} catch (TxFailed $ex) {
    $transaction->rollback();
    echo $ex->getMessage();
}
```

Transactions can be used to delete a number of records, ensuring that everything is deleted correctly:

```php
<?php

use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

// Create a transaction manager
$manager = new TxManager();

// Request a transaction
$transaction = $manager->get();

try {
    $invoices = Invoices::find(
        [
            'conditions' => 'inv_cst_id = :cst_id:',
            'bind'       => [
                'cst_id' => 10,
            ]    
        ]  
    );

    foreach ($invoices as $invoice) {
        $invoice->setTransaction($transaction);
        if (false === $invoice->delete()) {
            $messages = $invoice->getMessages();

            foreach ($messages as $message) {
                $transaction->rollback(
                    $message->getMessage()
                );
            }
        }
    }

    $transaction->commit();
} catch (TxFailed $ex) {
    echo $ex->getMessage();
}
```

## Exceptions

Any exceptions thrown in the Logger component will be of type [Phalcon\Mvc\Model\Transaction\Exception](api/phalcon_mvc#mvc-model-transaction-exception) or [Phalcon\Mvc\Model\Transaction\Failed](api/phalcon_mvc#mvc-model-transaction-failed). You can use these exceptions to selectively catch exceptions thrown only from this component.

Additionally you can throw an exception if the rollback was not successful, by using the `throwRollbackException(true)` method.

```php
<?php

use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

// Create a transaction manager
$manager = new TxManager();

// Request a transaction
$transaction = $manager
    ->get()
    ->throwRollbackException(true)
;

try {
    $invoices = Invoices::find(
        [
            'conditions' => 'inv_cst_id = :cst_id:',
            'bind'       => [
                'cst_id' => 10,
            ]    
        ]  
    );

    foreach ($invoices as $invoice) {
        $invoice->setTransaction($transaction);
        if (false === $invoice->delete()) {
            $messages = $invoice->getMessages();

            foreach ($messages as $message) {
                $transaction->rollback(
                    $message->getMessage()
                );
            }
        }
    }

    $transaction->commit();
} catch (TxFailed $ex) {
    echo $ex->getMessage();
}
```

## Dependency Injection

Transactions are reused no matter where the transaction object is retrieved. A new transaction is generated only when a `commit()` or `rollback()` is performed. You can use the service container to create the global transaction manager for the entire application:

```php
<?php

use Phalcon\Mvc\Model\Transaction\Manager;

$container->setShared(
    'transactions',
    function () {
        return new Manager();
    }
);
```

Then access it from a controller or view:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Transaction\Manager;

/**
 * @property Manager $transactions
 */
class ProductsController extends Controller
{
    public function saveAction()
    {
        $manager = $this->di->getTransactions();

        $manager = $this->transactions;

        $transaction = $manager->get();

        // ...
    }
}
```

> **NOTE**: While a transaction is active, the transaction manager will always return the same transaction across the application.
{: .alert .alert-info }


