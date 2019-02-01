---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Query'
---
# Class **Phalcon\Mvc\Model\Query**

*implements* [Phalcon\Mvc\Model\QueryInterface](Phalcon_Mvc_Model_QueryInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/query.zep)

Kelas ini mengambil representasi antara PHQL dan mengeksekusinya.

```php
<?php

$phql = "SELECT c.price*0.16 AS taxes, c.* FROM Cars AS c JOIN Brands AS b
         WHERE b.name = :name: ORDER BY c.name";

$result = $manager->executeQuery(
    $phql,
    [
        "name" => "Lamborghini",
    ]
);

foreach ($result as $row) {
    echo "Name: ",  $row->cars->name, "\n";
    echo "Price: ", $row->cars->price, "\n";
    echo "Taxes: ", $row->taxes, "\n";
}

```

## Constants

*integer* **TYPE_SELECT**

*integer* **TYPE_INSERT**

*integer* **TYPE_UPDATE**

*integer* **TYPE_DELETE**

## Metode

public **__construct** ([*string* $phql], [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector], [*mixed* $options])

Phalcon\Mvc\Model\Query constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Menetapkan ketergantungan injeksi wadah

publik **mendapatkanDI** ()

Kembali wadah injeksi ketergantungan

public **setUniqueRow** (*mixed* $uniqueRow)

Memberi tahu permintaan jika hanya baris pertama di resultset yang harus dikembalikan

public **getUniqueRow** ()

Periksa apakah kueri diprogram untuk mendapatkan hanya baris pertama di resultset

final protected **_getQualified** (*array* $expr)

Ganti nama model menjadi nama sumbernya dengan ekspresi nama yang memenuhi syarat

final protected **_getCallArgument** (*array* $argument)

Mengeksploitasi sebuah ekspresi dalam satu argumen panggilan

final protected **_getCaseExpression** (*array* $expr)

Mengeksploitasi sebuah ekspresi dalam satu argumen panggilan

final protected **_getFunctionCall** (*array* $expr)

Mengeksploitasi sebuah ekspresi dalam satu argumen panggilan

final protected *string* **_getExpression** (*array* $expr, [*boolean* $quoting])

Selesaikan ungkapan dari kode perantara menjadi string

final protected **_getSelectColumn** (*array* $column)

Selesaikan sebuah kolom dari representasi menengahnya menjadi sebuah array yang digunakan untuk menentukan apakah resultet yang dihasilkan sederhana atau kompleks

final protected *string* **_getTable** ([Phalcon\Mvc\Model\ManagerInterface](Phalcon_Mvc_Model_ManagerInterface) $manager, *array* $qualifiedName)

Menyelesaikan sebuah tabel dalam sebuah pernyataan SELECT memeriksa apakah model yang ada

final protected **_getJoin** ([Phalcon\Mvc\Model\ManagerInterface](Phalcon_Mvc_Model_ManagerInterface) $manager, *mixed* $join)

Menyelesaikan BERGABUNG klausul memeriksa jika dikaitkan model ada

final protected *string* **_getJoinType** (*array* $join)

Menyelesaikan BERGABUNG tipe

final protected *array* **_getSingleJoin** (*string* $joinType, *string* $joinSource, *string* $modelAlias, *string* $joinAlias, [Phalcon\Mvc\Model\RelationInterface](Phalcon_Mvc_Model_RelationInterface) $relation)

Mengatasi bergabung dengan melibatkan memiliki-satu/milik-memiliki-banyak hubungan

final protected *array* **_getMultiJoin** (*string* $joinType, *string* $joinSource, *string* $modelAlias, *string* $joinAlias, [Phalcon\Mvc\Model\RelationInterface](Phalcon_Mvc_Model_RelationInterface) $relation)

Menyelesaikan bergabung melibatkan banyak-ke-banyak hubungan

final protected *array* **_getJoins** (*array* $select)

Proses Bergabung dalam permintaan kembali sebuah representasi internal untuk database dialek

final protected *array* **_getOrderClause** (*array* | *string* $order)

Kembali diproses agar klausul untuk MEMILIH pernyataan

