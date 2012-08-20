Class **Phalcon_Db_Profiler_Item**
==================================

This class identifies each profile in a Phalcon_Db_Profiler

Methods
---------

**setSQLStatement** (string $sqlStatement)

Sets the SQL statement related to the profile

**string** **getSQLStatement** ()

Returns the SQL statement related to the profile

**setInitialTime** (int $initialTime)

Sets the timestamp on when the profile started

**setFinalTime** (int $finalTime)

Sets the timestamp on when the profile ended

**double** **getInitialTime** ()

Returns the initial time in milseconds on when the profile started

**double** **getFinalTime** ()

Returns the initial time in milseconds on when the profile ended

**double** **getTotalElapsedSeconds** ()

Returns the total time in seconds spent by the profile

