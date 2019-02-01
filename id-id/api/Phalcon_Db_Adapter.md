---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Db\Adapter'
---
# Abstract class **Phalcon\Db\Adapter**

*implements* [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/adapter.zep)

Base class for Phalcon\Db adapters

## Metode

umum **getDialectType** ()

Nama dialek yang digunakan

publik **berhenti** ()

Jenis sistem database adaptor yang digunakan untuk

umum **getSqlVariables** ()

Parameter parameter terikat Active SQL

umum **__construct** (*array* $descriptor)

Phalcon\Db\Adapter constructor

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Menyetel pengelola acara

publik **getEventsManager** ()

Mengembalikan manajer acara internal

public **setDialect** ([Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface) $dialect)

Set dialek yang digunakan untuk menghasilkan SQL

umum **getDialect** ()

Pengembalian internal dialek contoh

umum **fetchOne** (*campuran* $sqlQuery, [*campuran* $fetchMode], [*campuran* $bindParams], [*campuran* $bindTypes])

Kembali baris pertama pada hasil query SQL

```php
<? php

// mendapatkan pertama robot$robot = $connection->fetchOne("Pilih * dari robot"); print_r($robot);

// Mendapatkan pertama robot dengan asosiatif indeks hanya
$robot = $connection->fetchOne("Pilih * dari robot", \Phalcon\Db::FETCH_ASSOC); print_r($robot);

```

umum *array* **fetchAll** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes])

Dumps lengkap hasil query ke dalam sebuah array

```php
<? php / / mendapatkan semua robot dengan asosiatif indeks hanya$robots = $connection -> fetchAll ("Pilih * dari robot", \Phalcon\Db::FETCH_ASSOC);  foreach ($robots sebagai $robot) {print_r($robot);}   Mendapatkan semua robot yang mengandung kata "robot" withing $robots nama = $connection -> fetchAll ("Pilih * dari robot yang mana nama seperti: nama", \Phalcon\Db::FETCH_ASSOC, ["name" = > "%robot%"]); foreach ($robots sebagai $robot) {print_r($robot);}

```

umum *string* | **fetchColumn** (*string* $sqlQuery, [*array* $placeholders], [*int* | *string* $column])

Kembali n'th bidang baris pertama pada hasil query SQL

```php
<? php

/ / mendapatkan jumlah robot$robotsCount = $connection->fetchColumn ("PILIH count(*) DARI robot");
print_r($robotsCount); 

// Mendapatkan nama terakhir diedit robot $robot = $connection->fetchColumn(  "PILIH id, nama DARI robot diurutkan dimodifikasi desc",
 1
);
print_r($robot);

```

umum *boolean* **memasukkan** (*string* | *array* $table, *array* $values, [*array* $fields], [*array* $dataTypes])

Memasukkan data ke dalam tabel menggunakan sintaks RDBMS SQL kustom

```php
<? php / / memasukkan$success robot baru = $connection -> insert ("robot", ["Astro Boy", 1952], ["name", "tahun"]);  Kalimat SQL berikutnya akan dikirim ke sistem database INSERT INTO 'robot' ('nama', 'tahun') nilai ("Astro boy", 1952);

```

umum *boolean* **insertAsDict** (*string* $table, *array* $data, [*array* $dataTypes])

Memasukkan data ke dalam tabel menggunakan kustom sintaks RBDM SQL

```php
<? php / / memasukkan$success robot baru = $connection -> insertAsDict ("robot", ["name" = > "Astro Boy", "tahun" = > 1952,]);  Kalimat SQL berikutnya akan dikirim ke sistem database INSERT INTO 'robot' ('nama', 'tahun') nilai ("Astro boy", 1952);

```

umum *boolean* **memperbarui** (*string* | *array* $table, *array* $fields, *array* $values, [*string* | *array* $whereCondition], [*array* $dataTypes])

Memperbarui data pada tabel menggunakan sintaks RBDM SQL kustom

