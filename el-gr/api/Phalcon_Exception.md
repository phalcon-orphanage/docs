---
layout: default
language: 'el-gr'
version: '4.0'
title: 'Phalcon\Exception'
---

<a name="Phalcon_Exception"></a>

# Class **Phalcon\Exception**

*extends* class [Exception](https://php.net/manual/en/class.exception.php)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/exception.zep)

## Methods

```php
public function __construct( [string $message = "" [, int $code = 0 [, \Throwable $previous = NULL ]]] )
```

Exception constructor

```php
final private function __clone(): void
```

Clone the object

```php
public function __toString(): string
```

String representation of the exception

```php
final public function getMessage(): string
```

Gets the Exception message

```php
final public function getCode(): int
```

Gets the Exception code

```php
final public function getFile(): string
```

Gets the file in which the exception occurred

```php
final public function getLine(): int
```

Gets the line in which the exception occurred

```php
final public function getTrace(): array
```

Gets the stack trace

```php
final public function getPrevious(): \Throwable
```

Returns previous Exception

```php
final public function getTraceAsString(): string
```

Gets the stack trace as a string