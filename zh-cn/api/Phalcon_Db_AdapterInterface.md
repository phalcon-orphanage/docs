* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Db\AdapterInterface'

* * *

# Interface **Phalcon\Db\AdapterInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/db/adapterinterface.zep" class="btn btn-default btn-sm">源码在GitHub</a>

## 方法

abstract public **fetchOne** (*mixed* $sqlQuery, [*mixed* $fetchMode], [*mixed* $placeholders])

...

abstract public **fetchAll** (*mixed* $sqlQuery, [*mixed* $fetchMode], [*mixed* $placeholders])

...

abstract public **insert** (*mixed* $table, *array* $values, [*mixed* $fields], [*mixed* $dataTypes])

...

abstract public **update** (*mixed* $table, *mixed* $fields, *mixed* $values, [*mixed* $whereCondition], [*mixed* $dataTypes])

...

abstract public **delete** (*mixed* $table, [*mixed* $whereCondition], [*mixed* $placeholders], [*mixed* $dataTypes])

...

abstract public **getColumnList** (*mixed* $columnList)

...

abstract public **limit** (*mixed* $sqlQuery, *mixed* $number)

...

abstract public **tableExists** (*mixed* $tableName, [*mixed* $schemaName])

...

abstract public **viewExists** (*mixed* $viewName, [*mixed* $schemaName])

...

abstract public **forUpdate** (*mixed* $sqlQuery)

...

abstract public **sharedLock** (*mixed* $sqlQuery)

...

abstract public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition)

...

abstract public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists])

...

abstract public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName])

...

abstract public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists])

...

abstract public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

...

abstract public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn])

...

abstract public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName)

...

abstract public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

...

abstract public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName)

...

abstract public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

...

abstract public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName)

...

abstract public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference)

...

abstract public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName)

...

abstract public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

...

abstract public **listTables** ([*mixed* $schemaName])

...

abstract public **listViews** ([*mixed* $schemaName])

...

abstract public **getDescriptor** ()

...

abstract public **getConnectionId** ()

...

abstract public **getSQLStatement** ()

...

abstract public **getRealSQLStatement** ()

...

abstract public **getSQLVariables** ()

...

abstract public **getSQLBindTypes** ()

...

abstract public **getType** ()

...

abstract public **getDialectType** ()

...

abstract public **getDialect** ()

...

abstract public **connect** ([*array* $descriptor])

...

abstract public **query** (*mixed* $sqlStatement, [*mixed* $placeholders], [*mixed* $dataTypes])

...

abstract public **execute** (*mixed* $sqlStatement, [*mixed* $placeholders], [*mixed* $dataTypes])

...

abstract public **affectedRows** ()

...

abstract public **close** ()

...

abstract public **escapeIdentifier** (*mixed* $identifier)

...

abstract public **escapeString** (*mixed* $str)

...

abstract public **lastInsertId** ([*mixed* $sequenceName])

...

abstract public **begin** ([*mixed* $nesting])

...

abstract public **rollback** ([*mixed* $nesting])

...

abstract public **commit** ([*mixed* $nesting])

...

abstract public **isUnderTransaction** ()

...

abstract public **getInternalHandler** ()

...

abstract public **describeIndexes** (*mixed* $table, [*mixed* $schema])

...

abstract public **describeReferences** (*mixed* $table, [*mixed* $schema])

...

abstract public **tableOptions** (*mixed* $tableName, [*mixed* $schemaName])

...

abstract public **useExplicitIdValue** ()

...

abstract public **getDefaultIdValue** ()

...

abstract public **supportSequences** ()

...

abstract public **createSavepoint** (*mixed* $name)

...

abstract public **releaseSavepoint** (*mixed* $name)

...

abstract public **rollbackSavepoint** (*mixed* $name)

...

abstract public **setNestedTransactionsWithSavepoints** (*mixed* $nestedTransactionsWithSavepoints)

...

abstract public **isNestedTransactionsWithSavepoints** ()

...

abstract public **getNestedTransactionSavepointName** ()

...

abstract public **describeColumns** (*mixed* $table, [*mixed* $schema])

...