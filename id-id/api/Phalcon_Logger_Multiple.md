---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Logger\Multiple'
---
# Class **Phalcon\Logger\Multiple**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/multiple.zep)

Menangani kelipatan penangan logger

## Metode

public **getLoggers** ()

...

public **getFormatter** ()

...

publik **mendapatkan tahapan catatan** ()

...

public **push** ([Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface) $logger)

Mendorong logger ke ekor logger

public **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter)

Mendorong logger ke ekor logger

publik **menetapkan tahap catatan** (*campur* $level)

Menetapkan tingkat global

publik **log** (*campur* $type, [*campur* $message], [*susunan* $context])

Mengirim pesan ke setiap logger terdaftar

publik **kritis** (*campur* $message, [*susun* $context])

Mengirim/Menulis pesan penting ke log

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