# Clase Abstracta **Phalcon\\Mvc\\Model\\Validator**

*implements* [Phalcon\Mvc\Model\ValidatorInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_Model_ValidatorInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/validator.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Se trata de una clase base para validadores de Phalcon\\Mvc\\Model

Esta clase es sólo por razones de compatibilidad con versiones anteriores para usar con Phalcon\\Mvc\\Collection. De lo contrario utiliza los validadores proporcionados por Phalcon\\Validation.

## Métodos

public **__construct** (*array* $options)

Constructor de Phalcon\\Mvc\\Model\\Validator

protected **appendMessage** (*string* $message, [*string* | *array* $field], [*string* $type])

Añade un mensaje para el validador

public **getMessages** ()

Devuelve mensajes generados por el validador

public *array* **getOptions** ()

Devuelve todas las opciones dela validador

public **getOption** (*mixed* $option, [*mixed* $defaultValue])

Devuelve una opción

public **isSetOption** (*mixed* $option)

Comprobar si una opción se ha definido en las opciones de validación

abstract public **validate** ([Phalcon\Mvc\EntityInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_EntityInterface) $record) inherited from [Phalcon\Mvc\Model\ValidatorInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_Model_ValidatorInterface)

...