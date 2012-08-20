Class **Phalcon_Db_Profiler**
=============================

Instances of Phalcon_Db can generate execution profiles on SQL statements sent to the relational database. Profiled  information includes execution time in miliseconds. This aids in identifying bottlenecks in an applications.  

.. code-block:: php

    <?php

    $profiler = new Phalcon_Db_Profiler();

    // Set the connection profiler
    $connection->setProfiler($profiler);

    $sql = "SELECT buyer_name, quantity, product_name "
         . "FROM buyers "
         . "LEFT JOIN products ON buyers.pid = products.id";

    // Execute a SQL statement
    $connection->query($sql);

    // Get the last profile in the profiler
    $profile = $profiler->getLastProfile();

    echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
    echo "Start Time: ", $profile->getInitialTime(), "\n";
    echo "Final Time: ", $profile->getFinalTime(), "\n";
    echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";

Methods
---------

**startProfile** (string $sqlStatement)

Starts the profile of a SQL sentence

**stopProfile** ()

Stops the active profile

**integer** **getNumberTotalStatements** ()

Returns the total number of SQL statements processed

**double** **getTotalElapsedSeconds** ()

Returns the total time in seconds spent by the profiles

**Phalcon_Db_Profiler_Item[]** **getProfiles** ()

Returns all the processed profiles

**reset** ()

Resets the profiler, cleaning up all the profiles

**Phalcon_Db_Profiler_Item** **getLastProfile** ()

Returns the last profile executed in the profiler

