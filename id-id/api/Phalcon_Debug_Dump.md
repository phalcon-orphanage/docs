---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Debug\Dump'
---
# Class **Phalcon\Debug\Dump**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/debug/dump.zep)

Informasi tentang variabel(s)

```php
<?php

$foo = 123;

echo (new \Phalcon\Debug\Dump())->variable($foo, "foo");

```

```php
<?php

$foo = "string";
$bar = ["key" => "value"];
$baz = new stdClass();

echo (new \Phalcon\Debug\Dump())->variables($foo, $bar, $baz);

```

## Metode

umum **getDetailed** ()

...

umum **setDetailed** (*campuran* $detil)

...

umum **__construct** ([*array* $gaya], [*campuran* $rinci])

Phalcon\Debug\Dump constructor

umum **semua** ()

Alias dari variabel-variabel() metode

protected **getStyle** (*mixed* $type)

Mendapat gaya untuk jenis

public **setStyles** ([*array* $styles])

Atur gaya untuk jenis vars

public **one** (*mixed* $variable, [*mixed* $name])

Nama lain dari metode variable()

protected **output** (*mixed* $variable, [*mixed* $name], [*mixed* $tab])

Siapkan sebuah HTML string dari informasi tentang sebuah variable tunggal.

public **variable** (*mixed* $variable, [*mixed* $name])

Mengembalikan sebuah HTML string dari informasi tentang sebuah variable tunggal.

```php
<?php

echo (new \Phalcon\Debug\Dump())->variable($foo, "foo");

```

public **variables** ()

Mengembalikan sebuah HTML string dari informasi debuging tentang jumlah apapun dari variable, masing-masing dibungkus dalam sebuah "pre" tag.

```php
<?php

$foo = "string";
$bar = ["key" => "value"];
$baz = new stdClass();

echo (new \Phalcon\Debug\Dump())->variables($foo, $bar, $baz);

```

public **toJson** (*mixed* $variable)

Mengembalikan sebuah JSON string dari informasi tentang sebuah variable tunggal.

```php
<?php

$foo = [
    "key" => "value",
];

echo (new \Phalcon\Debug\Dump())->toJson($foo);

$foo = new stdClass();
$foo->bar = "buz";

echo (new \Phalcon\Debug\Dump())->toJson($foo);

```