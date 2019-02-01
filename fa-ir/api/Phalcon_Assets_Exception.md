---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Assets\Exception'
---
# Class **Phalcon\Assets\Exception**

*extends* class [Phalcon\Exception](Phalcon_Exception)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/exception.zep)

## روش ها

final private [Exception](https://php.net/manual/en/class.exception.php) **__clone** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

استثنا را کلون کنید

public **__construct** ([*mixed* $message], [*mixed* $code], [*mixed* $previous]) inherited from [Exception](https://php.net/manual/en/class.exception.php)

سازنده استثنایی

public **__wakeup** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

...

final public *string* **getMessage** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

پیام اعتراض را دریافت می کند

final public *int* **getCode** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

پیام اعتراض را دریافت می کند

final public *string* **getFile** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

می دهد فایل که در آن استثنا اتفاق افتاده است

final public *int* **getLine** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Gets the line in which the exception occurred

final public *array* **getTrace** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Gets the stack trace

final public [Exception](https://php.net/manual/en/class.exception.php) **getPrevious** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Returns previous Exception

final public [Exception](https://php.net/manual/en/class.exception.php) **getTraceAsString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

Gets the stack trace as a string

public *string* **__toString** () inherited from [Exception](https://php.net/manual/en/class.exception.php)

String representation of the exception