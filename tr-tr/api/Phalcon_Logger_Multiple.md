---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Logger\Multiple'
---
# Class **Phalcon\Logger\Multiple**

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/multiple.zep)

Handles multiples logger handlers

## Metodlar

public **getLoggers** ()

...

public **getFormatter** ()

...

public **getLogLevel** ()

...

public **push** ([Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface) $logger)

Pushes a logger to the logger tail

public **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter)

Sets a global formatter

public **setLogLevel** (*mixed* $level)

Sets a global level

public **log** (*mixed* $type, [*mixed* $message], [*array* $context])

Sends a message to each registered logger

public **critical** (*mixed* $message, [*array* $context])

Sends/Writes an critical message to the log

public **emergency** (*mixed* $message, [*array* $context])

Sistem günlüğüne acil durum mesajı Gönderir / Yazar

public **debug** (*mixed* $message, [*array* $context])

Sistem günlüğüne hata giderme mesajı Gönderir / Yazar

public **error** (*mixed* $message, [*array* $context])

Sistem günlüğüne hata mesajı Gönderir / Yazar

public **info** (*mixed* $message, [*array* $context])

Sistem günlüğüne bilgi mesajı Gönderir / Yazar

public **notice** (*mixed* $message, [*array* $context])

Sistem günlüğüne bildirim mesajı Gönderir / Yazar

public **warning** (*mixed* $message, [*array* $context])

Sistem günlüğüne ikaz mesajı Gönderir / Yazar

public **alert** (*mixed* $message, [*array* $context])

Sistem günlüğüne uyarı mesajı Gönderir / Yazar