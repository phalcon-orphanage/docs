---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Transaction'
---
# Class **Phalcon\Mvc\Model\Transaction**

*implements* [Phalcon\Mvc\Model\TransactionInterface](Phalcon_Mvc_Model_TransactionInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/transaction.zep)

Transaksi adalah blok pelindung dimana pernyataan SQL hanya bersifat permanen jika bisa semua berhasil sebagai satu aksi atom. Phalcon\Transaction is intended to be used with Phalcon_Model_Base. Phalcon Transactions should be created using Phalcon\Transaction\Manager.

```php
<?php

try {
    $manager = new \Phalcon\Mvc\Model\Transaction\Manager();

    $transaction = $manager->get();

    $robot = new Robots();

    $robot->setTransaction($transaction);

    $robot->name       = "WALL·E";
    $robot->created_at = date("Y-m-d");

    if ($robot->save() === false) {
        $transaction->rollback("Can't save robot");
    }

    $robotPart = new RobotParts();

    $robotPart->setTransaction($transaction);

    $robotPart->type = "head";

    if ($robotPart->save() === false) {
        $transaction->rollback("Can't save robot part");
    }

    $transaction->commit();
} catch(Phalcon\Mvc\Model\Transaction\Failed $e) {
    echo "Failed, reason: ", $e->getMessage();
}

```

## Metode

public **__construct** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector, [*boolean* $autoBegin], [*string* $service])

Phalcon\Mvc\Model\Transaction constructor

public **setTransactionManager** ([Phalcon\Mvc\Model\Transaction\ManagerInterface](Phalcon_Mvc_Model_Transaction_ManagerInterface) $manager)

Menetapkan pengelola transaksi yang terkait dengan transaksi

publik **mulai** ()

Mulai transaksi

publik **komit** ()

Melakukan transaksi

public *boolean* **rollback** ([*string* $rollbackMessage], [[Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $rollbackRecord])

Rollbacks the transaction

public **getConnection** ()

Mengembalikan koneksi yang terkait dengan transaksi

public **setIsNewTransaction** (*mixed* $isNew)

Menetapkan apakah transaksi yang digunakan kembali atau baru sekali

public **setRollbackOnAbort** (*mixed* $rollbackOnAbort)

Set flag ke rollback pada membatalkan koneksi HTTP

public **isManaged** ()

Memeriksa apakah transaksi dikelola oleh manajer transaksi

public **getMessages** ()

Mengembalikan pesan validasi dari save simpan terakhir

public **isValid** ()

Memeriksa apakah koneksi internal berada di bawah transaksi aktif

public **setRollbackedRecord** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $record)

Menetapkan objek yang menghasilkan tindakan rollback