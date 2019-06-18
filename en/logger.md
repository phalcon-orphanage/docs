---
layout: default
language: 'en'
version: '4.0'
upgrade: '#logger'
category: 'logger'
---
# Logger Component
<hr/>

## Logging
[Phalcon\Logger][L1] is a component providing logging services for applications. It offers logging to different back-ends using different adapters. It also offers transaction logging, configuration options and different logging formats. You can use the [Phalcon\Logger][L1] for any logging need your application has, from debugging processes to tracing application flow.

![](/assets/images/implements-psr--3-orange.svg)

The [Phalcon\Logger][L1] has been rewritten to comply with [PSR-3][psr-3]. This allows you to use the [Phalcon\Logger][L1] to any application that utilizes a [PSR-3][psr-3] logger, not just Phalcon based ones.

In v3, the logger was incorporating the adapter in the same component. So in essence when creating a logger object, the developer was creating an adapter (file, stream etc.) with logger functionality. 

For v4, we rewrote the component to implement only the logging functionality and to accept one or more adapters that would be responsible for doing the work of logging. This immediately offers compatibility with [PSR-3][psr-3] and separates the responsibilities of the component. It also offers an easy way to attach more than one adapter to the logging component so that logging to multiple adapters can be achieved. By using this implementation we have reduced the code necessary for this component and removed the old `Logger\Multiple` component.

## Adapters
This component makes use of adapters to store the logged messages. The use of adapters allows for a common logging interface which provides the ability to easily switch back-ends, or use multiple adapters if necessary. The adapters supported are:

- [Phalcon\Logger\Adapter\Noop][L2]
- [Phalcon\Logger\Adapter\Stream][L3]
- [Phalcon\Logger\Adapter\Syslog][L4]

### Stream
This adapter is used when we want to log messages to a particular file stream. This adapter combines the v3 `Stream` and `File` ones. Usually this is the most used one: logging to a file in the file system.

### Syslog
This adapter sends messages to the system log. The syslog behavior may vary from one operating system to another.

### Noop
This is a black hole adapter. It sends messages to *infinity and beyond*! This adapter is used mostly for testing or if you want to joke with a colleague.

## Logger Factory 
You can use the [Phalcon\Logger\LoggerFactory][L5] component to create a logger. For the [Phalcon\Logger\LoggerFactory][L5] to work, it needs to be instantiated with an [Phalcon\Logger\AdapterFactory][L6]:

```php
<?php

use Phalcon\Logger\LoggerFactory;
use Phalcon\Logger\AdapterFactory;

$adapterFactory = new AdapterFactory();
$loggerFactory  = new LoggerFactory($adapterFactory);
```
### load
[Phalcon\Logger\LoggerFactory][L5] offers the `load` method, that constructs a logger based on supplied configuration. The configuration can be an array or a [Phalcon\Config](config) object. 

> Use Case: Create a Logger with two Stream adapters. One adapter will be called `main` for logging all messages, while the second one will be called `admin`, logging only messages generated in the admin area of our application 
{: .alert .alert-info}

```php
<?php

use Phalcon\Logger\AdapterFactory;
use Phalcon\Logger\LoggerFactory;

$config = [
    "name"     => "prod-logger",
    "adapters" => [
        "main"  => [
            "adapter" => "stream",
            "file"    => "/storage/logs/main.log",
            "options" => []
        ],
        "admin" => [
            "adapter" => "stream",
            "file"    => "/storage/logs/admin.log",
            "options" => []
        ],
    ],
];

$adapterFactory = new AdapterFactory();
$loggerFactory  = new LoggerFactory($adapterFactory);

$logger = $loggerFactory->load($config);
```

### newInstance
The [Phalcon\Logger\LoggerFactory][L5] also offers the `newInstance()` method, that constructs a logger based on the supplied name and array of relevant adapters. Using the use case above:

```php
<?php

use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\AdapterFactory;
use Phalcon\Logger\LoggerFactory;

$adapters = [
    "main"  => new Stream("/storage/logs/main.log"),
    "admin" => new Stream("/storage/logs/admin.log"),
];

$adapterFactory = new AdapterFactory();
$loggerFactory  = new LoggerFactory($adapterFactory);

$logger = $loggerFactory->newInstance('prod-logger', $adapters);
```

## Creating a logger
Creating a logger is a multi step process. First you create the logger object and then you attach an adapter to it. After that you can start logging messages according to the needs of your application.

