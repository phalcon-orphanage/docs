---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Db\Adapter\Pdo\Sqlite'
---
# Class **Phalcon\Db\Adapter\Pdo\Sqlite**

*extends* abstract class [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

*implements* [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/adapter/pdo/sqlite.zep)

Fungsi khusus untuk sistem database Sqlite

```php
<?php

gunakan Phalcon\Db\Adaptor\Pdo\Sqlite;

$connection = Sqlite baru(
    [
        "dbname" => "/tmp/test.sqlite",
    ]
);

```

## Metode

umum **hubungkan** ([*array* $descriptor])

This method is automatically called in Phalcon\Db\Adapter\Pdo constructor. Call it when you need to restore a database connection.

public **describColumns** (*mixed* $table, [*mixed* $schema])

Returns an array of Phalcon\Db\Column objects describing a table

```php
<?php

cetak_r(
    $connection->Jelaskan kolom("posts")
);

```

public [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) **describeIndexes** (*string* $table, [*string* $schema])

Daftar tabel indeks

```php
<?php

print_r(
    $connection->describeIndexes("robots_parts")
);

```

public [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) **describeReferences** (*string* $table, [*string* $schema])

Daftar referensi tabel

umum **useExplicitIdValue** ()

Periksa apakah sistem database memerlukan nilai eksplisit untuk kolom identitas

umum **getDefaultValue** ()

Mengembalikan nilai default untuk membuat RBDM menggunakan nilai default yang dinyatakan dalam definisi tabel

```php
<?php

//Memasukkan robot baru dengan nilai awal yang valid untuk kolom 'tahun'
$success=$connection->masukkan(
"robot"
[
"Astro Boy"
$connection->dapatNilaiAwal(),
],
[
"nama",
"tahun",
]
);

```

public **__construct** (*array* $descriptor) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Constructor for Phalcon\Db\Adapter\Pdo

public **prepare** (*mixed* $sqlStatement) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Mengembalikan pernyataan PDO yang disiapkan untuk dieksekusi dengan 'executePrepared'

```php
gunakan Phalcon \ Db \ Column;

$ statement = $ db- & gt; prepare (
     "SELECT * FROM robots WHERE name =: nama"
);

$ result = $ connection- & gt; executePrepared (
     $ pernyataan,
     [
         "nama" = & gt; "Voltron",
     ],
     [
         "nama" = & gt; Kolom :: BIND_PARAM_INT,
     ]
);

```

public [PDOStatement](https://php.net/manual/en/class.pdostatement.php) **executePrepared** ([PDOStatement](https://php.net/manual/en/class.pdostatement.php) $statement, *array* $placeholders, *array* $dataTypes) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Executes a prepared statement binding. This function uses integer indexes starting from zero

```php
gunakan Phalcon \ Db \ Column;

$ statement = $ db- & gt; prepare (
     "SELECT * FROM robots WHERE name =: nama"
);

$ result = $ connection- & gt; executePrepared (
     $ pernyataan,
     [
         "nama" = & gt; "Voltron",
     ],
     [
         "nama" = & gt; Kolom :: BIND_PARAM_INT,
     ]
);

```

public **query** (*mixed* $sqlStatement, [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server is returning rows

```php
& lt;? php

// Query data
$ resultset = $ connection- & gt; query (
     "MEMILIH * DARI robot DIMANA type = 'mekanis'"
);

$ resultset = $ connection- & gt; query (
     "MEMILIH * DARI robot tipe DIMANA =?",
     [
         "mekanis",
     ]
);

```

public **execute** (*mixed* $sqlStatement, [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server doesn't return any rows

```php
<?php

// Memasukkan data
$success = $connection->execute (
     "INSERT INTO robot NILAI (1, 'Astro Boy')",
 );

$success = $connection->execute (
     "INSERT INTO robot NILAI (?,?)",
     [
         1,
         "Astro Boy",
     ]
);

```

public **affectedRows** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Mengembalikan jumlah baris yang terpengaruh oleh INSERT/UPDATE/DELETE terbaru yang dieksekusi dalam sistem basis data

```php
echo $ connection- & gt; affectedRows (), "telah dihapus";

```

public **close** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Closes the active connection returning success. Phalcon automatically closes and destroys active connections when the request ends

public **escapeString** (*mixed* $str) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Melepaskan nilai untuk menghindari suntikan SQL sesuai dengan charset aktif dalam koneksi

```php
<?php

$escapedStr = $connection-
>escapeString("beberapa nilai berbahaya");

```

public **convertBoundParams** (*mixed* $sql, [*array* $params]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Mengkonversi parameter terikat seperti :name: atau ? 1 ke dalam PDO bind params ?

```php
<?php

print_r(
     $connection->convertBoundParams(
         "MEMILIH * DARI robot DIMANA nama = :name:'',
         [
             "Bender",
         ]
     )
);

```

public *int* | *boolean* **lastInsertId** ([*string* $sequenceName]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Mengembalikan insert id untuk kolom auto_increment/serial yang dimasukkan ke dalam pernyataan SQL yang dieksekusi terakhir

```php
<?php

// Memasukkan robot baru
$success = $connection->insert(
     "robot",
     [
         "Astro Boy",
         1952,
     ],
     [
         "nama",
         "tahun",
     ]
);

// Mendapatkan id yang dihasilkan
$id = $connection->lastInsertId();

```

public **begin** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Memulai transaksi dalam koneksi

public **rollback** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Rollbacks transaksi aktif dalam koneksi

public **commit** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Melakukan transaksi aktif dalam koneksi

public **getTransactionLevel** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Mengembalikan tingkat nesting transaksi saat ini

public **isUnderTransaction** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Memeriksa apakah koneksi sedang dalam transaksi

```php
<?php

$connection->begin();

// benar
var_dump(
     $connection->sedangdalamTransaksi()
);

```

public **getInternalHandler** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Kembalikan handler PDO internal

public *array* **getErrorInfo** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Kembalikan info kesalahannya, jika ada

public **getDialectType** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Nama dialek yang digunakan

public **getType** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Jenis sistem database adaptor yang digunakan untuk

public **getSqlVariables** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Parameter parameter terikat Active SQL

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Menyetel pengelola acara

public **getEventsManager** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Mengembalikan manajer acara internal

public **setDialect** ([Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface) $dialect) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Set dialek yang digunakan untuk menghasilkan SQL

public **getDialect** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Pengembalian internal dialek contoh

public **fetchOne** (*mixed* $sqlQuery, [*mixed* $fetchMode], [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Kembali baris pertama pada hasil query SQL

```php
<? php

// mendapatkan pertama robot$robot = $connection->fetchOne("Pilih * dari robot"); print_r($robot);

// Mendapatkan pertama robot dengan asosiatif indeks hanya
$robot = $connection->fetchOne("Pilih * dari robot", \Phalcon\Db::FETCH_ASSOC); print_r($robot);

```

public *array* **fetchAll** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Dumps lengkap hasil query ke dalam sebuah array

```php
<? php / / mendapatkan semua robot dengan asosiatif indeks hanya$robots = $connection -> fetchAll ("Pilih * dari robot", \Phalcon\Db::FETCH_ASSOC);  foreach ($robots sebagai $robot) {print_r($robot);}   Mendapatkan semua robot yang mengandung kata "robot" withing $robots nama = $connection -> fetchAll ("Pilih * dari robot yang mana nama seperti: nama", \Phalcon\Db::FETCH_ASSOC, ["name" = > "%robot%"]); foreach ($robots sebagai $robot) {print_r($robot);}

```

public *string* | ** **fetchColumn** (*string* $sqlQuery, [*array* $placeholders], [*int* | *string* $column]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *boolean* **insert** (*string* | *array* $table, *array* $values, [*array* $fields], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Memasukkan data ke dalam tabel menggunakan sintaks RDBMS SQL kustom

```php
<? php / / memasukkan$success robot baru = $connection -> insert ("robot", ["Astro Boy", 1952], ["name", "tahun"]);  Kalimat SQL berikutnya akan dikirim ke sistem database INSERT INTO 'robot' ('nama', 'tahun') nilai ("Astro boy", 1952);

```

public *boolean* **insertAsDict** (*string* $table, *array* $data, [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Memasukkan data ke dalam tabel menggunakan kustom sintaks RBDM SQL

```php
<? php / / memasukkan$success robot baru = $connection -> insertAsDict ("robot", ["name" = > "Astro Boy", "tahun" = > 1952,]);  Kalimat SQL berikutnya akan dikirim ke sistem database INSERT INTO 'robot' ('nama', 'tahun') nilai ("Astro boy", 1952);

```

public *boolean* **update** (*string* | *array* $table, *array* $fields, *array* $values, [*string* | *array* $whereCondition], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Memperbarui data pada tabel menggunakan sintaks RBDM SQL kustom

```php
<? php / / update yang ada robot$success = $connection -> update ("robot", ["name"], ["baru Astro Boy"], "id = 101");  Kalimat SQL berikutnya akan dikirim ke sistem database UPDATE 'robot' SET 'name' = "Astro boy" WHERE id = 101 / / update robot yang ada dengan berbagai kondisi dan $dataTypes $success = $connection -> update ("robot", ["name"], ["baru Astro Boy"], [         "kondisi" = > "id =?", "mengikat" = > [$some_unsafe_id], "bindTypes" = > [PDO::PARAM_INT], / / gunakan hanya jika Anda menggunakan $dataTypes param], [PDO::PARAM_STR]);

```

Warning! If $whereCondition is string it not escaped.

public *boolean* **updateAsDict** (*string* $table, *array* $data, [*string* $whereCondition], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Pembaruan data pada tabel menggunakan sintaks RBDM SQL kustom sintaks lain, lebih nyaman

```php
<? php / / update yang ada robot$success = $connection -> updateAsDict ("robot", ["name" = > "Baru Astro Boy",], "id = 101");  Kalimat SQL berikutnya akan dikirim ke sistem database UPDATE 'robot' SET 'name' = "Astro boy" WHERE id = 101

```

public *boolean* **delete** (*string* | *array* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Menghapus data dari tabel menggunakan sintaks RBDM SQL biasa

```php
<? php / / menghapus yang sudah ada robot$success = $connection -> delete ("robot", "id = 101");  Kalimat SQL berikutnya adalah dihasilkan menghapus dari 'robot' WHERE 'id' = 101

```

public **escapeIdentifier** (*array* | *string* $identifier) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *string* **getColumnList** (*array* $columnList) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Mendapat daftar kolom

public **limit** (*mixed* $sqlQuery, *mixed* $number) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Menambahkan klausa LIMIT menjadi $sqlQuery argument

```php
<?php

echo $connection->limit("SELECT * FROM robots", 5);

```

public **tableExists** (*mixed* $tableName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Menghasilkan pengecekan SQL untuk keberadaan skema

```php
<?php

var_dump(
    $connection->tableExists("blog", "posts")
);

```

public **viewExists** (*mixed* $viewName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Menghasilkan pengecekan SQL untuk adanya skema.view

```php
<?php

var_dump(
    $connection->viewExists("active_users", "posts")
);

```

public **forUpdate** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Mengembalikan SQL yang dimodifikasi dengan klausa FOR UPDATE

public **sharedLock** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Mengembalikan SQL yang dimodifikasi dengan klausa LOCK IN SHARE MODE

public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Membuat sebuah tabel

public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Turunkan tabel dari skema/database

public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Membuat tampilan

public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Turunkan pandangan

public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Menambahkan kolom ke sebuah tabel

public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Mengubah kolom tabel berdasarkan definisi

public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Turunkan sebuah kolom dari sebuah meja

public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Menambahkan indeks ke tabel

public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Jatuhkan indeks dari sebuah tabel

public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Menambahkan kunci utama ke sebuah tabel

public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Turunkan kunci utama tabel

public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Menambahkan kunci asing ke meja

public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Jatuhkan kunci asing dari sebuah meja

public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Mengembalikan definisi kolom SQL dari sebuah kolom

public **listTables** ([*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Daftar semua tabel di database

```php
<?php

print_r(
  $connection->listTables("blog")
);

```

public **listViews** ([*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Daftar semua tampilan di database

```php
<?php
 print_r(
$connection->listTables("blog")
);

```

public **tableOptions** (*mixed* $tableName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Mendapat opsi pembuatan dari sebuah tabel

```php
<?php
print_r(
   $connection-
>tableOptions("robots")
);

```

public **createSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Membuat savepoint baru

public **releaseSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Rilis diberikan savepoint

public **rollbackSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Rollbacks diberi sablon

public **setNestedTransactionsWithSavepoints** (*mixed* $nestedTransactionsWithSavepoints) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Atur jika transaksi bersarang harus menggunakan savepoint

public **isNestedTransactionsWithSavepoints** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Mengembalikan jika transaksi bersarang harus menggunakan savepoint

public **getNestedTransactionSavepointName** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Mengembalikan nama savepoint untuk digunakan untuk transaksi bersarang

public **getDefaultIdValue** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public **supportSequences** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Periksa apakah sistem database memerlukan urutan untuk menghasilkan nilai numerik otomatis

public **getDescriptor** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Kembali deskriptor yang digunakan untuk terhubung ke database aktif

public *string* **getConnectionId** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Mendapat pengenal unik koneksi aktif

public **getSQLStatement** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Pernyataan SQL aktif pada objek

public **getRealSQLStatement** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Pernyataan SQL aktif pada objek tanpa mengganti parameter terikat

public *array* **getSQLBindTypes** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Pernyataan SQL aktif pada objek