---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Db\Dialect\Postgresql'
---
# Class **Phalcon\Db\Dialect\Postgresql**

*extends* abstract class [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

*implements* [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/dialect/postgresql.zep)

Menghasilkan SQL spesifik database untuk RDBMS PostgreSQL

## Metode

public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

Mendapat nama kolom di PostgreSQL

public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

Menghasilkan SQL untuk menambahkan kolom ke sebuah tabel

public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn])

Menghasilkan SQL untuk memodifikasi kolom dalam sebuah tabel

umum **dropColumn** ($tableName *campuran*, *campuran* $schemaName, *campuran* $columnName)

Menghasilkan SQL untuk menghapus kolom dari sebuah tabel

public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

Menghasilkan SQL untuk menambahkan indeks ke tabel

umum **dropIndex** ($tableName *campuran*, *campuran* $schemaName, *campuran* $indexName)

Menghasilkan SQL untuk menghapus indeks dari tabel

public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

Menghasilkan SQL untuk menambahkan primary key ke sebuah tabel

umum **getProperty** (*campuran* $tableName, *campuran* $schemaName)

Menghasilkan SQL untuk menghapus primary key dari sebuah tabel

public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference)

Menghasilkan SQL untuk menambahkan indeks ke tabel

umum **dropForeignKey**(*campuran* $tableName, *mixed* $schemaName, *mixed* $referenceName)

Menghasilkan SQL untuk menghapus kunci asing dari sebuah tabel

publik **tambahkandilineJs** (*campuran* $tableName, [*campuran* $schemaName], [*campuran* $definition)

Menghasilkan SQL untuk membuat tabel

umum **truncateTable** (*campuran* $tableName, *campuran* $schemaName)

Menghasilkan SQL untuk memotong tabel

abstrak publik **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists])

Menghasilkan SQL untuk menjatuhkan tabel

publik **tambahkandilineJs** (*campuran* $viewName, [*campuran* $definition], [*campuran* $schemaName])

Menghasilkan SQL untuk membuat tampilan

publik **tambahkandilineJs** (*campuran* $viewName, [*campuran* $schemaName], [*campuran* $ifExists])

Menghasilkan SQL untuk menjatuhkan tampilan

abstrak umum **getProperty** ($tableName *campuran*, *campuran* $schemaName])

Menghasilkan pengecekan SQL untuk keberadaan skema

```php
<?php

echo $dialect->tableExists("posts", "blog");

echo $dialect->tableExists("posts");

```

abstrak umum **getProperty** ($viewName *campuran*, *campuran* $schemaName])

Menghasilkan pengecekan SQL untuk adanya skema.view

public **describColumns** (*mixed* $table, [*mixed* $schema])

Menghasilkan SQL yang menggambarkan sebuah tabel

```php
<?php

print_r(
    $dialect->describeColumns("posts")
);

```

umum **isResource** ([*campuran* $schemaName])

Daftar semua tabel di database

```php
<?php

print_r(
    $dialect->listTables("blog")
);

```

umum *string* **listViews** ([*string* $schemaName])

Menghasilkan SQL untuk menampilkan semua tampilan skema atau pengguna

public **describeIndexes** (*mixed* $table, [*mixed* $schema])

Menghasilkan SQL untuk query indeks di atas meja

umum **describeReferences** (*campuran* $table, [*campuran* $schema])

Menghasilkan SQL untuk query kunci asing di atas meja

public **tableOptions** (*mixed* $table, [*mixed* $schema])

Menghasilkan SQL untuk menjelaskan pilihan pembuatan tabel

protected **_castDefault** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

...

protected **_getTableOptions** (*array* $definition)

...

public **registerCustomFunction** (*mixed* $name, *mixed* $customFunction) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Mendaftarkan fungsi SQL ubahsuaian

public **getCustomFunctions** () inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Mengembalikan fungsi yang terdaftar

