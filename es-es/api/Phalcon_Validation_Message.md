---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Validation\Message'
---
# Class **Phalcon\Validation\Message**

*implements* [Phalcon\Validation\MessageInterface](Phalcon_Validation_MessageInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/validation/message.zep)

Encapsula información de validación generado en el proceso de validación

## Métodos

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

Método mágico __set_state ayuda a recuperar los mensajes desde la serialización