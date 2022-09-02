---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Helper'
---

* [Phalcon\Helper\Arr](#helper-arr)
* [Phalcon\Helper\Base64](#helper-base64)
* [Phalcon\Helper\Exception](#helper-exception)
* [Phalcon\Helper\Fs](#helper-fs)
* [Phalcon\Helper\Json](#helper-json)
* [Phalcon\Helper\Number](#helper-number)
* [Phalcon\Helper\Str](#helper-str)

<h1 id="helper-arr">Class Phalcon\Helper\Arr</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Helper/Arr.zep)

| Namespace | Phalcon\Helper | | Uses | stdClass |

Esta clase ofrece funciones de vector rápidas en todo el framework

## Métodos

```php
final public static function blackList( array $collection, array $blackList ): array;
```

Filtro de lista negra por clave: excluye elementos de un vector por las claves obtenidas de los elementos de una lista negra

```php
final public static function chunk( array $collection, int $size, bool $preserveKeys = bool ): array;
```

Trocea un vector en vectores más pequeños de un determinado tamaño.

```php
final public static function filter( array $collection, mixed $method = null ): array;
```

Método ayudante para filtrar la colección

```php
final public static function first( array $collection, mixed $method = null ): mixed;
```

Devuelve el primer elemento de la colección. Si se pasa una invocable, el elemento devuelto es el primero que valida a `true`

```php
final public static function firstKey( array $collection, mixed $method = null ): mixed;
```

Devuelve la clave del primer elemento de la colección. Si se indica una invocable, el elemento devuelto es el primero que valida a `true`

```php
final public static function flatten( array $collection, bool $deep = bool ): array;
```

Aplana un vector hasta un nivel de profundidad, a no ser que `$deep` se establezca a `true`

```php
final public static function get( array $collection, mixed $index, mixed $defaultValue = null, string $cast = null ): mixed;
```

Método ayudante para obtener un elemento vector o un valor por defecto

```php
final public static function group( array $collection, mixed $method ): array;
```

Agrupa los elementos de un vector según el invocable pasado

```php
final public static function has( array $collection, mixed $index ): bool;
```

Determina si un elemento está presente en el vector.

```php
final public static function isUnique( array $collection ): bool;
```

Comprueba valores duplicados en una lista plana. Devuelve `true` si existen valores duplicados y `false` si todos los valores son únicos.

```php
final public static function last( array $collection, mixed $method = null ): mixed;
```

Devuelve el último elemento de la colección. Si se pasa una invocable, el elemento devuelto es el primero que valida a `true`

```php
final public static function lastKey( array $collection, mixed $method = null ): mixed;
```

Devuelve la clave del último elemento de la colección. Si se indica una invocable, el elemento devuelto es el primero que valida a `true`

```php
final public static function order( array $collection, mixed $attribute, string $order = string ): array;
```

Ordena una colección de vectores u objetos por clave

```php
final public static function pluck( array $collection, string $element ): array;
```

Recupera todos los valores para una clave dada:

```php
final public static function set( array $collection, mixed $value, mixed $index = null ): array;
```

Método ayudante para establecer un elemento de vector

```php
final public static function sliceLeft( array $collection, int $elements = int ): array;
```

Devuelve un nuevo vector con n elementos eliminados desde la derecha.

```php
final public static function sliceRight( array $collection, int $elements = int ): array;
```

Devuelve un nuevo vector con los X elementos desde la derecha

```php
final public static function split( array $collection ): array;
```

Devuelve un nuevo vector con las claves del vector indicado como un elemento y los valores en otro

```php
final public static function toObject( array $collection );
```

Devuelve el vector pasado como un objeto

```php
final public static function validateAll( array $collection, mixed $method = null ): bool;
```

Devuelve `true` si la función indicada devuelve `true` para todos los elementos de la colección, `false` en caso contrario.

```php
final public static function validateAny( array $collection, mixed $method = null ): bool;
```

Devuelve `true` si la función indicada devuelve `true` para al menos un elemento de la colección, `false` en caso contrario.

```php
final public static function whiteList( array $collection, array $whiteList ): array;
```

Filtro de lista blanca por clave: obtiene elementos de un vector filtrando por claves obtenidas de los elementos de una lista blanca

<h1 id="helper-base64">Class Phalcon\Helper\Base64</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Helper/Base64.zep)

| Namespace | Phalcon\Helper |

Phalcon\Helper\Base64

Esta clase ofrece funciones base64 de cadena rápidas

## Métodos

```php
final public static function decodeUrl( string $input ): string;
```

Decodifica una cadena Url Base64 a una cadena json

```php
final public static function encodeUrl( string $input ): string;
```

Codifica una cadena json a formato Url Base64.

<h1 id="helper-exception">Class Phalcon\Helper\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Helper/Exception.zep)

| Namespace | Phalcon\Helper | | Extends | \Phalcon\Exception |

Las excepciones lanzadas en Phalcon\Helper usarán esta clase

<h1 id="helper-fs">Class Phalcon\Helper\Fs</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Helper/Fs.zep)

| Namespace | Phalcon\Helper |

Esta clase ofrece ayuda para operaciones de ficheros

## Métodos

```php
final public static function basename( string $uri, mixed $suffix = null ): string;
```

Obtiene el nombre del fichero desde la ruta dada, lo mismo que basename() de PHP pero tiene soporte no-ASCII. basename() de PHP no soporta apropiadamente flujos o nombres de fichero que empiecen con un carácter no-US-ASCII. see https://bugs.php.net/bug.php?id=37738

<h1 id="helper-json">Class Phalcon\Helper\Json</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Helper/Json.zep)

| Namespace | Phalcon\Helper | | Uses | InvalidArgumentException |

Esta clase ofrece una envoltura de los métodos JSON para serializar y deserializar

## Métodos

```php
final public static function decode( string $data, bool $associative = bool, int $depth = int, int $options = int ): mixed;
```

Decodifica una cadena usando `json_decode` y lanza una excepción si los datos JSON no se han podido decodificar

```php
use Phalcon\Helper\Json;

$data = ' {"one":"two","0":"three"}
';

var_dump(Json::decode($data));
// [
//     'one' => 'two',
//     'three'
// ];
```

```php
final public static function encode( mixed $data, int $options = int, int $depth = int ): string;
```

Codifica una cadena usando `json_encode` y lanza una excepción si los datos JSON no se han podido codificar

```php
use Phalcon\Helper\Json;

$data = [
    'one' => 'two',
    'three'
];

echo Json::encode($data);
// {"one":"two","0":"three"}
```

<h1 id="helper-number">Class Phalcon\Helper\Number</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Helper/Number.zep)

| Namespace | Phalcon\Helper |

Phalcon\Helper\number

Esta clase ofrece funciones numéricas para el framework

## Métodos

```php
final public static function between( int $value, int $from, int $to ): bool;
```

Método ayudante para obtener un elemento vector o un valor por defecto

<h1 id="helper-str">Class Phalcon\Helper\Str</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Helper/Str.zep)

