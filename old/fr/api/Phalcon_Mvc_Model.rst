Abstract class **Phalcon\\Mvc\\Model**
======================================

*implements* :doc:`Phalcon\\Mvc\\EntityInterface <Phalcon_Mvc_EntityInterface>`, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`, :doc:`Phalcon\\Mvc\\Model\\ResultInterface <Phalcon_Mvc_Model_ResultInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, `Serializable <http://php.net/manual/en/class.serializable.php>`_, `JsonSerializable <http://php.net/manual/en/class.jsonserializable.php>`_

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Phalcon\\Mvc\\Model connects business objects and database tables to create
a persistable domain model where logic and data are presented in one wrapping.
It‘s an implementation of the object-relational mapping (ORM).

A model represents the information (data) of the application and the rules to manipulate that data.
Models are primarily used for managing the rules of interaction with a corresponding database table.
In most cases, each table in your database will correspond to one model in your application.
The bulk of your application's business logic will be concentrated in the models.

Phalcon\\Mvc\\Model is the first ORM written in Zephir/C languages for PHP, giving to developers high performance
when interacting with databases while is also easy to use.

.. code-block:: php

    <?php

    $robot = new Robots();

    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;

    if ($robot->save() === false) {
        echo "Umh, We can store robots: ";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo message;
        }
    } else {
        echo "Great, a new robot was saved successfully!";
    }



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

final public  **__construct** ([*mixed* $data], [:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector], [:doc:`Phalcon\\Mvc\\Model\\ManagerInterface <Phalcon_Mvc_Model_ManagerInterface>` $modelsManager])

Phalcon\\Mvc\\Model constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injection container



public  **getDI** ()

Returns the dependency injection container



protected  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets a custom events manager



protected  **getEventsManager** ()

Returns the custom events manager



public  **getModelsMetaData** ()

Returns the models meta-data service related to the entity instance



public  **getModelsManager** ()

Returns the models manager related to the entity instance



public  **setTransaction** (:doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>` $transaction)

Sets a transaction related to the Model instance

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Transaction\Manager as TxManager;
    use Phalcon\Mvc\Model\Transaction\Failed as TxFailed;

    try {
        $txManager = new TxManager();

        $transaction = $txManager->get();

        $robot = new Robots();

        $robot->setTransaction($transaction);

        $robot->name       = "WALL·E";
        $robot->created_at = date("Y-m-d");

        if ($robot->save() === false) {
            $transaction->rollback("Can't save robot");
        }

        $robotPart = new RobotParts();

        $robotPart->setTransaction($transaction);

        $robotPart->type = "head";

        if ($robotPart->save() === false) {
            $transaction->rollback("Robot part cannot be saved");
        }

        $transaction->commit();
    } catch (TxFailed $e) {
        echo "Failed, reason: ", $e->getMessage();
    }




protected  **setSource** (*mixed* $source)

Sets the table name to which model should be mapped



public  **getSource** ()

Returns the table name mapped in the model



protected  **setSchema** (*mixed* $schema)

Sets schema name where the mapped table is located



public  **getSchema** ()

Returns schema name where the mapped table is located



public  **setConnectionService** (*mixed* $connectionService)

Sets the DependencyInjection connection service name



public  **setReadConnectionService** (*mixed* $connectionService)

Sets the DependencyInjection connection service name used to read data



public  **setWriteConnectionService** (*mixed* $connectionService)

Sets the DependencyInjection connection service name used to write data



public  **getReadConnectionService** ()

Returns the DependencyInjection connection service name used to read data related the model



public  **getWriteConnectionService** ()

Returns the DependencyInjection connection service name used to write data related to the model



public  **setDirtyState** (*mixed* $dirtyState)

Sets the dirty state of the object using one of the DIRTY_STATE_* constants



public  **getDirtyState** ()

Returns one of the DIRTY_STATE_* constants telling if the record exists in the database or not



public  **getReadConnection** ()

Gets the connection used to read data for the model



public  **getWriteConnection** ()

Gets the connection used to write data to the model



public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` **assign** (*array* $data, [*mixed* $dataColumnMap], [*array* $whiteList])

Assigns values to a model from an array

.. code-block:: php

    <?php

    $robot->assign(
        [
            "type" => "mechanical",
            "name" => "Astro Boy",
            "year" => 1952,
        ]
    );

    // Assign by db row, column map needed
    $robot->assign(
        $dbRow,
        [
            "db_type" => "type",
            "db_name" => "name",
            "db_year" => "year",
        ]
    );

    // Allow assign only name and year
    $robot->assign(
        $_POST,
        null,
        [
            "name",
            "year",
        ]
    );




public static  **cloneResultMap** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` | :doc:`Phalcon\\Mvc\\Model\\Row <Phalcon_Mvc_Model_Row>` $base, *array* $data, *array* $columnMap, [*int* $dirtyState], [*boolean* $keepSnapshots])

Assigns values to a model from an array, returning a new model.

.. code-block:: php

    <?php

    $robot = \Phalcon\Mvc\Model::cloneResultMap(
        new Robots(),
        [
            "type" => "mechanical",
            "name" => "Astro Boy",
            "year" => 1952,
        ]
    );




public static *mixed* **cloneResultMapHydrate** (*array* $data, *array* $columnMap, *int* $hydrationMode)

Returns an hydrated result based on the data and the column map



public static :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` **cloneResult** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $base, *array* $data, [*int* $dirtyState])

