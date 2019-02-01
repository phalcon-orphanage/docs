---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Db\RawValue'
---
# Class **Phalcon\Db\RawValue**

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/rawvalue.zep)

Bu sınıf alıntı yapma ya da şekillendirme yapmadan saf verileri eklemeye/güncelleştirmeye izin verir.

Bir sonraki örnek MySQL now() fonksiyonunu değer olarak alanların nasıl kullanılacağını gösterir.

```php
<?php

$subscriber = new Subscribers();

$subscriber->email     = "andres@phalconphp.com";
$subscriber->createdAt = new \Phalcon\Db\RawValue("now()");

$subscriber->save();

```

## Metodlar

public **getValue** ()

Alıntı veya şekillendirme yapmadan saf değer

herkese açık **__ sırala** ()

Alıntı veya şekillendirme yapmadan saf değer

public **__construct** (*mixed* $value)

Phalcon\Db\RawValue constructor