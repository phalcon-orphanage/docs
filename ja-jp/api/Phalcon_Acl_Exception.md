---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Acl\Exception'
---
# Class [Phalcon\Acl\Exception](Phalcon_Acl_Exception)

**extends** [Phalcon\Exception](Phalcon_Exception)

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/acl/exception.zep)

Exceptions thrown in `Phalcon\Acl\*` will use this class

## メソッド

```php
public function getCode(): int
```

Gets the exception code

```php
public function getFile(): string
```

例外が発生したファイルを取得します。

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

スタックトレースを取得します。

```php
public function getTraceAsString(): string
```

スタックトレースを文字列として取得します。

```php
public function __toString(): string
```

Gets a string representation of the thrown object