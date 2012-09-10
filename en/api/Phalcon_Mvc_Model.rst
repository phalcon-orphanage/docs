Class **Phalcon\\Mvc\\Model**
=============================

*implements* Serializable

Phalcon\\Mvc\\Model connects business objects and database tables to create a persistable domain model where logic and data are presented in one wrapping. It‘s an implementation of the object-relational mapping (ORM).   A model represents the information (data) of the application and the rules to manipulate that data. Models are primarily used for managing the rules of interaction with a corresponding database table. In most cases, each table in your database will correspond to one model in your application. The bulk of your application’s business logic will be concentrated in the models.   Phalcon\\Mvc\\Model is the first ORM written in C-language for PHP, giving to developers high performance when interacting with databases while is also easy to use.   

.. code-block:: php

    <?php

     $robot = new Robots();
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

final public **__construct** (*Phalcon\DI* $dependencyInjector, *string* $managerService, *string* $dbService)

Phalcon\\Mvc\\Model constructor



public **setDI** (*Phalcon\DI* $dependencyInjector)

Sets the dependency injection container



:doc:`Phalcon\\DI <Phalcon_DI>` public **getDI** ()

Returns the dependency injection container



public **setEventsManager** (*Phalcon\Events\Manager* $eventsManager)

Sets the event manager



:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` public **getEventsManager** ()

Returns the internal event manager



*array* protected static **_createSQLSelect** ()

Creates a SQL statement which returns many rows



protected static **_getOrCreateResultset** ()

Gets a resulset from the cache or creates one



:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` public **setTransaction** (*Phalcon\Mvc\Model\Transaction* $transaction)

Sets a transaction related to the Model instance 

.. code-block:: php

    <?php

    try {
    
      $transactionManager = new Phalcon\Mvc\Model\Transaction\Manager();
    
      $transaction = $transactionManager->get();
    
      $robot = new Robots();
      $robot->setTransaction($transaction);
      $robot->name = 'WALL·E';
      $robot->created_at = date('Y-m-d');
      if($robot->save()==false){
        $transaction->rollback("Can't save robot");
      }
    
      $robotPart = new RobotParts();
      $robotPart->setTransaction($transaction);
      $robotPart->type = 'head';
      if ($robotPart->save() == false) {
        $transaction->rollback("Can't save robot part");
      }
    
      $transaction->commit();
    
    }
    catch(Phalcon\Mvc\Model\Transaction\Failed $e){
      echo 'Failed, reason: ', $e->getMessage();
    }




:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` protected **setSource** ()

Sets table name which model should be mapped



*string* public **getSource** ()

Returns table name mapped in the model



:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` protected **setSchema** ()

Sets schema name where table mapped is located



*string* public **getSchema** ()

Returns schema name where table mapped is located



public **setConnectionService** (*string* $connectionService)

Sets DependencyInjection connection service



*$connectionService* public **getConnectionService** ()

Returns DependencyInjection connection service



public **setForceExists** (*unknown* $forceExists)





:doc:`Phalcon\\Db <Phalcon_Db>` public **getConnection** ()

Gets internal database connection



:doc:`Phalcon\\Mvc\\Model\\Base $result <Phalcon_Mvc_Model_Base $result>` public static **dumpResult** (*Phalcon\Mvc\Model\Base* $base, *array* $result)

Assigns values to a model from an array returning a new model 

.. code-block:: php

    <?php

    $robot = Phalcon\Mvc\Model::dumpResult(new Robots(), array(
      'type' => 'mechanical',
      'name' => 'Astro Boy',
      'year' => 1952
    ));




:doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>` public static **find** (*array* $parameters)

Allows to query a set of records that match the specified conditions 

.. code-block:: php

    <?php

     //How many robots are there?
     $robots = Robots::find();
     echo "There are ", count($robots);
    
     //How many mechanical robots are there?
     $robots = Robots::find("type='mechanical'");
     echo "There are ", count($robots);
    
     //Get and print virtual robots ordered by name
     $robots = Robots::find(array("type='virtual'", "order" => "name"));
     foreach ($robots as $robot) {
       echo $robot->name, "\n";
     }
    
     //Get first 100 virtual robots ordered by name
     $robots = Robots::find(array("type='virtual'", "order" => "name", "limit" => 100));
     foreach ($robots as $robot) {
       echo $robot->name, "\n";
     }




:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` public static **findFirst** (*array* $parameters)

