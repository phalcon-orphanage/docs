---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Query\Status'
---
# Class **Phalcon\Mvc\Model\Query\Status**

*implements* [Phalcon\Mvc\Model\Query\StatusInterface](Phalcon_Mvc_Model_Query_StatusInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/query/status.zep)

Kelas ini mewakili status yang dikembalikan oleh PHQL pernyataan seperti INSERT, UPDATE atau DELETE. Ini menawarkan konteks informasi dan pesan terkait yang dihasilkan oleh model yang akhirnya menjalankan operasi saat gagal

```php
<?php

$phql = "UPDATE Robots SET name = :name:, type = :type:, year = :year: WHERE id = :id:";

$status = $app->modelsManager->executeQuery(
    $phql,
    [
        "id"   => 100,
        "name" => "Astroy Boy",
        "type" => "mechanical",
        "year" => 1959,
    ]
);

// Check if the update was successful
if ($status->success() === true) {
    echo "OK";
}

```

## Metode

public **__construct** (*mixed* $success, [[Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model])

publik **mendapatkan Model** ()

Mengembalikan model yang menjalankan aksinya

public **getMessages** ()

Mengembalikan pesan yang dihasilkan karena operasi yang gagal

public **success** ()

Memungkinkan untuk memeriksa apakah operasi yang dijalankan berhasil