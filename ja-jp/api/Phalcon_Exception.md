---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Exception'
---

<a name="Phalcon_Exception"></a>

# Class **Phalcon\Exception**

*extends* class [Exception](https://php.net/manual/en/class.exception.php)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/exception.zep)

## メソッド

```php
public function __construct( [string $message = "" [, int $code = 0 [, \Throwable $previous = NULL ]]] )
```

例外のコンストラクタ

```php
final private function __clone(): void
```

Clone the object

```php
public function __toString(): string
```

例外を表す文字列

```php
final public function getMessage(): string
```

例外メッセージを取得します。

```php
final public function getCode(): int
```

例外コードを取得します。

```php
final public function getFile(): string
```

例外が発生したファイルを取得します。

```php
final public function getLine(): int
```

例外が発生した行を取得します。

```php
final public function getTrace(): array
```

スタックトレースを取得します。

```php
final public function getPrevious(): \Throwable
```

直前の例外を返します。

```php
final public function getTraceAsString(): string
```

スタックトレースを文字列として取得します。