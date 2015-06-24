Abstract class **Phalcon\\Db\\Dialect**
=======================================

This is the base class to each database dialect. This implements common methods to transform intermediate code into its RDBM related syntax


Methods
-------

public *string*  **limit** (*unknown* $sqlQuery, *unknown* $number)

Generates the SQL for LIMIT clause 

.. code-block:: php

    <?php

     $sql = $dialect->limit('SELECT * FROM robots', 10);
     echo $sql; // SELECT * FROM robots LIMIT 10




public *string*  **forUpdate** (*unknown* $sqlQuery)

Returns a SQL modified with a FOR UPDATE clause 

.. code-block:: php

    <?php

     $sql = $dialect->forUpdate('SELECT * FROM robots');
     echo $sql; // SELECT * FROM robots FOR UPDATE




public *string*  **sharedLock** (*unknown* $sqlQuery)

Returns a SQL modified with a LOCK IN SHARE MODE clause 

.. code-block:: php

    <?php

     $sql = $dialect->sharedLock('SELECT * FROM robots');
     echo $sql; // SELECT * FROM robots LOCK IN SHARE MODE




final public *string*  **getColumnList** (*unknown* $columnList)

Gets a list of columns with escaped identifiers 

.. code-block:: php

    <?php

     echo $dialect->getColumnList(array('column1', 'column'));




public *string*  **getSqlExpression** (*unknown* $expression, [*unknown* $escapeChar])

Transforms an intermediate representation for a expression into a database system valid expression



final public *string*  **getSqlTable** (*unknown* $table, [*unknown* $escapeChar])

Transform an intermediate representation of a schema/table into a database system valid expression



public *string*  **select** (*unknown* $definition)

Builds a SELECT statement



public *boolean*  **supportsSavepoints** ()

Checks whether the platform supports savepoints



public *boolean*  **supportsReleaseSavepoints** ()

Checks whether the platform supports releasing savepoints.



public *string*  **createSavepoint** (*unknown* $name)

Generate SQL to create a new savepoint



public *string*  **releaseSavepoint** (*unknown* $name)

Generate SQL to release a savepoint



public *string*  **rollbackSavepoint** (*unknown* $name)

Generate SQL to rollback a savepoint



