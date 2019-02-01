---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Filter\Exception'
---
# Class [Phalcon\Filter\Exception](Phalcon_Filter_Exception)

**extends** [Phalcon\Exception](Phalcon_Exception)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/exception.zep)

Exceptions thrown in `Phalcon\Filter\*` will use this class

## Métodos

```php
public function getCode(): int
```

Gets the exception code

```php
public function getFile(): string
```

Obtiene el archivo en el que se produjo la excepción

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

Obtiene el seguimiento de la pila

```php
public function getTraceAsString(): string
```

Obtiene el seguimiento de la pila como una cadena

```php
public function __toString(): string
```

Gets a string representation of the thrown object