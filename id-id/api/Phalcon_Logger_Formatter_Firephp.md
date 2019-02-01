---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Logger\Formatter\Firephp'
---
# Class **Phalcon\Logger\Formatter\Firephp**

*extends* abstract class [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter/firephp.zep)

Format pesan sehingga bisa dikirim ke FirePHP

## Metode

publik **getTypeString** (*campuran* $type)

Mengembalikan arti string dari konstanta logger

public **setShowBacktrace** ([*mixed* $isShow])

Mengembalikan arti string dari konstanta logger

public **getShowBacktrace** ()

Mengembalikan arti string dari konstanta logger

public **enableLabels** ([*mixed* $isEnable])

Mengembalikan arti string dari konstanta logger

public **labelsEnabled** ()

Mengembalikan label yang diaktifkan

public *string* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Menerapkan format ke sebuah pesan sebelum mengirimnya ke log

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Interpolasi nilai konteks ke dalam placeholder pesan