```php
<?php

use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Logger;

$adapter = new Stream('/storage/logs/main.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

The above example creates a [Stream][L3] adapter. We then create a logger object and attach this adapter to it. Each adapter attached to a logger needs to have a unique name, for the logger to be able to know where to log the messages. When calling the `error()` method on the logger object, the message is going to be stored in the `/storage/logs/main.log`.

Since the logger component implements PSR-3, the following methods are available:

```php
<?php

use Phalcon\Logger\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/storage/logs/main.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->alert("This is an alert message");
$logger->critical("This is a critical message");
$logger->debug("This is a debug message");
$logger->error("This is an error message");
$logger->emergency("This is an emergency message");
$logger->info("This is an info message");
$logger->log(Logger::CRITICAL, "This is a log message");
$logger->notice("This is a notice message");
$logger->warning("This is a warning message");

```
The log generated is as follows:

```bash
[Tue, 25 Dec 18 12:13:14 -0400][ALERT] This is an alert message
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] This is a critical message
[Tue, 25 Dec 18 12:13:14 -0400][DEBUG] This is a debug message
[Tue, 25 Dec 18 12:13:14 -0400][ERROR] This is an error message
[Tue, 25 Dec 18 12:13:14 -0400][EMERGENCY] This is an emergency message
[Tue, 25 Dec 18 12:13:14 -0400][INFO] This is an info message
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] This is a log message
[Tue, 25 Dec 18 12:13:14 -0400][NOTICE] This is a notice message
[Tue, 25 Dec 18 12:13:14 -0400][WARNING] This is warning message
```

## Logging to Multiple Adapters
[Phalcon\Logger][L1] can send messages to multiple adapters with a just single call:

```php
<?php

use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Logger;

$adapter1 = new Stream('/logs/first-log.log');
$adapter2 = new Stream('/remote/second-log.log');
$adapter3 = new Stream('/manager/third-log.log');

$logger = new Logger(
    'messages',
    [
        'local'   => $adapter1,
        'remote'  => $adapter2,
        'manager' => $adapter3,
    ]
);

// Log to all adapters
$logger->error('Something went wrong');
```

The messages are sent to the handlers in the order they were registered using the [first in first out][fifo] principle.

### Excluding adapters 
[Phalcon\Logger][L1] also offers the ability to exclude logging to one or more adapters when logging a message. This is particularly useful when in need to log a `manager` related message in the `manager` log but not in the `local` log without having to instantiate a new logger.

```php
<?php

use Phalcon\Logger\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter1 = new Stream('/logs/first-log.log');
$adapter2 = new Stream('/remote/second-log.log');
$adapter3 = new Stream('/manager/third-log.log');

$logger = new Logger(
    'messages',
    [
        'local'   => $adapter1,
        'remote'  => $adapter2,
        'manager' => $adapter3,
    ]
);

// Log to all adapters
$logger->error('Something went wrong');

// Log only to remote and manager
$logger
    ->excludeAdapters(['local'])
    ->info('This does not go to the "local" logger');
```

## Message Formatting
This component makes use of `formatters` to format messages before sending them to the backend. The formatters available are:

- [Phalcon\Logger\Formatter\Line][L7]
- [Phalcon\Logger\Formatter\Json][L8]
- [Phalcon\Logger\Formatter\Syslog][L9]

### Line Formatter
Formats the messages using a one-line string. The default logging format is:

```bash
[%date%][%type%] %message%
```

#### Message Format
If the default format of the message does not fit the needs of your application you can change it using the `setFormat()` method. The log format variables allowed are:

| Variable    | Description                              |
|-------------|------------------------------------------|
| `%message%` | The message itself expected to be logged |
| `%date%`    | Date the message was added               |
| `%type%`    | Uppercase string with message type       |

The following example demonstrates how to change the message format:

```php
<?php

use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;
use Phalcon\Logger\Logger;

$formatter = new Line('[%type%] - [%date%] - %message%');
$adapter   = new Stream('/storage/logs/main.log');

$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

which produces:

```bash
[ALERT] - [Tue, 25 Dec 18 12:13:14 -0400] - Something went wrong
```

If you do not want to use the constructor to change the message, you can always use the `setFormat()` on the formatter:

```php
<?php

use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;
use Phalcon\Logger\Logger;

$formatter = new Line();
$formatter->setFormat('[%type%] - [%date%] - %message%');

$adapter = new Stream('/storage/logs/main.log');

$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

#### Date Format
The default date format is:

```bash
"D, d M y H:i:s O"
```

If the default format of the message does not fit the needs of your application you can change it using the `setDateFormat()` method. The method accepts a string with characters that correspond to date formats. For all available formats, please consult [this page][date-formats].

```php
<?php

