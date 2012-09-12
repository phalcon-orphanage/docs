Class **Phalcon\\Mvc\\Model\\Row**
==================================

*implements* ArrayAccess

This component allows Phalcon\\Mvc\\Model to return rows without an associated entity. This objects implements the ArrayAccess interfase to allow access the object as object->x or array[x].


Methods
---------

public **setForceExists** ()

...


*boolean* public **offsetExists** (*int* $index)

Checks whether offset exists in the row



*string|Phalcon\Mvc\Model* public **offsetGet** (*int* $index)

Gets row in a specific position of the row



public **offsetSet** (*int* $index, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $value)

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public **offsetUnset** (*int* $offset)

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



