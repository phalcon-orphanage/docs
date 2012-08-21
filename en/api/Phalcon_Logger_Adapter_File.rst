Class **Phalcon_Logger_Adapter_File**
=====================================

Adapter to store logs in plain text files  

.. code-block:: php

    <?php
    
    $logger = new Phalcon_Logger("File", "app/logs/test.log");
    $logger->log("This is a message");
    $logger->log("This is an error", Phalcon_Logger::ERROR);
    $logger->error("This is another error");
    $logger->close();

Methods
---------

**__construct** (string $name, array $options)

Phalcon_Logger_Adapter_File constructor

**setFormat** (string $format)

Set the log format

**getFormat** (string $format)

Returns the log format

**string** **getTypeString** (integer $type)

Returns the string meaning of a logger constant

**string** **_applyFormat** (string $message, int $type, int $time)

Applies the internal format to the message

**setDateFormat** (string $date)

Sets the internal date format

**string** **getDateFormat** ()

Returns the internal date format

**log** (string $message, int $type)

Sends/Writes messages to the file log

**begin** ()

Starts a transaction

**commit** ()

Commits the internal transaction

**rollback** ()

Rollbacks the internal transaction

**boolean** **close** ()

Closes the logger

**__wakeup** ()

Opens the internal file handler after unserialization

