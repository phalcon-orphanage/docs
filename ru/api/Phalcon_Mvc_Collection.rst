Abstract class **Phalcon\\Mvc\\Collection**
===========================================

*implements* :doc:`Phalcon\\Mvc\\EntityInterface <Phalcon_Mvc_EntityInterface>`, :doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, `Serializable <http://php.net/manual/en/class.serializable.php>`_

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/collection.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This component implements a high level abstraction for NoSQL databases which
works with documents


Constants
---------

*integer* **OP_NONE**

*integer* **OP_CREATE**

*integer* **OP_UPDATE**

*integer* **OP_DELETE**

*integer* **DIRTY_STATE_PERSISTENT**

*integer* **DIRTY_STATE_TRANSIENT**

*integer* **DIRTY_STATE_DETACHED**

Methods
-------

final public  **__construct** ([:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector], [:doc:`Phalcon\\Mvc\\Collection\\ManagerInterface <Phalcon_Mvc_Collection_ManagerInterface>` $modelsManager])

Phalcon\\Mvc\\Collection constructor



public  **setId** (*mixed* $id)

Sets a value for the _id property, creates a MongoId object if needed



public *MongoId* **getId** ()

Returns the value of the _id property



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injection container



public  **getDI** ()

Returns the dependency injection container



protected  **setEventsManager** (:doc:`Phalcon\\Mvc\\Collection\\ManagerInterface <Phalcon_Mvc_Collection_ManagerInterface>` $eventsManager)

Sets a custom events manager



protected  **getEventsManager** ()

Returns the custom events manager



public  **getCollectionManager** ()

Returns the models manager related to the entity instance



public  **getReservedAttributes** ()

Returns an array with reserved properties that cannot be part of the insert/update



protected  **useImplicitObjectIds** (*mixed* $useImplicitObjectIds)

Sets if a model must use implicit objects ids



protected  **setSource** (*mixed* $source)

Sets collection name which model should be mapped



public  **getSource** ()

Returns collection name mapped in the model



public  **setConnectionService** (*mixed* $connectionService)

Sets the DependencyInjection connection service name



public  **getConnectionService** ()

Returns DependencyInjection connection service



public *MongoDb* **getConnection** ()

Retrieves a database connection



public *mixed* **readAttribute** (*string* $attribute)

Reads an attribute value by its name

.. code-block:: php

    <?php

    echo $robot->readAttribute("name");




public  **writeAttribute** (*string* $attribute, *mixed* $value)

Writes an attribute value by its name

.. code-block:: php

    <?php

    $robot->writeAttribute("name", "Rosey");




public static  **cloneResult** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $collection, *array* $document)

Returns a cloned collection



protected static *array* **_getResultset** (*array* $params, :doc:`Phalcon\\Mvc\\Collection <Phalcon_Mvc_Collection>` $collection, *MongoDb* $connection, *boolean* $unique)

Returns a collection resultset



protected static *int* **_getGroupResultset** (*array* $params, :doc:`Phalcon\\Mvc\\Collection <Phalcon_Mvc_Collection>` $collection, *MongoDb* $connection)

Perform a count over a resultset



final protected *boolean* **_preSave** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector, *boolean* $disableEvents, *boolean* $exists)

Executes internal hooks before save a document



final protected  **_postSave** (*mixed* $disableEvents, *mixed* $success, *mixed* $exists)

Executes internal events after save a document



protected  **validate** (*mixed* $validator)

Executes validators on every validation call

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Validator\ExclusionIn as ExclusionIn;

    class Subscriptors extends \Phalcon\Mvc\Collection
    {
        public function validation()
        {
            // Old, deprecated syntax, use new one below
            $this->validate(
                new ExclusionIn(
                    [
                        "field"  => "status",
                        "domain" => ["A", "I"],
                    ]
                )
            );

            if ($this->validationHasFailed() == true) {
                return false;
            }
        }
    }

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\ExclusionIn as ExclusionIn;
    use Phalcon\Validation;

    class Subscriptors extends \Phalcon\Mvc\Collection
    {
        public function validation()
        {
            $validator = new Validation();
            $validator->add("status",
                new ExclusionIn(
                    [
                        "domain" => ["A", "I"]
                    ]
                )
            );

            return $this->validate($validator);
        }
    }




public  **validationHasFailed** ()

Check whether validation process has generated any messages

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Validator\ExclusionIn as ExclusionIn;

    class Subscriptors extends \Phalcon\Mvc\Collection
    {
        public function validation()
        {
            $this->validate(
                new ExclusionIn(
                    [
                        "field"  => "status",
                        "domain" => ["A", "I"],
                    ]
                )
            );

            if ($this->validationHasFailed() == true) {
                return false;
            }
        }
    }




public  **fireEvent** (*mixed* $eventName)

Fires an internal event



public  **fireEventCancel** (*mixed* $eventName)

Fires an internal event that cancels the operation



protected  **_cancelOperation** (*mixed* $disableEvents)

Cancel the current operation



protected *boolean* **_exists** (*MongoCollection* $collection)

