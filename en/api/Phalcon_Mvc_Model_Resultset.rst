Class **Phalcon\\Mvc\\Model\\Resultset**
========================================

*implements* :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`, Iterator, Traversable, SeekableIterator, Countable, ArrayAccess, Serializable

This component allows to Phalcon\\Mvc\\Model returns large resulsets with the minimum memory consumption Resulsets can be traversed using a standard foreach or a while statement. If a resultset is serialized it will dump all the rows into a big array. Then unserialize will retrieve the rows as they were before serializing.  

.. code-block:: php

    <?php

     //Using a standard foreach
     $robots = Robots::find(array("type='virtual'", "order" => "name"));
     foreach($robots as $robot){
      echo $robot->name, "\n";
     }
    
     //Using a while
     $robots = Robots::find(array("type='virtual'", "order" => "name"));
     $robots->rewind();
     while($robots->valid()){
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
---------

public  **next** ()

Moves cursor to next row in the resultset



public *int*  **key** ()

Gets pointer number of active row in the resultset



public  **rewind** ()

Rewinds resultset to its beginning



public  **seek** (*int* $position)

Changes internal pointer to a specific position in the resultset



public *int*  **count** ()

Counts how many rows are in the resultset



public *boolean*  **offsetExists** (*int* $index)

Checks whether offset exists in the resultset



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **offsetGet** (*int* $index)

Gets row in a specific position of the resultset



public  **offsetSet** (*int* $index, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $value)

Resulsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public  **offsetUnset** (*int* $offset)

Resulsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public *int*  **getType** ()

Returns the internal type of data retrieval that the resultset is using



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getFirst** ()

Get first row in the resultset



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getLast** ()

Get last row in the resultset



public  **setIsFresh** (*boolean* $isFresh)

Set if the resultset is fresh or an old one cached



public *boolean*  **isFresh** ()

Tell if the resultset if fresh or an old one cached



public  **setHydrateMode** (*int* $hydrateMode)

Sets the hydration mode in the resultset



public *int*  **getHydrateMode** ()

Returns the current hydration mode



public :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`  **getCache** ()

Returns the associated cache for the resultset



public *object*  **current** ()

Returns current row in the resultset



public :doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>` [] **getMessages** ()

Returns the error messages produced by a batch operation



public *boolean*  **delete** ([*Closure* $conditionCallback])

Delete every record in the resultset



abstract public *array*  **toArray** () inherited from Phalcon\\Mvc\\Model\\ResultsetInterface

Returns a complete resultset as an array, if the resultset has a big number of rows it could consume more memory than currently it does.



abstract public  **valid** () inherited from Iterator

...


abstract public  **serialize** () inherited from Serializable

...


abstract public  **unserialize** (*unknown* $serialized) inherited from Serializable

...


