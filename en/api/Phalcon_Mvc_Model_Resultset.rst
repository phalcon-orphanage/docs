Class **Phalcon\\Mvc\\Model\\Resultset**
========================================

Phalcon\\Mvc\\Model\\Resultset   This component allows to Phalcon\\Mvc\\Model returns large resulsets with the minimum memory consumption  Resulsets can be traversed using a standard foreach or a while statement. If a resultset is serialized  it will dump all the rows into a big array. Then unserialize will retrieve the rows as they were before  serializing.   

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

**next** ()

**key** ()

**rewind** ()

**seek** (*int* **$position**)

*int* **count** ()

*boolean* **offsetExists** (*int* **$index**)

:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` **offsetGet** (*int* **$index**)

**offsetSet** (*int* **$index**, *Phalcon\Mvc\Model* **$value**)

**offsetUnset** (*int* **$offset**)

:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` **getFirst** ()

:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` **getLast** ()

*boolean* **isFresh** ()

:doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>` **getCache** ()

