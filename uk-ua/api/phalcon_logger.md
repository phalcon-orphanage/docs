---
layout: default
language: 'uk-ua'
version: '4.0'
title: 'Phalcon\Logger'
---

* [Phalcon\Logger](#logger)
* [Phalcon\Logger\Adapter\AbstractAdapter](#logger-adapter-abstractadapter)
* [Phalcon\Logger\Adapter\AdapterInterface](#logger-adapter-adapterinterface)
* [Phalcon\Logger\Adapter\Noop](#logger-adapter-noop)
* [Phalcon\Logger\Adapter\Stream](#logger-adapter-stream)
* [Phalcon\Logger\Adapter\Syslog](#logger-adapter-syslog)
* [Phalcon\Logger\AdapterFactory](#logger-adapterfactory)
* [Phalcon\Logger\Exception](#logger-exception)
* [Phalcon\Logger\Formatter\AbstractFormatter](#logger-formatter-abstractformatter)
* [Phalcon\Logger\Formatter\FormatterInterface](#logger-formatter-formatterinterface)
* [Phalcon\Logger\Formatter\Json](#logger-formatter-json)
* [Phalcon\Logger\Formatter\Line](#logger-formatter-line)
* [Phalcon\Logger\Item](#logger-item)
* [Phalcon\Logger\LoggerFactory](#logger-loggerfactory)

<h1 id="logger">Class Phalcon\Logger</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Logger.zep)

| Namespace | Phalcon | | Uses | Psr\Log\LoggerInterface, Phalcon\Logger\Adapter\AdapterInterface, Phalcon\Logger\Item, Phalcon\Logger\Exception | | Implements | LoggerInterface |

Phalcon\Logger

This component offers logging capabilities for your application. The component accepts multiple adapters, working also as a multiple logger. Phalcon\Logger implements PSR-3.

```php
use Phalcon\Logger;
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

// Log to specific adapters
$logger
        ->excludeAdapters(['manager'])
        ->info('This does not go to the "manager" logger);
```

## Constants

```php
const ALERT = 2;
const CRITICAL = 1;
const CUSTOM = 8;
const DEBUG = 7;
const EMERGENCY = 0;
const ERROR = 3;
const INFO = 6;
const NOTICE = 5;
const WARNING = 4;
```

## Properties

```php
/**
 * The adapter stack
 *
 * @var AdapterInterface[]
 */
protected adapters;

/**
 * Minimum log level for the logger
 *
 * @var int
 */
protected logLevel = 8;

/**
 * @var string
 */
protected name = ;

/**
 * The excluded adapters for this log process
 *
 * @var AdapterInterface[]
 */
protected excluded;

```

## Methods

Constructor.

```php
public function __construct( string $name, array $adapters = [] );
```

Add an adapter to the stack. For processing we use FIFO

```php
public function addAdapter( string $name, AdapterInterface $adapter ): Logger;
```

Action must be taken immediately.

Example: Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up.

```php
public function alert( mixed $message, array $context = [] ): void;
```

Critical conditions.

Example: Application component unavailable, unexpected exception.

```php
public function critical( mixed $message, array $context = [] ): void;
```

Detailed debug information.

```php
public function debug( mixed $message, array $context = [] ): void;
```

System is unusable.

```php
public function emergency( mixed $message, array $context = [] ): void;
```

Runtime errors that do not require immediate action but should typically be logged and monitored.

```php
public function error( mixed $message, array $context = [] ): void;
```

Exclude certain adapters.

```php
public function excludeAdapters( array $adapters = [] ): Logger;
```

Returns an adapter from the stack

```php
public function getAdapter( string $name ): AdapterInterface;
```

Returns the adapter stack array

```php
public function getAdapters(): array;
```

```php
public function getLogLevel(): int
```

Returns the name of the logger

```php
public function getName(): string;
```

Interesting events.

Example: User logs in, SQL logs.

```php
public function info( mixed $message, array $context = [] ): void;
```

Logs with an arbitrary level.

```php
public function log( mixed $level, mixed $message, array $context = [] ): void;
```

Normal but significant events.

```php
public function notice( mixed $message, array $context = [] ): void;
```

Removes an adapter from the stack

```php
public function removeAdapter( string $name ): Logger;
```

Sets the adapters stack overriding what is already there

```php
public function setAdapters( array $adapters ): Logger;
```

Sets the log level above which we can log

```php
public function setLogLevel( int $level ): Logger;
```

Exceptional occurrences that are not errors.

Example: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong.

```php
public function warning( mixed $message, array $context = [] ): void;
```

Adds a message to each handler for processing

```php
protected function addMessage( int $level, string $message, array $context = [] ): bool;
```

Returns an array of log levels with integer to string conversion

```php
protected function getLevels(): array;
```

<h1 id="logger-adapter-abstractadapter">Abstract Class Phalcon\Logger\Adapter\AbstractAdapter</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Logger/Adapter/AbstractAdapter.zep)

| Namespace | Phalcon\Logger\Adapter | | Uses | Phalcon\Logger, Phalcon\Logger\Exception, Phalcon\Logger\Formatter\FormatterInterface, Phalcon\Logger\Item | | Implements | AdapterInterface |

This file is part of the Phalcon Framework.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

## Properties

```php
/**
 * Name of the default formatter class
 *
 * @var string
 */
protected defaultFormatter = Line;

/**
 * Formatter
 *
 * @var FormatterInterface
 */
protected formatter;

/**
 * Tells if there is an active transaction or not
 *
 * @var bool
 */
protected inTransaction = false;

/**
 * Array with messages queued in the transaction
 *
 * @var array
 */
protected queue;

```

## Methods

Destructor cleanup

```php
public function __destruct();
```

Adds a message to the queue

```php
public function add( Item $item ): AdapterInterface;
```

Starts a transaction

```php
public function begin(): AdapterInterface;
```

Commits the internal transaction

```php
public function commit(): AdapterInterface;
```

```php
public function getFormatter(): FormatterInterface;
```

Returns the whether the logger is currently in an active transaction or not

```php
public function inTransaction(): bool;
```

Processes the message in the adapter

```php
abstract public function process( Item $item ): void;
```

Rollbacks the internal transaction

```php
public function rollback(): AdapterInterface;
```

Sets the message formatter

```php
public function setFormatter( FormatterInterface $formatter ): AdapterInterface;
```

<h1 id="logger-adapter-adapterinterface">Interface Phalcon\Logger\Adapter\AdapterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Logger/Adapter/AdapterInterface.zep)

| Namespace | Phalcon\Logger\Adapter | | Uses | Phalcon\Logger\Formatter\FormatterInterface, Phalcon\Logger\Item |

Phalcon\Logger\AdapterInterface

Interface for Phalcon\Logger adapters

## Methods

Adds a message in the queue

```php
public function add( Item $item ): AdapterInterface;
```

Starts a transaction

```php
public function begin(): AdapterInterface;
```

Closes the logger

```php
public function close(): bool;
```

Commits the internal transaction

```php
public function commit(): AdapterInterface;
```

Returns the internal formatter

```php
public function getFormatter(): FormatterInterface;
```

Returns the whether the logger is currently in an active transaction or not

```php
public function inTransaction(): bool;
```

Processes the message in the adapter

```php
public function process( Item $item ): void;
```

Rollbacks the internal transaction

```php
public function rollback(): AdapterInterface;
```

Sets the message formatter

```php
public function setFormatter( FormatterInterface $formatter ): AdapterInterface;
```

<h1 id="logger-adapter-noop">Class Phalcon\Logger\Adapter\Noop</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Logger/Adapter/Noop.zep)

| Namespace | Phalcon\Logger\Adapter | | Uses | Phalcon\Logger\Item | | Extends | AbstractAdapter |

Phalcon\Logger\Adapter\Noop

Adapter to store logs in plain text files

```php
$logger = new \Phalcon\Logger\Adapter\Noop();

$logger->log(\Phalcon\Logger::ERROR, "This is an error");
$logger->error("This is another error");

$logger->close();
```

## Methods

Closes the stream

```php
public function close(): bool;
```

Processes the message i.e. writes it to the file

```php
public function process( Item $item ): void;
```

<h1 id="logger-adapter-stream">Class Phalcon\Logger\Adapter\Stream</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Logger/Adapter/Stream.zep)

| Namespace | Phalcon\Logger\Adapter | | Uses | Phalcon\Logger\Adapter, Phalcon\Logger\Exception, Phalcon\Logger\Formatter\FormatterInterface, Phalcon\Logger\Item, UnexpectedValueException | | Extends | AbstractAdapter |

Phalcon\Logger\Adapter\Stream

Adapter to store logs in plain text files

```php
$logger = new \Phalcon\Logger\Adapter\Stream("app/logs/test.log");

$logger->log("This is a message");
$logger->log(\Phalcon\Logger::ERROR, "This is an error");
$logger->error("This is another error");

$logger->close();
```

## Properties

```php
/**
 * Stream handler resource
 *
 * @var resource|null
 */
protected handler;

/**
 * The file open mode. Defaults to "ab"
 *
 * @var string
 */
protected mode = ab;

/**
 * Stream name
 *
 * @var string
 */
protected name;

/**
 * Path options
 *
 * @var array
 */
protected options;

```

## Methods

Constructor. Accepts the name and some options

```php
public function __construct( string $name, array $options = [] );
```

Closes the stream

```php
public function close(): bool;
```

```php
public function getName(): string
```

Processes the message i.e. writes it to the file

```php
public function process( Item $item ): void;
```

<h1 id="logger-adapter-syslog">Class Phalcon\Logger\Adapter\Syslog</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Logger/Adapter/Syslog.zep)

| Namespace | Phalcon\Logger\Adapter | | Uses | LogicException, Phalcon\Helper\Arr, Phalcon\Logger, Phalcon\Logger\Adapter, Phalcon\Logger\Exception, Phalcon\Logger\Formatter\FormatterInterface, Phalcon\Logger\Item | | Extends | AbstractAdapter |

Phalcon\Logger\Adapter\Syslog

Sends logs to the system logger

```php
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

## Properties

```php
/**
 * Name of the default formatter class
 *
 * @var string
 */
protected defaultFormatter = Line;

/**
 * @var int
 */
protected facility = 0;

/**
 * @var string
 */
protected name = ;

/**
 * @var bool
 */
protected opened = false;

/**
 * @var int
 */
protected option = 0;

```

## Methods

Phalcon\Logger\Adapter\Syslog constructor

```php
public function __construct( string $name, array $options = [] );
```

Closes the logger

```php
public function close(): bool;
```

Processes the message i.e. writes it to the syslog

```php
public function process( Item $item ): void;
```

<h1 id="logger-adapterfactory">Class Phalcon\Logger\AdapterFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Logger/AdapterFactory.zep)

| Namespace | Phalcon\Logger | | Uses | Phalcon\Factory\AbstractFactory, Phalcon\Logger\Adapter\AdapterInterface | | Extends | AbstractFactory |

This file is part of the Phalcon Framework.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

## Methods

AdapterFactory constructor.

```php
public function __construct( array $services = [] );
```

Create a new instance of the adapter

```php
public function newInstance( string $name, string $fileName, array $options = [] ): AdapterInterface;
```

```php
protected function getAdapters(): array;
```

<h1 id="logger-exception">Class Phalcon\Logger\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Logger/Exception.zep)

| Namespace | Phalcon\Logger | | Extends | \Phalcon\Exception |

Phalcon\Logger\Exception

Exceptions thrown in Phalcon\Logger will use this class

<h1 id="logger-formatter-abstractformatter">Abstract Class Phalcon\Logger\Formatter\AbstractFormatter</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Logger/Formatter/AbstractFormatter.zep)

| Namespace | Phalcon\Logger\Formatter | | Uses | DateTimeImmutable, DateTimeZone, Phalcon\Logger, Phalcon\Logger\Item | | Implements | FormatterInterface |

This file is part of the Phalcon Framework.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

## Properties

```php
/**
 * Default date format
 *
 * @var string
 */
protected dateFormat;

```

## Methods

```php
public function getDateFormat(): string
```

Interpolates context values into the message placeholders

@see http://www.php-fig.org/psr/psr-3/ Section 1.2 Message

```php
public function interpolate( string $message, mixed $context = null );
```

```php
public function setDateFormat( string $dateFormat )
```

Returns the date formatted for the logger. @todo Not using the set time from the Item since we have interface misalignment which will break semver This will change in the future

```php
protected function getFormattedDate(): string;
```

<h1 id="logger-formatter-formatterinterface">Interface Phalcon\Logger\Formatter\FormatterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Logger/Formatter/FormatterInterface.zep)

| Namespace | Phalcon\Logger\Formatter | | Uses | Phalcon\Logger\Item |

Phalcon\Logger\FormatterInterface

This interface must be implemented by formatters in Phalcon\Logger

## Methods

Applies a format to an item

```php
public function format( Item $item ): string | array;
```

<h1 id="logger-formatter-json">Class Phalcon\Logger\Formatter\Json</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Logger/Formatter/Json.zep)

| Namespace | Phalcon\Logger\Formatter | | Uses | Phalcon\Helper\Json, Phalcon\Logger\Item | | Extends | AbstractFormatter |

Phalcon\Logger\Formatter\Json

Formats messages using JSON encoding

## Methods

Phalcon\Logger\Formatter\Json construct

```php
public function __construct( string $dateFormat = string );
```

Applies a format to a message before sent it to the internal log

```php
public function format( Item $item ): string;
```

<h1 id="logger-formatter-line">Class Phalcon\Logger\Formatter\Line</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Logger/Formatter/Line.zep)

| Namespace | Phalcon\Logger\Formatter | | Uses | DateTime, Phalcon\Logger\Item | | Extends | AbstractFormatter |

Phalcon\Logger\Formatter\Line

Formats messages using an one-line string

## Properties

```php
/**
 * Format applied to each message
 *
 * @var string
 */
protected format;

```

## Methods

Phalcon\Logger\Formatter\Line construct

```php
public function __construct( string $format = string, string $dateFormat = string );
```

Applies a format to a message before sent it to the internal log

```php
public function format( Item $item ): string;
```

```php
public function getFormat(): string
```

```php
public function setFormat( string $format )
```

<h1 id="logger-item">Class Phalcon\Logger\Item</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Logger/Item.zep)

| Namespace | Phalcon\Logger |

Phalcon\Logger\Item

Represents each item in a logging transaction

## Properties

```php
//
protected context;

/**
 * Log message
 *
 * @var string
 */
protected message;

/**
 * Log message
 *
 * @var string
 */
protected name;

/**
 * Log timestamp
 *
 * @var integer
 */
protected time;

/**
 * Log type
 *
 * @var integer
 */
protected type;

```

## Methods

Phalcon\Logger\Item constructor @todo Remove the time or change the signature to an array

```php
public function __construct( string $message, string $name, int $type, int $time = int, mixed $context = [] );
```

```php
public function getContext()
```

```php
public function getMessage(): string
```

```php
public function getName(): string
```

```php
public function getTime(): integer
```

```php
public function getType(): integer
```

<h1 id="logger-loggerfactory">Class Phalcon\Logger\LoggerFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Logger/LoggerFactory.zep)

| Namespace | Phalcon\Logger | | Uses | Phalcon\Config, Phalcon\Helper\Arr, Phalcon\Logger |

Phalcon\Logger\LoggerFactory

Logger factory

## Properties

```php
/**
 * @var AdapterFactory
 */
private adapterFactory;

```

## Methods

```php
public function __construct( AdapterFactory $factory );
```

Factory to create an instance from a Config object

```php
public function load( mixed $config ): Logger;
```

Returns a Logger object

```php
public function newInstance( string $name, array $adapters = [] ): Logger;
```