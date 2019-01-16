---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Logger\AdapterInterface'
---
# Interface **Phalcon\Logger\AdapterInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/logger/adapterinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods
abstract public  **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter)

...


abstract public  **getFormatter** ()

...


abstract public  **setLogLevel** (*mixed* $level)

...


abstract public  **getLogLevel** ()

...


abstract public  **log** (*mixed* $type, [*mixed* $message], [*array* $context])

...


abstract public  **begin** ()

...


abstract public  **commit** ()

...


abstract public  **rollback** ()

...


abstract public  **close** ()

...


abstract public  **debug** (*mixed* $message, [*array* $context])

...


abstract public  **error** (*mixed* $message, [*array* $context])

...


abstract public  **info** (*mixed* $message, [*array* $context])

...


abstract public  **notice** (*mixed* $message, [*array* $context])

...


abstract public  **warning** (*mixed* $message, [*array* $context])

...


abstract public  **alert** (*mixed* $message, [*array* $context])

...


abstract public  **emergency** (*mixed* $message, [*array* $context])

...


