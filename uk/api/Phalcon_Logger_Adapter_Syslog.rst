Class **Phalcon\\Logger\\Adapter\\Syslog**
==========================================

*extends* abstract class :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

*implements* :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/logger/adapter/syslog.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Sends logs to the system logger  

.. code-block:: php

    <?php

    $logger = new \Phalcon\Logger\Adapter\Syslog("ident", array(
    	'option' => LOG_NDELAY,
    	'facility' => LOG_MAIL
    ));
    $logger->log("This is a message");
    $logger->log("This is an error", \Phalcon\Logger::ERROR);
    $logger->error("This is another error");



Methods
-------

public  **__construct** (*string* $name, [*array* $options])

Phalcon\\Logger\\Adapter\\Syslog constructor



public  **getFormatter** ()

Returns the internal formatter



public  **logInternal** (*string* $message, *int* $type, *int* $time, *array* $context)

Writes the log to the stream itself



public *boolean*  **close** ()

Closes the logger



public  **setLogLevel** (*unknown* $level) inherited from Phalcon\\Logger\\Adapter

Filters the logs sent to the handlers that are less or equal than a specific level



public  **getLogLevel** () inherited from Phalcon\\Logger\\Adapter

Returns the current log level



public  **setFormatter** (:doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>` $formatter) inherited from Phalcon\\Logger\\Adapter

Sets the message formatter



public  **begin** () inherited from Phalcon\\Logger\\Adapter

Starts a transaction



public  **commit** () inherited from Phalcon\\Logger\\Adapter

Commits the internal transaction



public  **rollback** () inherited from Phalcon\\Logger\\Adapter

Rollbacks the internal transaction



public  **isTransaction** () inherited from Phalcon\\Logger\\Adapter

Returns the whether the logger is currently in an active transaction or not



public  **critical** (*unknown* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a critical message to the log



public  **emergency** (*unknown* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an emergency message to the log



public  **debug** (*unknown* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a debug message to the log



public  **error** (*unknown* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an error message to the log



public  **info** (*unknown* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an info message to the log



public  **notice** (*unknown* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a notice message to the log



public  **warning** (*unknown* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a warning message to the log



public  **alert** (*unknown* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an alert message to the log



public  **log** (*unknown* $type, [*unknown* $message], [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Logs messages to the internal logger. Appends logs to the logger



