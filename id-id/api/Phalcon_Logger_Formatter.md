---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Logger\Formatter'
---
# Abstract class **Phalcon\Logger\Formatter**

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter.zep)

Ini adalah kelas dasar untuk formaldger logger

## Metode

publik **getTypeString** (*campuran* $type)

Mengembalikan arti string dari konstanta logger

publik **menambah** (*tali* $message, [*array* $context])

Interpolasi nilai konteks ke dalam placeholder pesan

abstract public **format** (*mixed* $message, *mixed* $type, *mixed* $timestamp, [*mixed* $context]) inherited from [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

...