Class **Phalcon\\Validation\\Message**
======================================

*implements* :doc:`Phalcon\\Validation\\MessageInterface <Phalcon_Validation_MessageInterface>`

Encapsulates validation info generated in the validation process


Methods
-------

public  **__construct** (*unknown* $message, [*unknown* $field], [*unknown* $type])

Phalcon\\Validation\\Message constructor



public :doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>`  **setType** (*unknown* $type)

Sets message type



public *string*  **getType** ()

Returns message type



public :doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>`  **setMessage** (*unknown* $message)

Sets verbose message



public *string*  **getMessage** ()

Returns verbose message



public :doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>`  **setField** (*unknown* $field)

Sets field name related to message



public *string*  **getField** ()

Returns field name related to message



public *string*  **__toString** ()

Magic __toString method returns verbose message



public static :doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>`  **__set_state** (*unknown* $message)

Magic __set_state helps to recover messsages from serialization



