---
layout: default
language: 'es-es'
version: '4.0'
upgrade: ''
title: 'Ayudantes'
keywords: 'ayudantes, vector, cadena, sistema de ficheros, numero, utilidades'
---

# Componente Ayudante

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

`Phalcon\Helper` un componente que expone las clases ayudantes y métodos estáticos usados por el framework.

## Arr

[Phalcon\Helper\Arr](api/phalcon_helper#helper-arr) expone métodos estáticos que ofrecen un acceso rápido a funcionalidades comunes cuando se trabaja con vectores.

### `chunk`

```php
final public static function chunk(
    array $collection, 
    int $size, 
    bool $preserveKeys = false
): array
```

Trocea un vector en vectores más pequeños de un determinado tamaño.

```php
<?php

use Phalcon\Helper\Arr;

$source   = [
    'k1' => 1,
    'k2' => 2,
    'k3' => 3,
    'k4' => 4,
    'k5' => 5,
    'k6' => 6,
];

$chunks = Arr::chunk($source, 2);

// [
//    [1, 2],
//    [3, 4],
//    [5, 6],
// ]
```

### first

```php
final public static function first(
    array $collection, 
    mixed $method = null
): var
```

Devuelve el primer elemento de la colección. Si se indica una invocable, el elemento devuelto es el primero que valida a `true`

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    'Phalcon',
    'Framework',
];

echo Arr::first($collection); // 'Phalcon'

$result = Arr::first(
    $collection,
    function ($element) {
        return strlen($element) > 8;
    }
);

echo $result; // 'Framework'
```

### `firstKey`

```php
final public static function firstKey(
    array $collection, 
    mixed $method = null
): var
```

Devuelve la clave del primer elemento de la colección. Si se indica una invocable, el elemento devuelto es el primero que valida a `true`

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    1 => 'Phalcon',
    3 => 'Framework',
];

echo Arr::firstKey($collection); // 1

$result = Arr::firstKey(
    $collection,
    function ($element) {
        return strlen($element) > 8;
    }
);

echo $result; // 3
```

### `flatten`

```php
final public static function flatten(
    array $collection, 
    bool $deep = false
): array
```

Aplana un vector hasta tener un sólo nivel de profundidad. Si `$deep` se configura a `true`, recorre todos los elementos y los aplana todos.

```php
<?php

use Phalcon\Helper\Arr;

$source   = [1, [2], [[3], 4], 5];
var_dump(
    Arr::flatten($source)
);

// [1, 2, [3], 4, 5];

$source   = [1, [2], [[3], 4], 5];
var_dump(
    Arr::flatten($source, true)
);
// [1, 2, 3, 4, 5];
```

### `get`

```php
final public static function get(
    array $collection, 
    mixed $index, 
    mixed $defaultValue = null,
    string $cast = null
): mixed
```

Recupera un elemento de un vector. Si el elemento existe se devuelve su valor. Si no, se devuelve `defaultValue`. El parámetro `cast` acepta una cadena que define a qué tipo será convertido el valor devuelto. Los valores disponibles son:

- `array`
- `bool`
- `boolean`
- `double`
- `float`
- `int`
- `integer`
- `null`
- `object`
- `string`

```php
<?php

use Phalcon\Helper\Arr;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

echo Arr::get($data, 'year');                    // 1776
echo Arr::get($data, 'unknown', 1776);           // 1776
echo Arr::get($data, 'unknown', 1776, 'string'); // '1776'
```

### `group`

```php
final public static function group(
    array $collection, 
    mixed $method
): array
```

Agrupa los elementos de un vector basándose en la invocable indicada y devuelve el vector con los elementos agrupados. La invocable puede ser una cadena con el nombre del elemento, una llamable o un método disponible. El vector puede contener subvectores como elementos u objetos con propiedades relevantes.

