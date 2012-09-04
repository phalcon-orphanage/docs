Class **Phalcon\\Db\\Dialect\\Postgresql**
==========================================

*extends* :doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>`

Generates database specific SQL for the PostgreSQL RBDM


Methods
---------

*string* public static **getColumnList** (*array* $columnList)

Gets a list of columns



public static **getColumnDefinition** (*Phalcon\Db\Column* $column)

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



*array* protected static **_getTableOptions** ()

Generates SQL to add the table creation options



*string* public static **createTable** ()

Generates SQL to create a table in PostgreSQL



*boolean* public **dropTable** (*string* $tableName, *string* $schemaName, *boolean* $ifExists)

Generates SQL to drop a table



*string* public static **tableExists** (*string* $tableName, *string* $schemaName)

Generates SQL checking for the existence of a schema.table <code>echo $dialect->tableExists("posts", "blog") <code>echo $dialect->tableExists("posts")



*string* public static **describeColumns** (*string* $table, *string* $schema)

Generates a SQL describing a table <code>print_r($dialect->describeColumns("posts") ?>



*array* public static **listTables** (*string* $schemaName)

List all tables on database <code>print_r($dialect->listTables("blog") ?>



*string* public static **describeIndexes** (*string* $table, *string* $schema)

Generates SQL to query indexes on a table



*string* public static **describeReferences** (*string* $table, *string* $schema)

Generates SQL to query foreign keys on a table



*string* public static **tableOptions** (*string* $table, *string* $schema)

Generates the SQL to describe the table creation options



public **limit** (*unknown* $sqlQuery, *unknown* $number)

public **forUpdate** (*unknown* $sqlQuery)

public **sharedLock** (*unknown* $sqlQuery)

public **select** (*unknown* $definition)