use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;
use Phalcon\Logger\Logger;

$formatter = new Line();
$formatter->setDateFormat('Ymd-His');

$adapter = new Stream('/storage/logs/main.log');

$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong'); 
```
which produces:

```bash
[ERROR] - [20181225-121314] - Something went wrong
```

### JSON Formatter
Formats the messages returning a JSON string:

```json
{
    "type"      : "Type of the message",
    "message"   : "The message",
    "timestamp" : "The date as defined in the date format"
}
```

#### Date Format
The default date format is:

```bash
"D, d M y H:i:s O"
```

If the default format of the message does not fit the needs of your application you can change it using the `setDateFormat()` method. The method accepts a string with characters that correspond to date formats. For all available formats, please consult [this page][date-formats].

```php
<?php

use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;
use Phalcon\Logger\Logger;

$formatter = new Line();
$formatter->setDateFormat('Ymd-His');

$adapter = new Stream('/storage/logs/main.log');
$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

which produces:

```json
{
    "type"      : "error",
    "message"   : "Something went wrong",
    "timestamp" : "20181225-121314"
}
```

### Syslog Formatter
Formats the messages returning an array with the type and message as elements:

```bash
[
    "type",
    "message",
]
```

### Custom Formatter
The [Phalcon\Logger\Formatter\FormatterInterface][L10] interface must be implemented in order to create your own formatter or extend the existing ones.

## Interpolation
The logger also supports interpolation. There are times that you might need to inject additional text in your logging messages; text that is dynamically created by your application. This can be easily achieved by sending an array as the second parameter of the logging method (i.e. `error`, `info`, `alert` etc.). The array holds keys and values, where the key is the placeholder in the message and the value is what will be injected in the message.

The following example demonstrates interpolation by injecting in the message the parameter "framework" and "secs".

```php
<?php

use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Logger;

$adapter = new Stream('/storage/logs/main.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$message = '{framework} executed the "Hello World" test in {secs} second(s)';
$context = [
    'framework' => 'Phalcon',
    'secs'      => 1,
];

$logger->info($message, $context);
```

## Examples

### Stream
Logging to a file:

```php
<?php

use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Logger;

$adapter = new Stream('/storage/logs/main.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

// Log to all adapters
$logger->error('Something went wrong');
```

The stream logger writes messages to a valid registered stream in PHP. A list of streams is available [here][stream-wrappers]. Logging to a stream

```php
<?php

use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Logger;

$adapter = new Stream('php://stderr');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

### Syslog

```php
<?php

use Phalcon\Logger\Adapter\Syslog;
use Phalcon\Logger\Logger;

// Setting ident/mode/facility
$adapter = new Syslog(
    'ident-name',
    [
        'option'   => LOG_NDELAY,
        'facility' => LOG_MAIL,
    ]
);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

### Noop

```php
<?php

use Phalcon\Logger\Adapter\Noop;
use Phalcon\Logger\Logger;

$adapter = new Noop('nothing');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

### Implementing your own adapters
The [Phalcon\Logger\AdapterInterface][L11] interface must be implemented in order to create your own logger adapters or extend the existing ones.

[date-formats]: https://secure.php.net/manual/en/function.date.php
[fifo]: https://en.wikipedia.org/wiki/FIFO_(computing_and_electronics)
[psr-3]: https://www.php-fig.org/psr/psr-3/
[stream-wrappers]: https://php.net/manual/en/wrappers.php
[L1]: api/Phalcon_Logger#Phalcon_Logger_Logger
[L2]: api/Phalcon_Logger#Phalcon_Logger_Adapter_Noop
[L3]: api/Phalcon_Logger#Phalcon_Logger_Adapter_Stream
[L4]: api/Phalcon_Logger#Phalcon_Logger_Adapter_Syslog
[L5]: api/Phalcon_Logger#Phalcon_Logger_LoggerFactory
[L6]: api/Phalcon_Logger#Phalcon_Logger_AdapterFactory
[L7]: api/Phalcon_Logger#Phalcon_Logger_Formatter_Line
[L8]: api/Phalcon_Logger#Phalcon_Logger_Formatter_Json
[L9]: api/Phalcon_Logger#Phalcon_Logger_Formatter_Syslog
[L10]: api/Phalcon_Logger#Phalcon_Logger_Formatter_FormatterInterface
[L11]: api/Phalcon_Logger#Phalcon_Logger_Adapter_AdapterInterface
