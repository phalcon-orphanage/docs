---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Query\Lang'
---
# Abstract class **Phalcon\Mvc\Model\Query\Lang**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/query/lang.zep)

PHQL diimplementasikan sebagai parser (ditulis dalam C) yang menerjemahkan sintaks dari target RDBMS. Hal ini memungkinkan Phalcon untuk menawarkan bahasa SQL terpadu pengembang, sementara secara internal melakukan semua pekerjaan menerjemahkan PHQL instruksi ke petunjuk SQL yang paling optimal tergantung pada Tipe RDBMS berhubungan dengan model.

Untuk mencapai performa setinggi mungkin, kami menulis sebuah parser yang menggunakan teknologi yang sama seperti SQLite. Teknologi ini menyediakan memori kecil parser dengan tapak memori yang sangat rendah itu juga thread-safe.

```php
<?php

$intermediate = Phalcon\Mvc\Model\Query\Lang::parsePHQL("SELECT r.* FROM Robots r LIMIT 10");

```

## Metode

public static *string* **parsePHQL** (*string* $phql)

Mengurai pernyataan PHQL yang mengembalikan representasi menengah (IR)