Class **Phalcon\Db\Dialect\Postgresql**
=======================================

*extends* :doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>`

Methods
---------

public static **getColumnList** (*unknown* $columnList)

public static **getColumnDefinition** (*unknown* $column)

public static **addColumn** ()

public static **modifyColumn** ()

public static **dropColumn** ()

public static **addIndex** ()

public static **dropIndex** ()

public static **addPrimaryKey** ()

public static **dropPrimaryKey** ()

public static **addForeignKey** ()

public static **dropForeignKey** ()

protected static **_getTableOptions** ()

public static **createTable** ()

public **dropTable** (*unknown* $tableName, *unknown* $schemaName, *unknown* $ifExists)

public static **tableExists** (*unknown* $tableName, *unknown* $schemaName)

public static **describeColumns** (*unknown* $table, *unknown* $schema)

public static **listTables** (*unknown* $schemaName)

public static **describeIndexes** (*unknown* $table, *unknown* $schema)

public static **describeReferences** (*unknown* $table, *unknown* $schema)

public static **tableOptions** (*unknown* $table, *unknown* $schema)

public **limit** (*unknown* $sqlQuery, *unknown* $number)

public **forUpdate** (*unknown* $sqlQuery)

public **sharedLock** (*unknown* $sqlQuery)

public **select** (*unknown* $definition)

