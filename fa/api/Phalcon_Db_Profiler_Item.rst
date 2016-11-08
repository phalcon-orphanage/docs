Class **Phalcon\\Db\\Profiler\\Item**
=====================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/profiler/item.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This class identifies each profile in a Phalcon\\Db\\Profiler


Methods
-------

public  **setSqlStatement** (*mixed* $sqlStatement)

SQL statement related to the profile



public  **getSqlStatement** ()

SQL statement related to the profile



public  **setSqlVariables** (*array* $sqlVariables)

SQL variables related to the profile



public  **getSqlVariables** ()

SQL variables related to the profile



public  **setSqlBindTypes** (*array* $sqlBindTypes)

SQL bind types related to the profile



public  **getSqlBindTypes** ()

SQL bind types related to the profile



public  **setInitialTime** (*mixed* $initialTime)

Timestamp when the profile started



public  **getInitialTime** ()

Timestamp when the profile started



public  **setFinalTime** (*mixed* $finalTime)

Timestamp when the profile ended



public  **getFinalTime** ()

Timestamp when the profile ended



public  **getTotalElapsedSeconds** ()

Returns the total time in seconds spent by the profile



