---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Db\Profiler'
---
# Class **Phalcon\Db\Profiler**

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/profiler.zep)

Instances of Phalcon\Db can generate execution profiles on SQL statements sent to the relational database. Profiled bilgiler milisaniye cinsinden yürütme süresi içerir. Bu uygulamalarda performans sorunlarını belirlemenize yardımcı olur.

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

## Metodlar

public [Phalcon\Db\Profiler](Phalcon_Db_Profiler) **startProfile** (*string* $sqlStatement, [*mixed* $sqlVariables], [*mixed* $sqlBindTypes])

Bir SQL cümlesinin profilini başlatır

public **stopProfile** ()

Etkin profili durdurur

public **getNumberTotalStatements** ()

Returns the total number of SQL statements processed

public **getTotalElapsedSeconds** ()

Profil tarafından kullanılmış olan toplam saniye türünden süreyi döndürür

public **getProfiles** ()

İşlenen tüm profilleri döndürür

public **reset** ()

Profilciyi sıfırlar, tüm profilleri temizler

public **getLastProfile** ()

Profilcide yürütülen son profili döndürür