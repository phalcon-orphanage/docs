---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Logger\Formatter\Line'
---
# Class **Phalcon\Logger\Formatter\Line**

*extends* abstract class [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter/line.zep)

Mesajları bir satırlık dize kullanarak şekillendirir

## Metodlar

public **getDateFormat** ()

Varsayılan tarih şekli

public **setDateFormat** (*mixed* $dateFormat)

Varsayılan tarih şekli

public **getFormat** ()

Bütün mesajlara uygulanan biçim

public **setFormat** (*mixed* $format)

Bütün mesajlara uygulanan biçim

public **__construct** ([*string* $format], [*string* $dateFormat])

Phalcon\Logger\Formatter\Line construct

public *string* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Dahili sistem günlüğüne göndermeden önce mesaja format uygular

public **getTypeString** (*mixed* $type) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Günlükçü sabitinin dize anlamını döndürür

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Interpolates context values into the message placeholders