<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">ODM (Object-Document Mapper)</a> <ul>
        <li>
          <a href="#creating-models">Creating Models</a>
        </li>
        <li>
          <a href="#documents-to-objects">Understanding Documents To Objects</a>
        </li>
        <li>
          <a href="#namespaces">Models in Namespaces</a>
        </li>
        <li>
          <a href="#connection-setup">Setting a Connection</a>
        </li>
        <li>
          <a href="#finding-documents">Finding Documents</a>
        </li>
        <li>
          <a href="#aggregations">Aggregations</a>
        </li>
        <li>
          <a href="#creating-updating">Creating Updating/Records</a> <ul>
            <li>
              <a href="#validation-messages">Validation Messages</a>
            </li>
            <li>
              <a href="#events">Validation Events and Events Manager</a>
            </li>
            <li>
              <a href="#business-rules">Implementing a Business Rule</a>
            </li>
            <li>
              <a href="#data-integrity">Validating Data Integrity</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#deleting-records">Deleting Records</a>
        </li>
        <li>
          <a href="#validation-failed-events">Validation Failed Events</a>
        </li>
        <li>
          <a href="#ids-vs-primary-keys">Örtülü Kimliklere karşılık Öncelikli Kullanıcı Anahtarları</a>
        </li>
        <li>
          <a href="#multiple-databases">Setting multiple databases</a>
        </li>
        <li>
          <a href="#services-in-models">Injecting services into Models</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<h5 class='alert alert-info'>Please note that if you are using the Mongo driver provided by PHP 7, the ODM will not work for you. There is an incubator adapter but all the Mongo code must be rewritten (new Bson type instead of arrays, no MongoId, no MongoDate, etc...). Please ensure that you test your code before upgrading to PHP 7 and/or Phalcon 3+</h5>

<a name='overview'></a>

# ODM (Object-Document Mapper)

In addition to its ability to [map tables](/[[language]]/[[version]]/models) in relational databases, Phalcon can map documents from NoSQL databases. The ODM offers a CRUD functionality, events, validations among other services.

Due to the absence of SQL queries and planners, NoSQL databases can see real improvements in performance using the Phalcon approach. Additionally, there are no SQL building reducing the possibility of SQL injections.

The following NoSQL databases are supported:

