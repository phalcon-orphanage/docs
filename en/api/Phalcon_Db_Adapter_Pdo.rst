Class **Phalcon\\Db\\Adapter\\Pdo**
===================================

*extends* :doc:`Phalcon\\Db <Phalcon_Db>`

Constants
---------

integer **FETCH_ASSOC**

integer **FETCH_BOTH**

integer **FETCH_NUM**

Methods
---------

public **__construct** (*array* $descriptor)

Constructor for Phalcon\\Db\\Adapter\\Pdo



*boolean* public **connect** (*array* $descriptor)

This method is automatically called in Phalcon\\Db\\Adapter\\Pdo constructor. Call it when you need to restore a database connection



:doc:`Phalcon\\Db\\Result\\Pdo <Phalcon_Db_Result_Pdo>` public **query** (*string* $sqlStatement)

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server return rows 

.. code-block:: php

    <?php

    //Querying data

$resultset = $connection->query("SELECT * FROM robots WHERE type='mechanical'"); $resultset = $connection->query("SELECT * FROM robots WHERE type=?", array("mechanical"));



public **execute** (*string* $sqlStatement, *array* $placeholders)

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server don't return any row 

.. code-block:: php

    <?php

    //Inserting data
    $success = $connection->execute("INSERT INTO robots VALUES (1, 'Astro Boy')");
    $success = $connection->execute("INSERT INTO robots VALUES (?, ?)", array(1, 'Astro Boy'));




*int* public **affectedRows** ()

Returns the number of affected rows by the last INSERT/UPDATE/DELETE repoted by the database system 

.. code-block:: php

    <?php

    $connection->query("DELETE FROM robots");
    echo $connection->affectedRows(), ' were deleted';




*boolean* public **close** ()

Closes active connection returning success. Phalcon automatically closes and destroys active connections within Phalcon\\Db\\Pool



*string* public **escapeString** (*string* $str)

Escapes a value to avoid SQL injections



public **bindParams** (*string* $sqlSelect, *array* $params)

Bind params to SQL select



*int* public **lastInsertId** (*string* $table, *string* $primaryKey, *string* $sequenceName)

Returns insert id for the auto_increment column inserted in the last SQL statement



*boolean* public **begin** ()

Starts a transaction in the connection



*boolean* public **rollback** ()

Rollbacks the active transaction in the connection



*boolean* public **commit** ()

Commits the active transaction in the connection



*boolean* public **isUnderTransaction** ()

Checks whether connection is under database transaction



*PDO* public **getInternalHandler** ()

Return internal PDO handler



public **setEventsManager** (*unknown* $eventsManager)

public **getEventsManager** ()

public **fetchOne** (*unknown* $sqlQuery, *unknown* $fetchMode)

public **fetchAll** (*unknown* $sqlQuery, *unknown* $fetchMode)

public **insert** (*unknown* $table, *unknown* $values, *unknown* $fields)

public **update** (*unknown* $table, *unknown* $fields, *unknown* $values, *unknown* $whereCondition)

public **delete** (*unknown* $table, *unknown* $whereCondition, *unknown* $placeholders)

public **getColumnList** (*unknown* $columnList)

public **limit** (*unknown* $sqlQuery, *unknown* $number)

public **tableExists** (*unknown* $tableName, *unknown* $schemaName)

public **viewExists** (*unknown* $viewName, *unknown* $schemaName)

public **forUpdate** (*unknown* $sqlQuery)

public **sharedLock** (*unknown* $sqlQuery)

public **createTable** (*unknown* $tableName, *unknown* $schemaName, *unknown* $definition)

public **dropTable** (*unknown* $tableName, *unknown* $schemaName, *unknown* $ifExists)

public **addColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column)

public **modifyColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $column)

public **dropColumn** (*unknown* $tableName, *unknown* $schemaName, *unknown* $columnName)

public **addIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index)

public **dropIndex** (*unknown* $tableName, *unknown* $schemaName, *unknown* $indexName)

public **addPrimaryKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $index)

public **dropPrimaryKey** (*unknown* $tableName, *unknown* $schemaName)

public **addForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $reference)

public **dropForeignKey** (*unknown* $tableName, *unknown* $schemaName, *unknown* $referenceName)

public **getColumnDefinition** (*unknown* $column)

public **listTables** (*unknown* $schemaName)

public **getDescriptor** ()

public **getConnectionId** ()

public **getSQLStatement** ()

public **getType** ()

public **getDialectType** ()

public **getDialect** ()