final protected **_getGroupClause** (*array* $group)

Kembali diproses kelompok klausul untuk MEMILIH pernyataan

final protected **_getLimitClause** (*array* $limitClause)

Kembali diproses membatasi klausul untuk MEMILIH pernyataan

final protected **_prepareSelect** ([*mixed* $ast], [*mixed* $merge])

Analyzes a SELECT intermediate code and produces an array to be executed later

final protected **_prepareInsert** ()

Analisis MENYISIPKAN kode menengah dan menghasilkan sebuah array yang akan dieksekusi nanti

final protected **_prepareUpdate** ()

Analisis UPDATE kode menengah dan menghasilkan sebuah array yang akan dieksekusi nanti

final protected **_prepareDelete** ()

Analisis HAPUS kode menengah dan menghasilkan sebuah array yang akan dieksekusi nanti

public **parse** ()

Parses the intermediate code produced by Phalcon\Mvc\Model\Query\Lang generating another intermediate representation that could be executed by Phalcon\Mvc\Model\Query

public **getCache** ()

Kembali saat ini cache backend contoh

final protected **_executeSelect** (*mixed* $intermediate, *mixed* $bindParams, *mixed* $bindTypes, [*mixed* $simulate])

Executes the SELECT intermediate representation producing a Phalcon\Mvc\Model\Resultset

final protected [Phalcon\Mvc\Model\Query\StatusInterface](Phalcon_Mvc_Model_Query_StatusInterface) **_executeInsert** (*array* $intermediate, *array* $bindParams, *array* $bindTypes)

Executes the INSERT intermediate representation producing a Phalcon\Mvc\Model\Query\Status

final protected [Phalcon\Mvc\Model\Query\StatusInterface](Phalcon_Mvc_Model_Query_StatusInterface) **_executeUpdate** (*array* $intermediate, *array* $bindParams, *array* $bindTypes)

Executes the UPDATE intermediate representation producing a Phalcon\Mvc\Model\Query\Status

final protected [Phalcon\Mvc\Model\Query\StatusInterface](Phalcon_Mvc_Model_Query_StatusInterface) **_executeDelete** (*array* $intermediate, *array* $bindParams, *array* $bindTypes)

Executes the DELETE intermediate representation producing a Phalcon\Mvc\Model\Query\Status

final protected [Phalcon\Mvc\Model\ResultsetInterface](Phalcon_Mvc_Model_ResultsetInterface) **_getRelatedRecords** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *array* $intermediate, *array* $bindParams, *array* $bindTypes)

Query catatan yang UPDATE/MENGHAPUS operasi juga dapat dilakukan

public *mixed* **execute** ([*array* $bindParams], [*array* $bindTypes])

Mengeksekusi diurai PHQL pernyataan

public [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) **getSingleResult** ([*array* $bindParams], [*array* $bindTypes])

Mengeksekusi query kembali hasil pertama

publik **perangkat Tipe** (*dicampur* $type)

Menetapkan jenis PHQL pernyataan yang akan dieksekusi

publik **berhenti** ()

Mendapat jenis pernyataan PHQL yang dieksekusi

public **setBindParams** (*array* $bindParams, [*mixed* $merge])

Tetapkan parameter bind default

public *array* **getBindParams** ()

Mengembalikan default mengikat params

public **setBindTypes** (*array* $bindTypes, [*mixed* $merge])

Tetapkan parameter bind default

public **setSharedLock** ([*mixed* $sharedLock])

Setel klausa SHARED LOCK

public *array* **getBindTypes** ()

Returns default bind types

public **setIntermediate** (*array* $intermediate)

Allows to set the IR to be executed

public *array* **getIntermediate** ()

Returns the intermediate representation of the PHQL statement

public **cache** (*mixed* $cacheOptions)

Menetapkan parameter cache query

public **getCacheOptions** ()

Mengembalikan opsi cache saat ini

public **getSql** ()

Mengembalikan SQL yang akan dihasilkan oleh PHQL internal (hanya bekerja pada pernyataan SELECT)

public static **clean** ()

Hancurkan cache PHQL internal