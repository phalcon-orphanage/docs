Class **Phalcon\\Logger\\Multiple**
===================================

Handles multiples logger handlers


Methods
---------

public  **push** (:doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>` $logger)

Pushes a logger to the logger tail



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>` [] **getLoggers** ()

Returns the registered loggers



public  **setFormatter** (:doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>` $formatter)

Sets a global formatter



public :doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>`  **getFormatter** ()

Returns a formatter



public  **log** (*string* $message, [*int* $type])

Sends a message to each registered logger



public  **emergence** (*string* $message)

Sends/Writes an emergence message to the log



public  **debug** (*string* $message)

Sends/Writes a debug message to the log



public  **error** (*string* $message)

Sends/Writes an error message to the log



public  **info** (*string* $message)

Sends/Writes an info message to the log



public  **notice** (*string* $message)

Sends/Writes a notice message to the log



public  **warning** (*string* $message)

Sends/Writes a warning message to the log



public  **alert** (*string* $message)

Sends/Writes an alert message to the log



