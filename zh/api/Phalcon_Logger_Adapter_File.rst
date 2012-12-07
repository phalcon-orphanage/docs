Class **Phalcon\\Logger\\Adapter\\File**
========================================

<<<<<<< HEAD
*extends* :doc:`Phalcon\\Logger <Phalcon_Logger>`

Adapter to store logs in plain text files 
=======
*extends* :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

*implements* :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`

Adapter to store logs in plain text files  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    $logger = new Phalcon\Logger\Adapter\File("app/logs/test.log");
    $logger->log("This is a message");
    $logger->log("This is an error", Phalcon\Logger::ERROR);
    $logger->error("This is another error");
    $logger->close();



<<<<<<< HEAD
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

=======
>>>>>>> 0.7.0
Methods
---------

public  **__construct** (*string* $name, *array* $options)

Phalcon\\Logger\\Adapter\\File constructor



public  **setFormat** (*string* $format)

Set the log format



public *format*  **getFormat** ()

Returns the log format



<<<<<<< HEAD
public *string*  **getTypeString** (*integer* $type)

Returns the string meaning of a logger constant



=======
>>>>>>> 0.7.0
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



<<<<<<< HEAD
public  **debug** (*string* $message) inherited from Phalcon\\Logger
=======
public *string*  **getTypeString** (*integer* $type) inherited from Phalcon\\Logger\\Adapter

Returns the string meaning of a logger constant



public  **debug** (*string* $message) inherited from Phalcon\\Logger\\Adapter
>>>>>>> 0.7.0

Sends/Writes a debug message to the log



<<<<<<< HEAD
public  **error** (*string* $message) inherited from Phalcon\\Logger
=======
public  **error** (*string* $message) inherited from Phalcon\\Logger\\Adapter
>>>>>>> 0.7.0

Sends/Writes an error message to the log



<<<<<<< HEAD
public  **info** (*string* $message) inherited from Phalcon\\Logger
=======
public  **info** (*string* $message) inherited from Phalcon\\Logger\\Adapter
>>>>>>> 0.7.0

Sends/Writes an info message to the log



<<<<<<< HEAD
public  **notice** (*string* $message) inherited from Phalcon\\Logger
=======
public  **notice** (*string* $message) inherited from Phalcon\\Logger\\Adapter
>>>>>>> 0.7.0

Sends/Writes a notice message to the log



<<<<<<< HEAD
public  **warning** (*string* $message) inherited from Phalcon\\Logger
=======
public  **warning** (*string* $message) inherited from Phalcon\\Logger\\Adapter
>>>>>>> 0.7.0

Sends/Writes a warning message to the log



<<<<<<< HEAD
public  **alert** (*string* $message) inherited from Phalcon\\Logger
=======
public  **alert** (*string* $message) inherited from Phalcon\\Logger\\Adapter
>>>>>>> 0.7.0

Sends/Writes an alert message to the log



