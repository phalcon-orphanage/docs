---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Logger\Formatter\Json'
---
# Class **Phalcon\Logger\Formatter\Json**

*extends* abstract class [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter/json.zep)

Formats messages using JSON encoding

## Metodlar

public *string* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Dahili sistem günlüğüne göndermeden önce mesaja format uygular

public **getTypeString** (*mixed* $type) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Günlükçü sabitinin dize anlamını döndürür

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Interpolates context values into the message placeholders