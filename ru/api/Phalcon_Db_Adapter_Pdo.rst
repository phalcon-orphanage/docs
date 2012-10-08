Class **Phalcon\\Db\\Adapter\\Pdo**
===================================

*extends* :doc:`Phalcon\\Db <Phalcon_Db>`

Phalcon\\Db\\Adapter\\Pdo is the Phalcon\\Db that internally uses PDO to connect to a database 

.. code-block:: php

    <?php

     $connection = new Phalcon\Db\Adapter\Pdo\Mysql(array(
      'host' => '192.168.0.11',
      'username' => 'sigma',
      'password' => 'secret',
      'dbname' => 'blog',
      'port' => '3306',
     ));



Constants
---------

*integer* **FETCH_ASSOC**

*integer* **FETCH_BOTH**

*integer* **FETCH_NUM**

Methods
---------

public  **__construct** (*array* $descriptor)

Constructor for Phalcon\\Db\\Adapter\\Pdo



public *boolean*  **connect** (*array* $descriptor)

This method is automatically called in Phalcon\\Db\\Adapter\\Pdo constructor. Call it when you need to restore a database connection



public :doc:`Phalcon\\Db\\Result\\Pdo <Phalcon_Db_Result_Pdo>`  **query** (*string* $sqlStatement, *array* $placeholders)

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server return rows 

.. code-block:: php

    <?php

    //Querying data

$resultset = $connection->query("SELECT * FROM robots WHERE type='mechanical'"); $resultset = $connection->query("SELECT * FROM robots WHERE type=?", array("mechanical"));



public *boolean*  **execute** (*string* $sqlStatement, *array* $placeholders)

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server don't return any row 

.. code-block:: php

    <?php

    //Inserting data
    $success = $connection->execute("INSERT INTO robots VALUES (1, 'Astro Boy')");
    $success = $connection->execute("INSERT INTO robots VALUES (?, ?)", array(1, 'Astro Boy'));




public *int*  **affectedRows** ()

Returns the number of affected rows by the last INSERT/UPDATE/DELETE repoted by the database system 

.. code-block:: php

    <?php

    $connection->query("DELETE FROM robots");
    echo $connection->affectedRows(), ' were deleted';




public *boolean*  **close** ()

Closes active connection returning success. Phalcon automatically closes and destroys active connections within Phalcon\\Db\\Pool



public *string*  **escapeString** (*string* $str)

Escapes a value to avoid SQL injections



public  **bindParams** (*string* $sqlSelect, *array* $params)

Bind params to SQL select



public *int*  **lastInsertId** (*string* $table, *string* $primaryKey, *string* $sequenceName)

Returns insert id for the auto_increment column inserted in the last SQL statement



public *boolean*  **begin** ()

Starts a transaction in the connection



public *boolean*  **rollback** ()

Rollbacks the active transaction in the connection



public *boolean*  **commit** ()

Commits the active transaction in the connection



public *boolean*  **isUnderTransaction** ()

Checks whether connection is under database transaction



public *PDO*  **getInternalHandler** ()

Return internal PDO handler



