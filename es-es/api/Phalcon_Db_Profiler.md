---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Db\Profiler'
---
# Class **Phalcon\Db\Profiler**

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/profiler.zep)

Instances of Phalcon\Db can generate execution profiles on SQL statements sent to the relational database. Perfilado la información incluye tiempo de ejecución en milisegundos. Esto lo ayuda a identificar cuellos de botella en sus aplicaciones.

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

## Métodos

public [Phalcon\Db\Profiler](Phalcon_Db_Profiler) **startProfile** (*string* $sqlStatement, [*mixed* $sqlVariables], [*mixed* $sqlBindTypes])

Inicia el perfil de una sentencia SQL

public **stopProfile** ()

Detiene el perfil activo

public **getNumberTotalStatements** ()

Devuelve la cantidad total de sentencias SQL procesadas

public **getTotalElapsedSeconds** ()

Devuelve el tiempo total en segundos gastados por los perfiles

public **getProfiles** ()

Devuelve todos los perfiles procesados

public **reset** ()

Restablece el perfilador, limpiando todos los perfiles

public **getLastProfile** ()

Devuelve el último perfil ejecutado en el generador de perfiles