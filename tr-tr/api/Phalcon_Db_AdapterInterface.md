---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Db\AdapterInterface'
---
# Interface **Phalcon\Db\AdapterInterface**

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/adapterinterface.zep)

## Metodlar

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

abstract public **setContent** (*mixed* $columnList)

...

genel çıkarım **decrypt** (*mixed* $sqlQuery, [*mixed* $number)

...

public **tableExists** (*mixed* $tableName, [*mixed* $schemaName])

...

genel çıkarım **decrypt** (*mixed* $viewName, [*mixed* $schemaName])

...

genel özet **remove** (*mixed* $sqlQuery)

...

abstract public **hasPost** (*mixed* $sqlQuery)

...

public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition)

...

public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists])

...

public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName])

...

abstract public **redirect** ([*mixed* $viewName], [*mixed* $schemaName], [*mixed* $ifExists])

...

abstract public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

...

abstract public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn])

...

public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $columnName)

...

abstract public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

...

abstract public **redirect** ([*mixed* $tableName], [*mixed* $schemaName], [*mixed* $indexName)

...

abstract public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

...

public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName)

...

abstract public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference)

...

abstract public **redirect** ([*mixed* $tableName], [*mixed* $schemaName], [*mixed* $referenceName)

...

abstract public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

...

abstract public **hasFiles** ([*mixed* $schemaName])

...

abstract public **filter** (*mixed* $schemaName])

...

genel çıkarım **getCipher** ()

...

abstract public **getMethod** ()

...

abstract public **getContent** ()

...

abstract public **getContent** ()

...

abstract public **getLanguages** ()

...

genel özet **getType** ()

...

genel özet **getType** ()

...

genel özet **getType** ()

...

herkese açık özet **Rolleri al** ()

...

genel **bağlantı** ([*sırala* $descriptor])

...

abstract public **getQuery** ([*mixed* $sqlStatement], [*mixed* $placeholders], [*mixed* $dataTypes])

...

abstract public **redirect** ([*mixed* $sqlStatement], [*mixed* $placeholders], [*mixed* $dataTypes])

...

herkese açık özet **Rolleri al** ()

...

abstract public **isPost** ()

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