* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Db\Profiler'

* * *

# Class **Phalcon\Db\Profiler**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/db/profiler.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Instances of Phalcon\Db can generate execution profiles on SQL statements sent to the relational database. Profiled information includes execution time in milliseconds. This helps you to identify bottlenecks in your applications.

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

## Metody

public [Phalcon\Db\Profiler](Phalcon_Db_Profiler) **startProfile** (*string* $sqlStatement, [*mixed* $sqlVariables], [*mixed* $sqlBindTypes])

Starts the profile of a SQL sentence

public **stopProfile** ()

Stops the active profile

public **getNumberTotalStatements** ()

Returns the total number of SQL statements processed

public **getTotalElapsedSeconds** ()

Returns the total time in seconds spent by the profiles

public **getProfiles** ()

Returns all the processed profiles

public **reset** ()

Resets the profiler, cleaning up all the profiles

public **getLastProfile** ()

Returns the last profile executed in the profiler