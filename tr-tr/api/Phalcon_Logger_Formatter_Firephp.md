---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Logger\Formatter\Firephp'
---
# Class **Phalcon\Logger\Formatter\Firephp**

*extends* abstract class [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter/firephp.zep)

Formats messages so that they can be sent to FirePHP

## Metodlar

public **getTypeString** (*mixed* $type)

Günlükçü sabitinin dize anlamını döndürür

public **setShowBacktrace** ([*mixed* $isShow])

Günlükçü sabitinin dize anlamını döndürür

public **getShowBacktrace** ()

Günlükçü sabitinin dize anlamını döndürür

public **enableLabels** ([*mixed* $isEnable])

Günlükçü sabitinin dize anlamını döndürür

public **labelsEnabled** ()

Returns the labels enabled

public *string* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Bir mesajı günlüğüne göndermeden önce bir format uygular

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Interpolates context values into the message placeholders