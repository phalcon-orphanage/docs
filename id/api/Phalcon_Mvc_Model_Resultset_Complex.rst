Class **Phalcon\\Mvc\\Model\\Resultset\\Complex**
=================================================

*extends* abstract class :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`

*implements* JsonSerializable, Serializable, ArrayAccess, Countable, SeekableIterator, Traversable, Iterator, :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/resultset/complex.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Complex resultsets may include complete objects and scalar values. This class builds every complex row as it is required


Constants
---------

*integer* **TYPE_RESULT_FULL**

*integer* **TYPE_RESULT_PARTIAL**

*integer* **HYDRATE_RECORDS**

*integer* **HYDRATE_OBJECTS**

*integer* **HYDRATE_ARRAYS**

Methods
-------

public  **__construct** (*array* $columnTypes, [:doc:`Phalcon\\Db\\ResultInterface <Phalcon_Db_ResultInterface>` $result], [:doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>` $cache])

Phalcon\\Mvc\\Model\\Resultset\\Complex constructor



final public  **current** ()

Returns current row in the resultset



public  **toArray** ()

Returns a complete resultset as an array, if the resultset has a big number of rows it could consume more memory than currently it does.



public  **serialize** ()

Serializing a resultset will dump all related rows into a big array



public  **unserialize** (*mixed* $data)

Unserializing a resultset will allow to only works on the rows present in the saved state



public  **next** () inherited from Phalcon\\Mvc\\Model\\Resultset

Moves cursor to next row in the resultset



public  **valid** () inherited from Phalcon\\Mvc\\Model\\Resultset

Check whether internal resource has rows to fetch



public  **key** () inherited from Phalcon\\Mvc\\Model\\Resultset

Gets pointer number of active row in the resultset



final public  **rewind** () inherited from Phalcon\\Mvc\\Model\\Resultset

Rewinds resultset to its beginning



final public  **seek** (*mixed* $position) inherited from Phalcon\\Mvc\\Model\\Resultset

Changes internal pointer to a specific position in the resultset Set new position if required and set this->_row



final public  **count** () inherited from Phalcon\\Mvc\\Model\\Resultset

Counts how many rows are in the resultset



public  **offsetExists** (*mixed* $index) inherited from Phalcon\\Mvc\\Model\\Resultset

Checks whether offset exists in the resultset



public  **offsetGet** (*mixed* $index) inherited from Phalcon\\Mvc\\Model\\Resultset

Gets row in a specific position of the resultset



public  **offsetSet** (*int* $index, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $value) inherited from Phalcon\\Mvc\\Model\\Resultset

Resultsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public  **offsetUnset** (*mixed* $offset) inherited from Phalcon\\Mvc\\Model\\Resultset

Resultsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public  **getType** () inherited from Phalcon\\Mvc\\Model\\Resultset

Returns the internal type of data retrieval that the resultset is using



public  **getFirst** () inherited from Phalcon\\Mvc\\Model\\Resultset

Get first row in the resultset



public  **getLast** () inherited from Phalcon\\Mvc\\Model\\Resultset

Get last row in the resultset



public  **setIsFresh** (*mixed* $isFresh) inherited from Phalcon\\Mvc\\Model\\Resultset

Set if the resultset is fresh or an old one cached



public  **isFresh** () inherited from Phalcon\\Mvc\\Model\\Resultset

Tell if the resultset if fresh or an old one cached



public  **setHydrateMode** (*mixed* $hydrateMode) inherited from Phalcon\\Mvc\\Model\\Resultset

Sets the hydration mode in the resultset



public  **getHydrateMode** () inherited from Phalcon\\Mvc\\Model\\Resultset

Returns the current hydration mode



public  **getCache** () inherited from Phalcon\\Mvc\\Model\\Resultset

Returns the associated cache for the resultset



public  **getMessages** () inherited from Phalcon\\Mvc\\Model\\Resultset

Returns the error messages produced by a batch operation



public *boolean*  **update** (*array* $data, [*\\Closure* $conditionCallback]) inherited from Phalcon\\Mvc\\Model\\Resultset

Updates every record in the resultset



public  **delete** ([*Closure* $conditionCallback]) inherited from Phalcon\\Mvc\\Model\\Resultset

Deletes every record in the resultset



public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` [] **filter** (*callback* $filter) inherited from Phalcon\\Mvc\\Model\\Resultset

Filters a resultset returning only those the developer requires 

.. code-block:: php

    <?php

     $filtered = $robots->filter(function($robot){
    	if ($robot->id < 3) {
    		return $robot;
    	}
    });




public *array*  **jsonSerialize** () inherited from Phalcon\\Mvc\\Model\\Resultset

Returns serialised model objects as array for json_encode. Calls jsonSerialize on each object if present 

.. code-block:: php

    <?php

     $robots = Robots::find();
     echo json_encode($robots);




