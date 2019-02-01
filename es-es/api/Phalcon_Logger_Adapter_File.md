---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Logger\Adapter\File'
---
# Class **Phalcon\Logger\Adapter\File**

*extends* abstract class [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

*implements* [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/adapter/file.zep)

Adaptador para almacenar registros en archivos de texto simple

```php
<?php

$logger = new \Phalcon\Logger\Adapter\File("app/logs/test.log");

$logger->log("This is a message");
$logger->log(\Phalcon\Logger::ERROR, "This is an error");
$logger->error("This is another error");

$logger->close();

```

## Métodos

public **getPath** ()

Ruta del archivo

public **__construct** (*string* $name, [*array* $options])

Phalcon\Logger\Adapter\File constructor

public **getFormatter** ()

Devuelve el formateador interno

public **logInternal** (*mixed* $message, *mixed* $type, *mixed* $time, *array* $context)

Escribe el registro al mismo archivo

public **close** ()

Cierra el registrador

public **__wakeup** ()

Abre el controlador de archivo interno después de revertir la serialización

public **setLogLevel** (*mixed* $level) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Filtra los registros enviados a los controladores que son menos o igual a un nivel específico

public **getLogLevel** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Devuelve el nivel de registro actual

public **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Configura el formateador del mensaje

public **begin** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Inicia una transacción

public **commit** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Finaliza la transacción interna

public **rollback** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Revierte la transacción interna

public **isTransaction** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Devuelve si el registrador está actualmente en una transacción activa o no

public **critical** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Envía o escribe un mensaje crítico al registro

public **emergency** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Envía o escribe un mensaje de emergencia al registro

public **debug** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Envía o escribe un mensaje de depuración al registro

public **error** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Envía o escribe un mensaje de error al registro

public **info** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Envía o escribe un mensaje de información al registro

public **notice** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Envía o escribe un mensaje de notificación al registro

public **warning** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Envía o escribe un mensaje de advertencia al registro

public **alert** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Envía o escribe un mensaje de alerta al registro

public **log** (*mixed* $type, [*mixed* $message], [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Logs messages to the internal logger. Appends logs to the logger