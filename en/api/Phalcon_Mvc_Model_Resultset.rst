Class **Phalcon_Model_Resultset**
=================================

*implements* Iterator, Traversable, SeekableIterator, Countable, ArrayAccess, Serializable

This component allows to Phalcon_Model_Base returns large resulsets with the minimum memory consumption  Resulsets can be traversed using a standard foreach or a while statement. If a resultset is serialized  it will dump all the rows into a big array. Then unserialize will retrieve the rows as they were before serializing.   

.. code-block:: php

    <?php
    
    // Using a standard foreach
    $robots = $Robots->find(array("type='virtual'", "order" => "name"));
    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // Using a while
    $robots = $Robots->find(array("type='virtual'", "order" => "name"));
    $robots->rewind();
    while ($robots->valid()) {
        $robot = $robots->current();
        echo $robot->name, "\n";
        $robots->next();
    }

Methods
---------

**__construct** (Phalcon_Model_Base $model, Phalcon_Model_Result $result, Phalcon_Model_Cache $cache)

Phalcon_Model_Resultset constructor

**boolean** **valid** ()

Check whether internal resource has rows to fetch

**Phalcon_Model_Base** **current** ()

Returns current row in the resultset

**next** ()

Moves cursor to next row in the resultset

**key** ()

Gets pointer number of active row in the resultset

**rewind** ()

Rewinds resultset to its beginning

**seek** (int $position)

Changes internal pointer to a specific position in the resultset

**int** **count** ()

Counts how many rows are in the resultset

**boolean** **offsetExists** (int $index)

Checks whether offset exists in the resultset

**Phalcon_Model_Base** **offsetGet** (int $index)

Gets row in a specific position of the resultset

**offsetSet** (int $index, Phalcon_Model_Base $value)

Resulsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface

**offsetUnset** (int $offset)

Resulsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface

**Phalcon_Model_Base** **getFirst** ()

Get first row in the resultset

**Phalcon_Model_Base** **getLast** ()

Get last row in the resultset

**boolean** **isFresh** ()

Tell if the resultset if fresh or an old cached

**string** **serialize** ()

Serializing a resultset will dump all related rows into a big array

**unserialize** (string $data)

Unserializing a resultset will allow to only works on the rows present in the saved state

**Phalcon_Cache_Backend** **getCache** ()

Returns the associated cache for the resultset

**Phalcon_Model_Base** **getSourceModel** ()

Returns an instance of the model that is used to generate each of the results

