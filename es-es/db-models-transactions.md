---
layout: default
language: 'es-es'
version: '4.0'
title: 'Transacciones en modelos'
keywords: 'modelos, transacciones'
---

# Transacciones en modelos

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

Cuando un proceso ejecuta múltiples operaciones de bases de datos, es importante realizar todas esas operaciones como una sola unidad de trabajo. De esta forma, si una de las operaciones falla, no terminaremos con datos corruptos o registros huérfanos. Las transacciones de base de datos ofrecen esta funcionalidad, y aseguran que todas las operaciones de base de datos han sido ejecutadas correctamente antes de almacenar los datos en la base de datos.

Las transacciones en Phalcon le permite confirmar todas las operaciones si se ejecutaron correctamente o deshacer todas las operaciones si algo ha ido mal.

## Manual

Si una aplicación sólo usa una conexión y las transacciones no son muy complejas, una transacción se puede crear iniciando una transacción en la conexión y si todo está bien confirmar la transacción o deshacerla:

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

## Implícito

Se pueden usar las relaciones existentes para almacenar registros en sus instancias relacionadas. Una operación como esta implícitamente crea una transacción para asegurar que los datos son correctamente almacenados:

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

## Aislado

Las transacciones aisladas se ejecutan en una nueva conexión asegurando que todo el SQL generado, las comprobaciones de claves ajenas virtuales y reglas de negocio están aisladas de la conexión principal. Este tipo de transacción requiere un gestor de transacciones que globalmente gestione cada transacción creada, asegurándose de que son correctamente deshechas o confirmadas antes de terminar la petición:

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

Las transacciones se pueden usar para eliminar un número de registros, asegurándose que todo se borre correctamente:

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

## Excepciones

Cualquier excepción lanzada en el componente *Transaction* será del tipo [Phalcon\Mvc\Model\Transaction\Exception](api/phalcon_mvc#mvc-model-transaction-exception) o [Phalcon\Mvc\Model\Transaction\Failed](api/phalcon_mvc#mvc-model-transaction-failed). Puede usar estas excepciones para capturar selectivamente sólo las excepciones lanzadas desde este componente.

Además, puede lanzar una excepción si la operación deshacer no se ejecuta correctamente, usando el método `throwRollbackException(true)`.

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

## Inyección de Dependencias

Las transacciones se reutilizan sin importar de donde se recupera el objeto transacción. Se genera una nueva transacción sólo cuando se realiza un `commit()` o `rollback()`. Puede usar el contenedor de servicio para crear un gestor de transacciones global para toda la aplicación:

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

Entonces accede a él desde un controlador o vista:

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

> **NOTA**: Mientras que una transacción esté activa, el gestor de transacciones siempre devolverá la misma transacción en toda la aplicación.
{: .alert .alert-info }