| Name                               | Description                                                          |
| ---------------------------------- | -------------------------------------------------------------------- |
| [MongoDB](http://www.mongodb.org/) | MongoDB is a scalable, high-performance, open source NoSQL database. |

<a name='creating-models'></a>

## Creating Models

A model is a class that extends from `Phalcon\Mvc\Collection`. It must be placed in the models directory. A model file must contain a single class; its class name should be in camel case notation:

```php
<?php

use Phalcon\Mvc\Collection;

class Robots extends Collection
{

}
```

By default model `Robots` will refer to the collection `robots`. If you want to manually specify another name for the mapping collection, you can use the `setSource()` method:

```php
<?php

use Phalcon\Mvc\Collection;

class Robots extends Collection
{
    public function initialize()
    {
        $this->setSource('the_robots');
    }
}
```

<a name='documents-to-objects'></a>

## Understanding Documents To Objects

Every instance of a model represents a document in the collection. You can easily access collection data by reading object properties. For example, for a collection `robots` with the documents:

```bash
$ mongo test
MongoDB shell version: 1.8.2
connecting to: test
> db.robots.find()
{ '_id' : ObjectId('508735512d42b8c3d15ec4e1'), 'name' : 'Astro Boy', 'year' : 1952,
    'type' : 'mechanical' }
{ '_id' : ObjectId('5087358f2d42b8c3d15ec4e2'), 'name' : 'Bender', 'year' : 1999,
    'type' : 'mechanical' }
{ '_id' : ObjectId('508735d32d42b8c3d15ec4e3'), 'name' : 'Wall-E', 'year' : 2008 }
>
```

<a name='namespaces'></a>

## Models in Namespaces

Namespaces can be used to avoid class name collision. In this case it is necessary to indicate the name of the related collection using the `setSource()` method:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Collection;

class Robots extends Collection
{
    public function initialize()
    {
        $this->setSource('robots');
    }
}
```

You could find a certain document by its ID and then print its name:

```php
<?php

// Find record with _id = '5087358f2d42b8c3d15ec4e2'
$robot = Robots::findById('5087358f2d42b8c3d15ec4e2');

// Prints 'Bender'
echo $robot->name;
```

Once the record is in memory, you can make modifications to its data and then save changes:

```php
<?php

$robot = Robots::findFirst(
    [
        [
            'name' => 'Astro Boy',
        ]
    ]
);

$robot->name = 'Voltron';

$robot->save();
```

<a name='connection-setup'></a>

## Setting a Connection

Connections are retrieved from the services container. By default, Phalcon tries to find the connection in a service called `mongo`:

```php
<?php

// Simple database connection to localhost
$di->set(
    'mongo',
    function () {
        $mongo = new MongoClient();

        return $mongo->selectDB('store');
    },
    true
);

// Connecting to a domain socket, falling back to localhost connection
$di->set(
    'mongo',
    function () {
        $mongo = new MongoClient(
            'mongodb:///tmp/mongodb-27017.sock,localhost:27017'
        );

        return $mongo->selectDB('store');
    },
    true
);
```

<a name='finding-documents'></a>

## Finding Documents

As `Phalcon\Mvc\Collection` relies on the Mongo PHP extension you have the same facilities to query documents and convert them transparently to model instances:

```php
<?php

// How many robots are there?
$robots = Robots::find();
echo 'There are ', count($robots), "\n";

// How many mechanical robots are there?
$robots = Robots::find(
    [
        [
            'type' => 'mechanical',
        ]
    ]
);
echo 'There are ', count($robots), "\n";

// Get and print mechanical robots ordered by name upward
$robots = Robots::find(
    [
        [
            'type' => 'mechanical',
        ],
        'sort' => [
            'name' => 1,
        ],
    ]
);

foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

// Get first 100 mechanical robots ordered by name
$robots = Robots::find(
    [
        [
            'type' => 'mechanical',
        ],
        'sort'  => [
            'name' => 1,
        ],
        'limit' => 100,
    ]
);

foreach ($robots as $robot) {
    echo $robot->name, "\n";
}
```

You could also use the `findFirst()` method to get only the first record matching the given criteria:

```php
<?php

// What's the first robot in robots collection?
$robot = Robots::findFirst();
echo 'The robot name is ', $robot->name, "\n";

// What's the first mechanical robot in robots collection?
$robot = Robots::findFirst(
    [
        [
            'type' => 'mechanical',
        ]
    ]
);

echo 'The first mechanical robot name is ', $robot->name, "\n";
```

Both `find()` and `findFirst()` methods accept an associative array specifying the search criteria:

```php
<?php

// First robot where type = 'mechanical' and year = '1999'
$robot = Robots::findFirst(
    [
        'conditions' => [
            'type' => 'mechanical',
            'year' => '1999',
        ],
    ]
);

// All virtual robots ordered by name downward
$robots = Robots::find(
    [
        'conditions' => [
            'type' => 'virtual',
        ],
        'sort' => [
            'name' => -1,
        ],
    ]
);
```

The available query options are:

| Parameter    | Description                                                                                                                                                                                  | Example                                                 |
| ------------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------- |
| `conditions` | Search conditions for the find operation. Is used to extract only those records that fulfill a specified criterion. By default Phalcon_model assumes the first parameter are the conditions. | `'conditions' => array('$gt' => 1990)`            |
| `fields`     | Returns specific columns instead of the full fields in the collection. When using this option an incomplete object is returned                                                               | `'fields' => array('name' => true)`               |
| `sort`       | It's used to sort the resultset. Use one or more fields as each element in the array, 1 means ordering upwards, -1 downward                                                                  | `'sort' => array('name' => -1, 'status' => 1)` |
| `limit`      | Limit the results of the query to results to certain range                                                                                                                                   | `'limit' => 10`                                      |
| `skip`       | Skips a number of results                                                                                                                                                                    | `'skip' => 50`                                       |

If you have experience with SQL databases, you may want to check the [SQL to Mongo Mapping Chart](http://www.php.net/manual/en/mongo.sqltomongo.php).

<a name='finding-documents-fields'></a>

## Querying specific fields

To query specific fields specific fields from a MongoDB database using the Phalcon ODM, all you need to do is:

```php
$myRobots = Robots:find(
    [
        'fields' => ['name' => 1]
    ]
];
```

The `find()` above only returns a `name`. It can also be combined with a `condition`:

```php
$myRobots = Robots:find(
    [
        ['type' => 'maid'],
        'fields' => ['name' => 1]
    ]
];
```

The example above returns the `name` of the robot with the `type = 'maid'`.

<a name='aggregations'></a>

## Aggregations

A model can return calculations using [aggregation framework](http://docs.mongodb.org/manual/applications/aggregation/) provided by Mongo. The aggregated values are calculate without having to use MapReduce. With this option is easy perform tasks such as totaling or averaging field values:

```php
<?php

$data = Article::aggregate(
    [
        [
            '\$project' => [
                'category' => 1,
            ],
        ],
        [
            '\$group' => [
                '_id' => [
                    'category' => '\$category'
                ],
                'id'  => [
                    '\$max' => '\$_id',
                ],
            ],
        ],
    ]
);
```

<a name='creating-updating'></a>

## Creating Updating/Records

The `Phalcon\Mvc\Collection::save()` method allows you to create/update documents according to whether they already exist in the collection associated with a model. The `save()` method is called internally by the create and update methods of `Phalcon\Mvc\Collection`.

Also the method executes associated validators and events that are defined in the model:

```php
<?php

$robot = new Robots();

$robot->type = 'mechanical';
$robot->name = 'Astro Boy';
$robot->year = 1952;

if ($robot->save() === false) {
    echo "Umh, We can't store robots right now: \n";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message, "\n";
    }
} else {
    echo 'Great, a new robot was saved successfully!';
}
```

The `_id` property is automatically updated with the [MongoId](http://www.php.net/manual/en/class.mongoid.php) object created by the driver:

```php
<?php

