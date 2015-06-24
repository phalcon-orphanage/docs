Interface **Phalcon\\Db\\DialectInterface**
===========================================

Methods
-------

abstract public  **limit** (*unknown* $sqlQuery, *unknown* $number)

...


abstract public  **forUpdate** (*unknown* $sqlQuery)

...


abstract public  **sharedLock** (*unknown* $sqlQuery)

...


abstract public  **select** (*unknown* $definition)

...


abstract public  **getColumnList** (*unknown* $columnList)

...


abstract public  **getColumnDefinition** (*unknown* $column)

...


abstract public  **addColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column)

...


abstract public  **modifyColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column)

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


abstract public  **createTable** (*unknown* $tableName, *unknown* $schemaName, *unknown* $definition)

...


abstract public  **dropTable** (*unknown* $tableName, *unknown* $schemaName)

...


abstract public  **tableExists** (*unknown* $tableName, [*unknown* $schemaName])

...


abstract public  **describeColumns** (*unknown* $table, [*unknown* $schema])

...


abstract public  **listTables** ([*unknown* $schemaName])

...


abstract public  **describeIndexes** (*unknown* $table, [*unknown* $schema])

...


abstract public  **describeReferences** (*unknown* $table, [*unknown* $schema])

...


abstract public  **tableOptions** (*unknown* $table, [*unknown* $schema])

...


abstract public  **supportsSavepoints** ()

...


abstract public  **supportsReleaseSavepoints** ()

...


abstract public  **createSavepoint** (*unknown* $name)

...


abstract public  **releaseSavepoint** (*unknown* $name)

...


abstract public  **rollbackSavepoint** (*unknown* $name)

...


