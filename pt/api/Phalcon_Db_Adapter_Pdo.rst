Abstract class **Phalcon\\Db\\Adapter\\Pdo**
============================================

*extends* abstract class :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/adapter/pdo.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Phalcon\\Db\\Adapter\\Pdo is the Phalcon\\Db that internally uses PDO to connect to a database  

.. code-block:: php

    <?php

     use Phalcon\Db\Adapter\Pdo\Mysql;
    
     $config = [
       'host'     => 'localhost',
       'dbname'   => 'blog',
       'port'     => 3306,
       'username' => 'sigma',
       'password' => 'secret'
     ];
    
     $connection = new Mysql($config);



Methods
-------

public  **__construct** (*array* $descriptor)

Constructor for Phalcon\\Db\\Adapter\\Pdo



public  **connect** ([*array* $descriptor])

This method is automatically called in \\Phalcon\\Db\\Adapter\\Pdo constructor. Call it when you need to restore a database connection. 

.. code-block:: php

    <?php

     use Phalcon\Db\Adapter\Pdo\Mysql;
    
     // Make a connection
     $connection = new Mysql([
      'host'     => 'localhost',
      'username' => 'sigma',
      'password' => 'secret',
      'dbname'   => 'blog',
      'port'     => 3306,
     ]);
    
     // Reconnect
     $connection->connect();




public  **prepare** (*mixed* $sqlStatement)

Returns a PDO prepared statement to be executed with 'executePrepared' 

.. code-block:: php

    <?php

     use Phalcon\Db\Column;
    
     $statement = $db->prepare('SELECT * FROM robots WHERE name = :name');
     $result = $connection->executePrepared($statement, ['name' => 'Voltron'], ['name' => Column::BIND_PARAM_INT]);




public `PDOStatement <http://php.net/manual/en/class.pdostatement.php>`_ **executePrepared** (`PDOStatement <http://php.net/manual/en/class.pdostatement.php>`_ $statement, *array* $placeholders, *array* $dataTypes)

Executes a prepared statement binding. This function uses integer indexes starting from zero 

.. code-block:: php

    <?php

     use Phalcon\Db\Column;
    
     $statement = $db->prepare('SELECT * FROM robots WHERE name = :name');
     $result = $connection->executePrepared($statement, ['name' => 'Voltron'], ['name' => Column::BIND_PARAM_INT]);




public  **query** (*mixed* $sqlStatement, [*mixed* $bindParams], [*mixed* $bindTypes])

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server is returning rows 

.. code-block:: php

    <?php

    //Querying data
    $resultset = $connection->query("SELECT * FROM robots WHERE type='mechanical'");
    $resultset = $connection->query("SELECT * FROM robots WHERE type=?", array("mechanical"));




public  **execute** (*mixed* $sqlStatement, [*mixed* $bindParams], [*mixed* $bindTypes])

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server doesn't return any rows 

.. code-block:: php

    <?php

    //Inserting data
    $success = $connection->execute("INSERT INTO robots VALUES (1, 'Astro Boy')");
    $success = $connection->execute("INSERT INTO robots VALUES (?, ?)", array(1, 'Astro Boy'));




public  **affectedRows** ()

Returns the number of affected rows by the lastest INSERT/UPDATE/DELETE executed in the database system 

.. code-block:: php

    <?php

    $connection->execute("DELETE FROM robots");
    echo $connection->affectedRows(), ' were deleted';




public  **close** ()

Closes the active connection returning success. Phalcon automatically closes and destroys active connections when the request ends



public *string* **escapeIdentifier** (*string* $identifier)

Escapes a column/table/schema name 

.. code-block:: php

    <?php

    $escapedTable = $connection->escapeIdentifier('robots');
    $escapedTable = $connection->escapeIdentifier(['store', 'robots']);




public  **escapeString** (*mixed* $str)

Escapes a value to avoid SQL injections according to the active charset in the connection 

.. code-block:: php

    <?php

    $escapedStr = $connection->escapeString('some dangerous value');




public  **convertBoundParams** (*mixed* $sql, [*array* $params])

