---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Logger\Formatter\Json'
---
# Class **Phalcon\Logger\Formatter\Json**

*extends* abstract class [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

*implements* [Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/formatter/json.zep)

Format pesan menggunakan pengkodean JSON

## Metode

public *string* **format** (*string* $message, *int* $type, *int* $timestamp, [*array* $context])

Menerapkan format ke pesan sebelum mengirimnya ke log internal

public **getTypeString** (*mixed* $type) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Mengembalikan arti string dari konstanta logger

public **interpolate** (*string* $message, [*array* $context]) inherited from [Phalcon\Logger\Formatter](Phalcon_Logger_Formatter)

Interpolasi nilai konteks ke dalam placeholder pesan