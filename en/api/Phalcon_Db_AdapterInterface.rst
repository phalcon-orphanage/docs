Interface **Phalcon\\Db\\AdapterInterface**
===========================================

Phalcon\\Db\\AdapterInterface initializer


Methods
---------

abstract public  **__construct** ()

Constructor for Phalcon\\Db\\Adapter



abstract public *array*  **fetchOne** (*string* $sqlQuery, [*int* $fetchMode], [*unknown* $bindParams], [*unknown* $bindTypes])

Returns the first row in a SQL query result



abstract public *array*  **fetchAll** (*string* $sqlQuery, [*int* $fetchMode], [*unknown* $bindParams], [*unknown* $bindTypes])

Dumps the complete result of a query into an array



abstract public *boolean*  **insert** (*string* $table, *array* $values, [*array* $fields], [*array* $dataTypes])

Inserts data into a table using custom RBDM SQL syntax



abstract public *boolean*  **update** (*string* $table, *array* $fields, *array* $values, [*string* $whereCondition], [*array* $dataTypes])

Updates data on a table using custom RBDM SQL syntax



abstract public *boolean*  **delete** (*string* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes])

Deletes data from a table using custom RBDM SQL syntax



abstract public *string*  **getColumnList** (*array* $columnList)

Gets a list of columns



abstract public *string*  **limit** (*string* $sqlQuery, *int* $number)

Appends a LIMIT clause to $sqlQuery argument



abstract public *string*  **tableExists** (*string* $tableName, [*string* $schemaName])

Generates SQL checking for the existence of a schema.table



abstract public *string*  **viewExists** (*string* $viewName, [*string* $schemaName])

Generates SQL checking for the existence of a schema.view



abstract public *string*  **forUpdate** (*string* $sqlQuery)

Returns a SQL modified with a FOR UPDATE clause



abstract public *string*  **sharedLock** (*string* $sqlQuery)

Returns a SQL modified with a LOCK IN SHARE MODE clause



abstract public *boolean*  **createTable** (*string* $tableName, *string* $schemaName, *array* $definition)

Creates a table



abstract public *boolean*  **dropTable** (*string* $tableName, *string* $schemaName, [*boolean* $ifExists])

Drops a table from a schema/database



abstract public *boolean*  **addColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)

Adds a column to a table



abstract public *boolean*  **modifyColumn** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)

Modifies a table column based on a definition



abstract public *boolean*  **dropColumn** (*string* $tableName, *string* $schemaName, *string* $columnName)

Drops a column from a table



abstract public *boolean*  **addIndex** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index)

Adds an index to a table



abstract public *boolean*  **dropIndex** (*string* $tableName, *string* $schemaName, *string* $indexName)

Drop an index from a table



abstract public *boolean*  **addPrimaryKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` $index)

Adds a primary key to a table



abstract public *boolean*  **dropPrimaryKey** (*string* $tableName, *string* $schemaName)

Drops primary key from a table



abstract public *boolean true*  **addForeignKey** (*string* $tableName, *string* $schemaName, :doc:`Phalcon\\Db\\ReferenceInterface <Phalcon_Db_ReferenceInterface>` $reference)

Adds a foreign key to a table



abstract public *boolean true*  **dropForeignKey** (*string* $tableName, *string* $schemaName, *string* $referenceName)

Drops a foreign key from a table



abstract public *string*  **getColumnDefinition** (:doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` $column)

Returns the SQL column definition from a column



abstract public *array*  **listTables** ([*string* $schemaName])

List all tables on a database <code> print_r($connection->listTables("blog") ?>



abstract public *array*  **getDescriptor** ()

Return descriptor used to connect to the active database



abstract public *string*  **getConnectionId** ()

Gets the active connection unique identifier



abstract public *string*  **getSQLStatement** ()

Active SQL statement in the object



abstract public *string*  **getRealSQLStatement** ()

Active SQL statement in the object without replace bound paramters



abstract public *array*  **getSQLVariables** ()

Active SQL statement in the object



abstract public *array*  **getSQLBindTypes** ()

Active SQL statement in the object



abstract public *string*  **getType** ()

Returns type of database system the adapter is used for



abstract public *string*  **getDialectType** ()

Returns the name of the dialect used



abstract public :doc:`Phalcon\\Db\\DialectInterface <Phalcon_Db_DialectInterface>`  **getDialect** ()

Returns internal dialect instance



abstract public *boolean*  **connect** ([*array* $descriptor])

This method is automatically called in Phalcon\\Db\\Adapter\\Pdo constructor. Call it when you need to restore a database connection



abstract public :doc:`Phalcon\\Db\\ResultInterface <Phalcon_Db_ResultInterface>`  **query** (*string* $sqlStatement, [*array* $placeholders], [*array* $dataTypes])

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server return rows



abstract public *boolean*  **execute** (*string* $sqlStatement, [*array* $placeholders], [*array* $dataTypes])

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server don't return any row



abstract public *int*  **affectedRows** ()

Returns the number of affected rows by the last INSERT/UPDATE/DELETE reported by the database system



abstract public *boolean*  **close** ()

Closes active connection returning success. Phalcon automatically closes and destroys active connections within Phalcon\\Db\\Pool



abstract public *string*  **escapeIdentifier** (*string* $identifier)

Escapes a column/table/schema name



abstract public *string*  **escapeString** (*string* $str)

Escapes a value to avoid SQL injections



abstract public *array*  **convertBoundParams** (*string* $sqlStatement, *array* $params)

Converts bound params like :name: or ?1 into ? bind params



abstract public *int*  **lastInsertId** ([*string* $sequenceName])

Returns insert id for the auto_increment column inserted in the last SQL statement



abstract public *boolean*  **begin** ()

Starts a transaction in the connection



abstract public *boolean*  **rollback** ()

Rollbacks the active transaction in the connection



abstract public *boolean*  **commit** ()

Commits the active transaction in the connection



abstract public *boolean*  **isUnderTransaction** ()

Checks whether connection is under database transaction



abstract public *\PDO*  **getInternalHandler** ()

Return internal PDO handler



abstract public :doc:`Phalcon\\Db\\IndexInterface <Phalcon_Db_IndexInterface>` [] **describeIndexes** (*string* $table, [*string* $schema])

Lists table indexes



abstract public :doc:`Phalcon\\Db\\ReferenceInterface <Phalcon_Db_ReferenceInterface>` [] **describeReferences** (*string* $table, [*string* $schema])

Lists table references



abstract public *array*  **tableOptions** (*string* $tableName, [*string* $schemaName])

Gets creation options from a table



abstract public *boolean*  **useExplicitIdValue** ()

Check whether the database system requires an explicit value for identity columns



abstract public :doc:`Phalcon\\Db\\RawValue <Phalcon_Db_RawValue>`  **getDefaultIdValue** ()

Return the default identity value to insert in an identity column



abstract public *boolean*  **supportSequences** ()

Check whether the database system requires a sequence to produce auto-numeric values



abstract public :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>` [] **describeColumns** (*string* $table, [*string* $schema])

Returns an array of Phalcon\\Db\\Column objects describing a table



