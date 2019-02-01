---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Mvc\Micro\Exception'
---
# Class **Phalcon\Mvc\Micro\Exception**

*extends* class [Phalcon\Exception](Phalcon_Exception)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/micro/exception.zep)

## Methoden

final private [Exception](https://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Ausnahme klonen

public **__construct** ([*mixed* $message], [*mixed* $code], [*mixed* $previous]) inherited from [Exception](https://php.net/manual/en/class.exception.php)

Ausnahme-Konstruktor

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