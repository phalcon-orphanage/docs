---
layout: default
language: 'en'
version: '4.0'
title: 'Phalcon\Text'
---

* [Phalcon\Text](#text)
        
<h1 id="text">Class Phalcon\Text</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Text.zep)

| Namespace  | Phalcon |
| Uses       | Phalcon\Helper\Str |

Provides utilities to work with texts


## Constants
```php
const RANDOM_ALNUM = 0;
const RANDOM_ALPHA = 1;
const RANDOM_DISTINCT = 5;
const RANDOM_HEXDEC = 2;
const RANDOM_NOZERO = 4;
const RANDOM_NUMERIC = 3;
```

## Methods
```php
public static function camelize( string $text, mixed $delimiter = null ): string;
```
Converts strings to camelize style

```php
echo Phalcon\Text::camelize("coco_bongo"); // CocoBongo
echo Phalcon\Text::camelize("co_co-bon_go", "-"); // Co_coBon_go
echo Phalcon\Text::camelize("co_co-bon_go", "_-"); // CoCoBonGo
```


```php
public static function concat(): string;
```
Concatenates strings using the separator only once without duplication in
places concatenation

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
Generates random text in accordance with the template

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
Check if a string ends with a given string

```php
echo Phalcon\Text::endsWith("Hello", "llo"); // true
echo Phalcon\Text::endsWith("Hello", "LLO", false); // false
echo Phalcon\Text::endsWith("Hello", "LLO"); // true
```


```php
public static function humanize( string $text ): string;
```
Makes an underscored or dashed phrase human-readable

```php
echo Phalcon\Text::humanize("start-a-horse"); // "start a horse"
echo Phalcon\Text::humanize("five_cats"); // "five cats"
```


```php
public static function increment( string $text, string $separator = string ): string;
```
Adds a number to a string or increment that number if it already is
defined

```php
echo Phalcon\Text::increment("a"); // "a_1"
echo Phalcon\Text::increment("a_1"); // "a_2"
```


```php
public static function lower( string $text, string $encoding = string ): string;
```
Lowercases a string, this function makes use of the mbstring extension if
available

```php
echo Phalcon\Text::lower("HELLO"); // hello
```


```php
public static function random( int $type = int, long $length = int ): string;
```
Generates a random string based on the given type. Type is one of the
RANDOM_* constants

```php
use Phalcon\Text;

// "aloiwkqz"
echo Text::random(Text::RANDOM_ALNUM);
```


```php
public static function reduceSlashes( string $text ): string;
```
Reduces multiple slashes in a string to single slashes

```php
// foo/bar/baz
echo Phalcon\Text::reduceSlashes("foo//bar/baz");

// http://foo.bar/baz/buz
echo Phalcon\Text::reduceSlashes("http://foo.bar///baz/buz");
```


```php
public static function startsWith( string $text, string $start, bool $ignoreCase = bool ): bool;
```
Check if a string starts with a given string

```php
echo Phalcon\Text::startsWith("Hello", "He"); // true
echo Phalcon\Text::startsWith("Hello", "he", false); // false
echo Phalcon\Text::startsWith("Hello", "he"); // true
```


```php
public static function uncamelize( string $text, mixed $delimiter = null ): string;
```
Uncamelize strings which are camelized

```php
echo Phalcon\Text::uncamelize("CocoBongo"); // coco_bongo
echo Phalcon\Text::uncamelize("CocoBongo", "-"); // coco-bongo
```


```php
public static function underscore( string $text ): string;
```
Makes a phrase underscored instead of spaced

```php
echo Phalcon\Text::underscore("look behind"); // "look_behind"
echo Phalcon\Text::underscore("Awesome Phalcon"); // "Awesome_Phalcon"
```


```php
public static function upper( string $text, string $encoding = string ): string;
```
Uppercases a string, this function makes use of the mbstring extension if
available

```php
echo Phalcon\Text::upper("hello"); // HELLO
```


