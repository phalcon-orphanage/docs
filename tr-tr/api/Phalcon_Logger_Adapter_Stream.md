---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Logger\Adapter\Stream'
---
# Class **Phalcon\Logger\Adapter\Stream**

*extends* abstract class [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

*implements* [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/adapter/stream.zep)

Sends logs to a valid PHP stream

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$logger = new Stream("php://stderr");

$logger->log("This is a message");
$logger->log(Logger::ERROR, "This is an error");
$logger->error("This is another error");

```

## Metodlar

public **__construct** (*string* $name, [*array* $options])

Phalcon\Logger\Adapter\Stream constructor

public **getFormatter** ()

Dahili formatlayıcıyı döndürür

public **logInternal** (*mixed* $message, *mixed* $type, *mixed* $time, *array* $context)

Günlüğü dosyanın kendisine yazar

public **close** ()

Günlüğü kapatır

public **setLogLevel** (*mixed* $level) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Belirli bir seviyeden daha az ya da belirli bir seviyeye eşit olan işleyicilere gönderilen günlükleri filtreler

public **getLogLevel** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Geçerli günlük düzeyini döndürür

public **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Mesaj biçimlendiricisini ayarlar

public **begin** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Bir işlem başlatır

public **commit** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Dahili işlemi tamamlar

public **rollback** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Dahili işlemi geri döndürür

public **isTransaction** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Günlüğün halen aktif bir işlemde olup olmadığını döndürür

public **critical** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sistem günlüğüne kritik bir mesaj Gönderir / Yazar

public **emergency** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sistem günlüğüne acil durum mesajı Gönderir / Yazar

public **debug** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sistem günlüğüne hata giderme mesajı Gönderir / Yazar

public **error** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sistem günlüğüne hata mesajı Gönderir / Yazar

public **info** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sistem günlüğüne bilgi mesajı Gönderir / Yazar

public **notice** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sistem günlüğüne bildirim mesajı Gönderir / Yazar

public **warning** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sistem günlüğüne ikaz mesajı Gönderir / Yazar

public **alert** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sistem günlüğüne uyarı mesajı Gönderir / Yazar

public **log** (*mixed* $type, [*mixed* $message], [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Logs messages to the internal logger. Appends logs to the logger