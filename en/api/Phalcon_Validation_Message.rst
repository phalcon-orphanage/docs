Class **Phalcon\\Validation\\Message**
======================================

Encapsulates validation info generated in the validation process


Methods
---------

public  **__construct** (*string* $message, [*string* $field], [*string* $type], [*int* $code])

Phalcon\\Validation\\Message constructor



public :doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>`  **setType** (*string* $type)

Sets message type



public *string*  **getType** ()

Returns message type



public :doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>`  **setCode** (*string* $code)

Sets message code



public *string*  **getCode** ()

Returns message code



public :doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>`  **setMessage** (*string* $message)

Sets verbose message



public *string*  **getMessage** ()

Returns verbose message



public :doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>`  **setField** (*string* $field)

Sets field name related to message



public *string*  **getField** ()

Returns field name related to message



public *string*  **__toString** ()

Magic __toString method returns verbose message



public static :doc:`Phalcon\\Validation\\Message <Phalcon_Validation_Message>`  **__set_state** (*array* $message)

Magic __set_state helps to recover messsages from serialization