Checks if the document exists in the collection



public  **getMessages** ()

Returns all the validation messages

.. code-block:: php

    <?php

    $robot = new Robots();

    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;

    if ($robot->save() === false) {
        echo "Umh, We can't store robots right now ";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message;
        }
    } else {
        echo "Great, a new robot was saved successfully!";
    }




public  **appendMessage** (:doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>` $message)

Appends a customized message on the validation process

.. code-block:: php

    <?php

    use \Phalcon\Mvc\Model\Message as Message;

    class Robots extends \Phalcon\Mvc\Model
    {
        public function beforeSave()
        {
            if ($this->name === "Peter") {
                $message = new Message(
                    "Sorry, but a robot cannot be named Peter"
                );

                $this->appendMessage(message);
            }
        }
    }




protected  **prepareCU** ()

Shared Code for CU Operations
Prepares Collection



public  **save** ()

Creates/Updates a collection based on the values in the attributes



public  **create** ()

Creates a collection based on the values in the attributes



public  **createIfNotExist** (*array* $criteria)

Creates a document based on the values in the attributes, if not found by criteria
Preferred way to avoid duplication is to create index on attribute

.. code-block:: php

    <?php

    $robot = new Robot();

    $robot->name = "MyRobot";
    $robot->type = "Droid";

    // Create only if robot with same name and type does not exist
    $robot->createIfNotExist(
        [
            "name",
            "type",
        ]
    );




public  **update** ()

Creates/Updates a collection based on the values in the attributes



public static  **findById** (*mixed* $id)

Find a document by its id (_id)

.. code-block:: php

    <?php

    // Find user by using \MongoId object
    $user = Users::findById(
        new \MongoId("545eb081631d16153a293a66")
    );

    // Find user by using id as sting
    $user = Users::findById("45cbc4a0e4123f6920000002");

    // Validate input
    if ($user = Users::findById($_POST["id"])) {
        // ...
    }




public static  **findFirst** ([*array* $parameters])

Allows to query the first record that match the specified conditions

.. code-block:: php

    <?php

    // What's the first robot in the robots table?
    $robot = Robots::findFirst();

    echo "The robot name is ", $robot->name, "\n";

    // What's the first mechanical robot in robots table?
    $robot = Robots::findFirst(
        [
            [
                "type" => "mechanical",
            ]
        ]
    );

    echo "The first mechanical robot name is ", $robot->name, "\n";

    // Get first virtual robot ordered by name
    $robot = Robots::findFirst(
        [
            [
                "type" => "mechanical",
            ],
            "order" => [
                "name" => 1,
            ],
        ]
    );

    echo "The first virtual robot name is ", $robot->name, "\n";

    // Get first robot by id (_id)
    $robot = Robots::findFirst(
        [
            [
                "_id" => new \MongoId("45cbc4a0e4123f6920000002"),
            ]
        ]
    );

    echo "The robot id is ", $robot->_id, "\n";




public static  **find** ([*array* $parameters])

Allows to query a set of records that match the specified conditions

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

    echo "There are ", count(robots), "\n";

    // Get and print virtual robots ordered by name
    $robots = Robots::findFirst(
        [
            [
                "type" => "virtual"
            ],
            "order" => [
                "name" => 1,
            ]
        ]
    );

    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

    // Get first 100 virtual robots ordered by name
    $robots = Robots::find(
        [
            [
                "type" => "virtual",
            ],
            "order" => [
                "name" => 1,
            ],
            "limit" => 100,
        ]
    );

    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }




public static  **count** ([*array* $parameters])

Perform a count over a collection

.. code-block:: php

    <?php

    echo "There are ", Robots::count(), " robots";




public static  **aggregate** ([*array* $parameters])

Perform an aggregation using the Mongo aggregation framework



public static  **summatory** (*mixed* $field, [*mixed* $conditions], [*mixed* $finalize])

Allows to perform a summatory group for a column in the collection



public  **delete** ()

Deletes a model instance. Returning true on success or false otherwise.

.. code-block:: php

    <?php

    $robot = Robots::findFirst();

    $robot->delete();

    $robots = Robots::find();

    foreach ($robots as $robot) {
        $robot->delete();
    }




public  **setDirtyState** (*mixed* $dirtyState)

Sets the dirty state of the object using one of the DIRTY_STATE_* constants



public  **getDirtyState** ()

Returns one of the DIRTY_STATE_* constants telling if the document exists in the collection or not



protected  **addBehavior** (:doc:`Phalcon\\Mvc\\Collection\\BehaviorInterface <Phalcon_Mvc_Collection_BehaviorInterface>` $behavior)

Sets up a behavior in a collection



public  **skipOperation** (*mixed* $skip)

Skips the current operation forcing a success state



public  **toArray** ()

Returns the instance as an array representation

.. code-block:: php

    <?php

    print_r(
        $robot->toArray()
    );




public  **serialize** ()

Serializes the object ignoring connections or protected properties



public  **unserialize** (*mixed* $data)

Unserializes the object from a serialized string



