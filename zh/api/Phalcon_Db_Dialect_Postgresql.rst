Class **Phalcon\\Db\\Dialect\\Postgresql**
==========================================

*extends* :doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>`

<<<<<<< HEAD
=======
*implements* :doc:`Phalcon\\Db\\DialectInterface <Phalcon_Db_DialectInterface>`

>>>>>>> 0.7.0
Generates database specific SQL for the PostgreSQL RBDM


Methods
---------

<<<<<<< HEAD
public *string*  **getColumnList** (*array* $columnList)

Gets a list of columns



public static  **getColumnDefinition** (:doc:`Phalcon\\Db\\Column <Phalcon_Db_Column>` $column)
=======
public  **getColumnDefinition** (:doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)
>>>>>>> 0.7.0

Gets the column name in PostgreSQL



<<<<<<< HEAD
public static *string*  **addColumn** ()
=======
public *string*  **addColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)
>>>>>>> 0.7.0

Generates SQL to add a column to a table



<<<<<<< HEAD
public static *string*  **modifyColumn** ()
=======
public *string*  **modifyColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)
>>>>>>> 0.7.0

Generates SQL to modify a column in a table



<<<<<<< HEAD
public static *string*  **dropColumn** ()
=======
public *string*  **dropColumn** (*string* $tableName, *string* $schemaName, *string* $columnName)
>>>>>>> 0.7.0

Generates SQL to delete a column from a table



<<<<<<< HEAD
public static *string*  **addIndex** ()
=======
public *string*  **addIndex** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>` $index)
>>>>>>> 0.7.0

Generates SQL to add an index to a table



<<<<<<< HEAD
public static *string*  **dropIndex** ()
=======
public *string*  **dropIndex** (*string* $tableName, *string* $schemaName, *string* $indexName)
>>>>>>> 0.7.0

Generates SQL to delete an index from a table



<<<<<<< HEAD
public static *string*  **addPrimaryKey** ()
=======
public *string*  **addPrimaryKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>` $index)
>>>>>>> 0.7.0

Generates SQL to add the primary key to a table



<<<<<<< HEAD
public static *string*  **dropPrimaryKey** ()
=======
public *string*  **dropPrimaryKey** (*string* $tableName, *string* $schemaName)
>>>>>>> 0.7.0

Generates SQL to delete primary key from a table



<<<<<<< HEAD
public static *string*  **addForeignKey** ()
=======
public *string*  **addForeignKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ReferenceInterface <Phalcon_Db_ReferenceInterface>` $reference)
>>>>>>> 0.7.0

Generates SQL to add an index to a table



<<<<<<< HEAD
public static *string*  **dropForeignKey** ()
=======
public *string*  **dropForeignKey** (*string* $tableName, *string* $schemaName, *string* $referenceName)
>>>>>>> 0.7.0

Generates SQL to delete a foreign key from a table



protected *array*  **_getTableOptions** ()

Generates SQL to add the table creation options



<<<<<<< HEAD
public *string*  **createTable** ()
=======
public *string*  **createTable** (*string* $tableName, *string* $schemaName, *array* $definition)
>>>>>>> 0.7.0

Generates SQL to create a table in PostgreSQL



public *boolean*  **dropTable** (*string* $tableName, *string* $schemaName, *boolean* $ifExists)

Generates SQL to drop a table



<<<<<<< HEAD
public static *string*  **tableExists** (*string* $tableName, *string* $schemaName)
=======
public *string*  **tableExists** (*string* $tableName, *string* $schemaName)
>>>>>>> 0.7.0

Generates SQL checking for the existence of a schema.table <code>echo $dialect->tableExists("posts", "blog") <code>echo $dialect->tableExists("posts")



public *string*  **describeColumns** (*string* $table, *string* $schema)

Generates a SQL describing a table <code>print_r($dialect->describeColumns("posts") ?>



public *array*  **listTables** (*string* $schemaName)

List all tables on database <code>print_r($dialect->listTables("blog") ?>



public *string*  **describeIndexes** (*string* $table, *string* $schema)

Generates SQL to query indexes on a table



public *string*  **describeReferences** (*string* $table, *string* $schema)

Generates SQL to query foreign keys on a table



public *string*  **tableOptions** (*string* $table, *string* $schema)

Generates the SQL to describe the table creation options



public *string*  **limit** (*string* $sqlQuery, *int* $number) inherited from Phalcon\\Db\\Dialect

Generates the SQL for LIMIT clause



public *string*  **forUpdate** (*string* $sqlQuery) inherited from Phalcon\\Db\\Dialect

Returns a SQL modified with a FOR UPDATE clause



public *string*  **sharedLock** (*string* $sqlQuery) inherited from Phalcon\\Db\\Dialect

Returns a SQL modified with a LOCK IN SHARE MODE clause



<<<<<<< HEAD
=======
public *string*  **getColumnList** (*array* $columnList) inherited from Phalcon\\Db\\Dialect

Gets a list of columns



public *string*  **getSqlExpression** (*array* $expression, *string* $escapeChar) inherited from Phalcon\\Db\\Dialect

Transform an intermediate representation for a expression into a database system valid expression



public *string*  **getSqlTable** (*unknown* $table, *string* $escapeChar) inherited from Phalcon\\Db\\Dialect

Transform an intermediate representation for a schema/table into a database system valid expression



>>>>>>> 0.7.0
public *string*  **select** (*array* $definition) inherited from Phalcon\\Db\\Dialect

Builds a SELECT statement



