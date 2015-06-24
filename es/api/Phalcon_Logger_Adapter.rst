Abstract class **Phalcon\\Logger\\Adapter**
===========================================

Base class for Phalcon\\Logger adapters


Methods
-------

public  **setLogLevel** (*unknown* $level)

Filters the logs sent to the handlers that are less or equal than a specific level



public  **getLogLevel** ()

Returns the current log level



public  **setFormatter** (*unknown* $formatter)

Sets the message formatter



public  **begin** ()

Starts a transaction



public  **commit** ()

Commits the internal transaction



public  **rollback** ()

Rollbacks the internal transaction



public  **critical** (*unknown* $message, [*unknown* $context])

Sends/Writes a critical message to the log



public  **emergency** (*unknown* $message, [*unknown* $context])

Sends/Writes an emergency message to the log



public  **debug** (*unknown* $message, [*unknown* $context])

Sends/Writes a debug message to the log



public  **error** (*unknown* $message, [*unknown* $context])

Sends/Writes an error message to the log



public  **info** (*unknown* $message, [*unknown* $context])

Sends/Writes an info message to the log



public  **notice** (*unknown* $message, [*unknown* $context])

Sends/Writes a notice message to the log



public  **warning** (*unknown* $message, [*unknown* $context])

Sends/Writes a warning message to the log



public  **alert** (*unknown* $message, [*unknown* $context])

Sends/Writes an alert message to the log



public  **log** (*unknown* $type, [*unknown* $message], [*unknown* $context])

Logs messages to the internal logger. Appends logs to the logger



