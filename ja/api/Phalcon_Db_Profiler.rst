Class **Phalcon\\Db\\Profiler**
===============================

Instances of Phalcon\\Db can generate execution profiles on SQL statements sent to the relational database. Profiled information includes execution time in miliseconds. This helps you to identify bottlenecks in your applications.  

.. code-block:: php

    <?php

    $profiler = new \Phalcon\Db\Profiler();
    
    //Set the connection profiler
    $connection->setProfiler($profiler);
    
    $sql = "SELECT buyer_name, quantity, product_name
    FROM buyers LEFT JOIN products ON
    buyers.pid=products.id";
    
    //Execute a SQL statement
    $connection->query($sql);
    
    //Get the last profile in the profiler
    $profile = $profiler->getLastProfile();
    
    echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
    echo "Start Time: ", $profile->getInitialTime(), "\n";
    echo "Final Time: ", $profile->getFinalTime(), "\n";
    echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";



Methods
-------

public :doc:`Phalcon\\Db\\Profiler <Phalcon_Db_Profiler>`  **startProfile** (*unknown* $sqlStatement, [*unknown* $sqlVariables], [*unknown* $sqlBindTypes])

Starts the profile of a SQL sentence



public :doc:`Phalcon\\Db\\Profiler <Phalcon_Db_Profiler>`  **stopProfile** ()

Stops the active profile



public *integer*  **getNumberTotalStatements** ()

Returns the total number of SQL statements processed



public *double*  **getTotalElapsedSeconds** ()

Returns the total time in seconds spent by the profiles



public :doc:`Phalcon\\Db\\Profiler\\Item <Phalcon_Db_Profiler_Item>` [] **getProfiles** ()

Returns all the processed profiles



public :doc:`Phalcon\\Db\\Profiler <Phalcon_Db_Profiler>`  **reset** ()

Resets the profiler, cleaning up all the profiles



public :doc:`Phalcon\\Db\\Profiler\\Item <Phalcon_Db_Profiler_Item>`  **getLastProfile** ()

Returns the last profile executed in the profiler



