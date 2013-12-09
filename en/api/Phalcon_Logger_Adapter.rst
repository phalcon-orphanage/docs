Abstract class **Phalcon\\Logger\\Adapter**
===========================================

Base class for Phalcon\\Logger adapters


Methods
---------

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



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **emergency** (*string* $message)

Sends/Writes an emergency message to the log



public  **emergence** (*unknown* $message)

...


public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **debug** (*string* $message)

Sends/Writes a debug message to the log



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **error** (*string* $message)

Sends/Writes an error message to the log



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **info** (*string* $message)

Sends/Writes an info message to the log



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **notice** (*string* $message)

Sends/Writes a notice message to the log



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **warning** (*string* $message)

Sends/Writes a warning message to the log



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **alert** (*string* $message)

Sends/Writes an alert message to the log



public :doc:`Phalcon\\Logger\\Adapter <Phalcon_Logger_Adapter>`  **log** (*string* $message, [*int* $type])

Logs messages to the internal loggger. Appends logs to the



