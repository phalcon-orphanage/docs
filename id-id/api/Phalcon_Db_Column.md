---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Db\Column'
---
# Class **Phalcon\Db\Column**

*implements* [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/column.zep)

Memungkinkan untuk menentukan kolom yang akan digunakan untuk membuat atau mengubah operasi tabel

```php
<?php

use Phalcon\Db\Column as Column;

// Column definition
$column = new Column(
    "id",
    [
        "type"          => Column::TYPE_INTEGER,
        "size"          => 10,
        "unsigned"      => true,
        "notNull"       => true,
        "autoIncrement" => true,
        "first"         => true,
    ]
);

// Add column to existing table
$connection->addColumn("robots", null, $column);

```

## Constants

* bilangan bulat </ 0> ** TYPE_INTEGER </ 1></p> 

* bilangan bulat </ 0> ** TYPE_DATE </ 1></p> 

*integer* **TYPE_VARCHAR**

*integer* **TYPE_DECIMAL**

*integer* **TYPE_DATETIME**

*integer* **TYPE_CHAR**

*integer* **TYPE_TEXT**

*integer* **TYPE_FLOAT**

*integer* **TYPE_BOOLEAN**

*integer* **TYPE_DOUBLE**

*integer* **TYPE_TINYBLOB**

*integer* **TYPE_BLOB**

*integer* **TYPE_MEDIUMBLOB**

*integer* **TYPE_LONGBLOB**

*integer* **TYPE_BIGINTEGER**

*integer* **TYPE_JSON**

*integer* **TYPE_JSONB**

*integer* **TYPE_TIMESTAMP**

*integer* **BIND_PARAM_NULL**

*integer* **BIND_PARAM_INT**

*integer* **BIND_PARAM_STR**

*integer* **BIND_PARAM_BLOB**

*integer* **BIND_PARAM_BOOL**

*integer* **BIND_PARAM_DECIMAL**

*integer* **BIND_SKIP**

## Metode

publik **getNama** ()

Nama kolom

public **getSchemaName** ()

Skema yang tabelnya terkait adalah

publik **berhenti** ()

Tipe data kolom

public **getTypeReference** ()

Referensi tipe data kolom

public **getTypeValues** ()

Nilai tipe data kolom

public **getSize** ()

Ukuran kolom integer

public **getScale** ()

Skala bilangan kolom integer

public **getDefault** ()

Nilai kolom default

public **__construct** (*mixed* $name, *array* $definition)

Phalcon\Db\Column constructor

public **isUnsigned** ()

Mengembalikan true jika kolom number unsigned

public **isNotNull** ()

Tidak null

public **isPrimary** ()

Kolom adalah bagian dari primary key?

public **isAutoIncrement** ()

Kenaikan otomatis

public **isNumeric** ()

Periksa apakah kolom memiliki tipe numerik

public **isFirst** ()

Periksa apakah kolom memiliki posisi pertama dalam tabel

public *string* **getAfterPosition** ()

Periksa apakah bidang absolut pada posisi dalam tabel

public **getBindType** ()

Mengembalikan jenis penanganan bind

public static **__set_state** (*array* $data)

Restores the internal state of a Phalcon\Db\Column object

public **hasDefault** ()

Periksa apakah kolom memiliki nilai default