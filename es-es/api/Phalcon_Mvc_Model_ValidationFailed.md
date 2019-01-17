---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Mvc\Model\ValidationFailed'
---
# Class **Phalcon\Mvc\Model\ValidationFailed**

*extends* class [Phalcon\Mvc\Model\Exception](Phalcon_Mvc_Model_Exception)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/validationfailed.zep)

This exception is generated when a model fails to save a record Phalcon\Mvc\Model must be set up to have this behavior

## Métodos

public **__construct** (*Model* $model, *Message*\ [] $validationMessages)

Phalcon\Mvc\Model\ValidationFailed constructor

public **getModel** ()

Returns the model that generated the messages

public **getMessages** ()

Returns the complete group of messages produced in the validation

final private [Exception](https://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Clona la excepción

public **__wakeup** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

...

final public *string* **getMessage** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Obtiene el mensaje de excepción

final public *int* **getCode** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Obtiene el código de Exception

final public *string* **getFile** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Obtiene el archivo en el que se produjo la excepción

final public *int* **getLine** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Obtiene la línea en que se produjo la excepción

final public *array* **getTrace** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Obtiene el seguimiento de la pila

final public [Exception](https://php.net/manual/en/class.exception.php) **getPrevious** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Devuelve la excepción anterior

final public [Exception](https://php.net/manual/en/class.exception.php) **getTraceAsString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Obtiene el seguimiento de la pila como una cadena

public *string* **__toString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Representación de la excepción como una cadena