final public **escapeSchema** (*mixed* $str, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Skema Escape

final public **escape** (*mixed* $str, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Pengidentifikasi melarikan diri

public **limit** (*mixed* $sqlQuery, *mixed* $number) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Menghasilkan SQL untuk LIMIT clause

```php
<?php
$sql=$dialect->batas("PILIH*DARI robot",10);
echo$sql;//PILIH*DARI robot BATAS 10
$sql=$dialect->batas("PILIH*DARI robot",[10,50]);
echo$sql;//PILIH*DARI robot BATAS 10 IMBANG 50

```

public **forUpdate** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Mengembalikan SQL yang dimodifikasi dengan klausa FOR UPDATE

```php
<?php
$sql=$dialect->untukmemperbarui("PILIH*DARI robot");
echo$sql;//PILIH*DARI robot DARI PEMBARUAN

```

public **sharedLock** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Mengembalikan SQL yang dimodifikasi dengan klausa LOCK IN SHARE MODE

```php
<?php
$sql=$dialect->Membagikunci("PILIH*DARI robot");
gema$sql;//PILIH*DARI robot KUNCI DALAM MODE MEMBAGI

```

final public **getColumnList** (*array* $columnList, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Mendapat daftar kolom dengan pengenal yang lolos

```php
<?php
gema$dialect=>dapatdaftarkolom(
[
"kolom1",
"kolom",
]
);

```

final public **getSqlColumn** (*mixed* $column, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikan ekspresi Kolom

public **getSqlExpression** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Mengubah representasi perantara untuk ekspresi ke dalam ekspresi sistem basis data yang valid

final public **getSqlTable** (*mixed* $table, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Mengubah representasi antara skema/tabel menjadi ekspresi sistem basis data yang valid

public **select** (*array* $definition) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Buat pernyataan SELECT

public **supportsSavepoints** () inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Memeriksa apakah platform mendukung savepoints

public **supportsReleaseSavepoints** () inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Memeriksa apakah platform mendukung rilis savepoints.

public **createSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Menghasilkan SQL untuk menciptakan savepoint baru

public **releaseSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Hasilkan SQL untuk melepaskan savepoint

public **rollbackSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Menghasilkan SQL untuk mengembalikan sebuah savepoint

final protected **getSqlExpressionScalar** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikan ekspresi Kolom

final protected **getSqlExpressionObject** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikan ekspresi objek

final protected **getSqlExpressionQualified** (*array* $expression, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikanlah ekspresi berkualitas

final protected **getSqlExpressionBinaryOperations** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Putuskan ekspresi operasi biner

final protected **getSqlExpressionUnaryOperations** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikan ungkapan operasi unary

final protected **getSqlExpressionFunctionCall** (*array* $expression, *mixed* $escapeChar, [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikan pemanggilan fungsi

final protected **getSqlExpressionList** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Putuskan Daftar

final protected **getSqlExpressionAll** (*array* $expression, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikan*

final protected **getSqlExpressionCastValue** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikan nilai CAST

final protected **getSqlExpressionConvertValue** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikan CONVERT dari pengkodean nilai

final protected **getSqlExpressionCase** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikan pernyataan CASE

final protected **getSqlExpressionFrom** (*mixed* $expression, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikan klausa FROM

final protected **getSqlExpressionJoins** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikan klausa JOINs

final protected **getSqlExpressionWhere** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikan klausa WHERE

final protected **getSqlExpressionGroupBy** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikan klausa GROUP BY

final protected **getSqlExpressionHaving** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikan klausa GROUP BY

final protected **getSqlExpressionOrderBy** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikan klausa ORDER BY

final protected **getSqlExpressionLimit** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Selesaikan klausa LIMIT

protected **prepareColumnAlias** (*mixed* $qualified, [*mixed* $alias], [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Siapkan kolom untuk RDBMS ini

protected **prepareTable** (*mixed* $table, [*mixed* $schema], [*mixed* $alias], [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Siapkan tabel untuk RDBMS ini

protected **prepareQualified** (*mixed* $column, [*mixed* $domain], [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Siapkan kualifikasi untuk RDBMS ini