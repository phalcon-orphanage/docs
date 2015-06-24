Class **Phalcon\\Mvc\\Model\\Row**
==================================

*implements* ArrayAccess, :doc:`Phalcon\\Mvc\\Model\\ResultInterface <Phalcon_Mvc_Model_ResultInterface>`

This component allows Phalcon\\Mvc\\Model to return rows without an associated entity. This objects implements the ArrayAccess interface to allow access the object as object->x or array[x].


Methods
-------

public  **setDirtyState** (*unknown* $dirtyState)

Set the current object's state



public *boolean*  **offsetExists** (*string|int* $index)

Checks whether offset exists in the row



public *string|Phalcon\Mvc\ModelInterface*  **offsetGet** (*unknown* $index)

Gets a record in a specific position of the row



public  **offsetSet** (*unknown* $index, *unknown* $value)

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public  **offsetUnset** (*unknown* $offset)

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public *array*  **toArray** ()

Returns the instance as an array representation



