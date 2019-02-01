---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Debug\Dump'
---
# Class **Phalcon\Debug\Dump**

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/debug/dump.zep)

Dumps information about a variable(s)

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

## Metodlar

public **getDetailed** ()

...

public **setDetailed** (*mixed* $detailed)

...

public **__construct** ([*array* $styles], [*mixed* $detailed])

Phalcon\Debug\Dump constructor

public **all** ()

Değişkenlerin diğer adları () yöntemi

protected **getStyle** (*mixed* $type)

Yazı tipi elde elde et

genel **setStyles** ([*array* $styles])

Vars türü için stilleri ayarlar

genel **one** (*mixed* $variable, [*mixed* $name])

Değişken metodunun diğer adları

protected **output** (*mixed* $variable, [*mixed* $name], [*mixed* $tab])

Bir değişkenle ilgili olan HTML satırını haırlar.

public **variable** (*mixed* $variable, [*mixed* $name])

Bir değişkenle ilgili olan HTML satırını geri getirir.

```php
<?php

echo (new \Phalcon\Debug\Dump())->variable($foo, "foo");

```

public **variables** ()

Her biri bir "ön" etiket içine sarılmış, herhangi bir sayıda değişken hakkında hata ayıklama bilgisi içeren bir HTML dizesini geri getirir.

```php
<?php

$foo = "string";
$bar = ["key" => "value"];
$baz = new stdClass();

echo (new \Phalcon\Debug\Dump())->variables($foo, $bar, $baz);

```

public **toJson** (*mixed* $variable)

Tek bir değişkene ilişkin bilgilerini JSON satırını döndürür.

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