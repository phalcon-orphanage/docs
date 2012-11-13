Class **Phalcon\\Mvc\\Collection**
==================================

*implements* Phalcon\DI\InjectionAwareInterface, Phalcon\Events\EventsAwareInterface

This component implements a high level abstraction for NoSQL databases which works with documents


Constants
---------

*integer* **OP_NONE**

*integer* **OP_CREATE**

*integer* **OP_UPDATE**

*integer* **OP_DELETE**

Methods
---------

public  **__construct** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)





public  **setId** (*mixed* $id)

Sets a value for the _id propery, creates a MongoId object if needed



public *MongoId*  **getId** ()

Returns the value of the _id property



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injection container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the dependency injection container



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets the event manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()

Returns the internal event manager



public *array*  **getReservedAttributes** ()

Returns an array with reserved properties that cannot be part of the insert/update



protected :doc:`Phalcon\\Mvc\\Collection <Phalcon_Mvc_Collection>`  **setSource** ()

Sets collection name which model should be mapped



public *string*  **getSource** ()

Returns collection name mapped in the model



public  **setConnectionService** (*string* $connectionService)

Sets a service in the services container that returns the Mongo database



public *MongoDb*  **getConnection** ()

Retrieves a database connection



public *mixed*  **readAttribute** (*string* $attribute)

Reads an attribute value by its name <code> echo $robot->readAttribute('name');



public  **writeAttribute** (*string* $attribute, *mixed* $value)

Writes an attribute value by its name <code>$robot->writeAttribute('name', 'Rosey');



protected static :doc:`Phalcon\\Mvc\\Collection <Phalcon_Mvc_Collection>`  **dumpResult** ()

Returns a cloned collection



protected static *array*  **_getResultset** ()

Returns a collection resultset



protected *boolean*  **_preSave** ()

Executes internal hooks before save a document



protected *boolean*  **_postSave** ()

Executes internal events after save a document



protected  **validate** ()

Executes validators on every validation call 

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Validator\ExclusionIn as ExclusionIn;
    
    class Subscriptors extends Phalcon\Mvc\Collection
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




public *boolean*  **validationHasFailed** ()

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




protected *boolean*  **_callEvent** ()

Fires an internal event



protected *boolean*  **_callEventCancel** ()

Fires an internal event that cancels the operation



protected *boolean*  **_cancelOperation** ()

Cancel the current operation



protected  **_exists** ()

Checks if the document exists in the collection



public  **save** ()





public static :doc:`Phalcon\\Mvc\\Collection <Phalcon_Mvc_Collection>`  **findById** (*string* $id)

Find a document by its id



public static *array*  **findFirst** (*array* $parameters)

Allows to query the first record that match the specified conditions 

.. code-block:: php

    <?php

     //What's the first robot in robots table?
     $robot = Robots::findFirst();
     echo "The robot name is ", $robot->name;
    
     //What's the first mechanical robot in robots table?
     $robot = Robots::findFirst(array(
         array("type" => "mechanical")
     ));
     echo "The first mechanical robot name is ", $robot->name;
    
     //Get first virtual robot ordered by name
     $robot = Robots::findFirst(array(
         array("type" => "mechanical"),
         "order" => array("name" => 1)
     ));
     echo "The first virtual robot name is ", $robot->name;




public static *array*  **find** (*array* $parameters)

Allows to query a set of records that match the specified conditions 

.. code-block:: php

    <?php

     //How many robots are there?
     $robots = Robots::find();
     echo "There are ", count($robots);
    
     //How many mechanical robots are there?
     $robots = Robots::find(array(
         array("type" => "mechanical")
     ));
     echo "There are ", count($robots);
    
     //Get and print virtual robots ordered by name
     $robots = Robots::findFirst(array(
         array("type" => "virtual"),
         "order" => array("name" => 1)
     ));
     foreach ($robots as $robot) {
       echo $robot->name, "\n";
     }
    
     //Get first 100 virtual robots ordered by name
     $robots = Robots::find(array(
         array("type" => "virtual"),
         "order" => array("name" => 1),
         "limit" => 100
     ));
     foreach ($robots as $robot) {
       echo $robot->name, "\n";
     }




public static  **count** (*unknown* $parameters)





public *boolean*  **delete** ()

Deletes a model instance. Returning true on success or false otherwise. 

.. code-block:: php

    <?php

    $robot = Robots::findFirst();
    $robot->delete();
    
    foreach(Robots::find() as $robot){
       $robot->delete();
    }




