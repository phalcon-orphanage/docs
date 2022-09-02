---
layout: default
language: 'es-es'
version: '4.0'
title: 'Eventos del Modelo'
keywords: 'modelos, eventos, gestor de eventos'
---

# Eventos del Modelo

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

Los modelos le permiten implementar eventos que se lanzarán al realizar un `insert/update/delete`, que se pueden usar para definir las reglas de negocio. Se soportan los siguiente eventos por [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model-query) y su orden de ejecución:

| Operación           | Nombre                     | Detiene? | Explicación                                                                                                  |
| ------------------- | -------------------------- |:--------:| ------------------------------------------------------------------------------------------------------------ |
| Insertar            | `afterCreate`              |    No    | Se ejecuta después de crear un registro                                                                      |
| Eliminar            | `afterDelete`              |    No    | Se ejecuta después de borrar registros                                                                       |
| Obtener             | `afterFetch`               |    No    | Se ejecuta después de obtener registros                                                                      |
| Insertar/Actualizar | `afterSave`                |    No    | Se ejecuta después de guardar un registro                                                                    |
| Actualizar          | `afterUpdate`              |    No    | Se ejecuta después de actualizar un registro                                                                 |
| Insertar/Actualizar | `afterValidation`          |    Si    | Se ejecuta después de que se validen los campos no nulos/cadenas vacías o llaves ajenas                      |
| Insertar            | `afterValidationOnCreate`  |    Si    | Se ejecuta después de que se validen los campos no nulos/cadenas vacías o llaves ajenas en una inserción     |
| Actualizar          | `afterValidationOnUpdate`  |    Si    | Se ejecuta después de que se validen los campos no nulos/cadenas vacías o claves ajenas en una actualización |
| Insertar            | `beforeCreate`             |    Si    | Se ejecuta antes de crear un registro                                                                        |
| Eliminar            | `beforeDelete`             |    Si    | Se ejecuta antes de eliminar registros                                                                       |
| Insertar/Actualizar | `beforeSave`               |    Si    | Se ejecuta antes de guardar un registro                                                                      |
| Actualizar          | `beforeUpdate`             |    Si    | Se ejecuta antes de actualizar un registro                                                                   |
| Insertar/Actualizar | `beforeValidation`         |    Si    | Se ejecuta antes de que se validen los campos no nulos/cadenas vacías o claves ajenas                        |
| Insertar            | `beforeValidationOnCreate` |    Si    | Se ejecuta antes de que se validen los campos no nulos/cadenas vacías o claves ajenas                        |
| Actualizar          | `beforeValidationOnUpdate` |    Si    | Se ejecuta antes de que se validen los campos no nulos/cadenas vacías o claves ajenas en una actualización   |
| Eliminar            | `notDeleted`               |    No    | Se ejecuta cuando los registros no se eliminan (falla)                                                       |
| Guardar             | `notSaved`                 |    No    | Se ejecuta cuando los registros no se guardan (falla)                                                        |
| Insertar/Actualizar | `onValidationFails`        |    Si    | Se ejecuta después de que un validador de integridad falle                                                   |
| Insertar/Actualizar | `prepareSave`              |    No    | Se ejecuta antes de guardar y permite manipular datos                                                        |
| Insertar/Actualizar | `validation`               |    Si    | Se ejecuta antes de que se validen los campos no nulos/cadenas vacías o claves ajenas en una actualización   |

### Eventos

Los modelos actúan como oyentes del gestor de eventos. Por lo tanto, sólo necesitamos implementar los eventos anteriores directamente en los modelos como métodos públicos:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

/**
 * Class Invoices
 *
 * @property string $inv_created_at
 * @property int    $inv_cst_id
 * @property int    $inv_id
 * @property string $inv_number
 * @property string $inv_title
 * @property float  $inv_total
 */
class Invoices extends Model
{
    /**
     * @var int
     */
    public $inv_cst_id;

