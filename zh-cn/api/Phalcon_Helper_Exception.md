---
layout: default
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Helper\Exception'
---
# Class **Phalcon\Helper\Exception**

**extends** class [Phalcon\Exception](Phalcon_Exception) **implements** [Throwable](https://secure.php.net/manual/en/class.throwable.php)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/helper/exception.zep)

## Properties

```php
protected string $message 
protected int    $code    
protected string $file    
protected int    $line    
```

## 方法

**Inherited from [Throwable](https://secure.php.net/manual/en/class.throwable.php)**

```php
public __construct( 
    [ string $message = "" 
    [, int $code = 0 
    [, \Throwable $previous = null ]]] 
) : void
```

异常构造函数

* * *

```php
final public getCode() : int
```

获取异常代码

* * *

```php
final public getFile() : string
```

获取发生异常的文件

* * *

```php
final public getLine() : mixed
```

获取发生异常的行

* * *

```php
final public getMessage() : string
```

获取异常消息

* * *

```php
final public getPrevious() : \Throwable
```

返回前一个异常

* * *

```php
final public getTrace() : array 
```

获取堆栈跟踪

* * *

```php
final public getTraceAsString() : string
```

以字符串形式获取堆栈跟踪

* * *

```php
final private __clone() : void
```

Clone the exception

* * *

```php
public __toString() : string
```

异常的字符串表示形式

* * *

```php
public __wakeup()
```

Used to serialize the object

* * *