---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Logger\AdapterInterface'
---
# Interface **Phalcon\Logger\AdapterInterface**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/adapterinterface.zep)

## Metode

abstract public **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter)

...

publik abstrak **getFormatter** ()

...

abstrak publik **setLogLevel** (*mixed* $level)

...

abstrak publik **getLogLeve** ()

...

abstract public **log** (*mixed* $type, [*mixed* $message], [*array* $context])

...

abstract public **begin** ()

...

abstract public **commit** ()

...

abstract public **rollback** ()

...

abstrak umum **dekat** ()

...

abstract public **debug** (*mixed* $message, [*array* $context])

...

abstract public **error** (*mixed* $message, [*array* $context])

...

abstract public **info** (*mixed* $message, [*array* $context])

...

abstract public **notice** (*mixed* $message, [*array* $context])

...

abstract public **warning** (*mixed* $message, [*array* $context])

...

abstract public **alert** (*mixed* $message, [*array* $context])

...

abstract public **emergency** (*mixed* $message, [*array* $context])

...