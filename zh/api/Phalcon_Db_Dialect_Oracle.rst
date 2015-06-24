Class **Phalcon\\Db\\Dialect\\Oracle**
======================================

*extends* abstract class :doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>`

Methods
-------

public *string*  **limit** (*unknown* $sqlQuery, *unknown* $number) inherited from Phalcon\\Db\\Dialect

Generates the SQL for LIMIT clause 

.. code-block:: php

    <?php

     $sql = $dialect->limit('SELECT * FROM robots', 10);
     echo $sql; // SELECT * FROM robots LIMIT 10




public *string*  **forUpdate** (*unknown* $sqlQuery) inherited from Phalcon\\Db\\Dialect

Returns a SQL modified with a FOR UPDATE clause 

.. code-block:: php

    <?php

     $sql = $dialect->forUpdate('SELECT * FROM robots');
     echo $sql; // SELECT * FROM robots FOR UPDATE




public *string*  **sharedLock** (*unknown* $sqlQuery) inherited from Phalcon\\Db\\Dialect

Returns a SQL modified with a LOCK IN SHARE MODE clause 

.. code-block:: php

    <?php

     $sql = $dialect->sharedLock('SELECT * FROM robots');
     echo $sql; // SELECT * FROM robots LOCK IN SHARE MODE




final public *string*  **getColumnList** (*unknown* $columnList) inherited from Phalcon\\Db\\Dialect

Gets a list of columns with escaped identifiers 

.. code-block:: php

    <?php

     echo $dialect->getColumnList(array('column1', 'column'));




public *string*  **getSqlExpression** (*unknown* $expression, [*unknown* $escapeChar]) inherited from Phalcon\\Db\\Dialect

Transforms an intermediate representation for a expression into a database system valid expression



final public *string*  **getSqlTable** (*unknown* $table, [*unknown* $escapeChar]) inherited from Phalcon\\Db\\Dialect

Transform an intermediate representation of a schema/table into a database system valid expression



public *string*  **select** (*unknown* $definition) inherited from Phalcon\\Db\\Dialect

Builds a SELECT statement



public *boolean*  **supportsSavepoints** () inherited from Phalcon\\Db\\Dialect

Checks whether the platform supports savepoints



public *boolean*  **supportsReleaseSavepoints** () inherited from Phalcon\\Db\\Dialect

Checks whether the platform supports releasing savepoints.



public *string*  **createSavepoint** (*unknown* $name) inherited from Phalcon\\Db\\Dialect

Generate SQL to create a new savepoint



public *string*  **releaseSavepoint** (*unknown* $name) inherited from Phalcon\\Db\\Dialect

Generate SQL to release a savepoint



public *string*  **rollbackSavepoint** (*unknown* $name) inherited from Phalcon\\Db\\Dialect

Generate SQL to rollback a savepoint



