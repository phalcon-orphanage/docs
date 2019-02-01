---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Db\Profiler'
---
# Class **Phalcon\Db\Profiler**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/profiler.zep)

Instances of Phalcon\Db can generate execution profiles on SQL statements sent to the relational database. Milidetik. Ini membantu Anda untuk mengidentifikasi kemacetan dalam aplikasi Anda.

```php
<?php

$profiler = new \Phalcon\Db\Profiler();

// Set the connection profiler
$connection->setProfiler($profiler);

$sql = "SELECT buyer_name, quantity, product_name
FROM buyers LEFT JOIN products ON
buyers.pid=products.id";

// Execute a SQL statement
$connection->query($sql);

// Get the last profile in the profiler
$profile = $profiler->getLastProfile();

echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
echo "Start Time: ", $profile->getInitialTime(), "\n";
echo "Final Time: ", $profile->getFinalTime(), "\n";
echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";

```

## Metode

public [Phalcon\Db\Profiler](Phalcon_Db_Profiler) **startProfile** (*string* $sqlStatement, [*mixed* $sqlVariables], [*mixed* $sqlBindTypes])

Mulai profil kalimat SQL

umum **stopProfile** ()

Menghentikan profil aktif

umum **getNumberTotalStatements** ()

Mengembalikan jumlah total pernyataan SQL yang diproses

publik **getTotalElapsedSeconds** ()

Mengembalikan total waktu dalam detik yang dihabiskan oleh profil

umum **getProfiles** ()

Mengembalikan semua profil yang diproses

umum **reset** ()

Mengatur ulang profiler, membersihkan semua profil

umum **getLastProfile** ()

Mengembalikan profil terakhir yang dijalankan di profiler