Class **Phalcon\\Mvc\\Model\\Resultset\\Complex**
=================================================

*extends* :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`

*implements* Iterator, Traversable, SeekableIterator, Countable, ArrayAccess, Serializable

Complex resultsets may include complete objects and scalar values. This class builds every complex row as the're required


Methods
---------

public **__construct** (*array* $columnsTypes, :doc:`Phalcon\\Db\\Result\\Pdo <Phalcon_Db_Result_Pdo>` $result, :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>` $cache)

Phalcon\\Mvc\\Model\\Resultset\\Complex constructor



*boolean* public **valid** ()

Check whether internal resource has rows to fetch



*string* public **serialize** ()

Serializing a resultset will dump all related rows into a big array



public **unserialize** (*string* $data)

Unserializing a resultset will allow to only works on the rows present in the saved state



public **next** () inherited from Phalcon_Mvc_Model_Resultset

Moves cursor to next row in the resultset



*int* public **key** () inherited from Phalcon_Mvc_Model_Resultset

Gets pointer number of active row in the resultset



public **rewind** () inherited from Phalcon_Mvc_Model_Resultset

Rewinds resultset to its beginning



public **seek** (*int* $position) inherited from Phalcon_Mvc_Model_Resultset

Changes internal pointer to a specific position in the resultset



*int* public **count** () inherited from Phalcon_Mvc_Model_Resultset

Counts how many rows are in the resultset



*boolean* public **offsetExists** (*int* $index) inherited from Phalcon_Mvc_Model_Resultset

Checks whether offset exists in the resultset



:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` public **offsetGet** (*int* $index) inherited from Phalcon_Mvc_Model_Resultset

Gets row in a specific position of the resultset



public **offsetSet** (*int* $index, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $value) inherited from Phalcon_Mvc_Model_Resultset

Resulsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public **offsetUnset** (*int* $offset) inherited from Phalcon_Mvc_Model_Resultset

Resulsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` public **getFirst** () inherited from Phalcon_Mvc_Model_Resultset

Get first row in the resultset



:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` public **getLast** () inherited from Phalcon_Mvc_Model_Resultset

Get last row in the resultset



public **setIsFresh** (*boolean* $isFresh) inherited from Phalcon_Mvc_Model_Resultset

Set if the resultset is fresh or an old one cached



*boolean* public **isFresh** () inherited from Phalcon_Mvc_Model_Resultset

Tell if the resultset if fresh or an old one cached



:doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>` public **getCache** () inherited from Phalcon_Mvc_Model_Resultset

Returns the associated cache for the resultset



*object* public **current** () inherited from Phalcon_Mvc_Model_Resultset

Returns current row in the resultset



