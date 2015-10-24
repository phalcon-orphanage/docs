Abstract class **Phalcon\\Db\\Adapter**
=======================================

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/adapter.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Base class for Phalcon\\Db adapters


Methods
-------

public  **getDialectType** ()

Name of the dialect used



public  **getType** ()

Type of database system the adapter is used for



public  **getSqlVariables** ()

Active SQL bound parameter variables



public  **__construct** (*unknown* $descriptor)

Phalcon\\Db\\Adapter constructor



public  **setEventsManager** (*unknown* $eventsManager)

Sets the event manager



public  **getEventsManager** ()

Returns the internal event manager



public  **setDialect** (*unknown* $dialect)

Sets the dialect used to produce the SQL



public  **getDialect** ()

Returns internal dialect instance



public *array*  **fetchOne** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes])

Returns the first row in a SQL query result 

.. code-block:: php

    <?php

    //Getting first robot
    $robot = $connection->fetchOne("SELECT * FROM robots");
    print_r($robot);
    
    //Getting first robot with associative indexes only
    $robot = $connection->fetchOne("SELECT * FROM robots", Phalcon\Db::FETCH_ASSOC);
    print_r($robot);




public *array*  **fetchAll** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes])

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




public *string|*  **fetchColumn** (*string* $sqlQuery, [*array* $placeholders], [*int|string* $column])

Returns the n'th field of first row in a SQL query result 

.. code-block:: php

    <?php

    //Getting count of robots
    $robotsCount = $connection->fetchColumn("SELECT count(*) FROM robots");
    print_r($robotsCount);
    
    //Getting name of last edited robot
    $robot = $connection->fetchColumn("SELECT id, name FROM robots order by modified desc", 1);
    print_r($robot);




public *boolean*  **insert** (*string|array* $table, *array* $values, [*array* $fields], [*array* $dataTypes])

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




public *boolean*  **insertAsDict** (*string* $table, *array* $data, [*array* $dataTypes])

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




public *boolean*  **update** (*string|array* $table, *array* $fields, *array* $values, [*string|array* $whereCondition], [*array* $dataTypes])

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



public *boolean*  **updateAsDict** (*string* $table, *array* $data, [*string* $whereCondition], [*array* $dataTypes])

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




public *boolean*  **delete** (*string|array* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes])

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




public *string*  **getColumnList** (*array* $columnList)

Gets a list of columns



public  **limit** (*unknown* $sqlQuery, *unknown* $number)

Appends a LIMIT clause to $sqlQuery argument 

.. code-block:: php

    <?php

     	echo $connection->limit("SELECT * FROM robots", 5);




public  **tableExists** (*unknown* $tableName, [*unknown* $schemaName])

Generates SQL checking for the existence of a schema.table 

.. code-block:: php

    <?php

     	var_dump($connection->tableExists("blog", "posts"));




public  **viewExists** (*unknown* $viewName, [*unknown* $schemaName])

Generates SQL checking for the existence of a schema.view 

.. code-block:: php

    <?php

     var_dump($connection->viewExists("active_users", "posts"));




public  **forUpdate** (*unknown* $sqlQuery)

Returns a SQL modified with a FOR UPDATE clause



public  **sharedLock** (*unknown* $sqlQuery)

Returns a SQL modified with a LOCK IN SHARE MODE clause



public  **createTable** (*unknown* $tableName, *unknown* $schemaName, *unknown* $definition)

Creates a table



public  **dropTable** (*unknown* $tableName, [*unknown* $schemaName], [*unknown* $ifExists])

Drops a table from a schema/database



public *boolean*  **createView** (*unknown* $viewName, *array* $definition, [*string* $schemaName])

Creates a view



public  **dropView** (*unknown* $viewName, [*unknown* $schemaName], [*unknown* $ifExists])

Drops a view



public  **addColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column)

Adds a column to a table



public  **modifyColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column, [*unknown* $currentColumn])

Modifies a table column based on a definition



public  **dropColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $columnName)

Drops a column from a table



public  **addIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index)

Adds an index to a table



public  **dropIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $indexName)

Drop an index from a table



public  **addPrimaryKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index)

Adds a primary key to a table



public  **dropPrimaryKey** (*unknown* $tableName, *unknown* $schemaName)

Drops a table's primary key



public  **addForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $reference)

Adds a foreign key to a table



public  **dropForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $referenceName)

Drops a foreign key from a table



public  **getColumnDefinition** (*unknown* $column)

Returns the SQL column definition from a column



public  **listTables** ([*unknown* $schemaName])

List all tables on a database 

.. code-block:: php

    <?php

     	print_r($connection->listTables("blog"));




public  **listViews** ([*unknown* $schemaName])

List all views on a database 

.. code-block:: php

    <?php

    print_r($connection->listViews("blog"));




public :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>` [] **describeIndexes** (*string* $table, [*string* $schema])

Lists table indexes 

.. code-block:: php

    <?php

    print_r($connection->describeIndexes('robots_parts'));




public  **describeReferences** (*unknown* $table, [*unknown* $schema])

Lists table references 

.. code-block:: php

    <?php

     print_r($connection->describeReferences('robots_parts'));




public  **tableOptions** (*unknown* $tableName, [*unknown* $schemaName])

Gets creation options from a table 

.. code-block:: php

    <?php

     print_r($connection->tableOptions('robots'));




public  **createSavepoint** (*unknown* $name)

Creates a new savepoint



public  **releaseSavepoint** (*unknown* $name)

Releases given savepoint



public  **rollbackSavepoint** (*unknown* $name)

Rollbacks given savepoint



public  **setNestedTransactionsWithSavepoints** (*unknown* $nestedTransactionsWithSavepoints)

Set if nested transactions should use savepoints



public  **isNestedTransactionsWithSavepoints** ()

Returns if nested transactions should use savepoints



public  **getNestedTransactionSavepointName** ()

Returns the savepoint name to use for nested transactions



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




public  **getDefaultValue** ()

Returns the default value to make the RBDM use the default value declared in the table definition 

.. code-block:: php

    <?php

     //Inserting a new robot with a valid default value for the column 'year'
     $success = $connection->insert(
     "robots",
     array("Astro Boy", $connection->getDefaultValue()),
     array("name", "year")
     );




public  **supportSequences** ()

Check whether the database system requires a sequence to produce auto-numeric values



public  **useExplicitIdValue** ()

Check whether the database system requires an explicit value for identity columns



public *array*  **getDescriptor** ()

Return descriptor used to connect to the active database



public *string*  **getConnectionId** ()

Gets the active connection unique identifier



public  **getSQLStatement** ()

Active SQL statement in the object



public  **getRealSQLStatement** ()

Active SQL statement in the object without replace bound paramters



public *array*  **getSQLBindTypes** ()

Active SQL statement in the object



