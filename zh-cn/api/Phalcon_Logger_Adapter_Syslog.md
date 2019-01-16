* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Logger\Adapter\Syslog'

* * *

# Class **Phalcon\Logger\Adapter\Syslog**

*extends* abstract class [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

*implements* [Phalcon\Logger\AdapterInterface](Phalcon_Logger_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/logger/adapter/syslog.zep" class="btn btn-default btn-sm">源码在GitHub</a>

Sends logs to the system logger

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Syslog;

// LOG_USER is the only valid log type under Windows operating systems
$logger = new Syslog(
    "ident",
    [
        "option"   => LOG_CONS | LOG_NDELAY | LOG_PID,
        "facility" => LOG_USER,
    ]
);

$logger->log("This is a message");
$logger->log(Logger::ERROR, "This is an error");
$logger->error("This is another error");

```

## 方法

public **__construct** (*string* $name, [*array* $options])

Phalcon\Logger\Adapter\Syslog constructor

public **getFormatter** ()

Returns the internal formatter

public **logInternal** (*mixed* $message, *mixed* $type, *mixed* $time, *array* $context)

Writes the log to the stream itself

public **close** ()

Closes the logger

public **setLogLevel** (*mixed* $level) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Filters the logs sent to the handlers that are less or equal than a specific level

public **getLogLevel** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Returns the current log level

public **setFormatter** ([Phalcon\Logger\FormatterInterface](Phalcon_Logger_FormatterInterface) $formatter) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sets the message formatter

public **begin** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Starts a transaction

public **commit** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Commits the internal transaction

public **rollback** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Rollbacks the internal transaction

public **isTransaction** () inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Returns the whether the logger is currently in an active transaction or not

public **critical** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sends/Writes a critical message to the log

public **emergency** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sends/Writes an emergency message to the log

public **debug** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sends/Writes a debug message to the log

public **error** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sends/Writes an error message to the log

public **info** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sends/Writes an info message to the log

public **notice** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sends/Writes a notice message to the log

public **warning** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sends/Writes a warning message to the log

public **alert** (*mixed* $message, [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Sends/Writes an alert message to the log

public **log** (*mixed* $type, [*mixed* $message], [*array* $context]) inherited from [Phalcon\Logger\Adapter](Phalcon_Logger_Adapter)

Logs messages to the internal logger. Appends logs to the logger