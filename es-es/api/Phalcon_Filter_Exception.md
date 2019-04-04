---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Filter\Exception'
---
# Class [Phalcon\Filter\Exception](Phalcon_Filter_Exception)

**extiende** [Phalcon\Exception](Phalcon_Exception)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/filter/exception.zep)

Esta clase será utilizada por las excepciones generadas por `Phalcon\Filter\*`

## Métodos

```php
public function getCode(): int
```

Obtiene el código de la excepción

```php
public function getFile(): string
```

Obtiene el archivo en el que se produjo la excepción

```php
public function getLine(): int
```

Obtiene la línea en la cual el objeto fue instanciado

```php
public function getMessage(): string
```

Obtiene el mensaje

```php
public function getPrevious(): \Throwable
```

Obtiene el anterior objeto `\Throwable`

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

Obtiene una representación de cadena del objeto elevado