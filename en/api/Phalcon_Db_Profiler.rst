Class **Phalcon\\Db\\Profiler**
===============================

Methods
---------

public  **__construct** ()

Phalcon\\Db\\Profiler constructor



public :doc:`Phalcon\\Db\\Profiler <Phalcon_Db_Profiler>`  **startProfile** (*string* $sqlStatement)

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



