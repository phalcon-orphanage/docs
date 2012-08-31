Class **Phalcon\\Db**
=====================

Phalcon\\Db   Phalcon\\Db and its related classes provide a simple SQL database interface for Phalcon Framework.  The Phalcon\\Db is the basic class you use to connect your PHP application to an RDBMS.  There is a different adapter class for each brand of RDBMS.   This component is intended to lower level database operations. If you want to interact with databases using  higher level of abstraction use Phalcon\\Mvc\\Model.   Phalcon\\Db is an abstract class. You only can use it with a database adapter like Phalcon\\Db\\Adapter\\Pdo   

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

integer **FETCH_ASSOC**

integer **FETCH_BOTH**

integer **FETCH_NUM**

Methods
---------

**__construct** ()

**setEventsManager** (*Phalcon\Events\Manager* **$eventsManager**)

:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` **getEventsManager** ()

*array* **fetchOne** (*string* **$sqlQuery**, *int* **$fetchMode**)

*array* **fetchAll** (*string* **$sqlQuery**, *int* **$fetchMode**)

*boolean* **insert** (*string* **$table**, *array* **$values**, *array* **$fields**)

*boolean* **update** (*string* **$table**, *array* **$fields**, *array* **$values**, *string* **$whereCondition**)

*boolean* **delete** (*string* **$table**, *string* **$whereCondition**, *array* **$placeholders**)

*string* **getColumnList** (*array* **$columnList**)

*string* **limit** (*string* **$sqlQuery**, *int* **$number**)

*string* **tableExists** (*string* **$tableName**, *string* **$schemaName**)

*string* **viewExists** (*string* **$viewName**, *string* **$schemaName**)

*string* **forUpdate** (*string* **$sqlQuery**)

*string* **sharedLock** (*string* **$sqlQuery**)

*boolean* **createTable** (*string* **$tableName**, *string* **$schemaName**, *array* **$definition**)

*boolean* **dropTable** (*string* **$tableName**, *string* **$schemaName**, *boolean* **$ifExists**)

*boolean* **addColumn** (*string* **$tableName**, *string* **$schemaName**, *Phalcon\Db\Column* **$column**)

*boolean* **modifyColumn** (*string* **$tableName**, *string* **$schemaName**, *Phalcon\Db\Column* **$column**)

*boolean* **dropColumn** (*string* **$tableName**, *string* **$schemaName**, *string* **$columnName**)

*boolean* **addIndex** (*string* **$tableName**, *string* **$schemaName**, *DbIndex* **$index**)

*boolean* **dropIndex** (*string* **$tableName**, *string* **$schemaName**, *string* **$indexName**)

*boolean* **addPrimaryKey** (*string* **$tableName**, *string* **$schemaName**, *Phalcon\Db\Index* **$index**)

*boolean* **dropPrimaryKey** (*string* **$tableName**, *string* **$schemaName**)

*boolean true* **addForeignKey** (*string* **$tableName**, *string* **$schemaName**, *Phalcon\Db\Reference* **$reference**)

*boolean true* **dropForeignKey** (*string* **$tableName**, *string* **$schemaName**, *string* **$referenceName**)

*string* **getColumnDefinition** (*Phalcon\Db\Column* **$column**)

*array* **listTables** (*string* **$schemaName**)

*string* **getDescriptor** ()

*string* **getConnectionId** ()

**getSQLStatement** ()

*string* **getType** ()

*string* **getDialectType** ()

:doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>` **getDialect** ()

