* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Transacciones en modelos

Cuando un proceso realiza múltiples operaciones de base de datos, sería importante que cada paso se haya completado con éxito para que pueda mantenerse la integridad de los datos. Las transacciones ofrecen la capacidad para garantizar que todas las operaciones de base de datos han sido ejecutadas con éxito antes de que los datos se asienten en la base de datos.

Las transacciones en Phalcon permiten comprometer a todas las operaciones si se ejecutaron con éxito o deshacer todas las operaciones si algo salió mal.

<a name='manual'></a>

## Transacciones manuales

Si una aplicación utiliza sólo una conexión y las transacciones no son muy complejas, se puede crear una transacción moviendo sólo la conexión actual a modo de transacción y luego confirmar o deshacer la operación sea exitosa o no:

```php
<?php

use Phalcon\Mvc\Controller;

class RobotsController extends Controller
{
    public function saveAction()
    {
        // Iniciar una transacción
        $this->db->begin();

        $robot = new Robots();

        $robot->name       = 'WALL-E';
        $robot->created_at = date('Y-m-d');

        // Si el modelo falla al guardarse, entonces deshacemos la transacción
        if ($robot->save() === false) {
            $this->db->rollback();
            return;
        }

        $robotPart = new RobotParts();

        $robotPart->robots_id = $robot->id;
        $robotPart->type      = 'cabeza';

        // Si el modelo falla al guardar, deshacemos la transacción
        if ($robotPart->save() === false) {
            $this->db->rollback();

            return;
        }

        // Confirmamos la transacción
        $this->db->commit();
    }
}
```

<a name='implicit'></a>

## Transacciones implícitas

Las relaciones existentes se pueden utilizar para almacenar registros y sus instancias relacionadas, este tipo de operación implícitamente crea una transacción para asegurar que los datos se almacenan correctamente:

```php
<?php

$robotPart = new RobotParts();

$robotPart->type = 'head';

$robot = new Robots();

$robot->name       = 'WALL-E';
$robot->created_at = date('Y-m-d');
$robot->robotPart  = $robotPart;

// Crea una transacción implícita para almacenar ambos registros
$robot->save();
```

<a name='isolated'></a>

## Transacciones aisladas

Las transacciones aisladas se ejecutan en una nueva conexión, asegurando que todos los SQL generados, controles de claves extranjeras virtuales y reglas de negocio están aisladas de la conexión principal. Este tipo de transacción requiere de un administrador de transacciones que gestiona globalmente cada transacción creada, asegurando que ellas sean correctamente confirmadas/desechadas antes de terminar la solicitud:

```php
<?php

use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

try {
    // Crear un gestor de transacciones
    $manager = new TxManager();

    // Solicitar una transacción
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
    $robotPart->type      = 'cabeza';

    if ($robotPart->save() === false) {
        $transaction->rollback(
            'Cannot save robot part'
        );
    }

    // Todo resulto bien, entonces confirmamos la transacción
    $transaction->commit();
} catch (TxFailed $e) {
    echo 'Failed, reason: ', $e->getMessage();
}
```

Las transacciones pueden utilizarse para eliminar muchos registros de forma coherente:

```php
<?php

use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

try {
    // Crear un gestor de transacciones
    $manager = new TxManager();

    // Solicitar una transacción
    $transaction = $manager->get();

    // Obtener los robots a borrar
    $robots = Robots::find(
        "type = 'mechanical'"
    );

    foreach ($robots as $robot) {
        $robot->setTransaction($transaction);

        // Algo resulto mal, debemos deshacer la transacción
        if ($robot->delete() === false) {
            $messages = $robot->getMessages();

            foreach ($messages as $message) {
                $transaction->rollback(
                    $message->getMessage()
                );
            }
        }
    }

    // Todo salio bien, confirmamos la transacción
    $transaction->commit();

    echo 'Robots borrados exitosamente!';
} catch (TxFailed $e) {
    echo 'Error, detalle: ', $e->getMessage();
}
```

Las transacciones se reutilizan, sin importar de donde es obtenido el objeto de la transacción. A new transaction is generated only when a `commit()` or :code:`rollback()` is performed. Se puede utilizar el contenedor de servicio para crear un administrador global de transacciones para toda la aplicación:

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

Para luego acceder a él desde un controlador o vista:

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function saveAction()
    {
        // Obtener el gestor de transacciones desde el contenedor de servicios
        $manager = $this->di->getTransactions();

        // O simplemente
        $manager = $this->transactions;

        // Solicitar una transacción
        $transaction = $manager->get();

        // ...
    }
}
```

Mientras una transacción está activa, el administrador de transacciones siempre devuelve la misma transacción a través de la aplicación.