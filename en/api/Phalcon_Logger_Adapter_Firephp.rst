Class **Phalcon\\Logger\\Adapter\\Firephp**
===========================================

*extends* :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

*implements* :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`

Sends logs to FirePHP  

.. code-block:: php

    <?php

    $logger = new \Phalcon\Logger\Adapter\Firephp("");
    $logger->log("This is a message");
    $logger->log("This is an error", \Phalcon\Logger::ERROR);
    $logger->error("This is another error");



Methods
---------

public :doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>`  **getFormatter** ()

Returns the internal formatter



public  **logInternal** (*string* $message, *int* $type, *int* $time)

Writes the log to the stream itself



public *boolean*  **close** ()

Closes the logger



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **setLogLevel** (*int* $level) inherited from Phalcon\\Logger\\Adapter

Filters the logs sent to the handlers that are less or equal than a specific level



public *int*  **getLogLevel** () inherited from Phalcon\\Logger\\Adapter

Returns the current log level



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **setFormatter** (:doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>` $formatter) inherited from Phalcon\\Logger\\Adapter

Sets the message formatter



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **begin** () inherited from Phalcon\\Logger\\Adapter

Starts a transaction



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **commit** () inherited from Phalcon\\Logger\\Adapter

Commits the internal transaction



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **rollback** () inherited from Phalcon\\Logger\\Adapter

Rollbacks the internal transaction



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **emergence** (*string* $message) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an emergence message to the log



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **debug** (*string* $message) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a debug message to the log



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **error** (*string* $message) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an error message to the log



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **info** (*string* $message) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an info message to the log



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **notice** (*string* $message) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a notice message to the log



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **warning** (*string* $message) inherited from Phalcon\\Logger\\Adapter

Sends/Writes a warning message to the log



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **alert** (*string* $message) inherited from Phalcon\\Logger\\Adapter

Sends/Writes an alert message to the log



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **log** (*string* $message, [*int* $type]) inherited from Phalcon\\Logger\\Adapter

Logs messages to the internal loggger. Appends logs to the



