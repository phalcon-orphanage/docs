---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Logger\Formatter\Line'
---
# Class **Phalcon\Logger\Formatter\Line**

*extends* abstract class [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter/line.zep)

Formats messages using an one-line string

## Methoden

public **getDateFormat** ()

Default date format

public **setDateFormat** (*mixed* $dateFormat)

Default date format

public **getFormat** ()

Format applied to each message

public **setFormat** (*mixed* $format)

Format applied to each message

public **__construct** ([*string* $format], [*string* $dateFormat])

Phalcon\Logger\Formatter\Line construct

public *string* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Wendet ein Format an einer Nachricht an, bevor es zum internen Protokoll weitergeleitet wird

public **getTypeString** (*mixed* $type) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Gibt die Zeichenfolge Bedeutung einer Protokollierungs-Konstanten zurück

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Interpoliert Kontext Werte in die Nachricht-Platzhalter