Class **Phalcon\\Db\\Adapter\\Pdo**
===================================

<<<<<<< HEAD
*extends* :doc:`Phalcon\\Db <Phalcon_Db>`

Phalcon\\Db\\Adapter\\Pdo is the Phalcon\\Db that internally uses PDO to connect to a database 
=======
*extends* :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

Phalcon\\Db\\Adapter\\Pdo is the Phalcon\\Db that internally uses PDO to connect to a database  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

     $connection = new Phalcon\Db\Adapter\Pdo\Mysql(array(
      'host' => '192.168.0.11',
      'username' => 'sigma',
      'password' => 'secret',
      'dbname' => 'blog',
      'port' => '3306',
     ));



<<<<<<< HEAD
Constants
---------

*integer* **FETCH_ASSOC**

*integer* **FETCH_BOTH**

*integer* **FETCH_NUM**

=======
>>>>>>> 0.7.0
Methods
---------

public  **__construct** (*array* $descriptor)

Constructor for Phalcon\\Db\\Adapter\\Pdo



public *boolean*  **connect** (*array* $descriptor)

This method is automatically called in Phalcon\\Db\\Adapter\\Pdo constructor. Call it when you need to restore a database connection



<<<<<<< HEAD
protected *PDOStatement*  **_executePrepared** ()
=======
public *\PDOStatement*  **executePrepared** (*\PDOStatement* $statement, *array* $placeholders, *array* $dataTypes)
>>>>>>> 0.7.0

Executes a prepared statement binding



<<<<<<< HEAD
public :doc:`Phalcon\\Db\\Result\\Pdo <Phalcon_Db_Result_Pdo>`  **query** (*string* $sqlStatement, *array* $placeholders, *array* $dataTypes)

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server return rows 
=======
public :doc:`Phalcon\\Db\\ResultInterface <Phalcon_Db_ResultInterface>`  **query** (*string* $sqlStatement, *array* $bindParams, *array* $bindTypes)

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server is returning rows 
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    //Querying data

$resultset = $connection->query("SELECT * FROM robots WHERE type='mechanical'"); $resultset = $connection->query("SELECT * FROM robots WHERE type=?", array("mechanical"));



<<<<<<< HEAD
public *boolean*  **execute** (*string* $sqlStatement, *array* $placeholders, *array* $dataTypes)
=======
public *boolean*  **execute** (*string* $sqlStatement, *unknown* $bindParams, *unknown* $bindTypes)
>>>>>>> 0.7.0

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server don't return any row 

.. code-block:: php

    <?php

    //Inserting data
    $success = $connection->execute("INSERT INTO robots VALUES (1, 'Astro Boy')");
    $success = $connection->execute("INSERT INTO robots VALUES (?, ?)", array(1, 'Astro Boy'));




public *int*  **affectedRows** ()

<<<<<<< HEAD
Returns the number of affected rows by the last INSERT/UPDATE/DELETE repoted by the database system 
=======
Returns the number of affected rows by the last INSERT/UPDATE/DELETE reported by the database system 
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    $connection->query("DELETE FROM robots");
    echo $connection->affectedRows(), ' were deleted';




public *boolean*  **close** ()

Closes active connection returning success. Phalcon automatically closes and destroys active connections within Phalcon\\Db\\Pool



<<<<<<< HEAD
=======
public *string*  **escapeIdentifier** (*string* $identifier)

Escapes a column/table/schema name



>>>>>>> 0.7.0
public *string*  **escapeString** (*string* $str)

Escapes a value to avoid SQL injections



public  **bindParams** (*unknown* $sqlStatement, *array* $params)

Bind params to a SQL statement



public *array*  **convertBoundParams** (*string* $sql, *array* $params)

<<<<<<< HEAD
Converts bound params like :name: or ?1 into ? bind params
=======
Converts bound params such as :name: or ?1 into PDO bind params ?
>>>>>>> 0.7.0



public *int*  **lastInsertId** (*string* $sequenceName)

Returns insert id for the auto_increment column inserted in the last SQL statement



public *boolean*  **begin** ()

Starts a transaction in the connection



public *boolean*  **rollback** ()

Rollbacks the active transaction in the connection



public *boolean*  **commit** ()

Commits the active transaction in the connection



public *boolean*  **isUnderTransaction** ()

Checks whether connection is under database transaction



<<<<<<< HEAD
public *PDO*  **getInternalHandler** ()
=======
public *\PDO*  **getInternalHandler** ()
>>>>>>> 0.7.0

Return internal PDO handler



