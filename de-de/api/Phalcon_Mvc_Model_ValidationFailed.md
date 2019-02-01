---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Mvc\Model\ValidationFailed'
---
# Class **Phalcon\Mvc\Model\ValidationFailed**

*extends* class [Phalcon\Mvc\Model\Exception](Phalcon_Mvc_Model_Exception)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/validationfailed.zep)

This exception is generated when a model fails to save a record Phalcon\Mvc\Model must be set up to have this behavior

## Methoden

public **__construct** (*Model* $model, *Message*\ [] $validationMessages)

Phalcon\Mvc\Model\ValidationFailed constructor

public **getModel** ()

Returns the model that generated the messages

public **getMessages** ()

Returns the complete group of messages produced in the validation

final private [Exception](https://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Ausnahme klonen

public **__wakeup** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

...

final public *string* **getMessage** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Liefert den Ausnahme Meldung

final public *int* **getCode** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Liefert den Ausnahmecode

final public *string* **getFile** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Liefert die Datei, in der die Ausnahme aufgetreten ist

final public *int* **getLine** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Liefert die Zeile, in der die Ausnahme aufgetreten ist

final public *array* **getTrace** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Gibt den Stack-trace zurück

final public [Exception](https://php.net/manual/en/class.exception.php) **getPrevious** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Gibt die vorherige Ausnahme zurück

final public [Exception](https://php.net/manual/en/class.exception.php) **getTraceAsString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Gibt den Stack-trace als Zeichenfolge zurück

public *string* **__toString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

String-Darstellung der Ausnahme