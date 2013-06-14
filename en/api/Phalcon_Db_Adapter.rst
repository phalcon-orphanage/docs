Class **Phalcon\\Db\\Adapter**
==============================

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

Base class for Phalcon\\Db adapters


Methods
---------

protected  **__construct** ()

Phalcon\\Db\\Adapter constructor



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets the event manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()

Returns the internal event manager



public  **setDialect** (*unknown* $dialect)

Sets the dialect used to produce the SQL



public :doc:`Phalcon\\Db\\DialectInterface <Phalcon_Db_DialectInterface>`  **getDialect** ()

Returns internal dialect instance



public *array*  **fetchOne** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes])

Returns the first row in a SQL query result 

.. code-block:: php

    <?php

    //Getting first robot
    $robot = $connection->fecthOne("SELECT * FROM robots");
    print_r($robot);
    
    //Getting first robot with associative indexes only
    $robot = $connection->fecthOne("SELECT * FROM robots", Phalcon\Db::FETCH_ASSOC);
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




public *boolean*  **insert** (*string* $table, *array* $values, [*array* $fields], [*array* $dataTypes])

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




public *boolean*  **update** (*string* $table, *array* $fields, *array* $values, [*string* $whereCondition], [*array* $dataTypes])

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




public *boolean*  **delete** (*string* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes])

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



public *string*  **limit** (*string* $sqlQuery, *int* $number)

Appends a LIMIT clause to $sqlQuery argument 

.. code-block:: php

    <?php

     	echo $connection->limit("SELECT * FROM robots", 5);




public *string*  **tableExists** (*string* $tableName, [*string* $schemaName])

Generates SQL checking for the existence of a schema.table 

.. code-block:: php

    <?php

     	var_dump($connection->tableExists("blog", "posts"));




public *string*  **viewExists** (*string* $viewName, [*string* $schemaName])

Generates SQL checking for the existence of a schema.view 

.. code-block:: php

    <?php

     var_dump($connection->viewExists("active_users", "posts"));




public *string*  **forUpdate** (*string* $sqlQuery)

Returns a SQL modified with a FOR UPDATE clause



public *string*  **sharedLock** (*string* $sqlQuery)

Returns a SQL modified with a LOCK IN SHARE MODE clause



public *boolean*  **createTable** (*string* $tableName, *string* $schemaName, *array* $definition)

Creates a table



public *boolean*  **dropTable** (*string* $tableName, [*string* $schemaName], [*boolean* $ifExists])

Drops a table from a schema/database



public *boolean*  **createView** (*unknown* $viewName, *array* $definition, [*string* $schemaName])

Creates a view



public *boolean*  **dropView** (*string* $viewName, [*string* $schemaName], [*boolean* $ifExists])

Drops a view



public *boolean*  **addColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)

Adds a column to a table



public *boolean*  **modifyColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)

Modifies a table column based on a definition



public *boolean*  **dropColumn** (*string* $tableName, *string* $schemaName, *string* $columnName)

Drops a column from a table



public *boolean*  **addIndex** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index)

Adds an index to a table



public *boolean*  **dropIndex** (*string* $tableName, *string* $schemaName, *string* $indexName)

Drop an index from a table



public *boolean*  **addPrimaryKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index)

Adds a primary key to a table



public *boolean*  **dropPrimaryKey** (*string* $tableName, *string* $schemaName)

Drops a table's primary key



public *boolean true*  **addForeignKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ReferenceInterface <Phalcon_Db_ReferenceInterface>` $reference)

Adds a foreign key to a table



public *boolean true*  **dropForeignKey** (*string* $tableName, *string* $schemaName, *string* $referenceName)

Drops a foreign key from a table



public *string*  **getColumnDefinition** (:doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)

Returns the SQL column definition from a column



public *array*  **listTables** ([*string* $schemaName])

List all tables on a database 

.. code-block:: php

    <?php

     	print_r($connection->listTables("blog"));




public *array*  **listViews** ([*string* $schemaName])

List all views on a database 

.. code-block:: php

    <?php

    print_r($connection->listViews("blog")); ?>




public :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>` [] **describeIndexes** (*string* $table, [*string* $schema])

Lists table indexes 

.. code-block:: php

    <?php

     print_r($connection->describeIndexes('robots_parts'));




public :doc:`Phalcon\\Db\\Reference <Phalcon_Db_Reference>` [] **describeReferences** (*string* $table, [*string* $schema])

Lists table references 

.. code-block:: php

    <?php

     print_r($connection->describeReferences('robots_parts'));




public *array*  **tableOptions** (*string* $tableName, [*string* $schemaName])

Gets creation options from a table 

.. code-block:: php

    <?php

     print_r($connection->tableOptions('robots'));




public *boolean*  **createSavepoint** (*string* $name)

Creates a new savepoint



public *boolean*  **releaseSavepoint** (*string* $name)

Releases given savepoint



public *boolean*  **rollbackSavepoint** (*string* $name)

Rollbacks given savepoint



public :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>`  **setNestedTransactionsWithSavepoints** (*boolean* $nestedTransactionsWithSavepoints)

Set if nested transactions should use savepoints



public *boolean*  **isNestedTransactionsWithSavepoints** ()

Returns if nested transactions should use savepoints



public *string*  **getNestedTransactionSavepointName** ()

Returns the savepoint name to use for nested transactions



public :doc:`Phalcon\\Db\\RawValue <Phalcon_Db_RawValue>`  **getDefaultIdValue** ()

Returns the default identity value to be inserted in an identity column 

.. code-block:: php

    <?php

     //Inserting a new robot with a valid default value for the column 'id'
     $success = $connection->insert(
         "robots",
         array($connection->getDefaultIdValue(), "Astro Boy", 1952),
         array("id", "name", "year")
     );




public *boolean*  **supportSequences** ()

Check whether the database system requires a sequence to produce auto-numeric values



public *boolean*  **useExplicitIdValue** ()

Check whether the database system requires an explicit value for identity columns



public *array*  **getDescriptor** ()

Return descriptor used to connect to the active database



public *string*  **getConnectionId** ()

Gets the active connection unique identifier



public *string*  **getSQLStatement** ()

Active SQL statement in the object



public *string*  **getRealSQLStatement** ()

Active SQL statement in the object without replace bound paramters



public *array*  **getSQLVariables** ()

Active SQL statement in the object



public *array*  **getSQLBindTypes** ()

Active SQL statement in the object



public *string*  **getType** ()

Returns type of database system the adapter is used for



public *string*  **getDialectType** ()

Returns the name of the dialect used



