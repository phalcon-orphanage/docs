---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Acl\Exception'
---
# Class [Phalcon\Acl\Exception](Phalcon_Acl_Exception)

**extends** [Phalcon\Exception](Phalcon_Exception)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/acl/exception.zep)

Exceptions thrown in `Phalcon\Acl\*` will use this class

## Metodlar

```php
public function getCode(): int
```

Gets the exception code

```php
public function getFile(): string
```

İstisnanın oluştuğu dosyayı alır

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

Yığın izni alır

```php
public function getTraceAsString(): string
```

Bir dize olarak yığın izni alır

```php
public function __toString(): string
```

Gets a string representation of the thrown object