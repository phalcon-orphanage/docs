Interface **Phalcon\\Logger\\AdapterInterface**
===============================================

Phalcon\\Logger\\AdapterInterface initializer


Methods
-------

abstract public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **setFormatter** (:doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>` $formatter)

Sets the message formatter



abstract public :doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>`  **getFormatter** ()

Returns the internal formatter



abstract public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **setLogLevel** (*int* $level)

Filters the logs sent to the handlers to be greater or equals than a specific level



abstract public *int*  **getLogLevel** ()

Returns the current log level



abstract public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **log** (*string* $message, [*int* $type])

Sends/Writes messages to the file log



abstract public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **begin** ()

Starts a transaction



abstract public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **commit** ()

Commits the internal transaction



abstract public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **rollback** ()

Rollbacks the internal transaction



abstract public *boolean*  **close** ()

Closes the logger



abstract public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **debug** (*string* $message)

Sends/Writes a debug message to the log



abstract public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **error** (*string* $message)

Sends/Writes an error message to the log



abstract public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **info** (*string* $message)

Sends/Writes an info message to the log



abstract public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **notice** (*string* $message)

Sends/Writes a notice message to the log



abstract public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **warning** (*string* $message)

Sends/Writes a warning message to the log



abstract public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **alert** (*string* $message)

Sends/Writes an alert message to the log



