Interface **Phalcon\\Db\\DialectInterface**
===========================================

Phalcon\\Db\\DialectInterface initializer


Methods
---------

abstract public *string*  **limit** (*string* $sqlQuery, *int* $number)

Generates the SQL for LIMIT clause



abstract public *string*  **forUpdate** (*string* $sqlQuery)

Returns a SQL modified with a FOR UPDATE clause



abstract public *string*  **sharedLock** (*string* $sqlQuery)

Returns a SQL modified with a LOCK IN SHARE MODE clause



abstract public *string*  **select** (*array* $definition)

Builds a SELECT statement



abstract public *string*  **getColumnList** (*array* $columnList)

Gets a list of columns



abstract public  **getColumnDefinition** (:doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)

Gets the column name in MySQL



abstract public *string*  **addColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)

Generates SQL to add a column to a table



abstract public *string*  **modifyColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)

Generates SQL to modify a column in a table



abstract public *string*  **dropColumn** (*string* $tableName, *string* $schemaName, *string* $columnName)

Generates SQL to delete a column from a table



abstract public *string*  **addIndex** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index)

Generates SQL to add an index to a table



abstract public *string*  **dropIndex** (*string* $tableName, *string* $schemaName, *string* $indexName)

Generates SQL to delete an index from a table



abstract public *string*  **addPrimaryKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index)

Generates SQL to add the primary key to a table



abstract public *string*  **dropPrimaryKey** (*string* $tableName, *string* $schemaName)

Generates SQL to delete primary key from a table



abstract public *string*  **addForeignKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ReferenceInterface <Phalcon_Db_ReferenceInterface>` $reference)

Generates SQL to add an index to a table



abstract public *string*  **dropForeignKey** (*string* $tableName, *string* $schemaName, *string* $referenceName)

Generates SQL to delete a foreign key from a table



abstract public *string*  **createTable** (*string* $tableName, *string* $schemaName, *array* $definition)

Generates SQL to create a table



abstract public  **dropTable** (*unknown* $tableName, *unknown* $schemaName, *unknown* $ifExists)

Generates SQL to drop a table



abstract public *string*  **tableExists** (*string* $tableName, *string* $schemaName)

Generates SQL checking for the existence of a schema.table



abstract public *string*  **describeColumns** (*string* $table, *string* $schema)

Generates SQL to describe a table



abstract public *array*  **listTables** (*string* $schemaName)

List all tables on database



abstract public *string*  **describeIndexes** (*string* $table, *string* $schema)

Generates SQL to query indexes on a table



abstract public *string*  **describeReferences** (*string* $table, *string* $schema)

Generates SQL to query foreign keys on a table



abstract public *string*  **tableOptions** (*string* $table, *string* $schema)

Generates the SQL to describe the table creation options



