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


abstract public  **setLogLevel** (*unknown* $level)

...


abstract public  **getLogLevel** ()

...


abstract public  **log** (*unknown* $type, [*unknown* $message], [*array* $context])

...


abstract public  **begin** ()

...


abstract public  **commit** ()

...


abstract public  **rollback** ()

...


abstract public  **close** ()

...


abstract public  **debug** (*unknown* $message, [*array* $context])

...


abstract public  **error** (*unknown* $message, [*array* $context])

...


abstract public  **info** (*unknown* $message, [*array* $context])

...


abstract public  **notice** (*unknown* $message, [*array* $context])

...


abstract public  **warning** (*unknown* $message, [*array* $context])

...


abstract public  **alert** (*unknown* $message, [*array* $context])

...


abstract public  **emergency** (*unknown* $message, [*array* $context])

...


