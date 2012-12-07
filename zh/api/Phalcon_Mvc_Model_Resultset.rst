Class **Phalcon\\Mvc\\Model\\Resultset**
========================================

<<<<<<< HEAD
This component allows to Phalcon\\Mvc\\Model returns large resulsets with the minimum memory consumption Resulsets can be traversed using a standard foreach or a while statement. If a resultset is serialized it will dump all the rows into a big array. Then unserialize will retrieve the rows as they were before serializing. 
=======
*implements* :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`, Iterator, Traversable, SeekableIterator, Countable, ArrayAccess, Serializable

This component allows to Phalcon\\Mvc\\Model returns large resulsets with the minimum memory consumption Resulsets can be traversed using a standard foreach or a while statement. If a resultset is serialized it will dump all the rows into a big array. Then unserialize will retrieve the rows as they were before serializing.  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

     //Using a standard foreach
     $robots = $Robots::find(array("type='virtual'", "order" => "name"));
     foreach($robots as $robot){
      echo $robot->name, "\n";
     }
    
     //Using a while
     $robots = $Robots::find(array("type='virtual'", "order" => "name"));
     $robots->rewind();
     while($robots->valid()){
      $robot = $robots->current();
      echo $robot->name, "\n";
      $robots->next();
     }



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



public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>`  **offsetGet** (*int* $index)

Gets row in a specific position of the resultset



public  **offsetSet** (*int* $index, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $value)

Resulsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public  **offsetUnset** (*int* $offset)

Resulsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>`  **getFirst** ()

Get first row in the resultset



public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>`  **getLast** ()

Get last row in the resultset



public  **setIsFresh** (*boolean* $isFresh)

Set if the resultset is fresh or an old one cached



public *boolean*  **isFresh** ()

Tell if the resultset if fresh or an old one cached



public :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`  **getCache** ()

Returns the associated cache for the resultset



public *object*  **current** ()

Returns current row in the resultset



<<<<<<< HEAD
=======
abstract public  **valid** () inherited from Iterator

...


abstract public  **serialize** () inherited from Serializable

...


abstract public  **unserialize** (*unknown* $serialized) inherited from Serializable

...


>>>>>>> 0.7.0
