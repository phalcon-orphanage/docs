---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Image\Exception'
---
# Class **Phalcon\Image\Exception**

*extends* class [Phalcon\Exception](Phalcon_Exception)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/image/exception.zep)

## Metodlar

final private [Exception](https://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Olağandışılığı çoğalt

public **__construct** ([*mixed* $message], [*mixed* $code], [*mixed* $previous]) inherited from [Exception](https://php.net/manual/en/class.exception.php)

Olağandışılık oluşturucu

public **__wakeup** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

...

final public *string* **getMessage** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Özel durum mesajını getirir

final public *int* **getCode** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

İstisna kodunu alır

final public *string* **getFile** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

İstisnanın oluştuğu dosyayı alır

final public *int* **getLine** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

İstisnanın oluştuğu satırı alır

final public *array* **getTrace** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Yığın izni alır

final public [Exception](https://php.net/manual/en/class.exception.php) **getPrevious** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Önceki istisna döndürür

final public [Exception](https://php.net/manual/en/class.exception.php) **getTraceAsString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Bir dize olarak yığın izni alır

public *string* **__toString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

İstisnai dize gösterimi