Assigns values to a model from an array returning a new model

.. code-block:: php

    <?php

    $robot = Phalcon\Mvc\Model::cloneResult(
        new Robots(),
        [
            "type" => "mechanical",
            "name" => "Astro Boy",
            "year" => 1952,
        ]
    );




public static  **find** ([*mixed* $parameters])

Query for a set of records that match the specified conditions

.. code-block:: php

    <?php

    // How many robots are there?
    $robots = Robots::find();

    echo "There are ", count($robots), "\n";

    // How many mechanical robots are there?
    $robots = Robots::find(
        "type = 'mechanical'"
    );

    echo "There are ", count($robots), "\n";

    // Get and print virtual robots ordered by name
    $robots = Robots::find(
        [
            "type = 'virtual'",
            "order" => "name",
        ]
    );

    foreach ($robots as $robot) {
     echo $robot->name, "\n";
    }

    // Get first 100 virtual robots ordered by name
    $robots = Robots::find(
        [
            "type = 'virtual'",
            "order" => "name",
            "limit" => 100,
        ]
    );

    foreach ($robots as $robot) {
     echo $robot->name, "\n";
    }




public static *static* **findFirst** ([*string* | *array* $parameters])

Query the first record that matches the specified conditions

.. code-block:: php

    <?php

    // What's the first robot in robots table?
    $robot = Robots::findFirst();

    echo "The robot name is ", $robot->name;

    // What's the first mechanical robot in robots table?
    $robot = Robots::findFirst(
        "type = 'mechanical'"
    );

    echo "The first mechanical robot name is ", $robot->name;

    // Get first virtual robot ordered by name
    $robot = Robots::findFirst(
        [
            "type = 'virtual'",
            "order" => "name",
        ]
    );

    echo "The first virtual robot name is ", $robot->name;




public static  **query** ([:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector])

Create a criteria for a specific model



