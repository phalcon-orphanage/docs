Class **Phalcon\\Db\\Dialect\\Postgresql**
==========================================

*extends* :doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>`

Generates database specific SQL for the PostgreSQL RBDM


Methods
---------

*string* public **getColumnList** (*array* $columnList)

Gets a list of columns



public static **getColumnDefinition** (:doc:`Phalcon\\Db\\Column <Phalcon_Db_Column>` $column)

Gets the column name in PostgreSQL



*string* public static **addColumn** ()

Generates SQL to add a column to a table



*string* public static **modifyColumn** ()

Generates SQL to modify a column in a table



*string* public static **dropColumn** ()

Generates SQL to delete a column from a table



*string* public static **addIndex** ()

Generates SQL to add an index to a table



*string* public static **dropIndex** ()

Generates SQL to delete an index from a table



*string* public static **addPrimaryKey** ()

Generates SQL to add the primary key to a table



*string* public static **dropPrimaryKey** ()

Generates SQL to delete primary key from a table



*string* public static **addForeignKey** ()

Generates SQL to add an index to a table



*string* public static **dropForeignKey** ()

Generates SQL to delete a foreign key from a table



*array* protected **_getTableOptions** ()

Generates SQL to add the table creation options



*string* public **createTable** ()

Generates SQL to create a table in PostgreSQL



*boolean* public **dropTable** (*string* $tableName, *string* $schemaName, *boolean* $ifExists)

Generates SQL to drop a table



*string* public static **tableExists** (*string* $tableName, *string* $schemaName)

Generates SQL checking for the existence of a schema.table <code>echo $dialect->tableExists("posts", "blog") <code>echo $dialect->tableExists("posts")



*string* public **describeColumns** (*string* $table, *string* $schema)

Generates a SQL describing a table <code>print_r($dialect->describeColumns("posts") ?>



*array* public **listTables** (*string* $schemaName)

List all tables on database <code>print_r($dialect->listTables("blog") ?>



*string* public **describeIndexes** (*string* $table, *string* $schema)

Generates SQL to query indexes on a table



*string* public **describeReferences** (*string* $table, *string* $schema)

Generates SQL to query foreign keys on a table



*string* public **tableOptions** (*string* $table, *string* $schema)

Generates the SQL to describe the table creation options



*string* public **limit** (*string* $sqlQuery, *int* $number) inherited from Phalcon_Db_Dialect

Generates the SQL for LIMIT clause



*string* public **forUpdate** (*string* $sqlQuery) inherited from Phalcon_Db_Dialect

Returns a SQL modified with a FOR UPDATE clause



*string* public **sharedLock** (*string* $sqlQuery) inherited from Phalcon_Db_Dialect

Returns a SQL modified with a LOCK IN SHARE MODE clause



*string* public **select** (*array* $definition) inherited from Phalcon_Db_Dialect

Builds a SELECT statement



