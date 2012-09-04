Class **Phalcon\Db\Adapter\Pdo\Postgresql**
===========================================

*extends* :doc:`Phalcon\\Db\\Adapter\\Pdo <Phalcon_Db_Adapter_Pdo>`

Constants
---------

integer **FETCH_ASSOC**

integer **FETCH_BOTH**

integer **FETCH_NUM**

Methods
---------

public **connect** (*unknown* $descriptor)

public **describeColumns** (*unknown* $table, *unknown* $schema)

public **describeIndexes** (*unknown* $table, *unknown* $schema)

public **describeReferences** (*unknown* $table, *unknown* $schema)

public **tableOptions** (*unknown* $tableName, *unknown* $schemaName)

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

