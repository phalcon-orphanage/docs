Class **Phalcon\\Logger\\Adapter\\File**
========================================

*extends* abstract class :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

*implements* :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`

Adapter to store logs in plain text files  

.. code-block:: php

    <?php

    $logger = new \Phalcon\Logger\Adapter\File("app/logs/test.log");
    $logger->log("This is a message");
    $logger->log("This is an error", \Phalcon\Logger::ERROR);
    $logger->error("This is another error");
    $logger->close();



Methods
-------

public  **__construct** (*string* $name, [*array* $options])

Phalcon\\Logger\\Adapter\\File constructor



public :doc:`Phalcon\\Logger\\Formatter\\Line <Phalcon_Logger_Formatter_Line>`  **getFormatter** ()

Returns the internal formatter



protected  **logInternal** (*string* $message, *int* $type, *int* $time, *array* $context)

Writes the log to the file itself



public *boolean*  **close** ()

Closes the logger



public  **getPath** ()

Returns the file path



public  **__wakeup** ()

Opens the internal file handler after unserialization



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **setLogLevel** (*int* $level) inherited from Phalcon\\Logger\\Adapter

Filters the logs sent to the handlers that are less or equal than a specific level



public *int*  **getLogLevel** () inherited from Phalcon\\Logger\\Adapter

Returns the current log level



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **setFormatter** (:doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>` $formatter) inherited from Phalcon\\Logger\\Adapter

Sets the message formatter



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **isTransaction** () inherited from Phalcon\\Logger\\Adapter

Returns the current transaction



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **begin** () inherited from Phalcon\\Logger\\Adapter

Starts a transaction



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **commit** () inherited from Phalcon\\Logger\\Adapter

Commits the internal transaction



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **rollback** () inherited from Phalcon\\Logger\\Adapter

Rollbacks the internal transaction



public  **emergence** (*unknown* $message, [*unknown* $context]) inherited from Phalcon\\Logger\\Adapter

...


public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **log** (*unknown* $type, *string* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Logs messages to the internal logger. Appends messages to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **debug** (*string* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a debug message to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **info** (*string* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an info message to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **notice** (*string* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a notice message to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **warning** (*string* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a warning message to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **error** (*string* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an error message to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **critical** (*string* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a critical message to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **alert** (*string* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an alert message to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **emergency** (*string* $message, [*array* $context]) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an emergency message to the log



