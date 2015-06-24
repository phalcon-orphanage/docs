Abstract class **Phalcon\\Db\\Adapter**
=======================================

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

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



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()

Returns the internal event manager



public  **setDialect** (*unknown* $dialect)

Sets the dialect used to produce the SQL



public :doc:`Phalcon\\Db\\DialectInterface <Phalcon_Db_DialectInterface>`  **getDialect** ()

Returns internal dialect instance



public *array*  **fetchOne** (*unknown* $sqlQuery, [*unknown* $fetchMode], [*unknown* $bindParams], [*unknown* $bindTypes])

Returns the first row in a SQL query result 

.. code-block:: php

    <?php

    //Getting first robot
    $robot = $connection->fecthOne("SELECT * FROM robots");
    print_r($robot);
    
    //Getting first robot with associative indexes only
    $robot = $connection->fecthOne("SELECT * FROM robots", Phalcon\Db::FETCH_ASSOC);
    print_r($robot);




public *array*  **fetchAll** (*unknown* $sqlQuery, [*unknown* $fetchMode], [*unknown* $bindParams], [*unknown* $bindTypes])

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




public *string|*  **fetchColumn** (*unknown* $sqlQuery, [*unknown* $placeholders], [*unknown* $column])

Returns the n'th field of first row in a SQL query result 

.. code-block:: php

    <?php

        //Getting count of robots
        $robotsCount = $connection->fetchColumn("SELECT count(*) FROM robots");
        print_r($robotsCount);
    
        //Getting name of last edited robot
        $robot = $connection->fetchColumn("SELECT id, name FROM robots order by modified desc");
        print_r($robot);




public *boolean*  **insert** (*unknown* $table, *unknown* $values, [*unknown* $fields], [*unknown* $dataTypes])

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




public *boolean*  **insertAsDict** (*unknown* $table, *unknown* $data, [*unknown* $dataTypes])

Inserts data into a table using custom RBDM SQL syntax Another, more convenient syntax 

.. code-block:: php

    <?php

     //Inserting a new robot
     $success = $connection->insert(
         "robots",
         array(
              "name" => "Astro Boy",
              "year" => 1952
          )
     );
    
     //Next SQL sentence is sent to the database system
     INSERT INTO `robots` (`name`, `year`) VALUES ("Astro boy", 1952);




public *boolean*  **update** (*unknown* $table, *unknown* $fields, *unknown* $values, [*unknown* $whereCondition], [*unknown* $dataTypes])

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



public *boolean*  **updateAsDict** (*unknown* $table, *unknown* $data, [*unknown* $whereCondition], [*unknown* $dataTypes])

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




public *boolean*  **delete** (*unknown* $table, [*unknown* $whereCondition], [*unknown* $placeholders], [*unknown* $dataTypes])

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




public *string*  **getColumnList** (*unknown* $columnList)

Gets a list of columns



public *string*  **limit** (*unknown* $sqlQuery, *unknown* $number)

Appends a LIMIT clause to $sqlQuery argument 

.. code-block:: php

    <?php

     	echo $connection->limit("SELECT * FROM robots", 5);




public *boolean*  **tableExists** (*unknown* $tableName, [*unknown* $schemaName])

Generates SQL checking for the existence of a schema.table 

.. code-block:: php

    <?php

     	var_dump($connection->tableExists("blog", "posts"));




public *boolean*  **viewExists** (*unknown* $viewName, [*unknown* $schemaName])

Generates SQL checking for the existence of a schema.view 

.. code-block:: php

    <?php

     var_dump($connection->viewExists("active_users", "posts"));




public *string*  **forUpdate** (*unknown* $sqlQuery)

Returns a SQL modified with a FOR UPDATE clause



public *string*  **sharedLock** (*unknown* $sqlQuery)

Returns a SQL modified with a LOCK IN SHARE MODE clause



public *boolean*  **createTable** (*unknown* $tableName, *unknown* $schemaName, *unknown* $definition)

Creates a table



public *boolean*  **dropTable** (*unknown* $tableName, [*unknown* $schemaName], [*unknown* $ifExists])

Drops a table from a schema/database



public *boolean*  **createView** (*unknown* $viewName, *unknown* $definition, [*unknown* $schemaName])

Creates a view



public *boolean*  **dropView** (*unknown* $viewName, [*unknown* $schemaName], [*unknown* $ifExists])

Drops a view



public *boolean*  **addColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column)

Adds a column to a table



public *boolean*  **modifyColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column)

Modifies a table column based on a definition



public *boolean*  **dropColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $columnName)

Drops a column from a table



public *boolean*  **addIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index)

Adds an index to a table



public *boolean*  **dropIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $indexName)

Drop an index from a table



public *boolean*  **addPrimaryKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index)

Adds a primary key to a table



public *boolean*  **dropPrimaryKey** (*unknown* $tableName, *unknown* $schemaName)

Drops a table's primary key



public *boolean true*  **addForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $reference)

Adds a foreign key to a table



public *boolean true*  **dropForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $referenceName)

Drops a foreign key from a table



public *string*  **getColumnDefinition** (*unknown* $column)

Returns the SQL column definition from a column



public *array*  **listTables** ([*unknown* $schemaName])

List all tables on a database 

.. code-block:: php

    <?php

     	print_r($connection->listTables("blog"));




public *array*  **listViews** ([*unknown* $schemaName])

List all views on a database 

.. code-block:: php

    <?php

    print_r($connection->listViews("blog"));




public :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>` [] **describeIndexes** (*unknown* $table, [*unknown* $schema])

Lists table indexes 

.. code-block:: php

    <?php

    print_r($connection->describeIndexes('robots_parts'));




public :doc:`Phalcon\\Db\\Reference <Phalcon_Db_Reference>` [] **describeReferences** (*unknown* $table, [*unknown* $schema])

Lists table references 

.. code-block:: php

    <?php

     print_r($connection->describeReferences('robots_parts'));




public *array*  **tableOptions** (*unknown* $tableName, [*unknown* $schemaName])

Gets creation options from a table 

.. code-block:: php

    <?php

     print_r($connection->tableOptions('robots'));




public *boolean*  **createSavepoint** (*unknown* $name)

Creates a new savepoint



public *boolean*  **releaseSavepoint** (*unknown* $name)

Releases given savepoint



public *boolean*  **rollbackSavepoint** (*unknown* $name)

Rollbacks given savepoint



public :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>`  **setNestedTransactionsWithSavepoints** (*unknown* $nestedTransactionsWithSavepoints)

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



public *array*  **getSQLBindTypes** ()

Active SQL statement in the object



