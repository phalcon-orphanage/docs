---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Logger\Formatter\Line'
---
# Class **Phalcon\Logger\Formatter\Line**

*extends* abstract class [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter/line.zep)

Formatea mensajes utilizando una cadena de una línea

## Métodos

public **getDateFormat** ()

Formato de fecha por defecto

public **setDateFormat** (*mixed* $dateFormat)

Formato de fecha por defecto

public **getFormat** ()

Formato aplicado a cada mensaje

public **setFormat** (*mixed* $format)

Formato aplicado a cada mensaje

public **__construct** ([*string* $format], [*string* $dateFormat])

Phalcon\Logger\Formatter\Line construct

public *string* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Aplica un formato a un mensaje antes de enviarlo al registro interno

public **getTypeString** (*mixed* $type) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Returns the string meaning of a logger constant

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Interpolates context values into the message placeholders