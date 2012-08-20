Class **Phalcon_Db_Dialect_Mysql**
==================================

Generates database specific SQL for the MySQL RBDM

Methods
---------

**string** **limit** (string $sqlQuery, int $number)

Generates the SQL for a MySQL LIMIT clause

**string** **getColumnList** (array $columnList)

Gets a list of columns

**getColumnDefinition** (Phalcon\Db\Column $column)

Gets the column name in MySQL

**string** **addColumn** (string $tableName, string $schemaName, Phalcon\Db\Column $column)

Generates SQL to add a column to a table

**string** **modifyColumn** (string $tableName, string $schemaName, Phalcon\Db\Column $column)

Generates SQL to modify a column in a table

**string** **dropColumn** (string $tableName, string $schemaName, string $columnName)

Generates SQL to delete a column from a table

**string** **addIndex** (string $tableName, string $schemaName, Phalcon\Db\Index $index)

Generates SQL to add an index to a table

**string** **dropIndex** (string $tableName, string $schemaName, string $indexName)

Generates SQL to delete an index from a table

**string** **addPrimaryKey** (string $tableName, string $schemaName, Phalcon\Db\Index $index)

Generates SQL to add the primary key to a table

**string** **dropPrimaryKey** (string $tableName, string $schemaName)

Generates SQL to delete primary key from a table

**string** **addForeignKey** (string $tableName, string $schemaName, Phalcon\Db\Reference $reference)

Generates SQL to add an index to a table

**string** **dropForeignKey** (string $tableName, string $schemaName, string $referenceName)

Generates SQL to delete a foreign key from a table

**array** **_getTableOptions** (array $definition)

Generates SQL to add the table creation options

**string** **createTable** (string $tableName, string $schemaName, array $definition)

Generates SQL to create a table in MySQL

**boolean** **dropTable** (string $tableName, string $schemaName, boolean $ifExists)

Generates SQL to drop a table

**string** **tableExists** (string $tableName, string $schemaName)

Generates SQL checking for the existence of a schema.table  

.. code-block:: php

    <?php 

    echo Phalcon_Db_Dialect_Mysql::tableExists("posts");

.. code-block:: php

    <?php 

    echo Phalcon_Db_Dialect_Mysql::tableExists("posts");

**string** **describeTable** (string $table, string $schema)

Generates SQL describing a table  

.. code-block:: php

    <?php 

    print_r(Phalcon_Db_Dialect_Mysql::describeTable("posts");

**array** **listTables** (string $schemaName)

List all tables on database  

.. code-block:: php

    <?php 

    print_r(Phalcon_Db_Dialect_Mysql::listTables("blog");

**string** **describeIndexes** (string $table, string $schema)

Generates SQL to query indexes on a table

**string** **describeReferences** (string $table, string $schema)

Generates SQL to query foreign keys on a table

**string** **tableOptions** (string $table, string $schema)

Generates the SQL to describe the table creation options

