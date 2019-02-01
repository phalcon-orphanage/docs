---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Text'
---
# Abstract class **Phalcon\Text**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/text.zep)

Menyediakan utilitas untuk bekerja dengan teks

## Constants

*integer* **RANDOM_ALNUM**

*integer* **RANDOM_ALPHA**

*integer* **RANDOM_HEXDEC**

*integer* **RANDOM_NUMERIC**

*integer* **RANDOM_NOZERO**

*integer* **RANDOM_DISTINCT**

## Metode

public static **camelize** (*mixed* $str, [*mixed* $delimiter])

Mengkoversikan gaya ke string

```php
<?php

echo Phalcon\Text::camelize("coco_bongo"); // CocoBongo
echo Phalcon\Text::camelize("co_co-bon_go", "-"); // Co_coBon_go
echo Phalcon\Text::camelize("co_co-bon_go", "_-"); // CoCoBonGo

```

public static **uncamelize** (*mixed* $str, [*mixed* $delimiter])

Uncamelize deretan yang dikemudikan

```php
<?php

echo Phalcon\Text::uncamelize("CocoBongo"); // coco_bongo
echo Phalcon\Text::uncamelize("CocoBongo", "-"); // coco-bongo

```

public static **increment** (*mixed* $str, [*mixed* $separator])

Menambahkan sebuah nomor ke sebuah string atau menaikan nomor itu jika sudah didefinisikan

```php
<?php

echo Phalcon\Text::increment("a"); // "a_1"
echo Phalcon\Text::increment("a_1"); // "a_2"

```

public static **random** ([*mixed* $type], [*mixed* $length])

Generates a random string based on the given type. Type is one of the RANDOM_* constants

```php
<?php

use Phalcon\Text;

// "aloiwkqz"
echo Text::random(Text::RANDOM_ALNUM);

```

public static **startsWith** (*mixed* $str, *mixed* $start, [*mixed* $ignoreCase])

Periksa apakah deretan dimulai dengan deretan yang diberikan

```php
<?php

echo Phalcon\Text::startsWith("Hello", "He"); // true
echo Phalcon\Text::startsWith("Hello", "he", false); // false
echo Phalcon\Text::startsWith("Hello", "he"); // true

```

public static **endsWith** (*mixed* $str, *mixed* $end, [*mixed* $ignoreCase])

Periksa apakah deretan diakhiri dengan deretan yang diberikan

```php
<?php

echo Phalcon\Text::endsWith("Hello", "llo"); // true
echo Phalcon\Text::endsWith("Hello", "LLO", false); // false
echo Phalcon\Text::endsWith("Hello", "LLO"); // true

```

public static **lower** (*mixed* $str, [*mixed* $encoding])

Turunkan deretan, fungsi ini memanfaatkan ekstensi mbderetan jika tersedia

```php
<?php

echo Phalcon\Text::lower("HELLO"); // hello

```

public static **upper** (*mixed* $str, [*mixed* $encoding])

Mengisi sebuah deretan, fungsi ini memanfaatkan ekstensi deretan jika tersedia

```php
<?php

echo Phalcon\Text::upper("hello"); // HELLO

```

public static **reduceSlashes** (*mixed* $str)

Mengurangi beberapa garis miring dalam deretan menjadi satu garis miring

```php
<?php

echo Phalcon\Text::reduceSlashes("foo//bar/baz"); // foo/bar/baz
echo Phalcon\Text::reduceSlashes("https://foo.bar///baz/buz"); // https://foo.bar/baz/buz

```

public static **concat** ()

Persatukan deretan menggunakan pemisah hanya satu kali tanpa duplikasi di tempat penggabungan

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

public static **dynamic** (*mixed* $text, [*mixed* $leftDelimiter], [*mixed* $rightDelimiter], [*mixed* $separator])

Menghasilkan teks acak sesuai dengan contoh

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

public static **underscore** (*mixed* $text)

Membuat sebuah frase menggarisbawahi bukan spasi

```php
<?php

echo Phalcon\Text::underscore("look behind"); // "look_behind"
echo Phalcon\Text::underscore("Awesome Phalcon"); // "Awesome_Phalcon"

```

public static **humanize** (*mixed* $text)

Membuat sebuah frase yang digarisbawahi atau putus-putus yang bisa dibaca manusia

```php
<?php

echo Phalcon\Text::humanize("start-a-horse"); // "start a horse"
echo Phalcon\Text::humanize("five_cats"); // "five cats"

```