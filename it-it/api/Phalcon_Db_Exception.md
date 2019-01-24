---
layout: article
language: 'it-it'
version: '4.0'
title: 'Phalcon\Db\Exception'
---
# Class **Phalcon\Db\Exception**

*extends* class [Phalcon\Exception](Phalcon_Exception)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

[Sorgente su GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/exception.zep)

## Metodi

final private [Exception](https://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Clona l'eccezione

public **__construct** ([*mixed* $message], [*mixed* $code], [*mixed* $previous]) inherited from [Exception](https://php.net/manual/en/class.exception.php)

Costruttore Exception

public **__wakeup** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

...

final public *string* **getMessage** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Ottiene il messaggio dell'eccezione

final public *int* **getCode** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Ottiene il codice dell'eccezione

final public *string* **getFile** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Ottiene il file in cui si è verificata l'eccezione

final public *int* **getLine** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Ottiene la riga in cui si è verificata l'eccezione

final public *array* **getTrace** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Ottiene la traccia dello stack

final public [Exception](https://php.net/manual/en/class.exception.php) **getPrevious** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Restituisce l'eccezione precedente

final public [Exception](https://php.net/manual/en/class.exception.php) **getTraceAsString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Ottiene la traccia dello stack come stringa

public *string* **__toString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Stringa rappresentativa dell'eccezione