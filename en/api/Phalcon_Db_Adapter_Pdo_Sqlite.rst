Class **Phalcon\\Db\\Adapter\\Pdo\\Sqlite**
===========================================

*extends* :doc:`Phalcon\\Db\\Adapter\\Pdo <Phalcon_Db_Adapter_Pdo>`

Specific functions for the Sqlite database system 

.. code-block:: php

    <?php

     $config = array(
      "dbname" => "/tmp/test.sqlite"
     );
    
     $connection = new Phalcon\Db\Adapter\Pdo\Sqlite($config);



Constants
---------

integer **FETCH_ASSOC**

integer **FETCH_BOTH**

integer **FETCH_NUM**

Methods
---------

*boolean* public **connect** (*array* $descriptor)

This method is automatically called in Phalcon\\Db\\Adapter\\Pdo constructor. Call it when you need to restore a database connection.



:doc:`Phalcon\\Db\\Column[] <Phalcon_Db_Column[]>` public **describeColumns** ()

Returns an array of Phalcon\\Db\\Column objects describing a table <code>print_r($connection->describeColumns("posts")); ?>



:doc:`Phalcon\\Db\\Index[] <Phalcon_Db_Index[]>` public **describeIndexes** ()

Lists table indexes



:doc:`Phalcon\\Db\\Reference[] <Phalcon_Db_Reference[]>` public **describeReferences** ()

Lists table references



public **__construct** (*unknown* $descriptor)

public **query** (*unknown* $sqlStatement)

public **execute** (*unknown* $sqlStatement, *unknown* $placeholders)

public **affectedRows** ()

public **close** ()

public **escapeString** (*unknown* $str)

public **bindParams** (*unknown* $sqlSelect, *unknown* $params)

public **lastInsertId** (*unknown* $table, *unknown* $primaryKey, *unknown* $sequenceName)

public **begin** ()

public **rollback** ()

public **commit** ()

public **isUnderTransaction** ()

public **getInternalHandler** ()

public **tableOptions** (*unknown* $tableName, *unknown* $schemaName)

public **setEventsManager** (*unknown* $eventsManager)

public **getEventsManager** ()

public **fetchOne** (*unknown* $sqlQuery, *unknown* $fetchMode)

public **fetchAll** (*unknown* $sqlQuery, *unknown* $fetchMode)

public **insert** (*unknown* $table, *unknown* $values, *unknown* $fields)

public **update** (*unknown* $table, *unknown* $fields, *unknown* $values, *unknown* $whereCondition)

public **delete** (*unknown* $table, *unknown* $whereCondition, *unknown* $placeholders)

public **getColumnList** (*unknown* $columnList)

public **limit** (*unknown* $sqlQuery, *unknown* $number)

public **tableExists** (*unknown* $tableName, *unknown* $schemaName)

public **viewExists** (*unknown* $viewName, *unknown* $schemaName)

public **forUpdate** (*unknown* $sqlQuery)

public **sharedLock** (*unknown* $sqlQuery)

public **createTable** (*unknown* $tableName, *unknown* $schemaName, *unknown* $definition)

public **dropTable** (*unknown* $tableName, *unknown* $schemaName, *unknown* $ifExists)

public **addColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column)

public **modifyColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column)

public **dropColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $columnName)

public **addIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index)

public **dropIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $indexName)

public **addPrimaryKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index)

public **dropPrimaryKey** (*unknown* $tableName, *unknown* $schemaName)

public **addForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $reference)

public **dropForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $referenceName)

public **getColumnDefinition** (*unknown* $column)

public **listTables** (*unknown* $schemaName)

public **getDescriptor** ()

public **getConnectionId** ()

public **getSQLStatement** ()

public **getType** ()

public **getDialectType** ()

public **getDialect** ()

