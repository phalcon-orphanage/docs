---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Filter'
---

* [Phalcon\Filter](#filter)
* [Phalcon\Filter\Exception](#filter-exception)
* [Phalcon\Filter\FilterFactory](#filter-filterfactory)
* [Phalcon\Filter\FilterInterface](#filter-filterinterface)
* [Phalcon\Filter\Sanitize\AbsInt](#filter-sanitize-absint)
* [Phalcon\Filter\Sanitize\Alnum](#filter-sanitize-alnum)
* [Phalcon\Filter\Sanitize\Alpha](#filter-sanitize-alpha)
* [Phalcon\Filter\Sanitize\BoolVal](#filter-sanitize-boolval)
* [Phalcon\Filter\Sanitize\Email](#filter-sanitize-email)
* [Phalcon\Filter\Sanitize\FloatVal](#filter-sanitize-floatval)
* [Phalcon\Filter\Sanitize\IntVal](#filter-sanitize-intval)
* [Phalcon\Filter\Sanitize\Lower](#filter-sanitize-lower)
* [Phalcon\Filter\Sanitize\LowerFirst](#filter-sanitize-lowerfirst)
* [Phalcon\Filter\Sanitize\Regex](#filter-sanitize-regex)
* [Phalcon\Filter\Sanitize\Remove](#filter-sanitize-remove)
* [Phalcon\Filter\Sanitize\Replace](#filter-sanitize-replace)
* [Phalcon\Filter\Sanitize\Special](#filter-sanitize-special)
* [Phalcon\Filter\Sanitize\SpecialFull](#filter-sanitize-specialfull)
* [Phalcon\Filter\Sanitize\StringVal](#filter-sanitize-stringval)
* [Phalcon\Filter\Sanitize\Striptags](#filter-sanitize-striptags)
* [Phalcon\Filter\Sanitize\Trim](#filter-sanitize-trim)
* [Phalcon\Filter\Sanitize\Upper](#filter-sanitize-upper)
* [Phalcon\Filter\Sanitize\UpperFirst](#filter-sanitize-upperfirst)
* [Phalcon\Filter\Sanitize\UpperWords](#filter-sanitize-upperwords)
* [Phalcon\Filter\Sanitize\Url](#filter-sanitize-url)

<h1 id="filter">Class Phalcon\Filter</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter.zep)

| Namespace | Phalcon | | Uses | Closure, Phalcon\Filter\Exception, Phalcon\Filter\FilterInterface | | Implements | FilterInterface |

Carga perezosamente, almacena y expone objetos saneadores

## Constantes

```php
const FILTER_ABSINT = absint;
const FILTER_ALNUM = alnum;
const FILTER_ALPHA = alpha;
const FILTER_BOOL = bool;
const FILTER_EMAIL = email;
const FILTER_FLOAT = float;
const FILTER_INT = int;
const FILTER_LOWER = lower;
const FILTER_LOWERFIRST = lowerFirst;
const FILTER_REGEX = regex;
const FILTER_REMOVE = remove;
const FILTER_REPLACE = replace;
const FILTER_SPECIAL = special;
const FILTER_SPECIALFULL = specialFull;
const FILTER_STRING = string;
const FILTER_STRIPTAGS = striptags;
const FILTER_TRIM = trim;
const FILTER_UPPER = upper;
const FILTER_UPPERFIRST = upperFirst;
const FILTER_UPPERWORDS = upperWords;
const FILTER_URL = url;
```

## Propiedades

```php
/**
 * @var array
 */
protected mapper;

/**
 * @var array
 */
protected services;

```

## Métodos

```php
public function __construct( array $mapper = [] );
```

Pares clave valor con el nombre como clave y una llamada de retorno como valor para el objeto servicio

```php
public function get( string $name ): mixed;
```

Obtiene un servicio. Si no está en el vector mapeador, crea un nuevo objeto, lo establece y luego lo devuelve.

```php
public function has( string $name ): bool;
```

Comprueba si un servicio existe en el vector mapa

```php
public function sanitize( mixed $value, mixed $sanitizers, bool $noRecursive = bool ): mixed;
```

Sanea un valor con un único o conjunto de saneadores especificados

```php
public function set( string $name, callable $service ): void;
```

Establece un nuevo servicio en el vector mapeador

```php
protected function init( array $mapper ): void;
```

Carga los objetos en el vector mapeador interno

<h1 id="filter-exception">Class Phalcon\Filter\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Exception.zep)

| Namespace | Phalcon\Filter | | Extends | \Phalcon\Exception |

Phalcon\Filter\Exception

Las excepciones lanzadas en Phalcon\Filter usarán esta clase

<h1 id="filter-filterfactory">Class Phalcon\Filter\FilterFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/FilterFactory.zep)

| Namespace | Phalcon\Filter | | Uses | Phalcon\Filter |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Métodos

```php
public function newInstance(): FilterInterface;
```

Devuelve un objeto Localizador con todos los ayudantes definidos en funciones anónimas

```php
protected function getAdapters(): array;
```

<h1 id="filter-filterinterface">Interface Phalcon\Filter\FilterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/FilterInterface.zep)

| Namespace | Phalcon\Filter |

Carga perezosamente, almacena y expone objetos saneadores

## Métodos

```php
public function sanitize( mixed $value, mixed $sanitizers, bool $noRecursive = bool ): mixed;
```

Sanea un valor con un único o conjunto de saneadores especificados

<h1 id="filter-sanitize-absint">Class Phalcon\Filter\Sanitize\AbsInt</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/AbsInt.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\AbsInt

Sanea un valor a un entero absoluto

## Métodos

```php
public function __invoke( mixed $input );
```

@var mixed input The text to sanitize

<h1 id="filter-sanitize-alnum">Class Phalcon\Filter\Sanitize\Alnum</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/Alnum.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Alnum

Sanea un valor a un valor alfanumérico

## Métodos

```php
public function __invoke( mixed $input );
```

@var mixed input The text to sanitize

<h1 id="filter-sanitize-alpha">Class Phalcon\Filter\Sanitize\Alpha</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/Alpha.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Alpha

Sanea un valor a un valor alfabético

## Métodos

```php
public function __invoke( mixed $input );
```

@var mixed input The text to sanitize

<h1 id="filter-sanitize-boolval">Class Phalcon\Filter\Sanitize\BoolVal</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/BoolVal.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\BoolVal

Sanea un valor a booleano

## Métodos

```php
public function __invoke( mixed $input );
```

@var mixed input The text to sanitize

<h1 id="filter-sanitize-email">Class Phalcon\Filter\Sanitize\Email</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/Email.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Email

Sanea una cadena email

## Métodos

```php
public function __invoke( mixed $input );
```

@var mixed input The text to sanitize

<h1 id="filter-sanitize-floatval">Class Phalcon\Filter\Sanitize\FloatVal</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/FloatVal.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\FloatVal

Sane a un valor a real

## Métodos

```php
public function __invoke( mixed $input );
```

@var mixed input The text to sanitize

<h1 id="filter-sanitize-intval">Class Phalcon\Filter\Sanitize\IntVal</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/IntVal.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\IntVal

Sanea un valor a entero

## Métodos

```php
public function __invoke( mixed $input );
```

@var mixed input The text to sanitize

<h1 id="filter-sanitize-lower">Class Phalcon\Filter\Sanitize\Lower</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/Lower.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Lower

Sanea un valor a minúsculas

## Métodos

```php
public function __invoke( string $input );
```

@var string input The text to sanitize

<h1 id="filter-sanitize-lowerfirst">Class Phalcon\Filter\Sanitize\LowerFirst</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/LowerFirst.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\LowerFirst

Sanea un valor a `lcfirst`

## Métodos

```php
public function __invoke( string $input );
```

@var string input The text to sanitize

<h1 id="filter-sanitize-regex">Class Phalcon\Filter\Sanitize\Regex</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/Regex.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Regex

Sanea un valor realizando `preg_replace`

## Métodos

```php
public function __invoke( mixed $input, mixed $pattern, mixed $replace );
```

@var mixed input The text to sanitize

<h1 id="filter-sanitize-remove">Class Phalcon\Filter\Sanitize\Remove</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/Remove.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Remove

Sanea un valor eliminando partes de una cadena

## Métodos

```php
public function __invoke( mixed $input, mixed $replace );
```

@var mixed input The text to sanitize

<h1 id="filter-sanitize-replace">Class Phalcon\Filter\Sanitize\Replace</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/Replace.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Replace

Sanea un valor sustituyendo partes de una cadena

## Métodos

```php
public function __invoke( mixed $input, mixed $from, mixed $to );
```

@var mixed input The text to sanitize

<h1 id="filter-sanitize-special">Class Phalcon\Filter\Sanitize\Special</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/Special.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Special

Sanea caracteres especiales de un valor

## Métodos

```php
public function __invoke( mixed $input );
```

@var mixed input The text to sanitize

<h1 id="filter-sanitize-specialfull">Class Phalcon\Filter\Sanitize\SpecialFull</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/SpecialFull.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\SpecialFull

Sanee caracteres especiales de un valor (htmlspecialchars() y ENT_QUOTES)

## Métodos

```php
public function __invoke( mixed $input );
```

@var mixed input The text to sanitize

<h1 id="filter-sanitize-stringval">Class Phalcon\Filter\Sanitize\StringVal</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/StringVal.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\String

Sanea un valor a cadena

## Métodos

```php
public function __invoke( mixed $input );
```

@var mixed input The text to sanitize

<h1 id="filter-sanitize-striptags">Class Phalcon\Filter\Sanitize\Striptags</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/Striptags.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Striptags

Sanea un valor a `striptags`

## Métodos

```php
public function __invoke( string $input );
```

@var string input The text to sanitize

<h1 id="filter-sanitize-trim">Class Phalcon\Filter\Sanitize\Trim</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/Trim.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Trim

Sanea un valor eliminando espacios iniciales y finales

## Métodos

```php
public function __invoke( string $input );
```

@var mixed input The text to sanitize

<h1 id="filter-sanitize-upper">Class Phalcon\Filter\Sanitize\Upper</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/Upper.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Upper

Sanea un valor a mayúsculas

## Métodos

```php
public function __invoke( string $input );
```

@var string input The text to sanitize

<h1 id="filter-sanitize-upperfirst">Class Phalcon\Filter\Sanitize\UpperFirst</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/UpperFirst.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\UpperFirst

Sanea un valor a `ucfirst`

## Métodos

```php
public function __invoke( string $input );
```

@var string input The text to sanitize

<h1 id="filter-sanitize-upperwords">Class Phalcon\Filter\Sanitize\UpperWords</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/UpperWords.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\UpperWords

Sanea un valor a mayúsculas el primer carácter de cada palabra

## Métodos

```php
public function __invoke( string $input );
```

@var string input The text to sanitize

<h1 id="filter-sanitize-url">Class Phalcon\Filter\Sanitize\Url</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Filter/Sanitize/Url.zep)

| Namespace | Phalcon\Filter\Sanitize |

Phalcon\Filter\Sanitize\Url

Sanea un valor url

## Métodos

```php
public function __invoke( mixed $input );
```

@var mixed input The text to sanitize
