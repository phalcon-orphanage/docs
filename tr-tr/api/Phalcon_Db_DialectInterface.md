---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Db\DialectInterface'
---
# Interface **Phalcon\Db\DialectInterface**

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/dialectinterface.zep)

## Metodlar

genel çıkarım **decrypt** (*mixed* $sqlQuery, [*mixed* $number)

...

genel özet **remove** (*mixed* $sqlQuery)

...

abstract public **hasPost** (*mixed* $sqlQuery)

...

abstract public **select** (*array* $definition)

...

abstract public **getColumnList** (*array* $columnList)

...

abstract public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

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

public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition)

...

public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName])

...

abstract public **dropTable** (*mixed* $tableName, *mixed* $schemaName)

...

abstract public **redirect** ([*mixed* $viewName], [*mixed* $schemaName], [*mixed* $ifExists])

...

public **tableExists** (*mixed* $tableName, [*mixed* $schemaName])

...

genel çıkarım **decrypt** (*mixed* $viewName, [*mixed* $schemaName])

...

abstract public **describeColumns** (*mixed* $table, [*mixed* $schema])

...

abstract public **hasFiles** ([*mixed* $schemaName])

...

abstract public **describeIndexes** (*mixed* $table, [*mixed* $schema])

...

abstract public **describeReferences** (*mixed* $table, [*mixed* $schema])

...

abstract public **tableOptions** (*mixed* $table, [*mixed* $schema])

...

abstract public **supportsSavepoints** ()

...

abstract public **supportsReleaseSavepoints** ()

...

abstract public **createSavepoint** (*mixed* $name)

...

abstract public **releaseSavepoint** (*mixed* $name)

...

abstract public **rollbackSavepoint** (*mixed* $name)

...