Class **Phalcon\\Db\\Dialect**
==============================

This is the base class to each database dialect. This implements common methods to transform intermediate code into its RDBM related syntax


Methods
---------

public *string*  **limit** (*string* $sqlQuery, *int* $number)

Generates the SQL for LIMIT clause 

.. code-block:: php

    <?php

     $sql = $dialect->limit('SELECT * FROM robots', 10);
     echo $sql; // SELECT * FROM robots LIMIT 10




public *string*  **forUpdate** (*string* $sqlQuery)

Returns a SQL modified with a FOR UPDATE clause 

.. code-block:: php

    <?php

     $sql = $dialect->forUpdate('SELECT * FROM robots');
     echo $sql; // SELECT * FROM robots FOR UPDATE




public *string*  **sharedLock** (*string* $sqlQuery)

Returns a SQL modified with a LOCK IN SHARE MODE clause 

.. code-block:: php

    <?php

     $sql = $dialect->sharedLock('SELECT * FROM robots');
     echo $sql; // SELECT * FROM robots LOCK IN SHARE MODE




public *string*  **getColumnList** (*array* $columnList)

Gets a list of columns with escaped identifiers 

.. code-block:: php

    <?php

     echo $dialect->getColumnList(array('column1', 'column'));




public *string*  **getSqlExpression** (*array* $expression, [*string* $escapeChar])

Transforms an intermediate representation for a expression into a database system valid expression



public *string*  **getSqlTable** (*array* $table, [*string* $escapeChar])

Transform an intermediate representation for a schema/table into a database system valid expression



public *string*  **select** (*array* $definition)

Builds a SELECT statement



