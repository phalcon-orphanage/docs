---
layout: default
language: 'tr-tr'
version: '5.0'
title: 'Phalcon\Logger'
---

* [Phalcon\Logger\AbstractLogger](#logger-abstractlogger)
* [Phalcon\Logger\Adapter\AbstractAdapter](#logger-adapter-abstractadapter)
* [Phalcon\Logger\Adapter\AdapterInterface](#logger-adapter-adapterinterface)
* [Phalcon\Logger\Adapter\Noop](#logger-adapter-noop)
* [Phalcon\Logger\Adapter\Stream](#logger-adapter-stream)
* [Phalcon\Logger\Adapter\Syslog](#logger-adapter-syslog)
* [Phalcon\Logger\AdapterFactory](#logger-adapterfactory)
* [Phalcon\Logger\Enum](#logger-enum)
* [Phalcon\Logger\Exception](#logger-exception)
* [Phalcon\Logger\Formatter\AbstractFormatter](#logger-formatter-abstractformatter)
* [Phalcon\Logger\Formatter\FormatterInterface](#logger-formatter-formatterinterface)
* [Phalcon\Logger\Formatter\Json](#logger-formatter-json)
* [Phalcon\Logger\Formatter\Line](#logger-formatter-line)
* [Phalcon\Logger\Item](#logger-item)
* [Phalcon\Logger\Logger](#logger-logger)
* [Phalcon\Logger\LoggerFactory](#logger-loggerfactory)
* [Phalcon\Logger\LoggerInterface](#logger-loggerinterface)

<h1 id="logger-abstractlogger">Abstract Class Phalcon\Logger\AbstractLogger</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/AbstractLogger.zep)

| Namespace  | Phalcon\Logger | | Uses       | DateTimeImmutable, DateTimeZone, Exception, Phalcon\Logger\Exception, Phalcon\Logger\Adapter\AdapterInterface |

Abstract Logger Class

Abstract logger class, providing common functionality. A formatter interface is available as well as an adapter one. Adapters can be created easily using the built in AdapterFactory. A LoggerFactory is also available that allows developers to create new instances of the Logger or load them from config files (see Phalcon\Config\Config object).

@property AdapterInterface[] $adapters @property array              $excluded @property int                $logLevel @property string             $name @property string             $timezone


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
 * The excluded adapters for this log process
 *
 * @var array
 */
protected excluded;

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
 * @var DateTimeZone
 */
protected timezone;

```

## Methods

```php
public function __construct( string $name, array $adapters = [], DateTimeZone $timezone = null );
```
Constructor.


```php
public function addAdapter( string $name, AdapterInterface $adapter ): AbstractLogger;
```
Add an adapter to the stack. For processing we use FIFO


```php
public function excludeAdapters( array $adapters = [] ): AbstractLogger;
```
Exclude certain adapters.


```php
public function getAdapter( string $name ): AdapterInterface;
```
Returns an adapter from the stack


```php
public function getAdapters(): array;
```
Returns the adapter stack array


```php
public function getLogLevel(): int;
```
Returns the log level


```php
public function getName(): string;
```
Returns the name of the logger


```php
public function removeAdapter( string $name ): AbstractLogger;
```
Removes an adapter from the stack


```php
public function setAdapters( array $adapters ): AbstractLogger;
```
Sets the adapters stack overriding what is already there


```php
public function setLogLevel( int $level ): AbstractLogger;
```
Sets the adapters stack overriding what is already there


```php
protected function addMessage( int $level, string $message, array $context = [] ): bool;
```
Adds a message to each handler for processing


```php
protected function getLevelNumber( mixed $level ): int;
```
Converts the level from string/word to an integer


```php
protected function getLevels(): array;
```
Returns an array of log levels with integer to string conversion




<h1 id="logger-adapter-abstractadapter">Abstract Class Phalcon\Logger\Adapter\AbstractAdapter</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Adapter/AbstractAdapter.zep)

| Namespace  | Phalcon\Logger\Adapter | | Uses       | Phalcon\Logger\Exception, Phalcon\Logger\Formatter\FormatterInterface, Phalcon\Logger\Formatter\Line, Phalcon\Logger\Item | | Implements | AdapterInterface |

Class AbstractAdapter

@property string             $defaultFormatter @property FormatterInterface $formatter @property bool               $inTransaction @property array              $queue


## Properties
```php
/**
 * Name of the default formatter class
 *
 * @var string
 */
protected defaultFormatter = Phalcon\\Logger\Formatter\\Line;

/**
 * Formatter
 *
 * @var FormatterInterface|null
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

```php
public function __destruct();
```
Destructor cleanup

@throws Exception


```php
public function __serialize(): array;
```
Prevent serialization


```php
public function __unserialize( array $data ): void;
```
Prevent unserialization


```php
public function add( Item $item ): AdapterInterface;
```
Adds a message to the queue


```php
public function begin(): AdapterInterface;
```
Starts a transaction


```php
public function commit(): AdapterInterface;
```
Commits the internal transaction


```php
public function getFormatter(): FormatterInterface;
```

```php
public function inTransaction(): bool;
```
Returns the whether the logger is currently in an active transaction or not


```php
abstract public function process( Item $item ): void;
```
Processes the message in the adapter


```php
public function rollback(): AdapterInterface;
```
Rollbacks the internal transaction


```php
public function setFormatter( FormatterInterface $formatter ): AdapterInterface;
```
Sets the message formatter


```php
protected function getFormattedItem( Item $item ): string;
```
Returns the formatted item




<h1 id="logger-adapter-adapterinterface">Interface Phalcon\Logger\Adapter\AdapterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Adapter/AdapterInterface.zep)

| Namespace  | Phalcon\Logger\Adapter | | Uses       | Phalcon\Logger\Formatter\FormatterInterface, Phalcon\Logger\Item |

Phalcon\Logger\AdapterInterface

Interface for Phalcon\Logger adapters


## Methods

```php
public function add( Item $item ): AdapterInterface;
```
Adds a message in the queue


```php
public function begin(): AdapterInterface;
```
Starts a transaction


```php
public function close(): bool;
```
Closes the logger


```php
public function commit(): AdapterInterface;
```
Commits the internal transaction


```php
public function getFormatter(): FormatterInterface;
```
Returns the internal formatter


```php
public function inTransaction(): bool;
```
Returns the whether the logger is currently in an active transaction or not


```php
public function process( Item $item ): void;
```
Processes the message in the adapter


```php
public function rollback(): AdapterInterface;
```
Rollbacks the internal transaction


```php
public function setFormatter( FormatterInterface $formatter ): AdapterInterface;
```
Sets the message formatter




<h1 id="logger-adapter-noop">Class Phalcon\Logger\Adapter\Noop</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Adapter/Noop.zep)

| Namespace  | Phalcon\Logger\Adapter | | Uses       | Phalcon\Logger\Item | | Extends    | AbstractAdapter |

Class Noop

@package Phalcon\Logger\Adapter


## Methods

```php
public function close(): bool;
```
Closes the stream


```php
public function process( Item $item ): void;
```
Processes the message i.e. writes it to the file




<h1 id="logger-adapter-stream">Class Phalcon\Logger\Adapter\Stream</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Adapter/Stream.zep)

| Namespace  | Phalcon\Logger\Adapter | | Uses       | LogicException, Phalcon\Logger\Exception, Phalcon\Logger\Item | | Extends    | AbstractAdapter |

Phalcon\Logger\Adapter\Stream

Adapter to store logs in plain text files

```php
$logger = new \Phalcon\Logger\Adapter\Stream('app/logs/test.log');

$logger->log('This is a message');
$logger->log(\Phalcon\Logger::ERROR, 'This is an error');
$logger->error('This is another error');

$logger->close();
```

@property resource|null $handler @property string        $mode @property string        $name @property array         $options


## Properties
```php
/**
 * Stream handler resource
 *
 * @var resource|null
 */
protected handler;

/**
 * The file open mode. Defaults to 'ab'
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

```php
public function __construct( string $name, array $options = [] );
```
Stream constructor.


```php
public function close(): bool;
```
Closes the stream


```php
public function getName(): string
```

```php
public function process( Item $item ): void;
```
Processes the message i.e. writes it to the file


```php
protected function phpFopen( string $filename, string $mode );
```
@todo to be removed when we get traits




<h1 id="logger-adapter-syslog">Class Phalcon\Logger\Adapter\Syslog</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Adapter/Syslog.zep)

| Namespace  | Phalcon\Logger\Adapter | | Uses       | LogicException, Phalcon\Logger\Item, Phalcon\Logger\Logger | | Extends    | AbstractAdapter |

Class Syslog

@property string $defaultFormatter @property int    $facility @property string $name @property bool   $opened @property int    $option


## Properties
```php
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

```php
public function __construct( string $name, array $options = [] );
```
Syslog constructor.


```php
public function close(): bool;
```
 Closes the logger

```php
public function process( Item $item ): void;
```
Processes the message i.e. writes it to the syslog


```php
protected function openlog( string $ident, int $option, int $facility ): bool;
```
Open connection to system logger

@link https://php.net/manual/en/function.openlog.php




<h1 id="logger-adapterfactory">Class Phalcon\Logger\AdapterFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/AdapterFactory.zep)

| Namespace  | Phalcon\Logger | | Uses       | Phalcon\Factory\AbstractFactory, Phalcon\Logger\Adapter\AdapterInterface, Phalcon\Logger\Exception | | Extends    | AbstractFactory |

Factory used to create adapters used for Logging


## Methods

```php
public function __construct( array $services = [] );
```
AdapterFactory constructor.


```php
public function newInstance( string $name, string $fileName, array $options = [] ): AdapterInterface;
```
Create a new instance of the adapter


```php
protected function getExceptionClass(): string;
```

```php
protected function getServices(): array;
```
Returns the available adapters




<h1 id="logger-enum">Class Phalcon\Logger\Enum</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Enum.zep)

| Namespace  | Phalcon\Logger |

Log Level Enum constants


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


<h1 id="logger-exception">Class Phalcon\Logger\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Exception.zep)

| Namespace  | Phalcon\Logger | | Extends    | \Exception |

Phalcon\Logger\Exception

Exceptions thrown in Phalcon\Logger will use this class



<h1 id="logger-formatter-abstractformatter">Abstract Class Phalcon\Logger\Formatter\AbstractFormatter</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Formatter/AbstractFormatter.zep)

| Namespace  | Phalcon\Logger\Formatter | | Uses       | Phalcon\Logger\Item, Phalcon\Support\Helper\Str\AbstractStr | | Extends    | AbstractStr | | Implements | FormatterInterface |

Class AbstractFormatter

@property string $dateFormat


## Properties
```php
/**
 * Default date format
 *
 * @var string
 */
protected dateFormat = c;

```

## Methods

```php
public function getDateFormat(): string
```

```php
public function setDateFormat( string $dateFormat )
```

```php
protected function getFormattedDate( Item $item ): string;
```
Returns the date formatted for the logger.




<h1 id="logger-formatter-formatterinterface">Interface Phalcon\Logger\Formatter\FormatterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Formatter/FormatterInterface.zep)

| Namespace  | Phalcon\Logger\Formatter | | Uses       | Phalcon\Logger\Item |

Phalcon\Logger\FormatterInterface

This interface must be implemented by formatters in Phalcon\Logger


## Methods

```php
public function format( Item $item ): string;
```
Applies a format to an item




<h1 id="logger-formatter-json">Class Phalcon\Logger\Formatter\Json</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Formatter/Json.zep)

| Namespace  | Phalcon\Logger\Formatter | | Uses       | JsonException, Phalcon\Logger\Item | | Extends    | AbstractFormatter |

Phalcon\Logger\Formatter\Json

Formats messages using JSON encoding


## Methods

```php
public function __construct( string $dateFormat = string );
```
Json constructor.


```php
public function format( Item $item ): string;
```
Applies a format to a message before sent it to the internal log




<h1 id="logger-formatter-line">Class Phalcon\Logger\Formatter\Line</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Formatter/Line.zep)

| Namespace  | Phalcon\Logger\Formatter | | Uses       | Exception, Phalcon\Logger\Item | | Extends    | AbstractFormatter |

Class Line

@property string $format


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

```php
public function __construct( string $format = string, string $dateFormat = string );
```
Line constructor.


```php
public function format( Item $item ): string;
```
Applies a format to a message before sent it to the internal log


```php
public function getFormat(): string
```

```php
public function setFormat( string $format )
```





<h1 id="logger-item">Class Phalcon\Logger\Item</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Item.zep)

| Namespace  | Phalcon\Logger | | Uses       | DateTimeImmutable |

Phalcon\Logger\Item

Represents each item in a logging transaction

@property array             $context @property string            $message @property int               $level @property string            $levelName @property DateTimeImmutable $datetime


## Properties
```php
/**
 * @var array
 */
protected context;

/**
 * @var string
 */
protected message;

/**
 * @var int
 */
protected level;

/**
 * @var string
 */
protected levelName;

/**
 * @var DateTimeImmutable
 */
protected dateTime;

```

## Methods

```php
public function __construct( string $message, string $levelName, int $level, DateTimeImmutable $dateTime, array $context = [] );
```
Item constructor.


```php
public function getContext(): array
```

```php
public function getDateTime(): DateTimeImmutable
```

```php
public function getLevel(): int
```

```php
public function getLevelName(): string
```

```php
public function getMessage(): string
```





<h1 id="logger-logger">Class Phalcon\Logger\Logger</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Logger.zep)

| Namespace  | Phalcon\Logger | | Uses       | Exception, Phalcon\Logger\Exception | | Extends    | AbstractLogger | | Implements | LoggerInterface |

Phalcon Logger.

A logger, with various adapters and formatters. A formatter interface is available as well as an adapter one. Adapters can be created easily using the built-in AdapterFactory. A LoggerFactory is also available that allows developers to create new instances of the Logger or load them from config files (see Phalcon\Config\Config object).


## Methods

```php
public function alert( string $message, array $context = [] ): void;
```
Action must be taken immediately.

Example: Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up.


```php
public function critical( string $message, array $context = [] ): void;
```
Critical conditions.

Example: Application component unavailable, unexpected exception.


```php
public function debug( string $message, array $context = [] ): void;
```
Detailed debug information.


```php
public function emergency( string $message, array $context = [] ): void;
```
System is unusable.


```php
public function error( string $message, array $context = [] ): void;
```
Runtime errors that do not require immediate action but should typically be logged and monitored.


```php
public function info( string $message, array $context = [] ): void;
```
Interesting events.

Example: User logs in, SQL logs.


```php
public function log( mixed $level, string $message, array $context = [] ): void;
```
Logs with an arbitrary level.


```php
public function notice( string $message, array $context = [] ): void;
```
Normal but significant events.


```php
public function warning( string $message, array $context = [] ): void;
```
Exceptional occurrences that are not errors.

Example: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong.




<h1 id="logger-loggerfactory">Class Phalcon\Logger\LoggerFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/LoggerFactory.zep)

| Namespace  | Phalcon\Logger | | Uses       | DateTimeZone, Phalcon\Config\ConfigInterface, Phalcon\Factory\AbstractConfigFactory | | Extends    | AbstractConfigFactory |

Factory creating logger objects


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

```php
public function load( mixed $config ): Logger;
```
Factory to create an instance from a Config object


```php
public function newInstance( string $name, array $adapters = [], DateTimeZone $timezone = null ): Logger;
```
Returns a Logger object


```php
protected function getArrVal( array $collection, mixed $index, mixed $defaultValue = null ): mixed;
```
@todo Remove this when we get traits


```php
protected function getExceptionClass(): string;
```





<h1 id="logger-loggerinterface">Interface Phalcon\Logger\LoggerInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/LoggerInterface.zep)

| Namespace  | Phalcon\Logger | | Uses       | Phalcon\Logger\Adapter\AdapterInterface |

Interface for Phalcon based logger objects.


## Methods

```php
public function alert( string $message, array $context = [] ): void;
```
Action must be taken immediately.

Example: Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up.


```php
public function critical( string $message, array $context = [] ): void;
```
Critical conditions.

Example: Application component unavailable, unexpected exception.


```php
public function debug( string $message, array $context = [] ): void;
```
Detailed debug information.


```php
public function emergency( string $message, array $context = [] ): void;
```
System is unusable.


```php
public function error( string $message, array $context = [] ): void;
```
Runtime errors that do not require immediate action but should typically be logged and monitored.


```php
public function getAdapter( string $name ): AdapterInterface;
```
Returns an adapter from the stack


```php
public function getAdapters(): array;
```
Returns the adapter stack array


```php
public function getLogLevel(): int;
```
Returns the log level


```php
public function getName(): string;
```
Returns the name of the logger


```php
public function info( string $message, array $context = [] ): void;
```
Interesting events.

Example: User logs in, SQL logs.


```php
public function log( mixed $level, string $message, array $context = [] ): void;
```
Logs with an arbitrary level.


```php
public function notice( string $message, array $context = [] ): void;
```
Normal but significant events.


```php
public function warning( string $message, array $context = [] ): void;
```
Normal but significant events.


