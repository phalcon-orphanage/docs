---
layout: default
language: 'zh-cn'
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

异常构造函数

```php
final private function __clone(): void
```

Clone the object

```php
public function __toString(): string
```

异常的字符串表示形式

```php
final public function getMessage(): string
```

获取异常消息

```php
final public function getCode(): int
```

获取异常代码

```php
final public function getFile(): string
```

获取发生异常的文件

```php
final public function getLine(): int
```

获取发生异常的行

```php
final public function getTrace(): array
```

获取堆栈跟踪

```php
final public function getPrevious(): \Throwable
```

返回前一个异常

```php
final public function getTraceAsString(): string
```

以字符串形式获取堆栈跟踪