Abstract class **Phalcon\\Logger\\Adapter**
===========================================

*implements* :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`

Base class for Phalcon\\Logger adapters


Methods
-------

public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **setLogLevel** (*int* $level)

Filters the logs sent to the handlers that are less or equal than a specific level



public *int*  **getLogLevel** ()

Returns the current log level



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **setFormatter** (:doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>` $formatter)

Sets the message formatter



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **isTransaction** ()

Returns the current transaction



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **begin** ()

Starts a transaction



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **commit** ()

Commits the internal transaction



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **rollback** ()

Rollbacks the internal transaction



public  **emergence** (*unknown* $message, [*unknown* $context])

...


public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **log** (*unknown* $type, *string* $message, [*array* $context])

Logs messages to the internal logger. Appends messages to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **debug** (*string* $message, [*array* $context])

Sends/Writes a debug message to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **info** (*string* $message, [*array* $context])

Sends/Writes an info message to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **notice** (*string* $message, [*array* $context])

Sends/Writes a notice message to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **warning** (*string* $message, [*array* $context])

Sends/Writes a warning message to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **error** (*string* $message, [*array* $context])

Sends/Writes an error message to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **critical** (*string* $message, [*array* $context])

Sends/Writes a critical message to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **alert** (*string* $message, [*array* $context])

Sends/Writes an alert message to the log



public :doc:`Phalcon\\Logger\\AdapterInterface <Phalcon_Logger_AdapterInterface>`  **emergency** (*string* $message, [*array* $context])

Sends/Writes an emergency message to the log



abstract protected  **logInternal** (*unknown* $message, *unknown* $type, *unknown* $time, *unknown* $context)

...


abstract public :doc:`Phalcon\\Logger\\FormatterInterface <Phalcon_Logger_FormatterInterface>`  **getFormatter** () inherited from Phalcon\\Logger\\AdapterInterface

Returns the internal formatter



abstract public *boolean*  **close** () inherited from Phalcon\\Logger\\AdapterInterface

Closes the logger



