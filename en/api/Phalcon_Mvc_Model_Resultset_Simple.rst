Class **Phalcon\\Mvc\\Model\\Resultset\\Simple**
================================================

*extends* :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`

*implements* Serializable, ArrayAccess, Countable, SeekableIterator, Traversable, Iterator, :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`

Simple resultsets only contains a complete objects This class builds every complete object as it is required


Constants
---------

*integer* **TYPE_RESULT_FULL**

*integer* **TYPE_RESULT_PARTIAL**

*integer* **HYDRATE_RECORDS**

*integer* **HYDRATE_OBJECTS**

*integer* **HYDRATE_ARRAYS**

Methods
---------

public  **__construct** (*array* $columnMap, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, :doc:`Phalcon\\Db\\Result\\Pdo <Phalcon_Db_Result_Pdo>` $result, [:doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>` $cache])

Phalcon\\Mvc\\Model\\Resultset\\Simple constructor



public *boolean*  **valid** ()

Check whether internal resource has rows to fetch



public *array*  **toArray** ()

Returns a complete resultset as an array, if the resultset has a big number of rows it could consume more memory than currently it does.



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



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **offsetGet** (*int* $index) inherited from Phalcon\\Mvc\\Model\\Resultset

Gets row in a specific position of the resultset



public  **offsetSet** (*int* $index, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $value) inherited from Phalcon\\Mvc\\Model\\Resultset

Resulsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public  **offsetUnset** (*int* $offset) inherited from Phalcon\\Mvc\\Model\\Resultset

Resulsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public *int*  **getType** () inherited from Phalcon\\Mvc\\Model\\Resultset

Returns the internal type of data retrieval that the resultset is using



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getFirst** () inherited from Phalcon\\Mvc\\Model\\Resultset

Get first row in the resultset



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getLast** () inherited from Phalcon\\Mvc\\Model\\Resultset

Get last row in the resultset



public :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`  **setIsFresh** (*boolean* $isFresh) inherited from Phalcon\\Mvc\\Model\\Resultset

Set if the resultset is fresh or an old one cached



public *boolean*  **isFresh** () inherited from Phalcon\\Mvc\\Model\\Resultset

Tell if the resultset if fresh or an old one cached



public :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`  **setHydrateMode** (*int* $hydrateMode) inherited from Phalcon\\Mvc\\Model\\Resultset

Sets the hydration mode in the resultset



public *int*  **getHydrateMode** () inherited from Phalcon\\Mvc\\Model\\Resultset

Returns the current hydration mode



public :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`  **getCache** () inherited from Phalcon\\Mvc\\Model\\Resultset

Returns the associated cache for the resultset



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **current** () inherited from Phalcon\\Mvc\\Model\\Resultset

Returns current row in the resultset



public :doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>` [] **getMessages** () inherited from Phalcon\\Mvc\\Model\\Resultset

Returns the error messages produced by a batch operation



public *boolean*  **delete** ([*Closure* $conditionCallback]) inherited from Phalcon\\Mvc\\Model\\Resultset

Delete every record in the resultset



