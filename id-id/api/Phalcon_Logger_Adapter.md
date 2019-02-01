---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Logger\Adapter'
---
# Abstract class **Phalcon\Logger\Adapter**

*implements* [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/adapter.zep)

Base class for Phalcon\Logger adapters

## Metode

publik **menetapkan tahap catatan** (*campur* $level)

Menyaring log yang dikirim ke penangan yang kurang atau sama dari pada tingkat tertentu

publik **mendapatkan tahapan catatan** ()

Mengembalikan tingkat log saat ini

public **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter)

Mengatur formatter pesan

publik **mulai** ()

Mulai transaksi

publik **komit** ()

Melakukan transaksi internal

publik **putar kembali** ()

Rollbacks transaksi internal

publik **kepada Transaksi** ()

Mengembalikan apakah logger saat ini dalam transaksi aktif atau tidak

publik **kritis** (*campur* $message, [*susun* $context])

Mengirim / Menulis pesan penting ke log

publick **darurat** (*campur* $message, [*susunan* $context])

Mengirim / Menulis pesan penting ke log

publik **debug** (*dicampur* $message, [*susuan* $context])

Mengirim / Menulis pesan debug ke log

publik **kesalahan** (*dicampur* $message, [*susunan* $context])

Mengirim / Menulis pesan kesalahan ke log

publik **info** (*dicampur* $message, [*susunan* $context])

Mengirim / Menulis pesan info ke log

publik **melihat** (*dicampur* $message, [*susunan* $context])

Mengirim / Menulis pesan pemberitahuan ke log

publik **peringatan** (*dicampur* $message, [*susunan* $context])

Mengirim / Menulis pesan peringatan ke log

publik **waspada** (*dicampur* $message, [*susunan* $context])

Mengirim / Menulis pesan peringatan ke log

publik **log** (*campur* $type, [*campur* $message], [*susunan* $context])

Logs messages to the internal logger. Appends logs to the logger

abstract public **getFormatter** () inherited from [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

...

abstract public **close** () inherited from [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

...