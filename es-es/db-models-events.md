* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Eventos del Modelo

<a name='events'></a>

## Eventos y Gestor de eventos

Los modelos permiten implementar eventos que se disparan al realizar una inserción/actualización/eliminación, pueden usarse para definir reglas de negocio. The following are the events supported by [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) and their order of execution:

| Operación             | Nombre                   | ¿Detiene la operación? | Explicación                                                                                                                                      |
| --------------------- | ------------------------ |:----------------------:| ------------------------------------------------------------------------------------------------------------------------------------------------ |
| Insertar              | afterCreate              |           NO           | Se ejecuta después de la operación sobre el sistema de base de datos pero sólo cuando se realiza una operación de inserción                      |
| Insertar o actualizar | afterSave                |           NO           | Después que la operación se ejecuta sobre el sistema de base de datos solo para inserción o actualización                                        |
| Actualizar            | afterUpdate              |           NO           | Se ejecuta después de la operación sobre el sistema de base de datos pero sólo cuando se realiza una operación de actualización                  |
| Insertar o actualizar | afterValidation          |           SI           | Se ejecuta después de que se validan los campos no nulos/cadenas vacías o llaves foráneas                                                        |
| Insertar              | afterValidationOnCreate  |           SI           | Se ejecuta después de que se validan los campos no nulos/cadenas vacías o llaves foráneas solo cuando se realiza una operación de inserción      |
| Actualizar            | afterValidationOnUpdate  |           SI           | Se ejecuta después de que se validan los campos no nulos/cadenas vacías o llaves foráneas, solo cuando se realiza una operación de actualización |
| Insertar              | beforeCreate             |           SI           | Se ejecuta antes de la operación sobre el sistema de base de datos, sólo cuando se realiza una operación de inserción                            |
| Insertar o actualizar | beforeSave               |           SI           | Se ejecuta antes de la operación sobre el sistema de base de datos, para operaciones de inserción o actualización                                |
| Actualizar            | beforeUpdate             |           SI           | Se ejecuta antes de la operación sobre el sistema de base de datos, sólo cuando se realiza una operación de actualización                        |
| Insertar o actualizar | beforeValidation         |           SI           | Se ejecuta antes de que se validan los campos no nulos/cadenas vacías o llaves foráneas, para operaciones de inserción o actualización           |
| Insertar              | beforeValidationOnCreate |           SI           | Se ejecuta antes de que se validan los campos no nulos/cadenas vacías o llaves foráneas, solo cuando se realiza una operación de inserción       |
| Actualizar            | beforeValidationOnUpdate |           SI           | Se ejecuta antes de que se validan los campos no nulos/cadenas vacías o llaves foráneas, solo cuando se realiza una operación de actualización   |
| Insertar o actualizar | onValidationFails        |     SI (detenido)      | Se ejecuta después de un validador de integridad falla                                                                                           |
| Insertar o actualizar | prepareSave              |           NO           | Es ejecutado antes de guardar y permite la manipulación de datos                                                                                 |
| Insertar o actualizar | validation               |           SI           | Se ejecuta antes de que se validan los campos no nulos/cadenas vacías o llaves foráneas, solo cuando se realiza una operación de actualización   |

<a name='events-in-models'></a>

### Implementando eventos en clases de Modelos

La manera más fácil para hacer a un modelo reaccionar a los eventos es implementar un método con el mismo nombre del evento en la clase del modelo:

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

Los eventos pueden utilizarse para asignar valores antes de realizar una operación, por ejemplo:

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

<a name='custom-events-manager'></a>

### Utilizando un Gestor de Eventos personalizado

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

En el ejemplo anterior, el gestor de eventos sólo actúa como un puente entre un objeto y un oyente (la función anónima). Los eventos se dispararán al oyente cuando los `robots` se guarden:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->name = 'Scooby Doo';
$robot->year = 1969;

$robot->save();
```

Si queremos que todos los objetos creados en nuestra aplicación utilicen el mismo EventsManager, tenemos que asignarlo al administrador de modelos (Models Manager):

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// Registramos el servicio modelsManager
$di->setShared(
    'modelsManager',
    function () {
        $eventsManager = new EventsManager();

        // Adjuntamos una función anónima como listener para los eventos del 'model'
        $eventsManager->attach(
            'model:beforeSave',
            function (Event $event, $model) {
                // Capturamos los eventos producidos en el modelo Robots
                if (get_class($model) === 'Store\Toys\Robots') {
                    if ($model->name === 'Scooby Doo') {
                        echo "Scooby Doo no es un robot!";

                        return false;
                    }
                }

                return true;
            }
        );

        // Configuramos el EventsManager por defecto
        $modelsManager = new ModelsManager();

        $modelsManager->setEventsManager($eventsManager);

        return $modelsManager;
    }
);
```

Si un oyente devuelve `false` detendrá la operación que se esté ejecutando actualmente.

<a name='logging-sql-statements'></a>

## Registro de sentencias SQL de bajo nivel

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

Como los modelos acceden a la conexión de base de datos por defecto, todas las sentencias SQL que se envían al sistema de base de datos se registrarán en un archivo:

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

Como en el anterior ejemplo, el archivo *app/logs/db.log* contendrá algo como esto:

> `[Mon, 30 Apr 12 13:47:18 -0500][DEBUG][Resource Id #77] INSERT INTO robots` `(name, created_at) VALUES ('Robby el Robot', '1956-07-21')`

<a name='profiling-sql-statements'></a>

## Perfilando sentencias SQL

Thanks to [Phalcon\Db](api/Phalcon_Db), the underlying component of [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model), it's possible to profile the SQL statements generated by the ORM in order to analyze the performance of database operations. Con esto usted puede diagnosticar problemas de rendimiento y descubrir cuellos de botella.

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

Perfilando de algunas consultas:

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

Cada perfil generado contiene la duración en milisegundos que tarda cada instrucción en completarse, así como la instrucción SQL generada.