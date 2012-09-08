Class **Phalcon\\Db\\Profiler**
===============================

Instances of Phalcon\\Db can generate execution profiles on SQL statements sent to the relational database. Profiled information includes execution time in milliseconds. This helps you to identify bottlenecks in your applications.

.. code-block:: php

    <?php

    $profiler = new Phalcon\Db\Profiler();

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

public **__construct** ()

:doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>` public **startProfile** (*string* $sqlStatement)

Starts the profile of a SQL sentence



:doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>` public **stopProfile** ()

Stops the active profile



*integer* public **getNumberTotalStatements** ()

Returns the total number of SQL statements processed



*double* public **getTotalElapsedSeconds** ()

Returns the total time in seconds spent by the profiles



:doc:`Phalcon\\Db\\Profiler\\Item <../api/Phalcon_Db_Profiler_Item>` public **getProfiles** ()

Returns all the processed profiles



:doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>` public **reset** ()

Resets the profiler, cleaning up all the profiles



:doc:`Phalcon\\Db\\Profiler\\Item <../api/Phalcon_Db_Profiler_Item>` public **getLastProfile** ()

Returns the last profile executed in the profiler