Converts bound parameters such as :name: or ?1 into PDO bind params ? 

.. code-block:: php

    <?php

     print_r($connection->convertBoundParams('SELECT * FROM robots WHERE name = :name:', array('Bender')));




public *int* | *boolean* **lastInsertId** ([*string* $sequenceName])

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




public  **begin** ([*mixed* $nesting])

Starts a transaction in the connection



public  **rollback** ([*mixed* $nesting])

Rollbacks the active transaction in the connection



public  **commit** ([*mixed* $nesting])

Commits the active transaction in the connection



public  **getTransactionLevel** ()

Returns the current transaction nesting level



public  **isUnderTransaction** ()

Checks whether the connection is under a transaction 

.. code-block:: php

    <?php

    $connection->begin();
    var_dump($connection->isUnderTransaction()); //true




public  **getInternalHandler** ()

Return internal PDO handler



public *array* **getErrorInfo** ()

Return the error info, if any



public  **getDialectType** () inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Name of the dialect used



public  **getType** () inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Type of database system the adapter is used for



public  **getSqlVariables** () inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Active SQL bound parameter variables



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Sets the event manager



public  **getEventsManager** () inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Returns the internal event manager



public  **setDialect** (:doc:`Phalcon\\Db\\DialectInterface <Phalcon_Db_DialectInterface>` $dialect) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Sets the dialect used to produce the SQL



public  **getDialect** () inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Returns internal dialect instance