| Namespace | Phalcon\Helper | | Uses | RuntimeException |

Esta clase ofrece funciones de cadena rápidas en todo el framework

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
final public static function camelize( string $text, mixed $delimiter = null ): string;
```

Convierte cadenas a estilo `camelize`

```php
use Phalcon\Helper\Str;

echo Str::camelize("coco_bongo");            // CocoBongo
echo Str::camelize("co_co-bon_go", "-");     // Co_coBon_go
echo Str::camelize("co_co-bon_go", "_-");    // CoCoBonGo
```

```php
final public static function concat(): string;
```

Concatena cadenas usando el separador sólo una vez sin duplicación en los lugares de la concatenación

```php
$str = Phalcon\Helper\Str::concat(
    "/",
    "/tmp/",
    "/folder_1/",
    "/folder_2",
    "folder_3/"
);

echo $str;   // /tmp/folder_1/folder_2/folder_3/
```

```php
final public static function countVowels( string $text ): int;
```

Devuelve el número de vocales de la cadena indicada. Usa una expresión regular para contar el número de vocales (A, E, I, O, U) en una cadena.

```php
final public static function decapitalize( string $text, bool $upperRest = bool, string $encoding = string ): string;
```

Decapitaliza la primera letra de una cadena y luego la añade con el resto de la cadena. Omita el parámetro `upperRest` para mantener el resto de la cadena intacta, o establezcalo a `true` para convertir a mayúsculas.

```php
final public static function decrement( string $text, string $separator = string ): string;
```

Elimina un número de una cadena o decrementa ese número si está definido. defined

```php
use Phalcon\Helper\Str;

echo Str::decrement("a_1");    // "a"
echo Str::decrement("a_2");  // "a_1"
```

```php
final public static function dirFromFile( string $file ): string;
```

Acepta un nombre de fichero (sin extensión) y devuelve una estructura de directorios calculada con el nombre del fichero al final

```php
use Phalcon\Helper\Str;

echo Str::dirFromFile("file1234.jpg"); // fi/le/12/
```

```php
final public static function dirSeparator( string $directory ): string;
```

Acepta un nombre de directorio y se asegura que termina con DIRECTORY_SEPARATOR

```php
use Phalcon\Helper\Str;

echo Str::dirSeparator("/home/phalcon"); // /home/phalcon/
```

```php
final public static function dynamic( string $text, string $leftDelimiter = string, string $rightDelimiter = string, string $separator = string ): string;
```

Genera texto aleatorio según la plantilla

```php
use Phalcon\Helper\Str;

