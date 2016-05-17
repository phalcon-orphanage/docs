Interface **Phalcon\\Db\\DialectInterface**
===========================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/dialectinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **limit** (*unknown* $sqlQuery, *unknown* $number)

...


abstract public  **forUpdate** (*unknown* $sqlQuery)

...


abstract public  **sharedLock** (*unknown* $sqlQuery)

...


abstract public  **select** (*array* $definition)

...


abstract public  **getColumnList** (*array* $columnList)

...


abstract public  **getColumnDefinition** (:doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)

...


abstract public  **addColumn** (*unknown* $tableName, *unknown* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)

...


abstract public  **modifyColumn** (*unknown* $tableName, *unknown* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column, [:doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $currentColumn])

...


abstract public  **dropColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $columnName)

...


abstract public  **addIndex** (*unknown* $tableName, *unknown* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index)

...


abstract public  **dropIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $indexName)

...


abstract public  **addPrimaryKey** (*unknown* $tableName, *unknown* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index)

...


abstract public  **dropPrimaryKey** (*unknown* $tableName, *unknown* $schemaName)

...


abstract public  **addForeignKey** (*unknown* $tableName, *unknown* $schemaName, :doc:`Phalcon\\Db\\ReferenceInterface <Phalcon_Db_ReferenceInterface>` $reference)

...


abstract public  **dropForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $referenceName)

...


abstract public  **createTable** (*unknown* $tableName, *unknown* $schemaName, *array* $definition)

...


abstract public  **createView** (*unknown* $viewName, *array* $definition, [*unknown* $schemaName])

...


abstract public  **dropTable** (*unknown* $tableName, *unknown* $schemaName)

...


abstract public  **dropView** (*unknown* $viewName, [*unknown* $schemaName], [*unknown* $ifExists])

...


abstract public  **tableExists** (*unknown* $tableName, [*unknown* $schemaName])

...


abstract public  **viewExists** (*unknown* $viewName, [*unknown* $schemaName])

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