    /**
     * @var string
     */
    public $inv_created_at;

    /**
     * @var int
     */
    public $inv_id;

    /**
     * @var string
     */
    public $inv_number;

    /**
     * @var string
     */
    public $inv_title;

    /**
     * @var float
     */
    public $inv_total;

    public function beforeValidationOnCreate()
    {
        if ($this->inv_total < 1) {
            $this->inv_total = 0;
        }
    }
}

```

Los eventos se pueden usar para asignar valores antes de ejecutar una operación, por ejemplo:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use function str_pad;

/**
 * Class Invoices
 *
 * @property string $inv_created_at
 * @property int    $inv_cst_id
 * @property int    $inv_id
 * @property string $inv_number
 * @property string $inv_title
 * @property float  $inv_total
 */
class Invoices extends Model
{
    /**
     * @var int
     */
    public $inv_cst_id;

    /**
     * @var string
     */
    public $inv_created_at;

    /**
     * @var int
     */
    public $inv_id;

    /**
     * @var string
     */
    public $inv_number;

    /**
     * @var string
     */
    public $inv_title;

    /**
     * @var float
     */
    public $inv_total;

    public function beforeCreate()
    {
        $date     = date('YmdHis');
        $customer = substr(
            str_pad(
                $this->inv_cst_id, 6, '0', STR_PAD_LEFT
            ),
            -6
        );

        $this->inv_number = 'INV-' . $customer . '-' . $date;
    }
}
```

### Gestor de Eventos Personalizado

Además, este componente está integrado con [Phalcon\Events\Manager](api/phalcon_events#events-manager), esto significa que podemos crear oyentes que se ejecuten cuando se dispare un evento.

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Events\Manager;

/**
 * Class Invoices
 *
 * @property string $inv_created_at
 * @property int    $inv_cst_id
 * @property int    $inv_id
 * @property string $inv_number
 * @property string $inv_title
 * @property float  $inv_total
 */
class Invoices extends Model
{
    /**
     * @var int
     */
    public $inv_cst_id;

    /**
     * @var string
     */
    public $inv_created_at;

    /**
     * @var int
     */
    public $inv_id;

    /**
     * @var string
     */
    public $inv_number;

    /**
     * @var string
     */
    public $inv_title;

    /**
     * @var float
     */
    public $inv_total;

    public function initialize()
    {
        $eventsManager = new Manager();

        $eventsManager->attach(
            'model:beforeSave',
            function (Event $event, $invoice) {
                if ($invoice->inv_total < 1) {
                    return false;
                }

                return true;
            }
        );

        $this->setEventsManager($eventsManager);
    }
}
```

En el ejemplo anterior, el Gestor de Eventos sólo actúa como puente entre un objeto y un oyente (la función anónima). Los eventos se dispararán hacia el oyente cuando se guarde `Invoices`:

```php
<?php

use MyApp\Models\Invoices;

$invoice = new Invoices();
$invoice->inv_cst_id = 10;
$invoice->inv_title = 'Invoice for ACME Inc.';

$invoice->save();
```

Si queremos que todos los objetos creados en nuestra aplicación usen el mismo Gestor de Eventos, necesitamos asignarlo al Gestor de Modelos cuando lo configuramos en el contenedor DI:

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Model\Manager as ModelsManager;

$container = new FactoryDefault();
$container->setShared(
    'modelsManager',
    function () {
        $eventsManager = new Manager();

        $eventsManager->attach(
            'model:beforeSave',
            function (Event $event, $model) {
                if (get_class($model) === Invoices::class) {
                    if ($model->inv_total < 1) {
                        return false;
                    }
                }

                return true;
            }
        );

        $modelsManager = new ModelsManager();
        $modelsManager->setEventsManager($eventsManager);

        return $modelsManager;
    }
);
```

Si un oyente devuelve `false`, detendrá la operación que se está ejecutando actualmente.

## Registrar Sentencias SQL

Cuando se usa componentes de abstracción de alto nivel como [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) para acceder a la base de datos, es difícil de entender qué sentencias se envían finalmente al sistema de base de datos. [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) se soporta internamente por [Phalcon\Db](api/phalcon_db). [Phalcon\Logger](logger) interactúa con [Phalcon\Db](api/phalcon_db), proporcionando capacidades de registro sobre la capa de abstracción de base de datos, lo que nos permite registrar sentencias SQL a medida que suceden.

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$container = new FactoryDefault();
$container->set(
    'db',
    function () {
        $eventsManager = new Manager();
        $adapter = new Stream('/storage/logs/db.log');
        $logger  = new Logger(
            'messages',
            [
                'main' => $adapter,
            ]
        );

        $eventsManager->attach(
            'db:beforeQuery',
            function ($event, $connection) use ($logger) {
                $logger->info(
                    $connection->getSQLStatement()
                );
            }
        );

        $connection = new Mysql\(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'phalcon',
            ]
        );

        $connection->setEventsManager($eventsManager);

        return $connection;
    }
);
```

Como los modelos acceden a la conexión de base de datos por defecto, todas las sentencias SQL que se envían al sistema de base de datos se registran en el fichero:

```php
<?php

