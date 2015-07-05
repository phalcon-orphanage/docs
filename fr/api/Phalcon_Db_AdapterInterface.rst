Interface **Phalcon\\Db\\AdapterInterface**
===========================================

Methods
-------

abstract public  **__construct** (*unknown* $descriptor)

...


abstract public  **fetchOne** (*unknown* $sqlQuery, [*unknown* $fetchMode], [*unknown* $placeholders])

...


abstract public  **fetchAll** (*unknown* $sqlQuery, [*unknown* $fetchMode], [*unknown* $placeholders])

...


abstract public  **insert** (*unknown* $table, *unknown* $values, [*unknown* $fields], [*unknown* $dataTypes])

...


abstract public  **update** (*unknown* $table, *unknown* $fields, *unknown* $values, [*unknown* $whereCondition], [*unknown* $dataTypes])

...


abstract public  **delete** (*unknown* $table, [*unknown* $whereCondition], [*unknown* $placeholders], [*unknown* $dataTypes])

...


abstract public  **getColumnList** (*unknown* $columnList)

...


abstract public  **limit** (*unknown* $sqlQuery, *unknown* $number)

...


abstract public  **tableExists** (*unknown* $tableName, [*unknown* $schemaName])

...


abstract public  **viewExists** (*unknown* $viewName, [*unknown* $schemaName])

...


abstract public  **forUpdate** (*unknown* $sqlQuery)

...


abstract public  **sharedLock** (*unknown* $sqlQuery)

...


abstract public  **createTable** (*unknown* $tableName, *unknown* $schemaName, *unknown* $definition)

...


abstract public  **dropTable** (*unknown* $tableName, [*unknown* $schemaName], [*unknown* $ifExists])

...


abstract public  **createView** (*unknown* $viewName, *unknown* $definition, [*unknown* $schemaName])

...


abstract public  **dropView** (*unknown* $viewName, [*unknown* $schemaName], [*unknown* $ifExists])

...


abstract public  **addColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column)

...


abstract public  **modifyColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column, [*unknown* $currentColumn])

...


abstract public  **dropColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $columnName)

...


abstract public  **addIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index)

...


abstract public  **dropIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $indexName)

...


abstract public  **addPrimaryKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index)

...


abstract public  **dropPrimaryKey** (*unknown* $tableName, *unknown* $schemaName)

...


abstract public  **addForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $reference)

...


abstract public  **dropForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $referenceName)

...


abstract public  **getColumnDefinition** (*unknown* $column)

...


abstract public  **listTables** ([*unknown* $schemaName])

...


abstract public  **listViews** ([*unknown* $schemaName])

...


abstract public  **getDescriptor** ()

...


abstract public  **getConnectionId** ()

...


abstract public  **getSQLStatement** ()

...


abstract public  **getRealSQLStatement** ()

...


abstract public  **getSQLVariables** ()

...


abstract public  **getSQLBindTypes** ()

...


abstract public  **getType** ()

...


abstract public  **getDialectType** ()

...


abstract public  **getDialect** ()

...


abstract public  **connect** ([*unknown* $descriptor])

...


abstract public  **query** (*unknown* $sqlStatement, [*unknown* $placeholders], [*unknown* $dataTypes])

...


abstract public  **execute** (*unknown* $sqlStatement, [*unknown* $placeholders], [*unknown* $dataTypes])

...


abstract public  **affectedRows** ()

...


abstract public  **close** ()

...


abstract public  **escapeIdentifier** (*unknown* $identifier)

...


abstract public  **escapeString** (*unknown* $str)

...


abstract public  **lastInsertId** ([*unknown* $sequenceName])

...


abstract public  **begin** ([*unknown* $nesting])

...


abstract public  **rollback** ([*unknown* $nesting])

...


abstract public  **commit** ([*unknown* $nesting])

...


abstract public  **isUnderTransaction** ()

...


abstract public  **getInternalHandler** ()

...


abstract public  **describeIndexes** (*unknown* $table, [*unknown* $schema])

...


abstract public  **describeReferences** (*unknown* $table, [*unknown* $schema])

...


abstract public  **tableOptions** (*unknown* $tableName, [*unknown* $schemaName])

...


abstract public  **useExplicitIdValue** ()

...


abstract public  **getDefaultIdValue** ()

...


abstract public  **supportSequences** ()

...


abstract public  **createSavepoint** (*unknown* $name)

...


abstract public  **releaseSavepoint** (*unknown* $name)

...


abstract public  **rollbackSavepoint** (*unknown* $name)

...


abstract public  **setNestedTransactionsWithSavepoints** (*unknown* $nestedTransactionsWithSavepoints)

...


abstract public  **isNestedTransactionsWithSavepoints** ()

...


abstract public  **getNestedTransactionSavepointName** ()

...


abstract public  **describeColumns** (*unknown* $table, [*unknown* $schema])

...


