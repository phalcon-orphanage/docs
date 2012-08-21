Class **Phalcon_Db_Adapter_Mysql**
==================================

Phalcon_Db_Adapter_Mysql is the Phalcon_Db adapter for the MySQL database.  

.. code-block:: php

    <?php

    // Setting all posible parameters
    $config              = new stdClass();
    $config->host        = 'localhost';
    $config->username    = 'machine';
    $config->password    = 'sigma';
    $config->name        = 'swarm';
    $config->charset     = 'utf8';
    $config->collation   = 'utf8_unicode_ci';
    $config->compression = true;
    
    $connection = Phalcon_Db::factory('Mysql', $config);

Constants
---------

integer **DB_ASSOC**

integer **DB_BOTH**

integer **DB_NUM**

Methods
---------

**__construct** (stdClass $descriptor)

Constructor for Phalcon_Db_Adapter_Mysql. This method does not should to be called directly. Use Phalcon_Db::factory instead

**boolean** **connect** (stdClass $descriptor)

This method is automatically called in Phalcon_Db_Mysql constructor.  Call it when you need to restore a database connection

**Phalcon_Db_Result_Mysql|boolean** **query** (string $sqlStatement)

Sends SQL statements to the MySQL database server returning success state. When the SQL sent returns any row, the result is a PHP resource.  

.. code-block:: php

    <?php

    // Inserting data
    $success = $connection->query("INSERT INTO robots VALUES (1, 'Astro Boy')");
    $success = $connection->query("INSERT INTO robots VALUES (?, ?)", array(1, 'Astro Boy'));
    
    // Querying data
    $resultset = $connection->query("SELECT * FROM robots WHERE type='mechanical'");
    $resultset = $connection->query("SELECT * FROM robots WHERE type=?", array("mechanical"));

**int** **affectedRows** ()

Returns number of affected rows by the last INSERT/UPDATE/DELETE repoted by MySQL  

.. code-block:: php

    <?php
    
    $connection->query("DELETE FROM robots");
    echo $connection->affectedRows(), ' were deleted';
     
**boolean** **close** ()

Closes active connection returning success. Phalcon automatically closes and destroys active connections within Phalcon_Db_Pool

**string** **getConnectionId** (boolean $asString)

Gets the active connection unique identifier. A mysqli object

**string** **escapeString** (string $str)

Escapes a value to avoid SQL injections

**bindParams** (string $sqlSelect, array $params)

Bind params to SQL select

**string** **error** (string $errorString)

Returns last error message from MySQL

**int** **noError** (resurce $resultQuery)

Returns last error code from MySQL

**int** **lastInsertId** (string $table, string $primaryKey, string $sequenceName)

Returns insert id for the auto_increment column inserted in the last SQL statement

**string** **getColumnList** (array $columnList)

Gets a list of columns

**string** **limit** (string $sqlQuery, int $number)

Appends a LIMIT clause to $sqlQuery argument  

.. code-block:: php

    <?php

    $connection->limit("SELECT * FROM robots", 5);

**string** **tableExists** (string $tableName, string $schemaName)

Generates SQL checking for the existence of a schema.table  

.. code-block:: php

    <?php 

    $connection->tableExists("blog", "posts")

**string** **viewExists** (string $viewName, string $schemaName)

Generates SQL checking for the existence of a schema.view  

.. code-block:: php

    <?php 

    $connection->viewExists("active_users", "posts")

**string** **forUpdate** (string $sqlQuery)

Generates SQL with a valid FOR UPDATE statement on a SELECT of the RDBMS

**string** **sharedLock** (string $sqlQuery)

Generates SQL with a valid SHARED LOCK statement on a SELECT of the RDBMS

**boolean** **createTable** (string $tableName, string $schemaName, array $definition)

Creates a table using MySQL SQL

**boolean** **dropTable** (string $tableName, string $schemaName, boolean $ifExists)

Drops a table from a schema/database

**boolean** **addColumn** (string $tableName, string $schemaName, Phalcon_Db_Column $column)

Adds a column to a table

**boolean** **modifyColumn** (string $tableName, string $schemaName, Phalcon_Db_Column $column)

Modifies a table column based on a definition

**boolean** **dropColumn** (string $tableName, string $schemaName, string $columnName)

Drops a column from a table

**boolean** **addIndex** (string $tableName, string $schemaName, DbIndex $index)

Adds an index to a table

**boolean** **dropIndex** (string $tableName, string $schemaName, string $indexName)

Drop an index from a table

**boolean** **addPrimaryKey** (string $tableName, string $schemaName, Phalcon_Db_Index $index)

Adds a primary key to a table

**boolean** **dropPrimaryKey** (string $tableName, string $schemaName)

Drops primary key from a table

**boolean true** **addForeignKey** (string $tableName, string $schemaName, Phalcon_Db_Reference $reference)

Adds a foreign key to a table

**boolean true** **dropForeignKey** (string $tableName, string $schemaName, string $referenceName)

Drops a foreign key from a table

**string** **getColumnDefinition** (Phalcon_Db_Column $column)

Returns the SQL column definition from a column

**string** **describeTable** (string $table, string $schema)

Generates SQL describing a table  

.. code-block:: php

    <?php 

    print_r($connection->describeTable("posts")

**array** **listTables** (string $schemaName)

List all tables on a database  

.. code-block:: php

    <?php  

    print_r($connection->listTables("blog"));

**string** **getDateUsingFormat** (string $date, string $format)

Returns a database date formatted  

.. code-block:: php

    <?php 

    $format = $connection->getDateUsingFormat("2011-02-01", "YYYY-MM-DD");

**Phalcon_Db_Index[]** **describeIndexes** (string $table, string $schema)

Lists table indexes

**Phalcon_Db_Reference[]** **describeReferences** (string $table, string $schema)

Lists table references

**array** **tableOptions** (string $tableName, string $schemaName)

Gets creation options from a table

