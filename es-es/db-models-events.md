---
layout: default
title: 'Eventos del Modelo'
keywords: 'modelos, eventos, gestor de eventos'
---

# Eventos del Modelo
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
Los modelos le permiten implementar eventos que se lanzarán al realizar un `insert/update/delete`, que se pueden usar para definir las reglas de negocio. The following are the events supported by [Phalcon\Mvc\Model][mvc-model-query] and their order of execution:

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
Los modelos actúan como oyentes del gestor de eventos. Therefore, we only need to implement the events above in the models directly as public methods:

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
Additionally, this component is integrated with [Phalcon\Events\Manager][events-manager], this means we can create listeners that run when an event is triggered.

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
When using high-level abstraction components such as [Phalcon\Mvc\Model][mvc-model] to access a database, it is difficult to understand which statements are finally sent to the database system. [Phalcon\Mvc\Model][mvc-model] is supported internally by [Phalcon\Db][db]. [Phalcon\Logger](logger) interacts with [Phalcon\Db][db], providing logging capabilities on the database abstraction layer, thus allowing us to log SQL statements as they happen.

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

As above, the file */storage/logs/db.log* will contain something like this:


> `[Mon, 30 Apr 12 13:47:18 -0500][DEBUG][Resource Id #77] INSERT INTO co_invoices` `(inv_cst_id, inv_title, inv_total) VALUES (10, 'Invoice for ACME Inc.', 10000)`

## Perfilando sentencias SQL
Using the [Phalcon\Db][db], the underlying component of [Phalcon\Mvc\Model][mvc-model], it is possible to profile the SQL statements generated by the ORM in order to analyze the performance of database operations. Analizar los registros ayudará a identificar cuellos de botella en su código SQL:

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

[db]: api/phalcon_db
[events-manager]: api/phalcon_events#events-manager
[mvc-model]: api/phalcon_mvc#mvc-model
[mvc-model-query]: api/phalcon_mvc#mvc-model-query
