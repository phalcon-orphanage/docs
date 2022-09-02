---
layout: default
language: 'ko-kr'
version: '4.0'
title: 'Phalcon\DataMapper'
---

* [Phalcon\DataMapper\Pdo\Connection](#datamapper-pdo-connection)
* [Phalcon\DataMapper\Pdo\Connection\AbstractConnection](#datamapper-pdo-connection-abstractconnection)
* [Phalcon\DataMapper\Pdo\Connection\ConnectionInterface](#datamapper-pdo-connection-connectioninterface)
* [Phalcon\DataMapper\Pdo\Connection\Decorated](#datamapper-pdo-connection-decorated)
* [Phalcon\DataMapper\Pdo\Connection\PdoInterface](#datamapper-pdo-connection-pdointerface)
* [Phalcon\DataMapper\Pdo\ConnectionLocator](#datamapper-pdo-connectionlocator)
* [Phalcon\DataMapper\Pdo\ConnectionLocatorInterface](#datamapper-pdo-connectionlocatorinterface)
* [Phalcon\DataMapper\Pdo\Exception\CannotDisconnect](#datamapper-pdo-exception-cannotdisconnect)
* [Phalcon\DataMapper\Pdo\Exception\ConnectionNotFound](#datamapper-pdo-exception-connectionnotfound)
* [Phalcon\DataMapper\Pdo\Exception\Exception](#datamapper-pdo-exception-exception)
* [Phalcon\DataMapper\Pdo\Profiler\MemoryLogger](#datamapper-pdo-profiler-memorylogger)
* [Phalcon\DataMapper\Pdo\Profiler\Profiler](#datamapper-pdo-profiler-profiler)
* [Phalcon\DataMapper\Pdo\Profiler\ProfilerInterface](#datamapper-pdo-profiler-profilerinterface)
* [Phalcon\DataMapper\Query\AbstractConditions](#datamapper-query-abstractconditions)
* [Phalcon\DataMapper\Query\AbstractQuery](#datamapper-query-abstractquery)
* [Phalcon\DataMapper\Query\Bind](#datamapper-query-bind)
* [Phalcon\DataMapper\Query\Delete](#datamapper-query-delete)
* [Phalcon\DataMapper\Query\Insert](#datamapper-query-insert)
* [Phalcon\DataMapper\Query\QueryFactory](#datamapper-query-queryfactory)
* [Phalcon\DataMapper\Query\Select](#datamapper-query-select)
* [Phalcon\DataMapper\Query\Update](#datamapper-query-update)


<h1 id="datamapper-pdo-connection">Class Phalcon\DataMapper\Pdo\Connection</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Pdo/Connection.zep)

![](/assets/images/version-4.1.svg)

| Namespace  | Phalcon\DataMapper\Pdo | | Uses       | InvalidArgumentException, Phalcon\DataMapper\Pdo\Connection\AbstractConnection, Phalcon\DataMapper\Pdo\Profiler\Profiler, Phalcon\DataMapper\Pdo\Profiler\ProfilerInterface | | Extends    | AbstractConnection |

Provides array quoting, profiling, a new `perform()` method, new `fetch*()` methods

@property array             $arguments @property PDO               $pdo @property ProfilerInterface $profiler


## Properties
```php
/**
 * @var array
 */
protected arguments;

```

## Methods

```php
public function __construct( string $dsn, string $username = null, string $password = null, array $options = [], array $queries = [], ProfilerInterface $profiler = null );
```
Constructor.

This overrides the parent so that it can take connection attributes as a constructor parameter, and set them after connection.


```php
public function __debugInfo(): array;
```
The purpose of this method is to hide sensitive data from stack traces.


```php
public function connect(): void;
```
Connects to the database.


```php
public function disconnect(): void;
```
Disconnects from the database.




<h1 id="datamapper-pdo-connection-abstractconnection">Abstract Class Phalcon\DataMapper\Pdo\Connection\AbstractConnection</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Pdo/Connection/AbstractConnection.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Connection | | Uses       | BadMethodCallException, Phalcon\DataMapper\Pdo\Exception\CannotBindValue, Phalcon\DataMapper\Pdo\Profiler\ProfilerInterface | | Implements | ConnectionInterface |

Provides array quoting, profiling, a new `perform()` method, new `fetch*()` methods

@property PDO               $pdo @property ProfilerInterface $profiler


## Properties
```php
/**
 * @var PDO
 */
protected pdo;

/**
 * @var ProfilerInterface
 */
protected profiler;

```

## Methods

```php
public function __call( mixed $name, array $arguments );
```
Proxies to PDO methods created for specific drivers; in particular, `sqlite` and `pgsql`.


```php
public function beginTransaction(): bool;
```
Begins a transaction. If the profiler is enabled, the operation will be recorded.


```php
public function commit(): bool;
```
Commits the existing transaction. If the profiler is enabled, the operation will be recorded.


```php
abstract public function connect(): void;
```
Connects to the database.


```php
abstract public function disconnect(): void;
```
Disconnects from the database.


```php
public function errorCode(): string | null;
```
Gets the most recent error code.


```php
public function errorInfo(): array;
```
Gets the most recent error info.


```php
public function exec( string $statement ): int;
```
Executes an SQL statement and returns the number of affected rows. If the profiler is enabled, the operation will be recorded.


```php
public function fetchAffected( string $statement, array $values = [] ): int;
```
Performs a statement and returns the number of affected rows.


```php
public function fetchAll( string $statement, array $values = [] ): array;
```
Fetches a sequential array of rows from the database; the rows are returned as associative arrays.


```php
public function fetchAssoc( string $statement, array $values = [] ): array;
```
Fetches an associative array of rows from the database; the rows are returned as associative arrays, and the array of rows is keyed on the first column of each row.

If multiple rows have the same first column value, the last row with that value will overwrite earlier rows. This method is more resource intensive and should be avoided if possible.


```php
public function fetchColumn( string $statement, array $values = [], int $column = int ): array;
```
Fetches a column of rows as a sequential array (default first one).


```php
public function fetchGroup( string $statement, array $values = [], int $flags = static-constant-access ): array;
```
Fetches multiple from the database as an associative array. The first column will be the index key. The default flags are PDO::FETCH_ASSOC | PDO::FETCH_GROUP


```php
public function fetchObject( string $statement, array $values = [], string $className = string, array $arguments = [] ): object;
```
Fetches one row from the database as an object where the column values are mapped to object properties.

Since PDO injects property values before invoking the constructor, any initializations for defaults that you potentially have in your object's constructor, will override the values that have been injected by `fetchObject`. The default object returned is `\stdClass`


```php
public function fetchObjects( string $statement, array $values = [], string $className = string, array $arguments = [] ): array;
```
Fetches a sequential array of rows from the database; the rows are returned as objects where the column values are mapped to object properties.

Since PDO injects property values before invoking the constructor, any initializations for defaults that you potentially have in your object's constructor, will override the values that have been injected by `fetchObject`. The default object returned is `\stdClass`


```php
public function fetchOne( string $statement, array $values = [] ): array;
```
Fetches one row from the database as an associative array.


```php
public function fetchPairs( string $statement, array $values = [] ): array;
```
Fetches an associative array of rows as key-value pairs (first column is the key, second column is the value).


```php
public function fetchValue( string $statement, array $values = [] );
```
Fetches the very first value (i.e., first column of the first row).


```php
public function getAdapter(): \PDO;
```
Return the inner PDO (if any)


```php
public function getAttribute( int $attribute ): mixed;
```
Retrieve a database connection attribute


```php
public static function getAvailableDrivers(): array;
```
Return an array of available PDO drivers (empty array if none available)


```php
public function getDriverName(): string;
```
Return the driver name


```php
public function getProfiler(): ProfilerInterface;
```
Returns the Profiler instance.


```php
public function getQuoteNames( string $driver = string ): array;
```
Gets the quote parameters based on the driver


```php
public function inTransaction(): bool;
```
Is a transaction currently active? If the profiler is enabled, the operation will be recorded. If the profiler is enabled, the operation will be recorded.


```php
public function isConnected(): bool;
```
Is the PDO connection active?


```php
public function lastInsertId( string $name = null ): string;
```
Returns the last inserted autoincrement sequence value. If the profiler is enabled, the operation will be recorded.


```php
public function perform( string $statement, array $values = [] ): \PDOStatement;
```
Performs a query with bound values and returns the resulting PDOStatement; array values will be passed through `quote()` and their respective placeholders will be replaced in the query string. If the profiler is enabled, the operation will be recorded.


```php
public function prepare( string $statement, array $options = [] ): \PDOStatement | bool;
```
Prepares an SQL statement for execution.


```php
public function query( string $statement ): \PDOStatement | bool;
```
Queries the database and returns a PDOStatement. If the profiler is enabled, the operation will be recorded.


```php
public function quote( mixed $value, int $type = static-constant-access ): string;
```
Quotes a value for use in an SQL statement. This differs from `PDO::quote()` in that it will convert an array into a string of comma-separated quoted values. The default type is `PDO::PARAM_STR`


```php
public function rollBack(): bool;
```
Rolls back the current transaction, and restores autocommit mode. If the profiler is enabled, the operation will be recorded.


```php
public function setAttribute( int $attribute, mixed $value ): bool;
```
Set a database connection attribute


```php
public function setProfiler( ProfilerInterface $profiler );
```
Sets the Profiler instance.


```php
protected function fetchData( string $method, array $arguments, string $statement, array $values = [] ): array;
```
Helper method to get data from PDO based on the method passed


```php
protected function performBind( \PDOStatement $statement, mixed $name, mixed $arguments ): void;
```
Bind a value using the proper PDO::PARAM_* type.




<h1 id="datamapper-pdo-connection-connectioninterface">Interface Phalcon\DataMapper\Pdo\Connection\ConnectionInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Pdo/Connection/ConnectionInterface.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Connection | | Uses       | Phalcon\DataMapper\Pdo\Exception\CannotBindValue, Phalcon\DataMapper\Pdo\Parser\ParserInterface, Phalcon\DataMapper\Pdo\Profiler\ProfilerInterface | | Extends    | PdoInterface |

Provides array quoting, profiling, a new `perform()` method, new `fetch*()` methods

@property array             $args @property PDO               $pdo @property ProfilerInterface $profiler @property array             $quote


## Methods

```php
public function connect(): void;
```
Connects to the database.


```php
public function disconnect(): void;
```
Disconnects from the database.


```php
public function fetchAffected( string $statement, array $values = [] ): int;
```
Performs a statement and returns the number of affected rows.


```php
public function fetchAll( string $statement, array $values = [] ): array;
```
Fetches a sequential array of rows from the database; the rows are returned as associative arrays.


```php
public function fetchAssoc( string $statement, array $values = [] ): array;
```
Fetches an associative array of rows from the database; the rows are returned as associative arrays, and the array of rows is keyed on the first column of each row.

If multiple rows have the same first column value, the last row with that value will overwrite earlier rows. This method is more resource intensive and should be avoided if possible.


```php
public function fetchColumn( string $statement, array $values = [], int $column = int ): array;
```
Fetches a column of rows as a sequential array (default first one).


```php
public function fetchGroup( string $statement, array $values = [], int $flags = static-constant-access ): array;
```
Fetches multiple from the database as an associative array. The first column will be the index key. The default flags are PDO::FETCH_ASSOC | PDO::FETCH_GROUP


```php
public function fetchObject( string $statement, array $values = [], string $className = string, array $arguments = [] ): object;
```
Fetches one row from the database as an object where the column values are mapped to object properties.

Since PDO injects property values before invoking the constructor, any initializations for defaults that you potentially have in your object's constructor, will override the values that have been injected by `fetchObject`. The default object returned is `\stdClass`


```php
public function fetchObjects( string $statement, array $values = [], string $className = string, array $arguments = [] ): array;
```
Fetches a sequential array of rows from the database; the rows are returned as objects where the column values are mapped to object properties.

Since PDO injects property values before invoking the constructor, any initializations for defaults that you potentially have in your object's constructor, will override the values that have been injected by `fetchObject`. The default object returned is `\stdClass`


```php
public function fetchOne( string $statement, array $values = [] ): array;
```
Fetches one row from the database as an associative array.


```php
public function fetchPairs( string $statement, array $values = [] ): array;
```
Fetches an associative array of rows as key-value pairs (first column is the key, second column is the value).


```php
public function fetchValue( string $statement, array $values = [] ): mixed;
```
Fetches the very first value (i.e., first column of the first row).


```php
public function getAdapter(): \PDO;
```
Return the inner PDO (if any)


```php
public function getProfiler(): ProfilerInterface;
```
Returns the Profiler instance.


```php
public function isConnected(): bool;
```
Is the PDO connection active?


```php
public function perform( string $statement, array $values = [] ): \PDOStatement;
```
Performs a query with bound values and returns the resulting PDOStatement; array values will be passed through `quote()` and their respective placeholders will be replaced in the query string. If the profiler is enabled, the operation will be recorded.


```php
public function setProfiler( ProfilerInterface $profiler );
```
Sets the Profiler instance.




<h1 id="datamapper-pdo-connection-decorated">Class Phalcon\DataMapper\Pdo\Connection\Decorated</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Pdo/Connection/Decorated.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Connection | | Uses       | Phalcon\DataMapper\Pdo\Exception\CannotDisconnect, Phalcon\DataMapper\Pdo\Profiler\Profiler, Phalcon\DataMapper\Pdo\Profiler\ProfilerInterface | | Extends    | AbstractConnection |

Decorates an existing PDO instance with the extended methods.


## Methods

```php
public function __construct( \PDO $pdo, ProfilerInterface $profiler = null );
```
Constructor.

This overrides the parent so that it can take an existing PDO instance and decorate it with the extended methods.


```php
public function connect(): void;
```
Connects to the database.


```php
public function disconnect(): void;
```
Disconnects from the database; disallowed with decorated PDO connections.

@throws CannotDisconnect




<h1 id="datamapper-pdo-connection-pdointerface">Interface Phalcon\DataMapper\Pdo\Connection\PdoInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Pdo/Connection/PdoInterface.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Connection |

An interface to the native PDO object.


## Methods

```php
public function beginTransaction(): bool;
```
Begins a transaction. If the profiler is enabled, the operation will be recorded.


```php
public function commit(): bool;
```
Commits the existing transaction. If the profiler is enabled, the operation will be recorded.


```php
public function errorCode(): null | string;
```
Gets the most recent error code.


```php
public function errorInfo(): array;
```
Gets the most recent error info.


```php
public function exec( string $statement ): int;
```
Executes an SQL statement and returns the number of affected rows. If the profiler is enabled, the operation will be recorded.


```php
public function getAttribute( int $attribute ): mixed;
```
Retrieve a database connection attribute


```php
public static function getAvailableDrivers(): array;
```
Return an array of available PDO drivers (empty array if none available)


```php
public function inTransaction(): bool;
```
Is a transaction currently active? If the profiler is enabled, the operation will be recorded. If the profiler is enabled, the operation will be recorded.


```php
public function lastInsertId( string $name = null ): string;
```
Returns the last inserted autoincrement sequence value. If the profiler is enabled, the operation will be recorded.


```php
public function prepare( string $statement, array $options = [] ): \PDOStatement | bool;
```
Prepares an SQL statement for execution.


```php
public function query( string $statement ): \PDOStatement | bool;
```
Queries the database and returns a PDOStatement. If the profiler is enabled, the operation will be recorded.


```php
public function quote( mixed $value, int $type = static-constant-access ): string;
```
Quotes a value for use in an SQL statement. This differs from `PDO::quote()` in that it will convert an array into a string of comma-separated quoted values. The default type is `PDO::PARAM_STR`


```php
public function rollBack(): bool;
```
Rolls back the current transaction, and restores autocommit mode. If the profiler is enabled, the operation will be recorded.


```php
public function setAttribute( int $attribute, mixed $value ): bool;
```
Set a database connection attribute




<h1 id="datamapper-pdo-connectionlocator">Class Phalcon\DataMapper\Pdo\ConnectionLocator</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Pdo/ConnectionLocator.zep)

| Namespace  | Phalcon\DataMapper\Pdo | | Uses       | Phalcon\DataMapper\Pdo\Connection\ConnectionInterface, Phalcon\DataMapper\Pdo\Exception\ConnectionNotFound | | Implements | ConnectionLocatorInterface |

Manages Connection instances for default, read, and write connections.

@property callable $master @property array    $read @property array    $write


## Properties
```php
/**
 * A default Connection connection factory/instance.
 *
 * @var ConnectionInterface
 */
protected master;

/**
 * A registry of Connection "read" factories/instances.
 *
 * @var array
 */
protected read;

/**
 * A registry of Connection "write" factories/instances.
 *
 * @var array
 */
protected write;

/**
 * A collection of resolved instances
 *
 * @var array
 */
private instances;

```

## Methods

```php
public function __construct( ConnectionInterface $master, array $read = [], array $write = [] );
```
Constructor.


```php
public function getMaster(): ConnectionInterface;
```
Returns the default connection object.


```php
public function getRead( string $name = string ): ConnectionInterface;
```
Returns a read connection by name; if no name is given, picks a random connection; if no read connections are present, returns the default connection.


```php
public function getWrite( string $name = string ): ConnectionInterface;
```
Returns a write connection by name; if no name is given, picks a random connection; if no write connections are present, returns the default connection.


```php
public function setMaster( ConnectionInterface $callableObject ): ConnectionLocatorInterface;
```
Sets the default connection factory.


```php
public function setRead( string $name, callable $callableObject ): ConnectionLocatorInterface;
```
Sets a read connection factory by name.


```php
public function setWrite( string $name, callable $callableObject ): ConnectionLocatorInterface;
```
Sets a write connection factory by name.


```php
protected function getConnection( string $type, string $name = string ): ConnectionInterface;
```
Returns a connection by name.




<h1 id="datamapper-pdo-connectionlocatorinterface">Interface Phalcon\DataMapper\Pdo\ConnectionLocatorInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Pdo/ConnectionLocatorInterface.zep)

| Namespace  | Phalcon\DataMapper\Pdo | | Uses       | Phalcon\DataMapper\Pdo\Connection\ConnectionInterface |

Locates PDO connections for default, read, and write databases.


## Methods

```php
public function getMaster(): ConnectionInterface;
```
Returns the default connection object.


```php
public function getRead( string $name = string ): ConnectionInterface;
```
Returns a read connection by name; if no name is given, picks a random connection; if no read connections are present, returns the default connection.


```php
public function getWrite( string $name = string ): ConnectionInterface;
```
Returns a write connection by name; if no name is given, picks a random connection; if no write connections are present, returns the default connection.


```php
public function setMaster( ConnectionInterface $callableObject ): ConnectionLocatorInterface;
```
Sets the default connection registry entry.


```php
public function setRead( string $name, callable $callableObject ): ConnectionLocatorInterface;
```
Sets a read connection registry entry by name.


```php
public function setWrite( string $name, callable $callableObject ): ConnectionLocatorInterface;
```
Sets a write connection registry entry by name.




<h1 id="datamapper-pdo-exception-cannotdisconnect">Class Phalcon\DataMapper\Pdo\Exception\CannotDisconnect</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Pdo/Exception/CannotDisconnect.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Exception | | Extends    | Exception |

ExtendedPdo could not disconnect; e.g., because its PDO connection was created externally and then injected.



<h1 id="datamapper-pdo-exception-connectionnotfound">Class Phalcon\DataMapper\Pdo\Exception\ConnectionNotFound</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Pdo/Exception/ConnectionNotFound.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Exception | | Extends    | Exception |

Locator could not find a named connection.



<h1 id="datamapper-pdo-exception-exception">Class Phalcon\DataMapper\Pdo\Exception\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Pdo/Exception/Exception.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Exception | | Extends    | \Exception |

Base Exception class



<h1 id="datamapper-pdo-profiler-memorylogger">Class Phalcon\DataMapper\Pdo\Profiler\MemoryLogger</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Pdo/Profiler/MemoryLogger.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Profiler | | Uses       | Psr\Log\AbstractLogger | | Extends    | AbstractLogger |

A naive memory-based logger.

@property array $messages


## Properties
```php
/**
 * @var array
 */
protected messages;

```

## Methods

```php
public function getMessages();
```
Returns the logged messages.


```php
public function log( mixed $level, mixed $message, array $context = [] );
```
Logs a message.




<h1 id="datamapper-pdo-profiler-profiler">Class Phalcon\DataMapper\Pdo\Profiler\Profiler</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Pdo/Profiler/Profiler.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Profiler | | Uses       | Phalcon\DataMapper\Pdo\Exception\Exception, Phalcon\Helper\Json, Psr\Log\LoggerInterface, Psr\Log\LogLevel | | Implements | ProfilerInterface |

Sends query profiles to a logger.

@property bool            $active @property array           $context @property string          $logFormat @property string          $logLevel @property LoggerInterface $logger


## Properties
```php
/**
 * @var bool
 */
protected active = false;

/**
 * @var array
 */
protected context;

/**
 * @var string
 */
protected logFormat = ;

/**
 * @var int
 */
protected logLevel = 0;

/**
 * @var LoggerInterface
 */
protected logger;

```

## Methods

```php
public function __construct( LoggerInterface $logger = null );
```
Constructor.


```php
public function finish( string $statement = null, array $values = [] ): void;
```
Finishes and logs a profile entry.


```php
public function getLogFormat(): string;
```
Returns the log message format string, with placeholders.


```php
public function getLogLevel(): string;
```
Returns the level at which to log profile messages.


```php
public function getLogger(): LoggerInterface;
```
Returns the underlying logger instance.


```php
public function isActive(): bool;
```
Returns true if logging is active.


```php
public function setActive( bool $active ): ProfilerInterface;
```
Enable or disable profiler logging.


```php
public function setLogFormat( string $logFormat ): ProfilerInterface;
```
Sets the log message format string, with placeholders.


```php
public function setLogLevel( string $logLevel ): ProfilerInterface;
```
Level at which to log profile messages.


```php
public function start( string $method ): void;
```
Starts a profile entry.




<h1 id="datamapper-pdo-profiler-profilerinterface">Interface Phalcon\DataMapper\Pdo\Profiler\ProfilerInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Pdo/Profiler/ProfilerInterface.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Profiler | | Uses       | Psr\Log\LoggerInterface |

Interface to send query profiles to a logger.


## Methods

```php
public function finish( string $statement = null, array $values = [] ): void;
```
Finishes and logs a profile entry.


```php
public function getLogFormat(): string;
```
Returns the log message format string, with placeholders.


```php
public function getLogLevel(): string;
```
Returns the level at which to log profile messages.


```php
public function getLogger(): LoggerInterface;
```
Returns the underlying logger instance.


```php
public function isActive(): bool;
```
Returns true if logging is active.


```php
public function setActive( bool $active ): ProfilerInterface;
```
Enable or disable profiler logging.


```php
public function setLogFormat( string $logFormat ): ProfilerInterface;
```
Sets the log message format string, with placeholders.


```php
public function setLogLevel( string $logLevel ): ProfilerInterface;
```
Level at which to log profile messages.


```php
public function start( string $method ): void;
```
Starts a profile entry.




<h1 id="datamapper-query-abstractconditions">Abstract Class Phalcon\DataMapper\Query\AbstractConditions</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Query/AbstractConditions.zep)

| Namespace  | Phalcon\DataMapper\Query | | Uses       | Phalcon\Helper\Arr | | Extends    | AbstractQuery |

Class AbstractConditions


## Methods

```php
public function andWhere( string $condition, mixed $value = null, int $type = int ): AbstractConditions;
```
Sets a `AND` for a `WHERE` condition


```php
public function appendWhere( string $condition, mixed $value = null, int $type = int ): AbstractConditions;
```
Concatenates to the most recent `WHERE` clause


```php
public function limit( int $limit ): AbstractConditions;
```
Sets the `LIMIT` clause


```php
public function offset( int $offset ): AbstractConditions;
```
Sets the `OFFSET` clause


```php
public function orWhere( string $condition, mixed $value = null, int $type = int ): AbstractConditions;
```
Sets a `OR` for a `WHERE` condition


```php
public function orderBy( mixed $orderBy ): AbstractConditions;
```
Sets the `ORDER BY`


```php
public function where( string $condition, mixed $value = null, int $type = int ): AbstractConditions;
```
Sets a `WHERE` condition


```php
public function whereEquals( array $columnsValues ): AbstractConditions;
```

```php
protected function addCondition( string $store, string $andor, string $condition, mixed $value = null, int $type = int ): void;
```
Appends a conditional


```php
protected function appendCondition( string $store, string $condition, mixed $value = null, int $type = int ): void;
```
Concatenates a conditional


```php
protected function buildBy( string $type ): string;
```
Builds a `BY` list


```php
protected function buildCondition( string $type ): string;
```
Builds the conditional string


```php
protected function buildLimit(): string;
```
Builds the `LIMIT` clause


```php
protected function buildLimitCommon(): string;
```
Builds the `LIMIT` clause for all drivers


```php
protected function buildLimitEarly(): string;
```
Builds the early `LIMIT` clause - MS SQLServer


```php
protected function buildLimitSqlsrv(): string;
```
Builds the `LIMIT` clause for MSSQLServer


```php
protected function processValue( string $store, mixed $data ): void;
```
Processes a value (array or string) and merges it with the store




<h1 id="datamapper-query-abstractquery">Abstract Class Phalcon\DataMapper\Query\AbstractQuery</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Query/AbstractQuery.zep)

| Namespace  | Phalcon\DataMapper\Query | | Uses       | Phalcon\DataMapper\Pdo\Connection |

Class AbstractQuery

@property Bind       $bind @property Connection $connection @property array      $store


## Properties
```php
/**
 * @var Bind
 */
protected bind;

/**
 * @var Connection
 */
protected connection;

/**
 * @var array
 */
protected store;

```

## Methods

```php
public function __construct( Connection $connection, Bind $bind );
```
AbstractQuery constructor.


```php
public function bindInline( mixed $value, int $type = int ): string;
```
Binds a value inline


```php
public function bindValue( string $key, mixed $value, int $type = int ): AbstractQuery;
```
Binds a value - auto-detects the type if necessary


```php
public function bindValues( array $values ): AbstractQuery;
```
Binds an array of values


```php
public function getBindValues(): array;
```
Returns all the bound values


```php
abstract public function getStatement(): string;
```
Return the generated statement


```php
public function perform();
```
Performs a statement in the connection


```php
public function quoteIdentifier( string $name, int $type = static-constant-access ): string;
```
Quotes the identifier


```php
public function reset();
```
Resets the internal array


```php
public function setFlag( string $flag, bool $enable = bool ): void;
```
Sets a flag for the query such as "DISTINCT"


```php
protected function buildFlags();
```
Builds the flags statement(s)


```php
protected function buildReturning(): string;
```
Builds the `RETURNING` clause


```php
protected function indent( array $collection, string $glue = string ): string;
```
Indents a collection




<h1 id="datamapper-query-bind">Class Phalcon\DataMapper\Query\Bind</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Query/Bind.zep)

| Namespace  | Phalcon\DataMapper\Query |

Class Bind

@property int   $inlineCount @property array $store


## Properties
```php
/**
 * @var int
 */
protected inlineCount = 0;

/**
 * @var array
 */
protected store;

```

## Methods

```php
public function bindInline( mixed $value, int $type = int ): string;
```

```php
public function remove( string $key ): void;
```
Removes a value from the store


```php
public function setValue( string $key, mixed $value, int $type = int ): void;
```
Sets a value


```php
public function setValues( array $values, int $type = int ): void;
```
Sets values from an array


```php
public function toArray(): array;
```
Returns the internal collection


```php
protected function getType( mixed $value ): int;
```
Auto detects the PDO type


```php
protected function inlineArray( array $data, int $type ): string;
```
Processes an array - if passed as an `inline` parameter




<h1 id="datamapper-query-delete">Class Phalcon\DataMapper\Query\Delete</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Query/Delete.zep)

| Namespace  | Phalcon\DataMapper\Query | | Uses       | Phalcon\DataMapper\Pdo\Connection | | Extends    | AbstractConditions |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

Implementation of this file has been influenced by AtlasPHP

@link    https://github.com/atlasphp/Atlas.Query @license https://github.com/atlasphp/Atlas.Qyert/blob/1.x/LICENSE.md


## Methods

```php
public function __construct( Connection $connection, Bind $bind );
```
Delete constructor.


```php
public function from( string $table ): Delete;
```
Adds table(s) in the query


```php
public function getStatement(): string;
```

```php
public function reset(): void;
```
Resets the internal store


```php
public function returning( array $columns ): Delete;
```
Adds the `RETURNING` clause




<h1 id="datamapper-query-insert">Class Phalcon\DataMapper\Query\Insert</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Query/Insert.zep)

| Namespace  | Phalcon\DataMapper\Query | | Uses       | Phalcon\DataMapper\Pdo\Connection | | Extends    | AbstractQuery |

Class Insert


## Methods

```php
public function __construct( Connection $connection, Bind $bind );
```
Insert constructor.


```php
public function column( string $column, mixed $value = null, int $type = int ): Insert;
```
Sets a column for the `INSERT` query


```php
public function columns( array $columns ): Insert;
```
Mass sets columns and values for the `INSERT`


```php
public function getLastInsertId( string $name = null ): string;
```
Returns the id of the last inserted record


```php
public function getStatement(): string;
```

```php
public function into( string $table ): Insert;
```
Adds table(s) in the query


```php
public function reset(): void;
```
Resets the internal store


```php
public function returning( array $columns ): Insert;
```
Adds the `RETURNING` clause


```php
public function set( string $column, mixed $value = null ): Insert;
```
Sets a column = value condition




<h1 id="datamapper-query-queryfactory">Class Phalcon\DataMapper\Query\QueryFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Query/QueryFactory.zep)

| Namespace  | Phalcon\DataMapper\Query | | Uses       | Phalcon\DataMapper\Pdo\Connection |

Class QueryFactory

@property string $class


## Properties
```php
/**
 * @var string
 */
protected selectClass = ;

```

## Methods

```php
public function __construct( string $selectClass = string );
```
QueryFactory constructor.


```php
public function newBind(): Bind;
```
Create a new Bind object


```php
public function newDelete( Connection $connection ): Delete;
```
Create a new Delete object


```php
public function newInsert( Connection $connection ): Insert;
```
Create a new Insert object


```php
public function newSelect( Connection $connection ): Select;
```
Create a new Select object


```php
public function newUpdate( Connection $connection ): Update;
```
Create a new Update object




<h1 id="datamapper-query-select">Class Phalcon\DataMapper\Query\Select</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Query/Select.zep)

| Namespace  | Phalcon\DataMapper\Query | | Uses       | BadMethodCallException, Phalcon\Helper\Arr | | Extends    | AbstractConditions |

Class Select

@property string $asAlias @property bool   $forUpdate

@method int    fetchAffected() @method array  fetchAll() @method array  fetchAssoc() @method array  fetchColumn(int $column = 0) @method array  fetchGroup(int $flags = PDO::FETCH_ASSOC) @method object fetchObject(string $class = 'stdClass', array $arguments = []) @method array  fetchObjects(string $class = 'stdClass', array $arguments = []) @method array  fetchOne() @method array  fetchPairs() @method mixed  fetchValue()


## Constants
```php
const JOIN_INNER = INNER;
const JOIN_LEFT = LEFT;
const JOIN_NATURAL = NATURAL;
const JOIN_RIGHT = RIGHT;
```

## Properties
```php
/**
 * @var string
 */
protected asAlias = ;

/**
 * @var bool
 */
protected forUpdate = false;

```

## Methods

```php
public function __call( string $method, array $params );
```
Proxied methods to the connection


```php
public function andHaving( string $condition, mixed $value = null, int $type = int ): Select;
```
Sets a `AND` for a `HAVING` condition


```php
public function appendHaving( string $condition, mixed $value = null, int $type = int ): Select;
```
Concatenates to the most recent `HAVING` clause


```php
public function appendJoin( string $condition, mixed $value = null, int $type = int ): Select;
```
Concatenates to the most recent `JOIN` clause


```php
public function asAlias( string $asAlias ): Select;
```
The `AS` statement for the query - useful in sub-queries


```php
public function columns(): Select;
```
The columns to select from. If a key is set in an array element, the key will be used as the alias


```php
public function distinct( bool $enable = bool ): Select;
```

```php
public function forUpdate( bool $enable = bool ): Select;
```
Enable the `FOR UPDATE` for the query


```php
public function from( string $table ): Select;
```
Adds table(s) in the query


```php
public function getStatement(): string;
```
Returns the compiled SQL statement


```php
public function groupBy( mixed $groupBy ): Select;
```
Sets the `GROUP BY`


```php
public function hasColumns(): bool;
```
Whether the query has columns or not


```php
public function having( string $condition, mixed $value = null, int $type = int ): Select;
```
Sets a `HAVING` condition


```php
public function join( string $join, string $table, string $condition, mixed $value = null, int $type = int ): Select;
```
Sets a 'JOIN' condition


```php
public function orHaving( string $condition, mixed $value = null, int $type = int ): Select;
```
Sets a `OR` for a `HAVING` condition


```php
public function reset(): Select;
```
Resets the internal collections


```php
public function subSelect(): Select;
```
Start a sub-select


```php
public function union(): Select;
```
Start a `UNION`


```php
public function unionAll(): Select;
```
Start a `UNION ALL`


```php
protected function getCurrentStatement( string $suffix = string ): string;
```
Statement builder




<h1 id="datamapper-query-update">Class Phalcon\DataMapper\Query\Update</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/DataMapper/Query/Update.zep)

| Namespace  | Phalcon\DataMapper\Query | | Uses       | Phalcon\DataMapper\Pdo\Connection | | Extends    | AbstractConditions |

Class Update


## Methods

```php
public function __construct( Connection $connection, Bind $bind );
```
Update constructor.


```php
public function column( string $column, mixed $value = null, int $type = int ): Update;
```
Sets a column for the `UPDATE` query


```php
public function columns( array $columns ): Update;
```
Mass sets columns and values for the `UPDATE`


```php
public function from( string $table ): Update;
```
Adds table(s) in the query


```php
public function getStatement(): string;
```

```php
public function hasColumns(): bool;
```
Whether the query has columns or not


```php
public function reset(): void;
```
Resets the internal store


```php
public function returning( array $columns ): Update;
```
Adds the `RETURNING` clause


```php
public function set( string $column, mixed $value = null ): Update;
```
Sets a column = value condition
