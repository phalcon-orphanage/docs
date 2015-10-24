Class **Phalcon\\Db\\Adapter\\Pdo\\Postgresql**
===============================================

*extends* abstract class :doc:`Phalcon\\Db\\Adapter\\Pdo <Phalcon_Db_Adapter_Pdo>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/adapter/pdo/postgresql.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Specific functions for the Postgresql database system 

.. code-block:: php

    <?php

     $config = array(
      "host" => "192.168.0.11",
      "dbname" => "blog",
      "username" => "postgres",
      "password" => ""
     );
    
     $connection = new \Phalcon\Db\Adapter\Pdo\Postgresql($config);



Methods
-------

public *boolean*  **connect** ([*array* $descriptor])

This method is automatically called in Phalcon\\Db\\Adapter\\Pdo constructor. Call it when you need to restore a database connection.



public  **describeColumns** (*unknown* $table, [*unknown* $schema])

Returns an array of Phalcon\\Db\\Column objects describing a table 

.. code-block:: php

    <?php

     print_r($connection->describeColumns("posts"));




public  **createTable** (*unknown* $tableName, *unknown* $schemaName, *unknown* $definition)

Creates a table



public  **modifyColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column, [*unknown* $currentColumn])

Modifies a table column based on a definition



public  **useExplicitIdValue** ()

Check whether the database system requires an explicit value for identity columns



public  **getDefaultIdValue** ()

Returns the default identity value to be inserted in an identity column 

.. code-block:: php

    <?php

     //Inserting a new robot with a valid default value for the column 'id'
     $success = $connection->insert(
         "robots",
         array($connection->getDefaultIdValue(), "Astro Boy", 1952),
         array("id", "name", "year")
     );




public  **supportSequences** ()

Check whether the database system requires a sequence to produce auto-numeric values



public  **__construct** (*unknown* $descriptor) inherited from Phalcon\\Db\\Adapter\\Pdo

Constructor for Phalcon\\Db\\Adapter\\Pdo



public  **prepare** (*unknown* $sqlStatement) inherited from Phalcon\\Db\\Adapter\\Pdo

Returns a PDO prepared statement to be executed with 'executePrepared' 

.. code-block:: php

    <?php

     $statement = $db->prepare('SELECT * FROM robots WHERE name = :name');
     $result = $connection->executePrepared($statement, array('name' => 'Voltron'));




public *\PDOStatement*  **executePrepared** (*\PDOStatement* $statement, *array* $placeholders, *array* $dataTypes) inherited from Phalcon\\Db\\Adapter\\Pdo

Executes a prepared statement binding. This function uses integer indexes starting from zero 

.. code-block:: php

    <?php

     $statement = $db->prepare('SELECT * FROM robots WHERE name = :name');
     $result = $connection->executePrepared($statement, array('name' => 'Voltron'));




public  **query** (*unknown* $sqlStatement, [*unknown* $bindParams], [*unknown* $bindTypes]) inherited from Phalcon\\Db\\Adapter\\Pdo

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server is returning rows 

.. code-block:: php

    <?php

    //Querying data
    $resultset = $connection->query("SELECT * FROM robots WHERE type='mechanical'");
    $resultset = $connection->query("SELECT * FROM robots WHERE type=?", array("mechanical"));




public  **execute** (*unknown* $sqlStatement, [*unknown* $bindParams], [*unknown* $bindTypes]) inherited from Phalcon\\Db\\Adapter\\Pdo

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server doesn't return any rows 

.. code-block:: php

    <?php

    //Inserting data
    $success = $connection->execute("INSERT INTO robots VALUES (1, 'Astro Boy')");
    $success = $connection->execute("INSERT INTO robots VALUES (?, ?)", array(1, 'Astro Boy'));




public  **affectedRows** () inherited from Phalcon\\Db\\Adapter\\Pdo

Returns the number of affected rows by the lastest INSERT/UPDATE/DELETE executed in the database system 

.. code-block:: php

    <?php

    $connection->execute("DELETE FROM robots");
    echo $connection->affectedRows(), ' were deleted';




public  **close** () inherited from Phalcon\\Db\\Adapter\\Pdo

Closes the active connection returning success. Phalcon automatically closes and destroys active connections when the request ends



public *string*  **escapeIdentifier** (*string* $identifier) inherited from Phalcon\\Db\\Adapter\\Pdo

Escapes a column/table/schema name 

.. code-block:: php

    <?php

    $escapedTable = $connection->escapeIdentifier('robots');
    $escapedTable = $connection->escapeIdentifier(array('store', 'robots'));




public  **escapeString** (*unknown* $str) inherited from Phalcon\\Db\\Adapter\\Pdo

Escapes a value to avoid SQL injections according to the active charset in the connection 

.. code-block:: php

    <?php

    $escapedStr = $connection->escapeString('some dangerous value');




public  **convertBoundParams** (*unknown* $sql, [*unknown* $params]) inherited from Phalcon\\Db\\Adapter\\Pdo

Converts bound parameters such as :name: or ?1 into PDO bind params ? 

.. code-block:: php

    <?php

     print_r($connection->convertBoundParams('SELECT * FROM robots WHERE name = :name:', array('Bender')));




public *int|boolean*  **lastInsertId** ([*string* $sequenceName]) inherited from Phalcon\\Db\\Adapter\\Pdo

Returns the insert id for the auto_increment/serial column inserted in the lastest executed SQL statement 

.. code-block:: php

    <?php

     //Inserting a new robot
     $success = $connection->insert(
         "robots",
         array("Astro Boy", 1952),
         array("name", "year")
     );
    
     //Getting the generated id
     $id = $connection->lastInsertId();




public  **begin** ([*unknown* $nesting]) inherited from Phalcon\\Db\\Adapter\\Pdo

Starts a transaction in the connection



public  **rollback** ([*unknown* $nesting]) inherited from Phalcon\\Db\\Adapter\\Pdo

Rollbacks the active transaction in the connection



public  **commit** ([*unknown* $nesting]) inherited from Phalcon\\Db\\Adapter\\Pdo

Commits the active transaction in the connection



public  **getTransactionLevel** () inherited from Phalcon\\Db\\Adapter\\Pdo

Returns the current transaction nesting level



public  **isUnderTransaction** () inherited from Phalcon\\Db\\Adapter\\Pdo

Checks whether the connection is under a transaction 

.. code-block:: php

    <?php

    $connection->begin();
    var_dump($connection->isUnderTransaction()); //true




public  **getInternalHandler** () inherited from Phalcon\\Db\\Adapter\\Pdo

Return internal PDO handler



public *array*  **getErrorInfo** () inherited from Phalcon\\Db\\Adapter\\Pdo

Return the error info, if any



public  **getDialectType** () inherited from Phalcon\\Db\\Adapter

Name of the dialect used



public  **getType** () inherited from Phalcon\\Db\\Adapter

Type of database system the adapter is used for



public  **getSqlVariables** () inherited from Phalcon\\Db\\Adapter

Active SQL bound parameter variables



public  **setEventsManager** (*unknown* $eventsManager) inherited from Phalcon\\Db\\Adapter

Sets the event manager



public  **getEventsManager** () inherited from Phalcon\\Db\\Adapter

Returns the internal event manager



public  **setDialect** (*unknown* $dialect) inherited from Phalcon\\Db\\Adapter

Sets the dialect used to produce the SQL



public  **getDialect** () inherited from Phalcon\\Db\\Adapter

Returns internal dialect instance



public *array*  **fetchOne** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes]) inherited from Phalcon\\Db\\Adapter

Returns the first row in a SQL query result 

.. code-block:: php

    <?php

    //Getting first robot
    $robot = $connection->fetchOne("SELECT * FROM robots");
    print_r($robot);
    
    //Getting first robot with associative indexes only
    $robot = $connection->fetchOne("SELECT * FROM robots", Phalcon\Db::FETCH_ASSOC);
    print_r($robot);




public *array*  **fetchAll** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes]) inherited from Phalcon\\Db\\Adapter

Dumps the complete result of a query into an array 

.. code-block:: php

    <?php

    //Getting all robots with associative indexes only
    $robots = $connection->fetchAll("SELECT * FROM robots", Phalcon\Db::FETCH_ASSOC);
    foreach ($robots as $robot) {
    	print_r($robot);
    }
    
      //Getting all robots that contains word "robot" withing the name
      $robots = $connection->fetchAll("SELECT * FROM robots WHERE name LIKE :name",
    	Phalcon\Db::FETCH_ASSOC,
    	array('name' => '%robot%')
      );
    foreach($robots as $robot){
    	print_r($robot);
    }




public *string|*  **fetchColumn** (*string* $sqlQuery, [*array* $placeholders], [*int|string* $column]) inherited from Phalcon\\Db\\Adapter

Returns the n'th field of first row in a SQL query result 

.. code-block:: php

    <?php

    //Getting count of robots
    $robotsCount = $connection->fetchColumn("SELECT count(*) FROM robots");
    print_r($robotsCount);
    
    //Getting name of last edited robot
    $robot = $connection->fetchColumn("SELECT id, name FROM robots order by modified desc", 1);
    print_r($robot);




public *boolean*  **insert** (*string|array* $table, *array* $values, [*array* $fields], [*array* $dataTypes]) inherited from Phalcon\\Db\\Adapter

Inserts data into a table using custom RBDM SQL syntax 

.. code-block:: php

    <?php

     // Inserting a new robot
     $success = $connection->insert(
     "robots",
     array("Astro Boy", 1952),
     array("name", "year")
     );
    
     // Next SQL sentence is sent to the database system
     INSERT INTO `robots` (`name`, `year`) VALUES ("Astro boy", 1952);




public *boolean*  **insertAsDict** (*string* $table, *array* $data, [*array* $dataTypes]) inherited from Phalcon\\Db\\Adapter

Inserts data into a table using custom RBDM SQL syntax 

.. code-block:: php

    <?php

     //Inserting a new robot
     $success = $connection->insertAsDict(
     "robots",
     array(
    	  "name" => "Astro Boy",
    	  "year" => 1952
      )
     );
    
     //Next SQL sentence is sent to the database system
     INSERT INTO `robots` (`name`, `year`) VALUES ("Astro boy", 1952);




public *boolean*  **update** (*string|array* $table, *array* $fields, *array* $values, [*string|array* $whereCondition], [*array* $dataTypes]) inherited from Phalcon\\Db\\Adapter

Updates data on a table using custom RBDM SQL syntax 

.. code-block:: php

    <?php

     //Updating existing robot
     $success = $connection->update(
     "robots",
     array("name"),
     array("New Astro Boy"),
     "id = 101"
     );
    
     //Next SQL sentence is sent to the database system
     UPDATE `robots` SET `name` = "Astro boy" WHERE id = 101
    
     //Updating existing robot with array condition and $dataTypes
     $success = $connection->update(
     "robots",
     array("name"),
     array("New Astro Boy"),
     array(
    	 'conditions' => "id = ?",
    	 'bind' => array($some_unsafe_id),
    	 'bindTypes' => array(PDO::PARAM_INT) //use only if you use $dataTypes param
     ),
     array(PDO::PARAM_STR)
     );

Warning! If $whereCondition is string it not escaped.



public *boolean*  **updateAsDict** (*string* $table, *array* $data, [*string* $whereCondition], [*array* $dataTypes]) inherited from Phalcon\\Db\\Adapter

Updates data on a table using custom RBDM SQL syntax Another, more convenient syntax 

.. code-block:: php

    <?php

     //Updating existing robot
     $success = $connection->update(
     "robots",
     array(
    	  "name" => "New Astro Boy"
      ),
     "id = 101"
     );
    
     //Next SQL sentence is sent to the database system
     UPDATE `robots` SET `name` = "Astro boy" WHERE id = 101




public *boolean*  **delete** (*string|array* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes]) inherited from Phalcon\\Db\\Adapter

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



public  **limit** (*unknown* $sqlQuery, *unknown* $number) inherited from Phalcon\\Db\\Adapter

Appends a LIMIT clause to $sqlQuery argument 

.. code-block:: php

    <?php

     	echo $connection->limit("SELECT * FROM robots", 5);




public  **tableExists** (*unknown* $tableName, [*unknown* $schemaName]) inherited from Phalcon\\Db\\Adapter

Generates SQL checking for the existence of a schema.table 

.. code-block:: php

    <?php

     	var_dump($connection->tableExists("blog", "posts"));




public  **viewExists** (*unknown* $viewName, [*unknown* $schemaName]) inherited from Phalcon\\Db\\Adapter

Generates SQL checking for the existence of a schema.view 

.. code-block:: php

    <?php

     var_dump($connection->viewExists("active_users", "posts"));




public  **forUpdate** (*unknown* $sqlQuery) inherited from Phalcon\\Db\\Adapter

Returns a SQL modified with a FOR UPDATE clause



public  **sharedLock** (*unknown* $sqlQuery) inherited from Phalcon\\Db\\Adapter

Returns a SQL modified with a LOCK IN SHARE MODE clause



public  **dropTable** (*unknown* $tableName, [*unknown* $schemaName], [*unknown* $ifExists]) inherited from Phalcon\\Db\\Adapter

Drops a table from a schema/database



public *boolean*  **createView** (*unknown* $viewName, *array* $definition, [*string* $schemaName]) inherited from Phalcon\\Db\\Adapter

Creates a view



public  **dropView** (*unknown* $viewName, [*unknown* $schemaName], [*unknown* $ifExists]) inherited from Phalcon\\Db\\Adapter

Drops a view



public  **addColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column) inherited from Phalcon\\Db\\Adapter

Adds a column to a table



public  **dropColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $columnName) inherited from Phalcon\\Db\\Adapter

Drops a column from a table



public  **addIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index) inherited from Phalcon\\Db\\Adapter

Adds an index to a table



public  **dropIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $indexName) inherited from Phalcon\\Db\\Adapter

Drop an index from a table



public  **addPrimaryKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index) inherited from Phalcon\\Db\\Adapter

Adds a primary key to a table



public  **dropPrimaryKey** (*unknown* $tableName, *unknown* $schemaName) inherited from Phalcon\\Db\\Adapter

Drops a table's primary key



public  **addForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $reference) inherited from Phalcon\\Db\\Adapter

Adds a foreign key to a table



public  **dropForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $referenceName) inherited from Phalcon\\Db\\Adapter

Drops a foreign key from a table



public  **getColumnDefinition** (*unknown* $column) inherited from Phalcon\\Db\\Adapter

Returns the SQL column definition from a column



public  **listTables** ([*unknown* $schemaName]) inherited from Phalcon\\Db\\Adapter

List all tables on a database 

.. code-block:: php

    <?php

     	print_r($connection->listTables("blog"));




public  **listViews** ([*unknown* $schemaName]) inherited from Phalcon\\Db\\Adapter

List all views on a database 

.. code-block:: php

    <?php

    print_r($connection->listViews("blog"));




public :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>` [] **describeIndexes** (*string* $table, [*string* $schema]) inherited from Phalcon\\Db\\Adapter

