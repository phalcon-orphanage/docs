Class **Phalcon\\Db\\Adapter\\Pdo**
===================================

*extends* :doc:`Phalcon\\Db <Phalcon_Db>`

Phalcon\\Db\\Adapter\\Pdo   Phalcon\\Db\\Adapter\\Pdo is the Phalcon\\Db that internally uses PDO to connect to a database  

.. code-block:: php

    <?php

    
    
     $connection = new Phalcon\Db\Adapter\Pdo\Mysql(array(
      'host' => '192.168.0.11',
      'username' => 'sigma',
      'password' => 'secret',
      'dbname' => 'blog',
      'port' => '3306',
     ));
    
     





Constants
---------

integer **FETCH_ASSOC**

integer **FETCH_BOTH**

integer **FETCH_NUM**

Methods
---------

**__construct** (*array* **$descriptor**)

*boolean* **connect** (*array* **$descriptor**)

:doc:`Phalcon\\Db\\Result\\Pdo <Phalcon_Db_Result_Pdo>` **query** (*string* **$sqlStatement**)

**execute** (*unknown* **$sqlStatement**, *unknown* **$placeholders**)

*int* **affectedRows** ()

*boolean* **close** ()

*string* **escapeString** (*string* **$str**)

**bindParams** (*string* **$sqlSelect**, *array* **$params**)

*int* **lastInsertId** (*string* **$table**, *string* **$primaryKey**, *string* **$sequenceName**)

*boolean* **begin** ()

*boolean* **rollback** ()

*boolean* **commit** ()

*boolean* **isUnderTransaction** ()

*PDO* **getInternalHandler** ()

**setEventsManager** (*unknown* **$eventsManager**)

**getEventsManager** ()

**fetchOne** (*unknown* **$sqlQuery**, *unknown* **$fetchMode**)

**fetchAll** (*unknown* **$sqlQuery**, *unknown* **$fetchMode**)

**insert** (*unknown* **$table**, *unknown* **$values**, *unknown* **$fields**)

**update** (*unknown* **$table**, *unknown* **$fields**, *unknown* **$values**, *unknown* **$whereCondition**)

**delete** (*unknown* **$table**, *unknown* **$whereCondition**, *unknown* **$placeholders**)

**getColumnList** (*unknown* **$columnList**)

**limit** (*unknown* **$sqlQuery**, *unknown* **$number**)

**tableExists** (*unknown* **$tableName**, *unknown* **$schemaName**)

**viewExists** (*unknown* **$viewName**, *unknown* **$schemaName**)

**forUpdate** (*unknown* **$sqlQuery**)

**sharedLock** (*unknown* **$sqlQuery**)

**createTable** (*unknown* **$tableName**, *unknown* **$schemaName**, *unknown* **$definition**)

**dropTable** (*unknown* **$tableName**, *unknown* **$schemaName**, *unknown* **$ifExists**)

**addColumn** (*unknown* **$tableName**, *unknown* **$schemaName**, *unknown* **$column**)

**modifyColumn** (*unknown* **$tableName**, *unknown* **$schemaName**, *unknown* **$column**)

**dropColumn** (*unknown* **$tableName**, *unknown* **$schemaName**, *unknown* **$columnName**)

**addIndex** (*unknown* **$tableName**, *unknown* **$schemaName**, *unknown* **$index**)

**dropIndex** (*unknown* **$tableName**, *unknown* **$schemaName**, *unknown* **$indexName**)

**addPrimaryKey** (*unknown* **$tableName**, *unknown* **$schemaName**, *unknown* **$index**)

**dropPrimaryKey** (*unknown* **$tableName**, *unknown* **$schemaName**)

**addForeignKey** (*unknown* **$tableName**, *unknown* **$schemaName**, *unknown* **$reference**)

**dropForeignKey** (*unknown* **$tableName**, *unknown* **$schemaName**, *unknown* **$referenceName**)

**getColumnDefinition** (*unknown* **$column**)

**listTables** (*unknown* **$schemaName**)

**getDescriptor** ()

**getConnectionId** ()

**getSQLStatement** ()

**getType** ()

**getDialectType** ()

**getDialect** ()

