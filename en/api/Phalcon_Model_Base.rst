Class **Phalcon_Model_Base**
============================

Phalcon_Model connects business objects and database tables to create a persistent domain model where logic and data are presented wrapped as one. 

Its an implementation of the object-relational mapping (ORM). A model represents the information (data) of the application and the rules to manipulate that data. Models are primarily used for managing the rules of interaction with a corresponding database table. In most cases, each table in the database will correspond to one model in the application. The bulk of the application's business logic will be in the models. 

Phalcon_Model is the first ORM written in C-language for PHP, giving developers an easy to use while high performance framework to interact with databases.

.. code-block:: php

    <?php
    
    $manager = new Phalcon_Model_Manager();
    $manager->setModelsDir('app/models/');

    $robot       = new Robots();
    $robot->type = 'mechanical'
    $robot->name = 'Astro Boy';
    $robot->year = 1952;

    if ($robot->save() == false) {
        echo "Umh, We can store robots: ";
        foreach ($robot->getMessages() as $message) {
            echo $message;
        }
    } else {
        echo "Great, a new robot was saved successfully!";
    }

Constants
---------

integer **OP_CREATE**

integer **OP_UPDATE**

integer **OP_DELETE**

Methods
---------

**__construct** (Phalcon_Model_Manager $manager)

Phalcon_Model_Base constructor

**setManager** (Phalcon_Model_Manager $manager)

Overwrites default model manager

**Phalcon_Model_Manager** **getManager** ()

Returns internal models manager

**_connect** ()

Internal method to create a connection. Automatically dumps mapped table meta-data

**array** **getAttributes** ()

Return an array with the attributes names

**array** **getPrimaryKeyAttributes** ()

Returns an array of attributes that are part of the related table primary key

**array** **getNonPrimaryKeyAttributes** ()

Returns an array of attributes that aren't part of the primary key

**array** **getNotNullAttributes** ()

Returns an array of not-nullable attributes

**array** **getDataTypesNumeric** ()

Returns an array of numeric attributes

**array** **getDataTypes** ()

Returns an array of data-types attributes

**string** **getIdentityField** ()

Returns the name of the identity field

**Phalcon_Model_Base** **dump** ()

Dumps mapped table meta-data

**array** **_createSQLSelect** (Phalcon_Manager $manager, Phalcon_Model_Base $model, Phalcon_Db $connection, array $params)

Creates SQL statement which returns many rows

**_getOrCreateResultset** (Phalcon_Model_Manager $manager, Phalcon_Model_Base $model, Phalcon_Db $connection, array $params, boolean $unique)

Gets a resulset from the cache or creates one

**setTransaction** (Phalcon_Transaction $transaction)

Sets a transaction related to the Model instance 

.. code-block:: php

    <?php

    
    try {
        $transaction = Phalcon_Transaction_Manager::get();

        $robot = new Robots();
        $robot->setTransaction($transaction);
        $robot->name       = 'WALL-E';
        $robot->created_at = date('Y-m-d');

        if ($robot->save() == false) {
            $transaction->rollback("Can't save robot");
        }
        $robotPart = new RobotParts();
        $robotPart->setTransaction($transaction);
        $robotPart->type = 'head';

        if ($robotPart->save() == false) {
            $transaction->rollback("Can't save robot part");
        }
        $transaction->commit();

    } catch(Phalcon_Transaction_Failed $e) {
        echo 'Failed, reason: ', $e->getMessage();
    }
    
**boolean** **isView** ()

Checks whether model is mapped to a database view

**setSource** (string $source)

Sets table name which model should be mapped

**string** **getSource** ()

Returns table name mapped in the model

**setSchema** (string $schema)

Sets schema name where table mapped is located

**string** **getSchema** ()

Returns schema name where table mapped is located

**setConnection** (Phalcon_Db $connection)

Overwrites internal Phalcon_Db connection

**Phalcon_Db** **getConnection** ()

Gets internal Phalcon_Db connection

**Phalcon_Model_Base $result** **dumpResult** (Phalcon_Model_Base $base, array $result)

Assigns values to a model from an array returning a new model 

.. code-block:: php

    <?php

    $robot = Phalcon_Model_Base::dumpResult(
        new Robots(), 
        array(
            'type' => 'mechanical',
            'name' => 'Astro Boy',
            'year' => 1952,
        )
    );
    
**Phalcon_Model_Resultset** **find** (array $parameters)

Allows to query a set of records that match the specified conditions  

