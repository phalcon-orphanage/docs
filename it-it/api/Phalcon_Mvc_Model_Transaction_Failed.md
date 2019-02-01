---
layout: article
language: 'it-it'
version: '4.0'
title: 'Phalcon\Mvc\Model\Transaction\Failed'
---
# Class **Phalcon\Mvc\Model\Transaction\Failed**

*extends* class [Phalcon\Mvc\Model\Transaction\Exception](Phalcon_Mvc_Model_Transaction_Exception)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

[Sorgente su GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/transaction/failed.zep)

This class will be thrown to exit a try/catch block for isolated transactions

## Metodi

public **__construct** (*mixed* $message, [[Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $record])

Phalcon\Mvc\Model\Transaction\Failed constructor

public **getRecordMessages** ()

Returns validation record messages which stop the transaction

public **getRecord** ()

Returns validation record messages which stop the transaction

final private [Exception](https://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Clona l'eccezione

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