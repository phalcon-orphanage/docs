Class **Phalcon\\Db\\Dialect\\Postgresql**
==========================================

*extends* :doc:`Phalcon\\Db\\Dialect <Phalcon_Db_Dialect>`

Phalcon\\Db\\Dialect\\Postgresql   Generates database specific SQL for the PostgreSQL RBDM

Methods
---------

*string* **getColumnList** (*array* **$columnList**)

**getColumnDefinition** (*Phalcon\Db\Column* **$column**)

*string* **addColumn** ()

*string* **modifyColumn** ()

*string* **dropColumn** ()

*string* **addIndex** ()

*string* **dropIndex** ()

*string* **addPrimaryKey** ()

*string* **dropPrimaryKey** ()

*string* **addForeignKey** ()

*string* **dropForeignKey** ()

*array* **_getTableOptions** ()

*string* **createTable** ()

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