.. code-block:: php

    <?php

    // How many robots are there?
    $robots = Robots::find();
    echo "There are ", count($robots);
    
    // How many mechanical robots are there?
    $robots = Robots::find("type='mechanical'");
    echo "There are ", count($robots);
    
    // Get and print virtual robots ordered by name
    $robots = Robots::find(array("type='virtual'", "order" => "name"));
    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // Get first 100 virtual robots ordered by name
    $robots = Robots::find(array("type='virtual'", "order" => "name", "limit" => 100));
    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }
     
**Phalcon_Model_Base** **findFirst** (array $parameters)

Allows to query the first record that match the specified conditions  

.. code-block:: php

    <?php
    
    // What's the first robot in robots table?
    $robot = Robots::findFirst();
    echo "The robot name is ", $robot->name;
    
    // What's the first mechanical robot in robots table?
    $robot = Robots::findFirst("type='mechanical'");
    echo "The first mechanical robot name is ", $robot->name;
    
    // Get first virtual robot ordered by name
    $robot = Robots::findFirst(array("type='virtual'", "order" => "name"));
    echo "The first virtual robot name is ", $robot->name;
     
**boolean** **_exists** (Phalcon_Db $connection)

Checks if the current record already exists or not

**Phalcon_Model_Resultset** **_prepareGroupResult** (string $function, string $alias, array $parameters)

Generate a SQL SELECT statement for an aggregate

**array|Phalcon_Model_Resultset** **_getGroupResult** (Phalcon_Db $connection, array $params, string $sqlSelect, string $alias)

Generate a resulset from an aggreate SQL select

**int** **count** (array $parameters)

Allows to count how many records match the specified conditions  

.. code-block:: php

    <?php
    
    // How many robots are there?
    $number = Robots::count();
    echo "There are ", $number;

    // How many mechanical robots are there?
    $number = Robots::count("type='mechanical'");
    echo "There are ", $number, " mechanical robots";
    
**double** **sum** (array $parameters)

Allows to a calculate a summatory on a column that match the specified conditions  

.. code-block:: php

    <?php
    
    // How much are all robots?
    $sum = Robots::sum(array('column' => 'price'));
    echo "The total price of robots is ", $sum;
    
    // How much are mechanical robots?
    $sum = Robots::sum(array("type='mechanical'", 'column' => 'price'));
    echo "The total price of mechanical robots is  ", $sum;
     
**mixed** **maximum** (array $parameters)

Allows to get the maximum value of a column that match the specified conditions  

.. code-block:: php

    <?php
    
    // What is the maximum robot id?
    $id = Robots::maximum(array('column' => 'id'));
    echo "The maximum robot id is: ", $id;
    
    // What is the maximum id of mechanical robots?
    $sum = Robots::maximum(array("type='mechanical'", 'column' => 'id'));
    echo "The maximum robot id of mechanical robots is ", $id;
     
**mixed** **minimum** (array $parameters)

Allows to get the minimum value of a column that match the specified conditions  

.. code-block:: php

    <?php
    
    // What is the minimum robot id?
    $id = Robots::minimum(array('column' => 'id'));
    echo "The minimum robot id is: ", $id;
    
    // What is the minimum id of mechanical robots?
    $sum = Robots::minimum(array("type='mechanical'", 'column' => 'id'));
    echo "The minimum robot id of mechanical robots is ", $id;
     
**double** **average** (array $parameters)

Allows to calculate the average value on a column matching the specified conditions

.. code-block:: php

    <?php
    
    // What's the average price of robots?
    $average = Robots::average(array('column' => 'price'));
    echo "The average price is ", $average;
    
    // What's the average price of mechanical robots?
    $average = Robots::average(array("type='mechanical'", 'column' => 'price'));
    echo "The average price of mechanical robots is ", $average;
     
**boolean** **_callEvent** (string $eventName)

Fires an internal event

**boolean** **_cancelOperation** ()

Cancel the current operation

**appendMessage** (Phalcon_Model_Message $message)

Appends a customized message on the validation process  

.. code-block:: php

    <?php
    
     class Robots extends Phalcon_Model_Base 
     {

        function beforeSave() 
        {
            if (this->name=='Peter') {
                $message = new Phalcon_Model_Message("Sorry, but a robot cannot be named Peter");
                $this->appendMessage($message);
            }
        }

     }
     
**validate** (string $validatorClass, array $options)

Executes validators on every validation call 