```php
<? php / / update yang ada robot$success = $connection -> update ("robot", ["name"], ["baru Astro Boy"], "id = 101");  Kalimat SQL berikutnya akan dikirim ke sistem database UPDATE 'robot' SET 'name' = "Astro boy" WHERE id = 101 / / update robot yang ada dengan berbagai kondisi dan $dataTypes $success = $connection -> update ("robot", ["name"], ["baru Astro Boy"], [         "kondisi" = > "id =?", "mengikat" = > [$some_unsafe_id], "bindTypes" = > [PDO::PARAM_INT], / / gunakan hanya jika Anda menggunakan $dataTypes param], [PDO::PARAM_STR]);

```

Warning! If $whereCondition is string it not escaped.

umum *boolean* **updateAsDict** (*string* $table, *array* $data, [*string* $whereCondition], [*array* $dataTypes])

Pembaruan data pada tabel menggunakan sintaks RBDM SQL kustom sintaks lain, lebih nyaman

```php
<? php / / update yang ada robot$success = $connection -> updateAsDict ("robot", ["name" = > "Baru Astro Boy",], "id = 101");  Kalimat SQL berikutnya akan dikirim ke sistem database UPDATE 'robot' SET 'name' = "Astro boy" WHERE id = 101

```

umum *boolean* **menghapus** (*string* | *array* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes])

Menghapus data dari tabel menggunakan sintaks RBDM SQL biasa

```php
<? php / / menghapus yang sudah ada robot$success = $connection -> delete ("robot", "id = 101");  Kalimat SQL berikutnya adalah dihasilkan menghapus dari 'robot' WHERE 'id' = 101

```

umum **escapeIdentifier** (*array* | *string* $identifier)

Melewati kolom/tabel/nama skema

```php
<?php

$escapedTable = $connection->escapeIdentifier(
    "robots"
);

$escapedTable = $connection->escapeIdentifier(
    [
        "store",
        "robots",
    ]
);

```

umum *string* **getColumnList** (*array* $columnList)

Mendapat daftar kolom

abstrak publik **tableExists** (*mixed* $sqlQuery, [*mixed* $number)

Menambahkan klausa LIMIT menjadi $sqlQuery argument

```php
<?php

echo $connection->limit("SELECT * FROM robots", 5);

```

abstrak umum **getProperty** ($tableName *campuran*, *campuran* $schemaName])

Menghasilkan pengecekan SQL untuk keberadaan skema

```php
<?php

var_dump(
    $connection->tableExists("blog", "posts")
);

```

abstrak umum **getProperty** ($viewName *campuran*, *campuran* $schemaName])

Menghasilkan pengecekan SQL untuk adanya skema.view

```php
<?php

var_dump(
    $connection->viewExists("active_users", "posts")
);

```

publik ** memiliki ** (* campuran*$sqlQuery)

Mengembalikan SQL yang dimodifikasi dengan klausa FOR UPDATE

publik ** memiliki ** (* campuran*$sqlQuery)

Mengembalikan SQL yang dimodifikasi dengan klausa LOCK IN SHARE MODE

publik **tambahkandilineJs** (*campuran* $tableName, [*campuran* $schemaName], [*campuran* $definition)

Membuat sebuah tabel

abstrak publik **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists])

Turunkan tabel dari skema/database

publik **tambahkandilineJs** (*campuran* $viewName, [*campuran* $definition], [*campuran* $schemaName])

Membuat tampilan

publik **tambahkandilineJs** (*campuran* $viewName, [*campuran* $schemaName], [*campuran* $ifExists])

Turunkan pandangan

public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

Menambahkan kolom ke sebuah tabel

public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn])

Mengubah kolom tabel berdasarkan definisi

umum **dropColumn** ($tableName *campuran*, *campuran* $schemaName, *campuran* $columnName)

Turunkan sebuah kolom dari sebuah meja

public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

Menambahkan indeks ke tabel

umum **dropIndex** ($tableName *campuran*, *campuran* $schemaName, *campuran* $indexName)

Jatuhkan indeks dari sebuah tabel

public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

Menambahkan kunci utama ke sebuah tabel

umum **getProperty** (*campuran* $tableName, *campuran* $schemaName)

Turunkan kunci utama tabel

public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference)

