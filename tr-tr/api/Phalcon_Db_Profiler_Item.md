---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Db\Profiler\Item'
---
# Class **Phalcon\Db\Profiler\Item**

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/profiler/item.zep)

This class identifies each profile in a Phalcon\Db\Profiler

## Metodlar

public **setSqlStatement** (*mixed* $sqlStatement)

Profil ile alakalı SQL deyimi

public **getSqlStatement** ()

Profil ile alakalı SQL deyimi

public **setSqlVariables** (*array* $sqlVariables)

Profil ile alakalı SQL deyimi

genel **getSqlVariables** ()

Profil ile alakalı SQL deyimi

public **setSqlBindTypes** (*array* $sqlBindTypes)

SQL bind types related to the profile

public **getSqlBindTypes** ()

SQL bind types related to the profile

public **setInitialTime** (*mixed* $initialTime)

Profil başladığı zaman zaman damgası

public **getInitialTime** ()

Profil başladığı zaman zaman damgası

public **setFinalTime** (*mixed* $finalTime)

Timestamp when the profile ended

public **getFinalTime** ()

Timestamp when the profile ended

public **getTotalElapsedSeconds** ()

Profil tarafından kullanılmış olan toplam saniye türünden süreyi döndürür