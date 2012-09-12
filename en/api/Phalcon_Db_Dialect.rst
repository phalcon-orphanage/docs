Class **Phalcon\\Db\\Dialect**
==============================




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



