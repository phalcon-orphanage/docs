Class **Phalcon\\Db\\Adapter\\Pdo\\Postgresql**
===============================================

*extends* :doc:`Phalcon\\Db\\Adapter\\Pdo <Phalcon_Db_Adapter_Pdo>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>`

Specific functions for the Postgresql database system 

.. code-block:: php

    <?php

     $config = array(
      "host" => "192.168.0.11",
      "dbname" => "blog",
      "username" => "postgres",
      "password" => ""
     );
    
     $connection = new Phalcon\Db\Adapter\Pdo\Postgresql($config);



Methods
---------

public *boolean*  **connect** (*array* $descriptor)

This method is automatically called in Phalcon\\Db\\Adapter\\Pdo constructor. Call it when you need to restore a database connection. Support set search_path after connectted if schema is specified in config.



public :doc:`Phalcon\\Db\\Column <Phalcon_Db_Column>` [] **describeColumns** (*string* $table, *string* $schema)

Returns an array of Phalcon\\Db\\Column objects describing a table <code>print_r($connection->describeColumns("posts")); ?>



public :doc:`Phalcon\\Db\\RawValue <Phalcon_Db_RawValue>`  **getDefaultIdValue** ()

Return the default identity value to insert in an identity column



public *boolean*  **supportSequences** ()

Check whether the database system requires a sequence to produce auto-numeric values



public  **__construct** (*array* $descriptor) inherited from Phalcon\\Db\\Adapter\\Pdo

Constructor for Phalcon\\Db\\Adapter\\Pdo



protected *\PDOStatement*  **_executePrepared** () inherited from Phalcon\\Db\\Adapter\\Pdo

Executes a prepared statement binding



public :doc:`Phalcon\\Db\\ResultInterface <Phalcon_Db_ResultInterface>`  **query** (*string* $sqlStatement, *array* $bindParams, *array* $bindTypes) inherited from Phalcon\\Db\\Adapter\\Pdo

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server is returning rows 

.. code-block:: php

    <?php

    //Querying data

$resultset = $connection->query("SELECT * FROM robots WHERE type='mechanical'"); $resultset = $connection->query("SELECT * FROM robots WHERE type=?", array("mechanical"));



public *boolean*  **execute** (*string* $sqlStatement, *unknown* $bindParams, *unknown* $bindTypes) inherited from Phalcon\\Db\\Adapter\\Pdo

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server don't return any row 

.. code-block:: php

    <?php

    //Inserting data
    $success = $connection->execute("INSERT INTO robots VALUES (1, 'Astro Boy')");
    $success = $connection->execute("INSERT INTO robots VALUES (?, ?)", array(1, 'Astro Boy'));




public *int*  **affectedRows** () inherited from Phalcon\\Db\\Adapter\\Pdo

Returns the number of affected rows by the last INSERT/UPDATE/DELETE reported by the database system 

.. code-block:: php

    <?php

    $connection->query("DELETE FROM robots");
    echo $connection->affectedRows(), ' were deleted';




public *boolean*  **close** () inherited from Phalcon\\Db\\Adapter\\Pdo

Closes active connection returning success. Phalcon automatically closes and destroys active connections within Phalcon\\Db\\Pool



public *string*  **escapeIdentifier** (*string* $identifier) inherited from Phalcon\\Db\\Adapter\\Pdo

Escapes a column/table/schema name



public *string*  **escapeString** (*string* $str) inherited from Phalcon\\Db\\Adapter\\Pdo

Escapes a value to avoid SQL injections



public  **bindParams** (*unknown* $sqlStatement, *array* $params) inherited from Phalcon\\Db\\Adapter\\Pdo

Bind params to a SQL statement



public *array*  **convertBoundParams** (*string* $sql, *array* $params) inherited from Phalcon\\Db\\Adapter\\Pdo

Converts bound params such as :name: or ?1 into PDO bind params ?



public *int*  **lastInsertId** (*string* $sequenceName) inherited from Phalcon\\Db\\Adapter\\Pdo

Returns insert id for the auto_increment column inserted in the last SQL statement



public *boolean*  **begin** () inherited from Phalcon\\Db\\Adapter\\Pdo

Starts a transaction in the connection



