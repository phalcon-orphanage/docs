---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Filter\Exception'
---
# Class [Phalcon\Filter\Exception](Phalcon_Filter_Exception)

**extends** [Phalcon\Exception](Phalcon_Exception)

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/exception.zep)

Exceptions thrown in `Phalcon\Filter\*` will use this class

## روش ها

```php
public function getCode(): int
```

Gets the exception code

```php
public function getFile(): string
```

می دهد فایل که در آن استثنا اتفاق افتاده است

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