public  **fetchOne** (*mixed* $sqlQuery, [*mixed* $fetchMode], [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Returns the first row in a SQL query result 

.. code-block:: php

    <?php

    //Getting first robot
    $robot = $connection->fetchOne("SELECT * FROM robots");
    print_r($robot);
    
    //Getting first robot with associative indexes only
    $robot = $connection->fetchOne("SELECT * FROM robots", Phalcon\Db::FETCH_ASSOC);
    print_r($robot);




public *array* **fetchAll** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

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




public *string* | ** **fetchColumn** (*string* $sqlQuery, [*array* $placeholders], [*int* | *string* $column]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Returns the n'th field of first row in a SQL query result 

.. code-block:: php

    <?php

    //Getting count of robots
    $robotsCount = $connection->fetchColumn("SELECT count(*) FROM robots");
    print_r($robotsCount);
    
    //Getting name of last edited robot
    $robot = $connection->fetchColumn("SELECT id, name FROM robots order by modified desc", 1);
    print_r($robot);




public *boolean* **insert** (*string* | *array* $table, *array* $values, [*array* $fields], [*array* $dataTypes]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Inserts data into a table using custom RDBMS SQL syntax 

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




public *boolean* **insertAsDict** (*string* $table, *array* $data, [*array* $dataTypes]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

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




public *boolean* **update** (*string* | *array* $table, *array* $fields, *array* $values, [*string* | *array* $whereCondition], [*array* $dataTypes]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

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



public *boolean* **updateAsDict** (*string* $table, *array* $data, [*string* $whereCondition], [*array* $dataTypes]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Updates data on a table using custom RBDM SQL syntax Another, more convenient syntax 

.. code-block:: php

    <?php

     //Updating existing robot
     $success = $connection->updateAsDict(
     "robots",
     array(
    	  "name" => "New Astro Boy"
      ),
     "id = 101"
     );
    
     //Next SQL sentence is sent to the database system
     UPDATE `robots` SET `name` = "Astro boy" WHERE id = 101




public *boolean* **delete** (*string* | *array* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

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




public *string* **getColumnList** (*array* $columnList) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Gets a list of columns



public  **limit** (*mixed* $sqlQuery, *mixed* $number) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Appends a LIMIT clause to $sqlQuery argument 

.. code-block:: php

    <?php

     	echo $connection->limit("SELECT * FROM robots", 5);




public  **tableExists** (*mixed* $tableName, [*mixed* $schemaName]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Generates SQL checking for the existence of a schema.table 

.. code-block:: php

    <?php

     	var_dump($connection->tableExists("blog", "posts"));




public  **viewExists** (*mixed* $viewName, [*mixed* $schemaName]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Generates SQL checking for the existence of a schema.view 

.. code-block:: php

    <?php

     var_dump($connection->viewExists("active_users", "posts"));




public  **forUpdate** (*mixed* $sqlQuery) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Returns a SQL modified with a FOR UPDATE clause



public  **sharedLock** (*mixed* $sqlQuery) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Returns a SQL modified with a LOCK IN SHARE MODE clause



public  **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Creates a table



public  **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Drops a table from a schema/database



public  **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Creates a view



public  **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Drops a view



public  **addColumn** (*mixed* $tableName, *mixed* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Adds a column to a table



public  **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column, [:doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $currentColumn]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Modifies a table column based on a definition



public  **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Drops a column from a table



public  **addIndex** (*mixed* $tableName, *mixed* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Adds an index to a table



public  **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Drop an index from a table



public  **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Adds a primary key to a table



public  **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Drops a table's primary key



public  **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, :doc:`Phalcon\\Db\\ReferenceInterface <Phalcon_Db_ReferenceInterface>` $reference) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Adds a foreign key to a table



public  **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Drops a foreign key from a table



public  **getColumnDefinition** (:doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Returns the SQL column definition from a column



public  **listTables** ([*mixed* $schemaName]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

List all tables on a database 

.. code-block:: php

    <?php

     	print_r($connection->listTables("blog"));




public  **listViews** ([*mixed* $schemaName]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

List all views on a database 

.. code-block:: php

    <?php

    print_r($connection->listViews("blog"));




public :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>`\ [] **describeIndexes** (*string* $table, [*string* $schema]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Lists table indexes 

.. code-block:: php

    <?php

    print_r($connection->describeIndexes('robots_parts'));




public  **describeReferences** (*mixed* $table, [*mixed* $schema]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Lists table references 

.. code-block:: php

    <?php

     print_r($connection->describeReferences('robots_parts'));




public  **tableOptions** (*mixed* $tableName, [*mixed* $schemaName]) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Gets creation options from a table 

.. code-block:: php

    <?php

     print_r($connection->tableOptions('robots'));




public  **createSavepoint** (*mixed* $name) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Creates a new savepoint



public  **releaseSavepoint** (*mixed* $name) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Releases given savepoint



public  **rollbackSavepoint** (*mixed* $name) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Rollbacks given savepoint



public  **setNestedTransactionsWithSavepoints** (*mixed* $nestedTransactionsWithSavepoints) inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Set if nested transactions should use savepoints



public  **isNestedTransactionsWithSavepoints** () inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Returns if nested transactions should use savepoints



public  **getNestedTransactionSavepointName** () inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Returns the savepoint name to use for nested transactions



public  **getDefaultIdValue** () inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Returns the default identity value to be inserted in an identity column 

.. code-block:: php

    <?php

     //Inserting a new robot with a valid default value for the column 'id'
     $success = $connection->insert(
     "robots",
     array($connection->getDefaultIdValue(), "Astro Boy", 1952),
     array("id", "name", "year")
     );




public  **getDefaultValue** () inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Returns the default value to make the RBDM use the default value declared in the table definition 

.. code-block:: php

    <?php

     //Inserting a new robot with a valid default value for the column 'year'
     $success = $connection->insert(
     "robots",
     array("Astro Boy", $connection->getDefaultValue()),
     array("name", "year")
     );




public  **supportSequences** () inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Check whether the database system requires a sequence to produce auto-numeric values



public  **useExplicitIdValue** () inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Check whether the database system requires an explicit value for identity columns



public  **getDescriptor** () inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Return descriptor used to connect to the active database



public *string* **getConnectionId** () inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Gets the active connection unique identifier



public  **getSQLStatement** () inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Active SQL statement in the object



public  **getRealSQLStatement** () inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Active SQL statement in the object without replace bound paramters



public *array* **getSQLBindTypes** () inherited from :doc:`Phalcon\\Db\\Adapter <Phalcon_Db_Adapter>`

Active SQL statement in the object