Allows to query the first record that match the specified conditions 

.. code-block:: php

    <?php

     //What's the first robot in robots table?
     $robot = Robots::findFirst();
     echo "The robot name is ", $robot->name;
    
     //What's the first mechanical robot in robots table?
     $robot = Robots::findFirst("type='mechanical'");
     echo "The first mechanical robot name is ", $robot->name;
    
     //Get first virtual robot ordered by name
     $robot = Robots::findFirst(array("type='virtual'", "order" => "name"));
     echo "The first virtual robot name is ", $robot->name;




:doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>` public static **query** (*unknown* $dependencyInjector)

Create a criteria for a especific model



*boolean* protected **_exists** ()

Checks if the current record already exists or not



:doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>` protected static **_prepareGroupResult** ()

Generate a SQL SELECT statement for an aggregate



:doc:`array|Phalcon\\Mvc\\Model\\Resultset <array|Phalcon_Mvc_Model_Resultset>` protected static **_getGroupResult** ()

Generate a resulset from an SQL select with aggregations



*int* public static **count** (*array* $parameters)

Allows to count how many records match the specified conditions 

.. code-block:: php

    <?php

     //How many robots are there?
     $number = Robots::count();
     echo "There are ", $number;
    
     //How many mechanical robots are there?
     $number = Robots::count("type='mechanical'");
     echo "There are ", $number, " mechanical robots";




*double* public static **sum** (*array* $parameters)

Allows to a calculate a summatory on a column that match the specified conditions 

.. code-block:: php

    <?php

     //How much are all robots?
     $sum = Robots::sum(array('column' => 'price'));
     echo "The total price of robots is ", $sum;
    
     //How much are mechanical robots?
     $sum = Robots::sum(array("type='mechanical'", 'column' => 'price'));
     echo "The total price of mechanical robots is  ", $sum;




*mixed* public static **maximum** (*array* $parameters)

Allows to get the maximum value of a column that match the specified conditions 

.. code-block:: php

    <?php

     //What is the maximum robot id?
     $id = Robots::maximum(array('column' => 'id'));
     echo "The maximum robot id is: ", $id;
    
     //What is the maximum id of mechanical robots?
     $sum = Robots::maximum(array("type='mechanical'", 'column' => 'id'));
     echo "The maximum robot id of mechanical robots is ", $id;




*mixed* public static **minimum** (*array* $parameters)

Allows to get the minimum value of a column that match the specified conditions 

.. code-block:: php

    <?php

     //What is the minimum robot id?
     $id = Robots::minimum(array('column' => 'id'));
     echo "The minimum robot id is: ", $id;
    
     //What is the minimum id of mechanical robots?
     $sum = Robots::minimum(array("type='mechanical'", 'column' => 'id'));
     echo "The minimum robot id of mechanical robots is ", $id;




*double* public static **average** (*array* $parameters)

Allows to calculate the average value on a column matching the specified conditions 

.. code-block:: php

    <?php

     //What's the average price of robots?
     $average = Robots::average(array('column' => 'price'));
     echo "The average price is ", $average;
    
     //What's the average price of mechanical robots?
     $average = Robots::average(array("type='mechanical'", 'column' => 'price'));
     echo "The average price of mechanical robots is ", $average;




*boolean* protected **_callEvent** ()

Fires an internal event



*boolean* protected **_callEventCancel** ()

Fires an internal event that cancels the operation



*boolean* protected **_cancelOperation** ()

Cancel the current operation



public **appendMessage** (*Phalcon\Mvc\Model\Message* $message)

Appends a customized message on the validation process 

