Abstract class **Phalcon\\Db\\Dialect**
=======================================
<<<<<<< HEAD

*implements* :doc:`Phalcon\\Db\\DialectInterface <Phalcon_Db_DialectInterface>`
=======
>>>>>>> master

This is the base class to each database dialect. This implements common methods to transform intermediate code into its RDBM related syntax


Methods
-------

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



public *boolean*  **supportsSavepoints** ()

Checks whether the platform supports savepoints



public *boolean*  **supportsReleaseSavepoints** ()

Checks whether the platform supports releasing savepoints.



public *string*  **createSavepoint** (*string* $name)

Generate SQL to create a new savepoint



public *string*  **releaseSavepoint** (*string* $name)

Generate SQL to release a savepoint



public *string*  **rollbackSavepoint** (*string* $name)

Generate SQL to rollback a savepoint



abstract public  **getColumnDefinition** (:doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column) inherited from Phalcon\\Db\\DialectInterface

Gets the column name in MySQL



abstract public *string*  **addColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column) inherited from Phalcon\\Db\\DialectInterface

Generates SQL to add a column to a table



abstract public *string*  **modifyColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column) inherited from Phalcon\\Db\\DialectInterface

Generates SQL to modify a column in a table



abstract public *string*  **dropColumn** (*string* $tableName, *string* $schemaName, *string* $columnName) inherited from Phalcon\\Db\\DialectInterface

Generates SQL to delete a column from a table



abstract public *string*  **addIndex** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index) inherited from Phalcon\\Db\\DialectInterface

Generates SQL to add an index to a table



abstract public *string*  **dropIndex** (*string* $tableName, *string* $schemaName, *string* $indexName) inherited from Phalcon\\Db\\DialectInterface

Generates SQL to delete an index from a table



abstract public *string*  **addPrimaryKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index) inherited from Phalcon\\Db\\DialectInterface

Generates SQL to add the primary key to a table



abstract public *string*  **dropPrimaryKey** (*string* $tableName, *string* $schemaName) inherited from Phalcon\\Db\\DialectInterface

Generates SQL to delete primary key from a table



abstract public *string*  **addForeignKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ReferenceInterface <Phalcon_Db_ReferenceInterface>` $reference) inherited from Phalcon\\Db\\DialectInterface

Generates SQL to add an index to a table



abstract public *string*  **dropForeignKey** (*string* $tableName, *string* $schemaName, *string* $referenceName) inherited from Phalcon\\Db\\DialectInterface

Generates SQL to delete a foreign key from a table



abstract public *string*  **createTable** (*string* $tableName, *string* $schemaName, *array* $definition) inherited from Phalcon\\Db\\DialectInterface

Generates SQL to create a table



abstract public *string*  **dropTable** (*string* $tableName, *string* $schemaName) inherited from Phalcon\\Db\\DialectInterface

Generates SQL to drop a table



abstract public *string*  **createView** (*string* $viewName, *array* $definition, *string* $schemaName) inherited from Phalcon\\Db\\DialectInterface

Generates SQL to create a view



abstract public *string*  **dropView** (*string* $viewName, *string* $schemaName, [*unknown* $ifExists]) inherited from Phalcon\\Db\\DialectInterface

Generates SQL to drop a view



abstract public *string*  **tableExists** (*string* $tableName, [*string* $schemaName]) inherited from Phalcon\\Db\\DialectInterface

Generates SQL checking for the existence of a schema.table



abstract public *string*  **viewExists** (*string* $viewName, [*string* $schemaName]) inherited from Phalcon\\Db\\DialectInterface

Generates SQL checking for the existence of a schema.view



abstract public *string*  **describeColumns** (*string* $table, [*string* $schema]) inherited from Phalcon\\Db\\DialectInterface

Generates SQL to describe a table



abstract public *array*  **listTables** ([*string* $schemaName]) inherited from Phalcon\\Db\\DialectInterface

List all tables on database



abstract public *array*  **listViews** ([*string* $schemaName]) inherited from Phalcon\\Db\\DialectInterface

List all views on database



abstract public *string*  **describeIndexes** (*string* $table, [*string* $schema]) inherited from Phalcon\\Db\\DialectInterface

Generates SQL to query indexes on a table



abstract public *string*  **describeReferences** (*string* $table, [*string* $schema]) inherited from Phalcon\\Db\\DialectInterface

Generates SQL to query foreign keys on a table



abstract public *string*  **tableOptions** (*string* $table, [*string* $schema]) inherited from Phalcon\\Db\\DialectInterface

Generates the SQL to describe the table creation options



