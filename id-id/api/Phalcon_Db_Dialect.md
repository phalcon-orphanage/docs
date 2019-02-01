---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Db\Dialect'
---
# Abstract class **Phalcon\Db\Dialect**

*implements* [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/dialect.zep)

This is the base class to each database dialect. This implements common methods to transform intermediate code into its RDBMS related syntax

## Metode

publik**fungsitampilanregistrasi**(*tercampur*$name,*tercampur*$customFunction)

Mendaftarkan fungsi SQL ubahsuaian

publik**dapatkanfungsitampilan**()

Mengembalikan fungsi yang terdaftar

final publik**skemapelarian**(*tercampur*$str,[*tercampur*$escapeChar])

Skema Escape

final [ublik**melarikandiri**(*tercampur*$str,[*tercampur*$escapeChar])

Pengidentifikasi melarikan diri

abstrak publik **tableExists** (*mixed* $sqlQuery, [*mixed* $number)

Menghasilkan SQL untuk LIMIT clause

```php
<?php
$sql=$dialect->batas("PILIH*DARI robot",10);
echo$sql;//PILIH*DARI robot BATAS 10
$sql=$dialect->batas("PILIH*DARI robot",[10,50]);
echo$sql;//PILIH*DARI robot BATAS 10 IMBANG 50

```

publik ** memiliki ** (* campuran*$sqlQuery)

Mengembalikan SQL yang dimodifikasi dengan klausa FOR UPDATE

```php
<?php
$sql=$dialect->untukmemperbarui("PILIH*DARI robot");
echo$sql;//PILIH*DARI robot DARI PEMBARUAN

```

publik ** memiliki ** (* campuran*$sqlQuery)

Mengembalikan SQL yang dimodifikasi dengan klausa LOCK IN SHARE MODE

```php
<?php
$sql=$dialect->Membagikunci("PILIH*DARI robot");
gema$sql;//PILIH*DARI robot KUNCI DALAM MODE MEMBAGI

```

final publik**dapatdaftarkolom**(*array*$columnList,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

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

final publik**dapatkolomsql**(*tercampur*$column,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

Selesaikan ekspresi Kolom

publik**dapatkanekspressisql**(*array*$expression,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

Mengubah representasi perantara untuk ekspresi ke dalam ekspresi sistem basis data yang valid

final publik**dapatkantabelsql**(*tercampur*$table,[*tercampur*$escapeChar])

Mengubah representasi antara skema/tabel menjadi ekspresi sistem basis data yang valid

umum**pilih**(*array*$definition)

Buat pernyataan SELECT

umum**dukungpontm=simpan**()

Memeriksa apakah platform mendukung savepoints

umum**dukungmelepaspoinsimpan**()

Memeriksa apakah platform mendukung rilis savepoints.

publik **getAll ** (* dicampur * $name)

Menghasilkan SQL untuk menciptakan savepoint baru

publik **setName** (*dicampur* $name)

Hasilkan SQL untuk melepaskan savepoint

publik **createSavepoint** (*mixed* $name)

Menghasilkan SQL untuk mengembalikan sebuah savepoint

perlindungan terakhir**dapatkanekspressiskalarsql**(*array*$expression,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

Selesaikan ekspresi Kolom

perlindungan terakhir**dapatkanobjekekspressi**(*array*$expression,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

Selesaikan ekspresi objek

perlindungan terakhir**dapatkualifikasiekspressisql**(*array*$expression,[*tercampur*$escapeChar])

Selesaikanlah ekspresi berkualitas

perlindungan terakhir**dapatkanekspressiBinariOperasiSql**(*array*$expression,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

Putuskan ekspresi operasi biner

perlindungan terakhir**dapatkanOperasiUnariEkspressiSql**(*array*$expression,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

Selesaikan ungkapan operasi unary

perlindungan terakhir**dapatfungsuPanggilanEkspressiSql**(*array*$expression,*tercampur*$escapeChar,[*tercampur*$bindCounts])

Selesaikan pemanggilan fungsi

perlindungan teralkhir**dapatDaftarEkspressiSql**(*array*$expression,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

Putuskan Daftar

perlindungan terakhir**dapatSemuaEkspressiSql**(*array*$expression,[*tercampur*$escapeChar])

Selesaikan*

perlindunga terakhir**dapatNilaiEkspressiSql**(*array*$expression,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

Selesaikan nilai CAST

perlindungan terakhir**dapatNilaiKonversiEkspressiSql**(*array*$expression,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

Selesaikan CONVERT dari pengkodean nilai

perlindungan terakhir**dapatKasusEkspressiSql**(*array*$expression,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

Selesaikan pernyataan CASE

perlindungan terakhir**dapatDariEkspressiSql**(*tercampur*$expression,[*tercampur*$escapeChar])

Selesaikan klausa FROM

perlindungan terakhir**dapatBergabungEkspressiSql**(*tercampur*$expression,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

Selesaikan klausa JOINs

perlindungan terakhir**apatDimanaEkspressiSql**(*tercampur*$expression,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

Selesaikan klausa WHERE

perlindungan terakhir**apatGrupOlehEkspressiSql**(*tercampur*$expression,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

Selesaikan klausa GROUP BY

perlindungan terkahir**dapatMempunyaiEkspressiSql**(*array*$expression,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

Selesaikan klausa GROUP BY

perlindungan terkahir**dapatPesananOlehEkspressiSql**(*array*$expression,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

Selesaikan klausa ORDER BY

perlindungan terkahir**dapatBatasEkspressiSql**(*array*$expression,[*tercampur*$escapeChar],[*tercampur*$bindCounts])

Selesaikan klausa LIMIT

perlindungan**persiapanKolomAlias**(*tercampur*$qualified,[*tercampur*$alias],[*tercampur*$escapeChar])

Siapkan kolom untuk RDBMS ini

perlindungan**Tabelpersiapan**(*tercampur*$table,[*tercampur*$schema],[*tercampur*$alias],[*tercampur*$escapeChar])

Siapkan tabel untuk RDBMS ini

perlindungan**persiapanKualifikasi**(*tercampur*$column,[*tercampur*$domain],[*tercampur*$escapeChar])

Siapkan kualifikasi untuk RDBMS ini

abstract public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **dropTable** (*mixed* $tableName, *mixed* $schemaName) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **tableExists** (*mixed* $tableName, [*mixed* $schemaName]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **viewExists** (*mixed* $viewName, [*mixed* $schemaName]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **describeColumns** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **listTables** ([*mixed* $schemaName]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **describeIndexes** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **describeReferences** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **tableOptions** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...