Lists table indexes 

.. code-block:: php

    <?php

    print_r($connection->describeIndexes('robots_parts'));




public  **describeReferences** (*unknown* $table, [*unknown* $schema]) inherited from Phalcon\\Db\\Adapter

Lists table references 

.. code-block:: php

    <?php

     print_r($connection->describeReferences('robots_parts'));




public  **tableOptions** (*unknown* $tableName, [*unknown* $schemaName]) inherited from Phalcon\\Db\\Adapter

Gets creation options from a table 

.. code-block:: php

    <?php

     print_r($connection->tableOptions('robots'));




public  **createSavepoint** (*unknown* $name) inherited from Phalcon\\Db\\Adapter

Creates a new savepoint



public  **releaseSavepoint** (*unknown* $name) inherited from Phalcon\\Db\\Adapter

Releases given savepoint



public  **rollbackSavepoint** (*unknown* $name) inherited from Phalcon\\Db\\Adapter

Rollbacks given savepoint



public  **setNestedTransactionsWithSavepoints** (*unknown* $nestedTransactionsWithSavepoints) inherited from Phalcon\\Db\\Adapter

Set if nested transactions should use savepoints



public  **isNestedTransactionsWithSavepoints** () inherited from Phalcon\\Db\\Adapter

Returns if nested transactions should use savepoints



public  **getNestedTransactionSavepointName** () inherited from Phalcon\\Db\\Adapter

Returns the savepoint name to use for nested transactions



public  **getDefaultValue** () inherited from Phalcon\\Db\\Adapter

Returns the default value to make the RBDM use the default value declared in the table definition 

.. code-block:: php

    <?php

     //Inserting a new robot with a valid default value for the column 'year'
     $success = $connection->insert(
     "robots",
     array("Astro Boy", $connection->getDefaultValue()),
     array("name", "year")
     );




public *array*  **getDescriptor** () inherited from Phalcon\\Db\\Adapter

Return descriptor used to connect to the active database



public *string*  **getConnectionId** () inherited from Phalcon\\Db\\Adapter

Gets the active connection unique identifier



public  **getSQLStatement** () inherited from Phalcon\\Db\\Adapter

Active SQL statement in the object



public  **getRealSQLStatement** () inherited from Phalcon\\Db\\Adapter

Active SQL statement in the object without replace bound paramters



public *array*  **getSQLBindTypes** () inherited from Phalcon\\Db\\Adapter

Active SQL statement in the object



