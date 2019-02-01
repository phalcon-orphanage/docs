---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Logger\Multiple'
---
# Class **Phalcon\Logger\Multiple**

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/multiple.zep)

Controla controladores múltiples de registrador

## Métodos

public **getLoggers** ()

...

public **getFormatter** ()

...

public **getLogLevel** ()

...

public **push** ([Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface) $logger)

Pushes a logger to the logger tail

public **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter)

Configura el formateador global

public **setLogLevel** (*mixed* $level)

Configura el nivel global

public **log** (*mixed* $type, [*mixed* $message], [*array* $context])

Envía un mensaje a cada registrador registrado

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