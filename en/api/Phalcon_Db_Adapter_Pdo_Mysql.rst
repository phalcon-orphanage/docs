Class **Phalcon\\Db\\Adapter\\Pdo\\Mysql**
==========================================

*extends* :doc:`Phalcon\\Db\\Adapter\\Pdo <Phalcon_Db_Adapter_Pdo>`

Phalcon\\Db\\Adapter\\Pdo\\Mysql   Specific functions for the Mysql database system  

.. code-block:: php

    <?php

    
    
     $config = array(
      "host" => "192.168.0.11",
      "dbname" => "blog",
      "port" => 3306,
      "username" => "sigma",
      "password" => "secret"
     );
    
     $connection = new Phalcon\Db\Adapter\Pdo\Mysql($config);
    
     





Constants
---------

integer **FETCH_ASSOC**

integer **FETCH_BOTH**

integer **FETCH_NUM**

Methods
---------

:doc:`Phalcon\\Db\\Column[] <Phalcon_Db_Column[]>` **describeColumns** (*string* **$table**, *string* **$schema**)

:doc:`Phalcon\\Db\\Index[] <Phalcon_Db_Index[]>` **describeIndexes** (*string* **$table**, *string* **$schema**)

:doc:`Phalcon\\Db\\Reference[] <Phalcon_Db_Reference[]>` **describeReferences** (*string* **$table**, *string* **$schema**)

*array* **tableOptions** (*string* **$tableName**, *string* **$schemaName**)

**__construct** (*unknown* **$descriptor**)

**connect** (*unknown* **$descriptor**)

**query** (*unknown* **$sqlStatement**)

**execute** (*unknown* **$sqlStatement**, *unknown* **$placeholders**)

**affectedRows** ()

**close** ()

**escapeString** (*unknown* **$str**)

**bindParams** (*unknown* **$sqlSelect**, *unknown* **$params**)

**lastInsertId** (*unknown* **$table**, *unknown* **$primaryKey**, *unknown* **$sequenceName**)

**begin** ()

**rollback** ()

**commit** ()

**isUnderTransaction** ()

**getInternalHandler** ()

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