$robot->save();

echo 'The generated id is: ', $robot->getId();
```

<a name='validation-messages'></a>

### Validation Messages

`Phalcon\Mvc\Collection` has a messaging subsystem that provides a flexible way to output or store the validation messages generated during the insert/update processes.

Each message consists of an instance of the class `Phalcon\Mvc\Model\Message`. The set of messages generated can be retrieved with the method getMessages(). Each message provides extended information like the field name that generated the message or the message type:

```php
<?php

if ($robot->save() === false) {
    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo 'Message: ', $message->getMessage();
        echo 'Field: ', $message->getField();
        echo 'Type: ', $message->getType();
    }
}
```

<a name='events'></a>

### Validation Events and Events Manager

Models allow you to implement events that will be thrown when performing an insert or update. They help define business rules for a certain model. The following are the events supported by `Phalcon\Mvc\Collection` and their order of execution:

| Operation          | Name                       | Can stop operation?   | Explanation                                                                                                        |
| ------------------ | -------------------------- | --------------------- | ------------------------------------------------------------------------------------------------------------------ |
| Inserting/Updating | `beforeValidation`         | YES                   | Is executed before the validation process and the final insert/update to the database                              |
| Inserting          | `beforeValidationOnCreate` | YES                   | Is executed before the validation process only when an insertion operation is being made                           |
| Updating           | `beforeValidationOnUpdate` | YES                   | Is executed before the fields are validated for not nulls or foreign keys when an updating operation is being made |
| Inserting/Updating | `onValidationFails`        | YES (already stopped) | Is executed before the validation process only when an insertion operation is being made                           |
| Inserting          | `afterValidationOnCreate`  | YES                   | Is executed after the validation process when an insertion operation is being made                                 |
| Updating           | `afterValidationOnUpdate`  | YES                   | Is executed after the validation process when an updating operation is being made                                  |
| Inserting/Updating | `afterValidation`          | YES                   | Is executed after the validation process                                                                           |
| Inserting/Updating | `beforeSave`               | YES                   | Runs before the required operation over the database system                                                        |
| Updating           | `beforeUpdate`             | YES                   | Runs before the required operation over the database system only when an updating operation is being made          |
| Inserting          | `beforeCreate`             | YES                   | Runs before the required operation over the database system only when an inserting operation is being made         |
| Updating           | `afterUpdate`              | NO                    | Runs after the required operation over the database system only when an updating operation is being made           |
| Inserting          | `afterCreate`              | NO                    | Runs after the required operation over the database system only when an inserting operation is being made          |
| Inserting/Updating | `afterSave`                | NO                    | Runs after the required operation over the database system                                                         |

To make a model to react to an event, we must to implement a method with the same name of the event:

```php
<?php

