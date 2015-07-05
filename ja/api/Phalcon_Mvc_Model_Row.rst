Class **Phalcon\\Mvc\\Model\\Row**
==================================

*implements* :doc:`Phalcon\\Mvc\\EntityInterface <Phalcon_Mvc_EntityInterface>`, :doc:`Phalcon\\Mvc\\Model\\ResultInterface <Phalcon_Mvc_Model_ResultInterface>`, ArrayAccess

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



public *mixed*  **readAttribute** (*unknown* $attribute)

Reads an attribute value by its name 

.. code-block:: php

    <?php

      echo $robot->readAttribute('name');




public  **writeAttribute** (*unknown* $attribute, *unknown* $value)

Writes an attribute value by its name 

.. code-block:: php

    <?php

      $robot->writeAttribute('name', 'Rosey');




public *array*  **toArray** ()

Returns the instance as an array representation



