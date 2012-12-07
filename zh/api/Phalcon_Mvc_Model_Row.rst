Class **Phalcon\\Mvc\\Model\\Row**
==================================

<<<<<<< HEAD
*implements* ArrayAccess

This component allows Phalcon\\Mvc\\Model to return rows without an associated entity. This objects implements the ArrayAccess interfase to allow access the object as object->x or array[x].
=======
*implements* ArrayAccess, :doc:`Phalcon\\Mvc\\Model\\ResultInterface <Phalcon_Mvc_Model_ResultInterface>`

This component allows Phalcon\\Mvc\\Model to return rows without an associated entity. This objects implements the ArrayAccess interface to allow access the object as object->x or array[x].
>>>>>>> 0.7.0


Methods
---------

<<<<<<< HEAD
public  **setForceExists** ()

...
=======
public  **setForceExists** (*boolean* $forceExists)

Forces that a model doesn't need to be checked if exists before store it

>>>>>>> 0.7.0


public *boolean*  **offsetExists** (*int* $index)

Checks whether offset exists in the row



<<<<<<< HEAD
public *string|Phalcon\Mvc\Model*  **offsetGet** (*int* $index)
=======
public *string|Phalcon\Mvc\ModelInterface*  **offsetGet** (*int* $index)
>>>>>>> 0.7.0

Gets row in a specific position of the row



<<<<<<< HEAD
public  **offsetSet** (*int* $index, :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $value)
=======
public  **offsetSet** (*int* $index, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $value)
>>>>>>> 0.7.0

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public  **offsetUnset** (*int* $offset)

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



