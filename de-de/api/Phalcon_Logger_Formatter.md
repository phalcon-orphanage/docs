---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Logger\Formatter'
---
# Abstract class **Phalcon\Logger\Formatter**

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter.zep)

Dies ist eine Basisklasse für Protokollierung Formatierer

## Methoden

public **getTypeString** (*mixed* $type)

Gibt die Zeichenfolge Bedeutung einer Protokollierungs-Konstanten zurück

public **interpolate** (*string* $message, [*array* $context])

Interpoliert Kontext Werte in die Nachricht-Platzhalter

abstract public **format** (*mixed* $message, *mixed* $type, *mixed* $timestamp, [*mixed* $context]) inherited from [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

...