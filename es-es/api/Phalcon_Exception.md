---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Exception'
---

<a name="Phalcon_Exception"></a>

# Class **Phalcon\Exception**

*extends* class [Exception](https://php.net/manual/en/class.exception.php)

*implements* [Throwable](https://php.net/manual/en/class.throwable.php)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/exception.zep)

## Métodos

```php
public function __construct( [string $message = "" [, int $code = 0 [, \Throwable $previous = NULL ]]] )
```

Constructor de la excepción

```php
final private function __clone(): void
```

Clone the object

```php
public function __toString(): string
```

Representación de la excepción como una cadena

```php
final public function getMessage(): string
```

Obtiene el mensaje de excepción

```php
final public function getCode(): int
```

Obtiene el código de Exception

```php
final public function getFile(): string
```

Obtiene el archivo en el que se produjo la excepción

```php
final public function getLine(): int
```

Obtiene la línea en que se produjo la excepción

```php
final public function getTrace(): array
```

Obtiene el seguimiento de la pila

```php
final public function getPrevious(): \Throwable
```

Devuelve la excepción anterior

```php
final public function getTraceAsString(): string
```

Obtiene el seguimiento de la pila como una cadena