---
layout: article
language: 'it-it'
version: '4.0'
title: 'Phalcon\Acl\Exception'
---
# Class [Phalcon\Acl\Exception](Phalcon_Acl_Exception)

**extends** [Phalcon\Exception](Phalcon_Exception)

[Sorgente su GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/acl/exception.zep)

Exceptions thrown in `Phalcon\Acl\*` will use this class

## Metodi

```php
public function getCode(): int
```

Gets the exception code

```php
public function getFile(): string
```

Ottiene il file in cui si è verificata l'eccezione

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

Ottiene la traccia dello stack

```php
public function getTraceAsString(): string
```

Ottiene la traccia dello stack come stringa

```php
public function __toString(): string
```

Gets a string representation of the thrown object