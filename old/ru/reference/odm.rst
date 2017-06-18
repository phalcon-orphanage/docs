ODM (Object-Document Mapper)
============================

В дополнение к его способности :doc:`отображать таблицы <models>` в реляционных базах данных, Phalcon может отображать документы из баз данных NoSQL.
ODM предлагает функциональность CRUD, события, валидацию и другие сервисы.

Из-за отсутствия запросов SQL и проектировщиков в базах данных NoSQL, вы можете увидеть реальные улучшения в
производительности, используя подход Phalcon.
Кроме того, NoSQL конструкци уменьшают возможность  SQL инъекций.

Поддерживаются следующие базы данных NoSQL:

+------------+----------------------------------------------------------------------------------------+
| Name       | Description                                                                            |
+============+========================================================================================+
| MongoDB_   | MongoDB - масштабируемая, высоко-производительная NoSQL БД, с открытым исходным кодом. |
+------------+----------------------------------------------------------------------------------------+

Создание моделей
----------------
Модель - класс, который расширяет :doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>`.
Он должен быть помещен в каталог моделей. Файл модели должен содержать только один класс.
Его имя класса должно быть записано в верблюжачей нотации:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;

    class Robots extends Collection
    {

    }

.. highlights::

    Если вы используете PHP 5.4 / 5.5, рекомендуется объявить каждый столбец, создаваемый в модели,
    чтобы сохранить память и уменьшить выделение памяти.

По умолчанию модель “Robots” будет ссылаться на “robots”. Если вы хотите вручную указать другое имя для отображения коллекции,
вы можете использовать :code:`setSource()` метод:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;

    class Robots extends Collection
    {
        public function initialize()
        {
            $this->setSource("the_robots");
        }
    }

Понимание Документов как Объектов
---------------------------------
Каждый экземпляр модели представляет документ в коллекции. Вы можете легко получить доступ к коллекции данных путем считывания свойств объекта.
Например, для коллекции "robots" с документами:

.. code-block:: bash

    $ mongo test
    MongoDB shell version: 1.8.2
    connecting to: test
    > db.robots.find()
    { "_id" : ObjectId("508735512d42b8c3d15ec4e1"), "name" : "Astro Boy", "year" : 1952,
        "type" : "mechanical" }
    { "_id" : ObjectId("5087358f2d42b8c3d15ec4e2"), "name" : "Bender", "year" : 1999,
        "type" : "mechanical" }
    { "_id" : ObjectId("508735d32d42b8c3d15ec4e3"), "name" : "Wall-E", "year" : 2008 }
    >

Модели в пространствах имен
---------------------------
Пространства имен могут быть использованы для того, чтобы избежать колизий имен классов. В этом случае необходимо указать имя соответствующей колекции, используя :code:`setSource()`:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Collection;

    class Robots extends Collection
    {
        public function initialize()
        {
            $this->setSource("robots");
        }
    }

Вы можете найти определенный документ, его ID, а затем распечатать его имя:

.. code-block:: php

    <?php

    // Найти запись с _id = "5087358f2d42b8c3d15ec4e2"
    $robot = Robots::findById("5087358f2d42b8c3d15ec4e2");

    // Напечатать "Bender"
    echo $robot->name;

После записи в память, вы можете вносить изменения в свои данные и сохранить изменения:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(
        [
            [
                "name" => "Astro Boy",
            ]
        ]
    );

    $robot->name = "Voltron";

    $robot->save();

Setting a Connection
--------------------
Connections are retrieved from the services container. By default, Phalcon tries to find the connection in a service called "mongo":

.. code-block:: php

    <?php

    // Simple database connection to localhost
    $di->set(
        "mongo",
        function () {
            $mongo = new MongoClient();

            return $mongo->selectDB("store");
        },
        true
    );

    // Connecting to a domain socket, falling back to localhost connection
    $di->set(
        "mongo",
        function () {
            $mongo = new MongoClient(
                "mongodb:///tmp/mongodb-27017.sock,localhost:27017"
            );

            return $mongo->selectDB("store");
        },
        true
    );

Finding Documents
-----------------
As :doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>` relies on the Mongo PHP extension you have the same facilities
to query documents and convert them transparently to model instances:

.. code-block:: php

    <?php

    // How many robots are there?
    $robots = Robots::find();
    echo "There are ", count($robots), "\n";

    // How many mechanical robots are there?
    $robots = Robots::find(
        [
            [
                "type" => "mechanical",
            ]
        ]
    );
    echo "There are ", count($robots), "\n";

    // Get and print mechanical robots ordered by name upward
    $robots = Robots::find(
        [
            [
                "type" => "mechanical",
            ],
            "sort" => [
                "name" => 1,
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
                "type" => "mechanical",
            ],
            "sort"  => [
                "name" => 1,
            ],
            "limit" => 100,
        ]
    );

    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