use Phalcon\Mvc\Collection;

class Robots extends Collection
{
    public function beforeValidationOnCreate()
    {
        echo 'This is executed before creating a Robot!';
    }
}
```

Events can be useful to assign values before performing an operation, for example:

```php
<?php

use Phalcon\Mvc\Collection;

class Products extends Collection
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

Additionally, this component is integrated with the [Phalcon Events Manager](/[[language]]/[[version]]/events) (`Phalcon\Events\Manager`), this means we can create listeners that run when an event is triggered.

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

$eventsManager = new EventsManager();

// Attach an anonymous function as a listener for 'model' events
$eventsManager->attach(
    'collection:beforeSave',
    function (Event $event, $robot) {
        if ($robot->name === 'Scooby Doo') {
            echo "Scooby Doo isn't a robot!";

            return false;
        }

        return true;
    }
);

$robot = new Robots();

$robot->setEventsManager($eventsManager);

$robot->name = 'Scooby Doo';
$robot->year = 1969;

$robot->save();
```

In the example given above the EventsManager only acted as a bridge between an object and a listener (the anonymous function). If we want all objects created in our application use the same EventsManager, then we need to assign this to the Models Manager:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Collection\Manager as CollectionManager;

// Registering the collectionManager service
$di->set(
    'collectionManager',
    function () {
        $eventsManager = new EventsManager();

        // Attach an anonymous function as a listener for 'model' events
        $eventsManager->attach(
            'collection:beforeSave',
            function (Event $event, $model) {
                if (get_class($model) === 'Robots') {
                    if ($model->name === 'Scooby Doo') {
                        echo "Scooby Doo isn't a robot!";

                        return false;
                    }
                }

                return true;
            }
        );

        // Setting a default EventsManager
        $modelsManager = new CollectionManager();

        $modelsManager->setEventsManager($eventsManager);

        return $modelsManager;
    },
    true
);
```

<a name='business-rules'></a>

### Implementing a Business Rule

When an insert, update or delete is executed, the model verifies if there are any methods with the names of the events listed in the table above.

We recommend that validation methods are declared protected to prevent that business logic implementation from being exposed publicly.

The following example implements an event that validates the year cannot be smaller than 0 on update or insert:

```php
<?php

use Phalcon\Mvc\Collection;

class Robots extends Collection
{
    public function beforeSave()
    {
        if ($this->year < 0) {
            echo 'Year cannot be smaller than zero!';

            return false;
        }
    }
}
```

Some events return false as an indication to stop the current operation. If an event doesn't return anything, `Phalcon\Mvc\Collection` will assume a true value.

<a name='data-integrity'></a>

### Validating Data Integrity

`Phalcon\Mvc\Collection` provides several events to validate data and implement business rules. The special `validation` event allows us to call built-in validators over the record. Phalcon exposes a few built-in validators that can be used at this stage of validation.

The following example shows how to use it:

```php
<?php

use Phalcon\Mvc\Collection;
use Phalcon\Validation;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Numericality;

class Robots extends Collection
{
    public function validation()
    {
        $validation = new Validation();

        $validation->add(
            'type',
            new InclusionIn(
                [
                    'message' => 'Type must be: mechanical or virtual',
                    'domain' => [
                        'Mechanical',
                        'Virtual',
                    ],
                ]
            )
        );

        $validation->add(
            'price',
            new Numericality(
                [
                    'message' => 'Price must be numeric'
                ]
            )
        );

        return $this->validate($validation);
    }
}
```

