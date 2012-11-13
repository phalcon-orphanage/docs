Class **Phalcon\\Mvc\\Model\\Resultset\\Simple**
================================================

*extends* :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`

*implements* Serializable, ArrayAccess, Countable, SeekableIterator, Traversable, Iterator, :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`

Simple resultsets only contains a complete object. This class builds every complete object as it's required


Methods
---------

public  **__construct** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $model, :doc:`Phalcon\\Db\\Result\\Pdo <Phalcon_Db_Result_Pdo>` $result, :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>` $cache)

Phalcon\\Mvc\\Model\\Resultset\\Simple constructor



public *boolean*  **valid** ()

Check whether internal resource has rows to fetch



public *string*  **serialize** ()

Serializing a resultset will dump all related rows into a big array



public  **unserialize** (*string* $data)

Unserializing a resultset will allow to only works on the rows present in the saved state



public  **next** () inherited from Phalcon\\Mvc\\Model\\Resultset

Moves cursor to next row in the resultset



public *int*  **key** () inherited from Phalcon\\Mvc\\Model\\Resultset

Gets pointer number of active row in the resultset



public  **rewind** () inherited from Phalcon\\Mvc\\Model\\Resultset

Rewinds resultset to its beginning



public  **seek** (*int* $position) inherited from Phalcon\\Mvc\\Model\\Resultset

Changes internal pointer to a specific position in the resultset



public *int*  **count** () inherited from Phalcon\\Mvc\\Model\\Resultset

Counts how many rows are in the resultset



public *boolean*  **offsetExists** (*int* $index) inherited from Phalcon\\Mvc\\Model\\Resultset

Checks whether offset exists in the resultset



public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>`  **offsetGet** (*int* $index) inherited from Phalcon\\Mvc\\Model\\Resultset

Gets row in a specific position of the resultset



public  **offsetSet** (*int* $index, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $value) inherited from Phalcon\\Mvc\\Model\\Resultset

Resulsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public  **offsetUnset** (*int* $offset) inherited from Phalcon\\Mvc\\Model\\Resultset

Resulsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>`  **getFirst** () inherited from Phalcon\\Mvc\\Model\\Resultset

Get first row in the resultset



public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>`  **getLast** () inherited from Phalcon\\Mvc\\Model\\Resultset

Get last row in the resultset



public  **setIsFresh** (*boolean* $isFresh) inherited from Phalcon\\Mvc\\Model\\Resultset

Set if the resultset is fresh or an old one cached



public *boolean*  **isFresh** () inherited from Phalcon\\Mvc\\Model\\Resultset

Tell if the resultset if fresh or an old one cached



public :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`  **getCache** () inherited from Phalcon\\Mvc\\Model\\Resultset

Returns the associated cache for the resultset



public *object*  **current** () inherited from Phalcon\\Mvc\\Model\\Resultset

Returns current row in the resultset



