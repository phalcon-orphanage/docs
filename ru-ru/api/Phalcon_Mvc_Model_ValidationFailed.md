---
layout: article
language: 'ru-ru'
version: '4.0'
title: 'Phalcon\Mvc\Model\ValidationFailed'
---
# Class **Phalcon\Mvc\Model\ValidationFailed**

*extends* class [Phalcon\Mvc\Model\Exception](Phalcon_Mvc_Model_Exception)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/validationfailed.zep)

This exception is generated when a model fails to save a record Phalcon\Mvc\Model must be set up to have this behavior

## Методы

public **__construct** (*Model* $model, *Message*\ [] $validationMessages)

Phalcon\Mvc\Model\ValidationFailed constructor

public **getModel** ()

Returns the model that generated the messages

public **getMessages** ()

Returns the complete group of messages produced in the validation

final private [Exception](https://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Clone the exception

public **__wakeup** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

...

final public *string* **getMessage** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Возвращает сообщение об исключении

final public *int* **getCode** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Возвращает код исключения

final public *string* **getFile** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Возвращает файл, в котором произошло исключение

final public *int* **getLine** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Возвращает строку, в которой произошло исключение

final public *array* **getTrace** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Возвращает трассировку стека

final public [Exception](https://php.net/manual/en/class.exception.php) **getPrevious** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Возвращает Предыдущее исключение

final public [Exception](https://php.net/manual/en/class.exception.php) **getTraceAsString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Возвращает трассировку стека в виде строки

public *string* **__toString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Строковое представление исключения