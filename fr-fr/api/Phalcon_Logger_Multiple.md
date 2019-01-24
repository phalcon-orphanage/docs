---
layout: article
language: 'fr-fr'
version: '4.0'
title: 'Phalcon\Logger\Multiple'
---
# Class **Phalcon\Logger\Multiple**

[Source sur GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/multiple.zep)

Poignées de multiples enregistreur de gestionnaires

## Méthodes

public **getLoggers** ()

...

public **getFormatter** ()

...

public **getLogLevel** ()

...

public **push** ([Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface) $logger)

Pousse un enregistreur à l'enregistreur de queue

public **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter)

Définit un mondial formateur

public **setLogLevel** (*mixed* $level)

Sets a global level

public **log** (*mixed* $type, [*mixed* $message], [*array* $context])

Envoie un message à tous les inscrits de l'enregistreur de

public **critical** (*mixed* $message, [*array* $context])

Envoie/Écrit une critique de message dans le journal

public **emergency** (*mixed* $message, [*array* $context])

Sends/Writes an emergency message to the log

public **debug** (*mixed* $message, [*array* $context])

Sends/Writes a debug message to the log

public **error** (*mixed* $message, [*array* $context])

Sends/Writes an error message to the log

public **info** (*mixed* $message, [*array* $context])

Sends/Writes an info message to the log

public **notice** (*mixed* $message, [*array* $context])

Sends/Writes a notice message to the log

public **warning** (*mixed* $message, [*array* $context])

Sends/Writes a warning message to the log

public **alert** (*mixed* $message, [*array* $context])

Sends/Writes an alert message to the log