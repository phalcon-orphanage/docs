Abstract class **Phalcon\\Mvc\\Model\\Resultset**
=================================================

*implements* :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`, Iterator, Traversable, SeekableIterator, Countable, ArrayAccess, Serializable

This component allows to Phalcon\\Mvc\\Model returns large resultsets with the minimum memory consumption Resultsets can be traversed using a standard foreach or a while statement. If a resultset is serialized it will dump all the rows into a big array. Then unserialize will retrieve the rows as they were before serializing.  

.. code-block:: php

    <?php

     //Using a standard foreach
     $robots = Robots::find(array("type='virtual'", "order" => "name"));
     foreach ($robots as robot) {
      echo robot->name, "\n";
     }
    
     //Using a while
     $robots = Robots::find(array("type='virtual'", "order" => "name"));
     $robots->rewind();
     while ($robots->valid()) {
      $robot = $robots->current();
      echo $robot->name, "\n";
      $robots->next();
     }



Constants
---------

*integer* **TYPE_RESULT_FULL**

*integer* **TYPE_RESULT_PARTIAL**

*integer* **HYDRATE_RECORDS**

*integer* **HYDRATE_OBJECTS**

*integer* **HYDRATE_ARRAYS**

Methods
-------

public  **__construct** (*Phalcon\\Db\\ResultInterface|false* $result, [:doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>` $cache])

Phalcon\\Mvc\\Model\\Resultset constructor



public  **next** ()

Moves cursor to next row in the resultset



public  **valid** ()

Check whether internal resource has rows to fetch



public  **key** ()

Gets pointer number of active row in the resultset



final public  **rewind** ()

Rewinds resultset to its beginning



final public  **seek** (*unknown* $position)

Changes internal pointer to a specific position in the resultset Set new position if required and set this->_row



final public  **count** ()

Counts how many rows are in the resultset



public  **offsetExists** (*unknown* $index)

Checks whether offset exists in the resultset



public  **offsetGet** (*unknown* $index)

Gets row in a specific position of the resultset



public  **offsetSet** (*int* $index, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $value)

Resultsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public  **offsetUnset** (*unknown* $offset)

Resultsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public  **getType** ()

Returns the internal type of data retrieval that the resultset is using



public  **getFirst** ()

Get first row in the resultset



public  **getLast** ()

Get last row in the resultset



public  **setIsFresh** (*unknown* $isFresh)

Set if the resultset is fresh or an old one cached



public  **isFresh** ()

Tell if the resultset if fresh or an old one cached



public  **setHydrateMode** (*unknown* $hydrateMode)

Sets the hydration mode in the resultset



public  **getHydrateMode** ()

Returns the current hydration mode



public  **getCache** ()

Returns the associated cache for the resultset



public  **getMessages** ()

Returns the error messages produced by a batch operation



public *boolean*  **update** (*array* $data, [*Closure* $conditionCallback])

Updates every record in the resultset



public  **delete** ([*unknown* $conditionCallback])

Deletes every record in the resultset



public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` [] **filter** (*callback* $filter)

Filters a resultset returning only those the developer requires 

.. code-block:: php

    <?php

     $filtered = $robots->filter(function($robot){
    	if ($robot->id < 3) {
    		return $robot;
    	}
    });




abstract public  **toArray** () inherited from Phalcon\\Mvc\\Model\\ResultsetInterface

...


abstract public  **current** () inherited from Iterator

...


abstract public  **serialize** () inherited from Serializable

...


abstract public  **unserialize** (*unknown* $serialized) inherited from Serializable

...


