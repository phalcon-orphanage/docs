Class **Phalcon\\Mvc\\Model\\Row**
==================================

*implements* ArrayAccess, Countable, :doc:`Phalcon\\Mvc\\Model\\ResultInterface <Phalcon_Mvc_Model_ResultInterface>`

This component allows Phalcon\\Mvc\\Model to return rows without an associated entity. This objects implements the ArrayAccess interface to allow access the object as object->x or array[x].


Methods
-------

public  **setDirtyState** (*int* $dirtyState)

Set the current object's state



public *boolean*  **offsetExists** (*int* $index)

Checks whether offset exists in the row



public *string|\Phalcon\Mvc\ModelInterface*  **offsetGet** (*int* $index)

Gets a record in a specific position of the row



public  **offsetSet** (*int* $index, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $value)

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public  **offsetUnset** (*int* $offset)

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public *array*  **toArray** ()

Returns the instance as an array representation



<<<<<<< HEAD
public  **count** ()

...


public  **__wakeup** ()

...


=======
>>>>>>> master
