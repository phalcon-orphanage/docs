---
layout: default
language: 'sr-sp'
version: '4.0'
title: 'Phalcon\Helper\Exception'
---

# Class **Phalcon\Helper\Exception**

**extends** class [Phalcon\Exception](Phalcon_Exception) **implements** [Throwable](https://secure.php.net/manual/en/class.throwable.php)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/helper/exception.zep)

## Properties

```php
protected string $message 
protected int    $code    
protected string $file    
protected int    $line    
```

## Methods

**Inherited from [Throwable](https://secure.php.net/manual/en/class.throwable.php)**

```php
public __construct( 
    [ string $message = "" 
    [, int $code = 0 
    [, \Throwable $previous = null ]]] 
) : void
```

Exception constructor

* * *

```php
final public getCode() : int
```

Gets the Exception code

* * *

```php
final public getFile() : string
```

Gets the file in which the exception occurred

* * *

```php
final public getLine() : mixed
```

Gets the line in which the exception occurred

* * *

```php
final public getMessage() : string
```

Gets the Exception message

* * *

```php
final public getPrevious() : \Throwable
```

Returns previous Exception

* * *

```php
final public getTrace() : array 
```

Gets the stack trace

* * *

```php
final public getTraceAsString() : string
```

Gets the stack trace as a string

* * *

```php
final private __clone() : void
```

Clone the exception

* * *

```php
public __toString() : string
```

String representation of the exception

* * *

```php
public __wakeup()
```

Used to serialize the object

* * *