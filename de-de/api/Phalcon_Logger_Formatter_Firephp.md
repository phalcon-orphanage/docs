---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Logger\Formatter\Firephp'
---
# Class **Phalcon\Logger\Formatter\Firephp**

*extends* abstract class [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter/firephp.zep)

Formats messages so that they can be sent to FirePHP

## Methoden

public **getTypeString** (*mixed* $type)

Gibt die Zeichenfolge Bedeutung einer Protokollierungs-Konstanten zurück

public **setShowBacktrace** ([*mixed* $isShow])

Gibt die Zeichenfolge Bedeutung einer Protokollierungs-Konstanten zurück

public **getShowBacktrace** ()

Gibt die Zeichenfolge Bedeutung einer Protokollierungs-Konstanten zurück

public **enableLabels** ([*mixed* $isEnable])

Gibt die Zeichenfolge Bedeutung einer Protokollierungs-Konstanten zurück

public **labelsEnabled** ()

Returns the labels enabled

public *string* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Applies a format to a message before sending it to the log

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Interpoliert Kontext Werte in die Nachricht-Platzhalter