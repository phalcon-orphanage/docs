---
layout: default
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Validation\Message'
---
# Class **Phalcon\Validation\Message**

*implements* [Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/validation/message.zep)

Encapsulates validation info generated in the validation process

## 方法

public **__construct** (*mixed* $message, [*mixed* $field], [*mixed* $type], [*mixed* $code])

Phalcon\Validation\Message constructor

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