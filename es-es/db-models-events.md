---
layout: default
language: 'es-es'
version: '4.0'
---

# Model Events

* * *

![](/assets/images/document-status-under-review-red.svg)

## Events and Events Manager

Models allow you to implement events that will be thrown while performing an insert/update/delete which can be used to define business rules. The following are the events supported by [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) and their order of execution:

| Operación             | Nombre                     | ¿Detiene la operación? | Explicación                                                                                                                                      |
| --------------------- | -------------------------- |:----------------------:| ------------------------------------------------------------------------------------------------------------------------------------------------ |
| Insertar              | `afterCreate`              |           NO           | Se ejecuta después de la operación sobre el sistema de base de datos pero sólo cuando se realiza una operación de inserción                      |
| Insertar o actualizar | `afterSave`                |           NO           | Después que la operación se ejecuta sobre el sistema de base de datos solo para inserción o actualización                                        |
| Actualizar            | `afterUpdate`              |           NO           | Se ejecuta después de la operación sobre el sistema de base de datos pero sólo cuando se realiza una operación de actualización                  |
| Insertar o actualizar | `afterValidation`          |           SI           | Se ejecuta después de que se validan los campos no nulos/cadenas vacías o llaves foráneas                                                        |
| Insertar              | `afterValidationOnCreate`  |           SI           | Se ejecuta después de que se validan los campos no nulos/cadenas vacías o llaves foráneas solo cuando se realiza una operación de inserción      |
| Actualizar            | `afterValidationOnUpdate`  |           SI           | Se ejecuta después de que se validan los campos no nulos/cadenas vacías o llaves foráneas, solo cuando se realiza una operación de actualización |
| Insertar              | `beforeCreate`             |           SI           | Se ejecuta antes de la operación sobre el sistema de base de datos, sólo cuando se realiza una operación de inserción                            |
| Insertar o actualizar | `beforeSave`               |           SI           | Se ejecuta antes de la operación sobre el sistema de base de datos, para operaciones de inserción o actualización                                |
| Actualizar            | `beforeUpdate`             |           SI           | Se ejecuta antes de la operación sobre el sistema de base de datos, sólo cuando se realiza una operación de actualización                        |
| Insertar o actualizar | `beforeValidation`         |           SI           | Se ejecuta antes de que se validan los campos no nulos/cadenas vacías o llaves foráneas, para operaciones de inserción o actualización           |
| Insertar              | `beforeValidationOnCreate` |           SI           | Se ejecuta antes de que se validan los campos no nulos/cadenas vacías o llaves foráneas, solo cuando se realiza una operación de inserción       |
| Actualizar            | `beforeValidationOnUpdate` |           SI           | Se ejecuta antes de que se validan los campos no nulos/cadenas vacías o llaves foráneas, solo cuando se realiza una operación de actualización   |
| Insertar o actualizar | `onValidationFails`        |     SI (detenido)      | Se ejecuta después de un validador de integridad falla                                                                                           |
| Insertar o actualizar | `prepareSave`              |           NO           | Es ejecutado antes de guardar y permite la manipulación de datos                                                                                 |
| Insertar o actualizar | `validation`               |           SI           | Se ejecuta antes de que se validan los campos no nulos/cadenas vacías o llaves foráneas, solo cuando se realiza una operación de actualización   |

### Implementing Events in Models

The easier way to make a model react to events is to implement a method with the same name of the event in the model's class:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function beforeValidationOnCreate()
    {
        echo 'Esto se ejecuta antes de crear un Robot!';
    }
}
```

Events can be used to assign values before performing an operation, for example:

```php
<?php

use Phalcon\Mvc\Model;

class Products extends Model
{
    public function beforeCreate()
    {
        // Establecer fecha de creación
        $this->created_at = date('Y-m-d H:i:s');
    }

    public function beforeUpdate()
    {
        // Establecer fecha de actualización
        $this->modified_in = date('Y-m-d H:i:s');
    }
}
```

### Using a custom Events Manager

Additionally, this component is integrated with [Phalcon\Events\Manager](api/Phalcon_Events_Manager), this means we can create listeners that run when an event is triggered.

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

class Robots extends Model
{
    public function initialize()
    {
        $eventsManager = new EventsManager();

        // Adjuntamos una función anónima para escuchar los eventos del modelo
        $eventsManager->attach(
            'model:beforeSave',
            function (Event $event, $robot) {
                if ($robot->name === 'Scooby Doo') {
                    echo "Scooby Doo no es un robot!";

                    return false;
                }

                return true;
            }
        );

        // Adjuntamos el event manager al evento
        $this->setEventsManager($eventsManager);
    }
}
```