// Hi my name is a Bob
echo Str::dynamic("{Hi|Hello}, my name is a {Bob|Mark|Jon}!");

// Hi my name is a Jon
echo Str::dynamic("{Hi|Hello}, my name is a {Bob|Mark|Jon}!");

// Hello my name is a Bob
echo Str::dynamic("{Hi|Hello}, my name is a {Bob|Mark|Jon}!");

// Hello my name is a Zyxep
echo Str::dynamic(
    "[Hi/Hello], my name is a [Zyxep/Mark]!",
    "[", "]",
    "/"
);
```

```php
final public static function endsWith( string $text, string $end, bool $ignoreCase = bool ): bool;
```

Comprueba si una cadena termina con una cadena dada

```php
use Phalcon\Helper\Str;

echo Str::endsWith("Hello", "llo");          // true
echo Str::endsWith("Hello", "LLO", false);   // false
echo Str::endsWith("Hello", "LLO");          // true
```

```php
final public static function firstBetween( string $text, string $start, string $end ): string;
```

Devuelve la primera cadena que hay entre las cadenas desde el parámetro `start` y `end`.

```php
final public static function friendly( string $text, string $separator = string, bool $lowercase = bool, mixed $replace = null ): string;
```

Cambia un texto a una URL amigable

```php
final public static function humanize( string $text ): string;
```

Transforma una frase separada con guiones bajos o medios legible para humanos

```php
use Phalcon\Helper\Str;

echo Str::humanize("start-a-horse"); // "start a horse"
echo Str::humanize("five_cats");     // "five cats"
```

```php
final public static function includes( string $needle, string $haystack ): bool;
```

Le permite determinar si una cadena incluye o no a otra cadena.

```php
final public static function increment( string $text, string $separator = string ): string;
```

Añade un número a una cadena o incrementa ese número si ya está definido

```php
use Phalcon\Helper\Str;

echo Str::increment("a");    // "a_1"
echo Str::increment("a_1");  // "a_2"
```

```php
final public static function isAnagram( string $first, string $second ): bool;
```

Compara dos cadenas y devuelve `true` si ambas cadenas son anagrama, `false` en caso contrario.

```php
final public static function isLower( string $text, string $encoding = string ): bool;
```

Devuelve `true` si la cadena dada está en minúsculas, `false` en caso contrario.

```php
final public static function isPalindrome( string $text ): bool;
```

Devuelve `true` si la cadena dada es un palíndromo, `false` en caso contrario.

```php
final public static function isUpper( string $text, string $encoding = string ): bool;
```

Devuelve `true` si la cadena dada está en mayúsculas, `false` en caso contrario.

```php
final public static function lower( string $text, string $encoding = string ): string;
```

Convierte una cadena a minúsculas, esta función hace uso de la extensión mbstring si está disponible

```php
echo Phalcon\Helper\Str::lower("HELLO"); // hello
```

```php
final public static function random( int $type = int, long $length = int ): string;
```

Genera una cadena aleatoria basada en el tipo dado. El tipo es una de las constantes RANDOM_*

```php
use Phalcon\Helper\Str;

echo Str::random(Str::RANDOM_ALNUM); // "aloiwkqz"
```

```php
final public static function reduceSlashes( string $text ): string;
```

Reduce múltiples barras de una cadena a sólo una barra

```php
// foo/bar/baz
echo Phalcon\Helper\Str::reduceSlashes("foo//bar/baz");

// http://foo.bar/baz/buz
echo Phalcon\Helper\Str::reduceSlashes("http://foo.bar///baz/buz");
```

```php
final public static function startsWith( string $text, string $start, bool $ignoreCase = bool ): bool;
```

Comprueba si una cadena empieza con una cadena dada

```php
use Phalcon\Helper\Str;

echo Str::startsWith("Hello", "He");         // true
echo Str::startsWith("Hello", "he", false);  // false
echo Str::startsWith("Hello", "he");         // true
```

```php
final public static function uncamelize( string $text, mixed $delimiter = null ): string;
```

Decameliza cadenas que están camelizadas

```php
use Phalcon\Helper\Str;

echo Str::uncamelize("CocoBongo");       // coco_bongo
echo Str::uncamelize("CocoBongo", "-");  // coco-bongo
```

```php
final public static function underscore( string $text ): string;
```

Transforma una frase separada por guiones bajos en lugar de espacios

```php
use Phalcon\Helper\Str;

echo Str::underscore("look behind");     // "look_behind"
echo Str::underscore("Awesome Phalcon"); // "Awesome_Phalcon"
```

```php
final public static function upper( string $text, string $encoding = string ): string;
```

Convierte una cadena de texto a mayúsculas, esta función hace uso de la extensión mbstring si está disponible

```php
echo Phalcon\Helper\Str::upper("hello"); // HELLO
```
