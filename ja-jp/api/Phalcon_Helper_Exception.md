---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Helper\Exception'
---
# Class **Phalcon\Helper\Exception**

**extends** class [Phalcon\Exception](Phalcon_Exception) **implements** [Throwable](https://secure.php.net/manual/en/class.throwable.php)

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/helper/exception.zep)

## Properties

```php
protected string $message 
protected int    $code    
protected string $file    
protected int    $line    
```

## メソッド

**Inherited from [Throwable](https://secure.php.net/manual/en/class.throwable.php)**

```php
public __construct( 
    [ string $message = "" 
    [, int $code = 0 
    [, \Throwable $previous = null ]]] 
) : void
```

例外のコンストラクタ

* * *

```php
final public getCode() : int
```

例外コードを取得します。

* * *

```php
final public getFile() : string
```

例外が発生したファイルを取得します。

* * *

```php
final public getLine() : mixed
```

例外が発生した行を取得します。

* * *

```php
final public getMessage() : string
```

例外メッセージを取得します。

* * *

```php
final public getPrevious() : \Throwable
```

直前の例外を返します。

* * *

```php
final public getTrace() : array 
```

スタックトレースを取得します。

* * *

```php
final public getTraceAsString() : string
```

スタックトレースを文字列として取得します。

* * *

```php
final private __clone() : void
```

例外のクローンを生成します。

* * *

```php
public __toString() : string
```

例外を表す文字列

* * *

```php
public __wakeup()
```

Used to serialize the object

* * *