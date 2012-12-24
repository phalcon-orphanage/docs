Interface **Phalcon\\Mvc\\CollectionInterface**
===============================================

Phalcon\\Mvc\\CollectionInterface initializer


Methods
---------

abstract public  **__construct** ([:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector])

Phalcon\\Mvc\\Collection



abstract public  **setId** (*mixed* $id)

Sets a value for the _id propery, creates a MongoId object if needed



abstract public *MongoId*  **getId** ()

Returns the value of the _id property



abstract public *array*  **getReservedAttributes** ()

Returns an array with reserved properties that cannot be part of the insert/update



abstract public *string*  **getSource** ()

Returns collection name mapped in the model



abstract public  **setConnectionService** (*string* $connectionService)

Sets a service in the services container that returns the Mongo database



abstract public *MongoDb*  **getConnection** ()

Retrieves a database connection



abstract public *mixed*  **readAttribute** (*string* $attribute)

Reads an attribute value by its name 

.. code-block:: php

    <?php

    echo $robot->readAttribute('name');




abstract public  **writeAttribute** (*string* $attribute, *mixed* $value)

Writes an attribute value by its name 

.. code-block:: php

    <?php

    $robot->writeAttribute('name', 'Rosey');




abstract public static :doc:`Phalcon\\Mvc\\Collection <Phalcon_Mvc_Collection>`  **dumpResult** (:doc:`Phalcon\\Mvc\\Collection <Phalcon_Mvc_Collection>` $collection, *array* $document)

Returns a cloned collection



abstract public *boolean*  **validationHasFailed** ()

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




abstract public :doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>` [] **getMessages** ()

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




abstract public  **appendMessage** (:doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>` $message)

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




abstract public *boolean*  **save** ()

Creates/Updates a collection based on the values in the atributes



abstract public static :doc:`Phalcon\\Mvc\\Collection <Phalcon_Mvc_Collection>`  **findById** (*string* $id)

Find a document by its id



abstract public static *array*  **findFirst** ([*array* $parameters])

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




abstract public static *array*  **find** ([*array* $parameters])

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




abstract public static *array*  **count** ([*array* $parameters])

Perform a count over a collection



abstract public *boolean*  **delete** ()

Deletes a model instance. Returning true on success or false otherwise. 

.. code-block:: php

    <?php

    $robot = Robots::findFirst();
    $robot->delete();
    
    foreach(Robots::find() as $robot){
       $robot->delete();
    }




