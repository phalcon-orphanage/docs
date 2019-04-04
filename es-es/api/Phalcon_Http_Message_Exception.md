---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Http\Message\Exception'
---
# Class **Phalcon\Http\Message\Exception**

**extends** class [Phalcon\Exception](Phalcon_Exception) **implements** [Throwable](https://secure.php.net/manual/en/class.throwable.php)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/message/exception.zep)

Exceptions thrown in `Phalcon\Http\Message` classes use this class for exceptions

## Properties

```php
protected string $message 
protected int    $code    
protected string $file    
protected int    $line    
```

## Métodos

**Inherited from [Throwable](https://secure.php.net/manual/en/class.throwable.php)**

```php
public __construct( 
    [ string $message = "" [, int $code = 0 [, \Throwable $previous = null ]]] 
) : void
```

Constructor de la excepción

* * *

```php
final public getCode() : int
```

Obtiene el código de Exception

* * *

```php
final public getFile() : string
```

Obtiene el archivo en el que se produjo la excepción

* * *

```php
final public getLine() : mixed
```

Obtiene la línea en que se produjo la excepción

* * *

```php
final public getMessage() : string
```

Obtiene el mensaje de excepción

* * *

```php
final public getPrevious() : \Throwable
```

Devuelve la excepción anterior

* * *

```php
final public getTrace() : array 
```

Obtiene el seguimiento de la pila

* * *

```php
final public getTraceAsString() : string
```

Obtiene el seguimiento de la pila como una cadena

* * *

```php
final private __clone() : void
```

Clona la excepción

* * *

```php
public __toString() : string
```

Representación de la excepción como una cadena

* * *

```php
public __wakeup()
```

Used to serialize the object

* * *