---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Logger\Adapter\File'
---
# Class **Phalcon\Logger\Adapter\File**

*extends* abstract class [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

*implements* [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/adapter/file.zep)

Adaptor untuk menyimpan log dalam file teks biasa

```php
<?php

$logger = new \Phalcon\Logger\Adapter\File("app/logs/test.log");

$logger->log("This is a message");
$logger->log(\Phalcon\Logger::ERROR, "This is an error");
$logger->error("This is another error");

$logger->close();

```

## Metode

public **getPath** ()

Jalur File

public **__construct** (*string* $name, [*array* $options])

Phalcon\Logger\Adapter\File constructor

public **getFormatter** ()

Mengembalikan formatter internal

public **logInternal** (*mixed* $message, *mixed* $type, *mixed* $time, *array* $context)

Menulis log ke file itu sendiri

publik **tutup** ()

Menutup logger

public **__wakeup** ()

Membuka handler file internal setelah unserialization

public **setLogLevel** (*mixed* $level) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Menyaring log yang dikirim ke penangan yang kurang atau sama dari pada tingkat tertentu

public **getLogLevel** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Mengembalikan tingkat log saat ini

public **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Mengatur formatter pesan

public **begin** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Mulai transaksi

public **commit** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Melakukan transaksi internal

public **rollback** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Rollbacks transaksi internal

public **isTransaction** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Mengembalikan apakah logger saat ini dalam transaksi aktif atau tidak

public **critical** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Mengirim / Menulis pesan penting ke log

public **emergency** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Mengirim / Menulis pesan penting ke log

public **debug** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Mengirim / Menulis pesan debug ke log

public **error** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Mengirim / Menulis pesan kesalahan ke log

public **info** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Mengirim / Menulis pesan info ke log

public **notice** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Mengirim / Menulis pesan pemberitahuan ke log

public **warning** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Mengirim / Menulis pesan peringatan ke log

public **alert** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Mengirim / Menulis pesan peringatan ke log

public **log** (*mixed* $type, [*mixed* $message], [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Logs messages to the internal logger. Appends logs to the logger