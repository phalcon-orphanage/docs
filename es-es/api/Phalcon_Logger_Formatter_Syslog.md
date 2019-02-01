---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Logger\Formatter\Syslog'
---
# Class **Phalcon\Logger\Formatter\Syslog**

*extends* abstract class [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter/syslog.zep)

Prepara un mensaje para ser utilizado en un backend Syslog

## Métodos

public *array* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Aplica un formato a un mensaje antes de enviarlo al registro interno

public **getTypeString** (*mixed* $type) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Returns the string meaning of a logger constant

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Interpolates context values into the message placeholders