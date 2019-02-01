---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Db\Profiler\Item'
---
# Class **Phalcon\Db\Profiler\Item**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/profiler/item.zep)

This class identifies each profile in a Phalcon\Db\Profiler

## Metode

publik **setSqlStatement** (*mixed* $sqlStatement)

Pernyataan SQL terkait dengan profil

publik **getSqlStatement** ()

Pernyataan SQL terkait dengan profil

publik **setSqlVariables** (*array* $sqlVariables)

Variabel SQL terkait dengan profil

umum **getSqlVariables** ()

Variabel SQL terkait dengan profil

publik **setSqlBindTypes** (*array* $sqlBindTypes)

SQL mengikat jenis yang terkait dengan profil

publik **getSqlBindTypes** ()

SQL mengikat jenis yang terkait dengan profil

publik **setInitialTime** (*mixed* $initialTime)

Timestamp saat profil dimulai

publik **getInitialTime** ()

Timestamp saat profil dimulai

publik **setFinalTime** (*mixed* $finalTime)

Jangka waktu saat profil berakhir

publik **getFinalTime** ()

Jangka waktu saat profil berakhir

publik **getTotalElapsedSeconds** ()

Mengembalikan total waktu dalam detik yang dihabiskan oleh profil