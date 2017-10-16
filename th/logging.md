<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Contextual Escaping</a>
    </li>
    <li>
      <a href="#overview">Logging</a> <ul>
        <li>
          <a href="#adapters">Adapters</a> <ul>
            <li>
              <a href="#adapters-factory">Factory</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#creating">Creating a Log</a>
        </li>
        <li>
          <a href="#transactions">Transactions</a>
        </li>
        <li>
          <a href="#multiple-handlers">Logging to Multiple Handlers</a>
        </li>
        <li>
          <a href="#message-formatting">Message Formatting</a> <ul>
            <li>
              <a href="#message-formatting-line">Line Formatter</a>
            </li>
            <li>
              <a href="#message-formatting-custom">Implementing your own formatters</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#usage">Adapters</a> <ul>
            <li>
              <a href="#usage-stream">Stream Logger</a>
            </li>
            <li>
              <a href="#usage-file">File Logger</a>
            </li>
            <li>
              <a href="#usage-syslog">Syslog Logger</a>
            </li>
            <li>
              <a href="#usage-firephp">FirePHP Logger</a>
            </li>
            <li>
              <a href="#usage-custom">Implementing your own adapters</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Logging

`Phalcon\Logger` is a component whose purpose is to provide logging services for applications. It offers logging to different backends using different adapters. It also offers transaction logging, configuration options, different formats and filters. You can use the `Phalcon\Logger` for every logging need your application has, from debugging processes to tracing application flow.

<a name='adapters'></a>

## Adapters

This component makes use of adapters to store the logged messages. The use of adapters allows for a common logging interface which provides the ability to easily switch backends if necessary. The adapters supported are:

| Adapter                             | Description               |
| ----------------------------------- | ------------------------- |
| `Phalcon\Logger\Adapter\File`    | Logs to a plain text file |
| `Phalcon\Logger\Adapter\Stream`  | Logs to a PHP Streams     |
| `Phalcon\Logger\Adapter\Syslog`  | Logs to the system logger |
| `Phalcon\Logger\Adapter\FirePHP` | Logs to the FirePHP       |

<a name='adapters-factory'></a>

### Factory

Loads Logger Adapter class using `adapter` option

```php
<?php

use Phalcon\Logger\Factory;

$options = [
    'name'    => 'log.txt',
    'adapter' => 'file',
];

$logger = Factory::load($options);
```

<a name='creating'></a>

## Creating a Log

The example below shows how to create a log and add messages to it:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileAdapter;

$logger = new FileAdapter('app/logs/test.log');

// These are the different log levels available:

$logger->critical(
    'This is a critical message'
);

$logger->emergency(
    'This is an emergency message'
);

$logger->debug(
    'This is a debug message'
);

$logger->error(
    'This is an error message'
);

$logger->info(
    'This is an info message'
);

$logger->notice(
    'This is a notice message'
);

$logger->warning(
    'This is a warning message'
);

$logger->alert(
    'This is an alert message'
);

// You can also use the log() method with a Logger constant:
$logger->log(
    'This is another error message',
    Logger::ERROR
);

// If no constant is given, DEBUG is assumed.
$logger->log(
    'This is a message'
);

// You can also pass context parameters like this
$logger->log(
    'This is a {message}', 
    [ 
        'message' => 'parameter' 
    ]
);
```

The log generated is below:

```bash
[Tue, 28 Jul 15 22:09:02 -0500][CRITICAL] This is a critical message
[Tue, 28 Jul 15 22:09:02 -0500][EMERGENCY] This is an emergency message
[Tue, 28 Jul 15 22:09:02 -0500][DEBUG] This is a debug message
[Tue, 28 Jul 15 22:09:02 -0500][ERROR] This is an error message
[Tue, 28 Jul 15 22:09:02 -0500][INFO] This is an info message
[Tue, 28 Jul 15 22:09:02 -0500][NOTICE] This is a notice message
[Tue, 28 Jul 15 22:09:02 -0500][WARNING] This is a warning message
[Tue, 28 Jul 15 22:09:02 -0500][ALERT] This is an alert message
[Tue, 28 Jul 15 22:09:02 -0500][ERROR] This is another error message
[Tue, 28 Jul 15 22:09:02 -0500][DEBUG] This is a message
[Tue, 28 Jul 15 22:09:02 -0500][DEBUG] This is a parameter
```

You can also set a log level using the `setLogLevel()` method. This method takes a Logger constant and will only save log messages that are as important or more important than the constant:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileAdapter;

$logger = new FileAdapter('app/logs/test.log');

$logger->setLogLevel(
    Logger::CRITICAL
);
```

In the example above, only critical and emergency messages will get saved to the log. By default, everything is saved.

<a name='transactions'></a>

## Transactions

