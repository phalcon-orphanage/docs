Class **Phalcon\\Logger\\Adapter\\File**
========================================

*extends* :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

*implements* :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`

Adapter to store logs in plain text files  

.. code-block:: php

    <?php

    $logger = new Phalcon\Logger\Adapter\File("app/logs/test.log");
    $logger->log("This is a message");
    $logger->log("This is an error", Phalcon\Logger::ERROR);
    $logger->error("This is another error");
    $logger->close();



Methods
---------

public  **__construct** (*string* $name, [*array* $options])

Phalcon\\Logger\\Adapter\\File constructor



public  **log** (*string* $message, [*int* $type])

Sends/Writes messages to the file log



public  **begin** ()

Starts a transaction



public  **commit** ()

Commits the internal transaction



public  **rollback** ()

Rollbacks the internal transaction



public *boolean*  **close** ()

Closes the logger



public  **__wakeup** ()

Opens the internal file handler after unserialization



public  **setFormat** (*string* $format) inherited from Phalcon\\Logger\\Adapter

Set the log format



public *format*  **getFormat** () inherited from Phalcon\\Logger\\Adapter

Returns the log format



protected *string*  **_applyFormat** () inherited from Phalcon\\Logger\\Adapter

Applies the internal format to the message



public  **setDateFormat** (*string* $date) inherited from Phalcon\\Logger\\Adapter

Sets the internal date format



public *string*  **getDateFormat** () inherited from Phalcon\\Logger\\Adapter

Returns the internal date format



public *string*  **getTypeString** (*integer* $type) inherited from Phalcon\\Logger\\Adapter

Returns the string meaning of a logger constant



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



