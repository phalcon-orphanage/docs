Class **Phalcon\\Mvc\\Model\\Resultset\\Complex**
=================================================

*extends* :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`

*implements* Iterator, Traversable, SeekableIterator, Countable, ArrayAccess, Serializable

Methods
---------

public **__construct** (*array* $columnsTypes, *Phalcon\Db\Result* $result, *Phalcon\Cache\Backend* $cache)

Phalcon\\Mvc\\Model\\Resultset constructor



*boolean* public **valid** ()

Check whether internal resource has rows to fetch



*string* public **serialize** ()

Serializing a resultset will dump all related rows into a big array



public **unserialize** (*string* $data)

Unserializing a resultset will allow to only works on the rows present in the saved state



:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` public **current** ()

Returns current row in the resultset



public **next** ()

public **key** ()

public **rewind** ()

public **seek** (*unknown* $position)

public **count** ()

public **offsetExists** (*unknown* $index)

public **offsetGet** (*unknown* $index)

public **offsetSet** (*unknown* $index, *unknown* $value)

public **offsetUnset** (*unknown* $offset)

public **getFirst** ()

public **getLast** ()

public **isFresh** ()

public **getCache** ()

