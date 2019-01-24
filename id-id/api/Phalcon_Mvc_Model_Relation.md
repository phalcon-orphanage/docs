---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Relation'
---
# Class **Phalcon\Mvc\Model\Relation**

*implements* [Phalcon\Mvc\Model\RelationInterface](Phalcon_Mvc_Model_RelationInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/relation.zep)

Kelas ini mewakili hubungan antara dua model

## Constants

*integer* **BELONGS_TO**

*integer* **HAS_ONE**

*integer* **HAS_MANY**

*integer* **HAS_ONE_THROUGH**

*integer* **HAS_MANY_THROUGH**

*integer* **NO_ACTION**

*integer* **ACTION_RESTRICT**

*integer* **ACTION_CASCADE**

## Metode

public **__construct** (*int* $type, *string* $referencedModel, *string* | *array* $fields, *string* | *array* $referencedFields, [*array* $options])

Phalcon\Mvc\Model\Relation constructor

public **setIntermediateRelation** (*string* | *array* $intermediateFields, *string* $intermediateModel, *string* $intermediateReferencedFields)

Menetapkan data model perantara untuk memiliki hubungan-*-melalui

publik **berhenti** ()

Mengembalikan tipe relasi

public **getReferencedModel** ()

Mengembalikan model yang direferensikan

public *string* | *array* **getFields** ()

Mengembalikan field

public *string* | *array* **getReferencedFields** ()

Mengembalikan field yang direferensikan

public *string* | *array* **getOptions** ()

Mengembalikan pilihannya

public **getOption** (*mixed* $name)

Mengembalikan opsi dengan nama yang ditentukan Jika pilihan tidak ada null dikembalikan

public **isForeignKey** ()

Periksa apakah hubungan tersebut bertindak sebagai foreign key

public *string* | *array* **getForeignKey** ()

Mengembalikan konfigurasi kunci asing

publik *array* **MendapatkanParams** ()

Mengembalikan parameter yang harus selalu digunakan saat record terkait diperoleh

public **isThrough** ()

Periksa apakah hubungan itu adalah hubungan 'banyak-ke-banyak' atau tidak

public **isReusable** ()

Periksa apakah catatan yang dikembalikan dengan mendapatkan milik-ke/has-banyak secara implisit di-cache selama permintaan saat ini

public *string* | *array* **getIntermediateFields** ()

Mendapat bidang perantara untuk memiliki hubungan-*-melalui

public **getIntermediateModel** ()

Mendapat model perantara untuk memiliki hubungan-*-through

public *string* | *array* **getIntermediateReferencedFields** ()

Miliki bidang yang dirujuk menengah untuk memiliki hubungan-*-melalui