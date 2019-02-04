---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#filter'
category: 'filter'
---
# Componente Filtro

* * *

## Limpiadores predeterminados

> Cuando sea apropiado, los limpiadores convertirán el valor al tipo esperado. Por ejemplo, el limpiador [absint](https://secure.php.net/manual/en/function.absint.php) removerá todos los caracteres no numéricos de la entrada, los convertirá a un número íntegro y devolverá su valor absoluto. {: .alert .alert-warning }

A continuación se enlistan los filtros predeterminados del componente. (N. del T.: se preserva la palabra inglesa *mixed* [mixto], para definir que el filtro acepta como entrada [`$input`] tanto cadenas de caracteres [`string`] como matrices [`array`]):

#### absint

```php
AbsInt( mixed $input ): int
```

Elimina todos los caracteres no numéricos, convierte el valor a íntegro y devuelve su valor absoluto. De manera interna utiliza [filter_var](https://secure.php.net/manual/es/function.filter-var.php) para el íntegro, [intval](https://secure.php.net/manual/es/function.intval.php) para la conversión y [absint](https://secure.php.net/manual/es/function.absint.php) para el valor absoluto.

#### alnum

```php
Alnum( mixed $input ): string | array
```

Elimina todos los caracteres que no son números o que no pertenecen al alfabeto. Se utiliza [preg_replace](https://secure.php.net/manual/es/function.preg-replace.php), que acepta cadenas y matrices como parámetros.

#### alpha

```php
Alpha( mixed $input ): string | array
```

Elimina todos los caracteres que no pertenecen al alfabeto. Se utiliza [preg_replace](https://secure.php.net/manual/es/function.preg-replace.php), que acepta cadenas y matrices como parámetros.

#### bool

```php
BoolVal( mixed $input ): bool
```

Convierte el valor a "booleano" (verdadero o falso).

Devuelve `true` (verdadero) si el valor es:

* `true`
* `on (encendido)`
* `yes (sí)`
* `y`
* `1`

Devuelve `false` (falso) si el valor es:

* `false`
* `off`
* `no`
* `n`
* `0`

#### email

```php
Email( mixed $input ): string
```

Elimina todos los caracteres excepto letras, digitos y los caracteres ``!#$%&*+-/=?^_`{\|}~@.[]``. El código interno utiliza [filter_var](https://secure.php.net/manual/es/function.filter-var.php)

#### float

```php
FloatVal( mixed $input ): float
```

Elimina todos los caracteres excepto dígitos, punto, signos más y menos, y convierte el valor a `double` (número con coma flotante de doble precisión). De manera interna utiliza [filter_var](https://secure.php.net/manual/es/function.filter-var.php) y `(double)`.

#### int

```php
IntVal( mixed $input ): int
```

Elimina todos los caracteres excepto digitos, signos más y menos, y convierte el valor a íntegro. De manera interna utiliza `(int)` y [filter_var](https://secure.php.net/manual/es/function.filter-var.php).

#### lower

```php
Lower( mixed $input ): string
```

Convierte todos los caracteres a minúscula. Si está cargada la extensión [mbstring](https://secure.php.net/manual/es/book.mbstring.php), utilizará la función [mb_convert_case](https://secure.php.net/manual/es/function.mb-convert-case.php) para ejecutar la transformación. Si no, empleará en su lugar la función estándar de PHP [strtolower](https://secure.php.net/manual/es/function.strtolower.php) con [utf8_decode](https://secure.php.net/manual/es/function.utf8-decode.php)

#### lowerFirst

```php
LowerFirst( mixed $input ): string
```

Convierte el primer carácter de la entrada a minúscula. De manera interna utiliza la función [lcfirst](https://secure.php.net/manual/es/function.lcfirst.php).

#### regex

```php
Regex( mixed $input, mixed $pattern, mixed $replace ): string
```

Realiza una operación de remplazo regex utilizando un patrón (`$pattern`) y texto de remplazo (`$replace`) como parámetros. De manera interna utiliza la función [preg_replace](https://secure.php.net/manual/ea/function.preg-replace.php).

#### remove

```php
Remove( mixed $input, mixed $remove ): string
```

Elimina contenido de la entrada sustituyendo el parámetro de remplazo (`$remove`) con una cadena vacía. De manera interna utiliza la función [str_replace](https://secure.php.net/manual/es/function.str-replace.php)

#### replace

```php
Replace( mixed $input, mixed $from, mixed $to ): string
```

Remplaza en la entrada el parámetro `$from` con el parámetro `$to`. De manera interna utiliza la función [str_replace](https://secure.php.net/manual/es/function.str-replace.php)

#### special

```php
Special( mixed $input ): string
```

Escapa los caracteres HTML, `'"<>&` y ASCII con valor inferior a 32 de la entrada. El código interno utiliza la función [filter_var](https://secure.php.net/manual/es/function.filter-var.php).

#### specialFull

```php
SpecialFull( mixed $input ): string
```

Convierte todos los caracteres especiales de la entrada a entidades HTML (incluidos comillas y apóstrofes). El código interno utiliza la función [filter_var](https://secure.php.net/manual/es/function.filter-var.php).

#### string

```php
StringVal( mixed $input ): string
```

Elimina las etiquetas y codifica las entidades HTML, incluyendo las comillas y apóstrofes. El código interno utiliza la función [filter_var](https://secure.php.net/manual/es/function.filter-var.php).

#### striptags

```php
StripTags( mixed $input ): int
```

Elimina todas las etiquetas HTML y PHP de la entrada. De manera interna utiliza la función [strip_tags](https://www.php.net/manual/es/function.strip-tags.php)

#### trim

```php
Trim( mixed $input ): string
```

Elimina los espacios en blanco al inicio y final de la entrada. De manera interna utiliza la función [trim](https://www.php.net/manual/es/function.trim.php).

#### upper

```php
Upper( mixed $input ): string
```

Capitaliza todos los caracteres. Si está instalada la extensión [mbstring](https://secure.php.net/manual/es/book.mbstring.php), utilizará la función [mb_convert_case](https://secure.php.net/manual/es/function.mb-convert-case.php) para ejecutar la transformación. En su defecto, utilizará la función estándar de PHP [strtoupper](https://secure.php.net/manual/es/function.strtoupper.php) con [utf8_decode](https://secure.php.net/manual/es/function.utf8-decode.php).

#### upperFirst

```php
UpperFirst( mixed $input ): string
```

Capitaliza el primer carácter de la entrada. De manera interna utiliza la función [ucfirst](https://secure.php.net/manual/es/function.ucfirst.php).

#### upperWords

```php
UpperWords( mixed $input ): string
```

Capitaliza la primera letra de cada palabra. De manera interna utiliza la función [ucwords](https://secure.php.net/manual/es/function.ucwords.php)

#### url

```php
Url( mixed $input ): string
```

Listado resumido de constantes disponibles para definir el tipo de limpieza a realizar:

```php
<?php

const FILTER_ABSINT      = 'absint';
const FILTER_ALNUM       = 'alnum';
const FILTER_ALPHA       = 'alpha';
const FILTER_BOOL        = 'bool';
const FILTER_EMAIL       = 'email';
const FILTER_FLOAT       = 'float';
const FILTER_INT         = 'int';
const FILTER_LOWER       = 'lower';
const FILTER_LOWERFIRST  = 'lowerFirst';
const FILTER_REGEX       = 'regex';
const FILTER_REMOVE      = 'remove';
const FILTER_REPLACE     = 'replace';
const FILTER_SPECIAL     = 'special';
const FILTER_SPECIALFULL = 'specialFull';
const FILTER_STRING      = 'string';
const FILTER_STRIPTAGS   = 'striptags';
const FILTER_TRIM        = 'trim';
const FILTER_UPPER       = 'upper';
const FILTER_UPPERFIRST  = 'upperFirst';
const FILTER_UPPERWORDS  = 'upperWords';
const FILTER_URL         = 'url';
```