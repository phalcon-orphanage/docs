Class **Phalcon\\Logger\\Adapter\\Stream**
==========================================

*extends* :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

*implements* :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`

Sends logs to a valid PHP stream  

.. code-block:: php

    <?php

    $logger = new \Phalcon\Logger\Adapter\Stream("php://stderr");
    $logger->log("This is a message");
    $logger->log("This is an error", \Phalcon\Logger::ERROR);
    $logger->error("This is another error");



Methods
---------

public  **__construct** (*string* $name, [*array* $options])

Phalcon\\Logger\\Adapter\\Stream constructor



public :doc:`Phalcon\\Logger\\Formatter\\Line <Phalcon_Logger_Formatter_Line>`  **getFormatter** ()

Returns the internal formatter



public  **logInternal** (*string* $message, *int* $type, *int* $time)

Writes the log to the stream itself



public *boolean*  **close** ()

Closes the logger



public  **setFormatter** (:doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>` $formatter) inherited from Phalcon\\Logger\\Adapter

Sets the message formatter



public  **begin** () inherited from Phalcon\\Logger\\Adapter

Starts a transaction



public  **commit** () inherited from Phalcon\\Logger\\Adapter

Commits the internal transaction



public  **rollback** () inherited from Phalcon\\Logger\\Adapter

Rollbacks the internal transaction



public  **emergence** (*string* $message) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an emergence message to the log



public  **debug** (*string* $message) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a debug message to the log



public  **error** (*string* $message) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an error message to the log



public  **info** (*string* $message) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an info message to the log



public  **notice** (*string* $message) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a notice message to the log



public  **warning** (*string* $message) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a warning message to the log



public  **alert** (*string* $message) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an alert message to the log



public  **log** (*string* $message, [*int* $type]) inherited from Phalcon\\Logger\\Adapter

Logs messages to the internal loggger. Appends logs to the



