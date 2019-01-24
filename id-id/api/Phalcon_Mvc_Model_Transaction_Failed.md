---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Transaction\Failed'
---
# Class **Phalcon\Mvc\Model\Transaction\Failed**

*extends* class [Phalcon\Mvc\Model\Transaction\Exception](Phalcon_Mvc_Model_Transaction_Exception)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/transaction/failed.zep)

Kelas ini akan dilempar untuk keluar dari blok try/catch untuk transaksi yang terisolasi

## Metode

public **__construct** (*mixed* $message, [[Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $record])

Phalcon\Mvc\Model\Transaction\Failed constructor

public **getRecordMessages** ()

Mengembalikan pesan catatan validasi yang menghentikan transaksi

public **getRecord** ()

Mengembalikan pesan catatan validasi yang menghentikan transaksi

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