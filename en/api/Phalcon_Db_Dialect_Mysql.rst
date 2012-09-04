Class **Phalcon\Db\Dialect\Mysql**
==================================

*extends* :doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>`

Methods
---------

public **getColumnList** (*unknown* $columnList)

public **getColumnDefinition** (*unknown* $column)

public **addColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column)

public **modifyColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column)

public **dropColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $columnName)

public **addIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index)

public **dropIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $indexName)

public **addPrimaryKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index)

public **dropPrimaryKey** (*unknown* $tableName, *unknown* $schemaName)

public **addForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $reference)

public **dropForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $referenceName)

protected **_getTableOptions** ()

public **createTable** (*unknown* $tableName, *unknown* $schemaName, *unknown* $definition)

public **dropTable** (*unknown* $tableName, *unknown* $schemaName, *unknown* $ifExists)

public **tableExists** (*unknown* $tableName, *unknown* $schemaName)

public **describeColumns** (*unknown* $table, *unknown* $schema)

public **listTables** (*unknown* $schemaName)

public **describeIndexes** (*unknown* $table, *unknown* $schema)

public **describeReferences** (*unknown* $table, *unknown* $schema)

public **tableOptions** (*unknown* $table, *unknown* $schema)

public **limit** (*unknown* $sqlQuery, *unknown* $number)

public **forUpdate** (*unknown* $sqlQuery)

public **sharedLock** (*unknown* $sqlQuery)

public **select** (*unknown* $definition)