```php
<?php

use Phalcon\Helper\Arr;

$collection =  [
    ['name' => 'Paul',  'age' => 34],
    ['name' => 'Peter', 'age' => 31],
    ['name' => 'John',  'age' => 29],
];

$result = Arr::group($collection, 'age');
var_dump($result);

// [
//     34 => [
//         [
//             'name' => 'Paul',
//             'age' => 34,
//         ],
//     ],
//     31 => [
//         [
//             'name' => 'Peter',
//             'age' => 31,
//         ],
//     ],
//     29 => [
//         [
//             'name' => 'John',
//             'age' => 29,
//         ],
//     ],
// ]


$peter = new \stdClass();
$peter->name = 'Peter';
$peter->age = 34;

$paul = new \stdClass();
$paul->name = 'Paul';
$paul->age = 31;

$collection = [
    'peter' => $peter,
    'paul'  => $paul,
];

$result = = Arr::group($collection, 'name');
var_dump($result);

// [
//     'Peter' => [
//          stdClass(
//              name : 'Peter',
//              age  : 34
//          ),
//      ],
//     'Paul'  => [
//          stdClass(
//              name : 'Paul',
//              age  : 31
//          ),
//      ],
// ]


$collection = ['one', 'two', 'three'];

$result = Arr::group($collection, 'strlen');
var_dump($result);

// [
//     3 => ['one', 'two'],
//     5 => ['three']
// ]
```

### `has`

```php
final public static function has(array $collection, mixed $index): bool
```

Comprueba si un elemento existe en un vector. Devuelve `true` si se encuentra, `false` en caso contrario.

```php
<?php

use Phalcon\Helper\Arr;

$data = [
    'colors' => [
        'red',
        'white',
        'blue',
    ],
    'year'   => 1776,
];

echo Arr::has($data, 'year');          // true
echo Arr::has($data, 'unknown');       // false
```

### `isUnique`

```php
final public static function isUnique(array $collection): bool
```

Comprueba valores duplicados en una lista plana. Devuelve `true` si existen valores duplicados y `false` si todos los valores son únicos.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    'Phalcon',
    'Framework',
];

$result = Arr::isUnique($collection); // true

$collection = [
    'Phalcon',
    'Framework',
    'Phalcon',
];
$result = Arr::isUnique($collection); // false
```

### `last`

```php
final public static function last(
    array $collection, 
    mixed $method = null
): var
```

Devuelve el último elemento de la colección. Si se indica una invocable, el elemento devuelto es el último que valida `true`

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    'Phalcon',
    'Framework',
];

echo Arr::last($collection); // 'Framework'

$result = Arr::last(
    $collection,
    function ($element) {
        return strlen($element) < 8;
    }
);

echo $result; // 'Phalcon'
```

### `lastKey`

```php
final public static function lastKey(
    array $collection, 
    mixed $method = null
): var
```

Devuelve la clave del último elemento de la colección. Si se indica una invocable, el elemento devuelto es el último que valida `true`

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    1 => 'Phalcon',
    3 => 'Framework',
];

echo Arr::lastKey($collection); // 3

$result = Arr::lastKey(
    $collection,
    function ($element) {
        return strlen($element) < 8;
    }
);

echo $result; // 1
```

### `order`

```php
final public static function order(
    array $collection, 
    mixed $attribute, 
    string $order = 'asc'
): array
```

Ordena una colección de vectores u objetos por `attribute` y devuelve el vector ordenado. El tercer parámetro controla el sentido de la ordenación.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    ['id' => 2],
    ['id' => 3],
    ['id' => 1],
];

$result = Arr::order($collection, 'id');
var_dump($result);
// [
//     ['id' => 1],
//     ['id' => 2],
//     ['id' => 3],
// ]

$result = Arr::order($collection, 'id', 'desc');
var_dump($result);
// [
//     ['id' => 3],
//     ['id' => 2],
//     ['id' => 1],
// ]
```

### `pluck`

```php
final public static function pluck(
    array $collection, 
    string element
): array
```

Recupera todos los valores para una clave dada, devolviéndolos como un vector

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    ['product_id' => 'prod-100', 'name' => 'Desk'],
    ['product_id' => 'prod-200', 'name' => 'Chair'],
];

$result = Arr::pluck($collection, 'name');
var_dump($result);
// [
//     'Desk', 
//     'Chair'
// ]
```

### `set`

```php
final public static function set(
    array $collection, 
    mixed $value, 
    mixed $index = null
): array
```

Establece un elemento vector y devuelve un nuevo vector. El tercer parámetro es el índice/clave.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [];
$result = Arr::set($collection, 'Phalcon');
var_dump($result);
// [
//     0 => 'Phalcon',
// ]


$collection = [
    1 => 'Phalcon'
];
$result = Arr::set($collection, 'Framework', 1);
var_dump($result);
// [
//     1 => 'Framework',
// ]
```

### `sliceLeft`

```php
final public static function sliceLeft(
    array $collection, 
    int $elements = 1
): array
```

Devuelve un nuevo vector con n elementos eliminados desde la izquierda.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    'Phalcon',
    'Framework',
    'for',
    'PHP',
];