In the example given above, the Events Manager only acts as a bridge between an object and a listener (the anonymous function). Events will be fired to the listener when `robots` are saved:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->name = 'Scooby Doo';
$robot->year = 1969;

$robot->save();
```

If we want all objects created in our application use the same EventsManager, then we need to assign it to the Models Manager:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// Registering the modelsManager service
$di->setShared(
    'modelsManager',
    function () {
        $eventsManager = new EventsManager();

        // Attach an anonymous function as a listener for 'model' events
        $eventsManager->attach(
            'model:beforeSave',
            function (Event $event, $model) {
                // Catch events produced by the Robots model
                if (get_class($model) === \Store\Toys\Robots::class) {
                    if ($model->name === 'Scooby Doo') {
                        echo "Scooby Doo isn't a robot!";

                        return false;
                    }
                }

                return true;
            }
        );

        // Setting a default EventsManager
        $modelsManager = new ModelsManager();

        $modelsManager->setEventsManager($eventsManager);

        return $modelsManager;
    }
);
```

If a listener returns false that will stop the operation that is executing currently.

## Logging Low-Level SQL Statements

When using high-level abstraction components such as [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) to access a database, it is difficult to understand which statements are finally sent to the database system. [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) is supported internally by [Phalcon\Db](api/Phalcon_Db). [Phalcon\Logger](api/Phalcon_Logger) interacts with [Phalcon\Db](api/Phalcon_Db), providing logging capabilities on the database abstraction layer, thus allowing us to log SQL statements as they happen.

```php
<?php

use Phalcon\Logger;
use Phalcon\Events\Manager;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Db\Adapter\Pdo\Mysql as Connection;

$di->set(
    'db',
    function () {
        $eventsManager = new EventsManager();

        $logger = new FileLogger('app/logs/debug.log');

        // Escucharemos todos los eventos de la base de datos
        $eventsManager->attach(
            'db:beforeQuery',
            function ($event, $connection) use ($logger) {
                $logger->log(
                    $connection->getSQLStatement(),
                    Logger::INFO
                );
            }
        );

        $connection = new Connection(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );

        // Asignamos el eventsManager a la instancia del adaptador de db
        $connection->setEventsManager($eventsManager);

        return $connection;
    }
);
```

As models access the default database connection, all SQL statements that are sent to the database system will be logged in the file:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->name       = 'Robby el Robot';
$robot->created_at = '1956-07-21';

if ($robot->save() === false) {
    echo 'No se pudo guardar el robot';
}
```

As above, the file *app/logs/db.log* will contain something like this:

> `[Mon, 30 Apr 12 13:47:18 -0500][DEBUG][Resource Id #77] INSERT INTO robots` `(name, created_at) VALUES ('Robby el Robot', '1956-07-21')`

## Perfilando sentencias SQL

Thanks to [Phalcon\Db](api/Phalcon_Db), the underlying component of [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model), it's possible to profile the SQL statements generated by the ORM in order to analyze the performance of database operations. With this you can diagnose performance problems and to discover bottlenecks.

```php
<?php

use Phalcon\Db\Profiler as ProfilerDb;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Adapter\Pdo\Mysql as MysqlPdo;

$di->set(
    'profiler',
    function () {
        return new ProfilerDb();
    },
    true
);

$di->set(
    'db',
    function () use ($di) {
        $eventsManager = new EventsManager();

        // Obtenemos la instancia compartida de DbProfiler
        $profiler = $di->getProfiler();

        // Escuchamos todos los eventos de la base de datos
        $eventsManager->attach(
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

        $connection = new MysqlPdo(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );

        // Asignamos el eventsManager a la instancia del adaptador de db
        $connection->setEventsManager($eventsManager);

        return $connection;
    }
);
```

Profiling some queries:

```php
<?php

use Store\Toys\Robots;

// Enviamos algunas sentencias SQL a la base de datos
Robots::find();

Robots::find(
    [
        'order' => 'name',
    ]
);

Robots::find(
    [
        'limit' => 30,
    ]
);

// Obtenemos los perfiles generados por el profiler
$profiles = $di->get('profiler')->getProfiles();

foreach ($profiles as $profile) {
   echo 'SQL Statement: ', $profile->getSQLStatement(), '\n';
   echo 'Start Time: ', $profile->getInitialTime(), '\n';
   echo 'Final Time: ', $profile->getFinalTime(), '\n';
   echo 'Total Elapsed Time: ', $profile->getTotalElapsedSeconds(), '\n';
}
```

Each generated profile contains the duration in milliseconds that each instruction takes to complete as well as the generated SQL statement.