public *boolean*  **rollback** () inherited from Phalcon\\Db\\Adapter\\Pdo

Rollbacks the active transaction in the connection



public *boolean*  **commit** () inherited from Phalcon\\Db\\Adapter\\Pdo

Commits the active transaction in the connection



public *boolean*  **isUnderTransaction** () inherited from Phalcon\\Db\\Adapter\\Pdo

Checks whether connection is under database transaction



public *\PDO*  **getInternalHandler** () inherited from Phalcon\\Db\\Adapter\\Pdo

Return internal PDO handler



public :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>` [] **describeIndexes** (*string* $table, *string* $schema) inherited from Phalcon\\Db\\Adapter\\Pdo

Lists table indexes



public :doc:`Phalcon\\Db\\Reference <Phalcon_Db_Reference>` [] **describeReferences** (*string* $table, *string* $schema) inherited from Phalcon\\Db\\Adapter\\Pdo

Lists table references



public *array*  **tableOptions** (*string* $tableName, *string* $schemaName) inherited from Phalcon\\Db\\Adapter\\Pdo

Gets creation options from a table



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from Phalcon\\Db\\Adapter

Sets the event manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** () inherited from Phalcon\\Db\\Adapter

Returns the internal event manager



public *array*  **fetchOne** (*string* $sqlQuery, *int* $fetchMode, *array* $bindParams, *array* $bindTypes) inherited from Phalcon\\Db\\Adapter

Returns the first row in a SQL query result 

.. code-block:: php

    <?php

    //Getting first robot
    $robot = $connection->fecthOne("SELECT * FROM robots");
    print_r($robot);
    
    //Getting first robot with associative indexes only
    $robot = $connection->fecthOne("SELECT * FROM robots", Phalcon\Db::FETCH_ASSOC);
    print_r($robot);




public *array*  **fetchAll** (*string* $sqlQuery, *int* $fetchMode, *array* $bindParams, *array* $bindTypes) inherited from Phalcon\\Db\\Adapter

Dumps the complete result of a query into an array 

.. code-block:: php

    <?php

    //Getting all robots
    $robots = $connection->fetchAll("SELECT * FROM robots");
    foreach($robots as $robot){
    	print_r($robot);
    }
    
    //Getting all robots with associative indexes only
    $robots = $connection->fetchAll("SELECT * FROM robots", Phalcon\Db::FETCH_ASSOC);
    foreach($robots as $robot){
    	print_r($robot);
    }




public *boolean*  **insert** (*string* $table, *array* $values, *array* $fields, *array* $dataTypes) inherited from Phalcon\\Db\\Adapter

Inserts data into a table using custom RBDM SQL syntax 

.. code-block:: php

    <?php

     //Inserting a new robot
     $success = $connection->insert(
         "robots",
         array("Astro Boy", 1952),
         array("name", "year")
     );
    
     //Next SQL sentence is sent to the database system
     INSERT INTO `robots` (`name`, `year`) VALUES ("Astro boy", 1952);




public *boolean*  **update** (*string* $table, *array* $fields, *array* $values, *string* $whereCondition, *array* $dataTypes) inherited from Phalcon\\Db\\Adapter

Updates data on a table using custom RBDM SQL syntax 

.. code-block:: php

    <?php

     //Updating existing robot
     $success = $connection->update(
         "robots",
         array("name")
         array("New Astro Boy"),
         "id = 101"
     );
    
     //Next SQL sentence is sent to the database system
     UPDATE `robots` SET `name` = "Astro boy" WHERE id = 101




public *boolean*  **delete** (*string* $table, *string* $whereCondition, *array* $placeholders, *array* $dataTypes) inherited from Phalcon\\Db\\Adapter

Deletes data from a table using custom RBDM SQL syntax 

.. code-block:: php

    <?php

     //Deleting existing robot
     $success = $connection->delete(
         "robots",
         "id = 101"
     );
    
     //Next SQL sentence is generated
     DELETE FROM `robots` WHERE `id` = 101




public *string*  **getColumnList** (*array* $columnList) inherited from Phalcon\\Db\\Adapter

Gets a list of columns



public *string*  **limit** (*string* $sqlQuery, *int* $number) inherited from Phalcon\\Db\\Adapter

Appends a LIMIT clause to $sqlQuery argument 

.. code-block:: php

    <?php

     $connection->limit("SELECT * FROM robots", 5);




public *string*  **tableExists** (*string* $tableName, *string* $schemaName) inherited from Phalcon\\Db\\Adapter

Generates SQL checking for the existence of a schema.table 

.. code-block:: php

    <?php

     $connection->tableExists("blog", "posts")




public *string*  **viewExists** (*string* $viewName, *string* $schemaName) inherited from Phalcon\\Db\\Adapter

Generates SQL checking for the existence of a schema.view 

.. code-block:: php

    <?php

     $connection->viewExists("active_users", "posts")




public *string*  **forUpdate** (*string* $sqlQuery) inherited from Phalcon\\Db\\Adapter

Returns a SQL modified with a FOR UPDATE clause



public *string*  **sharedLock** (*string* $sqlQuery) inherited from Phalcon\\Db\\Adapter

Returns a SQL modified with a LOCK IN SHARE MODE clause



public *boolean*  **createTable** (*string* $tableName, *string* $schemaName, *array* $definition) inherited from Phalcon\\Db\\Adapter

Creates a table



public *boolean*  **dropTable** (*string* $tableName, *string* $schemaName, *boolean* $ifExists) inherited from Phalcon\\Db\\Adapter

Drops a table from a schema/database



public *boolean*  **addColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column) inherited from Phalcon\\Db\\Adapter

Adds a column to a table



public *boolean*  **modifyColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column) inherited from Phalcon\\Db\\Adapter

Modifies a table column based on a definition



public *boolean*  **dropColumn** (*string* $tableName, *string* $schemaName, *string* $columnName) inherited from Phalcon\\Db\\Adapter

Drops a column from a table



public *boolean*  **addIndex** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index) inherited from Phalcon\\Db\\Adapter

Adds an index to a table



public *boolean*  **dropIndex** (*string* $tableName, *string* $schemaName, *string* $indexName) inherited from Phalcon\\Db\\Adapter

Drop an index from a table



public *boolean*  **addPrimaryKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index) inherited from Phalcon\\Db\\Adapter

Adds a primary key to a table



public *boolean*  **dropPrimaryKey** (*string* $tableName, *string* $schemaName) inherited from Phalcon\\Db\\Adapter

Drops primary key from a table



public *boolean true*  **addForeignKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ReferenceInterface <Phalcon_Db_ReferenceInterface>` $reference) inherited from Phalcon\\Db\\Adapter

