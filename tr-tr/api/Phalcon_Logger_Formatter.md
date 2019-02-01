---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Logger\Formatter'
---
# Abstract class **Phalcon\Logger\Formatter**

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter.zep)

Bu günlükçü formatlayıcılar için ana sınıftır

## Metodlar

public **getTypeString** (*mixed* $type)

Günlükçü sabitinin dize anlamını döndürür

public **interpolate** (*string* $message, [*array* $context])

Interpolates context values into the message placeholders

abstract public **format** (*mixed* $message, *mixed* $type, *mixed* $timestamp, [*mixed* $context]) inherited from [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

...