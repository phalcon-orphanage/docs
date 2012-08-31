Class **Phalcon\\Db\\Dialect\\Mysql**
=====================================

*extends* :doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>`

Phalcon\\Db\\Dialect\\Mysql   Generates database specific SQL for the MySQL RBDM

Methods
---------

*string* **getColumnList** (*array* **$columnList**)

**getColumnDefinition** (*Phalcon\Db\Column* **$column**)

*string* **addColumn** (*string* **$tableName**, *string* **$schemaName**, *Phalcon\Db\Column* **$column**)

*string* **modifyColumn** (*string* **$tableName**, *string* **$schemaName**, *Phalcon\Db\Column* **$column**)

*string* **dropColumn** (*string* **$tableName**, *string* **$schemaName**, *string* **$columnName**)

*string* **addIndex** (*string* **$tableName**, *string* **$schemaName**, *Phalcon\Db\Index* **$index**)

*string* **dropIndex** (*string* **$tableName**, *string* **$schemaName**, *string* **$indexName**)

*string* **addPrimaryKey** (*string* **$tableName**, *string* **$schemaName**, *Phalcon\Db\Index* **$index**)

*string* **dropPrimaryKey** (*string* **$tableName**, *string* **$schemaName**)

*string* **addForeignKey** (*string* **$tableName**, *string* **$schemaName**, *Phalcon\Db\Reference* **$reference**)

*string* **dropForeignKey** (*string* **$tableName**, *string* **$schemaName**, *string* **$referenceName**)

*array* **_getTableOptions** ()

*string* **createTable** (*string* **$tableName**, *string* **$schemaName**, *array* **$definition**)

*boolean* **dropTable** (*string* **$tableName**, *string* **$schemaName**, *boolean* **$ifExists**)

*string* **tableExists** (*string* **$tableName**, *string* **$schemaName**)

*string* **describeColumns** (*string* **$table**, *string* **$schema**)

*array* **listTables** (*string* **$schemaName**)

*string* **describeIndexes** (*string* **$table**, *string* **$schema**)

*string* **describeReferences** (*string* **$table**, *string* **$schema**)

*string* **tableOptions** (*string* **$table**, *string* **$schema**)

**limit** (*unknown* **$sqlQuery**, *unknown* **$number**)

**forUpdate** (*unknown* **$sqlQuery**)

**sharedLock** (*unknown* **$sqlQuery**)

**select** (*unknown* **$definition**)

