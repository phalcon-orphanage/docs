---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Db\RawValue'
---
# Class **Phalcon\Db\RawValue**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/rawvalue.zep)

Kelas ini memungkinkan untuk memasukkan / memperbarui data mentah tanpa mengutip atau memformat.

Contoh berikut menunjukkan bagaimana menggunakan MySQL now () berfungsi sebagai field value.

```php
<?php

$subscriber = pelanggan baru();

$subscriber->email     = "andres@phalconphp.com";
$subscriber->createdAt = baru \Phalcon\Db\RawValue("now()");

$subscriber->menyimpan();

```

## Metode

publik **getValue** ()

Nilai mentah tanpa mengutip atau format

publik **__keString** ()

Nilai mentah tanpa mengutip atau format

publik **__construct** (*mixed* $value)

Phalcon\Db\RawValue constructor