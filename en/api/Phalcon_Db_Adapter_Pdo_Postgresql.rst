Class **Phalcon\\Db\\Adapter\\Pdo\\Postgresql**
===============================================

*extends* :doc:`Phalcon\\Db\\Adapter\\Pdo <Phalcon_Db_Adapter_Pdo>`

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



Constants
---------

*integer* **FETCH_ASSOC**

*integer* **FETCH_BOTH**

*integer* **FETCH_NUM**

Methods
---------

*boolean* public **connect** (*array* $descriptor)

This method is automatically called in Phalcon\\Db\\Adapter\\Pdo constructor. Call it when you need to restore a database connection. Support set search_path after connectted if schema is specified in config.



:doc:`Phalcon\\Db\\Column <Phalcon_Db_Column>` []public **describeColumns** (*string* $table, *string* $schema)

Returns an array of Phalcon\\Db\\Column objects describing a table <code>print_r($connection->describeColumns("posts")); ?>



public **__construct** (*array* $descriptor) inherited from Phalcon_Db_Adapter_Pdo

Constructor for Phalcon\\Db\\Adapter\\Pdo



:doc:`Phalcon\\Db\\Result\\Pdo <Phalcon_Db_Result_Pdo>` public **query** (*string* $sqlStatement, *array* $placeholders) inherited from Phalcon_Db_Adapter_Pdo

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server return rows 

.. code-block:: php

    <?php

    //Querying data

$resultset = $connection->query("SELECT * FROM robots WHERE type='mechanical'"); $resultset = $connection->query("SELECT * FROM robots WHERE type=?", array("mechanical"));



*boolean* public **execute** (*string* $sqlStatement, *array* $placeholders) inherited from Phalcon_Db_Adapter_Pdo

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server don't return any row 

.. code-block:: php

    <?php

    //Inserting data
    $success = $connection->execute("INSERT INTO robots VALUES (1, 'Astro Boy')");
    $success = $connection->execute("INSERT INTO robots VALUES (?, ?)", array(1, 'Astro Boy'));




*int* public **affectedRows** () inherited from Phalcon_Db_Adapter_Pdo

Returns the number of affected rows by the last INSERT/UPDATE/DELETE repoted by the database system 

.. code-block:: php

    <?php

    $connection->query("DELETE FROM robots");
    echo $connection->affectedRows(), ' were deleted';




*boolean* public **close** () inherited from Phalcon_Db_Adapter_Pdo

Closes active connection returning success. Phalcon automatically closes and destroys active connections within Phalcon\\Db\\Pool



*string* public **escapeString** (*string* $str) inherited from Phalcon_Db_Adapter_Pdo

Escapes a value to avoid SQL injections



public **bindParams** (*string* $sqlSelect, *array* $params) inherited from Phalcon_Db_Adapter_Pdo

Bind params to SQL select



*int* public **lastInsertId** (*string* $table, *string* $primaryKey, *string* $sequenceName) inherited from Phalcon_Db_Adapter_Pdo

Returns insert id for the auto_increment column inserted in the last SQL statement



*boolean* public **begin** () inherited from Phalcon_Db_Adapter_Pdo

Starts a transaction in the connection



*boolean* public **rollback** () inherited from Phalcon_Db_Adapter_Pdo

Rollbacks the active transaction in the connection



*boolean* public **commit** () inherited from Phalcon_Db_Adapter_Pdo

Commits the active transaction in the connection



*boolean* public **isUnderTransaction** () inherited from Phalcon_Db_Adapter_Pdo

Checks whether connection is under database transaction



*PDO* public **getInternalHandler** () inherited from Phalcon_Db_Adapter_Pdo

Return internal PDO handler



:doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>` []public **describeIndexes** (*string* $table, *string* $schema) inherited from Phalcon_Db_Adapter_Pdo

Lists table indexes



:doc:`Phalcon\\Db\\Reference <Phalcon_Db_Reference>` []public **describeReferences** (*string* $table, *string* $schema) inherited from Phalcon_Db_Adapter_Pdo

Lists table references



*array* public **tableOptions** (*string* $tableName, *string* $schemaName) inherited from Phalcon_Db_Adapter_Pdo

Gets creation options from a table



public **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager) inherited from Phalcon_Db

Sets the event manager



:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` public **getEventsManager** () inherited from Phalcon_Db

Returns the internal event manager



*array* public **fetchOne** (*string* $sqlQuery, *int* $fetchMode) inherited from Phalcon_Db

