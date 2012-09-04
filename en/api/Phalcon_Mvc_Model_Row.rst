Class **Phalcon\\Mvc\\Model\\Row**
==================================

*implements* ArrayAccess

Methods
---------

public **setForceExists** ()

*boolean* public **offsetExists** (*int* $index)

Checks whether offset exists in the row



:doc:`string|Phalcon\\Mvc\\Model <string|Phalcon_Mvc_Model>` public **offsetGet** (*int* $index)

Gets row in a specific position of the row



public **offsetSet** (*int* $index, *Phalcon\Mvc\Model* $value)

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public **offsetUnset** (*int* $offset)

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