public :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>` [] **describeIndexes** (*string* $table, *string* $schema)

Lists table indexes



public :doc:`Phalcon\\Db\\Reference <Phalcon_Db_Reference>` [] **describeReferences** (*string* $table, *string* $schema)

Lists table references



public *array*  **tableOptions** (*string* $tableName, *string* $schemaName)

Gets creation options from a table



public :doc:`Phalcon\\Db\\RawValue <Phalcon_Db_RawValue>`  **getDefaultIdValue** ()

Return the default identity value to insert in an identity column



public *boolean*  **supportSequences** ()

Check whether the database system requires a sequence to produce auto-numeric values



<<<<<<< HEAD
public  **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager) inherited from Phalcon\\Db
=======
public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Sets the event manager



<<<<<<< HEAD
public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** () inherited from Phalcon\\Db
=======
public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** () inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Returns the internal event manager



<<<<<<< HEAD
public *array*  **fetchOne** (*string* $sqlQuery, *int* $fetchMode) inherited from Phalcon\\Db
=======
public *array*  **fetchOne** (*string* $sqlQuery, *int* $fetchMode, *array* $bindParams, *array* $bindTypes) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Returns the first row in a SQL query result 

.. code-block:: php

    <?php

    //Getting first robot
    $robot = $connection->fecthOne("SELECT * FROM robots");
    print_r($robot);
    
    //Getting first robot with associative indexes only
    $robot = $connection->fecthOne("SELECT * FROM robots", Phalcon\Db::FETCH_ASSOC);
    print_r($robot);




<<<<<<< HEAD
public *array*  **fetchAll** (*string* $sqlQuery, *int* $fetchMode) inherited from Phalcon\\Db
=======
public *array*  **fetchAll** (*string* $sqlQuery, *int* $fetchMode, *array* $bindParams, *array* $bindTypes) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

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




<<<<<<< HEAD
public *boolean*  **insert** (*string* $table, *array* $values, *array* $fields, *array* $dataTypes) inherited from Phalcon\\Db
=======
public *boolean*  **insert** (*string* $table, *array* $values, *array* $fields, *array* $dataTypes) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

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




<<<<<<< HEAD
public *boolean*  **update** (*string* $table, *array* $fields, *array* $values, *string* $whereCondition, *array* $dataTypes) inherited from Phalcon\\Db
=======
public *boolean*  **update** (*string* $table, *array* $fields, *array* $values, *string* $whereCondition, *array* $dataTypes) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

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




<<<<<<< HEAD
public *boolean*  **delete** (*string* $table, *string* $whereCondition, *array* $placeholders, *array* $dataTypes) inherited from Phalcon\\Db
=======
public *boolean*  **delete** (*string* $table, *string* $whereCondition, *array* $placeholders, *array* $dataTypes) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

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




<<<<<<< HEAD
public *string*  **getColumnList** (*array* $columnList) inherited from Phalcon\\Db
=======
public *string*  **getColumnList** (*array* $columnList) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Gets a list of columns



<<<<<<< HEAD
public *string*  **limit** (*string* $sqlQuery, *int* $number) inherited from Phalcon\\Db

Appends a LIMIT clause to $sqlQuery argument <code>$connection->limit("SELECT * FROM robots", 5);



public *string*  **tableExists** (*string* $tableName, *string* $schemaName) inherited from Phalcon\\Db

Generates SQL checking for the existence of a schema.table <code>$connection->tableExists("blog", "posts")



public *string*  **viewExists** (*string* $viewName, *string* $schemaName) inherited from Phalcon\\Db

Generates SQL checking for the existence of a schema.view <code>$connection->viewExists("active_users", "posts")



public *string*  **forUpdate** (*string* $sqlQuery) inherited from Phalcon\\Db
=======
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
>>>>>>> 0.7.0

Returns a SQL modified with a FOR UPDATE clause



<<<<<<< HEAD
public *string*  **sharedLock** (*string* $sqlQuery) inherited from Phalcon\\Db
=======
public *string*  **sharedLock** (*string* $sqlQuery) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Returns a SQL modified with a LOCK IN SHARE MODE clause



<<<<<<< HEAD
public *boolean*  **createTable** (*string* $tableName, *string* $schemaName, *array* $definition) inherited from Phalcon\\Db

Creates a table using MySQL SQL



public *boolean*  **dropTable** (*string* $tableName, *string* $schemaName, *boolean* $ifExists) inherited from Phalcon\\Db
=======
public *boolean*  **createTable** (*string* $tableName, *string* $schemaName, *array* $definition) inherited from Phalcon\\Db\\Adapter

Creates a table



public *boolean*  **dropTable** (*string* $tableName, *string* $schemaName, *boolean* $ifExists) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Drops a table from a schema/database



<<<<<<< HEAD
public *boolean*  **addColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Column <Phalcon_Db_Column>` $column) inherited from Phalcon\\Db
=======
public *boolean*  **addColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Adds a column to a table



