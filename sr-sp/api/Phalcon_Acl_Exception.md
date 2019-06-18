---
layout: default
language: 'sr-sp'
version: '4.0'
title: 'Phalcon\Acl\Exception'
---

# Class [Phalcon\Acl\Exception](Phalcon_Acl_Exception)

**extends** [Phalcon\Exception](Phalcon_Exception)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/acl/exception.zep)

Exceptions thrown in `Phalcon\Acl\*` will use this class

## Methods

```php
public function getCode(): int
```

Gets the exception code

```php
public function getFile(): string
```

Gets the file in which the exception occurred

```php
public function getLine(): int
```

Gets the line on which the object was instantiated

```php
public function getMessage(): string
```

Gets the message

```php
public function getPrevious(): \Throwable
```

Get the previous `\Throwable` object

```php
public function getTrace(): array
```

Gets the stack trace

```php
public function getTraceAsString(): string
```

Gets the stack trace as a string

```php
public function __toString(): string
```

Gets a string representation of the thrown object