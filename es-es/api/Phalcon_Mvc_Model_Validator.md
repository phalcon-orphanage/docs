---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Mvc\Model\Validator'
---
# Abstract class **Phalcon\Mvc\Model\Validator**

*implements* [Phalcon\Mvc\Model\ValidatorInterface](Phalcon_Mvc_Model_ValidatorInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/validator.zep)

This is a base class for Phalcon\Mvc\Model validators

This class is only for backward compatibility reasons to use with Phalcon\Mvc\Collection. Otherwise please use the validators provided by Phalcon\Validation.

## Métodos

public **__construct** (*array* $options)

Phalcon\Mvc\Model\Validator constructor

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

abstract public **validate** ([Phalcon\Mvc\EntityInterface](Phalcon_Mvc_EntityInterface) $record) inherited from [Phalcon\Mvc\Model\ValidatorInterface](Phalcon_Mvc_Model_ValidatorInterface)

...