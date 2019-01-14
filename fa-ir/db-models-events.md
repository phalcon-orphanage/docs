* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Model Events

<a name='events'></a>

## Events and Events Manager

Models allow you to implement events that will be thrown while performing an insert/update/delete which can be used to define business rules. The following are the events supported by [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) and their order of execution:

| Operation          | Name                     |  Can stop operation?  | Explanation                                                                                                                       |
| ------------------ | ------------------------ |:---------------------:| --------------------------------------------------------------------------------------------------------------------------------- |
| Inserting          | afterCreate              |          NO           | Runs after the required operation over the database system only when an inserting operation is being made                         |
| Inserting/Updating | afterSave                |          NO           | Runs after the required operation over the database system                                                                        |
| Updating           | afterUpdate              |          NO           | Runs after the required operation over the database system only when an updating operation is being made                          |
| Inserting/Updating | afterValidation          |          YES          | Is executed after the fields are validated for not nulls/empty strings or foreign keys                                            |
| Inserting          | afterValidationOnCreate  |          YES          | Is executed after the fields are validated for not nulls/empty strings or foreign keys when an insertion operation is being made  |
| Updating           | afterValidationOnUpdate  |          YES          | Is executed after the fields are validated for not nulls/empty strings or foreign keys when an updating operation is being made   |
| Inserting          | beforeCreate             |          YES          | Runs before the required operation over the database system only when an inserting operation is being made                        |
| Inserting/Updating | beforeSave               |          YES          | Runs before the required operation over the database system                                                                       |
| Updating           | beforeUpdate             |          YES          | Runs before the required operation over the database system only when an updating operation is being made                         |
| Inserting/Updating | beforeValidation         |          YES          | Is executed before the fields are validated for not nulls/empty strings or foreign keys                                           |
| Inserting          | beforeValidationOnCreate |          YES          | Is executed before the fields are validated for not nulls/empty strings or foreign keys when an insertion operation is being made |
| Updating           | beforeValidationOnUpdate |          YES          | Is executed before the fields are validated for not nulls/empty strings or foreign keys when an updating operation is being made  |
| Inserting/Updating | onValidationFails        | YES (already stopped) | Is executed after an integrity validator fails                                                                                    |
| Inserting/Updating | prepareSave              |          NO           | Is executed before saving and allows data manipulation                                                                            |
| Inserting/Updating | validation               |          YES          | Is executed before the fields are validated for not nulls/empty strings or foreign keys when an updating operation is being made  |

<a name='events-in-models'></a>

### Implementing Events in the Model's class

The easier way to make a model react to events is to implement a method with the same name of the event in the model's class:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function beforeValidationOnCreate()
    {
        echo 'This is executed before creating a Robot!';
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
        // Set the creation date
        $this->created_at = date('Y-m-d H:i:s');
    }

    public function beforeUpdate()
    {
        // Set the modification date
        $this->modified_in = date('Y-m-d H:i:s');
    }
}
```

<a name='custom-events-manager'></a>

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

        // Attach an anonymous function as a listener for 'model' events
        $eventsManager->attach(
            'model:beforeSave',
            function (Event $event, $robot) {
                if ($robot->name === 'Scooby Doo') {
                    echo "Scooby Doo isn't a robot!";

                    return false;
                }

                return true;
            }
        );

        // Attach the events manager to the event
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
                if (get_class($model) === 'Store\Toys\Robots') {
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

<a name='logging-sql-statements'></a>

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

        // Listen all the database events
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

        // Assign the eventsManager to the db adapter instance
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

$robot->name       = 'Robby the Robot';
$robot->created_at = '1956-07-21';

if ($robot->save() === false) {
    echo 'Cannot save robot';
}
```

As above, the file *app/logs/db.log* will contain something like this:

> `[Mon, 30 Apr 12 13:47:18 -0500][DEBUG][Resource Id #77] INSERT INTO robots` `(name, created_at) VALUES ('Robby the Robot', '1956-07-21')`

<a name='profiling-sql-statements'></a>

## Profiling SQL Statements

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

        // Get a shared instance of the DbProfiler
        $profiler = $di->getProfiler();

        // Listen all the database events
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

        // Assign the eventsManager to the db adapter instance
        $connection->setEventsManager($eventsManager);

        return $connection;
    }
);
```

Profiling some queries:

```php
<?php

use Store\Toys\Robots;

// Send some SQL statements to the database
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

// Get the generated profiles from the profiler
$profiles = $di->get('profiler')->getProfiles();

foreach ($profiles as $profile) {
   echo 'SQL Statement: ', $profile->getSQLStatement(), '\n';
   echo 'Start Time: ', $profile->getInitialTime(), '\n';
   echo 'Final Time: ', $profile->getFinalTime(), '\n';
   echo 'Total Elapsed Time: ', $profile->getTotalElapsedSeconds(), '\n';
}
```

Each generated profile contains the duration in milliseconds that each instruction takes to complete as well as the generated SQL statement.