$result = Arr::sliceLeft($collection, 1);
var_dump($result);
// [
//     'Phalcon',
// ]

$result = Arr::sliceLeft($collection, 3);
var_dump($result);
// [
//     'Phalcon',
//     'Framework',
//     'for',
// ]
```

### `sliceRight`

```php
final public static function sliceRight(
    array $collection, 
    int $elements = 1
): array
```

Devuelve un nuevo vector con n elementos eliminados desde la derecha.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    'Phalcon',
    'Framework',
    'for',
    'PHP',
];

$result   = Arr::sliceRight($collection, 1);
var_dump($result);
// [
//     'Framework',
//     'for',
//     'PHP',
// ]

$result   = Arr::sliceRight($collection, 3);
var_dump($result);
// [
//     'PHP',
// ]
```

### `split`

```php
final public static function split(array $collection): array
```

Devuelve un nuevo vector con las claves del vector indicado como un elemento y los valores en otro.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    1 => 'Phalcon',
    3 => 'Framework',
];

$result = Arr::split($collection);
var_dump($result);
// [
//     [1, 3],
//     ['Phalcon', 'Framework']
// ]
```

### `toObject`

```php
final public static function toObject(array $collection)
```

Convierte un vector a un objeto

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    1 => 'Phalcon',
    3 => 'Framework',
];

$result = Arr::toObject($collection);
var_dump($result);
// object(stdClass)#1 (2) {
//   ["1"] => string(7) "Phalcon"
//   ["3"] => string(9) "Framework"
// }
```

### `validateAll`

```php
final public static function validateAll(
    array $collection, 
    mixed $method
): bool
```

Devuelve `true` si la función indicada devuelve `true` para todos los elementos de la colección, `false` en caso contrario.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [2, 3, 4, 5];
$result     = Arr::validateAll(
    $collection,
    function ($element) {
        return $element > 1;
    }
);

var_dump($result); // true
```

### `validateAny`

```php
final public static function validateAny(
    array $collection, 
    mixed $method
): bool
```

Devuelve `true` si la función indicada devuelve `true` para al menos un elemento de la colección, `false` en caso contrario.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [2, 3, 4, 5];
$result     = Arr::validateAny(
    $collection,
    function ($element) {
        return $element > 4;
    }
);

var_dump($result); // true
```

### `whiteList`

```php
final public static function whiteList(
    array $collection, 
    array $whiteList 
): array
```

Devuelve un subconjunto del vector, elementos de lista blanca por clave. El vector devuelto contiene sólo los elementos del vector original que tiene claves idénticas al vector lista blanca pasado como parámetro.

```php
<?php

use Phalcon\Helper\Arr;

$collection = [
    2     => 'Phalcon',
    3     => 'Apples',
    'one' => 'Framework',
    'two' => 'Oranges',
];
$result     = Arr::whiteList(
    $collection,
    [2, 'one']
);

var_dump($result);
// [
//     2     => 'Phalcon',
//     'one' => 'Framework'
// ]
```

## Excepción

