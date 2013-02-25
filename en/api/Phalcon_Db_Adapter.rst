Class **Phalcon\\Db\\Adapter**
==============================

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

Base class for Phalcon\\Db adapters


Methods
---------

protected  **__construct** ()

Phalcon\\Db\\Adapter constructor



public  **setEventsManager** (*Phalcon\\Events\\ManagerInterface* $eventsManager)

Sets the event manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()

Returns the internal event manager



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
         array("name")
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



public *boolean*  **dropTable** (*string* $tableName, *string* $schemaName, [*boolean* $ifExists])

Drops a table from a schema/database



public *boolean*  **addColumn** (*string* $tableName, *string* $schemaName, *Phalcon\\Db\\ColumnInterface* $column)

Adds a column to a table



public *boolean*  **modifyColumn** (*string* $tableName, *string* $schemaName, *Phalcon\\Db\\ColumnInterface* $column)

Modifies a table column based on a definition



public *boolean*  **dropColumn** (*string* $tableName, *string* $schemaName, *string* $columnName)

Drops a column from a table



public *boolean*  **addIndex** (*string* $tableName, *string* $schemaName, *Phalcon\\Db\\IndexInterface* $index)

Adds an index to a table



public *boolean*  **dropIndex** (*string* $tableName, *string* $schemaName, *string* $indexName)

Drop an index from a table



public *boolean*  **addPrimaryKey** (*string* $tableName, *string* $schemaName, *Phalcon\\Db\\IndexInterface* $index)

Adds a primary key to a table



public *boolean*  **dropPrimaryKey** (*string* $tableName, *string* $schemaName)

Drops a table's primary key



public *boolean true*  **addForeignKey** (*string* $tableName, *string* $schemaName, *Phalcon\\Db\\ReferenceInterface* $reference)

Adds a foreign key to a table



public *boolean true*  **dropForeignKey** (*string* $tableName, *string* $schemaName, *string* $referenceName)

Drops a foreign key from a table



public *string*  **getColumnDefinition** (*Phalcon\\Db\\ColumnInterface* $column)

Returns the SQL column definition from a column



public *array*  **listTables** ([*string* $schemaName])

List all tables on a database 

.. code-block:: php

    <?php

     	print_r($connection->listTables("blog");




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



public :doc:`Phalcon\\Db\\DialectInterface <Phalcon_Db_DialectInterface>`  **getDialect** ()

Returns internal dialect instance