You could also use the :code:`findFirst()` method to get only the first record matching the given criteria:

.. code-block:: php

    <?php

    // What's the first robot in robots collection?
    $robot = Robots::findFirst();
    echo "The robot name is ", $robot->name, "\n";

    // What's the first mechanical robot in robots collection?
    $robot = Robots::findFirst(
        [
            [
                "type" => "mechanical",
            ]
        ]
    );
    echo "The first mechanical robot name is ", $robot->name, "\n";

Both :code:`find()` and :code:`findFirst()` methods accept an associative array specifying the search criteria:

.. code-block:: php

    <?php

    // First robot where type = "mechanical" and year = "1999"
    $robot = Robots::findFirst(
        [
            "conditions" => [
                "type" => "mechanical",
                "year" => "1999",
            ],
        ]
    );

    // All virtual robots ordered by name downward
    $robots = Robots::find(
        [
            "conditions" => [
                "type" => "virtual",
            ],
            "sort" => [
                "name" => -1,
            ],
        ]
    );

The available query options are:

+--------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------+
| Parameter          | Description                                                                                                                                                                                  | Example                                              |
+====================+==============================================================================================================================================================================================+======================================================+
| :code:`conditions` | Search conditions for the find operation. Is used to extract only those records that fulfill a specified criterion. By default Phalcon_model assumes the first parameter are the conditions. | :code:`"conditions" => array('$gt' => 1990)`         |
+--------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------+
| :code:`fields`     | Returns specific columns instead of the full fields in the collection. When using this option an incomplete object is returned                                                               | :code:`"fields" => array('name' => true)`            |
+--------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------+
| :code:`sort`       | It's used to sort the resultset. Use one or more fields as each element in the array, 1 means ordering upwards, -1 downward                                                                  | :code:`"sort" => array("name" => -1, "status" => 1)` |
+--------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------+
| :code:`limit`      | Limit the results of the query to results to certain range                                                                                                                                   | :code:`"limit" => 10`                                |
+--------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------+
| :code:`skip`       | Skips a number of results                                                                                                                                                                    | :code:`"skip" => 50`                                 |
+--------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------+

If you have experience with SQL databases, you may want to check the `SQL to Mongo Mapping Chart`_.

Aggregations
------------
A model can return calculations using `aggregation framework`_ provided by Mongo. The aggregated values are calculate without having to use MapReduce.
With this option is easy perform tasks such as totaling or averaging field values:

.. code-block:: php

    <?php

    $data = Article::aggregate(
        [
            [
                "\$project" => [
                    "category" => 1,
                ],
            ],
            [
                "\$group" => [
                    "_id" => [
                        "category" => "\$category"
                    ],
                    "id"  => [
                        "\$max" => "\$_id",
                    ],
                ],
            ],
        ]
    );

Creating Updating/Records
-------------------------
The :code:`Phalcon\Mvc\Collection::save()` method allows you to create/update documents according to whether they already exist in the collection
associated with a model. The :code:`save()` method is called internally by the create and update methods of :doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>`.

Also the method executes associated validators and events that are defined in the model:

.. code-block:: php

    <?php

    $robot = new Robots();

    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;

    if ($robot->save() === false) {
        echo "Umh, We can't store robots right now: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo "Great, a new robot was saved successfully!";
    }

The "_id" property is automatically updated with the MongoId_ object created by the driver:

.. code-block:: php

    <?php

    $robot->save();

    echo "The generated id is: ", $robot->getId();

Validation Messages
^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>` has a messaging subsystem that provides a flexible way to output or store the
validation messages generated during the insert/update processes.

Each message consists of an instance of the class :doc:`Phalcon\\Mvc\\Model\\Message <../api/Phalcon_Mvc_Model_Message>`. The set of
messages generated can be retrieved with the method getMessages(). Each message provides extended information like the field name that
generated the message or the message type:

.. code-block:: php

    <?php

    if ($robot->save() === false) {
        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo "Message: ", $message->getMessage();
            echo "Field: ", $message->getField();
            echo "Type: ", $message->getType();
        }
    }

