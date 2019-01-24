---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Db\AdapterInterface'
---
# Interface **Phalcon\Db\AdapterInterface**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/adapterinterface.zep)

## Metode

abstrak public **fetchOne** (*campuran* $sqlQuery, [*mixed* $fetchMode], [*campuran* $placeholders])

...

abstrak publik **fetchAll** (*campuran* $sqlQuery, [*mixed* $fetchMode], [*campuran* $placeholders])

...

abstrak publik **sisipkan** (*campuran* $table, *array* $values, [*mixed* $fields], [*mixed* $dataTypes])

...

abstrak publik **perbarui** (*campuran* $table, *campuran* $fields, *mixed* $values, [*mixed* $whereCondition], [*mixed* $dataTypes])

...

abstrak publik **hapus** (*mixed* $table, [*mixed* $whereCondition], [*mixed* $placeholders], [*mixed* $dataTypes])

...

publik abstrak **getColumnList** (*campuran* $columnList)

...

abstrak public **limit** (*mixed* $sqlQuery, *mixed* $number)

...

abstrak publik **tableExists** (*mixed* $tableName, [*mixed* $schemaName])

...

abstrak publik **viewExists** (*mixed* $viewName, [*mixed* $schemaName])

...

abstrak publik **forUpdate** (*campuran* $sqlQuery)

...

abstrak publik **sharedLock** (*campuran* $sqlQuery)

...

abstrak publik **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition)

...

abstrak publik **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists])

...

abstrak publik **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName])

...

abstrak publik **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists])

...

abstract public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

...

abstract public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn])

...

abstract public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName)

...

abstract public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

...

abstrak umum **dropIndex** (*campuran* $tableName, *campuran* $schemaName, *campuran* $indexName)

...

abstract public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

...

abstract public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName)

...

abstract public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference)

...

abstrak umum **dropForeignKey** (*campuran* $tableName, *campuran* $schemaName, *campuran* $referenceName)

...

abstract public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

...

abstrak umum **listTables** ([*campuran* $schemaName])

...

abstrak umum **listViews** ([*campuran* $schemaName])

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

abstrak umum **dekat** ()

...

abstrak umum **escapeIdentifier** (*campuran* $identifier)

...

abstract public **escapeString** (*mixed* $str)

...

abstrak umum **lastInsertId** ([*campuran* $sequenceName])

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