Returns the first row in a SQL query result 

.. code-block:: php

    <?php

    //Getting first robot
    $robot = $connection->fecthOne("SELECT * FROM robots");
    print_r($robot);
    
    //Getting first robot with associative indexes only
    $robot = $connection->fecthOne("SELECT * FROM robots", Phalcon\Db::FETCH_ASSOC);
    print_r($robot);




*array* public **fetchAll** (*string* $sqlQuery, *int* $fetchMode) inherited from Phalcon_Db

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




*boolean* public **insert** (*string* $table, *array* $values, *array* $fields) inherited from Phalcon_Db

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




*boolean* public **update** (*string* $table, *array* $fields, *array* $values, *string* $whereCondition) inherited from Phalcon_Db

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




*boolean* public **delete** (*string* $table, *string* $whereCondition, *array* $placeholders) inherited from Phalcon_Db

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




*string* public **getColumnList** (*array* $columnList) inherited from Phalcon_Db

Gets a list of columns



*string* public **limit** (*string* $sqlQuery, *int* $number) inherited from Phalcon_Db

Appends a LIMIT clause to $sqlQuery argument <code>$connection->limit("SELECT * FROM robots", 5);



*string* public **tableExists** (*string* $tableName, *string* $schemaName) inherited from Phalcon_Db

Generates SQL checking for the existence of a schema.table <code>$connection->tableExists("blog", "posts")



*string* public **viewExists** (*string* $viewName, *string* $schemaName) inherited from Phalcon_Db

Generates SQL checking for the existence of a schema.view <code>$connection->viewExists("active_users", "posts")



*string* public **forUpdate** (*string* $sqlQuery) inherited from Phalcon_Db

Returns a SQL modified with a FOR UPDATE clause



*string* public **sharedLock** (*string* $sqlQuery) inherited from Phalcon_Db

Returns a SQL modified with a LOCK IN SHARE MODE clause



*boolean* public **createTable** (*string* $tableName, *string* $schemaName, *array* $definition) inherited from Phalcon_Db

Creates a table using MySQL SQL



*boolean* public **dropTable** (*string* $tableName, *string* $schemaName, *boolean* $ifExists) inherited from Phalcon_Db

Drops a table from a schema/database



*boolean* public **addColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Column <Phalcon_Db_Column>` $column) inherited from Phalcon_Db

Adds a column to a table



*boolean* public **modifyColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Column <Phalcon_Db_Column>` $column) inherited from Phalcon_Db

Modifies a table column based on a definition



*boolean* public **dropColumn** (*string* $tableName, *string* $schemaName, *string* $columnName) inherited from Phalcon_Db

Drops a column from a table



*boolean* public **addIndex** (*string* $tableName, *string* $schemaName, *DbIndex* $index) inherited from Phalcon_Db

Adds an index to a table



*boolean* public **dropIndex** (*string* $tableName, *string* $schemaName, *string* $indexName) inherited from Phalcon_Db

Drop an index from a table



*boolean* public **addPrimaryKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>` $index) inherited from Phalcon_Db

Adds a primary key to a table



*boolean* public **dropPrimaryKey** (*string* $tableName, *string* $schemaName) inherited from Phalcon_Db

Drops primary key from a table



*boolean true* public **addForeignKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Reference <Phalcon_Db_Reference>` $reference) inherited from Phalcon_Db

Adds a foreign key to a table



*boolean true* public **dropForeignKey** (*string* $tableName, *string* $schemaName, *string* $referenceName) inherited from Phalcon_Db

Drops a foreign key from a table



*string* public **getColumnDefinition** (:doc:`Phalcon\\Db\\Column <Phalcon_Db_Column>` $column) inherited from Phalcon_Db

Returns the SQL column definition from a column



*array* public **listTables** (*string* $schemaName) inherited from Phalcon_Db

List all tables on a database <code> print_r($connection->listTables("blog") ?>



*string* public **getDescriptor** () inherited from Phalcon_Db

Return descriptor used to connect to the active database



*string* public **getConnectionId** () inherited from Phalcon_Db

Gets the active connection unique identifier



public **getSQLStatement** () inherited from Phalcon_Db

Active SQL statement in the object



*string* public **getType** () inherited from Phalcon_Db

Returns type of database system the adapter is used for



*string* public **getDialectType** () inherited from Phalcon_Db

Returns the name of the dialect used



:doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>` public **getDialect** () inherited from Phalcon_Db

Returns internal dialect instance



