---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Db\Reference'
---
# Class **Phalcon\Db\Reference**

*implements* [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/reference.zep)

Memungkinkan untuk mendefinisikan batasan referensi pada tabel

```php
<?php

$reference = baru \Phalcon\Db\Referensi(
    "field_fk",
    [
        "referencedSchema"  => "faktur",
        "referencedTable"   => "produk",
        "columns"           => [
            "tipe produk",
            "kode produk",
        ],
        "referencedColumns" => [
            "tipe",
            "kode",
        ],
    ]
);

```

## Metode

publik **getNama** ()

Nama kendala

public **getSchemaName** ()

...

publik **getReferencedSchema** ()

...

publik **getReferencedTable** ()

Tabel yang direferensikan

publik **getColumns** ()

Kolom referensi lokal

publik **getReferencedColumns** ()

Kolom yang direferensikan

publik **getOnDelete** ()

DI HAPUS

publik **getOnUpdate** ()

DI PERBARUI

public **__construct** (*mixed* $name, *array* $definition)

Phalcon\Db\Reference constructor

public static **__set_state** (*array* $data)

Restore a Phalcon\Db\Reference object from export