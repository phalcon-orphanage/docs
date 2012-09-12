Class **Phalcon\\Db**
=====================

Phalcon\\Db and its related classes provide a simple SQL database interface for Phalcon Framework. The Phalcon\\Db is the basic class you use to connect your PHP application to an RDBMS. There is a different adapter class for each brand of RDBMS. This component is intended to lower level database operations. If you want to interact with databases using higher level of abstraction use Phalcon\\Mvc\\Model. Phalcon\\Db is an abstract class. You only can use it with a database adapter like Phalcon\\Db\\Adapter\\Pdo 

.. code-block:: php

    <?php

    try {
    
      $connection = new Phalcon\Db\Adapter\Pdo\Mysql(array(
         'host' => '192.168.0.11',
         'username' => 'sigma',
         'password' => 'secret',
         'dbname' => 'blog',
         'port' => '3306',
      ));
    
      $result = $connection->query("SELECT * FROM robots LIMIT 5");
      $result->setFetchMode(Phalcon\Db::FETCH_NUM);
      while($robot = $result->fetchArray()){
        print_r($robot);
      }
    
    } catch(Phalcon\Db\Exception $e){
    echo $e->getMessage(), PHP_EOL;
    }



Constants
---------

*integer* **FETCH_ASSOC**

*integer* **FETCH_BOTH**

*integer* **FETCH_NUM**

Methods
---------

protected  **__construct** ()

Phalcon\\Db constructor



public  **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager)

Sets the event manager



public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** ()

Returns the internal event manager



public *array*  **fetchOne** (*string* $sqlQuery, *int* $fetchMode)

Returns the first row in a SQL query result 

.. code-block:: php

    <?php

    //Getting first robot
    $robot = $connection->fecthOne("SELECT * FROM robots");
    print_r($robot);
    
    //Getting first robot with associative indexes only
    $robot = $connection->fecthOne("SELECT * FROM robots", Phalcon\Db::FETCH_ASSOC);
    print_r($robot);




public *array*  **fetchAll** (*string* $sqlQuery, *int* $fetchMode)

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




public *boolean*  **insert** (*string* $table, *array* $values, *array* $fields)

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




public *boolean*  **update** (*string* $table, *array* $fields, *array* $values, *string* $whereCondition)

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




public *boolean*  **delete** (*string* $table, *string* $whereCondition, *array* $placeholders)

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

Appends a LIMIT clause to $sqlQuery argument <code>$connection->limit("SELECT * FROM robots", 5);



public *string*  **tableExists** (*string* $tableName, *string* $schemaName)

Generates SQL checking for the existence of a schema.table <code>$connection->tableExists("blog", "posts")



public *string*  **viewExists** (*string* $viewName, *string* $schemaName)

Generates SQL checking for the existence of a schema.view <code>$connection->viewExists("active_users", "posts")



public *string*  **forUpdate** (*string* $sqlQuery)

Returns a SQL modified with a FOR UPDATE clause



public *string*  **sharedLock** (*string* $sqlQuery)

Returns a SQL modified with a LOCK IN SHARE MODE clause



public *boolean*  **createTable** (*string* $tableName, *string* $schemaName, *array* $definition)

Creates a table using MySQL SQL



public *boolean*  **dropTable** (*string* $tableName, *string* $schemaName, *boolean* $ifExists)

Drops a table from a schema/database



public *boolean*  **addColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Column <Phalcon_Db_Column>` $column)

Adds a column to a table



public *boolean*  **modifyColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Column <Phalcon_Db_Column>` $column)

Modifies a table column based on a definition



public *boolean*  **dropColumn** (*string* $tableName, *string* $schemaName, *string* $columnName)

Drops a column from a table



public *boolean*  **addIndex** (*string* $tableName, *string* $schemaName, *DbIndex* $index)

Adds an index to a table



public *boolean*  **dropIndex** (*string* $tableName, *string* $schemaName, *string* $indexName)

Drop an index from a table



public *boolean*  **addPrimaryKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Index <Phalcon_Db_Index>` $index)

Adds a primary key to a table



public *boolean*  **dropPrimaryKey** (*string* $tableName, *string* $schemaName)

Drops primary key from a table



public *boolean true*  **addForeignKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\Reference <Phalcon_Db_Reference>` $reference)

Adds a foreign key to a table



public *boolean true*  **dropForeignKey** (*string* $tableName, *string* $schemaName, *string* $referenceName)

Drops a foreign key from a table



public *string*  **getColumnDefinition** (:doc:`Phalcon\\Db\\Column <Phalcon_Db_Column>` $column)

Returns the SQL column definition from a column



public *array*  **listTables** (*string* $schemaName)

List all tables on a database <code> print_r($connection->listTables("blog") ?>



public *string*  **getDescriptor** ()

Return descriptor used to connect to the active database



public *string*  **getConnectionId** ()

Gets the active connection unique identifier



public  **getSQLStatement** ()

Active SQL statement in the object



public *string*  **getType** ()

Returns type of database system the adapter is used for



public *string*  **getDialectType** ()

Returns the name of the dialect used



public :doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>`  **getDialect** ()

Returns internal dialect instance



