Class **Phalcon\\Mvc\\Collection\\Document**
============================================

*implements* ArrayAccess

This component allows Phalcon\\Mvc\\Collection to return rows without an associated entity. This objects implements the ArrayAccess interface to allow access the object as object->x or array[x].


Methods
---------

public *boolean*  **offsetExists** (*int* $index)

Checks whether offset exists in the row



public *mixed*  **offsetGet** (*string* $index)

Returns the value of a field using the ArrayAccess interfase



public  **offsetSet** (*string* $index, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $value)

Change a value using the ArrayAccess interface



public  **offsetUnset** (*string* $offset)

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public *mixed*  **readAttribute** (*string* $attribute)

Reads an attribute value by its name 

.. code-block:: php

    <?php

    echo $robot->readAttribute('name');




public  **writeAttribute** (*string* $attribute, *mixed* $value)

Writes an attribute value by its name 

.. code-block:: php

    <?php

    $robot->writeAttribute('name', 'Rosey');




