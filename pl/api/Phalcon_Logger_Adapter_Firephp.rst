Class **Phalcon\\Logger\\Adapter\\Firephp**
===========================================

*extends* abstract class :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

*implements* :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`

Sends logs to FirePHP  

.. code-block:: php

    <?php

     $logger = new \Phalcon\Logger\Adapter\Firephp("");
     $logger->log(\Phalcon\Logger::ERROR, "This is an error");
     $logger->error("This is another error");



Methods
-------

public *\Phalcon\Logger\FormatterInterface*  **getFormatter** ()

Returns the internal formatter



public  **logInternal** (*string* $message, *int* $type, *int* $time, *array* $context)

Writes the log to the stream itself



public *boolean*  **close** ()

Closes the logger



public  **setLogLevel** (*unknown* $level) inherited from Phalcon\\Logger\\Adapter

Filters the logs sent to the handlers that are less or equal than a specific level



public  **getLogLevel** () inherited from Phalcon\\Logger\\Adapter

Returns the current log level



public  **setFormatter** (*unknown* $formatter) inherited from Phalcon\\Logger\\Adapter

Sets the message formatter



public  **begin** () inherited from Phalcon\\Logger\\Adapter

Starts a transaction



public  **commit** () inherited from Phalcon\\Logger\\Adapter

Commits the internal transaction



public  **rollback** () inherited from Phalcon\\Logger\\Adapter

Rollbacks the internal transaction



public  **critical** (*unknown* $message, [*unknown* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a critical message to the log



public  **emergency** (*unknown* $message, [*unknown* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an emergency message to the log



public  **debug** (*unknown* $message, [*unknown* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a debug message to the log



public  **error** (*unknown* $message, [*unknown* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an error message to the log



public  **info** (*unknown* $message, [*unknown* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an info message to the log



public  **notice** (*unknown* $message, [*unknown* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a notice message to the log



public  **warning** (*unknown* $message, [*unknown* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a warning message to the log



public  **alert** (*unknown* $message, [*unknown* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an alert message to the log



public  **log** (*unknown* $type, [*unknown* $message], [*unknown* $context]) inherited from Phalcon\\Logger\\Adapter

Logs messages to the internal logger. Appends logs to the logger



