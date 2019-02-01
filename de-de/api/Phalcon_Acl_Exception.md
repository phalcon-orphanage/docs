---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Acl\Exception'
---
# Class [Phalcon\Acl\Exception](Phalcon_Acl_Exception)

**extends** [Phalcon\Exception](Phalcon_Exception)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/acl/exception.zep)

Exceptions thrown in `Phalcon\Acl\*` will use this class

## Methoden

```php
public function getCode(): int
```

Gets the exception code

```php
public function getFile(): string
```

Liefert die Datei, in der die Ausnahme aufgetreten ist

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

Gibt den Stack-trace zurück

```php
public function getTraceAsString(): string
```

Gibt den Stack-trace als Zeichenfolge zurück

```php
public function __toString(): string
```

Gets a string representation of the thrown object