Cualquier excepción lanzada en los componentes `Phalcon\Helper\*` serán de este tipo: [Phalcon\Helper\Exception](api/phalcon_helper#helper-exception)

## Fs

[Phalcon\Helper\Fs](api/phalcon_helper#helper-fs) expone métodos estáticos que ofrecen métodos de ayuda para operaciones con ficheros

### `basename`

```php
final public static function basename(
    int $uri, 
    mixed $suffix
) -> string
```

Obtiene el nombre de fichero de una ruta dada, Este método es similar a la función PHP [basename()](https://www.php.net/manual/en/function.basename.php) pero con soporte de caracteres no-ASCII. La función de PHP [basename()](https://www.php.net/manual/en/function.basename.php) no soporta correctamente flujos o nombres de archivo que empiecen con un carácter no-US-ASCII.

```php
<?php

use Phalcon\Helper\Fs;

$file = '/file/热爱中文.txt';

echo Fs::basename($file); // '热爱中文.txt'

$file = '/myfolder/日本語のファイル名.txt';

echo Fs::basename($file); // '日本語のファイル名.txt'

$file = '/root/ελληνικά.txt';

echo Fs::basename($file); // 'ελληνικά.txt';
```

## Json

[Phalcon\Helper\Json](api/phalcon_helper#helper-json) actúa como una envoltura de los métodos PHP `json_encode` y `json_decode`, comprobando errores y lanzando excepciones en consecuencia.

### `decode`

```php
final public static function decode(
    string $data,
    bool $associative = false,
    int $depth = 512,
    int $options = 0
 ): mixed
```

Decodifica una cadena usando `json_decode` y lanza una excepción si los datos JSON no pueden ser decodificados

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

### `encode`

```php
final public static function encode(
    $data,
    int $depth = 512,
    int $options = 0
): string
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

## Number

[Phalcon\Helper\Number](api/phalcon_helper#helper-number) expone métodos estáticos que ofrecen un acceso rápido a funcionalidades comunes cuando se trabaja con números.

### `between`

```php
final public static function between(
    int $value, 
    int $from, 
    int $to
) -> bool
```

Comprueba si el valor pasado está entre el rango especificado en `from` y `to`

```php
<?php

use Phalcon\Helper\Number;

$min   = 10;
$max   = 100;
$value = 13;

echo Number::between($value, $min, $max);   // true

$value = 2;
echo Number::between($value, $min, $max);   // false
```

## Str

[Phalcon\Helper\Str](api/phalcon_helper#helper-str) expone métodos estáticos que ofrecen manipulaciones ágiles sobre cadenas.

### `camelize`

```php
final public static function camelize(string $text, mixed $delimiter = null): string
```

Convierte una cadena a estilo camelize

```php
<?php

use Phalcon\Helper\Str;

echo Str::camelize('coco_bongo');         // CocoBongo
echo Str::camelize('co_co-bon_go', '-');  // Co_coBon_go
echo Str::camelize('co_co-bon_go', '_-'); // CoCoBonGo
```

### `concat`

```php
final public static function concat(
    string $separator, 
    string $a, 
    string $b 
    [, string $x] ... 
): string
```

Concatena cadenas usando el separador sólo una vez, quitando delimitadores duplicados. El primer parámetro es el separador, los siguientes son las cadenas a concatenar. Los parámetros mínimos obligatorios son tres.

```php
<?php

use Phalcon\Helper\Str;

$folder = Str::concat(
    '/',
    '/tmp/',
    '/folder_1/',
    '/folder_2',
    'folder_3/'
);

echo $folder; // /tmp/folder_1/folder_2/folder_3/

```

### `countVowels`

```php
final public static function countVowels(string $text): int
```

Devuelve el número de vocales de la cadena indicada. Usa una expresión regular para contar el número de vocales (A, E, I, O, U) en una cadena.

```php
<?php

use Phalcon\Helper\Str;

$source = 'Luke, I am your father!';

echo Str::countVowels($source); // 8
```

### `decapitalize`

```php
final public static function decapitalize(
    string $text, 
    bool $upperRest = false, 
    string $encoding = 'UTF-8'
): string
```

Convierte a minúscula la primera letra de la cadena y luego la añade. Si el parámetro `upperRest` se establece a `false` el resto de la cadena permanecece intacto, en caso contrario se convertirá a mayúsculas. Este método intentará usar métodos proporcionados por la extensión `mbstring` y usar el equivalente PHP como alternativa. El último parámetro es la codificación que usarán los métodos `mbstring`. Por defecto `UTF-8`.

```php
<?php

use Phalcon\Helper\Str;

$source   = 'BeetleJuice';

echo Str::decapitalize($source);       // beetleJuice
echo Str::decapitalize($source, true); // bEETLEJUICE
```

### decrement

```php
final public static function decrement(
    string $text, 
    string $separator = '_'
): string
```

Elimina un número de una cadena o decrementa ese número si está definido.

```php
<?php

use Phalcon\Helper\Str;

echo Str::decrement('a_1'); // 'a'
echo Str::decrement('a_2'); // 'a_1'
```

### `dirFromFile`

```php
final public static function dirFromFile(string $file): string
```

Acepta un nombre de fichero (sin extension) y devuelve una estructura de directorio calculada con el nombre del fichero al final

```php
<?php

use Phalcon\Helper\Str;

echo Str::dirFromFile("file1234.jpg"); // fi/le/12/
```

### `dirSeparator`

```php
final public static function dirSeparator(string $directory): string
```

Acepta un nombre de directorio y se asegura que termina con `DIRECTORY_SEPARATOR`

```php
<?php

use Phalcon\Helper\Str;

echo Str::dirSeparator("/home/phalcon"); // /home/phalcon/
```

### `dynamic`

```php
final public static function dynamic(
    string $text,
    string $leftDelimiter = '{',
    string $rightDelimiter = '}',
    string $separator = '|'
): string
```

Genera texto aleatorio basado en la plantilla. La plantilla necesita separadores y delimitadores para los diferentes valores. Los valores por defecto para éstos se pueden anular con los parámetros del método.

```php
<?php

use Phalcon\Helper\Str;

echo Str::dynamic('{Han|Leia|Luke} {Solo|Skywalker}!');  // Han Solo!
echo Str::dynamic('{Han|Leia|Luke} {Solo|Skywalker}!');  // Leia Skywalker!
echo Str::dynamic('{Han|Leia|Luke} {Solo|Skywalker}!');  // Luke Solo!
```

### `endsWith`

```php
final public static function endsWith(
    string $text, 
    string $end, 
    bool $ignoreCase = true
): bool
```

Devuelve `true` si una cadena termina con la cadena dada. Si el último parámetro es `true` (por defecto), la búsqueda se hace de una forma insensible a mayúsculas y minúsculas.

```php
<?php

use Phalcon\Helper\Str;

echo Str::endsWith('Hello', 'llo');        // true
echo Str::endsWith('Hello', 'LLO', false); // false
echo Str::endsWith('Hello', 'LLO');        // true
```

### `firstBetween`

```php
final public static function firstBetween(
    string $haystack,
    string $start,
    string $end
): string
```

Devuelve la primera cadena que hay entre las cadenas de los parámetros `start` y `end`. El método intentará usar métodos proporcionados por la extensión `mbstring` y usar el equivalente PHP como alternativa.

```php
<?php

use Phalcon\Helper\Str;

$source   = 'This is a [custom] string with [other] stuff';

echo Str::firstBetween($source, '[', ']'); // custom
```

### `humanize`

```php
final public static function humanize(string $text): string
```

Transforma una frase separada con guiones bajos o medios legible para humanos

```php
<?php

use Phalcon\Helper\Str;

echo Str::humanize('start-a-horse'); // 'start a horse'
echo Str::humanize('five_cats');     // 'five cats'
```

### `includes`

```php
final public static function includes(
    string $needle, 
    string $haystack
): bool
```

Comprueba si una cadena está incluida en otra. Devuelve `true` si está incluida, `false` en caso contrario. Este método intentará usar métodos proporcionados por la extensión `mbstring` y usar el equivalente PHP como alternativa.

```php
<?php

use Phalcon\Helper\Str;

echo Str::includes('start', 'start-a-horse'); // true
echo Str::includes('end', 'start-a-horse'); // false
```

### `increment`

```php
final public static function increment(
    string $text, 
    string $separator = '_'
): string
```

Añade un número a una cadena o lo incrementa si el número ya existe.

```php
<?php

use Phalcon\Helper\Str;

echo Str::increment('a');   // 'a_1'
echo Str::increment('a_1'); // 'a_2'
```

### `isAnagram`

```php
final public static function isAnagram(
    string $first, 
    string $second
): bool
```

Compara dos cadenas y devuelve `true` si ambas cadenas son anagramas, `false` en caso contrario.

```php
<?php

use Phalcon\Helper\Str;

echo Str::isAnagram('rail safety', 'fairy tales'); // true
```

### `isLower`

```php
final public static function isLower(
    string $text, 
    string $encoding = 'UTF-8'
):  bool
```

Devuelve `true` si la cadena dada está en minúsculas, `false` en caso contrario. Este método intentará usar métodos proporcionados por la extensión `mbstring` y usar el equivalente PHP como alternativa. El último parámetro es la codificación que usarán los métodos `mbstring`. Por defecto `UTF-8`.

```php
<?php

use Phalcon\Helper\Str;

echo Str::isLower('phalcon framework'); // true
echo Str::isLower('Phalcon Framework'); // false
```

### `isPalindrome`

```php
final public static function isPalindrome(string $text): bool
```

Devuelve `true` si la cadena dada es un palíndromo, `false` en caso contrario.

```php
<?php

use Phalcon\Helper\Str;

echo Str::isPalindrome('racecar'); // true
```

### `isUpper`

```php
final public static function isUpper(
    string $text, 
    string $encoding = 'UTF-8'
):  bool
```

Devuelve `true` si la cadena dada está en mayúsculas, `false` en caso contrario. Este método intentará usar métodos proporcionados por la extensión `mbstring` y usar el equivalente PHP como alternativa. El último parámetro es la codificación que usarán los métodos `mbstring`. Por defecto `UTF-8`.

```php
<?php

use Phalcon\Helper\Str;

echo Str::isUpper('PHALCON FRAMEWORK'); // true
echo Str::isUpper('Phalcon Framework'); // false
```

### `lower`

```php
final public static function lower(
    string $text, 
    string $encoding = 'UTF-8'
): string
```

Convierte una cadena a minúscula. Este método intentará usar métodos proporcionados por la extensión `mbstring` y usar el equivalente PHP como alternativa. El último parámetro es la codificación que usarán los métodos `mbstring`. Por defecto `UTF-8`.

```php
<?php

use Phalcon\Helper\Str;

echo Str::lower('PHALCON FRAMEWORK'); // phalcon framework
```

### `random`

```php
final public static function random(
    int $type = 0, 
    long $length = 8
): string
```

Genera una cadena aleatoria basada en el tipo dado. El primer parámetro es una de las constantes `RANDOM_*`. El segundo parámetro especifica el tamaño de la cadena (por defecto 8).

| Constante         | Descripción                                                                                                |
| ----------------- | ---------------------------------------------------------------------------------------------------------- |
| `RANDOM_ALNUM`    | Sólo caracteres alfanuméricos `[a-zA-Z0-9]`                                                                |
| `RANDOM_ALPHA`    | Sólo caracteres alfabéticos `[azAZ]`                                                                       |
| `RANDOM_DISTINCT` | Sólo caracteres alfanuméricos en mayúsculas excluyen caracteres similares `[2345679ACDEFHJKLMNPRSTUVWXYZ]` |
| `RANDOM_HEXDEC`   | Sólo caracteres hexadecimales `[0-9a-f]`                                                                   |
| `RANDOM_NOZERO`   | Sólo números sin `0` `[1-9]`                                                                               |
| `RANDOM_NUMERIC`  | Sólo números `[0-9]`                                                                                       |

```php
<?php

use Phalcon\Helper\Str;

echo Str::random(Str::RANDOM_ALNUM); // 'aloiwkqz'
```

### `reduceSlashes`

```php
final public static function reduceSlashes(string $text): string
```

Reduce múltiples barras de una cadena a sólo una barra. Si está presente el esquema (`https://`, `ftp://` no se cambiará)

```php
<?php

use Phalcon\Helper\Str;

echo Str::reduceSlashes('foo//bar/baz');             // foo/bar/baz
echo Str::reduceSlashes('http://foo.bar///baz/buz'); // http://foo.bar/baz/buz
echo Str::reduceSlashes('//foo.bar///baz/buz');      // /foo.bar/baz/buz
echo Str::reduceSlashes('ftp://foo.bar///baz/buz');  // ftp://foo.bar/baz/buz
echo Str::reduceSlashes('ftp//foo.bar///baz/buz');   // ftp/foo.bar/baz/buz
```

### `startsWith`

```php
final public static function startsWith(
    string $text, 
    string $start, 
    bool $ignoreCase = true
): bool
```

Devuelve `true` si una cadena empieza por una cadena dada. Si el último parámetro es `true` (por defecto), la búsqueda se hace de una forma insensible a mayúsculas y minúsculas.

```php
<?php

use Phalcon\Helper\Str;

echo Str::startsWith('Hello', 'He');        // true
echo Str::startsWith('Hello', 'he', false); // false
echo Str::startsWith('Hello', 'he');        // true
```

### `uncamelize`

```php
final public static function uncamelize(
    string $text,   
    mixed $delimiter = null
): string
```

Convierte en texto normal, cadenas de texto en estilo camelcase

```php
<?php

use Phalcon\Helper\Str;

echo Str::uncamelize('CocoBongo');      // coco_bongo
echo Str::uncamelize('CocoBongo', '-'); // coco-bongo
```

### `underscore`

```php
final public static function underscore(string $text): string
```

Transforma una frase separada por guiones bajos en lugar de espacios.

```php
<?php

use Phalcon\Helper\Str;

echo Str::underscore('look behind');     // 'look_behind'
echo Str::underscore('Awesome Phalcon'); // 'Awesome_Phalcon'
```

### `upper`

```php
final public static function upper(
    string $text, 
    string $encoding = 'UTF-8'
): string
```

Convierte una cadena a mayúscula. Este método intentará usar métodos proporcionados por la extensión `mbstring` y usar el equivalente PHP como alternativa. El último parámetro es la codificación que usarán los métodos `mbstring`. Por defecto `UTF-8`.

```php
<?php

use Phalcon\Helper\Str;

echo Str::upper('phalcon framework'); // PHALCON FRAMEWORK
```
