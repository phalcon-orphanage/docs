<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Modelové transakce</a> <ul>
        <li>
          <a href="#manual">Manualní transakce</a>
        </li>
        <li>
          <a href="#implicit">Implicitní transakce</a>
        </li>
        <li>
          <a href="#isolated">Izolované transakce</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Modelové transakce

Pokud proces provádí více databázových operací, je důležité, aby každý krok byl úspěšně dokončen, a byla tak zachována integrita dat. Transakce nabízejí možnost zjistit, zda všechny databázové operace budou provedeny úspěšně předtím, než budou data uložena do databáze.

Transakce ve Phalconu vám umožní potvrdit všechny operace, pokud byly provedeny úspěšně, nebo vrácení všech změn zpět, pokud se něco pokazilo.

<a name='manual'></a>

## Manualní transakce

Pokud aplikace používá pouze jedno připojení a transakce nejsou příliš složité, může být transakce vytvořena pouze přesunutím aktuálního připojení do režimu transakce a následným provedením nebo zrušením operace podle úspěšnosti:

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

<a name='implicit'></a>

## Implicitní transakce

Pro uložení existující relace lze použít jejich instance, tento druh operace implicitně vytváří transakci, která zajistí správné uložení dat:

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

<a name='isolated'></a>

## Izolované transakce

Izolované transakce se provádějí v novém spojení, které zajišťuje, že všechny generované SQL, kontroly cizích klíčů a business rules (aplikační logika) jsou izolovány od hlavního připojení. Tento druh transakce vyžaduje správce transakcí, který globálně spravuje všechny vytvořené transakce a zajišťuje, že byly před ukončením požadavku správně vráceny zpět nebo uloženy:

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

Transakce lze použít k odstranění více záznamů konzistentním způsobem:

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

Transakce jsou znovu použity bez ohledu na to, kde je objekt transakce načten. Nová transakce se vygeneruje pouze v případě, že se provede příkaz `commit()` nebo :code:`rollback()`. Můžete také použít kontejner pro služby (Di) pro vytvoření globalního správce transakcí pro celou aplikaci:

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

Pak k němu máme přístup v Controlleru nebo v šabloně:

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

Dokud je transakce aktivní, správce transakcí vždy vrací tu stejnou transakci skrz celou aplikaci.