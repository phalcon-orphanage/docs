---
layout: article
language: 'it-it'
version: '4.0'
title: 'Phalcon\Db\Profiler\Item'
---
# Class **Phalcon\Db\Profiler\Item**

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/profiler/item.zep)

This class identifies each profile in a Phalcon\Db\Profiler

## Methods

public **setSqlStatement** (*mixed* $sqlStatement)

SQL statement related to the profile

public **getSqlStatement** ()

SQL statement related to the profile

public **setSqlVariables** (*array* $sqlVariables)

SQL variables related to the profile

public **getSqlVariables** ()

SQL variables related to the profile

public **setSqlBindTypes** (*array* $sqlBindTypes)

SQL bind types related to the profile

public **getSqlBindTypes** ()

SQL bind types related to the profile

public **setInitialTime** (*mixed* $initialTime)

Timestamp when the profile started

public **getInitialTime** ()

Timestamp when the profile started

public **setFinalTime** (*mixed* $finalTime)

Timestamp when the profile ended

public **getFinalTime** ()

Timestamp when the profile ended

public **getTotalElapsedSeconds** ()

Returns the total time in seconds spent by the profile