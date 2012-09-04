Class **Phalcon\\Db\\Dialect**
==============================

Methods
---------

*string* public **limit** (*string* $sqlQuery, *int* $number)

Generates the SQL for LIMIT clause



*string* public **forUpdate** (*string* $sqlQuery)

Returns a SQL modified with a FOR UPDATE clause



*string* public **sharedLock** (*string* $sqlQuery)

Returns a SQL modified with a LOCK IN SHARE MODE clause



*string* public **select** (*array* $definition)

Builds a SELECT statement



