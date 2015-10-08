Class **Phalcon\\Validation\\Message**
======================================

*implements* :doc:`Phalcon\\Validation\\MessageInterface <Phalcon_Validation_MessageInterface>`

Encapsulates validation info generated in the validation process


Methods
-------

public  **__construct** (*string* $message, [*string* $field], [*string* $type])

Phalcon\\Validation\\Message constructor



public  **setType** (*unknown* $type)

Sets message type



public  **getType** ()

Returns message type



public  **setMessage** (*unknown* $message)

Sets verbose message



public  **getMessage** ()

Returns verbose message



public  **setField** (*unknown* $field)

Sets field name related to message



public *string*  **getField** ()

Returns field name related to message



public  **__toString** ()

Magic __toString method returns verbose message



public static  **__set_state** (*unknown* $message)

Magic __set_state helps to recover messsages from serialization



