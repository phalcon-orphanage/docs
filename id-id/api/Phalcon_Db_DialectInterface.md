---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Db\DialectInterface'
---
# Interface **Phalcon\Db\DialectInterface**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/dialectinterface.zep)

## Metode

abstrak public **limit** (*mixed* $sqlQuery, *mixed* $number)

...

abstrak publik **forUpdate** (*campuran* $sqlQuery)

...

abstrak publik **sharedLock** (*campuran* $sqlQuery)

...

publik abstrak **pilih** (*array* $definition)

...

abstrak publik **getColumnList** (*array* $columnList)

...

abstract public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

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

abstrak publik **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition)

...

abstrak publik **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName])

...

abstrak publik **dropTable** (*campuran* $tableName *dicampur* $schemaName)

...

abstrak publik **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists])

...

abstrak publik **tableExists** (*mixed* $tableName, [*mixed* $schemaName])

...

abstrak publik **viewExists** (*mixed* $viewName, [*mixed* $schemaName])

...

abstract public **describeColumns** (*mixed* $table, [*mixed* $schema])

...

abstrak umum **listTables** ([*campuran* $schemaName])

...

abstract public **describeIndexes** (*mixed* $table, [*mixed* $schema])

...

abstract public **describeReferences** (*mixed* $table, [*mixed* $schema])

...

abstrak publik **tableOptions** (*mixed* $table, [*mixed* $schema])

...

publik abstrak **mendukungSavepoints** ()

...

publik abstrak **mendukungReleaseSavepoints** ()

...

abstract public **createSavepoint** (*mixed* $name)

...

abstract public **releaseSavepoint** (*mixed* $name)

...

abstract public **rollbackSavepoint** (*mixed* $name)

...