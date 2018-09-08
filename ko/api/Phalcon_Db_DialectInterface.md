# Interface **Phalcon\\Db\\DialectInterface**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/dialectinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods

abstract public **limit** (*mixed* $sqlQuery, *mixed* $number)

...

abstract public **forUpdate** (*mixed* $sqlQuery)

...

abstract public **sharedLock** (*mixed* $sqlQuery)

...

abstract public **select** (*array* $definition)

...

abstract public **getColumnList** (*array* $columnList)

...

abstract public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](/en/3.2/api/Phalcon_Db_ColumnInterface) $column)

...

abstract public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](/en/3.2/api/Phalcon_Db_ColumnInterface) $column)

...

abstract public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](/en/3.2/api/Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](/en/3.2/api/Phalcon_Db_ColumnInterface) $currentColumn])

...

abstract public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName)

...

abstract public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](/en/3.2/api/Phalcon_Db_IndexInterface) $index)

...

abstract public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName)

...

abstract public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](/en/3.2/api/Phalcon_Db_IndexInterface) $index)

...

abstract public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName)

...

abstract public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](/en/3.2/api/Phalcon_Db_ReferenceInterface) $reference)

...

abstract public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName)

...

abstract public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition)

...

abstract public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName])

...

abstract public **dropTable** (*mixed* $tableName, *mixed* $schemaName)

...

abstract public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists])

...

abstract public **tableExists** (*mixed* $tableName, [*mixed* $schemaName])

...

abstract public **viewExists** (*mixed* $viewName, [*mixed* $schemaName])

...

abstract public **describeColumns** (*mixed* $table, [*mixed* $schema])

...

abstract public **listTables** ([*mixed* $schemaName])

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