---
layout: article
language: 'id-id'
version: '4.0'
---
**This article reflects v3.4 and has not yet been revised**

<h5 class='alert alert-info'>Please note that if you are using the Mongo driver provided by PHP 7, the ODM will not work for you. There is an incubator adapter but all the Mongo code must be rewritten (new Bson type instead of arrays, no MongoId, no MongoDate, etc...). Please ensure that you test your code before upgrading to PHP 7 and/or Phalcon 3+</h5>

<a name='overview'></a>

# ODM (Object-Document Mapper)

In addition to its ability to [map tables](/4.0/en/models) in relational databases, Phalcon can map documents from NoSQL databases. The ODM offers a CRUD functionality, events, validations among other services.

Due to the absence of SQL queries and planners, NoSQL databases can see real improvements in performance using the Phalcon approach. Additionally, there are no SQL building reducing the possibility of SQL injections.

The following NoSQL databases are supported:

| Nama                                | Deskripsi                                                                               |
| ----------------------------------- | --------------------------------------------------------------------------------------- |
| [MongoDB](https://www.mongodb.org/) | MongoDB adalah database open source NoSQL yang berkinerja tinggi dan berkinerja tinggi. |

<a name='creating-models'></a>

## Membuat Model

A model is a class that extends from [Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection). It must be placed in the models directory. A model file must contain a single class; its class name should be in camel case notation:

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

## Memahami Dokumen Untuk Objek

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

## Model di Namespaces

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

Begitu catatan di memori, anda dapat melakukan modifikasi terhadap datanya dan kemudian menyimpan perubahan:

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

## Mengatur Koneksi

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

## Mencari Dokumen

As [Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection) relies on the Mongo PHP extension you have the same facilities to query documents and convert them transparently to model instances:

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

Anda juga bisa menggunakan `findFirst()` metode untuk mendapatkan rekaman pertama yang sesuai dengan kriteria yang diberikan:

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

// Find all robots that have more than 4 friends using the where condition
$robots = Robots::find(
    [
        'conditions' => [
            '$where' => 'this.friends.length > 4',
        ]
    ]
);
```

Pilihan permintaan yang tersedia adalah:

| Parameter    | Deskripsi                                                                                                                                                                                 | Contoh                                                  |
| ------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------- |
| `kondisi`    | Cari kondisi untuk operasi pencarian. Digunakan hanya untuk mengekstrak catatan yang memenuhi kriteria tertentu. By default Phalcon_model assumes the first parameter are the conditions. | `'conditions' => array('$gt' => 1990)`            |
| `ladang`     | Returns specific columns instead of the full fields in the collection. When using this option an incomplete object is returned                                                            | `'fields' => array('name' => true)`               |
| `menyortir`  | It's used to sort the resultset. Use one or more fields as each element in the array, 1 means ordering upwards, -1 downward                                                               | `'sort' => array('name' => -1, 'status' => 1)` |
| `batas`      | Batasi hasil query untuk menghasilkan rentang tertentu                                                                                                                                    | `'batas' => 10`                                      |
| `melewatkan` | Melewati sejumlah hasil                                                                                                                                                                   | `'skip' => 50`                                       |

If you have experience with SQL databases, you may want to check the [SQL to Mongo Mapping Chart](https://secure.php.net/manual/en/mongo.sqltomongo.php).

<a name='finding-documents-fields'></a>

## Query bidang spesifik

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

A model can return calculations using [aggregation framework](https://docs.mongodb.org/manual/applications/aggregation/) provided by Mongo. The aggregated values are calculate without having to use MapReduce. With this option is easy perform tasks such as totaling or averaging field values:

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

The `Phalcon\Mvc\Collection::save()` method allows you to create/update documents according to whether they already exist in the collection associated with a model. The `save()` method is called internally by the create and update methods of [Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection).

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

The `_id` property is automatically updated with the [MongoId](https://secure.php.net/manual/en/class.mongoid.php) object created by the driver:

```php
<?php

$robot->save();

echo 'The generated id is: ', $robot->getId();
```

<a name='validation-messages'></a>

### Pesan validasi

[Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection) has a messaging subsystem that provides a flexible way to output or store the validation messages generated during the insert/update processes.

Each message consists of an instance of the class [Phalcon\Mvc\Model\Message](api/Phalcon_Mvc_Model_Message). The set of messages generated can be retrieved with the method getMessages(). Setiap pesan memberikan informasi tambahan seperti nama field yang menghasilkan pesan atau jenis pesan:

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

### Validasi Acara dan Event Manager

Models allow you to implement events that will be thrown when performing an insert or update. They help define business rules for a certain model. The following are the events supported by [Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection) and their order of execution:

| Operasi             | Nama                            | Bisa berhenti operasinya? | Penjelasan                                                                                                        |
| ------------------- | ------------------------------- | ------------------------- | ----------------------------------------------------------------------------------------------------------------- |
| Masukkan/perbaharui | `sebelumValidasi`               | YA                        | Dilakukan sebelum proses validasi dan insert/update terakhir ke database                                          |
| Memasukkan          | `sebelumPengesahanPadaBuat`     | YA                        | Dilakukan sebelum proses validasi hanya saat operasi penyisipan sedang dilakukan                                  |
| Memperbarui         | `sebelumPengesahanDiPerbaharui` | YA                        | Dieksekusi sebelum bidang divalidasi untuk tidak nulls atau foreign key saat operasi update sedang dilakukan      |
| Masukkan/perbaharui | `padaPengesahanGagal`           | YA (sudah berhenti)       | Dilakukan sebelum proses validasi hanya saat operasi penyisipan sedang dilakukan                                  |
| Memasukkan          | `setelahPengesahanPadaBuat`     | YA                        | Dilakukan setelah proses validasi saat operasi penyisipan sedang dilakukan                                        |
| Memperbarui         | `setelahPengesahanDiUpdate`     | YA                        | Dilakukan setelah proses validasi saat operasi update sedang dilakukan                                            |
| Masukkan/perbaharui | `setelahPengesahan`             | YA                        | Dilakukan setelah proses validasi                                                                                 |
| Masukkan/perbaharui | `sebelumdisimpan`               | YA                        | Berjalan sebelum operasi yang diperlukan dari database sistem                                                     |
| Memperbarui         | `sebelummemperbarui`            | YA                        | Berjalan sebelum operasi yang diperlukan melalui sistem basis data hanya bila operasi update sedang dilakukan     |
| Memasukkan          | `sebelummembuat`                | YA                        | Berjalan sebelum operasi yang diperlukan melalui sistem basis data hanya saat operasi penyisipan dilakukan        |
| Memperbarui         | `afterUpdate`                   | NO                        | Berjalan setelah operasi yang diperlukan melalui sistem basis data hanya saat operasi update sedang dilakukan     |
| Memasukkan          | `afterCreate`                   | NO                        | Berjalan setelah operasi yang diperlukan melalui sistem basis data hanya saat operasi penyisipan sedang dilakukan |
| Masukkan/perbaharui | `afterSave`                     | NO                        | Berjalan setelah operasi yang diperlukan melalui sistem database                                                  |

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

Additionally, this component is integrated with the [Phalcon Events Manager](/4.0/en/events) ([Phalcon\Events\Manager](api/Phalcon_Events_Manager)), this means we can create listeners that run when an event is triggered.

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
    protected function beforeSave()
    {
        if ($this->year < 0) {
            echo 'Year cannot be smaller than zero!';

            return false;
        }
    }
}
```

Some events return `false` as an indication to stop the current operation. If an event doesn't return anything, `Phalcon\Mvc\Collection` will assume a `true` value.

<a name='data-integrity'></a>

### Memvalidasi Integritas Data

[Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection) provides several events to validate data and implement business rules. Khusus `validasi` acara ini memungkinkan kita untuk memanggil built-in validator selama merekam. Phalcon memaparkan beberapa validator bawaan yang dapat digunakan pada tahap validasi ini.

Contoh berikut menunjukkan bagaimana cara menggunakannya:

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

The example above performs a validation using the built-in validator `InclusionIn`. It checks that the value of the field `type` is in a `domain` list. If the value is not included in the list, then the validator will fail and return `false`.

<h5 class='alert alert-warning'>For more information on validators, see the <a href="/4.0/en/validation">Validation documentation</a> </h5>

<a name='deleting-records'></a>

## Menghapus catatan

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

Peristiwa berikut tersedia untuk menentukan aturan bisnis khusus yang dapat dijalankan saat operasi hapus dilakukan:

| Operasi      | Nama           | Bisa berhenti operasinya? | Penjelasan                               |
| ------------ | -------------- | ------------------------- | ---------------------------------------- |
| Menghapuskan | `beforeDelete` | YA                        | Berjalan sebelum operasi hapus dilakukan |
| Menghapuskan | `afterDelete`  | NO                        | Berjalan setelah operasi hapus dilakukan |

<a name='validation-failed-events'></a>

## Validasi Gagal

Another type of events is available when the data validation process finds any inconsistency:

| Operasi                       | Nama                  | Penjelasan                                                       |
| ----------------------------- | --------------------- | ---------------------------------------------------------------- |
| Sisipkan atau Perbarui        | `notSave`             | Dipicu saat penyisipan/update operasi gagal dengan alasan apapun |
| Sisipkan, Hapus atau Perbarui | `padaPengesahanGagal` | Dipicu saat operasi manipulasi data gagal                        |

<a name='ids-vs-primary-keys'></a>

## Implicit Ids vs. User Primary Keys

By default [Phalcon\Mvc\Collection](api/Phalcon_Mvc_Collection) assumes that the `_id` attribute is automatically generated using [MongoIds](https://secure.php.net/manual/en/class.mongoid.php).

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

## Menetapkan beberapa database

In Phalcon, all models can share the same database connection or specify a connection per model. Actually, when `Phalcon\Mvc\Collection` needs to connect to the database it requests the `mongo` service in the application's services container. You can overwrite this service by setting it in the `initialize()` method:

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

## Menyuntikkan layanan ke dalam Model

Anda mungkin diminta untuk mengakses layanan aplikasi dalam model, contoh berikut menjelaskan cara melakukannya:

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