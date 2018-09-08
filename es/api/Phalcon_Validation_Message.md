# Clase **Phalcon\\Validation\\Message**

*implements* [Phalcon\Validation\MessageInterface](/[[language]]/[[version]]/api/Phalcon_Validation_MessageInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/message.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Encapsula información de validación generado en el proceso de validación

## Métodos

public **__construct** (*mixed* $message, [*mixed* $field], [*mixed* $type], [*mixed* $code])

Phalcon\\Validation\\Message constructor

public **setType** (*mixed* $type)

Establece el tipo de mensaje

public **getType** ()

Devuelve el tipo de mensaje

public **setMessage** (*mixed* $message)

Establece un mensaje detallado

public **getMessage** ()

Devuelve un mensaje detallado

public **setField** (*mixed* $field)

Establece el nombre del campo relacionado al mensaje

public *mixed* **getField** ()

Devuelve el nombre del campo relacionado al mensaje

public **setCode** (*mixed* $code)

Establece el código del mensaje

public **getCode** ()

Devuelve el código del mensaje

public **__toString** ()

Método mágico __toString devuelve un mensaje detallado

public static **__set_state** (*array* $message)

Método mágico __set_state ayuda a recuperar los mensajes desde la serialización