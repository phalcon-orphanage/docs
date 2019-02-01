---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Crypt\Mismatch'
---
# Class **Phalcon\Crypt\Mismatch**

*extends* class [Phalcon\Crypt\Exception](Phalcon_Crypt_Exception)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/crypt/mismatch.zep)

## Metode

final private [Exception](https://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Kloning pengecualian

public **__construct** ([*mixed* $message], [*mixed* $code], [*mixed* $previous]) inherited from [Exception](https://php.net/manual/en/class.exception.php)

Pengecualian konstruktor

public **__wakeup** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

...

final public *string* **getMessage** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Pesan pengecualian terenkripsi

final public *int* **getCode** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Pesan pengecualian terenkripsi

final public *string* **getFile** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Mendapatkan file di mana pengecualian terjadi

final public *int* **getLine** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Mendapatkan file di mana pengecualian terjadi

final public *array* **getTrace** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Mendapatkan pelacakan stack

final public [Exception](https://php.net/manual/en/class.exception.php) **getPrevious** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Kembali pengecualian sebelumnya

final public [Exception](https://php.net/manual/en/class.exception.php) **getTraceAsString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Mendapatkan jejak stack sebagai string

public *string* **__toString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

String representasi dari pengecualian