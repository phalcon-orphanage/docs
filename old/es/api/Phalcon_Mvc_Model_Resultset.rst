Abstract class **Phalcon\\Mvc\\Model\\Resultset**
=================================================

*implements* :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`, `Iterator <http://php.net/manual/en/class.iterator.php>`_, `Traversable <http://php.net/manual/en/class.traversable.php>`_, `SeekableIterator <http://php.net/manual/en/class.seekableiterator.php>`_, `Countable <http://php.net/manual/en/class.countable.php>`_, `ArrayAccess <http://php.net/manual/en/class.arrayaccess.php>`_, `Serializable <http://php.net/manual/en/class.serializable.php>`_, `JsonSerializable <http://php.net/manual/en/class.jsonserializable.php>`_

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/resultset.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This component allows to Phalcon\\Mvc\\Model returns large resultsets with the minimum memory consumption
Resultsets can be traversed using a standard foreach or a while statement. If a resultset is serialized
it will dump all the rows into a big array. Then unserialize will retrieve the rows as they were before
serializing.

.. code-block:: php

    <?php

    // Using a standard foreach
    $robots = Robots::find(
        [
            "type = 'virtual'",
            "order" => "name",
        ]
    );

    foreach ($robots as robot) {
        echo robot->name, "\n";
    }

    // Using a while
    $robots = Robots::find(
        [
            "type = 'virtual'",
            "order" => "name",
        ]
    );

    $robots->rewind();

    while ($robots->valid()) {
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
-------

public  **__construct** (:doc:`Phalcon\\Db\\ResultInterface <Phalcon_Db_ResultInterface>` | *false* $result, [:doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>` $cache])

Phalcon\\Mvc\\Model\\Resultset constructor



public  **next** ()

Moves cursor to next row in the resultset



public  **valid** ()

Check whether internal resource has rows to fetch



public  **key** ()

Gets pointer number of active row in the resultset



final public  **rewind** ()

Rewinds resultset to its beginning



final public  **seek** (*mixed* $position)

Changes internal pointer to a specific position in the resultset
Set new position if required and set this->_row



final public  **count** ()

Counts how many rows are in the resultset



public  **offsetExists** (*mixed* $index)

Checks whether offset exists in the resultset



public  **offsetGet** (*mixed* $index)

Gets row in a specific position of the resultset



public  **offsetSet** (*int* $index, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $value)

Resultsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public  **offsetUnset** (*mixed* $offset)

Resultsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public  **getType** ()

Returns the internal type of data retrieval that the resultset is using



public  **getFirst** ()

Get first row in the resultset



public  **getLast** ()

Get last row in the resultset



public  **setIsFresh** (*mixed* $isFresh)

Set if the resultset is fresh or an old one cached



public  **isFresh** ()

Tell if the resultset if fresh or an old one cached



public  **setHydrateMode** (*mixed* $hydrateMode)

Sets the hydration mode in the resultset



public  **getHydrateMode** ()

Returns the current hydration mode



public  **getCache** ()

Returns the associated cache for the resultset



public  **getMessages** ()

Returns the error messages produced by a batch operation



public *boolean* **update** (*array* $data, [`Closure <http://php.net/manual/en/class.closure.php>`_ $conditionCallback])

Updates every record in the resultset



public  **delete** ([`Closure <http://php.net/manual/en/class.closure.php>`_ $conditionCallback])

Deletes every record in the resultset



public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>`\ [] **filter** (*callback* $filter)

Filters a resultset returning only those the developer requires

.. code-block:: php

    <?php

    $filtered = $robots->filter(
        function ($robot) {
            if ($robot->id < 3) {
                return $robot;
            }
        }
    );




public *array* **jsonSerialize** ()

Returns serialised model objects as array for json_encode.
Calls jsonSerialize on each object if present

.. code-block:: php

    <?php

    $robots = Robots::find();
    echo json_encode($robots);




abstract public  **toArray** () inherited from :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`

...


abstract public  **current** () inherited from `Iterator <http://php.net/manual/en/class.iterator.php>`_

...


abstract public  **serialize** () inherited from `Serializable <http://php.net/manual/en/class.serializable.php>`_

...


abstract public  **unserialize** (*mixed* $serialized) inherited from `Serializable <http://php.net/manual/en/class.serializable.php>`_

...