public :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>` [] **describeIndexes** (*string* $table, *string* $schema)

Lists table indexes



public :doc:`Phalcon\\Db\\Reference <Phalcon_Db_Reference>` [] **describeReferences** (*string* $table, *string* $schema)

Lists table references



public *array*  **tableOptions** (*string* $tableName, *string* $schemaName)

Gets creation options from a table



public  **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager) inherited from Phalcon\\Db

Sets the event manager



public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** () inherited from Phalcon\\Db

Returns the internal event manager



public *array*  **fetchOne** (*string* $sqlQuery, *int* $fetchMode) inherited from Phalcon\\Db

Returns the first row in a SQL query result 

.. code-block:: php

    <?php

    //Getting first robot
    $robot = $connection->fecthOne("SELECT * FROM robots");
    print_r($robot);
    
    //Getting first robot with associative indexes only
    $robot = $connection->fecthOne("SELECT * FROM robots", Phalcon\Db::FETCH_ASSOC);
    print_r($robot);




public *array*  **fetchAll** (*string* $sqlQuery, *int* $fetchMode) inherited from Phalcon\\Db

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




public *boolean*  **insert** (*string* $table, *array* $values, *array* $fields) inherited from Phalcon\\Db

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




public *boolean*  **update** (*string* $table, *array* $fields, *array* $values, *string* $whereCondition) inherited from Phalcon\\Db

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




public *boolean*  **delete** (*string* $table, *string* $whereCondition, *array* $placeholders) inherited from Phalcon\\Db

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




public *string*  **getColumnList** (*array* $columnList) inherited from Phalcon\\Db

Gets a list of columns



public *string*  **limit** (*string* $sqlQuery, *int* $number) inherited from Phalcon\\Db

Appends a LIMIT clause to $sqlQuery argument <code>$connection->limit("SELECT * FROM robots", 5);



public *string*  **tableExists** (*string* $tableName, *string* $schemaName) inherited from Phalcon\\Db

Generates SQL checking for the existence of a schema.table <code>$connection->tableExists("blog", "posts")



public *string*  **viewExists** (*string* $viewName, *string* $schemaName) inherited from Phalcon\\Db

Generates SQL checking for the existence of a schema.view <code>$connection->viewExists("active_users", "posts")



public *string*  **forUpdate** (*string* $sqlQuery) inherited from Phalcon\\Db

Returns a SQL modified with a FOR UPDATE clause



public *string*  **sharedLock** (*string* $sqlQuery) inherited from Phalcon\\Db

Returns a SQL modified with a LOCK IN SHARE MODE clause



public *boolean*  **createTable** (*string* $tableName, *string* $schemaName, *array* $definition) inherited from Phalcon\\Db

Creates a table using MySQL SQL



public *boolean*  **dropTable** (*string* $tableName, *string* $schemaName, *boolean* $ifExists) inherited from Phalcon\\Db

Drops a table from a schema/database



public *boolean*  **addColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Column <Phalcon_Db_Column>` $column) inherited from Phalcon\\Db

Adds a column to a table



public *boolean*  **modifyColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Column <Phalcon_Db_Column>` $column) inherited from Phalcon\\Db

Modifies a table column based on a definition



public *boolean*  **dropColumn** (*string* $tableName, *string* $schemaName, *string* $columnName) inherited from Phalcon\\Db

Drops a column from a table



public *boolean*  **addIndex** (*string* $tableName, *string* $schemaName, *DbIndex* $index) inherited from Phalcon\\Db

Adds an index to a table



public *boolean*  **dropIndex** (*string* $tableName, *string* $schemaName, *string* $indexName) inherited from Phalcon\\Db

Drop an index from a table



public *boolean*  **addPrimaryKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>` $index) inherited from Phalcon\\Db

Adds a primary key to a table



public *boolean*  **dropPrimaryKey** (*string* $tableName, *string* $schemaName) inherited from Phalcon\\Db

Drops primary key from a table



public *boolean true*  **addForeignKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Reference <Phalcon_Db_Reference>` $reference) inherited from Phalcon\\Db

Adds a foreign key to a table



public *boolean true*  **dropForeignKey** (*string* $tableName, *string* $schemaName, *string* $referenceName) inherited from Phalcon\\Db

Drops a foreign key from a table



public *string*  **getColumnDefinition** (:doc:`Phalcon\\Db\\Column <Phalcon_Db_Column>` $column) inherited from Phalcon\\Db

Returns the SQL column definition from a column



public *array*  **listTables** (*string* $schemaName) inherited from Phalcon\\Db

List all tables on a database <code> print_r($connection->listTables("blog") ?>



public *string*  **getDescriptor** () inherited from Phalcon\\Db

Return descriptor used to connect to the active database



public *string*  **getConnectionId** () inherited from Phalcon\\Db

Gets the active connection unique identifier



public  **getSQLStatement** () inherited from Phalcon\\Db

Active SQL statement in the object



public *string*  **getType** () inherited from Phalcon\\Db

Returns type of database system the adapter is used for



public *string*  **getDialectType** () inherited from Phalcon\\Db

Returns the name of the dialect used



public :doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>`  **getDialect** () inherited from Phalcon\\Db

Returns internal dialect instance



