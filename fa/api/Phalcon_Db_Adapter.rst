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



public  **__construct** (*array* $descriptor)

Phalcon\\Db\\Adapter constructor



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets the event manager



public  **getEventsManager** ()

Returns the internal event manager



public  **setDialect** (:doc:`Phalcon\\Db\\DialectInterface <Phalcon_Db_DialectInterface>` $dialect)

Sets the dialect used to produce the SQL



public  **getDialect** ()

Returns internal dialect instance



public  **fetchOne** (*mixed* $sqlQuery, [*mixed* $fetchMode], [*mixed* $bindParams], [*mixed* $bindTypes])

Returns the first row in a SQL query result 

.. code-block:: php

    <?php

    //Getting first robot
    $robot = $connection->fetchOne("SELECT * FROM robots");
    print_r($robot);
    
    //Getting first robot with associative indexes only
    $robot = $connection->fetchOne("SELECT * FROM robots", Phalcon\Db::FETCH_ASSOC);
    print_r($robot);




public *array* **fetchAll** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes])

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




public *string* | ** **fetchColumn** (*string* $sqlQuery, [*array* $placeholders], [*int* | *string* $column])

Returns the n'th field of first row in a SQL query result 

.. code-block:: php

    <?php

    //Getting count of robots
    $robotsCount = $connection->fetchColumn("SELECT count(*) FROM robots");
    print_r($robotsCount);
    
    //Getting name of last edited robot
    $robot = $connection->fetchColumn("SELECT id, name FROM robots order by modified desc", 1);
    print_r($robot);




public *boolean* **insert** (*string* | *array* $table, *array* $values, [*array* $fields], [*array* $dataTypes])

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




public *boolean* **insertAsDict** (*string* $table, *array* $data, [*array* $dataTypes])

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




public *boolean* **update** (*string* | *array* $table, *array* $fields, *array* $values, [*string* | *array* $whereCondition], [*array* $dataTypes])

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



public *boolean* **updateAsDict** (*string* $table, *array* $data, [*string* $whereCondition], [*array* $dataTypes])

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




public *boolean* **delete** (*string* | *array* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes])

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




public *string* **getColumnList** (*array* $columnList)

Gets a list of columns



public  **limit** (*mixed* $sqlQuery, *mixed* $number)

Appends a LIMIT clause to $sqlQuery argument 

.. code-block:: php

    <?php

     	echo $connection->limit("SELECT * FROM robots", 5);




public  **tableExists** (*mixed* $tableName, [*mixed* $schemaName])

Generates SQL checking for the existence of a schema.table 

.. code-block:: php

    <?php

     	var_dump($connection->tableExists("blog", "posts"));




public  **viewExists** (*mixed* $viewName, [*mixed* $schemaName])

Generates SQL checking for the existence of a schema.view 

.. code-block:: php

    <?php

     var_dump($connection->viewExists("active_users", "posts"));




public  **forUpdate** (*mixed* $sqlQuery)

Returns a SQL modified with a FOR UPDATE clause



public  **sharedLock** (*mixed* $sqlQuery)

Returns a SQL modified with a LOCK IN SHARE MODE clause



public  **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition)

Creates a table



public  **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists])

Drops a table from a schema/database



public  **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName])

Creates a view



public  **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists])

Drops a view



public  **addColumn** (*mixed* $tableName, *mixed* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)

Adds a column to a table



public  **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column, [:doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $currentColumn])

Modifies a table column based on a definition



public  **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName)

Drops a column from a table



public  **addIndex** (*mixed* $tableName, *mixed* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index)

Adds an index to a table



public  **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName)

Drop an index from a table



public  **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index)

Adds a primary key to a table



public  **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName)

Drops a table's primary key



public  **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, :doc:`Phalcon\\Db\\ReferenceInterface <Phalcon_Db_ReferenceInterface>` $reference)

Adds a foreign key to a table



public  **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName)

Drops a foreign key from a table



public  **getColumnDefinition** (:doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)

Returns the SQL column definition from a column



public  **listTables** ([*mixed* $schemaName])

List all tables on a database 

.. code-block:: php

    <?php

     	print_r($connection->listTables("blog"));




public  **listViews** ([*mixed* $schemaName])

List all views on a database 

.. code-block:: php

    <?php

    print_r($connection->listViews("blog"));




public :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>`\ [] **describeIndexes** (*string* $table, [*string* $schema])

Lists table indexes 

.. code-block:: php

    <?php

    print_r($connection->describeIndexes('robots_parts'));




public  **describeReferences** (*mixed* $table, [*mixed* $schema])

Lists table references 

.. code-block:: php

    <?php

     print_r($connection->describeReferences('robots_parts'));




public  **tableOptions** (*mixed* $tableName, [*mixed* $schemaName])

Gets creation options from a table 

.. code-block:: php

    <?php

     print_r($connection->tableOptions('robots'));




public  **createSavepoint** (*mixed* $name)

Creates a new savepoint



public  **releaseSavepoint** (*mixed* $name)

Releases given savepoint



public  **rollbackSavepoint** (*mixed* $name)

Rollbacks given savepoint



public  **setNestedTransactionsWithSavepoints** (*mixed* $nestedTransactionsWithSavepoints)

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



public  **getDescriptor** ()

Return descriptor used to connect to the active database



public *string* **getConnectionId** ()

Gets the active connection unique identifier



public  **getSQLStatement** ()

Active SQL statement in the object



public  **getRealSQLStatement** ()

Active SQL statement in the object without replace bound paramters



public *array* **getSQLBindTypes** ()

Active SQL statement in the object



