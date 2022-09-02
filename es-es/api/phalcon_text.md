---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Text'
---

* [Phalcon\Text](#text)

<h1 id="text">Class Phalcon\Text</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Text.zep)

| Namespace | Phalcon | | Uses | Phalcon\Helper\Str |

Provee utilidades para trabajar con textos

## Constantes

```php
const RANDOM_ALNUM = 0;
const RANDOM_ALPHA = 1;
const RANDOM_DISTINCT = 5;
const RANDOM_HEXDEC = 2;
const RANDOM_NOZERO = 4;
const RANDOM_NUMERIC = 3;
```

## Métodos

```php
public static function camelize( string $text, mixed $delimiter = null ): string;
```

Convierte las cadenas a estilo camelize

```php
echo Phalcon\Text::camelize("coco_bongo"); // CocoBongo
echo Phalcon\Text::camelize("co_co-bon_go", "-"); // Co_coBon_go
echo Phalcon\Text::camelize("co_co-bon_go", "_-"); // CoCoBonGo
```

```php
public static function concat(): string;
```

Concatena cadenas usando el separador sólo una vez sin duplicación en los lugares de la concatenación

```php
$str = Phalcon\Text::concat(
    "/",
    "/tmp/",
    "/folder_1/",
    "/folder_2",
    "folder_3/"
);

// /tmp/folder_1/folder_2/folder_3/
echo $str;
```

```php
public static function dynamic( string $text, string $leftDelimiter = string, string $rightDelimiter = string, string $separator = string ): string;
```

Genera texto aleatorio según la plantilla

```php
// Hi my name is a Bob
echo Phalcon\Text::dynamic("{Hi|Hello}, my name is a {Bob|Mark|Jon}!");

// Hi my name is a Jon
echo Phalcon\Text::dynamic("{Hi|Hello}, my name is a {Bob|Mark|Jon}!");

// Hello my name is a Bob
echo Phalcon\Text::dynamic("{Hi|Hello}, my name is a {Bob|Mark|Jon}!");

// Hello my name is a Zyxep
echo Phalcon\Text::dynamic(
    "[Hi/Hello], my name is a [Zyxep/Mark]!",
    "[", "]",
    "/"
);
```

```php
public static function endsWith( string $text, string $end, bool $ignoreCase = bool ): bool;
```

Comprueba si una cadena termina con una cadena dada

```php
echo Phalcon\Text::endsWith("Hello", "llo"); // true
echo Phalcon\Text::endsWith("Hello", "LLO", false); // false
echo Phalcon\Text::endsWith("Hello", "LLO"); // true
```

```php
public static function humanize( string $text ): string;
```

Transforma una frase separada con guiones bajos o medios legible para humanos

```php
echo Phalcon\Text::humanize("start-a-horse"); // "start a horse"
echo Phalcon\Text::humanize("five_cats"); // "five cats"
```

```php
public static function increment( string $text, string $separator = string ): string;
```

Añade un número a una cadena o incrementa ese número si ya está definido

```php
echo Phalcon\Text::increment("a"); // "a_1"
echo Phalcon\Text::increment("a_1"); // "a_2"
```

```php
public static function lower( string $text, string $encoding = string ): string;
```

Convierte una cadena a minúsculas, esta función hace uso de la extensión mbstring si está disponible

```php
echo Phalcon\Text::lower("HELLO"); // hello
```

```php
public static function random( int $type = int, long $length = int ): string;
```

Genera una cadena aleatoria basada en el tipo dado. El tipo es una de las constantes RANDOM_*

```php
use Phalcon\Text;

// "aloiwkqz"
echo Text::random(Text::RANDOM_ALNUM);
```

```php
public static function reduceSlashes( string $text ): string;
```

Reduce múltiples barras de una cadena a sólo una barra

```php
// foo/bar/baz
echo Phalcon\Text::reduceSlashes("foo//bar/baz");

// http://foo.bar/baz/buz
echo Phalcon\Text::reduceSlashes("http://foo.bar///baz/buz");
```

```php
public static function startsWith( string $text, string $start, bool $ignoreCase = bool ): bool;
```

Comprueba si una cadena empieza con una cadena dada

```php
echo Phalcon\Text::startsWith("Hello", "He"); // true
echo Phalcon\Text::startsWith("Hello", "he", false); // false
echo Phalcon\Text::startsWith("Hello", "he"); // true
```

```php
public static function uncamelize( string $text, mixed $delimiter = null ): string;
```

Decameliza cadenas que están camelizadas

```php
echo Phalcon\Text::uncamelize("CocoBongo"); // coco_bongo
echo Phalcon\Text::uncamelize("CocoBongo", "-"); // coco-bongo
```

```php
public static function underscore( string $text ): string;
```

Transforma una frase separada por guiones bajos en lugar de espacios

```php
echo Phalcon\Text::underscore("look behind"); // "look_behind"
echo Phalcon\Text::underscore("Awesome Phalcon"); // "Awesome_Phalcon"
```

```php
public static function upper( string $text, string $encoding = string ): string;
```

Convierte una cadena de texto a mayúsculas, esta función hace uso de la extensión mbstring si está disponible

```php
echo Phalcon\Text::upper("hello"); // HELLO
```
