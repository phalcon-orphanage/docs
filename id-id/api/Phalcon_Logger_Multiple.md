* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Logger\Multiple'

* * *

# Class **Phalcon\Logger\Multiple**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/logger/multiple.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Handles multiples logger handlers

## Methods

public **getLoggers** ()

...

public **getFormatter** ()

...

public **getLogLevel** ()

...

public **push** ([Phalcon\Logger\AdapterInterface](/4.0/en/api/Phalcon_Logger_AdapterInterface) $logger)

Pushes a logger to the logger tail

public **setFormatter** ([Phalcon\Logger\FormatterInterface](/4.0/en/api/Phalcon_Logger_FormatterInterface) $formatter)

Sets a global formatter

public **setLogLevel** (*mixed* $level)

Sets a global level

public **log** (*mixed* $type, [*mixed* $message], [*array* $context])

Sends a message to each registered logger

public **critical** (*mixed* $message, [*array* $context])

Sends/Writes an critical message to the log

public **emergency** (*mixed* $message, [*array* $context])

Sends/Writes an emergency message to the log

public **debug** (*mixed* $message, [*array* $context])

Sends/Writes a debug message to the log

public **error** (*mixed* $message, [*array* $context])

Sends/Writes an error message to the log

public **info** (*mixed* $message, [*array* $context])

Sends/Writes an info message to the log

public **notice** (*mixed* $message, [*array* $context])

Sends/Writes a notice message to the log

public **warning** (*mixed* $message, [*array* $context])

Sends/Writes a warning message to the log

public **alert** (*mixed* $message, [*array* $context])

Sends/Writes an alert message to the log