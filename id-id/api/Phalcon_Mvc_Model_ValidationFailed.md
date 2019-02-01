---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\ValidationFailed'
---
# Class **Phalcon\Mvc\Model\ValidationFailed**

*extends* class [Phalcon\Mvc\Model\Exception](Phalcon_Mvc_Model_Exception)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/validationfailed.zep)

This exception is generated when a model fails to save a record Phalcon\Mvc\Model must be set up to have this behavior

## Metode

public **__construct** (*Model* $model, *Message*\ [] $validationMessages)

Phalcon\Mvc\Model\ValidationFailed constructor

publik **mendapatkan Model** ()

Mengembalikan model yang menghasilkan pesan

public **getMessages** ()

Mengembalikan kelompok pesan lengkap yang dihasilkan dalam validasi

final private [Exception](https://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Kloning pengecualian

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