---
layout: article
language: 'cs-cz'
version: '4.0'
title: 'Phalcon\Logger\AdapterInterface'
---
# Interface **Phalcon\Logger\AdapterInterface**

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/adapterinterface.zep)

## Methods

abstract public **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter)

...

abstract public **getFormatter** ()

...

abstract public **setLogLevel** (*mixed* $level)

...

abstract public **getLogLevel** ()

...

abstract public **log** (*mixed* $type, [*mixed* $message], [*array* $context])

...

abstract public **begin** ()

...

abstract public **commit** ()

...

abstract public **rollback** ()

...

abstract public **close** ()

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