---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Logger\Adapter'
---
# Abstract class **Phalcon\Logger\Adapter**

*implements* [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/adapter.zep)

Base class for Phalcon\Logger adapters

## Metodlar

public **setLogLevel** (*mixed* $level)

Belirli bir seviyeden daha az ya da belirli bir seviyeye eşit olan işleyicilere gönderilen günlükleri filtreler

public **getLogLevel** ()

Geçerli günlük düzeyini döndürür

public **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter)

Mesaj biçimlendiricisini ayarlar

public **begin** ()

Bir işlem başlatır

public **commit** ()

Dahili işlemi tamamlar

public **rollback** ()

Dahili işlemi geri döndürür

public **isTransaction** ()

Günlüğün halen aktif bir işlemde olup olmadığını döndürür

public **critical** (*mixed* $message, [*array* $context])

Sistem günlüğüne kritik bir mesaj Gönderir / Yazar

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

public **log** (*mixed* $type, [*mixed* $message], [*array* $context])

Logs messages to the internal logger. Appends logs to the logger

abstract public **getFormatter** () inherited from [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

...

abstract public **close** () inherited from [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

...