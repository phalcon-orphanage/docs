# Abstract class **Phalcon\\Text**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/text.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Provides utilities to work with texts


## Constants
*integer* **RANDOM_ALNUM**

*integer* **RANDOM_ALPHA**

*integer* **RANDOM_HEXDEC**

*integer* **RANDOM_NUMERIC**

*integer* **RANDOM_NOZERO**

## Methods
public static  **camelize** (*mixed* $str, [*mixed* $delimiter])

Converts strings to camelize style

```php
<?php

echo Phalcon\Text::camelize("coco_bongo"); // CocoBongo
echo Phalcon\Text::camelize("co_co-bon_go", "-"); // Co_coBon_go
echo Phalcon\Text::camelize("co_co-bon_go", "_-"); // CoCoBonGo

```



public static  **uncamelize** (*mixed* $str, [*mixed* $delimiter])

Uncamelize strings which are camelized

```php
<?php

echo Phalcon\Text::uncamelize("CocoBongo"); // coco_bongo
echo Phalcon\Text::uncamelize("CocoBongo", "-"); // coco-bongo

```



public static  **increment** (*mixed* $str, [*mixed* $separator])

Adds a number to a string or increment that number if it already is defined

```php
<?php

echo Phalcon\Text::increment("a"); // "a_1"
echo Phalcon\Text::increment("a_1"); // "a_2"

```



public static  **random** ([*mixed* $type], [*mixed* $length])

Generates a random string based on the given type. Type is one of the RANDOM_* constants

```php
<?php

// "aloiwkqz"
echo Phalcon\Text::random(
    Phalcon\Text::RANDOM_ALNUM
);

```



public static  **startsWith** (*mixed* $str, *mixed* $start, [*mixed* $ignoreCase])

Check if a string starts with a given string

```php
<?php

echo Phalcon\Text::startsWith("Hello", "He"); // true
echo Phalcon\Text::startsWith("Hello", "he", false); // false
echo Phalcon\Text::startsWith("Hello", "he"); // true

```



public static  **endsWith** (*mixed* $str, *mixed* $end, [*mixed* $ignoreCase])

Check if a string ends with a given string

```php
<?php

echo Phalcon\Text::endsWith("Hello", "llo"); // true
echo Phalcon\Text::endsWith("Hello", "LLO", false); // false
echo Phalcon\Text::endsWith("Hello", "LLO"); // true

```



public static  **lower** (*mixed* $str, [*mixed* $encoding])

Lowercases a string, this function makes use of the mbstring extension if available

```php
<?php

echo Phalcon\Text::lower("HELLO"); // hello

```



public static  **upper** (*mixed* $str, [*mixed* $encoding])

Uppercases a string, this function makes use of the mbstring extension if available

```php
<?php

echo Phalcon\Text::upper("hello"); // HELLO

```



public static  **reduceSlashes** (*mixed* $str)

Reduces multiple slashes in a string to single slashes

```php
<?php

echo Phalcon\Text::reduceSlashes("foo//bar/baz"); // foo/bar/baz
echo Phalcon\Text::reduceSlashes("http://foo.bar///baz/buz"); // http://foo.bar/baz/buz

```



public static  **concat** ()

Concatenates strings using the separator only once without duplication in places concatenation

```php
<?php

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



public static  **dynamic** (*mixed* $text, [*mixed* $leftDelimiter], [*mixed* $rightDelimiter], [*mixed* $separator])

Generates random text in accordance with the template

```php
<?php

// Hi my name is a Bob
echo Phalcon\Text::dynamic("{Hi|Hello}, my name is a {Bob|Mark|Jon}!");

// Hi my name is a Jon
echo Phalcon\Text::dynamic("{Hi|Hello}, my name is a {Bob|Mark|Jon}!");

// Hello my name is a Bob
echo Phalcon\Text::dynamic("{Hi|Hello}, my name is a {Bob|Mark|Jon}!");

// Hello my name is a Zyxep
echo Phalcon\Text::dynamic("[Hi/Hello], my name is a [Zyxep/Mark]!", "[", "]", "/");

```



public static  **underscore** (*mixed* $text)

Makes a phrase underscored instead of spaced

```php
<?php

echo Phalcon\Text::underscore("look behind"); // "look_behind"
echo Phalcon\Text::underscore("Awesome Phalcon"); // "Awesome_Phalcon"

```



public static  **humanize** (*mixed* $text)

Makes an underscored or dashed phrase human-readable

```php
<?php

echo Phalcon\Text::humanize("start-a-horse"); // "start a horse"
echo Phalcon\Text::humanize("five_cats"); // "five cats"

```



