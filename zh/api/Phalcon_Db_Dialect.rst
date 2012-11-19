Class **Phalcon\\Db\\Dialect**
==============================

This is the base class to each database dialect. This implements common methods to transform intermediate code into its RDBM related syntax


Methods
---------

public *string*  **limit** (*string* $sqlQuery, *int* $number)

Generates the SQL for LIMIT clause



public *string*  **forUpdate** (*string* $sqlQuery)

Returns a SQL modified with a FOR UPDATE clause



public *string*  **sharedLock** (*string* $sqlQuery)

Returns a SQL modified with a LOCK IN SHARE MODE clause



public *string*  **select** (*array* $definition)

Builds a SELECT statement



