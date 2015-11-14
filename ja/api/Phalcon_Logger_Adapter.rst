Abstract class **Phalcon\\Logger\\Adapter**
===========================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/logger/adapter.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Base class for Phalcon\\Logger adapters


Methods
-------

public  **setLogLevel** (*unknown* $level)

Filters the logs sent to the handlers that are less or equal than a specific level



public  **getLogLevel** ()

Returns the current log level



public  **setFormatter** (:doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>` $formatter)

Sets the message formatter



public  **begin** ()

Starts a transaction



public  **commit** ()

Commits the internal transaction



public  **rollback** ()

Rollbacks the internal transaction



public  **isTransaction** ()

Returns the whether the logger is currently in an active transaction or not



public  **critical** (*unknown* $message, [*array* $context])

Sends/Writes a critical message to the log



public  **emergency** (*unknown* $message, [*array* $context])

Sends/Writes an emergency message to the log



public  **debug** (*unknown* $message, [*array* $context])

Sends/Writes a debug message to the log



public  **error** (*unknown* $message, [*array* $context])

Sends/Writes an error message to the log



public  **info** (*unknown* $message, [*array* $context])

Sends/Writes an info message to the log



public  **notice** (*unknown* $message, [*array* $context])

Sends/Writes a notice message to the log



public  **warning** (*unknown* $message, [*array* $context])

Sends/Writes a warning message to the log



public  **alert** (*unknown* $message, [*array* $context])

Sends/Writes an alert message to the log



public  **log** (*unknown* $type, [*unknown* $message], [*array* $context])

Logs messages to the internal logger. Appends logs to the logger



