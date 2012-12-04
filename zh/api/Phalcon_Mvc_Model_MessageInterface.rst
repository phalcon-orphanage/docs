Interface **Phalcon\\Mvc\\Model\\MessageInterface**
===================================================

Phalcon\\Mvc\\Model\\MessageInterface initializer


Methods
---------

abstract public  **__construct** (*string* $message, *string* $field, *string* $type)

Phalcon\\Mvc\\Model\\Message constructor



abstract public  **setType** (*string* $type)

Sets message type



abstract public *string*  **getType** ()

Returns message type



abstract public  **setMessage** (*string* $message)

Sets verbose message



abstract public *string*  **getMessage** ()

Returns verbose message



abstract public  **setField** (*string* $field)

Sets field name related to message



abstract public *string*  **getField** ()

Returns field name related to message



abstract public *string*  **__toString** ()

Magic __toString method returns verbose message



abstract public static :doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>`  **__set_state** (*array* $message)

Magic __set_state helps to recover messsages from serialization



