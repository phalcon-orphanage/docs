---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Transaction\Manager'
---
# Class **Phalcon\Mvc\Model\Transaction\Manager**

*implements* [Phalcon\Mvc\Model\Transaction\ManagerInterface](Phalcon_Mvc_Model_Transaction_ManagerInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/transaction/manager.zep)

A transaction acts on a single database connection. If you have multiple class-specific databases, the transaction will not protect interaction among them.

This class manages the objects that compose a transaction. A transaction produces a unique connection that is passed to every object part of the transaction.

```php
<?php

try {
   use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;

   $transactionManager = new TransactionManager();

   $transaction = $transactionManager->get();

   $robot = new Robots();

   $robot->setTransaction($transaction);

   $robot->name       = "WALL·E";
   $robot->created_at = date("Y-m-d");

   if ($robot->save() === false){
       $transaction->rollback("Can't save robot");
   }

   $robotPart = new RobotParts();

   $robotPart->setTransaction($transaction);

   $robotPart->type = "head";

   if ($robotPart->save() === false) {
       $transaction->rollback("Can't save robot part");
   }

   $transaction->commit();
} catch (Phalcon\Mvc\Model\Transaction\Failed $e) {
   echo "Failed, reason: ", $e->getMessage();
}

```

## Metode

public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Phalcon\Mvc\Model\Transaction\Manager constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Menetapkan ketergantungan injeksi wadah

publik **mendapatkanDI** ()

Kembali wadah injeksi ketergantungan

public **setDbService** (*mixed* $service)

Mengatur layanan database yang digunakan untuk menjalankan transaksi isolasi

public *string* **getDbService** ()

Mengembalikan layanan database yang digunakan untuk transaksi isolasi

public **setRollbackPendent** (*mixed* $rollbackPendent)

Mengatur jika manajer transaksi harus mendaftarkan fungsi shutdown untuk membersihkan transaksi yang tidak tepat

public **getRollbackPendent** ()

Periksa apakah manager transaksi mendaftarkan fungsi pada shutdown untuk membersihkan transaksi tidak tepat

public **has** ()

Periksa apakah manajer memiliki sebuah transaksi aktif

public **get** ([*mixed* $autoBegin])

Returns a new \Phalcon\Mvc\Model\Transaction or an already created once This method registers a shutdown function to rollback active connections

public **getOrCreateTransaction** ([*mixed* $autoBegin])

Membuat/Mengembalikan transaksi terbaru atau yang sudah ada

public **rollbackPendent** ()

Memutar kembali transaksi aktif didalam manajer

publik **komit** ()

Berkomitmen transaksi aktif didalam manajer

public **rollback** ([*boolean* $collect])

Memutar kembali transaksi aktif didalam manajer Kumpulan akan dihapus transaksi itu dari manajer

public **notifyRollback** ([Phalcon\Mvc\Model\TransactionInterface](Phalcon_Mvc_Model_TransactionInterface) $transaction)

Memeberitahukan manajer tentang sebuah transaksi rollbacked

public **notifyCommit** ([Phalcon\Mvc\Model\TransactionInterface](Phalcon_Mvc_Model_TransactionInterface) $transaction)

Memberitahukan manajer tentang sebuah transaksi yang dilakukan

protected **_collectTransaction** ([Phalcon\Mvc\Model\TransactionInterface](Phalcon_Mvc_Model_TransactionInterface) $transaction)

Menghapus transaksi dari TransactionManager

public **collectTransactions** ()

Menghapus semua transaksi dari manajer