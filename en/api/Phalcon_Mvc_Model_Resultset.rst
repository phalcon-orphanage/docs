Class **Phalcon\\Mvc\\Model\\Resultset**
========================================

This component allows to Phalcon\\Mvc\\Model returns large resulsets with the minimum memory consumption Resulsets can be traversed using a standard foreach or a while statement. If a resultset is serialized it will dump all the rows into a big array. Then unserialize will retrieve the rows as they were before serializing. 

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

public **next** ()

Moves cursor to next row in the resultset



*int* public **key** ()

Gets pointer number of active row in the resultset



public **rewind** ()

Rewinds resultset to its beginning



public **seek** (*int* $position)

Changes internal pointer to a specific position in the resultset



*int* public **count** ()

Counts how many rows are in the resultset



*boolean* public **offsetExists** (*int* $index)

Checks whether offset exists in the resultset



:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` public **offsetGet** (*int* $index)

Gets row in a specific position of the resultset



public **offsetSet** (*int* $index, *Phalcon\Mvc\Model* $value)

Resulsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public **offsetUnset** (*int* $offset)

Resulsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` public **getFirst** ()

Get first row in the resultset



:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` public **getLast** ()

Get last row in the resultset



public **setIsFresh** (*boolean* $isFresh)

Set if the resultset is fresh or an old one cached



*boolean* public **isFresh** ()

Tell if the resultset if fresh or an old one cached



:doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>` public **getCache** ()

Returns the associated cache for the resultset



*object* public **current** ()

Returns current row in the resultset



