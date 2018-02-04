# Class **Phalcon\\Validation\\Message**

*implements* [Phalcon\Validation\MessageInterface](/en/3.2/api/Phalcon_Validation_MessageInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/message.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Encapsulates validation info generated in the validation process

## Methods

public **__construct** (*mixed* $message, [*mixed* $field], [*mixed* $type], [*mixed* $code])

Phalcon\\Validation\\Message constructor

public **setType** (*mixed* $type)

Sets message type

public **getType** ()

Returns message type

public **setMessage** (*mixed* $message)

Sets verbose message

public **getMessage** ()

Returns verbose message

public **setField** (*mixed* $field)

Sets field name related to message

public *mixed* **getField** ()

Returns field name related to message

public **setCode** (*mixed* $code)

Sets code for the message

public **getCode** ()

Returns the message code

public **__toString** ()

Magic __toString method returns verbose message

public static **__set_state** (*array* $message)

Magic __set_state helps to recover messages from serialization