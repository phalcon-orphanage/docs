# Abstract class **Phalcon\\Logger\\Adapter**

*implements* [Phalcon\Logger\AdapterInterface](/en/3.1.2/api/Phalcon_Logger_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/logger/adapter.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Base class for Phalcon\\Logger adapters

## Methods
public  **setLogLevel** (*mixed* $level)

Filters the logs sent to the handlers that are less or equal than a specific level

public  **getLogLevel** ()

Returns the current log level

public  **setFormatter** ([Phalcon\Logger\FormatterInterface](/en/3.1.2/api/Phalcon_Logger_FormatterInterface) $formatter)

Sets the message formatter

public  **begin** ()

Starts a transaction

public  **commit** ()

Commits the internal transaction

public  **rollback** ()

Rollbacks the internal transaction

public  **isTransaction** ()

Returns the whether the logger is currently in an active transaction or not

public  **critical** (*mixed* $message, [*array* $context])

Sends/Writes a critical message to the log

public  **emergency** (*mixed* $message, [*array* $context])

Sends/Writes an emergency message to the log

public  **debug** (*mixed* $message, [*array* $context])

Sends/Writes a debug message to the log

public  **error** (*mixed* $message, [*array* $context])

Sends/Writes an error message to the log

public  **info** (*mixed* $message, [*array* $context])

Sends/Writes an info message to the log

public  **notice** (*mixed* $message, [*array* $context])

Sends/Writes a notice message to the log

public  **warning** (*mixed* $message, [*array* $context])

Sends/Writes a warning message to the log

public  **alert** (*mixed* $message, [*array* $context])

Sends/Writes an alert message to the log

public  **log** (*mixed* $type, [*mixed* $message], [*array* $context])

Logs messages to the internal logger. Appends logs to the logger

abstract public  **getFormatter** () inherited from [Phalcon\Logger\AdapterInterface](/en/3.1.2/api/Phalcon_Logger_AdapterInterface)

...

abstract public  **close** () inherited from [Phalcon\Logger\AdapterInterface](/en/3.1.2/api/Phalcon_Logger_AdapterInterface)

...

