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



public  **setFormatter** (*unknown* $formatter)

Sets the message formatter



public  **begin** ()

Starts a transaction



public  **commit** ()

Commits the internal transaction



public  **rollback** ()

Rollbacks the internal transaction



public  **critical** (*unknown* $message, [*unknown* $context])

Sends/Writes a critical message to the log



public  **emergency** (*unknown* $message, [*unknown* $context])

Sends/Writes an emergency message to the log



public  **debug** (*unknown* $message, [*unknown* $context])

Sends/Writes a debug message to the log



public  **error** (*unknown* $message, [*unknown* $context])

Sends/Writes an error message to the log



public  **info** (*unknown* $message, [*unknown* $context])

Sends/Writes an info message to the log



public  **notice** (*unknown* $message, [*unknown* $context])

Sends/Writes a notice message to the log



public  **warning** (*unknown* $message, [*unknown* $context])

Sends/Writes a warning message to the log



public  **alert** (*unknown* $message, [*unknown* $context])

Sends/Writes an alert message to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **log** (*mixed* $type, [*mixed* $message], [*mixed* $context])

Logs messages to the internal logger. Appends logs to the logger