.. code-block:: php

    <?php

     use \Phalcon\Mvc\Model\Message as Message;
    
     class Robots extends Phalcon\Mvc\Model
     {
    
       public function beforeSave()
       {
         if (this->name == 'Peter') {
            $message = new Message("Sorry, but a robot cannot be named Peter");
            $this->appendMessage($message);
         }
       }
     }




protected **validate** ()

Executes validators on every validation call 

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Validator\ExclusionIn as ExclusionIn;
    
    class Subscriptors extends Phalcon\Mvc\Model
    {
    
    public function validation()
      {
     		$this->validate(new ExclusionIn(array(
    		'field' => 'status',
    		'domain' => array('A', 'I')
    	)));
    	if ($this->validationHasFailed() == true) {
    		return false;
    	}
    }
    
    }




*boolean* public **validationHasFailed** ()

Check whether validation process has generated any messages 

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Validator\ExclusionIn as ExclusionIn;
    
    class Subscriptors extends Phalcon\Mvc\Model
    {
    
    public function validation()
      {
     		$this->validate(new ExclusionIn(array(
    		'field' => 'status',
    		'domain' => array('A', 'I')
    	)));
    	if ($this->validationHasFailed() == true) {
    		return false;
    	}
    }
    
    }




:doc:`Phalcon\\Mvc\\Model\\Message[] <Phalcon_Mvc_Model_Message[]>` public **getMessages** ()

Returns all the validation messages 

.. code-block:: php

    <?php

    $robot = new Robots();
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




*boolean* protected **_checkForeignKeys** ()

Reads "belongs to" relations and check the virtual foreign keys when inserting or updating records



*boolean* protected **_checkForeignKeysReverse** ()

Reads both "hasMany" and "hasOne" relations and check the virtual foreign keys when deleting records



*boolean* protected **_preSave** ()

Executes internal hooks before save a record



*boolean* protected **_postSave** ()

Executes internal events after save a record



*boolean* protected **_doLowInsert** ()

Sends a pre-build INSERT SQL statement to the relational database system



*boolean* protected **_doLowUpdate** ()

Sends a pre-build UPDATE SQL statement to the relational database system



*boolean* public **save** ()

Inserts or updates a model instance. Returning true on success or false otherwise. 

.. code-block:: php

    <?php

     //Creating a new robot
    $robot = new Robots();
    $robot->type = 'mechanical'
    $robot->name = 'Astro Boy';
    $robot->year = 1952;
    $robot->save();
    
     //Updating a robot name
    $robot = Robots::findFirst("id=100");
    $robot->name = "Biomass";
    $robot->save();




public **create** ()

public **update** ()

*boolean* public **delete** ()

Deletes a model instance. Returning true on success or false otherwise. 

.. code-block:: php

    <?php

    $robot = Robots::findFirst("id=100");
    $robot->delete();
    
    foreach(Robots::find("type = 'mechanical'") as $robot){
       $robot->delete();
    }




*mixed* public **readAttribute** (*string* $attribute)

Reads an attribute value by its name <code> echo $robot->readAttribute('name');



public **writeAttribute** (*string* $attribute, *mixed* $value)

Writes an attribute value by its name <code>$robot->writeAttribute('name', 'Rosey');



protected **hasOne** ()

Setup a 1-1 relation between two models 

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {
    
       public function initialize(){
           $this->hasOne('id', 'RobotsDescription', 'robots_id');
       }
    
    }




protected **belongsTo** ()

Setup a relation reverse 1-1  between two models 

.. code-block:: php

    <?php

    class RobotsParts extends \Phalcon\Mvc\Model
    {
    
       public function initialize(){
           $this->belongsTo('robots_id', 'Robots', 'id');
       }
    
    }




protected **hasMany** ()

Setup a relation 1-n between two models 

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {
    
       public function initialize()
       {
           $this->hasMany('id', 'RobotsParts', 'robots_id');
       }
    
    }




protected **__getRelatedRecords** ()

*mixed* public **__call** (*string* $method, *array* $arguments)

Handles methods when a method does not exist



public **serialize** ()

public **unserialize** (*unknown* $data)

