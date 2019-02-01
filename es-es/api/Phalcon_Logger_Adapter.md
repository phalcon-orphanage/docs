---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Logger\Adapter'
---
# Abstract class **Phalcon\Logger\Adapter**

*implements* [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/adapter.zep)

Base class for Phalcon\Logger adapters

## Métodos

public **setLogLevel** (*mixed* $level)

Filtra los registros enviados a los controladores que son menos o igual a un nivel específico

public **getLogLevel** ()

Devuelve el nivel de registro actual

public **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter)

Configura el formateador del mensaje

public **begin** ()

Inicia una transacción

public **commit** ()

Finaliza la transacción interna

public **rollback** ()

Revierte la transacción interna

public **isTransaction** ()

Devuelve si el registrador está actualmente en una transacción activa o no

public **critical** (*mixed* $message, [*array* $context])

Envía o escribe un mensaje crítico al registro

public **emergency** (*mixed* $message, [*array* $context])

Envía o escribe un mensaje de emergencia al registro

public **debug** (*mixed* $message, [*array* $context])

Envía o escribe un mensaje de depuración al registro

public **error** (*mixed* $message, [*array* $context])

Envía o escribe un mensaje de error al registro

public **info** (*mixed* $message, [*array* $context])

Envía o escribe un mensaje de información al registro

public **notice** (*mixed* $message, [*array* $context])

Envía o escribe un mensaje de notificación al registro

public **warning** (*mixed* $message, [*array* $context])

Envía o escribe un mensaje de advertencia al registro

public **alert** (*mixed* $message, [*array* $context])

Envía o escribe un mensaje de alerta al registro

public **log** (*mixed* $type, [*mixed* $message], [*array* $context])

Logs messages to the internal logger. Appends logs to the logger

abstract public **getFormatter** () inherited from [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

...

abstract public **close** () inherited from [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

...