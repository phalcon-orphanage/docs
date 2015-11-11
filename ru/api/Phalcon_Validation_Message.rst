Class **Phalcon\\Validation\\Message**
======================================

*implements* :doc:`Phalcon\\Validation\\MessageInterface <Phalcon_Validation_MessageInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/message.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Encapsulates validation info generated in the validation process


Methods
-------

public  **__construct** (*unknown* $message, [*unknown* $field], [*unknown* $type], [*unknown* $code])

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



public  **setCode** (*unknown* $code)

Sets code for the message



public  **getCode** ()

Returns the message code



public  **__toString** ()

Magic __toString method returns verbose message



public static  **__set_state** (*unknown* $message)

Magic __set_state helps to recover messsages from serialization



