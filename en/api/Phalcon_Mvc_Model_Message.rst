Class **Phalcon\\Mvc\\Model\\Message**
======================================

*implements* :doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>`

Methods
---------

public  **__construct** (*string* $message, [*string* $field], [*string* $type], [:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model])

Phalcon\\Mvc\\Model\\Message constructor



public :doc:`Phalcon\\Mvc\\Model\\Message <Phalcon_Mvc_Model_Message>`  **setType** (*string* $type)

Sets message type



public *string*  **getType** ()

Returns message type



public :doc:`Phalcon\\Mvc\\Model\\Message <Phalcon_Mvc_Model_Message>`  **setMessage** (*string* $message)

Sets verbose message



public *string*  **getMessage** ()

Returns verbose message



public :doc:`Phalcon\\Mvc\\Model\\Message <Phalcon_Mvc_Model_Message>`  **setField** (*string* $field)

Sets field name related to message



public *string*  **getField** ()

Returns field name related to message



public :doc:`Phalcon\\Mvc\\Model\\Message <Phalcon_Mvc_Model_Message>`  **setModel** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Set the model who generates the message



public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **getModel** ()

Returns the model that produced the message



public *string*  **__toString** ()

Magic __toString method returns verbose message



public static :doc:`Phalcon\\Mvc\\Model\\Message <Phalcon_Mvc_Model_Message>`  **__set_state** (*array* $message)

Magic __set_state helps to re-build messages variable exporting