Adds a foreign key to a table



public *boolean true*  **dropForeignKey** (*string* $tableName, *string* $schemaName, *string* $referenceName) inherited from Phalcon\\Db\\Adapter

Drops a foreign key from a table



public *string*  **getColumnDefinition** (:doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column) inherited from Phalcon\\Db\\Adapter

Returns the SQL column definition from a column



public *array*  **listTables** (*string* $schemaName) inherited from Phalcon\\Db\\Adapter

List all tables on a database <code> print_r($connection->listTables("blog") ?>



public *array*  **getDescriptor** () inherited from Phalcon\\Db\\Adapter

Return descriptor used to connect to the active database



public *string*  **getConnectionId** () inherited from Phalcon\\Db\\Adapter

Gets the active connection unique identifier



public *string*  **getSQLStatement** () inherited from Phalcon\\Db\\Adapter

Active SQL statement in the object



public *string*  **getRealSQLStatement** () inherited from Phalcon\\Db\\Adapter

Active SQL statement in the object without replace bound paramters



public *array*  **getSQLVariables** () inherited from Phalcon\\Db\\Adapter

Active SQL statement in the object



public *array*  **getSQLBindTypes** () inherited from Phalcon\\Db\\Adapter

Active SQL statement in the object



public *string*  **getType** () inherited from Phalcon\\Db\\Adapter

Returns type of database system the adapter is used for



public *string*  **getDialectType** () inherited from Phalcon\\Db\\Adapter

Returns the name of the dialect used



public :doc:`Phalcon\\Db\\DialectInterface <Phalcon_Db_DialectInterface>`  **getDialect** () inherited from Phalcon\\Db\\Adapter

Returns internal dialect instance