Validation Events and Events Manager
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Models allow you to implement events that will be thrown when performing an insert or update. They help define business rules for a
certain model. The following are the events supported by :doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>` and their order of execution:

+--------------------+----------------------------------+-----------------------+--------------------------------------------------------------------------------------------------------------------+
| Operation          | Name                             | Can stop operation?   | Explanation                                                                                                        |
+====================+==================================+=======================+====================================================================================================================+
| Inserting/Updating | :code:`beforeValidation`         | YES                   | Is executed before the validation process and the final insert/update to the database                              |
+--------------------+----------------------------------+-----------------------+--------------------------------------------------------------------------------------------------------------------+
| Inserting          | :code:`beforeValidationOnCreate` | YES                   | Is executed before the validation process only when an insertion operation is being made                           |
+--------------------+----------------------------------+-----------------------+--------------------------------------------------------------------------------------------------------------------+
| Updating           | :code:`beforeValidationOnUpdate` | YES                   | Is executed before the fields are validated for not nulls or foreign keys when an updating operation is being made |
+--------------------+----------------------------------+-----------------------+--------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | :code:`onValidationFails`        | YES (already stopped) | Is executed before the validation process only when an insertion operation is being made                           |
+--------------------+----------------------------------+-----------------------+--------------------------------------------------------------------------------------------------------------------+
| Inserting          | :code:`afterValidationOnCreate`  | YES                   | Is executed after the validation process when an insertion operation is being made                                 |
+--------------------+----------------------------------+-----------------------+--------------------------------------------------------------------------------------------------------------------+
| Updating           | :code:`afterValidationOnUpdate`  | YES                   | Is executed after the validation process when an updating operation is being made                                  |
+--------------------+----------------------------------+-----------------------+--------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | :code:`afterValidation`          | YES                   | Is executed after the validation process                                                                           |
+--------------------+----------------------------------+-----------------------+--------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | :code:`beforeSave`               | YES                   | Runs before the required operation over the database system                                                        |
+--------------------+----------------------------------+-----------------------+--------------------------------------------------------------------------------------------------------------------+
| Updating           | :code:`beforeUpdate`             | YES                   | Runs before the required operation over the database system only when an updating operation is being made          |
+--------------------+----------------------------------+-----------------------+--------------------------------------------------------------------------------------------------------------------+
| Inserting          | :code:`beforeCreate`             | YES                   | Runs before the required operation over the database system only when an inserting operation is being made         |
+--------------------+----------------------------------+-----------------------+--------------------------------------------------------------------------------------------------------------------+
| Updating           | :code:`afterUpdate`              | NO                    | Runs after the required operation over the database system only when an updating operation is being made           |
+--------------------+----------------------------------+-----------------------+--------------------------------------------------------------------------------------------------------------------+
| Inserting          | :code:`afterCreate`              | NO                    | Runs after the required operation over the database system only when an inserting operation is being made          |
+--------------------+----------------------------------+-----------------------+--------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | :code:`afterSave`                | NO                    | Runs after the required operation over the database system                                                         |
+--------------------+----------------------------------+-----------------------+--------------------------------------------------------------------------------------------------------------------+

To make a model to react to an event, we must to implement a method with the same name of the event:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;

    class Robots extends Collection
    {
        public function beforeValidationOnCreate()
        {
            echo "This is executed before creating a Robot!";
        }
    }

Events can be useful to assign values before performing an operation, for example:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;

    class Products extends Collection
    {
        public function beforeCreate()
        {
            // Set the creation date
            $this->created_at = date("Y-m-d H:i:s");
        }

        public function beforeUpdate()
        {
            // Set the modification date
            $this->modified_in = date("Y-m-d H:i:s");
        }
    }

Additionally, this component is integrated with :doc:`Phalcon\\Events\\Manager <events>`, this means we can create
listeners that run when an event is triggered.

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    $eventsManager = new EventsManager();

    // Attach an anonymous function as a listener for "model" events
    $eventsManager->attach(
        "collection:beforeSave",
        function (Event $event, $robot) {
            if ($robot->name === "Scooby Doo") {
                echo "Scooby Doo isn't a robot!";

                return false;
            }

            return true;
        }
    );

    $robot = new Robots();

    $robot->setEventsManager($eventsManager);

    $robot->name = "Scooby Doo";
    $robot->year = 1969;

    $robot->save();

In the example given above the EventsManager only acted as a bridge between an object and a listener (the anonymous function). If we want all
objects created in our application use the same EventsManager, then we need to assign this to the Models Manager:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Mvc\Collection\Manager as CollectionManager;

    // Registering the collectionManager service
    $di->set(
        "collectionManager",
        function () {
            $eventsManager = new EventsManager();

            // Attach an anonymous function as a listener for "model" events
            $eventsManager->attach(
                "collection:beforeSave",
                function (Event $event, $model) {
                    if (get_class($model) === "Robots") {
                        if ($model->name === "Scooby Doo") {
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

Implementing a Business Rule
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
When an insert, update or delete is executed, the model verifies if there are any methods with the names of the events listed in the table above.

We recommend that validation methods are declared protected to prevent that business logic implementation from being exposed publicly.

The following example implements an event that validates the year cannot be smaller than 0 on update or insert:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;

    class Robots extends Collection
    {
        public function beforeSave()
        {
            if ($this->year < 0) {
                echo "Year cannot be smaller than zero!";

                return false;
            }
        }
    }

Some events return false as an indication to stop the current operation. If an event doesn't return anything,
:doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>` will assume a true value.

