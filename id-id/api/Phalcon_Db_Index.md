---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Db\Index'
---
# Class **Phalcon\Db\Index**

*implements* [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/index.zep)

Memungkinkan untuk menentukan indeks yang akan digunakan pada tabel. Indeks adalah cara yang umum untuk meningkatkan kinerja database. Sebuah indeks memungkinkan server database untuk menemukan dan mengambil baris tertentu jauh lebih cepat daripada yang bisa dilakukan tanpa sebuah indeks

```php
& lt; ? php 

// Tentukan indeks unik baru
 $ index_unique = new \ Phalcon \ Db \ Index (
     'column_UNIQUE',
     [
         'column',
         'column'
     ],
     'UNIQUE'); // Tentukan indeks utama baru
 $ index_primary = new \ Phalcon \ Db \ Index (
     'PRIMARY',
     [
         'column'
     ]); // Tambahkan indeks ke tabel yang ada
 $ connection - & gt; addIndex ("robot", null, $ index_unique );
$ koneksi - & gt; addIndex ("robot", null, $ index_primary );

```

## Metode

publik **getNama** ()

Nama indeks

publik **getColumns** ()

Kolom indeks

publik **berhenti** ()

Jenis indeks

publik **__construct** (*mixed* $name, *array* $columns, [*mixed* $type])

Phalcon\Db\Index constructor

public static **__set_state** (*array* $data)

Restore a Phalcon\Db\Index object from export