Menambahkan kunci asing ke meja

umum **dropForeignKey**(*campuran* $tableName, *mixed* $schemaName, *mixed* $referenceName)

Jatuhkan kunci asing dari sebuah meja

public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

Mengembalikan definisi kolom SQL dari sebuah kolom

umum **isResource** ([*campuran* $schemaName])

Daftar semua tabel di database

```php
<?php

print_r(
  $connection->listTables("blog")
);

```

umum **listTables** ([*dicampur* $schemaName])

Daftar semua tampilan di database

```php
<?php
 print_r(
$connection->listTables("blog")
);

```

public [Phalcon\Db\Index](Phalcon_Db_Index) **describeIndexes** (*string* $table, [*string* $schema])

Daftar tabel indeks

```php
<?php

print_r(
    $connection->describeIndexes("robots_parts")
);

```

umum **describeReferences** (*campuran* $table, [*campuran* $schema])

Daftar referensi tabel

```php
<?php
 print_r(
   $connection-
>describeReferences("robots_parts")
);

```

umum **tableExists** (*mixed* $tableName, [*mixed* $schemaName])

Mendapat opsi pembuatan dari sebuah tabel

```php
<?php
print_r(
   $connection-
>tableOptions("robots")
);

```

publik **getAll ** (* dicampur * $name)

Membuat savepoint baru

publik **setName** (*dicampur* $name)

Rilis diberikan savepoint

publik **createSavepoint** (*mixed* $name)

Rollbacks diberi sablon

publik **setTidakadaargumenAksiDefault** (*campuran* $nestedTransactionsWithSavepoints)

Atur jika transaksi bersarang harus menggunakan savepoint

public **isNestedTransactionsWithSavepoints** ()

Mengembalikan jika transaksi bersarang harus menggunakan savepoint

umum **getNestedTransactionSavepointName** ()

Mengembalikan nama savepoint untuk digunakan untuk transaksi bersarang

public **dapatkantargetlocal** ()

Mengembalikan nilai identitas default untuk dimasukkan ke dalam kolom identitas

```php
<?php

// Inserting a new robot with a valid default value for the column 'id'
$success = $connection->insert(
    "robots",
    [
        $connection->getDefaultIdValue(),
        "Astro Boy",
        1952,
    ],
    [
        "id",
        "name",
        "year",
    ]
);

```

umum **getDefaultValue** ()

Mengembalikan nilai default untuk membuat RBDM menggunakan nilai default yang dinyatakan dalam definisi tabel

```php
<?php

// Inserting a new robot with a valid default value for the column 'year'
$success = $connection->insert(
    "robots",
    [
        "Astro Boy",
        $connection->getDefaultValue()
    ],
    [
        "name",
        "year",
    ]
);

```

umum **supportSequences** ()

Periksa apakah sistem database memerlukan urutan untuk menghasilkan nilai numerik otomatis

umum **useExplicitIdValue** ()

Periksa apakah sistem database memerlukan nilai eksplisit untuk kolom identitas

umum **getDescriptor** ()

Kembali deskriptor yang digunakan untuk terhubung ke database aktif

umum *string* **getConnectionId** ()

Mendapat pengenal unik koneksi aktif

umum **getSQLStatement** ()

Pernyataan SQL aktif pada objek

umum **getRealSQLStatement** ()

Pernyataan SQL aktif pada objek tanpa mengganti parameter terikat

umum *array* **getSQLBindTypes** ()

Pernyataan SQL aktif pada objek

abstract public **connect** ([*array* $descriptor]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **query** (*mixed* $sqlStatement, [*mixed* $placeholders], [*mixed* $dataTypes]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **execute** (*mixed* $sqlStatement, [*mixed* $placeholders], [*mixed* $dataTypes]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **affectedRows** () inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **close** () inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **escapeString** (*mixed* $str) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **lastInsertId** ([*mixed* $sequenceName]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **begin** ([*mixed* $nesting]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **rollback** ([*mixed* $nesting]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **commit** ([*mixed* $nesting]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **isUnderTransaction** () inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **getInternalHandler** () inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **describeColumns** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...