Logging data to an adapter i.e. File (file system) is always an expensive operation in terms of performance. To combat that, you can take advantage of logging transactions. Transactions store log data temporarily in memory and later on write the data to the relevant adapter (File in this case) in a single atomic operation.

```php
<?php

use Phalcon\Logger\Adapter\File as FileAdapter;

// Create the logger
$logger = new FileAdapter('app/logs/test.log');

// Start a transaction
$logger->begin();

// Add messages

$logger->alert(
    'This is an alert'
);

$logger->error(
    'This is another error'
);

// Commit messages to file
$logger->commit();
```

<a name='multiple-handlers'></a>

## Logging to Multiple Handlers

`Phalcon\Logger` can send messages to multiple handlers with a just single call:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Multiple as MultipleStream;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Logger\Adapter\Stream as StreamAdapter;

$logger = new MultipleStream();



$logger->push(
    new FileAdapter('test.log')
);

$logger->push(
    new StreamAdapter('php://stdout')
);

$logger->log(
    'This is a message'
);

$logger->log(
    'This is an error',
    Logger::ERROR
);

$logger->error(
    'This is another error'
);
```

The messages are sent to the handlers in the order they were registered.

<a name='message-formatting'></a>

## Message Formatting

This component makes use of `formatters` to format messages before sending them to the backend. The formatters available are:

| Adapter                               | Description                                              |
| ------------------------------------- | -------------------------------------------------------- |
| `Phalcon\Logger\Formatter\Line`    | Formats the messages using a one-line string             |
| `Phalcon\Logger\Formatter\Firephp` | Formats the messages so that they can be sent to FirePHP |
| `Phalcon\Logger\Formatter\Json`    | Prepares a message to be encoded with JSON               |
| `Phalcon\Logger\Formatter\Syslog`  | Prepares a message to be sent to syslog                  |

<a name='message-formatting-line'></a>

### Line Formatter

Formats the messages using a one-line string. The default logging format is:

```bash
[%date%][%type%] %message%
```

You can change the default format using `setFormat()`, this allows you to change the format of the logged messages by defining your own. The log format variables allowed are:

| Variable  | Description                              |
| --------- | ---------------------------------------- |
| %message% | The message itself expected to be logged |
| %date%    | Date the message was added               |
| %type%    | Uppercase string with message type       |

The example below shows how to change the log format:

```php
<?php

use Phalcon\Logger\Formatter\Line as LineFormatter;

$formatter = new LineFormatter('%date% - %message%');

// Changing the logger format
$logger->setFormatter($formatter);
```

<a name='message-formatting-custom'></a>

### Implementing your own formatters

The `Phalcon\Logger\FormatterInterface` interface must be implemented in order to create your own logger formatter or extend the existing ones.

<a name='usage'></a>

## Adapters

The following examples show the basic use of each adapter:

<a name='usage-stream'></a>

### Stream Logger

The stream logger writes messages to a valid registered stream in PHP. A list of streams is available [here](http://php.net/manual/en/wrappers.php>):

```php
<?php

use Phalcon\Logger\Adapter\Stream as StreamAdapter;

// Opens a stream using zlib compression
$logger = new StreamAdapter('compress.zlib://week.log.gz');

// Writes the logs to stderr
$logger = new StreamAdapter('php://stderr');
```

<a name='usage-file'></a>

### File Logger

This logger uses plain files to log any kind of data. By default all logger files are opened using append mode which opens the files for writing only; placing the file pointer at the end of the file. If the file does not exist, an attempt will be made to create it. You can change this mode by passing additional options to the constructor:

```php
<?php

use Phalcon\Logger\Adapter\File as FileAdapter;

// Create the file logger in 'w' mode
$logger = new FileAdapter(
    'app/logs/test.log',
    [
        'mode' => 'w',
    ]
);
```

<a name='usage-syslog'></a>

### Syslog Logger

This logger sends messages to the system logger. The syslog behavior may vary from one operating system to another.

```php
<?php

use Phalcon\Logger\Adapter\Syslog as SyslogAdapter;

// Basic Usage
$logger = new SyslogAdapter(null);

// Setting ident/mode/facility
$logger = new SyslogAdapter(
    'ident-name',
    [
        'option'   => LOG_NDELAY,
        'facility' => LOG_MAIL,
    ]
);
```

<a name='usage-firephp'></a>

### FirePHP Logger

This logger sends messages in HTTP response headers that are displayed by [FirePHP](http://www.firephp.org/), a [Firebug](http://getfirebug.com/) extension for Firefox.

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Firephp as Firephp;

$logger = new Firephp('');

$logger->log(
    'This is a message'
);

$logger->log(
    'This is an error',
    Logger::ERROR
);

$logger->error(
    'This is another error'
);
```

<a name='usage-custom'></a>

### Implementing your own adapters

The `Phalcon\Logger\AdapterInterface` interface must be implemented in order to create your own logger adapters or extend the existing ones.