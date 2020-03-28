---
layout: default
language: 'es-es'
version: '4.0'
title: 'Estándar de codificación'
keywords: 'coding standard, zephir'
---

# Estándar de Código de Phalcon

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

Última actualización: 04-07-2019

Phalcon está escrito en [Zephir](https://zephir-lang.com), un lenguaje creado por el equipo de Phalcon y que se encuentra en continuo desarrollo. Por ello, aunque los desarrolladores quisieran seguirlo, no hay todavía ningún estándar de código establecido.

En este documento se describe el estándar de código que utiliza Phalcon para editar archivos de Zephir. El estándar de código es una variante de [PSR-12](https://www.php-fig.org/psr/psr-12/) desarrollada por [PHP-FIG](https://www.php-fig.org/)

## Archivos

- Los archivos deben usar solo UTF-8 sin [BOM (*marca de orden de bytes*)](https://es.wikipedia.org/wiki/Marca_de_orden_de_bytes).
- Los nombres de los archivos deben estar en formato [StudlyCaps](https://en.wikipedia.org/wiki/Studly_caps).
- Todos los archivos deben usar el final de línea de Unix LF (*linefeed*).
- Todos los archivos deben terminar con una única línea en blanco.
- Los nombres de las carpetas también deben estar en formato StudlyCaps y el árbol de carpeta/subcarpeta debe seguir el espacio de nombres (*namespace*) de la clase.

```php
phalcon/Acl/Adapter/Memory.zep
```

```php
namespace Phalcon\Acl\Adapter;

use Phalcon\Acl\Adapter;

class Memory extends Adapter
{

}
```

- El código debe utilizar 4 espacios para la sangría, no tabulaciones.
- Las líneas deben tener como máximo 80 caracteres. El límite de la longitud de línea es de 120 caracteres.
- Debe haber una línea en blanco después del espacio de nombres. También debe haber una línea en blanco después del bloque de declaraciones.
- No debe haber espacios en blanco al final de las líneas con código.
- Se pueden agregar líneas en blanco para hacer más legible el código o para indicar bloques de código relacionados.
- No debe haber más de una declaración por línea.

## Clases

- Los nombres de las clases deben estar en formato StudlyCaps.
- La llave de apertura de las clases debe ir en la línea siguiente a la declaración, y la de cierre en la línea siguiente del cuerpo.
- Las clases abstractas deben tener el prefijo `Abstract`
- Las interfaces deben tener el sufijo `Interface`

### Constantes

- Las constantes de clase deben declararse en mayúscula utilizando el guion bajo como separador.
- Las constantes de clase deben aparecer en la parte superior.
- Las constantes de clase deben estar en orden alfabético.

```php
namespace Phalcon\Acl;

class Enum
{
    const ALLOW = 1;
    const DENY  = 0;
}
```

### Propiedades

- Las propiedades de clase deben ser declaradas en formato camelCase.
- Las propiedades de clase deben estar en orden alfabético.
- Siempre que sea posible, las propiedades deben tener un valor predeterminado.
- Siempre que sea posible, las propiedades deben tener un bloque de documentación (*docblock*) que defina su tipo mediante la declaración `@var`.
- Las propiedades no deben usar como prefijo un guion bajo `_`. La única excepción es si el nombre de la propiedad es una palabra reservada como `default`, `namespace`, etc.

```php
namespace Phalcon\Acl\Adapter;

use Phalcon\Acl\Adapter;

class Memory extends Adapter
{
    /**
     * Returns latest key used to acquire access
     *
     * @var string | null
     */
    protected activeKey = "" { get };
}
```

### Métodos

- Method names must be declared in camelCase.
- Methods must be sorted alphabetically and based on their visibility. The order is `public`, `protected` and `private`. `__construct` if defined must be at the top of the class.
- Method names must not be prefixed with underscore `_`.
- All methods must have a return type. If the method does not return anything it should be marked `void`
- Opening braces for methods must go on the next line, and closing braces must go on the next line after the body.
- Visibility must be declared on all properties and methods; `abstract` and `final` must be declared before the visibility; `static` must be declared after the visibility.

```php
abstract public function getElement() -> var;

final public function getElement() -> var;

public static function getElement() -> var;
```

- Control structure keywords must have one space after them; method and function calls must not.
- Opening braces for control structures must go on the same line, and closing braces must go on the next line after the body.
- Control structures such as `if` must not have parentheses around the conditional, unless it is a complex one.

```php
if typeof variable === "array" {

}
```

### Method Arguments

- In the argument list, there must not be a space before each comma, and there must be one space after each comma.
- Each method must have its type declared before it
- Method arguments with default values must go at the end of the argument list.

```php
public function setElement(string! name, var value) -> void;
```

- Argument lists MAY be split across multiple lines, where each subsequent line is indented once. When doing so, the first item in the list must be on the next line, and there must be only one argument per line.

### Archivos PHP

Los archivos PHP tales como los tests deben seguir la especificación [PSR-12](https://www.php-fig.org/psr/psr-12/).