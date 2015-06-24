Class **Phalcon\\Db\\Dialect\\Postgresql**
==========================================

*extends* abstract class :doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>`

*implements* :doc:`Phalcon\\Db\\DialectInterface <Phalcon_Db_DialectInterface>`

Generates database specific SQL for the PostgreSQL RBDM


Methods
-------

public *string*  **getColumnDefinition** (*unknown* $column)

Gets the column name in PostgreSQL



public *string*  **addColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column)

Generates SQL to add a column to a table



public *string*  **modifyColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column)

Generates SQL to modify a column in a table



public *string*  **dropColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $columnName)

Generates SQL to delete a column from a table



public *string*  **addIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index)

Generates SQL to add an index to a table



public *string*  **dropIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $indexName)

Generates SQL to delete an index from a table



public *string*  **addPrimaryKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index)

Generates SQL to add the primary key to a table



public *string*  **dropPrimaryKey** (*unknown* $tableName, *unknown* $schemaName)

Generates SQL to delete primary key from a table



public *string*  **addForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $reference)

Generates SQL to add an index to a table



public *string*  **dropForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $referenceName)

Generates SQL to delete a foreign key from a table



protected *array*  **_getTableOptions** (*unknown* $definition)

Generates SQL to add the table creation options



public *string*  **createTable** (*unknown* $tableName, *unknown* $schemaName, *unknown* $definition)

Generates SQL to create a table in PostgreSQL



public *boolean*  **dropTable** (*unknown* $tableName, *unknown* $schemaName, [*unknown* $ifExists])

Generates SQL to drop a table



public *string*  **createView** (*unknown* $viewName, *unknown* $definition, *unknown* $schemaName)

Generates SQL to create a view



public *string*  **dropView** (*unknown* $viewName, *unknown* $schemaName, [*unknown* $ifExists])

Generates SQL to drop a view



public *string*  **tableExists** (*unknown* $tableName, [*unknown* $schemaName])

Generates SQL checking for the existence of a schema.table <code>echo dialect->tableExists("posts", "blog") <code>echo dialect->tableExists("posts")



public *string*  **viewExists** (*unknown* $viewName, [*unknown* $schemaName])

Generates SQL checking for the existence of a schema.view



public *string*  **describeColumns** (*unknown* $table, [*unknown* $schema])

Generates a SQL describing a table <code>print_r(dialect->describeColumns("posts") ?>



public *array*  **listTables** ([*unknown* $schemaName])

List all tables in database 

.. code-block:: php

    <?php

    print_r(dialect->listTables("blog")) ?>




public *string*  **listViews** ([*unknown* $schemaName])

Generates the SQL to list all views of a schema or user



public *string*  **describeIndexes** (*unknown* $table, [*unknown* $schema])

Generates SQL to query indexes on a table



public *string*  **describeReferences** (*unknown* $table, [*unknown* $schema])

Generates SQL to query foreign keys on a table



public *string*  **tableOptions** (*unknown* $table, [*unknown* $schema])

Generates the SQL to describe the table creation options



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



