---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Logger\Formatter\Line'
---
# Class **Phalcon\Logger\Formatter\Line**

*extends* abstract class [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter/line.zep)

Format pesan menggunakan string satu baris

## Metode

public **getDateFormat** ()

Format tanggal default

public **setDateFormat** (*mixed* $dateFormat)

Format tanggal default

public **getFormat** ()

Format diterapkan pada setiap pesan

public **setFormat** (*mixed* $format)

Format diterapkan pada setiap pesan

public **__construct** ([*string* $format], [*string* $dateFormat])

Phalcon\Logger\Formatter\Line construct

public *string* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Menerapkan format ke pesan sebelum mengirimnya ke log internal

public **getTypeString** (*mixed* $type) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Mengembalikan arti string dari konstanta logger

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Interpolasi nilai konteks ke dalam placeholder pesan