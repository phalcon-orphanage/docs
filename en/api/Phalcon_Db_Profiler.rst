Class **Phalcon\\Db\\Profiler**
===============================

Phalcon\\Db\\Profiler   Instances of Phalcon\\Db can generate execution profiles  on SQL statements sent to the relational database. Profiled  information includes execution time in miliseconds.  This helps you to identify bottlenecks in your applications.  

.. code-block:: php

    <?php

    
    
     $profiler = new Phalcon\Db\Profiler();
    
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
---------

**__construct** ()

:doc:`\\Phalcon\\Db\\Profiler <_Phalcon_Db_Profiler>` **startProfile** (*string* **$sqlStatement**)

:doc:`\\Phalcon\\Db\\Profiler <_Phalcon_Db_Profiler>` **stopProfile** ()

*integer* **getNumberTotalStatements** ()

*double* **getTotalElapsedSeconds** ()

:doc:`Phalcon\\Db\\Profiler\\Item[] <Phalcon_Db_Profiler_Item[]>` **getProfiles** ()

:doc:`\\Phalcon\\Db\\Profiler <_Phalcon_Db_Profiler>` **reset** ()

:doc:`Phalcon\\Db\\Profiler\\Item <Phalcon_Db_Profiler_Item>` **getLastProfile** ()

