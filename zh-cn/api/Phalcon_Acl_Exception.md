---
layout: default
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Acl\Exception'
---
# Class [Phalcon\Acl\Exception](Phalcon_Acl_Exception)

**extends** [Phalcon\Exception](Phalcon_Exception)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/acl/exception.zep)

Exceptions thrown in `Phalcon\Acl\*` will use this class

## 方法

```php
public function getCode(): int
```

Gets the exception code

```php
public function getFile(): string
```

获取发生异常的文件

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

获取堆栈跟踪

```php
public function getTraceAsString(): string
```

以字符串形式获取堆栈跟踪

```php
public function __toString(): string
```

Gets a string representation of the thrown object