use MyApp\Models\Invoices;

$invoice = new Invoices();
$invoice->inv_cst_id = 10;
$invoice->inv_title  = 'Invoice for ACME Inc.';
$invoice->inv_total  = 10000;

if ($invoice->save() === false) {
    echo 'Cannot save robot';
}
```

Como se ve arriba, el fichero */storage/logs/db.log* contendrá algo parecido a esto:

> `[Mon, 30 Apr 12 13:47:18 -0500][DEBUG][Resource Id #77] INSERT INTO co_invoices` `(inv_cst_id, inv_title, inv_total) VALUES (10, 'Invoice for ACME Inc.', 10000)`

## Perfilando sentencias SQL

Usando [Phalcon\Db](api/phalcon_db), el componente subyacente de [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model), es posible perfilar las sentencias SQL generadas por el ORM para analizar el rendimiento de las operaciones de la base de datos. Analizar los registros ayudará a identificar cuellos de botella en su código SQL:

```php
<?php

use Phalcon\Db\Profiler;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager;
use Phalcon\Db\Adapter\Pdo;

$container = new FactoryDefault();
$container->set(
    'profiler',
    function () {
        return new Profiler();
    },
    true
);

$container->set(
    'db',
    function () use ($container) {
        $manager  = new Manager();
        $profiler = $container->getProfiler();

        $manager->attach(
            'db',
            function ($event, $connection) use ($profiler) {
                if ($event->getType() === 'beforeQuery') {
                    $profiler->startProfile(
                        $connection->getSQLStatement()
                    );
                }

                if ($event->getType() === 'afterQuery') {
                    $profiler->stopProfile();
                }
            }
        );

        $connection = new Mysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'phalcon',
            ]
        );

        // Assign the eventsManager to the db adapter instance
        $connection->setEventsManager($manager);

        return $connection;
    }
);
```

Perfilando algunas consultas:

```php
<?php

use MyApp\Models\Invoices;

Invoices::find();
Invoices::find(
    [
        'order' => 'inv_cst_id, inv_title',
    ]
);
Invoices::find(
    [
        'limit' => 30,
    ]
);

$profiles = $container->get('profiler')->getProfiles();

foreach ($profiles as $profile) {
    echo 'SQL: ', 
        $profile->getSQLStatement(), 
        PHP_EOL,
        'Start: ',
        $profile->getInitialTime(),
        PHP_EOL,
        'Final: ',
        $profile->getFinalTime(),
        PHP_EOL,
        'Elapsed: ',
        $profile->getTotalElapsedSeconds(),
        PHP_EOL
    );
}
```

Cada perfil generado contiene la duración en milisegundos que cada instrucción consume para completarse, así como también la sentencia SQL generada.