<<<<<<< HEAD
public *boolean*  **modifyColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Column <Phalcon_Db_Column>` $column) inherited from Phalcon\\Db
=======
public *boolean*  **modifyColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Modifies a table column based on a definition



<<<<<<< HEAD
public *boolean*  **dropColumn** (*string* $tableName, *string* $schemaName, *string* $columnName) inherited from Phalcon\\Db
=======
public *boolean*  **dropColumn** (*string* $tableName, *string* $schemaName, *string* $columnName) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Drops a column from a table



<<<<<<< HEAD
public *boolean*  **addIndex** (*string* $tableName, *string* $schemaName, *DbIndex* $index) inherited from Phalcon\\Db
=======
public *boolean*  **addIndex** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Adds an index to a table



<<<<<<< HEAD
public *boolean*  **dropIndex** (*string* $tableName, *string* $schemaName, *string* $indexName) inherited from Phalcon\\Db
=======
public *boolean*  **dropIndex** (*string* $tableName, *string* $schemaName, *string* $indexName) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Drop an index from a table



<<<<<<< HEAD
public *boolean*  **addPrimaryKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>` $index) inherited from Phalcon\\Db
=======
public *boolean*  **addPrimaryKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Adds a primary key to a table



<<<<<<< HEAD
public *boolean*  **dropPrimaryKey** (*string* $tableName, *string* $schemaName) inherited from Phalcon\\Db
=======
public *boolean*  **dropPrimaryKey** (*string* $tableName, *string* $schemaName) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Drops primary key from a table



<<<<<<< HEAD
public *boolean true*  **addForeignKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Reference <Phalcon_Db_Reference>` $reference) inherited from Phalcon\\Db
=======
public *boolean true*  **addForeignKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ReferenceInterface <Phalcon_Db_ReferenceInterface>` $reference) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Adds a foreign key to a table



<<<<<<< HEAD
public *boolean true*  **dropForeignKey** (*string* $tableName, *string* $schemaName, *string* $referenceName) inherited from Phalcon\\Db
=======
public *boolean true*  **dropForeignKey** (*string* $tableName, *string* $schemaName, *string* $referenceName) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Drops a foreign key from a table



<<<<<<< HEAD
public *string*  **getColumnDefinition** (:doc:`Phalcon\\Db\\Column <Phalcon_Db_Column>` $column) inherited from Phalcon\\Db
=======
public *string*  **getColumnDefinition** (:doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Returns the SQL column definition from a column



<<<<<<< HEAD
public *array*  **listTables** (*string* $schemaName) inherited from Phalcon\\Db
=======
public *array*  **listTables** (*string* $schemaName) inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

List all tables on a database <code> print_r($connection->listTables("blog") ?>



<<<<<<< HEAD
public *string*  **getDescriptor** () inherited from Phalcon\\Db
=======
public *array*  **getDescriptor** () inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Return descriptor used to connect to the active database



<<<<<<< HEAD
public *string*  **getConnectionId** () inherited from Phalcon\\Db
=======
public *string*  **getConnectionId** () inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Gets the active connection unique identifier



<<<<<<< HEAD
public *string*  **getSQLStatement** () inherited from Phalcon\\Db
=======
public *string*  **getSQLStatement** () inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Active SQL statement in the object



<<<<<<< HEAD
public *string*  **getRealSQLStatement** () inherited from Phalcon\\Db
=======
public *string*  **getRealSQLStatement** () inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Active SQL statement in the object without replace bound paramters



<<<<<<< HEAD
public *array*  **getSQLVariables** () inherited from Phalcon\\Db
=======
public *array*  **getSQLVariables** () inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Active SQL statement in the object



<<<<<<< HEAD
public *array*  **getSQLBindTypes** () inherited from Phalcon\\Db
=======
public *array*  **getSQLBindTypes** () inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Active SQL statement in the object



<<<<<<< HEAD
public *string*  **getType** () inherited from Phalcon\\Db
=======
public *string*  **getType** () inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Returns type of database system the adapter is used for



<<<<<<< HEAD
public *string*  **getDialectType** () inherited from Phalcon\\Db
=======
public *string*  **getDialectType** () inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Returns the name of the dialect used



<<<<<<< HEAD
public :doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>`  **getDialect** () inherited from Phalcon\\Db
=======
public :doc:`Phalcon\\Db\\DialectInterface <Phalcon_Db_DialectInterface>`  **getDialect** () inherited from Phalcon\\Db\\Adapter
>>>>>>> 0.7.0

Returns internal dialect instance



