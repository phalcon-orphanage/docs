Class **Phalcon\\Logger\\Adapter\\File**
========================================

*extends* abstract class :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

*implements* :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/logger/adapter/file.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Adapter to store logs in plain text files

.. code-block:: php

    <?php

    $logger = new \Phalcon\Logger\Adapter\File("app/logs/test.log");

    $logger->log("This is a message");
    $logger->log(\Phalcon\Logger::ERROR, "This is an error");
    $logger->error("This is another error");

    $logger->close();



Methods
-------

public  **getPath** ()

File Path



public  **__construct** (*string* $name, [*array* $options])

Phalcon\\Logger\\Adapter\\File constructor



public  **getFormatter** ()

Returns the internal formatter



public  **logInternal** (*mixed* $message, *mixed* $type, *mixed* $time, *array* $context)

Writes the log to the file itself



public  **close** ()

Closes the logger



public  **__wakeup** ()

Opens the internal file handler after unserialization



public  **setLogLevel** (*mixed* $level) inherited from :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

Filters the logs sent to the handlers that are less or equal than a specific level



public  **getLogLevel** () inherited from :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

Returns the current log level



public  **setFormatter** (:doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>` $formatter) inherited from :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

Sets the message formatter



public  **begin** () inherited from :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

Starts a transaction



public  **commit** () inherited from :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

Commits the internal transaction



public  **rollback** () inherited from :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

Rollbacks the internal transaction



public  **isTransaction** () inherited from :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

Returns the whether the logger is currently in an active transaction or not



public  **critical** (*mixed* $message, [*array* $context]) inherited from :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

Sends/Writes a critical message to the log



public  **emergency** (*mixed* $message, [*array* $context]) inherited from :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

Sends/Writes an emergency message to the log



public  **debug** (*mixed* $message, [*array* $context]) inherited from :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

Sends/Writes a debug message to the log



public  **error** (*mixed* $message, [*array* $context]) inherited from :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

Sends/Writes an error message to the log



public  **info** (*mixed* $message, [*array* $context]) inherited from :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

Sends/Writes an info message to the log



public  **notice** (*mixed* $message, [*array* $context]) inherited from :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

Sends/Writes a notice message to the log



public  **warning** (*mixed* $message, [*array* $context]) inherited from :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

Sends/Writes a warning message to the log



public  **alert** (*mixed* $message, [*array* $context]) inherited from :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

Sends/Writes an alert message to the log



public  **log** (*mixed* $type, [*mixed* $message], [*array* $context]) inherited from :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`

Logs messages to the internal logger. Appends logs to the logger



