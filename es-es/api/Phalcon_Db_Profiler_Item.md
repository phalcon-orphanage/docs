---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Db\Profiler\Item'
---
# Class **Phalcon\Db\Profiler\Item**

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/profiler/item.zep)

This class identifies each profile in a Phalcon\Db\Profiler

## Métodos

public **setSqlStatement** (*mixed* $sqlStatement)

Instrucción SQL relacionada con el perfil

public **getSqlStatement** ()

Instrucción SQL relacionada con el perfil

public **setSqlVariables** (*array* $sqlVariables)

Variables SQL relacionadas con el perfil

public **getSqlVariables** ()

Variables SQL relacionadas con el perfil

public **setSqlBindTypes** (*array* $sqlBindTypes)

Tipos de enlace SQL relacionados con el perfil

public **getSqlBindTypes** ()

Tipos de enlace SQL relacionados con el perfil

public **setInitialTime** (*mixed* $initialTime)

Marca de tiempo de cuando se inició el perfil

public **getInitialTime** ()

Marca de tiempo de cuando se inició el perfil

public **setFinalTime** (*mixed* $finalTime)

Marca de tiempo de cuando finalizó el perfil

public **getFinalTime** ()

Marca de tiempo de cuando finalizó el perfil

public **getTotalElapsedSeconds** ()

Devuelve el tiempo total en segundos usado por el usuario