Validating Data Integrity
^^^^^^^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>` provides several events to validate data and implement business rules. The special "validation"
event allows us to call built-in validators over the record. Phalcon exposes a few built-in validators that can be used at this stage of validation.

The following example shows how to use it:

.. code-block:: php

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
                "type",
                new InclusionIn(
                    [
                        "message" => "Type must be: mechanical or virtual",
                        "domain" => [
                            "Mechanical",
                            "Virtual",
                        ],
                    ]
                )
            );

            $validation->add(
                "price",
                new Numericality(
                    [
                        "message" => "Price must be numeric"
                    ]
                )
            );

            return $this->validate($validation);
        }
    }

The example given above performs a validation using the built-in validator "InclusionIn". It checks the value of the field "type" in a domain list. If
the value is not included in the method, then the validator will fail and return false.

.. highlights::

    For more information on validators, see the :doc:`Validation documentation <validation>`.

Deleting Records
----------------
The :code:`Phalcon\Mvc\Collection::delete()` method allows you to delete a document. You can use it as follows:

.. code-block:: php

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
            echo "The robot was deleted successfully!";
        }
    }

You can also delete many documents by traversing a resultset with a :code:`foreach` loop:

.. code-block:: php

    <?php

    $robots = Robots::find(
        [
            [
                "type" => "mechanical",
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
            echo "The robot was deleted successfully!";
        }
    }

The following events are available to define custom business rules that can be executed when a delete operation is performed:

+-----------+----------------------+---------------------+------------------------------------------+
| Operation | Name                 | Can stop operation? | Explanation                              |
+===========+======================+=====================+==========================================+
| Deleting  | :code:`beforeDelete` | YES                 | Runs before the delete operation is made |
+-----------+----------------------+---------------------+------------------------------------------+
| Deleting  | :code:`afterDelete`  | NO                  | Runs after the delete operation was made |
+-----------+----------------------+---------------------+------------------------------------------+

Validation Failed Events
------------------------
Another type of events is available when the data validation process finds any inconsistency:

+--------------------------+---------------------------+--------------------------------------------------------------------+
| Operation                | Name                      | Explanation                                                        |
+==========================+===========================+====================================================================+
| Insert or Update         | :code:`notSave`           | Triggered when the insert/update operation fails for any reason    |
+--------------------------+---------------------------+--------------------------------------------------------------------+
| Insert, Delete or Update | :code:`onValidationFails` | Triggered when any data manipulation operation fails               |
+--------------------------+---------------------------+--------------------------------------------------------------------+

Implicit Ids vs. User Primary Keys
----------------------------------
By default :doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>` assumes that the :code:`_id` attribute is automatically generated using MongoIds_.
If a model uses custom primary keys this behavior can be overridden:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;

    class Robots extends Collection
    {
        public function initialize()
        {
            $this->useImplicitObjectIds(false);
        }
    }

Setting multiple databases
--------------------------
In Phalcon, all models can belong to the same database connection or have an individual one. Actually, when
:doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>` needs to connect to the database it requests the "mongo" service
in the application's services container. You can overwrite this service setting it in the initialize method:

.. code-block:: php

    <?php

    // This service returns a mongo database at 192.168.1.100
    $di->set(
        "mongo1",
        function () {
            $mongo = new MongoClient(
                "mongodb://scott:nekhen@192.168.1.100"
            );

            return $mongo->selectDB("management");
        },
        true
    );

    // This service returns a mongo database at localhost
    $di->set(
        "mongo2",
        function () {
            $mongo = new MongoClient(
                "mongodb://localhost"
            );

            return $mongo->selectDB("invoicing");
        },
        true
    );

Then, in the :code:`initialize()` method, we define the connection service for the model:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;

    class Robots extends Collection
    {
        public function initialize()
        {
            $this->setConnectionService("mongo1");
        }
    }

Injecting services into Models
------------------------------
You may be required to access the application services within a model, the following example explains how to do that:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Collection;

    class Robots extends Collection
    {
        public function notSave()
        {
            // Obtain the flash service from the DI container
            $flash = $this->getDI()->getShared("flash");

            $messages = $this->getMessages();

            // Show validation messages
            foreach ($messages as $message) {
                $flash->error(
                    (string) $message
                );
            }
        }
    }

The "notSave" event is triggered whenever a "creating" or "updating" action fails. We're flashing the validation messages
obtaining the "flash" service from the DI container. By doing this, we don't have to print messages after each saving.

.. _MongoDB: http://www.mongodb.org/
.. _MongoId: http://www.php.net/manual/en/class.mongoid.php
.. _MongoIds: http://www.php.net/manual/en/class.mongoid.php
.. _`SQL to Mongo Mapping Chart`: http://www.php.net/manual/en/mongo.sqltomongo.php
.. _`aggregation framework`: http://docs.mongodb.org/manual/applications/aggregation/
