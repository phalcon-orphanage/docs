Class **Phalcon\\Db\\Dialect\\Mysql**
=====================================

*extends* :doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>`

Methods
---------

*string* public **getColumnList** (*array* $columnList)

Gets a list of columns



public **getColumnDefinition** (*Phalcon\Db\Column* $column)

Gets the column name in MySQL



*string* public **addColumn** (*string* $tableName, *string* $schemaName, *Phalcon\Db\Column* $column)

Generates SQL to add a column to a table



*string* public **modifyColumn** (*string* $tableName, *string* $schemaName, *Phalcon\Db\Column* $column)

Generates SQL to modify a column in a table



*string* public **dropColumn** (*string* $tableName, *string* $schemaName, *string* $columnName)

Generates SQL to delete a column from a table



*string* public **addIndex** (*string* $tableName, *string* $schemaName, *Phalcon\Db\Index* $index)

Generates SQL to add an index to a table



*string* public **dropIndex** (*string* $tableName, *string* $schemaName, *string* $indexName)

Generates SQL to delete an index from a table



*string* public **addPrimaryKey** (*string* $tableName, *string* $schemaName, *Phalcon\Db\Index* $index)

Generates SQL to add the primary key to a table



*string* public **dropPrimaryKey** (*string* $tableName, *string* $schemaName)

Generates SQL to delete primary key from a table



*string* public **addForeignKey** (*string* $tableName, *string* $schemaName, *Phalcon\Db\Reference* $reference)

Generates SQL to add an index to a table



*string* public **dropForeignKey** (*string* $tableName, *string* $schemaName, *string* $referenceName)

Generates SQL to delete a foreign key from a table



*array* protected **_getTableOptions** ()

Generates SQL to add the table creation options



*string* public **createTable** (*string* $tableName, *string* $schemaName, *array* $definition)

Generates SQL to create a table in MySQL



*boolean* public **dropTable** (*string* $tableName, *string* $schemaName, *boolean* $ifExists)

Generates SQL to drop a table



*string* public **tableExists** (*string* $tableName, *string* $schemaName)

Generates SQL checking for the existence of a schema.table <code>echo $dialect->tableExists("posts", "blog") <code>echo $dialect->tableExists("posts")



*string* public **describeColumns** (*string* $table, *string* $schema)

Generates SQL describing a table <code>print_r($dialect->describeColumns("posts") ?>



*array* public **listTables** (*string* $schemaName)

List all tables on database <code>print_r($dialect->listTables("blog") ?>



*string* public **describeIndexes** (*string* $table, *string* $schema)

Generates SQL to query indexes on a table



*string* public **describeReferences** (*string* $table, *string* $schema)

Generates SQL to query foreign keys on a table



*string* public **tableOptions** (*string* $table, *string* $schema)

Generates the SQL to describe the table creation options



public **limit** (*unknown* $sqlQuery, *unknown* $number)

public **forUpdate** (*unknown* $sqlQuery)

public **sharedLock** (*unknown* $sqlQuery)

public **select** (*unknown* $definition)

