Interface **Phalcon\\Db\\ReferenceInterface**
=============================================

Methods
---------

abstract public  **__construct** (*string* $referenceName, *array* $definition)

Phalcon\\Db\\ReferenceInterface constructor



abstract public *string*  **getName** ()

Gets the index name



abstract public *string*  **getSchemaName** ()

Gets the schema where referenced table is



abstract public *string*  **getReferencedSchema** ()

Gets the schema where referenced table is



abstract public *array*  **getColumns** ()

Gets local columns which reference is based



abstract public *string*  **getReferencedTable** ()

Gets the referenced table



abstract public *array*  **getReferencedColumns** ()

Gets referenced columns



abstract public static :doc:`Phalcon\\Db\\ReferenceInterface <Phalcon_Db_ReferenceInterface>`  **__set_state** (*array* $data)

Restore a Phalcon\\Db\\Reference object from export



