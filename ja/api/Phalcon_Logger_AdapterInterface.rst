Interface **Phalcon\\Logger\\AdapterInterface**
===============================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/logger/adapterinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **setFormatter** (:doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>` $formatter)

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


