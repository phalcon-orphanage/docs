---
layout: article
language: 'pl-pl'
version: '4.0'
title: 'Phalcon\Logger\Formatter\Syslog'
---
# Class **Phalcon\Logger\Formatter\Syslog**

*extends* abstract class [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter/syslog.zep)

Prepares a message to be used in a Syslog backend

## Metody

public *array* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Applies a format to a message before sent it to the internal log

public **getTypeString** (*mixed* $type) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Returns the string meaning of a logger constant

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Interpolates context values into the message placeholders