.. code-block:: php

    <?php
    
    class Subscriptors extends Phalcon_Model_Base 
    {

    	function validation()
        {
     		$this->validate(
                'ExclusionIn', 
                array(
                    'field' => 'status',
                    'domain' => array('A', 'I'),
                )
            );

    		if ($this->validationHasFailed() == true) {
    			return false;
    		}
    	}

    }
    
**boolean** **validationHasFailed** ()

Check whether validation process has generated any messages 

.. code-block:: php

    <?php
    
    class Subscriptors extends Phalcon_Model_Base 
    {

    	function validation()
        {
     		$this->validate(
                'ExclusionIn', 
                array(
        			'field' => 'status',
        			'domain' => array('A', 'I'),
                )
            );

    		if ($this->validationHasFailed() == true) {
    			return false;
    		}
    	}

    }
    
**Phalcon_Model_Message[]** **getMessages** ()

Returns all the validation messages  

.. code-block:: php

    <?php
    
    $robot       = new Robots();
    $robot->type = 'mechanical';
    $robot->name = 'Astro Boy';
    $robot->year = 1952;

    if ($robot->save() == false) {
        echo "Umh, We can't store robots right now ";
        foreach ($robot->getMessages() as $message) {
            echo $message;
        }
    } else {
        echo "Great, a new robot was saved successfully!";
    }
    
**boolean** **_checkForeignKeys** ()

Reads "belongs to" relations and checks the virtual foreign keys when inserting or updating records

**boolean** **_checkForeignKeysReverse** ()

Reads both "hasMany" and "hasOne" relations and check the virtual foreign keys when deleting records

**boolean** **_preSave** (boolean $disableEvents, boolean $exists, string $identityField)

Executes internal events before save a record

**boolean** **_postSave** (boolean $disableEvents, boolean $success, boolean $exists)

Executes internal events after save a record

**boolean** **_doLowInsert** (Phalcon_Db $connection, string $table, array $dataType, array $dataTypeNumeric, string $identityField)

Sends a pre-build INSERT SQL statement to the relational database system

**boolean** **_doLowUpdate** (Phalcon_Db $connection, string $table, array $dataType, array $dataTypeNumeric)

Sends a pre-build UPDATE SQL statement to the relational database system

**boolean** **save** ()

Inserts or updates a model instance. Returning true on success or false otherwise.  

.. code-block:: php

    <?php

    // Creating a new robot
    $robot = new Robots();
    $robot->type = 'mechanical'
    $robot->name = 'Astro Boy';
    $robot->year = 1952;
    $robot->save();
    
    // Updating a robot name
    $robot = Robots::findFirst("id=100");
    $robot->name = "Biomass";
    $robot->save();
    
**boolean** **delete** ()

Deletes a model instance. Returning true on success or false otherwise.  

.. code-block:: php

    <?php
    
    $robot = Robots::findFirst("id=100");
    $robot->delete();

    foreach (Robots::find("type = 'mechanical'") as $robot) {
       $robot->delete();
    }

**mixed** **readAttribute** (string $attribute)

Reads an attribute value by its name  

.. code-block:: php

    <?php  

    echo $robot->readAttribute('name');

**writeAttribute** (string $attribute, mixed $value)

Writes an attribute value by its name  

.. code-block:: php

    <?php 

    $robot->writeAttribute('name', 'Rosey');

**hasOne** (mixed $fields, string $referenceModel, mixed $referencedFields, array $options)

Setup a 1-1 relation between two models 

.. code-block:: php

    <?php
    
    class Robots extends Phalcon_Model_Base 
    {
        function initialize()
        {
            $this->hasOne('id', 'RobotsDescription', 'robots_id');
        }
    }
    
**belongsTo** (mixed $fields, string $referenceModel, mixed $referencedFields, array $options)

Setup a relation reverse 1-1  between two models 

.. code-block:: php

    <?php
    
    class RobotsParts extends Phalcon_Model_Base 
    {
        function initialize()
        {
           $this->belongsTo('robots_id', 'Robots', 'id');
        }
    }
    
**hasMany** (mixed $fields, string $referenceModel, mixed $referencedFields, array $options)

Setup a relation 1-n between two models 

.. code-block:: php

    <?php
    
    class Robots extends Phalcon_Model_Base 
    {
        function initialize()
        {
           $this->hasMany('id', 'RobotsParts', 'robots_id');
        }
    }
    
**mixed** **__call** (string $method, array $arguments)

Handles methods when a method does not exist