The example given above performs a validation using the built-in validator `InclusionIn`. It checks the value of the field `type` in a domain list. If the value is not included in the method, then the validator will fail and return false.

<h5 class='alert alert-warning'>For more information on validators, see the <a href="/[[language]]/[[version]]/validation">Validation documentation</a> </h5>

<a name='deleting-records'></a>

## Deleting Records

The `Phalcon\Mvc\Collection::delete()` method allows you to delete a document. You can use it as follows:

```php
<?php

$robot = Robots::findFirst();

if ($robot !== false) {
    if ($robot->delete() === false) {
        echo "Sorry, we can't delete the robot right now: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo 'The robot was deleted successfully!';
    }
}
```

You can also delete many documents by traversing a resultset with a `foreach` loop:

```php
<?php

$robots = Robots::find(
    [
        [
            'type' => 'mechanical',
        ]
    ]
);

foreach ($robots as $robot) {
    if ($robot->delete() === false) {
        echo "Sorry, we can't delete the robot right now: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo 'The robot was deleted successfully!';
    }
}
```

The following events are available to define custom business rules that can be executed when a delete operation is performed:

| Operation | Name           | Can stop operation? | Explanation                              |
| --------- | -------------- | ------------------- | ---------------------------------------- |
| Deleting  | `beforeDelete` | YES                 | Runs before the delete operation is made |
| Deleting  | `afterDelete`  | NO                  | Runs after the delete operation was made |

<a name='validation-failed-events'></a>

## Validation Failed Events

Another type of events is available when the data validation process finds any inconsistency:

| Operation                | Name                | Explanation                                                     |
| ------------------------ | ------------------- | --------------------------------------------------------------- |
| Insert or Update         | `notSave`           | Triggered when the insert/update operation fails for any reason |
| Insert, Delete or Update | `onValidationFails` | Triggered when any data manipulation operation fails            |

<a name='ids-vs-primary-keys'></a>

## Örtülü Kimliklere karşılık Öncelikli Kullanıcı Anahtarları

By default `Phalcon\Mvc\Collection` assumes that the `_id` attribute is automatically generated using [MongoIds](http://www.php.net/manual/en/class.mongoid.php).

If a model uses custom primary keys this behavior can be overridden:

```php
<?php

use Phalcon\Mvc\Collection;

class Robots extends Collection
{
    public function initialize()
    {
        $this->useImplicitObjectIds(false);
    }
}
```

<a name='multiple-databases'></a>

## Setting multiple databases

In Phalcon, all models can belong to the same database connection or have an individual one. Actually, when `Phalcon\Mvc\Collection` needs to connect to the database it requests the `mongo` service in the application's services container. You can overwrite this service setting it in the initialize method:

```php
<?php

// This service returns a mongo database at 192.168.1.100
$di->set(
    'mongo1',
    function () {
        $mongo = new MongoClient(
            'mongodb://scott:nekhen@192.168.1.100'
        );

        return $mongo->selectDB('management');
    },
    true
);

// This service returns a mongo database at localhost
$di->set(
    'mongo2',
    function () {
        $mongo = new MongoClient(
            'mongodb://localhost'
        );

        return $mongo->selectDB('invoicing');
    },
    true
);
```

Then, in the `initialize()` method, we define the connection service for the model:

```php
<?php

use Phalcon\Mvc\Collection;

class Robots extends Collection
{
    public function initialize()
    {
        $this->setConnectionService('mongo1');
    }
}
```

<a name='services-in-models'></a>

## Injecting services into Models

You may be required to access the application services within a model, the following example explains how to do that:

```php
<?php

use Phalcon\Mvc\Collection;

class Robots extends Collection
{
    public function notSave()
    {
        // Obtain the flash service from the DI container
        $flash = $this->getDI()->getShared('flash');

        $messages = $this->getMessages();

        // Show validation messages
        foreach ($messages as $message) {
            $flash->error(
                (string) $message
            );
        }
    }
}
```

The `notSave` event is triggered whenever a `creating` or `updating` action fails. We're flashing the validation messages obtaining the `flash` service from the DI container. By doing this, we don't have to print messages after each saving.