Class **Phalcon\\Mvc\\Collection\\Document**
============================================

*implements* ArrayAccess

This component allows Phalcon\\Mvc\\Collection to return rows without an associated entity. This objects implements the ArrayAccess interface to allow access the object as object->x or array[x].


Methods
-------

public *boolean*  **offsetExists** (*unknown* $index)

Checks whether an offset exists in the document



public *mixed*  **offsetGet** (*unknown* $index)

Returns the value of a field using the ArrayAccess interfase



public  **offsetSet** (*unknown* $index, *unknown* $value)

Change a value using the ArrayAccess interface



public  **offsetUnset** (*unknown* $offset)

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface



public *mixed*  **readAttribute** (*unknown* $attribute)

Reads an attribute value by its name 

.. code-block:: php

    <?php

            echo robot->readAttribute('name');




public  **writeAttribute** (*unknown* $attribute, *unknown* $value)

Writes an attribute value by its name 

.. code-block:: php

    <?php

            robot->writeAttribute('name', 'Rosey');