protected *boolean* **_exists** (:doc:`Phalcon\\Mvc\\Model\\MetaDataInterface <Phalcon_Mvc_Model_MetaDataInterface>` $metaData, :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>` $connection, [*string* | *array* $table])

Checks whether the current record already exists



protected static :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>` **_groupResult** (*mixed* $functionName, *string* $alias, *array* $parameters)

Generate a PHQL SELECT statement for an aggregate



public static *mixed* **count** ([*array* $parameters])

Counts how many records match the specified conditions

.. code-block:: php

    <?php

    // How many robots are there?
    $number = Robots::count();

    echo "There are ", $number, "\n";

    // How many mechanical robots are there?
    $number = Robots::count("type = 'mechanical'");

    echo "There are ", $number, " mechanical robots\n";




public static *mixed* **sum** ([*array* $parameters])

Calculates the sum on a column for a result-set of rows that match the specified conditions

.. code-block:: php

    <?php

    // How much are all robots?
    $sum = Robots::sum(
        [
            "column" => "price",
        ]
    );

    echo "The total price of robots is ", $sum, "\n";

    // How much are mechanical robots?
    $sum = Robots::sum(
        [
            "type = 'mechanical'",
            "column" => "price",
        ]
    );

    echo "The total price of mechanical robots is  ", $sum, "\n";




public static *mixed* **maximum** ([*array* $parameters])

Returns the maximum value of a column for a result-set of rows that match the specified conditions

.. code-block:: php

    <?php

    // What is the maximum robot id?
    $id = Robots::maximum(
        [
            "column" => "id",
        ]
    );

    echo "The maximum robot id is: ", $id, "\n";

    // What is the maximum id of mechanical robots?
    $sum = Robots::maximum(
        [
            "type = 'mechanical'",
            "column" => "id",
        ]
    );

    echo "The maximum robot id of mechanical robots is ", $id, "\n";




public static *mixed* **minimum** ([*array* $parameters])

Returns the minimum value of a column for a result-set of rows that match the specified conditions

.. code-block:: php

    <?php

    // What is the minimum robot id?
    $id = Robots::minimum(
        [
            "column" => "id",
        ]
    );

    echo "The minimum robot id is: ", $id;

    // What is the minimum id of mechanical robots?
    $sum = Robots::minimum(
        [
            "type = 'mechanical'",
            "column" => "id",
        ]
    );

    echo "The minimum robot id of mechanical robots is ", $id;




public static *double* **average** ([*array* $parameters])

Returns the average value on a column for a result-set of rows matching the specified conditions

.. code-block:: php

    <?php

    // What's the average price of robots?
    $average = Robots::average(
        [
            "column" => "price",
        ]
    );

    echo "The average price is ", $average, "\n";

    // What's the average price of mechanical robots?
    $average = Robots::average(
        [
            "type = 'mechanical'",
            "column" => "price",
        ]
    );

    echo "The average price of mechanical robots is ", $average, "\n";




public  **fireEvent** (*mixed* $eventName)

Fires an event, implicitly calls behaviors and listeners in the events manager are notified



public  **fireEventCancel** (*mixed* $eventName)

Fires an event, implicitly calls behaviors and listeners in the events manager are notified
This method stops if one of the callbacks/listeners returns boolean false



protected  **_cancelOperation** ()

Cancel the current operation



public  **appendMessage** (:doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>` $message)

Appends a customized message on the validation process

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Message as Message;

    class Robots extends Model
    {
        public function beforeSave()
        {
            if ($this->name === "Peter") {
                $message = new Message(
                    "Sorry, but a robot cannot be named Peter"
                );

                $this->appendMessage($message);
            }
        }
    }




protected  **validate** (:doc:`Phalcon\\ValidationInterface <Phalcon_ValidationInterface>` $validator)

Executes validators on every validation call

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;
    use Phalcon\Validation;
    use Phalcon\Validation\Validator\ExclusionIn;

    class Subscriptors extends Model
    {
        public function validation()
        {
            $validator = new Validation();

            $validator->add(
                "status",
                new ExclusionIn(
                    [
                        "domain" => [
                            "A",
                            "I",
                        ],
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

    use Phalcon\Mvc\Model;
    use Phalcon\Validation;
    use Phalcon\Validation\Validator\ExclusionIn;

    class Subscriptors extends Model
    {
        public function validation()
        {
            $validator = new Validation();

            $validator->validate(
                "status",
                new ExclusionIn(
                    [
                        "domain" => [
                            "A",
                            "I",
                        ],
                    ]
                )
            );

            return $this->validate($validator);
        }
    }




public  **getMessages** ([*mixed* $filter])

Returns array of validation messages

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




final protected  **_checkForeignKeysRestrict** ()

Reads "belongs to" relations and check the virtual foreign keys when inserting or updating records
to verify that inserted/updated values are present in the related entity



final protected  **_checkForeignKeysReverseCascade** ()

Reads both "hasMany" and "hasOne" relations and checks the virtual foreign keys (cascade) when deleting records



final protected  **_checkForeignKeysReverseRestrict** ()

Reads both "hasMany" and "hasOne" relations and checks the virtual foreign keys (restrict) when deleting records



protected  **_preSave** (:doc:`Phalcon\\Mvc\\Model\\MetaDataInterface <Phalcon_Mvc_Model_MetaDataInterface>` $metaData, *mixed* $exists, *mixed* $identityField)

Executes internal hooks before save a record



protected  **_postSave** (*mixed* $success, *mixed* $exists)

Executes internal events after save a record



protected *boolean* **_doLowInsert** (:doc:`Phalcon\\Mvc\\Model\\MetaDataInterface <Phalcon_Mvc_Model_MetaDataInterface>` $metaData, :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>` $connection, *string* | *array* $table, *boolean* | *string* $identityField)

Sends a pre-build INSERT SQL statement to the relational database system



protected *boolean* **_doLowUpdate** (:doc:`Phalcon\\Mvc\\Model\\MetaDataInterface <Phalcon_Mvc_Model_MetaDataInterface>` $metaData, :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>` $connection, *string* | *array* $table)

Sends a pre-build UPDATE SQL statement to the relational database system



protected *boolean* **_preSaveRelatedRecords** (:doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>` $connection, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`\ [] $related)

Saves related records that must be stored prior to save the master record



protected *boolean* **_postSaveRelatedRecords** (:doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>` $connection, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`\ [] $related)

Save the related records assigned in the has-one/has-many relations



public *boolean* **save** ([*array* $data], [*array* $whiteList])

Inserts or updates a model instance. Returning true on success or false otherwise.

.. code-block:: php

    <?php

    // Creating a new robot
    $robot = new Robots();

    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;

    $robot->save();

    // Updating a robot name
    $robot = Robots::findFirst("id = 100");

    $robot->name = "Biomass";

    $robot->save();




public  **create** ([*mixed* $data], [*mixed* $whiteList])

Inserts a model instance. If the instance already exists in the persistence it will throw an exception
Returning true on success or false otherwise.

.. code-block:: php

    <?php

    // Creating a new robot
    $robot = new Robots();

    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;

    $robot->create();

    // Passing an array to create
    $robot = new Robots();

    $robot->create(
        [
            "type" => "mechanical",
            "name" => "Astro Boy",
            "year" => 1952,
        ]
    );




public  **update** ([*mixed* $data], [*mixed* $whiteList])

Updates a model instance. If the instance doesn't exist in the persistence it will throw an exception
Returning true on success or false otherwise.

.. code-block:: php

    <?php

    // Updating a robot name
    $robot = Robots::findFirst("id = 100");

    $robot->name = "Biomass";

    $robot->update();




public  **delete** ()

Deletes a model instance. Returning true on success or false otherwise.

.. code-block:: php

    <?php

    $robot = Robots::findFirst("id=100");

    $robot->delete();

    $robots = Robots::find("type = 'mechanical'");

    foreach ($robots as $robot) {
        $robot->delete();
    }




public  **getOperationMade** ()

Returns the type of the latest operation performed by the ORM
Returns one of the OP_* class constants



public  **refresh** ()

Refreshes the model attributes re-querying the record from the database



public  **skipOperation** (*mixed* $skip)

Skips the current operation forcing a success state



public  **readAttribute** (*mixed* $attribute)

Reads an attribute value by its name

.. code-block:: php

    <?php

    echo $robot->readAttribute("name");




public  **writeAttribute** (*mixed* $attribute, *mixed* $value)

Writes an attribute value by its name

.. code-block:: php

    <?php

    $robot->writeAttribute("name", "Rosey");




protected  **skipAttributes** (*array* $attributes)

Sets a list of attributes that must be skipped from the
generated INSERT/UPDATE statement

.. code-block:: php

    <?php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->skipAttributes(
                [
                    "price",
                ]
            );
        }
    }




protected  **skipAttributesOnCreate** (*array* $attributes)

Sets a list of attributes that must be skipped from the
generated INSERT statement

.. code-block:: php

    <?php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->skipAttributesOnCreate(
                [
                    "created_at",
                ]
            );
        }
    }




protected  **skipAttributesOnUpdate** (*array* $attributes)

Sets a list of attributes that must be skipped from the
generated UPDATE statement

.. code-block:: php

    <?php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->skipAttributesOnUpdate(
                [
                    "modified_in",
                ]
            );
        }
    }




protected  **allowEmptyStringValues** (*array* $attributes)

Sets a list of attributes that must be skipped from the
generated UPDATE statement

.. code-block:: php

    <?php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->allowEmptyStringValues(
                [
                    "name",
                ]
            );
        }
    }




protected  **hasOne** (*mixed* $fields, *mixed* $referenceModel, *mixed* $referencedFields, [*mixed* $options])

Setup a 1-1 relation between two models

.. code-block:: php

    <?php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->hasOne("id", "RobotsDescription", "robots_id");
        }
    }




protected  **belongsTo** (*mixed* $fields, *mixed* $referenceModel, *mixed* $referencedFields, [*mixed* $options])

Setup a reverse 1-1 or n-1 relation between two models

.. code-block:: php

    <?php

    <?php

    class RobotsParts extends \Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->belongsTo("robots_id", "Robots", "id");
        }
    }




protected  **hasMany** (*mixed* $fields, *mixed* $referenceModel, *mixed* $referencedFields, [*mixed* $options])

Setup a 1-n relation between two models

.. code-block:: php

    <?php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->hasMany("id", "RobotsParts", "robots_id");
        }
    }




protected :doc:`Phalcon\\Mvc\\Model\\Relation <Phalcon_Mvc_Model_Relation>` **hasManyToMany** (*string* | *array* $fields, *string* $intermediateModel, *string* | *array* $intermediateFields, *string* | *array* $intermediateReferencedFields, *mixed* $referenceModel, *string* | *array* $referencedFields, [*array* $options])

Setup an n-n relation between two models, through an intermediate relation

.. code-block:: php

    <?php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {
        public function initialize()
        {
            // Setup a many-to-many relation to Parts through RobotsParts
            $this->hasManyToMany(
                "id",
                "RobotsParts",
                "robots_id",
                "parts_id",
                "Parts",
                "id",
            );
        }
    }




public  **addBehavior** (:doc:`Phalcon\\Mvc\\Model\\BehaviorInterface <Phalcon_Mvc_Model_BehaviorInterface>` $behavior)

Setups a behavior in a model

.. code-block:: php

    <?php

    <?php

    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Behavior\Timestampable;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->addBehavior(
                new Timestampable(
                   [
                       "onCreate" => [
                            "field"  => "created_at",
                            "format" => "Y-m-d",
    	                   ],
                    ]
                )
            );
        }
    }




protected  **keepSnapshots** (*mixed* $keepSnapshot)

Sets if the model must keep the original record snapshot in memory

.. code-block:: php

    <?php

    <?php

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->keepSnapshots(true);
        }
    }




public  **setSnapshotData** (*array* $data, [*array* $columnMap])

Sets the record's snapshot data.
This method is used internally to set snapshot data when the model was set up to keep snapshot data



public  **hasSnapshotData** ()

Checks if the object has internal snapshot data



public  **getSnapshotData** ()

Returns the internal snapshot data



public  **hasChanged** ([*string* | *array* $fieldName])

Check if a specific attribute has changed
This only works if the model is keeping data snapshots



public  **getChangedFields** ()

Returns a list of changed values.

.. code-block:: php

    <?php

    $robots = Robots::findFirst();
    print_r($robots->getChangedFields()); // []

    $robots->deleted = 'Y';

    $robots->getChangedFields();
    print_r($robots->getChangedFields()); // ["deleted"]




protected  **useDynamicUpdate** (*mixed* $dynamicUpdate)

Sets if a model must use dynamic update instead of the all-field update

.. code-block:: php

    <?php

    <?php

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->useDynamicUpdate(true);
        }
    }




public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>` **getRelated** (*string* $alias, [*array* $arguments])

Returns related records based on defined relations



protected *mixed* **_getRelatedRecords** (*string* $modelName, *string* $method, *array* $arguments)

Returns related records defined relations depending on the method name



final protected static :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`\ [] | :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` | *boolean* **_invokeFinder** (*string* $method, *array* $arguments)

Try to check if the query must invoke a finder



public *mixed* **__call** (*string* $method, *array* $arguments)

Handles method calls when a method is not implemented



public static *mixed* **__callStatic** (*string* $method, *array* $arguments)

Handles method calls when a static method is not implemented



public  **__set** (*string* $property, *mixed* $value)

Magic method to assign values to the the model



final protected *string* **_possibleSetter** (*string* $property, *mixed* $value)

Check for, and attempt to use, possible setter.



public :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>` | :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` **__get** (*string* $property)

Magic method to get related records using the relation alias as a property



public  **__isset** (*mixed* $property)

Magic method to check if a property is a valid relation



public  **serialize** ()

Serializes the object ignoring connections, services, related objects or static properties



public  **unserialize** (*mixed* $data)

Unserializes the object from a serialized string



public  **dump** ()

Returns a simple representation of the object that can be used with var_dump

.. code-block:: php

    <?php

    var_dump(
        $robot->dump()
    );




public *array* **toArray** ([*array* $columns])

Returns the instance as an array representation

.. code-block:: php

    <?php

    print_r(
        $robot->toArray()
    );




public *array* **jsonSerialize** ()

Serializes the object for json_encode

.. code-block:: php

    <?php

    echo json_encode($robot);




public static  **setup** (*array* $options)

Enables/disables options in the ORM



public  **reset** ()

Reset a model instance data



