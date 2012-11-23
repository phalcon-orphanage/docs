Class **Phalcon\\Logger\\Adapter\\File**
========================================

*extends* :doc:`Phalcon\\Logger <Phalcon_Logger>`

Adapter to store logs in plain text files 

.. code-block:: php

    <?php

    $logger = new Phalcon\Logger\Adapter\File("app/logs/test.log");
    $logger->log("This is a message");
    $logger->log("This is an error", Phalcon\Logger::ERROR);
    $logger->error("This is another error");
    $logger->close();



Constants
---------

*integer* **SPECIAL**

*integer* **CUSTOM**

*integer* **DEBUG**

*integer* **INFO**

*integer* **NOTICE**

*integer* **WARNING**

*integer* **ERROR**

*integer* **ALERT**

*integer* **CRITICAL**

*integer* **EMERGENCE**

Methods
---------

public  **__construct** (*string* $name, *array* $options)

Phalcon\\Logger\\Adapter\\File constructor



public  **setFormat** (*string* $format)

Set the log format



public *format*  **getFormat** ()

Returns the log format



public *string*  **getTypeString** (*integer* $type)

Returns the string meaning of a logger constant



protected *string*  **_applyFormat** ()

Applies the internal format to the message



public  **setDateFormat** (*string* $date)

Sets the internal date format



public *string*  **getDateFormat** ()

Returns the internal date format



public  **log** (*string* $message, *int* $type)

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



public  **debug** (*string* $message) inherited from Phalcon\\Logger

Sends/Writes a debug message to the log



public  **error** (*string* $message) inherited from Phalcon\\Logger

Sends/Writes an error message to the log



public  **info** (*string* $message) inherited from Phalcon\\Logger

Sends/Writes an info message to the log



public  **notice** (*string* $message) inherited from Phalcon\\Logger

Sends/Writes a notice message to the log



public  **warning** (*string* $message) inherited from Phalcon\\Logger

Sends/Writes a warning message to the log



public  **alert** (*string* $message) inherited from Phalcon\\Logger

Sends/Writes an alert message to the log



