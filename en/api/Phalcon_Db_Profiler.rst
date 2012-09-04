Class **Phalcon\\Db\\Profiler**
===============================

Methods
---------

public **__construct** ()

:doc:`Phalcon\\Db\\Profiler <Phalcon_Db_Profiler>` public **startProfile** (*string* $sqlStatement)

Starts the profile of a SQL sentence



:doc:`Phalcon\\Db\\Profiler <Phalcon_Db_Profiler>` public **stopProfile** ()

Stops the active profile



*integer* public **getNumberTotalStatements** ()

Returns the total number of SQL statements processed



*double* public **getTotalElapsedSeconds** ()

Returns the total time in seconds spent by the profiles



:doc:`Phalcon\\Db\\Profiler\\Item[] <Phalcon_Db_Profiler_Item[]>` public **getProfiles** ()

Returns all the processed profiles



:doc:`Phalcon\\Db\\Profiler <Phalcon_Db_Profiler>` public **reset** ()

Resets the profiler, cleaning up all the profiles



:doc:`Phalcon\\Db\\Profiler\\Item <Phalcon_Db_Profiler_Item>` public **getLastProfile** ()

Returns the last profile executed in the profiler



